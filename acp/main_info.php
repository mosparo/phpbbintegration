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
 * mosparo phpBB Integration ACP module info.
 */
class main_info
{
	public function module()
	{
		return [
			'filename'	=> '\mosparo\phpbbintegration\acp\main_module',
			'title'		=> 'ACP_MOSPARO_PHPBBINTEGRATION_TITLE',
			'modes'		=> [
				'settings'	=> [
					'title'	=> 'ACP_MOSPARO_PHPBBINTEGRATION',
					'auth'	=> 'ext_mosparo/phpbbintegration && acl_a_board',
					'cat'	=> ['ACP_MOSPARO_PHPBBINTEGRATION_TITLE'],
				],
			],
		];
	}
}
