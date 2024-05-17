<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\API;

use Exception;

/**
 * Description of Connection
 *
 * @author Mateusz Pawłowski <mateusz.pa@modulesgarden.com>
 */
class Connection
{

    /**
     * CURL object
     * 
     * @var object
     */
    private $curl;

    /**
     * EasyDCIM url
     * 
     * @var string
     */
    private $url;

    /*
     * EasyDCIM API Key
     * 
     * @var string
     */
    private $apiKey;

    /**
     * Params to Get Method
     * 
     * @var array
     */
    protected $getParams;

    /**
     * Params to Logs
     * 
     * @var array
     */
    protected $params;

    /**
     * Easy DCIM set Hostname, Api Key and prepare CURL
     * 
     * @param string $apiURL, $apiKey
     */
    public function __construct($apiURL, $apiKey)
    {
        $this->url    = $apiURL . '/api/v2/';
        $this->apiKey = $apiKey;
        $this->prepare();
    }

    /**
     * prepare CURL 
     */
    private function prepare()
    {
        $this->curl = curl_init();

        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($this->curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($this->curl, CURLOPT_CONNECTTIMEOUT, 10);
        $this->setHeader();
    }

    private function setHeader()
    {
        $header = $this->preapreHeader();
        curl_setopt($this->curl, CURLOPT_HEADER, 0);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $header);
    }

    /**
     * set CURL header
     * 
     * @return array
     */
    private function preapreHeader()
    {
        return [
            'apikey: ' . $this->apiKey,
        ];
    }

    /**
     * set Curl method POST
     * 
     * @return object
     */
    public function post($params = null)
    {
        curl_setopt($this->curl, CURLOPT_POST, true);
        if (!is_null($params))
        {
            $this->params = $params;
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, http_build_query($params));
        }else
        {
            $this->params = [];
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, http_build_query($this->params));
        }
        return $this;
    }

    /**
     * set Curl method PUT
     * 
     * @return object
     */
    public function put($params = null)
    {
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, "PUT");
        if (!is_null($params))
        {
            $this->params = $params;
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, http_build_query($params));
        }
        return $this;
    }

    /**
     * set Curl method GET
     * 
     * @return object
     */
    public function get($params = null)
    {
        if (!is_null($params))
        {
            $this->params    = $params;
            $this->getParams = $params;
        }
        return $this;
    }

    /**
     * set Curl method DELETE
     * 
     * @return object
     */
    public function delete()
    {
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        return $this;
    }

    /**
     * set Curl URL
     */
    private function setURL()
    {
        if ($this->getParams)
        {
            $this->url .= '?' . http_build_query($this->getParams);
        }
        curl_setopt($this->curl, CURLOPT_URL, $this->url);
    }

    /**
     * execute CURL
     * @param string $method
     * @return JSON object
     */
    public function execut($method)
    {
        $this->url .= $method;
        $this->setURL();
        $result    = curl_exec($this->curl);
        return $this->parseResponse($result);
    }

    /**
     * check HTTP code in CURL response
     * @return int
     */
    private function checkHttpCode()
    {
        return curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
    }

    /**
     * validate CURL response
     * @param CURL object $response
     * @return JSON object
     */
    private function parseResponse($response)
    {
        $httpCode = $this->checkHttpCode();

        //close CURL connection;
        $error_msg = curl_error($this->curl);

        curl_close($this->curl);

//        $this->saveLogs($response);
        $response = json_decode($response);

        if (empty($response->status))
        {
            throw new Exception('ERROR: Connection problem. HTTP Code: ' . $httpCode);
        }
        if ($response === false)
        {
            throw new Exception('API ERROR: Connection problem.');
        }
        if (json_last_error() !== 0)
        {
            throw new Exception('API ERROR: ' . json_last_error_msg());
        }
        if ($httpCode !== 200 || $response->status == "error")
        {
            return $response;
            throw new Exception($this->prepareErrorString($response, $httpCode));
        }

        if (str_contains($this->url, '/console')) {
            return $response;
        }

        return $response->result ?: $response->moduleInfo;
    }

    private function saveLogs($response)
    {
        $request = [
            'url'    => $this->url,
            'params' => $this->params
        ];
      
    }

    /**
     * remove unwanted string from error string
     * @param string $responseString
     * @return string
     */
    private function removeUnwantedString($responseString)
    {
        $unwatedStrings = [
            'Error occurred.',
            'Please contact the administrator..'
        ];
        foreach ($unwatedStrings as $toRemove)
        {
            $responseString = str_replace($toRemove, "", $responseString);
        }
        return $responseString;
    }

    /**
     * prepare error string
     * @param CURL object $response
     * @return string
     */
    private function prepareErrorString($response, $httpCode)
    {
        $errors = ($response->errors) ? $this->parseObjectToString($response->errors) : '';
        return $this->removeUnwantedString($response->message . '. ' . $errors);
    }

    /**
     * parse object to string
     * @param object $response
     * @return string $errorMessge
     */
    private function parseObjectToString($response)
    {
        $errorMessge = [];
        foreach ($response as $key => $value)
        {
            $key           = (is_numeric($key)) ? '' : ucfirst($key) . ' - ';
            $value         = (is_array($value)) ? implode(', ', $value) : $value;
            $errorMessge[] = $key . $value;
        }
        return implode(', ', $errorMessge);
    }

}
