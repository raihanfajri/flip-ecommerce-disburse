<?php

namespace models\Endpoints;

class DisbursementStatusEndpointModel extends BaseEndpointModel {

    protected $res_model = 'DisburseResponseModel';

    protected function baseUrl() {
        return env("BASE_URL_FLIP", "localhost:3005");
    }

    protected function pathUrl() {
        return "/disburse/";
    }

    protected function setMethod() {
        return "POST";
    }
}