<?php
/**
 *
 * mosparo phpBB Integration. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2026, mosparo Core Developers, https://mosparo.io
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace mosparo\phpbbintegration\event;

/**
 * @ignore
 */

use mosparo\phpbbintegration\includes\verification_helper;
use phpbb\auth\auth;
use phpbb\config\config;
use phpbb\event\data;
use phpbb\event\dispatcher;
use phpbb\language\language;
use phpbb\request\request;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * mosparo phpBB Integration Event listener.
 */
class main_listener implements EventSubscriberInterface
{
	/**
	 * Map phpBB core events to the listener methods that should handle those events
	 *
	 * @return array
	 */
	public static function getSubscribedEvents()
	{
		return [
			'core.ucp_register_modify_template_data'    => 'add_mosparo_params_to_template_vars',
			'core.ucp_register_data_after'              => 'verify_mosparo_register',

			'core.posting_modify_template_vars'         => 'add_mosparo_params_to_page_data',
			'core.posting_modify_submission_errors'     => 'verify_mosparo_posting',

			'core.user_setup'							=> 'load_language_on_setup',
			'core.permissions'							=> 'add_permissions',
		];
	}

	protected config $config;

	protected request $request;

	protected dispatcher $dispatcher;

	protected auth $auth;

	protected language $language;

	protected verification_helper $verification_helper;

	public function __construct(config $config, request $request, dispatcher $dispatcher, auth $auth, language $language, verification_helper $verification_helper)
	{
		$this->config = $config;
		$this->request = $request;
		$this->dispatcher = $dispatcher;
		$this->auth = $auth;
		$this->language = $language;
		$this->verification_helper = $verification_helper;
	}

	public function add_mosparo_params_to_template_vars(data $event)
	{
		$template_vars = $event['template_vars'];
		if ($this->config['mosparo_phpbbintegration_protect_registration'])
		{
			$template_vars['MOSPARO_ACTIVE'] = true;
			$template_vars['MOSPARO_HOST'] = $this->config['mosparo_phpbbintegration_host'];
			$template_vars['MOSPARO_UUID'] = $this->config['mosparo_phpbbintegration_uuid'];
			$template_vars['MOSPARO_PUBLIC_KEY'] = $this->config['mosparo_phpbbintegration_public_key'];
		}
		else
		{
			$template_vars['MOSPARO_ACTIVE'] = false;
		}
		$event['template_vars'] = $template_vars;
	}

	public function verify_mosparo_register(data $event)
	{
		if (!$this->config['mosparo_phpbbintegration_protect_registration'])
		{
			return;
		}

		$error = $event['error'];

		$submit_token = $this->request->untrimmed_variable('_mosparo_submitToken', '');
		$validation_token = $this->request->untrimmed_variable('_mosparo_validationToken', '');
		if (!$submit_token || !$validation_token)
		{
			$error[] = $this->language->lang('MOSPARO_PHPBBINTEGRATION_TOKENS_MISSING');
			$event['error'] = $error;
			return;
		}

		$ignored_keys = ['new_password', 'password_confirm'];
		$not_required_keys = ['lang'];
		$form_data = [];
		$required_fields = [];
		$verifiable_fields = [];
		foreach (array_merge(array_keys($event['data']), array_keys($event['cp_data'])) as $key)
		{
			if (in_array($key, $ignored_keys))
			{
				continue;
			}

			$form_data[$key] = $this->request->untrimmed_variable($key, '');

			if (!in_array($key, $not_required_keys))
			{
				$required_fields[] = $key;
				$verifiable_fields[] = $key;
			}
		}

		$form_data_event = new form_data(
			$form_data,
			$required_fields,
			$verifiable_fields,
		);
		/**
		 * Modify the form data before sending them to mosparo
		 *
		 * @event mosparo.phpbbintegration.form_data_registration
		 * @var \mosparo\phpbbintegration\event\form_data $form_data_event
		 * @since 1.0.0
		 */
		$this->dispatcher->dispatch('mosparo.phpbbintegration.form_data_registration', $form_data_event);

		$result = $this->verification_helper->verify_submission($submit_token, $validation_token, $form_data_event->get_form_data());
		if ($result === null || !$result->isSubmittable() || !$result->isValid())
		{
			$error[] = $this->language->lang('MOSPARO_PHPBBINTEGRATION_SUBMISSION_INVALID');
			$event['error'] = $error;
			return;
		}

		// Confirm that all required fields were verified
		$verified_fields = array_keys($result->getVerifiedFields());
		$field_difference = array_diff($form_data_event->get_required_fields(), $verified_fields);
		$verifiable_field_difference = array_diff($form_data_event->get_verifiable_fields(), $verified_fields);
		if (!empty($field_difference) || !empty($verifiable_field_difference))
		{
			$error[] = $this->language->lang('MOSPARO_PHPBBINTEGRATION_SUBMISSION_INVALID');
			$event['error'] = $error;
		}
	}

