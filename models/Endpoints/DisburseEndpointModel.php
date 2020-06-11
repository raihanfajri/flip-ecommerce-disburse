<?php

namespace models\Endpoints;

use models\Endpoints\Responses\DisburseResponseModel;

class DisburseEndpointModel extends BaseEndpointModel {

    protected $res_model = 'DisburseResponseModel';

    protected function baseUrl() {
        return env("BASE_URL_FLIP", "");
    }

    protected function pathUrl() {
        return "/disburse";
    }

    protected function setMethod() {
        return "POST";
    }
}