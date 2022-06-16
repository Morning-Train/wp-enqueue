<?php

namespace Morningtrain\WP\Enqueue\Abstracts;

abstract class AbstractThing
{
    protected string $src = '';
    protected array $deps = [];
    protected string|bool|null $ver = false;
    protected ?string $rootUrl;

    public function __construct(protected string $handle)
    {
        $this->src = $handle;
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

    public function rootUrl(?string $url): static
    {
        $this->rootUrl = $url;

        return $this;
    }

    public function getUrl()
    {
        return $this->rootUrl . $this->src;
    }

    protected abstract function register(): void;

    protected abstract function enqueue(): void;

    protected function delay(string $function)
    {
        \add_action('wp_enqueue_scripts', [$this, $function]);
    }
}
