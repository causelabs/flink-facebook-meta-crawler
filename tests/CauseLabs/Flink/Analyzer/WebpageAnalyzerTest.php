<?php

use CauseLabs\Flink\Analyzer\WebpageAnalyzer;
use FlameCore\Webtools\HttpClient;

class WebpageAnalyzerTest extends PHPUnit_Framework_TestCase
{
    public function testCanFetchVideoMetaTagsFromYouTube()
    {
        $analyzer = new WebpageAnalyzer('https://www.youtube.com/watch?v=Ifj8dwuAzAQ');
        $info = $analyzer->getOpenGraphDetails();

        $keys = ['title', 'image_url', 'site_name', 'video_url', 'description', 'url'];

        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $info);
            $this->assertNotEmpty($info[$key]);
        }

        // Verify the video key has an embed in it (for YouTube).
        $this->assertRegExp('/embed/', $info['video_url']);
    }

    public function testCanFetchVideoMetaTagsFromVimeo()
    {
        $analyzer = new WebpageAnalyzer('https://vimeo.com/167054481');
        $info = $analyzer->getOpenGraphDetails();

        $keys = ['title', 'image_url', 'site_name', 'video_url', 'description', 'url'];

        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $info);
            $this->assertNotEmpty($info[$key]);
        }

        // Verify the video key has an embed in it (for YouTube).
        $this->assertRegExp('/player\.vimeo\.com/', $info['video_url']);
    }

    public function testCanFetchVideoMetaTagsFromVimeoSecond()
    {
        $analyzer = new WebpageAnalyzer('https://vimeo.com/39507943');
        $info = $analyzer->getOpenGraphDetails();

        $keys = ['title', 'image_url', 'site_name', 'description', 'url'];

        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $info);
            $this->assertNotEmpty($info[$key], $key . ' was empty ' . var_export($info, true));
        }

        $this->assertEmpty($info['video_url']);
    }

    public function testCanFetchNonvideoMetaTags()
    {
        $analyzer = new WebpageAnalyzer('http://www.vilcap.com');
        $info = $analyzer->getOpenGraphDetails();

        $keys = ['title', 'image_url', 'site_name', 'video_url', 'description', 'url'];
        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $info);
        }
        $this->assertEmpty($info['video_url']);
    }

    public function testCanFollowRedirectsWithCookiesToGetMetaTags()
    {
        $http = new HttpClient;
        $http->acceptCookies();

        $analyzer = new WebpageAnalyzer('http://www.nytimes.com/2016/12/13/business/an-edible-solution-to-extend-produces-shelf-life.html', $http);
        $info = $analyzer->getOpenGraphDetails();

        $keys = ['title', 'image_url', 'description', 'url'];
        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $info);
            $this->assertNotEmpty($info[$key], 'The ' . $key . ' was empty');
        }
    }
}
