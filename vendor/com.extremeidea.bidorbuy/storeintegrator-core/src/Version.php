<?php /*
 * #%L
 * Bidorbuy http://www.bidorbuy.co.za
 * %%
 * Copyright (C) 2014 - 2018 Bidorbuy http://www.bidorbuy.co.za
 * %%
 * This software is the proprietary information of Bidorbuy.
 *
 * All Rights Reserved.
 * Modification, redistribution and use in source and binary forms, with or without
 * modification are not permitted without prior written approval by the copyright
 * holder.
 *
 * Vendor: EXTREME IDEA LLC http://www.extreme-idea.com
 * #L%
 */ ?>
<?php

namespace Com\ExtremeIdea\Bidorbuy\StoreIntegrator\Core;

/**
 * Class Version
 *
 * @package com\extremeidea\bidorbuy\storeintegrator\core
 * @SuppressWarnings(PHPMD.ShortVariable)
 */
class Version
{
    public static $platform = '';

    public static $id = 'bidorbuystoreintegrator';
    public static $version = '';
    public static $coreVersion = '3.0.2';
    public static $name = 'bidorbuy Store Integrator';
    public static $description = 'The bidorbuy store integrator allows you to get products from your online store 
    listed on bidorbuy quickly and easily.';

    public static $author = 'bidorbuy';
    public static $authorUrl = 'www.bidorbuy.co.za';

    /**
     * Get current plugin version
     *
     * @return mixed
     */
    public static function getLivePluginVersion()
    {
        $version = array();

        if (!empty(Version::$platform)) {
            $version[] = Version::$platform;
        }

        $version[] = trim(Version::$name . ' ' . Version::$version);
        $version[] = trim('core ' . Version::$coreVersion);

        return implode(', ', $version);
    }

    /**
     * Get environment options
     *
     * @return array
     */
    public static function getMetrics()
    {
        $value = array();

        $value['plugin.version'] = self::getLivePluginVersion();

        $value['php.version'] = self::getPhpVersion();
        $value['php.memory_limit'] = ini_get('memory_limit');
        $value['php.safe_mode'] = ini_get('safe_mode');
        $value['php.open_basedir'] = ini_get('open_basedir');
        $value['php.zlib.output_compression'] = ini_get('zlib.output_compression');
        $value['curl.version'] = curl_version(); // PHP 4 >= 4.0.2, PHP 5

        if (defined('WP_MEMORY_LIMIT')) {
            $value['wp.memory_limit'] = WP_MEMORY_LIMIT;
        }

        return $value;
    }

    /**
     * Get php version
     *
     * @return mixed
     */
    public static function getPhpVersion()
    {
        return phpversion();
    }

    /**
     * Get only version from string
     *
     * @param string $str string which contains plugin version
     *
     * @return string version
     */
    public static function getVersionFromString($str)
    {
        $pattern = '/\d+(?:\.\d+)+/';
        preg_match($pattern, $str, $version);

        return $version[0];
    }
}
