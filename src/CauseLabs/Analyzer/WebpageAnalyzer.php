<?php
/**
 * Facebook OpenGraph Webpage Analyzer
 * Copyright (C) 2016 HiDef, Inc. dba Causelabs.
 *
 * Permission to use, copy, modify, and/or distribute this software for
 * any purpose with or without fee is hereby granted, provided that the
 * above copyright notice and this permission notice appear in all copies.
 *
 * THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES
 * WITH REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE
 * FOR ANY SPECIAL, DIRECT, INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY
 * DAMAGES WHATSOEVER RESULTING FROM LOSS OF USE, DATA OR PROFITS, WHETHER
 * IN AN ACTION OF CONTRACT, NEGLIGENCE OR OTHER TORTIOUS ACTION, ARISING
 * OUT OF OR IN CONNECTION WITH THE USE OR PERFORMANCE OF THIS SOFTWARE.
 *
 * @package  CauseLabs\flink-facebook-meta-crawler
 * @version  1.0
 * @license  http://opensource.org/licenses/ISC ISC License
 */

namespace CauseLabs\Analyzer;

use FlameCore\Webtools\WebpageAnalyzer as Base;

/**
 * The WebpageAnalyzer class
 *
 * @author   Mark Horlbeck <mark@causelabs.com>
 */
class WebpageAnalyzer extends Base
{
    /**
     * Retrieves common OpenGraph tags from the target HTML
     *
     * @var $propertyMap array Array of key/value pairs for OpenGraph tags to
     *      retrieve and what to call them in the resulting array
     * @return array
     */
    public function getOpenGraphDetails(array $propertyMap = [])
    {
        $nodes = $this->html->findTags('meta');
        $propertyMap = [
            'og:site_name' => 'site_name',
            'og:url' => 'url',
            'og:title' => 'title',
            'og:image' => 'image_url',
            'og:description' => 'description',
            'og:video:url' => 'video_url',
        ];

        // Create a default result array
        $result = array_combine(
            array_values($propertyMap),
            array_fill(0, count($propertyMap), '')
        );

        foreach($nodes as $node) {
            $property = $node->getAttribute('property');
            if (in_array($property, array_keys($propertyMap))) {
                $result[ $propertyMap[$property] ] = $node->getAttribute('content');
            }
        }

        return $result;
    }
}
