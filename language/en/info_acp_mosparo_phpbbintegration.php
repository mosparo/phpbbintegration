<?php
/**
 *
 * mosparo phpBB Integration. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2026, mosparo Core Developers, https://mosparo.io
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, [
    'ACP_MOSPARO_PHPBBINTEGRATION_TITLE' => 'mosparo Integration',
    'ACP_MOSPARO_PHPBBINTEGRATION' => 'mosparo Integration Settings',
    'ACP_MOSPARO_PHPBBINTEGRATION_INTRO' => 'mosparo offers spam protection for your registration and posting forms by scanning the data in the form fields for spam.',
    'ACP_MOSPARO_PHPBBINTEGRATION_HOWTO' => 'You need a mosparo project in a mosparo installation to set up the extension. Learn more about this on <a href="https://mosparo.io/how-to-use/" target="_blank">our website</a>.',

    'ACP_MOSPARO_PHPBBINTEGRATION_HOST' => 'Host',
    'ACP_MOSPARO_PHPBBINTEGRATION_HOST_EXPLAIN' => 'The host of your mosparo Installation, for example <samp>https://mosparo.example.com</samp>.',
    'ACP_MOSPARO_PHPBBINTEGRATION_UUID' => 'UUID',
    'ACP_MOSPARO_PHPBBINTEGRATION_UUID_EXPLAIN' => 'The UUID of your project.',
    'ACP_MOSPARO_PHPBBINTEGRATION_PUBLIC_KEY' => 'Public key',
    'ACP_MOSPARO_PHPBBINTEGRATION_PUBLIC_KEY_EXPLAIN' => 'The public key of your project.',
    'ACP_MOSPARO_PHPBBINTEGRATION_PRIVATE_KEY' => 'Private key',
    'ACP_MOSPARO_PHPBBINTEGRATION_PRIVATE_KEY_EXPLAIN' => 'The private key of your project.',
    'ACP_MOSPARO_PHPBBINTEGRATION_VERIFY_SSL' => 'Verify SSL',
    'ACP_MOSPARO_PHPBBINTEGRATION_VERIFY_SSL_EXPLAIN' => 'Decide if you want to verify the mosparo SSL certificate when the backend verifies the submission. If you use a self-signed certificate, you should set this to "No"; otherwise, it should be "Yes".',
    'ACP_MOSPARO_PHPBBINTEGRATION_PROTECT_REGISTRATION' => 'Protect registration',
    'ACP_MOSPARO_PHPBBINTEGRATION_PROTECT_REGISTRATION_EXPLAIN' => 'Decides if new registrations are protected with mosparo or not.',
    'ACP_MOSPARO_PHPBBINTEGRATION_PROTECT_POSTING' => 'Protect posting',
    'ACP_MOSPARO_PHPBBINTEGRATION_PROTECT_POSTING_EXPLAIN' => 'Decides if posting is protected (new topic, reply post) or not. If yes, you can additionally control this by using the forum permission on forum roles or forums themselves to decide where you want the mosparo protection and where not.',
    'ACP_MOSPARO_PHPBBINTEGRATION_SETTINGS_SAVED' => 'The mosparo settings were saved successfully.',

    'LOG_ACP_MOSPARO_PHPBBINTEGRATION_SETTINGS'	=> '<strong>mosparo Integration settings updated</strong>',
]);
