<?php
/**
 * CauseLabs Flink
 * Copyright (c) 2016 HiDef, Inc. dba CauseLabs.
 *
 * Permission to use, copy, modify, and/or distribute this software for
 * any purpose with or without fee is hereby granted, provided that the
 * above copyright notice and this permission notice appear in all copies.
 *
 * @package  CauseLabs\Flink
 * @version  1.0
 * @license  http://opensource.org/licenses/MIT MIT License
 */

namespace CauseLabs\Flink;

use FlameCore\Flink\Flink as Base;

/**
 * The entry class of Flink, just providing an override
 *
 * @author   Mark Horlbeck <mark@causelabs.com>
 */
class Flink extends Base
{
    /**
     * Fetches information about the given URL.
     *
     * @param string $url The URL to crawl
     * @return array|false Returns the gathered information as array or FALSE if none of the crawlers was able to crawl the URL.
     */
    protected function doFetch($url)
    {
        $result = [];

        foreach ($this->crawlers as $crawler) {
            $data = $crawler->crawl($url);

            if ($data !== false) {
                $result = array_merge($result, $data);
            }
        }

        return count($result) > 0 ? $result : false;
    }
}
