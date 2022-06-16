<?php

namespace Morningtrain\WP\Enqueue;

use Morningtrain\WP\Enqueue\Classes\Script;
use Morningtrain\WP\Enqueue\Classes\Style;

class Enqueue
{
    protected static ?string $scriptRootUrl = null;
    protected static ?string $styleRootUrl = null;

    public static function script(string $handle): Script
    {
        return (new Script($handle))->rootUrl(static::$scriptRootUrl);
    }

    public static function style(string $handle): Style
    {
        return (new Style($handle))->rootUrl(static::$styleRootUrl);
    }

    public static function didEnqueue(): bool
    {
        return \did_action('wp_enqueue_scripts');
    }

    public static function setScriptRootUrl(?string $url)
    {
        static::$scriptRootUrl = $url ? \trailingslashit($url) : null;
    }

    public static function setStyleRootUrl(?string $url)
    {
        static::$styleRootUrl = $url ? \trailingslashit($url) : null;
    }
}
