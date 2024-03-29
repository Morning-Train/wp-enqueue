<?php

namespace Morningtrain\WP\Enqueue\Abstracts;

abstract class AbstractThing
{
    protected string $src = '';
    protected array $deps = [];
    protected string|bool|null $ver = false;
    protected ?string $rootUrl;
    protected ?string $rootPath;
    protected array $manifest = [];

    /**
     * AbstractThing constructor.
     *
     * @param  string  $handle
     */
    public function __construct(protected string $handle)
    {
        $this->src($handle);
    }

    /**
     * Set the asset source
     *
     * @param  string  $src  The asset URL
     *
     * @return $this
     */
    public function src(string $src): static
    {
        $this->src = $src;

        return $this;
    }

    /**
     * Dependency list
     * If $deps is a string then it will be pushed to existing deps
     *
     * @param  array|string  $deps
     *
     * @return $this
     */
    public function deps(array|string $deps): static
    {
        $this->deps = array_merge($this->deps, (array) $deps);

        return $this;
    }

    /**
     * Version
     * Leave blank if you use a manifest
     *
     * @param  string  $ver
     *
     * @return $this
     */
    public function ver(string $ver): static
    {
        $this->ver = $ver;

        return $this;
    }

    /**
     * Set the root URL
     *
     * @param  string|null  $url
     * @return $this
     */
    public function rootUrl(?string $url): static
    {
        $this->rootUrl = $url;

        return $this;
    }

    /**
     * A getter for the src Url
     *
     * @return string
     */
    public function getUrl()
    {
        return trailingslashit($this->rootUrl) . ltrim($this->applyMixManifest($this->src), '/\\');
    }

    /**
     * Set the root PATH
     * If this is set then $src will be appended
     *
     * @param  string|null  $path
     * @return $this
     */
    public function rootPath(?string $path): static
    {
        $this->rootPath = $path;

        return $this;
    }

    /**
     * A getter for the src Path
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->rootPath . $this->src;
    }

    /**
     * Tell this asset to use this manifest array
     *
     * @param  array  $manifest
     *
     * @return $this
     */
    public function useMixManifest(array $manifest): static
    {
        $this->manifest = $manifest;

        return $this;
    }

    /**
     * Apply the registered manifest to a src and return it
     *
     * @param  string  $src
     *
     * @return string
     */
    protected function applyMixManifest(string $src): string
    {
        foreach ($this->manifest as $_src => $hashedSrc) {
            if ($_src === '/' . ltrim($src, '/\\')) {
                return $hashedSrc;
            }
        }

        return $src;
    }

    /**
     * Apply a WP-Scripts asset file version and dependencies if file exists
     * The asset file is created when wp-scripts builds assets. File is names [name].asset.php and includes a wp-dependency list and a version hash
     *
     * @return $this
     */
    public function applyAssetFile(): static
    {
        $extension = pathinfo($this->getPath())['extension'];
        $assetFileName = preg_replace('/\.' . $extension . '$/', '.asset.php', $this->getPath());
        $assetFile = file_exists($assetFileName) ? require($assetFileName) : null;

        if (! empty($assetFile) && is_array($assetFile) && ! empty($assetFile['version'])) {
            $this->ver($assetFile['version']);
            $this->deps($assetFile['dependencies']);
        }

        return $this;
    }

    protected abstract function register(): void;

    protected abstract function enqueue(): void;

    /**
     * Delay the execution of a method until wp_enqueue_scripts
     *
     * @param  string  $function
     */
    protected function delay(string $function)
    {
        if(is_login()) {
            return add_action('login_enqueue_scripts', [$this, $function]);
        }

        if(is_admin()) {
            return add_action('admin_enqueue_scripts', [$this, $function]);
        }
        
        add_action('wp_enqueue_scripts', [$this, $function]);
    }
}
