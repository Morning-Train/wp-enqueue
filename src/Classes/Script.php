<?php

namespace Morningtrain\WP\Enqueue\Classes;

use Morningtrain\WP\Enqueue\Enqueue;

class Script extends \Morningtrain\WP\Enqueue\Abstracts\AbstractThing
{

    private bool $inFooter = false;

    public function inFooter(bool $inFooter): static
    {
        $this->inFooter = $inFooter;

        return $this;
    }

    public function register(): void
    {
        if (Enqueue::didEnqueue()) {
            \wp_register_script($this->handle, $this->getUrl(), $this->deps, $this->ver, $this->inFooter);
        }

        $this->delay(__FUNCTION__);
    }

    public function enqueue(): void
    {
        if (Enqueue::didEnqueue()) {
            \wp_enqueue_script($this->handle, $this->getUrl(), $this->deps, $this->ver, $this->inFooter);
        }

        $this->delay(__FUNCTION__);
    }
}
