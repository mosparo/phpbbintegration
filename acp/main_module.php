<?php
/**
 *
 * mosparo phpBB Integration. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2026, mosparo Core Developers, https://mosparo.io
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace mosparo\phpbbintegration\acp;

/**
 * mosparo phpBB Integration ACP module.
 */
class main_module
{
	public $page_title;
	public $tpl_name;
	public $u_action;

	/**
	 * Main ACP module
	 *
	 * @param int    $id   The module ID
	 * @param string $mode The module mode (for example: manage or settings)
	 * @throws \Exception
	 */
	public function main($id, $mode)
	{
		global $language, $template, $request, $config;

		$this->tpl_name = 'acp_mosparo_phpbbintegration_body';
		$this->page_title = 'ACP_MOSPARO_PHPBBINTEGRATION_TITLE';

		add_form_key('mosparo_phpbbintegration_settings');

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key('mosparo_phpbbintegration_settings'))
			{
				trigger_error('FORM_INVALID');
			}

			$config->set('mosparo_phpbbintegration_host', $request->variable('mosparo_phpbbintegration_host', ''));
			$config->set('mosparo_phpbbintegration_uuid', $request->variable('mosparo_phpbbintegration_uuid', ''));
			$config->set('mosparo_phpbbintegration_public_key', $request->variable('mosparo_phpbbintegration_public_key', ''));
			$config->set('mosparo_phpbbintegration_private_key', $request->variable('mosparo_phpbbintegration_private_key', ''));
			$config->set('mosparo_phpbbintegration_verify_ssl', $request->variable('mosparo_phpbbintegration_verify_ssl', true));
			$config->set('mosparo_phpbbintegration_protect_registration', $request->variable('mosparo_phpbbintegration_protect_registration', true));
			$config->set('mosparo_phpbbintegration_protect_posting', $request->variable('mosparo_phpbbintegration_protect_posting', true));
			trigger_error($language->lang('ACP_MOSPARO_PHPBBINTEGRATION_SETTINGS_SAVED') . adm_back_link($this->u_action));
		}

		$template->assign_vars([
			'MOSPARO_PHPBBINTEGRATION_HOST' => $config['mosparo_phpbbintegration_host'],
			'MOSPARO_PHPBBINTEGRATION_UUID' => $config['mosparo_phpbbintegration_uuid'],
			'MOSPARO_PHPBBINTEGRATION_PUBLIC_KEY' => $config['mosparo_phpbbintegration_public_key'],
			'MOSPARO_PHPBBINTEGRATION_PRIVATE_KEY' => $config['mosparo_phpbbintegration_private_key'],
			'MOSPARO_PHPBBINTEGRATION_VERIFY_SSL' => $config['mosparo_phpbbintegration_verify_ssl'],
			'MOSPARO_PHPBBINTEGRATION_PROTECT_REGISTRATION' => $config['mosparo_phpbbintegration_protect_registration'],
			'MOSPARO_PHPBBINTEGRATION_PROTECT_POSTING' => $config['mosparo_phpbbintegration_protect_posting'],
			'U_ACTION' => $this->u_action,
		]);
	}
}
