<?php

namespace models\Endpoints;

class DisbursementStatusEndpointModel extends BaseEndpointModel {

    protected $res_model = 'DisburseResponseModel';

    protected function baseUrl() {
        return env("BASE_URL_FLIP", "https://nextar.flip.id");
    }

    protected function pathUrl() {
        return "/disburse";
    }

    protected function setMethod() {
        return "GET";
    }
}