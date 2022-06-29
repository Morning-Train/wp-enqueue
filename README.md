# WP Enqueue

For easy script and style enqueueing in WordPress. With Laravel Mix Manifest support!

## Table of Contents

- [Introduction](#introduction)
- [Getting Started](#getting-started)
    - [Installation](#installation)
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

Fist [install](#installation) the package!

Then from here on your entry point will be `Morningtrain\WP\Enqueue\Enqueue`.

### Installation

This tool is available as a package and can be installed through composer:

```
composer require morningtrain/wp-enqueue
```

## Usage

Here is a quick example to get you started!

```php
// functions.php (or plugin.php)
Enqueue::addManifest(get_stylesheet_directory() . '/public/build/mix-manifest.json');
Enqueue::setRootUrl(get_stylesheet_directory_uri() . '/public/build');

// Then wherever you wish to enqueue - preferably in the wp_enqueue_scripts action
Enqueue::script('main')
    ->src('js/main.js')
    ->deps('jquery')
    ->enqueue();

// Or to simply register a stylesheet
Enqueue::style('main')
    ->src('css/main.css')
    ->register();

// In a block, on a route or in a condition somewhere you can now enqueue the already registered stylesheet
Enqueue::style('main')->enqueue();
```

### Before you start

All relative paths should match paths in `webpack.mix.js`.

Note: Enqueueing assets before the `wp_enqueue_scripts` hook automatically delay the enqueueing until WordPress is
ready. You should, of course, still enqueue properly in the right hook.

### Defining the root Url

You may define the root URL of your build directory.

By doing this you can now enqueue assets using a relative path. This should match the one defined in `webpack.mix.js` if
you are using [Laravel Mix](https://laravel-mix.com/)

```php
// Setting the root URL
\Morningtrain\WP\Enqueue\Enqueue::setRootUrl(get_stylesheet_directory_uri() . '/public/build');
```

You may also get the url by calling `Enqueue::getRootUrl()`

```php
// Getting the root URL
$rootUrl = \Morningtrain\WP\Enqueue\Enqueue::getRootUrl();
```

### Adding a MixManifest file

If you are using [Laravel Mix](https://laravel-mix.com/) then you can add the generated `mix-manifest.json` file. By
doing this all enqueued assets will automatically use the hashed sources.

This is an easy and convenient way to clear client cached assets without worry.

```php
// Adding the manifest file
\Morningtrain\WP\Enqueue\Enqueue::addManifest(get_stylesheet_directory() . '/public/build/mix-manifest.json');
```

### Loading scripts and styles

Loading a script or a style is almost the same!
Construct either a `Script` or a `Style` from `Enqueue`

Then, using a fluid api, you can configure your asset and then either enqueue or register at the end.

Note: These methods act the same as, and wraps, WordPress
methods [wp_enqueue_script()](https://developer.wordpress.org/reference/functions/wp_enqueue_script/)
and [wp_enqueue_style()](https://developer.wordpress.org/reference/functions/wp_enqueue_style/) and their register
equivalents.

```php
// Beginning an Enqueue chain
// This is how you start enqueueing or registering a script
\Morningtrain\WP\Enqueue\Enqueue::script('my-script');
// ... and for a stylesheet
\Morningtrain\WP\Enqueue\Enqueue::style('my-style');
```

After this inspect the instance returned. All options are available as chainable methods!

#### Enqueueing

To enqueue simply end your chain by calling `enqueue()`

```php
// Enqueue a script called 'my-script' which is located in the /js directory
\Morningtrain\WP\Enqueue\Enqueue::script('my-script')
    ->src('js/my-script.js')
    ->enqueue();

// Or you may supply the source as the second param as so
\Morningtrain\WP\Enqueue\Enqueue::script('my-script', 'js/my-script.js')
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

Then later you can enqueue your asset this way:

```php
// Enqueue a script called 'my-script' which has already been registered
\Morningtrain\WP\Enqueue\Enqueue::script('my-script')
    ->enqueue();
```

### Options

There are the same options as the methods these classes wrap.

**Note:** `deps()` also accepts a string and if you call it multiple times in the same chain then every call pushes its
value to the list.

#### Script

Here is an example using all available options:

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

Here is an example using all available options:

See [wp_enqueue_style](https://developer.wordpress.org/reference/functions/wp_enqueue_style/) on developer.wordpress.org

```php
\Morningtrain\WP\Enqueue\Enqueue::style('my-style')
    ->src('css/my-style.css')
    ->deps('print-styles')
    ->ver('1.0')
    ->media('print')
    ->enqueue();
```
