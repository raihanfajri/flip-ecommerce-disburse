<?php

namespace response;

use helpers\Constants\ErrorConstant;
use helpers\Constants\MessageConstant;

class BaseResponse {

    private $success;
    private $error_code;
    private $message;
    private $data;
    private $view;
    private $transformer;

    public function __construct() {
        $this->success = true;
        $this->error_code = ErrorConstant::ERROR_CODE_DEFAULT;
        $this->message = MessageConstant::MESSAGE_DEFAULT;
    }

    public function withError($error = false, $error_code = null, $code = 400) {
        $this->success = !$error;
        $this->error_code = $error_code;
        http_response_code($code);
    }

    public function withMessage($message = "") {
        $this->message = $message;
    }

    public function withData($data = []) {
        $this->data = $data;
    }

    public function withView($path_to_view) {
        $this->view = $path_to_view;
    }

    public function send() {
        $jsonBody = $this->transform();

        header('Content-type: application/json');
        echo json_encode($jsonBody);
        return;
    }

    private function transform() {
        $response = [
            'success' => $this->success,
            'error_code' => $this->error_code,
            'message' => $this->message,
        ];

        if (!empty($this->data)) {
            $response['data'] = $this->transformData();
        }

        return $response;
    }

    private function transformData() {
        if (empty($this->transformer)) {
            return $this->data;
        }

        if (isset($this->data[0])) {
            $newData = [];

            foreach ($this->data as $data) {
                $newData[] = ($this->transformer)->transform($data);
            }

        } else {
            $newData = ($this->transformer)->transform($this->data);
        }

        return $newData;
    }

    public function view() {
        $view = "";

        if (file_exists($this->view)) {
            $view = include $this->view;
        }
        else {
            $view = $this->view;
        }

        header('Content-type: text/html');
        return $view;
    }
}