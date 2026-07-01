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
    'ACP_MOSPARO_PHPBBINTEGRATION' => 'mosparo Integration Einstellungen',
    'ACP_MOSPARO_PHPBBINTEGRATION_INTRO' => 'mosparo bietet einen Spam-Schutz für Ihre Registrierungs- und Beitragsformulare, indem es die Daten in den Formularfeldern auf Spam überprüft.',
    'ACP_MOSPARO_PHPBBINTEGRATION_HOWTO' => 'Um die Extension einzurichten, benötigen Sie ein mosparo-Projekt in einer mosparo-Installation. Weitere Informationen hierzu finden Sie auf <a href="https://mosparo.io/how-to-use/" target="_blank">unserer Website</a>.',

    'ACP_MOSPARO_PHPBBINTEGRATION_HOST' => 'Host',
    'ACP_MOSPARO_PHPBBINTEGRATION_HOST_EXPLAIN' => 'Der Host Ihrer mosparo-Installation, zum Beispiel <samp>https://mosparo.example.com</samp>.',
    'ACP_MOSPARO_PHPBBINTEGRATION_UUID' => 'Eindeutige Identifikationsnummer',
    'ACP_MOSPARO_PHPBBINTEGRATION_UUID_EXPLAIN' => 'Die eindeutige Identifikationsnummer Ihres Projektes.',
    'ACP_MOSPARO_PHPBBINTEGRATION_PUBLIC_KEY' => 'Öffentlicher Schlüssel',
    'ACP_MOSPARO_PHPBBINTEGRATION_PUBLIC_KEY_EXPLAIN' => 'Der öffentliche Schlüssel Ihres Projektes.',
    'ACP_MOSPARO_PHPBBINTEGRATION_PRIVATE_KEY' => 'Geheimer Schlüssel',
    'ACP_MOSPARO_PHPBBINTEGRATION_PRIVATE_KEY_EXPLAIN' => 'Der geheime Schlüssel Ihres Projektes.',
    'ACP_MOSPARO_PHPBBINTEGRATION_VERIFY_SSL' => 'SSL verifizieren',
    'ACP_MOSPARO_PHPBBINTEGRATION_VERIFY_SSL_EXPLAIN' => 'Entscheiden Sie, ob das mosparo-SSL-Zertifikat überprüft werden soll, wenn das Backend die Übermittlung überprüft. Wenn Sie ein selbstsigniertes Zertifikat verwenden, sollten Sie diese Option auf „Nein“ setzen; andernfalls sollte sie auf „Ja“ gesetzt sein.',
    'ACP_MOSPARO_PHPBBINTEGRATION_PROTECT_REGISTRATION' => 'Registration schützen',
    'ACP_MOSPARO_PHPBBINTEGRATION_PROTECT_REGISTRATION_EXPLAIN' => 'Legt fest, ob neue Registrationen mit mosparo geschützt werden oder nicht.',
    'ACP_MOSPARO_PHPBBINTEGRATION_PROTECT_POSTING' => 'Beitragsformulare schützen',
    'ACP_MOSPARO_PHPBBINTEGRATION_PROTECT_POSTING_EXPLAIN' => 'Legt fest, ob das Erstellen eines Beitrages mit mosparo geschützt ist (Neues Thema, Antworten) oder nicht. Falls ja, können Sie dies zusätzlich über die Forum-Berechtigungen für Forum-Rollen oder Foren selbst steuern, um zu entscheiden, wo der mosparo-Schutz gelten soll und wo nicht.',
    'ACP_MOSPARO_PHPBBINTEGRATION_SETTINGS_SAVED' => 'Die mosparo-Einstellungen wurden erfolgreich gespeichert.',
]);
