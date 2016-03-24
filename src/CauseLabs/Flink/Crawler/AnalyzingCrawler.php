<?php
/**
 * Facebook OpenGraph Analyzing Crawler
 * Copyright (C) 2016 HiDef, Inc. dba Causelabs.
 *
 * Permission to use, copy, modify, and/or distribute this software for
 * any purpose with or without fee is hereby granted, provided that the
 * above copyright notice and this permission notice appear in all copies.
 *
 * @package  CauseLabs\flink-facebook-meta-crawler
 * @version  1.0
 * @license  http://opensource.org/licenses/MIT MIT License
 */

namespace CauseLabs\Flink\Crawler;

use CauseLabs\Flink\Analyzer\WebpageAnalyzer;
use FlameCore\Webtools\HttpClient;
use FlameCore\Flink\Crawler\AnalyzingCrawler as Base;

/**
 * This crawler uses a custom CauseLabs WebpageAnalyzer
 *
 * @author   Mark Horlbeck <mark@causelabs.com>
 */
class AnalyzingCrawler extends Base
{
    /**
     * {@inheritdoc}
     */
    public function crawl($url)
    {
        try {
            $http = new HttpClient($this->userAgent);
            $analyzer = new WebpageAnalyzer($url, $http);

            // Get OpenGraph tags
            $result = $analyzer->getOpenGraphDetails();
            $result['type'] = 'opengraph';

            if (empty($result['title'])) {
                $result['title'] = $analyzer->getTitle();
            }
            if (empty($result['description'])) {
                $result['description'] = $analyzer->getDescription();
            }
            if (empty($result['image_url'])) {
                $result['images'] = $analyzer->getImages();
            }

            return $result;
        }
        catch (\Exception $e) {
            return false;
        }
    }
}
