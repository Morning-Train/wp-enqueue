<?php

namespace Morningtrain\WP\Enqueue;

use Morningtrain\WP\Enqueue\Classes\Script;
use Morningtrain\WP\Enqueue\Classes\Style;

class Enqueue
{
    public static function script(string $handle): Script
    {
        return new Script($handle);
    }

    public static function style(string $handle): Style
    {
        return new Style($handle);
    }

    public static function didEnqueue(): bool
    {
        return \did_action('wp_enqueue_scripts');
    }
}
