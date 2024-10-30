<?php
/**
 * Copyright (c) 2014, 2015, 2016 Bidorbuy http://www.bidorbuy.co.za
 * This software is the proprietary information of Bidorbuy.
 *
 * All Rights Reserved.
 * Modification, redistribution and use in source and binary forms, with or without modification
 * are not permitted without prior written approval by the copyright holder.
 *
 * Vendor: EXTREME IDEA LLC http://www.extreme-idea.com
 */

namespace Com\ExtremeIdea\Bidorbuy\StoreIntegrator\WooCommerce;

// phpcs:disable PSR1.Files.SideEffects
if (!defined('ABSPATH')) {
    exit;// Exit if accessed directly
}
// phpcs:enable PSR1.Files.SideEffects

/**
 * Class WoocommerceCurrencyConverter.
 *
 * @package com\extremeidea\bidorbuy\storeintegrator\woocommerce
 */
class WoocommerceCurrencyConverter
{
    const WOOCOMMERCE_CURRENCY_CONVERTER_FILE = 'woocommerce-currency-converter/woocommerce-currency-converter.php';

    protected $plugin;

    /**
     * WoocommerceCurrencyConverter constructor.
     *
     * @return self
     */
    public function __construct(BidorbuyStoreIntegrator $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * Check plugin status.
     *
     * @return mixed
     */
    public function isPluginActive()
    {
        $file = $this->getPluginFile();
        return is_plugin_active($file);
    }

    /**
     * Get plugin file
     *
     * @return string
     */
    public function getPluginFile()
    {
        return WP_PLUGIN_DIR . '/' . static::WOOCOMMERCE_CURRENCY_CONVERTER_FILE;
    }

    /**
     * Get Currencies.
     *
     * @return array
     */
    public function getCurrencies()
    {
        if ($this->isPluginActive()) {
            if (!function_exists('wccc_get_option')) {
                $this->plugin->core->logError('Function wccc_get_option is undefined.');
            }

            $out = array();
            $currencies = wccc_get_option('currency_list');

            if (!is_array($currencies)) {
                $this->plugin->core->logError('Something wrong with WCCC.');
            }

            foreach ($currencies as $currency) {
                $out[] = $currency['code'];
            }
            return $out;
        }
        return array();
    }

    /**
     * Convert price.
     *
     * @param mixed $price price
     *
     * @return mixed
     */
    public function convertPrice($price)
    {
        $price = (double)$price;
        if ($this->isPluginActive()) {
            if (!function_exists('wccc_convert_price')) {
                $this->plugin->core->logError('Function wccc_convert_price is undefined.');
            }
            return wccc_convert_price($price);
        }
        return $price;
    }

    /**
     * Set Cookie param.
     *
     * @param $currency
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function setCurrencyIntoCookie($currency)
    {
        if (!$this->isPluginActive()) {
            return;
        }
        if (!empty($currency)) {
            $_COOKIE['wccc-currency'] = $currency;
            return;
        }
        unset($_COOKIE['wccc-currency']);
    }
}
