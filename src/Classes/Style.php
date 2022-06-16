<?php

namespace Morningtrain\WP\Enqueue\Classes;

use Morningtrain\WP\Enqueue\Enqueue;

class Style extends \Morningtrain\WP\Enqueue\Abstracts\AbstractThing
{

    private string $media = 'all';

    public function media(string $media): static
    {
        $this->media = $media;

        return $this;
    }

    public function register(): void
    {
        if (Enqueue::didEnqueue()) {
            \wp_register_style($this->handle, $this->getUrl(), $this->deps, $this->ver, $this->media);
        }

        $this->delay(__FUNCTION__);
    }

    public function enqueue(): void
    {
        if (Enqueue::didEnqueue()) {
            \wp_enqueue_style($this->handle, $this->getUrl(), $this->deps, $this->ver, $this->media);
        }

        $this->delay(__FUNCTION__);
    }
}
