<?php 

namespace controllers;

use helpers\Http\Request;
use response\BaseResponse;
use services\DisburseService;
use transformers\DisburseTransformer;

class DisburseController extends BaseController {

    public function create(Request $request) {
        $response = new BaseResponse();
        $params = $request->getBody();

        $disburse_created = DisburseService::create($params);

        $response->withData($disburse_created);
        $response->withDataTransformer(new DisburseTransformer());
        return $response->send();
    }

    public function detail(Request $request) {
        $response = new BaseResponse();

        $response->withView(__DIR__. "/../views/index.php");

        return $response->view();
    }

    public function list(Request $request) {
        $response = new BaseResponse();
        $params = $request->getBody();

        $disburse_list = DisburseService::list($params);

        $response->withData($disburse_list);
        $response->withDataTransformer(new DisburseTransformer());
        return $response->send();
    }

    public function update(Request $request) {
        $response = new BaseResponse();
        $params = $request->getBody();

        $disburse = DisburseService::update($params);

        $response->withData($disburse);
        $response->withDataTransformer(new DisburseTransformer());
        return $response->send();
    }
}