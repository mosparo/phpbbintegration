#!/bin/env php
<?php
/**
 *
 * mosparo phpBB Integration. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2026, mosparo Core Developers, https://mosparo.io
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

/**
 *
 * IMPORTANT:
 * This script will be used to copy the licenses to the correct location after Strauss
 * prepared the dependencies. The script will not be bundled in the extension since
 * it's only used for the deployment.
 *
 */

require_once(__DIR__ . '/../vendor/autoload.php');

use League\Flysystem\Local\LocalFilesystemAdapter;
use League\Flysystem\Filesystem;
use Symfony\Component\Finder\Finder;

$vendor_dir = realpath(__DIR__ . '/../vendor/');
$target_dir = realpath(__DIR__ . '/../vendor-prefixed');

$filesystem = new Filesystem(new LocalFilesystemAdapter('/'));
$finder = new Finder();
$finder->files()->in($vendor_dir)->followLinks()->exclude(['vendor'])->name('/^.*licen.e.*/i');

foreach ($finder as $file)
{
    $file_path = $file->getPathname();
    $target_file_path = str_replace($vendor_dir, $target_dir, $file_path);

    if (!file_exists(dirname($target_file_path)))
    {
        // Skip, if the directory does not exist.
        continue;
    }

    if ($filesystem->has($target_file_path))
    {
        continue;
    }

    if (!$filesystem->has(dirname($target_file_path)))
    {
        continue;
    }

    $filesystem->copy(
        $file_path,
        $target_file_path
    );
}