	public function add_mosparo_params_to_page_data(data $event)
	{
		$page_data = $event['page_data'];

		if (!$this->config['mosparo_phpbbintegration_protect_posting'] || $this->auth->acl_get('f_posting_bypass_mosparo', $event['forum_id']))
		{
			$page_data['MOSPARO_ACTIVE'] = false;
		}
		else
		{
			$page_data['MOSPARO_ACTIVE'] = true;
			$page_data['MOSPARO_HOST'] = $this->config['mosparo_phpbbintegration_host'];
			$page_data['MOSPARO_UUID'] = $this->config['mosparo_phpbbintegration_uuid'];
			$page_data['MOSPARO_PUBLIC_KEY'] = $this->config['mosparo_phpbbintegration_public_key'];
		}

		$event['page_data'] = $page_data;
	}

	public function verify_mosparo_posting(data $event)
	{
		$error = $event['error'];

		if (!$event['submit'])
		{
			return;
		}

		if (!$this->config['mosparo_phpbbintegration_protect_posting'])
		{
			return;
		}

		if ($this->auth->acl_get('f_posting_bypass_mosparo', $event['forum_id']))
		{
			return;
		}

		$submit_token = $this->request->untrimmed_variable('_mosparo_submitToken', '');
		$validation_token = $this->request->untrimmed_variable('_mosparo_validationToken', '');
		if (!$submit_token || !$validation_token)
		{
			$error[] = $this->language->lang('MOSPARO_PHPBBINTEGRATION_TOKENS_MISSING');
			$event['error'] = $error;
			return;
		}

		$form_data = [
			'subject' => $this->request->untrimmed_variable('subject', ''),
			'message' => $this->request->untrimmed_variable('message', ''),
		];
		$required_fields = [
			'subject',
			'message',
		];
		$verifiable_fields = [
			'subject',
			'message',
		];

		if ($event['post_data']['poster_id'] == ANONYMOUS)
		{
			$form_data['username'] = $this->request->untrimmed_variable('username', '');
			$required_fields[] = 'username';
			$verified_fields[] = 'username';
		}

		if ($event['mode'] === 'edit')
		{
			$form_data['edit_reason'] = $this->request->untrimmed_variable('edit_reason', '');
			$verified_fields[] = 'edit_reason';
		}

		$form_data_event = new form_data(
			$form_data,
			$required_fields,
			$verifiable_fields,
		);
		/**
		 * Modify the form data before sending them to mosparo
		 *
		 * @event mosparo.phpbbintegration.form_data_posting
		 * @var \mosparo\phpbbintegration\event\form_data $form_data_event
		 * @since 1.0.0
		 */
		$this->dispatcher->dispatch('mosparo.phpbbintegration.form_data_posting', $form_data_event);

		$result = $this->verification_helper->verify_submission($submit_token, $validation_token, $form_data_event->get_form_data());
		if ($result === null || !$result->isSubmittable() || !$result->isValid())
		{
			$error[] = $this->language->lang('MOSPARO_PHPBBINTEGRATION_SUBMISSION_INVALID');
			$event['error'] = $error;
			return;
		}

		// Confirm that all required fields were verified
		$verified_fields = array_keys($result->getVerifiedFields());
		$field_difference = array_diff($form_data_event->get_required_fields(), $verified_fields);
		$verifiable_field_difference = array_diff($form_data_event->get_verifiable_fields(), $verified_fields);
		if (!empty($field_difference) || !empty($verifiable_field_difference))
		{
			$error[] = $this->language->lang('MOSPARO_PHPBBINTEGRATION_SUBMISSION_INVALID');
			$event['error'] = $error;
		}
	}

	public function load_language_on_setup(data $event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = [
			'ext_name' => 'mosparo/phpbbintegration',
			'lang_set' => 'common',
		];
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function add_permissions(data $event)
	{
		$permissions = $event['permissions'];
		$permissions['f_posting_bypass_mosparo'] = ['lang' => 'ACL_F_POSTING_BYPASS_MOSPARO', 'cat' => 'post'];
		$event['permissions'] = $permissions;
	}
}
