<?php

namespace models\Endpoints;

class DisburseEndpointModel extends BaseEndpointModel {

    protected $res_model = 'DisburseResponseModel';

    protected function baseUrl($url = "") {
        return env("BASE_URL_FLIP", "https://nextar.flip.id");
    }

    protected function pathUrl($url = "") {
        return "/disburse";
    }

    protected function setMethod($method = "") {
        return "POST";
    }
}