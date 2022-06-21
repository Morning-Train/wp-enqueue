<?php

namespace Morningtrain\WP\Enqueue\Classes;

use Morningtrain\WP\Enqueue\Enqueue;

/**
 * Class Script
 *
 * @see https://developer.wordpress.org/reference/functions/wp_enqueue_script/
 * @package Morningtrain\WP\Enqueue\Classes
 */
class Script extends \Morningtrain\WP\Enqueue\Abstracts\AbstractThing
{

    private bool $inFooter = false;

    /**
     * Whether to enqueue the script before </body> instead of in the <head>.
     *
     * @param  bool  $inFooter
     *
     * @return $this
     */
    public function inFooter(bool $inFooter): static
    {
        $this->inFooter = $inFooter;

        return $this;
    }

    /**
     * Register script
     *
     * @see https://developer.wordpress.org/reference/functions/wp_register_script/
     */
    public function register(): void
    {
        if (Enqueue::didEnqueue()) {
            \wp_register_script($this->handle, $this->getUrl(), $this->deps, $this->ver, $this->inFooter);

            return;
        }

        $this->delay(__FUNCTION__);
    }

    /**
     * Enqueue script
     * If WordPress is not yet ready then enqueue will wait
     *
     * @see https://developer.wordpress.org/reference/functions/wp_enqueue_script/
     */
    public function enqueue(): void
    {
        if (Enqueue::didEnqueue()) {
            \wp_enqueue_script($this->handle, $this->getUrl(), $this->deps, $this->ver, $this->inFooter);

            return;
        }

        $this->delay(__FUNCTION__);
    }
}
