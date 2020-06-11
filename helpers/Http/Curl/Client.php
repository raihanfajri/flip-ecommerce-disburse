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

    public function __construct($ssl = false) {
        $this->base_url = $this->baseUrl();
        $this->path = $this->pathUrl();
        $this->method = $this->setMethod();

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

    protected function baseUrl() {
        return "";
    }

    protected function pathUrl() {
        return "";
    }

    protected function setMethod() {
        return "GET";
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

        Log::info(json_encode($this->body));

        if ($this->method == "GET") {
            $result = $this->get($headers, $this->body);
        } else if ($this->method == "POST") {
            $result = $this->post($headers, $this->body);
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
            $url .= $this->q;
        }
 
        if (!empty($body)) {
            $url .= "&".http_build_query($body);
        }

        curl_setopt($ch, CURLOPT_URL, $url);            
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->ssl);
            
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 400);

        $server_output = curl_exec ($ch);

        return $server_output;
    }

    private function post($headers = [], $body = []) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->ssl);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_TIMEOUT, 400);

        $server_output = curl_exec ($ch);

        return $server_output;
    }

    protected function setResponse($result){}
}