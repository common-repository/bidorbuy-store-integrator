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

class GA
{
    const GA_URL = 'https://stats.g.doubleclick.net/__utm.gif'; //@nczz update v5.6.4dc

    private $data = array(
        'utmac' => null,
        'utmcc' => null,
        'utmcn' => null,
        'utmcr' => null,
        'utmcs' => null,
        'utmdt' => '-',
        'utmfl' => '-',
        'utme' => null,
        'utmni' => null,
        'utmhn' => null,
        'utmipc' => null,
        'utmipn' => null,
        'utmipr' => null,
        'utmiqt' => null,
        'utmiva' => null,
        'utmje' => 0,
        'utmn' => null,
        'utmp' => null,
        'utmr' => null,
        'utmsc' => '-',
        'utmvp' => '-',
        'utmsr' => '-',
        'utmt' => null,
        'utmtci' => null,
        'utmtco' => null,
        'utmtid' => null,
        'utmtrg' => null,
        'utmtsp' => null,
        'utmtst' => null,
        'utmtto' => null,
        'utmttx' => null,
        'utmul' => '-',
        'utmhid' => null,
        'utmht' => null,
        'utmwv' => '5.6.4dc'
    );

    private $tracking;
    private $request;


    /**
     * GA constructor.
     *
     * @param string $userAgent UA
     * @param string $domain    domain
     *
     * @return void
     */
    public function __construct($userAgent = null, $domain = null)
    {
        $this->request = new http\Request();

        $this->data['utmac'] = $userAgent;
        $this->data['utmhn'] = isset($domain) ? $domain : $this->request->server->get('SERVER_NAME');
        $this->data['utmp'] = $this->request->server->get('PHP_SELF');
        $this->data['utmn'] = rand(1000000000, 9999999999);
        $this->data['utmr'] = $this->request->server->get('HTTP_REFERER') ?: '';
        $this->data['utmcc'] = $this->createCookie();
        $this->data['utmhid'] = rand(1000000000, 9999999999);
        $this->data['utmht'] = time() * 1000;
    }

    /**
     * Create the GA callback url, aka the gif
     *
     * @return string
     */
    public function createGif()
    {
        $data = array();
        foreach ($this->data as $key => $item) {
            if ($item !== null) {
                $data[$key] = $item;
            }
        }

        return $this->tracking = self::GA_URL . '?' . http_build_query($data);
    }

    /**
     * Send tracking code/gif to GB
     *
     * @return mixed
     */
    public function send()
    {
        if (!isset($this->tracking)) {
            $this->createGif();
        }

        return $this->remoteCall();
    }

    /**
     * Use WP's HTTP class or CURL or fopen
     * @return mixed
     */
    private function remoteCall()
    {

        $wordPress = function_exists('wp_remote_head');
        $curlInit = function_exists('curl_init');

        if ($wordPress) {
            // Check if this is being used with WordPress, if so use it's excellent HTTP class
            $response = wp_remote_head($this->tracking);

            return $response;
        }

        if ($curlInit) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $this->tracking);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //@nczz Fixed HTTPS GET method
            curl_setopt($curl, CURLOPT_TIMEOUT, 10);
            curl_exec($curl);
            curl_close($curl);

