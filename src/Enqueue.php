<?php

namespace Morningtrain\WP\Enqueue;

use Morningtrain\WP\Enqueue\Classes\Script;
use Morningtrain\WP\Enqueue\Classes\Style;

class Enqueue
{
    protected static ?string $rootUrl = null;
    protected static array $manifest = [];

    public static function script(string $handle): Script
    {
        return (new Script($handle))
            ->rootUrl(static::$rootUrl)
            ->useMixManifest(static::$manifest);
    }

    public static function style(string $handle): Style
    {
        return (new Style($handle))
            ->rootUrl(static::$rootUrl)
            ->useMixManifest(static::$manifest);

    }

    public static function didEnqueue(): bool
    {
        return \did_action('wp_enqueue_scripts');
    }

    public static function setRootUrl(?string $url)
    {
        static::$rootUrl = $url ? \trailingslashit($url) : null;
    }

    public static function addManifest(string $file)
    {
        static::$manifest = json_decode(file_get_contents($file), true);
    }
}
