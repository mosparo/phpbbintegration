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

class install_permission extends migration
{
	public static function depends_on()
	{
		return ['\phpbb\db\migration\data\v320\v320'];
	}

	public function update_data()
	{
		return [
			['permission.add', ['f_posting_bypass_mosparo', false]],

            ['permission.permission_set', ['ROLE_FORUM_FULL', 'f_posting_bypass_mosparo', 'role', true]],
		];
	}
}
