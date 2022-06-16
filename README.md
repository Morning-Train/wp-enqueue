# WP Enqueue

[![Latest Release](https://backuptrain.dk/internal-projects/wp/wp-enqueue/-/badges/release.svg)](https://backuptrain.dk/internal-projects/wp/wp-enqueue/-/releases)
[![pipeline status](https://backuptrain.dk/internal-projects/wp/wp-enqueue/badges/master/pipeline.svg)](https://backuptrain.dk/internal-projects/wp/wp-enqueue/-/pipelines)
[![coverage status](https://backuptrain.dk/internal-projects/wp/wp-enqueue/badges/master/coverage.svg)](https://backuptrain.dk/internal-projects/wp/wp-enqueue/-/graphs/master/charts)

For easy script and style enqueueing. With Manifest support!


```php
\Morningtrain\WP\Enqueue\Enqueue::script('my-script')
    ->dependsOn(['jquery'])
    ->register();
```
