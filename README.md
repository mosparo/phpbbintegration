&nbsp;
<p align="center">
    <img src="https://github.com/mosparo/mosparo/blob/master/assets/images/mosparo-logo.svg?raw=true" alt="mosparo logo contains a bird with the name Mo and the mosparo text"/>
</p>

<h1 align="center">
    Extension for phpBB
</h1>
<p align="center">
    A phpBB extension to protect the registration and posting forms with mosparo.
</p>

-----

## Description

The mosparo Integration for phpBB can protect the registration and posting forms (New topic, Post reply) of your phpBB installation. You can use mosparo to rate-limit or protect your phpBB installation from bots and spam content.

**The mosparo Integration for phpBB requires at least PHP 8.1.**

## Requirements

- phpBB: >= 3.3.x
- PHP: >= 8.1

## Installation

1. Copy the extension to `ext/mosparo/phpbbintegration` in your phpBB directory.
2. In the ACP, go to: **Customise → Manage extensions**.
3. Enable the **mosparo Integration** extension.
4. Head over to **Extensions → mosapro Integration Settings** and configure the connection to your project. Additionally, you can either enable or disable the protection of the registration or the posting forms.
5. If you want disable mosparo for certain forum roles, you can head over to **Permissions** and set the permission **Can bypass the mosparo protection** (category **Post**) to **Yes**.

## Customization

If you have your own fields in the posting forms or i you need to adjust the mosparo verification process, you can listen for the events `mosparo.phpbbintegration.form_data_registration` and `mosparo.phpbbintegration.form_data_posting`. Both event will be dispatched with a `\mosparo\phpbbintegration\event\form_data` object which contains the form data, the required and the verifiable fields.

If you have custom fields, please adjust the form data as well as the required and the verified fields arrays.

## Why not using the phpBB CAPTCHA system?

mosparo is from a very technical perspective more a spam protection method than a CAPTCHA method. With the phpBB CAPTCHA system, it would be possible to add mosparo to the registration and the posting form. 

But mosparo would be in a user-unfriendly place in the posting form, since the CAPTCHA box is placed above the content editor. When we add mosparo there, the user has to check the mosparo box after adding the content, which is not a good user experience.

Additionally, the CAPTCHA system of phpBB does not protect the posting form for authenticated users. But since mosparo is a spam protection system, it is a normal use case to protect a form even for authenticated users.

The negative side of the choosen integration method is, that we cannot protect the login or lost-password forms. The phpBB CAPTCHA system would allow the login form, but not on the first login request because of the login forum box. On the other side, we cannot protect these forms with our choosen method, since there are no events in the login or lost-password forms which we could use.

## License

Licensed under the [GNU General Public License v2](license.txt)
