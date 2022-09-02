<?php

namespace Morningtrain\WP\Enqueue;

use Morningtrain\WP\Enqueue\Classes\Script;
use Morningtrain\WP\Enqueue\Classes\Style;

/**
 * Class Enqueue
 *
 * Use fluid interface to enqueue assets with Laravel mix support
 *
 * @package Morningtrain\WP\Enqueue
 */
class Enqueue
{
    const ROOT_KEY = 'root';
    protected static array $directories = [];
    protected static array $manifests = [];

    /**
     * Begin Enqueueing a script
     * You may namespace your script with "::" such as "myPlugin::main.js"
     *
     * @see https://developer.wordpress.org/reference/functions/wp_enqueue_script/
     *
     * @param  string  $handle
     * @param  string  $src  Optional. The src property
     *
     * @return Script
     */
    public static function script(string $handle, string $src = ''): Script
    {
        if (str_contains($handle, '::')) {
            [$namespace, $handle] = explode('::', $handle);
        } else {
            $namespace = static::ROOT_KEY;
        }

        return (new Script($handle))
            ->src($src)
            ->rootUrl(static::getDirectoryUrl($namespace))
            ->useMixManifest(static::getManifest($namespace));
    }

    /**
     * Begin Enqueueing a stylesheet
     * You may namespace your style with "::" such as "myPlugin::main.css"
     *
     * @see https://developer.wordpress.org/reference/functions/wp_enqueue_style/
     *
     * @param  string  $handle
     * @param  string  $src  Optional. The src property
     *
     * @return Style
     */
    public static function style(string $handle, string $src = ''): Style
    {
        if (str_contains($handle, '::')) {
            [$namespace, $handle] = explode('::', $handle);
        } else {
            $namespace = static::ROOT_KEY;
        }

        return (new Style($handle))
            ->src($src)
            ->rootUrl(static::getDirectoryUrl($namespace))
            ->useMixManifest(static::getManifest($namespace));
    }

    /**
     * Did WordPress already do wp_enqueue_scripts ?
     *
     * @return bool
     */
    public static function didEnqueue(): bool
    {

        return \did_action('wp_enqueue_scripts') || \did_action('admin_enqueue_scripts');
    }

    /**
     * Set a Root Directory
     * This should be the URL of the setPublicPath in webpack.mix.js
     *
     * @param  string|null  $url
     */
    public static function setRootUrl(?string $url)
    {
        static::$directories[static::ROOT_KEY] = $url ? \trailingslashit($url) : null;
    }

    /**
     * Get the Root Directory
     */
    public static function getRootUrl(): ?string
    {
        return static::getDirectoryUrl(static::ROOT_KEY);
    }

    /**
     * Get the Directory of a namespace
     */
    public static function getDirectoryUrl(string $namespace = self::ROOT_KEY): ?string
    {
        return static::$directories[$namespace] ?? null;
    }

    /**
     * Add a mix-manifest.json file for use in hashing
     * Note that this file should be located in the root dir. Where setPublicPath also points to
     *
     * @param  string  $file  full path to file. Filename included
     */
    public static function addManifest(string $file, string $namespace = self::ROOT_KEY)
    {
        $manifest = json_decode(file_get_contents($file), true);
        if (is_array($manifest)) {
            static::$manifests[$namespace] = $manifest;
        }
    }

    /**
     * Get the manifest.json content as array
     *
     * @return array
     */
    public static function getManifest(string $namespace = self::ROOT_KEY): array
    {
        return static::$manifests[$namespace] ?? [];
    }

    /**
     * Add a namespace for scripts/styles
     * This allows the use of multiple directories and manifests in the same codebase.
     * This is especially useful for plugins.
     *
     * @param  string  $namespace
     * @param  string  $directoryUrl
     * @param  string|null  $manifest
     */
    public static function addNamespace(string $namespace, string $directoryUrl, ?string $manifest = null)
    {
        static::$directories[$namespace] = \trailingslashit($directoryUrl);
        if ($manifest !== null && file_exists($manifest)) {
            static::addManifest($manifest, $namespace);
        }
    }
}
