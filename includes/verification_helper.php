<?php
/**
 *
 * mosparo phpBB Integration. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2026, mosparo Core Developers, https://mosparo.io
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace mosparo\phpbbintegration\includes;

use Exception;
use MosparoDependencies\Mosparo\ApiClient\VerificationResult;
use MosparoDependencies\Mosparo\ApiClient\Client;
use phpbb\config\config;

require_once(__DIR__ . '/../vendor-prefixed/autoload.php');

class verification_helper
{
    protected config $config;

    public Exception $last_exception;

    public function __construct(config $config)
    {
        $this->config = $config;
    }

    public function verify_submission(string $submit_token, string $validation_token, array $form_data): VerificationResult|null
    {
        $host = $this->config['mosparo_phpbbintegration_host'];
        $public_key = $this->config['mosparo_phpbbintegration_public_key'];
        $private_key = $this->config['mosparo_phpbbintegration_private_key'];
        $verify_ssl = boolval($this->config['mosparo_phpbbintegration_verify_ssl']);

        $client = new Client($host, $public_key, $private_key, ['verify' => $verify_ssl]);
        $result = null;
        try
        {
            $result = $client->verifySubmission($form_data, $submit_token, $validation_token);
        }
        catch (Exception $e)
        {
            $this->last_exception = $e;
        }

        return $result;
    }
}