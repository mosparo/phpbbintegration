<?php
/**
 *
 * mosparo phpBB Integration. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2026, mosparo Core Developers, https://mosparo.io
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace mosparo\phpbbintegration\migrations;

use phpbb\db\migration\migration;

class install_acp_module extends migration
{
	public function effectively_installed()
	{
		return isset($this->config['mosparo_phpbbintegration_host']);
	}

	public static function depends_on()
	{
		return ['\phpbb\db\migration\data\v320\v320'];
	}

	public function update_data()
	{
		return [
			['config.add', ['mosparo_phpbbintegration_host', '']],
            ['config.add', ['mosparo_phpbbintegration_uuid', '']],
            ['config.add', ['mosparo_phpbbintegration_public_key', '']],
            ['config.add', ['mosparo_phpbbintegration_private_key', '']],
            ['config.add', ['mosparo_phpbbintegration_verify_ssl', true]],
            ['config.add', ['mosparo_phpbbintegration_protect_registration', true]],
            ['config.add', ['mosparo_phpbbintegration_protect_posting', true]],

			['module.add', [
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_MOSPARO_PHPBBINTEGRATION_TITLE'
			]],
			['module.add', [
				'acp',
				'ACP_MOSPARO_PHPBBINTEGRATION_TITLE',
				[
					'module_basename'	=> '\mosparo\phpbbintegration\acp\main_module',
					'modes'				=> ['settings'],
				],
			]],
		];
	}
}
