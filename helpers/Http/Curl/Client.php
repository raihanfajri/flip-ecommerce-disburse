<?php

namespace helpers\Http\Curl;

use helpers\Log;

class Client {

    public $headers = [];
    public $body;
    protected $url;
    public $ssl;
    protected $method;
    protected $base_url = "";
    protected $path = "";
    protected $q = "";
    protected $response;

    public function __construct($base_url = "", $path = "", $method = "GET", $ssl = false) {
        $this->base_url = $this->baseUrl($base_url);
        $this->path = $this->pathUrl($path);
        $this->method = $this->setMethod($method);

        $this->headers['Content-type'] = 'application/json';
        $this->ssl = $ssl;
        $this->url = $this->base_url . $this->path;
    }

    public function intialize($body = []) {
        $this->body = $body;
    }

    public function setHeader($key, $value) {
        $this->headers[$key] = $value;
    }

    protected function baseUrl($base_url = "") {
        return $base_url;
    }

    protected function pathUrl($path = "") {
        return $path;
    }

    protected function setMethod($method = "GET") {
        return $method;
    }

    public function setQParams($q) {
        $this->q = $q;
    }

    public function respBody(){
        return $this->response;
    }

    public function callEndpoint() {
        $result = "";

        $headers = $this->buildHeaders();

        Log::info(json_encode($headers));
        Log::info(json_encode($this->body));

        if ($this->method == "GET") {
            $result = $this->get($headers, $this->body);
        } else if ($this->method == "POST") {
            $result = $this->post($headers, $this->body);
        } else if ($this->method == "PATCH") {
            $result = $this->patch($headers, $this->body);
        }

        Log::info($result);

        $this->setResponse($result);
    }

    private function buildHeaders() {
        $headers = [];

        foreach ($this->headers as $key => $value) {
            $headers[] = "$key: $value";
        }

        return $headers;
    }

    private function get($headers = [], $body = []) {
        $ch = curl_init();

        $url = $this->url;
        if (!empty($this->q)) {
            $url .= "/".$this->q;
        }
 
        if (!empty($body)) {
            $url .= "?".http_build_query($body);
        }
        Log::info($url);
        curl_setopt($ch, CURLOPT_URL, $url);            
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->ssl);
            
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 400);

        $server_output = curl_exec ($ch);
        Log::info($server_output);
        return $server_output;
    }

    private function post($headers = [], $body = []) {
        $encoded_body = "";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        switch ($this->headers['Content-type']) {
            case 'application/json':
                $encoded_body = json_encode($body);
                break;
            case 'application/x-www-form-urlencoded':
                $encoded_body = http_build_query($body);
                break;
        }

        curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded_body);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->ssl);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_TIMEOUT, 400);

        $server_output = curl_exec ($ch);

        return $server_output;
    }

    private function patch($headers = [], $body = []) {
        $encoded_body = "";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        switch ($this->headers['Content-type']) {
            case 'application/json':
                $encoded_body = json_encode($body);
                break;
            case 'application/x-www-form-urlencoded':
                $encoded_body = http_build_query($body);
                break;
        }

        curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded_body);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->ssl);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_TIMEOUT, 400);

        $server_output = curl_exec ($ch);

        return $server_output;
    }

    protected function setResponse($result){
        $this->response = $result;
    }
}