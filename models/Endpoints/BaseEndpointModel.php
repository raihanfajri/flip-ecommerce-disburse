<?php

namespace models\Endpoints;

use helpers\Http\Curl\Client;

class BaseEndpointModel extends Client {

    protected $res_model;

    protected function setResponse($result) {
        $body = json_decode($result, true);

        $modelName = "\models\Endpoints\Responses\\" . $this->res_model;

        if (class_exists($modelName)) {
            $model = new $modelName();

            if (is_iterable($body)) {
                foreach ($body as $key => $value) {
                    if (property_exists($model, $key)) {
                        $model->$key = $value;
                    }
                }
            }
            
            $this->response = $model;
        }
    }
}