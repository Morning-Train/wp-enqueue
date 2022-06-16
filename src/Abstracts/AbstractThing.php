<?php

namespace Morningtrain\WP\Enqueue\Abstracts;

abstract class AbstractThing
{
    protected string $src = '';
    protected array $deps = [];
    protected string|bool|null $ver = false;

    public function __construct(protected string $handle)
    {

    }

    public function src(string $src): static
    {
        $this->src = $src;

        return $this;
    }

    public function deps(array|string $deps): static
    {
        $this->deps = array_merge($this->deps, (array) $deps);

        return $this;
    }

    public function ver(string $ver): static
    {
        $this->ver = $ver;

        return $this;
    }

    protected abstract function register(): void;

    protected abstract function enqueue(): void;

    protected function delay(string $function)
    {
        \add_action('wp_enqueue_scripts', [$this, $function]);
    }
}
