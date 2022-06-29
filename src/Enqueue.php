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
    protected static ?string $rootUrl = null;
    protected static array $manifest = [];

    /**
     * Begin Enqueueing a script
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
        return (new Script($handle))
            ->src($src)
            ->rootUrl(static::$rootUrl)
            ->useMixManifest(static::$manifest);
    }

    /**
     * Begin Enqueueing a stylesheet
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
        return (new Style($handle))
            ->src($src)
            ->rootUrl(static::$rootUrl)
            ->useMixManifest(static::$manifest);

    }

    /**
     * Did WordPress already do wp_enqueue_scripts ?
     *
     * @return bool
     */
    public static function didEnqueue(): bool
    {
        return \did_action('wp_enqueue_scripts');
    }

    /**
     * Set a Root Directory
     * This should be the URL of the setPublicPath in webpack.mix.js
     *
     * @param  string|null  $url
     */
    public static function setRootUrl(?string $url)
    {
        static::$rootUrl = $url ? \trailingslashit($url) : null;
    }

    /**
     * Get the Root Directory
     */
    public static function getRootUrl(): ?string
    {
        return static::$rootUrl;
    }

    /**
     * Add a mix-manifest.json file for use in hashing
     * Note that this file should be located in the root dir. Where setPublicPath also points to
     *
     * @param  string  $file  full path to file. Filename included
     */
    public static function addManifest(string $file)
    {
        $manifest = json_decode(file_get_contents($file), true);
        if (is_array($manifest)) {
            static::$manifest = $manifest;
        }
    }
}