            return $this;
        }

        $handle = fopen($this->tracking, "r");
        fclose($handle);

        return $this;
    }

    /**
     * Reset Defaults
     *
     * @return null
     */
    public function reset()
    {
        $data = array(
            'utmac' => null,
            'utmcc' => $this->createCookie(),
            'utmcn' => null,
            'utmcr' => null,
            'utmcs' => null,
            'utmdt' => '-',
            'utmfl' => '-',
            'utme' => null,
            'utmni' => null,
            'utmipc' => null,
            'utmipn' => null,
            'utmipr' => null,
            'utmiqt' => null,
            'utmiva' => null,
            'utmje' => '0',
            'utmn' => rand(1000000000, 9999999999),
            'utmp' => $this->request->server->get('PHP_SELF'),
            'utmr' => $this->request->server->get('HTTP_REFERER') ?: '',
            'utmsc' => '-',
            'utmsr' => '-',
            'utmt' => null,
            'utmtci' => null,
            'utmtco' => null,
            'utmtid' => null,
            'utmtrg' => null,
            'utmtsp' => null,
            'utmtst' => null,
            'utmtto' => null,
            'utmttx' => null,
            'utmul' => 'php',
            'utmht' => time() * 1000,
            'utmwv' => '5.6.4dc'
        );
        $this->tracking = null;

        return $this->data = $data;
    }

    /**
     * Create unique cookie
     * @return string
     */
    private function createCookie()
    {
        $rand_id = rand(10000000, 99999999);
        $random = rand(1000000000, 2147483647);
        $var = '-';
        $time = time();
        $cookie = '';
        $cookie .= '__utma=' . $rand_id . '.' . $random . '.' . $time . '.' . $time . '.' . $time . '.2;+';
        $cookie .= '__utmb=' . $rand_id . ';+';
        $cookie .= '__utmc=' . $rand_id . ';+';
        $cookie .= '__utmz=' . $rand_id . '.' . $time . '.2.2.utmccn=(direct)|utmcsr=(direct)|utmcmd=(none);+';
        $cookie .= '__utmv=' . $rand_id . '.' . $var . ';';

        return $cookie;
    }

    ////////////
    // Params //
    ////////////


    /////////////
    // Product //
    /////////////

    /**
     * Set Product Code
     *
     * @param string $var value
     *
     * @return null
     */
    public function setProductCode($var = null)
    {
        return $this->data['utmipc'] = $var;
    }

    /**
     * Set Product Name
     *
     * @param string $var value
     *
     * @return null
     */
    public function setProductName($var = null)
    {
        return $this->data['utmipn'] = $var;
    }

    /**
     * Set Unit Price
     *
     * @param string $var value
     *
     * @return null
     */
    public function setUnitPrice($var = null)
    {
        return $this->data['utmipr'] = $var;
    }

    /**
     * Set Qty
     *
     * @param string $var value
     *
     * @return null
     */
    public function setQty($var = null)
    {
        return $this->data['utmiqt'] = $var;
    }

    /**
     * Set Variation
     *
     * @param string $var value
     *
     * @return null
     */
    public function setVariation($var = null)
    {
        return $this->data['utmiva'] = $var;
    }

    //////////
    // Misc //
    //////////

    /**
     * Set Java
     *
     * @param string $var value
     *
     * @return null
     */
    public function setJava($var = null)
    {
        return $this->data['utmje'] = $var;
    }

    /**
     * Set Encode Type
     *
     * @param string $var value
     *
     * @return null
     */
    public function setEncodeType($var = null)
    {
        return $this->data['utmcs'] = $var;
    }

    /**
     * Set Flash Version
     *
     * @param string $var value
     *
     * @return null
     */
    public function setFlashVersion($var = null)
    {
        return $this->data['utmfl'] = $var;
    }

    /**
     * Set Host
     *
     * @param string $var value
     *
     * @return null
     */
    public function setHost($var = null)
    {
        return $this->data['utmhn'] = $var;
    }

    /**
     * Set Screen Dept
     *
     * @param string $var value
     *
     * @return null
     */
    public function setScreenDepth($var = null)
    {
        return $this->data['utmsc'] = $var;
    }


    /**
     * Set Screen Resolution
     *
     * @param string $var value
     *
     * @return null
     */
    public function setScreenResolution($var = null)
    {
        return $this->data['utmsr'] = $var;
    }

    /**
     * Set Language
     *
     * @param string $var value
     *
     * @return null
     */
    public function setLang($var = null)
    {
        return $this->data['utmul'] = $var;
    }

    /**
     * Set GA version
     *
     * @param string $var value
     *
     * @return null
     */
    public function setGaVersion($var = null)
    {
        return $this->data['utmwv'] = isset($var) ? $var : $this->data['utmwv'];
    }

    //////////
    // Page //
    //////////

    /**
     * Set Page
     *
     * @param string $var value
     *
     * @return null
     */
    public function setPage($var = null)
    {
        return $this->data['utmp'] = $var;
    }

    /**
     * Set Page Title
     *
     * @param string $var value
     *
     * @return null
     */
    public function setPageTitle($var = null)
    {
        return $this->data['utmdt'] = $var;
    }

    /**
     * Set Campaign
     *
     * @param string $var value
     *
     * @return null
     */
    public function setCampaign($var = null)
    {
        return $this->data['utmcn'] = $var;
    }

    /**
     * Clone Campaign
     *
     * @param string $var value
     *
     * @return null
     */
    public function cloneCampaign($var = null)
    {
        return $this->data['utmcr'] = $var;
    }

    /**
     * Set Referal
     *
     * @param string $var value
     *
     * @return null
     */
    public function setReferal($var = null)
    {
        return $this->data['utmr'] = $var;
    }

    ////////////
    // Events //
    ////////////

    /**
     * Set Event.
     *
     * @param string $category           category
     * @param string $action             action
     * @param string $label              label
     * @param string $value              value
     * @param null   $opt_noninteraction flag
     *
     * @return string
     */
    public function setEvent($category, $action, $label = '', $value = '', $opt_noninteraction = null)
    {
        $event_category = (string)$category;
        $event_action = (string)$action;

        $event_string = '5(' . $event_category . '*' . $event_action;

        $event_string .= !empty($label) ? '*' . ((string)$label) . ')' : ')';

        if (!empty($value)) {
            $event_string .= '(' . ((int)intval($value)) . ')';
        }

        if ($opt_noninteraction) {
            $this->data['utmni'] = '1';
        }

        $this->data['utmt'] = 'event';

        return $this->data['utme'] = $event_string;
    }

    ///////////
    // Order //
    ///////////

    /**
     * Set Order Id
     *
     * @param string $var value
     *
     * @return null
     */
    public function setOrderId($var = null)
    {
        return $this->data['utmtid'] = $var;
    }

    /**
     * Set Billing City
     *
     * @param string $var value
     *
     * @return null
     */
    public function setBillingCity($var = null)
    {
        return $this->data['utmtci'] = $var;
    }

    /**
     * Set Billing Country
     *
     * @param string $var value
     *
     * @return null
     */
    public function setBillingCountry($var = null)
    {
        return $this->data['utmtco'] = $var;
    }

    /**
     * Set Billing Region
     *
     * @param string $var value
     *
     * @return null
     */
    public function setBillingRegion($var = null)
    {
        return $this->data['utmtrg'] = $var;
    }

    /**
     * Set Shipping Coast
     *
     * @param string $var value
     *
     * @return null
     */
    public function setShippingCost($var = null)
    {
        return $this->data['utmtsp'] = $var;
    }

    /**
     * Set Affiliate
     *
     * @param string $var value
     *
     * @return null
     */
    public function setAffiliate($var = null)
    {
        return $this->data['utmtst'] = $var;
    }

    /**
     * Set Total
     *
     * @param string $var value
     *
     * @return null
     */
    public function setTotal($var = null)
    {
        return $this->data['utmtto'] = $var;
    }

    /**
     * Set Taxes
     *
     * @param string $var value
     *
     * @return null
     */
    public function setTaxes($var = null)
    {
        return $this->data['utmttx'] = $var;
    }

    ////////////////////////
    // Ecommerce Tracking //
    ////////////////////////

    private static $requestsForThisSession = 0;

    /**
     * Create and send a transaction object
     *
     * Parameter order from
     * https://developers.google.com/analytics/devguides/collection/gajs/gaTrackingEcommerce
     */
    public function sendTransaction($transaction_id, $affiliation, $total, $tax, $shipping, $city, $region, $country)
    {
        $this->data['utmvw'] = '5.6.4dc';
        $this->data['utms'] = ++self::$requestsForThisSession;
        $this->data['utmt'] = 'tran';
        $this->data['utmtid'] = $transaction_id;
        $this->data['utmtst'] = $affiliation;
        $this->data['utmtto'] = $total;
        $this->data['utmttx'] = $tax;
        $this->data['utmtsp'] = $shipping;
        $this->data['utmtci'] = $city;
        $this->data['utmtrg'] = $region;
        $this->data['utmtco'] = $country;
        $this->data['utmcs'] = 'UTF-8';

        $this->send();
        $this->reset();

        return $this;
    }

    /**
     * Add item to the created $transaction_id
     *
     * Parameter order from
     * https://developers.google.com/analytics/devguides/collection/gajs/gaTrackingEcommerce
     */
    public function sendItem($transaction_id, $sku, $product_name, $variation, $unit_price, $quantity)
    {
        $this->data['utmvw'] = '5.6.4dc';
        $this->data['utms'] = ++self::$requestsForThisSession;
        $this->data['utmt'] = 'item';
        $this->data['utmtid'] = $transaction_id;
        $this->data['utmipc'] = $sku;
        $this->data['utmipn'] = $product_name;
        $this->data['utmiva'] = $variation;
        $this->data['utmipr'] = $unit_price;
        $this->data['utmiqt'] = $quantity;
        $this->data['utmcs'] = 'UTF-8';

        $this->send();
        $this->reset();

        return $this;
    }

    public function getData()
    {
        return $this->data;
    }
}


/**
 * Instantiate new class and push data
 *
 * @param  string $userAgent The UA string of the GA account to use
 * @param  string $domain    domain
 * @param  string $page      the page to set the pageview
 *
 * @return null
 */
function ssga_track($userAgent = null, $domain = null, $page = null)
{
    $ssga = new GA($userAgent, $domain);
    $ssga->setPage($page);
    $ssga->send();
    $ssga->reset();

    return $ssga;
}
