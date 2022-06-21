<?php

namespace Morningtrain\WP\Enqueue\Classes;

use Morningtrain\WP\Enqueue\Enqueue;

/**
 * Class Style
 *
 * @see https://developer.wordpress.org/reference/functions/wp_enqueue_style/
 * @package Morningtrain\WP\Enqueue\Classes
 */
class Style extends \Morningtrain\WP\Enqueue\Abstracts\AbstractThing
{

    private string $media = 'all';

    /**
     * The media for which this stylesheet has been defined. Accepts media types like 'all', 'print' and 'screen', or media queries like '(orientation: portrait)' and '(max-width: 640px)'.
     *
     * @param  string  $media
     *
     * @return $this
     */
    public function media(string $media): static
    {
        $this->media = $media;

        return $this;
    }

    /**
     * Register style
     *
     * @see https://developer.wordpress.org/reference/functions/wp_register_style/
     */
    public function register(): void
    {
        if (Enqueue::didEnqueue()) {
            \wp_register_style($this->handle, $this->getUrl(), $this->deps, $this->ver, $this->media);

            return;
        }

        $this->delay(__FUNCTION__);
    }

    /**
     * Enqueue style
     * If WordPress is not yet ready then enqueue will wait
     *
     * @see https://developer.wordpress.org/reference/functions/wp_enqueue_style/
     */
    public function enqueue(): void
    {
        if (Enqueue::didEnqueue()) {
            \wp_enqueue_style($this->handle, $this->getUrl(), $this->deps, $this->ver, $this->media);

            return;
        }

        $this->delay(__FUNCTION__);
    }
}
