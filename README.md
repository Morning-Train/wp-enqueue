# WP Enqueue

[![Latest Release](https://backuptrain.dk/internal-projects/wp/wp-enqueue/-/badges/release.svg)](https://backuptrain.dk/internal-projects/wp/wp-enqueue/-/releases)
[![pipeline status](https://backuptrain.dk/internal-projects/wp/wp-enqueue/badges/master/pipeline.svg)](https://backuptrain.dk/internal-projects/wp/wp-enqueue/-/pipelines)
[![coverage status](https://backuptrain.dk/internal-projects/wp/wp-enqueue/badges/master/coverage.svg)](https://backuptrain.dk/internal-projects/wp/wp-enqueue/-/graphs/master/charts)

For easy script and style enqueueing. With Laravel Mix Manifest support!

## Table of Contents

- [Introduction](#introduction)
- [Getting Started](#getting-started)
- [Usage](#usage)
    - [Before you start](#before-you-start)
    - [Defining the root Url](#defining-the-root-url)
    - [Adding a MixManifest file](#adding-a-mixmanifest-file)
    - [Loading scripts and styles](#loading-scripts-and-styles)
        - [Enqueueing](#enqueueing)
            - [Registering](#registering)
    - [Options](#options)
        - [Script](#script)
        - [Style](#style)

## Introduction

This tool is made for making enqueueing and registering WordPress scripts a bit more expressive and to make using
laravel Mix Manifest a bit easier to manage.

This tool lets you:

- Define a root URL for your scripts and styles so that you only have to use `get_stylesheet_directory_uri` once
- Add your `mix-manifest.json` file so that all mix compiled assets gets hashed automatically
- Use a fluid interface for enqueueing assets

## Getting Started

Fist install the package!

Then from here on your entry point will be `Morningtrain\WP\Enqueue\Enqueue`.

## Usage

```php
// A quick example!!
Enqueue::addManifest(get_stylesheet_directory() . '/public/build/mix-manifest.json');
Enqueue::setRootUrl(get_stylesheet_directory_uri() . '/public/build');

Enqueue::script('main')
    ->src('js/main.js')
    ->deps('jquery')
    ->enqueue();


Enqueue::style('main')
    ->src('css/main.css')
    ->register();

add_action(
    'wp_footer',
    function () {
        Enqueue::style('main')->enqueue();
    }
);
```

### Before you start

All relative paths should match paths in `webpack.mix.js`.

Don't worry about enqueueing assets before the `wp_enqueue_scripts` hook as this package will delay the enqueueing until
WordPress is ready.

### Defining the root Url

```php
// Setting the root URL
\Morningtrain\WP\Enqueue\Enqueue::setRootUrl(get_stylesheet_directory_uri() . '/public/build');
```

### Adding a MixManifest file

```php
// Adding the manifest file
\Morningtrain\WP\Enqueue\Enqueue::addManifest(get_stylesheet_directory() . '/public/build/mix-manifest.json');
```

### Loading scripts and styles

Loading a script or a style is almost the same!
Construct either a `Script` or a `Style` from `Enqueue`

```php
// Beginning an Enqueue chain
// This is how you start enqueueing or registering a script
\Morningtrain\WP\Enqueue\Enqueue::script('my-script');
// ... and for a stylesheet
\Morningtrain\WP\Enqueue\Enqueue::style('my-style');
```

After this inspect the instance returned. All options are available as chainable methods.

#### Enqueueing

```php
// Enqueue a script called 'my-script' which is located in the /js directory
\Morningtrain\WP\Enqueue\Enqueue::script('my-script')
    ->src('js/my-script.js')
    ->enqueue();
```

##### Registering

To register instead of enqueueing use `register()`

```php
// Register a script called 'my-script' which is located in the /js directory
\Morningtrain\WP\Enqueue\Enqueue::script('my-script')
    ->src('js/my-script.js')
    ->register();
```

Then later you can enqueue it like this:

```php
// Enqueue a script called 'my-script' which has already been registered
\Morningtrain\WP\Enqueue\Enqueue::script('my-script')
    ->enqueue();
```

### Options

**NOTE:** `deps()` also accepts a string

#### Script

See [wp_enqueue_script](https://developer.wordpress.org/reference/functions/wp_enqueue_script/) on
developer.wordpress.org

```php
\Morningtrain\WP\Enqueue\Enqueue::script('my-script')
    ->src('js/my-script.js')
    ->deps('jquery')
    ->ver('1.0')
    ->inFooter(true)
    ->enqueue();
```

#### Style

See [wp_enqueue_style](https://developer.wordpress.org/reference/functions/wp_enqueue_style/) on developer.wordpress.org

```php
\Morningtrain\WP\Enqueue\Enqueue::style('my-style')
    ->src('css/my-style.css')
    ->deps('print-styles')
    ->ver('1.0')
    ->media('print')
    ->enqueue();
```
