<?php

/**
 * @see    https://github.com/barbushin/multirequest
 * @author Barbushin Sergey http://linkedin.com/in/barbushin
 *
 */

namespace com\extremeidea\bidorbuy\storeintegrator\php\multirequest;

use com\extremeidea\bidorbuy\storeintegrator\php\multirequest\errors\MultiRequestException;
use com\extremeidea\bidorbuy\storeintegrator\php\multirequest\errors\MultiRequestFailedResponse;

/**
 * Class MultiRequestRequest.
 *
 * @package com\extremeidea\bidorbuy\storeintegrator\multirequest
 */
class MultiRequestRequest
{

    /**
     * @var MultiRequestCallbacks
     */
    protected $callbacks;

    protected $url;
    protected $realUrl;
    protected $curlHandle;
    protected $headers = array('Expect:');
    protected $getData;
    protected $postData;
    protected $curlInfo;
    protected $serverEncoding = 'utf-8';
    protected $defaultClientEncoding = 'utf-8';
    protected $responseHeaders;
    protected $responseHeadersList = array();
    protected $responseContent;
    protected $error;

    //      CURLOPT_FOLLOWLOCATION cannot be activated when safe_mode is enabled or an open_basedir is set
    //      http://www.php.net/manual/en/function.curl-setopt.php#95027

    protected $curlOptions = array(
        CURLOPT_TIMEOUT => 3600,
        CURLOPT_CONNECTTIMEOUT => 200,
        CURLOPT_FAILONERROR => true,
        CURLOPT_FRESH_CONNECT => true,
        CURLOPT_HEADER => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_FORBID_REUSE => true,
        CURLOPT_VERBOSE => true,
        CURLOPT_MAXCONNECTS => 1
    );

    protected static $clientsEncodings;

    /**
     * MultiRequestRequest constructor.
     *
     * @param string $url url
     *
     * @return self
     */
    public function __construct($url)
    {
        $this->callbacks = new MultiRequestCallbacks();
        $this->url = $url;
        $this->setUrl($url);

        if (ini_get('safe_mode') != 'Off' || ini_get('safe_mode') != false) {
            $this->curlOptions[CURLOPT_FOLLOWLOCATION] = false;
        }

        if (ini_get('open_basedir') != '') {
            $this->curlOptions[CURLOPT_FOLLOWLOCATION] = false;
        }
    }

    /**
     * Set url
     *
     * @param string $url url
     *
     * @return void
     */
    public function setUrl($url)
    {
        $this->setCurlOption(CURLOPT_URL, $url);
    }

    /**
     * Get domain
     *
     * @return mixed
     */
    public function getDomain()
    {
        return parse_url($this->url, PHP_URL_HOST);
    }

    /**
     * Get base url
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return parse_url($this->url, PHP_URL_SCHEME) . '://' . $this->getDomain();
    }

    /**
     * Get real url
     *
     * @return mixed
     */
    public function getRealUrl()
    {
        return $this->realUrl;
    }

    /**
     * Set server encoding
     *
     * @param string $serverEncoding Encoding
     *
     * @return void
     */
    public function setServerEncoding($serverEncoding)
    {
        $this->serverEncoding = $serverEncoding;
    }

    /**
     * Set client encoding
     *
     * @param string $clientEncoding Encoding
     *
     * @return void
     */
    public function setDefaultClientEncoding($clientEncoding)
    {
        $this->defaultClientEncoding = $clientEncoding;
    }

    public function addHeader($header)
    {
        $this->headers[] = $header;
    }

    public function addHeaders($headers)
    {
        $this->headers = array_merge($this->headers, $headers);
    }

    public function setGetData($getData)
    {
        $this->getData = $getData;
    }

    public function setPostData($postData)
    {
        $this->postData = $postData;
    }

    public function getPostData()
    {
        return $this->postData;
    }

    public function setPostVar($var, $value)
    {
        $this->postData[$var] = $value;
    }

    public function setCurlOption($optionName, $value)
    {
        if ($optionName == CURLOPT_URL) {
            $this->realUrl = $value;
        }
        $this->curlOptions[$optionName] = $value;
    }

    public function getCurlOptions()
    {
        return $this->curlOptions;
    }

    public function addCurlOptions(array $options)
    {
        foreach ($options as $option => $value) {
            $this->curlOptions[$option] = $value;
        }
    }

    public function setCookiesStorage($filepath)
    {
        $this->curlOptions[CURLOPT_COOKIEJAR] = $filepath;
        $this->curlOptions[CURLOPT_COOKIEFILE] = $filepath;
    }

    protected function initCurlHandle()
    {
        $curlHandle = curl_init($this->url);
        $curlOptions = $this->curlOptions;
        $curlOptions[CURLINFO_HEADER_OUT] = true;

        if ($this->headers) {
            $curlOptions[CURLOPT_HTTPHEADER] = $this->headers;
        }
        if ($this->postData) {
            $postData = $this->postData;

            $clientEncoding =
                isset(self::$clientsEncodings[$this->getDomain()]) ? self::$clientsEncodings[$this->getDomain()]
                    : $this->defaultClientEncoding;
            if ($clientEncoding != $this->serverEncoding) {
                if (is_array($postData)) {
                    array_walk_recursive(
                        $postData,
                        create_function('&$value', '$value = mb_convert_encoding($value, "'
                            . $clientEncoding . '", "' . $this->serverEncoding . '");')
                    );
                } else {
                    $postData = mb_convert_encoding($postData, $clientEncoding, $this->serverEncoding);
                }
            }
            $curlOptions[CURLOPT_POST] = true;
            $curlOptions[CURLOPT_POSTFIELDS] = $postData;
            $this->addHeader('Content-Type:	application/x-www-form-urlencoded; charset=' . $clientEncoding);
        }

        curl_setopt_array($curlHandle, $curlOptions);
        return $curlHandle;
    }

