# flink-facebook-meta-crawler

This package provides a (currently) super simple additional method to (Flamecore's Flink)[https://github.com/FlameCore/Flink] to allow parsing of links by retrieving a subset of Facebook OpenGraph tags.

## Installation

Use `composer` to get the job done:

```bash
composer require causelabs/flink-facebook-meta-crawler
```

## Usage

In your code, use `CauseLabs\AnalyzingCrawler` to get an array back with OpenGraph data for the most common tags. If you need a different set of tags, you can build your own by utilizing the `CauseLabs\WebpageAnalyzer::getOpenGraphDetails()` method. This all depends on using Flamecore's Flink, of course.

### Example

```php
use FlameCore\Flink\Flink;
use CauseLabs\Crawler\AnalyzingCrawler;

$flink = new Flink();
$flink->addCrawler(new AnalyzingCrawler());

$info = $flink->fetch('https://www.youtube.com/watch?v=ZnHmskwqCCQ');

// $info = [
//     'type' => 'opengraph',
//     'site_name' => 'YouTube',
//     'title' => '-Yakety Sax- Music - YouTube',
//     'description' => 'Selfyexplanitory :P',
//     'image_url' => ...
//     'video_url' => ...
// ];

```

## License

MIT

## Contact

Contact Mark Horlbeck at mark@causelabs.com for contributions, questions, etc.
