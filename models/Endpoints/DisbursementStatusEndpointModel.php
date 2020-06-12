<?php

namespace models\Endpoints;

class DisbursementStatusEndpointModel extends BaseEndpointModel {

    protected $res_model = 'DisburseResponseModel';

    protected function baseUrl($url = "") {
        return env("BASE_URL_FLIP", "https://nextar.flip.id");
    }

    protected function pathUrl($url = "") {
        return "/disburse";
    }

    protected function setMethod($method = "") {
        return "GET";
    }
}