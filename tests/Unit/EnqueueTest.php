<?php

use Brain\Monkey;

beforeAll(function () {
    Monkey\setUp();
});

afterAll(function () {
    Monkey\tearDown();
});

it('has Enqueue main class', function () {
    expect(\Morningtrain\WP\Enqueue\Enqueue::class)->toBeString();
});
it('has Script class', function () {
    expect(\Morningtrain\WP\Enqueue\Classes\Script::class)->toBeString();
});
it('has Style class', function () {
    expect(\Morningtrain\WP\Enqueue\Classes\Style::class)->toBeString();
});

it('can construct a script', function () {
    expect(\Morningtrain\WP\Enqueue\Enqueue::script('foo'))->toBeInstanceOf(\Morningtrain\WP\Enqueue\Classes\Script::class);
});

it('can construct a style', function () {
    expect(\Morningtrain\WP\Enqueue\Enqueue::style('foo'))->toBeInstanceOf(\Morningtrain\WP\Enqueue\Classes\Style::class);
});