    protected function detectClientCharset()
    {
        if (isset($this->curlInfo['content_type'])
            && preg_match('/charset\s*=\s*([\w\-\d]+)/i', $this->curlInfo['content_type'], $m)) {
            return strtolower($m[1]);
        }
        return $this->defaultClientEncoding;
    }

    public function getId()
    {
        return self::getRequestIdByCurlHandle($this->curlHandle);
    }

    public static function getRequestIdByCurlHandle($curlHandle)
    {
        return substr((string)$curlHandle, 13);
    }

    public function getUrl()
    {
        return $this->url . ($this->getData ? (strstr($this->url, '?') === false ? '?' : '&')
                . http_build_query($this->getData) : '');
    }

    public function reInitCurlHandle()
    {
        $this->curlHandle = $this->initCurlHandle();
    }

    public function getCurlHandle($new = false)
    {
        if (!$this->curlHandle || $new) {
            $this->reInitCurlHandle();
        }
        return $this->curlHandle;
    }

    public function getTime()
    {
        return $this->curlInfo['total_time'];
    }

    public function getCode()
    {
        return $this->curlInfo['http_code'];
    }

    public function handleCurlResult()
    {
        $curlHandle = $this->getCurlHandle();
        $this->curlInfo = curl_getinfo($curlHandle);
        $this->error = curl_error($curlHandle);
        $responseData = curl_multi_getcontent($curlHandle);

        $this->responseHeaders = substr($responseData, 0, curl_getinfo($curlHandle, CURLINFO_HEADER_SIZE));
        $this->responseContent = substr($responseData, curl_getinfo($curlHandle, CURLINFO_HEADER_SIZE));
        $clientEncoding = $this->detectClientCharset();
        if ($clientEncoding && $clientEncoding != $this->serverEncoding) {
            self::$clientsEncodings[$this->getDomain()] = $clientEncoding;
            $this->responseContent =
                mb_convert_encoding($this->responseContent, $this->serverEncoding, $clientEncoding);
        }
        if ($curlHandle && is_resource($curlHandle)) {
            curl_close($curlHandle);
        }
    }

    public function notifyIsComplete(MultiRequestHandler $handler)
    {
        $this->callbacks->onComplete($this, $handler);

        $failException = $this->getFailException();
        if ($failException) {
            $this->notifyIsFailed($failException, $handler);
        } else {
            $this->notifyIsSuccess($handler);
        }
    }

    public function onComplete($callback)
    {
        $this->callbacks->add(__FUNCTION__, $callback);
        return $this;
    }

    public function onFailed($callback)
    {
        $this->callbacks->add(__FUNCTION__, $callback);
        return $this;
    }

    public function onSuccess($callback)
    {
        $this->callbacks->add(__FUNCTION__, $callback);
        return $this;
    }

    public function notifyIsSuccess(MultiRequestHandler $handler)
    {
        $this->callbacks->onSuccess($this, $handler);
    }

    public function notifyIsFailed(MultiRequestException $exception, MultiRequestHandler $handler)
    {
        $this->callbacks->onFailed($this, $exception, $handler);
    }

    public function getFailException()
    {
        if ($this->error) {
            return new MultiRequestFailedResponse('Response failed with error: ' . $this->error);
        } else {
            $responseCode = $this->getCode();
            $successCodes = array(
                200,
                204
            );
            if (!in_array($responseCode, $successCodes)) {
                return new MultiRequestFailedResponse('Response failed with code "' . $responseCode . '"');
            }
        }
    }

    public function get()
    {
        curl_exec($this->getCurlHandle(true));

        $this->handleCurlResult();
        return $this->getContent();
    }

    public function __toString()
    {
        return $this->get();
    }

    public function getCurlInfo()
    {
        return $this->curlInfo;
    }

    /**
     * Parse headers
     *
     * @param string $headersString headers
     * @param bool   $associative   flag
     *
     * @return array
     */
    protected function parseHeaders($headersString, $associative = false)
    {
        $headers = array();
        preg_match_all('/\n\s*((.*?)\s*\:\s*(.*?))[\r\n]/', $headersString, $m);
        foreach ($m[1] as $i => $header) {
            if ($associative) {
                $headers[$m[2][$i]] = $m[3][$i];
            } else {
                $headers[] = $header;
            }
        }
        return $headers;
    }

    /**
     * Get cookies.
     *
     * @param null $deleted flag
     *
     * @return array
     */
    public function getResponseCookies(&$deleted = null)
    {
        $cookies = array();
        $deleted = array();
        foreach ($this->getResponseHeaders() as $header) {
            if (preg_match('/^Set-Cookie:\s*(.*?)=(.*?);/i', $header, $m)) {
                if ($m[2] == 'deleted') {
                    $deleted[] = $m[1];
                } else {
                    $cookies[$m[1]] = $m[2];
                }
            }
        }
        return $cookies;
    }

    /**
     * Get request headers.
     *
     * @return array
     */
    public function getRequestHeaders()
    {
        return isset($this->curlInfo['request_header']) ? $this->parseHeaders($this->curlInfo['request_header'])
            : $this->parseHeaders(implode("\n", $this->headers));
    }

    /**
     * Get response headers.
     *
     * @param bool $assoc flag
     *
     * @return array
     */
    public function getResponseHeaders($assoc = false)
    {
        return $this->parseHeaders($this->responseHeaders, $assoc);
    }

    /**
     * Get content
     *
     * @return mixed
     */
    public function getContent()
    {
        return $this->responseContent;
    }
}
