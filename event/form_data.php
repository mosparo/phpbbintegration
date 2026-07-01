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

use Symfony\Component\EventDispatcher\Event;

class form_data extends Event
{
	protected array $form_data;

	protected array $required_fields;

	protected array $verifiable_fields;

	public function __construct(array $form_data, array $required_fields, array $verifiable_fields)
	{
		$this->form_data = $form_data;
		$this->required_fields = $required_fields;
		$this->verifiable_fields = $verifiable_fields;
	}

	public function get_form_data(): array
	{
		return $this->form_data;
	}

	public function set_form_data(array $form_data): void
	{
		$this->form_data = $form_data;
	}

	public function get_required_fields(): array
	{
		return $this->required_fields;
	}

	public function set_required_fields(array $required_fields): void
	{
		$this->required_fields = $required_fields;
	}

	public function get_verifiable_fields(): array
	{
		return $this->verifiable_fields;
	}

	public function set_verifiable_fields(array $verifiable_fields): void
	{
		$this->verifiable_fields = $verifiable_fields;
	}
}
