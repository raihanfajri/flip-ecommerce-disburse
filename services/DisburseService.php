<?php

namespace services;

use helpers\Constants\DisburseConstant;
use helpers\Constants\ErrorConstant;
use helpers\Constants\MessageConstant;
use helpers\Exception\BaseException;
use helpers\Log;
use models\Databases\DisburseDatabaseModel;
use models\Endpoints\DisburseEndpointModel;
use models\Endpoints\DisbursementStatusEndpointModel;

class DisburseService extends BaseService {

    public static function create($params) {
        $failed_fields = self::validate($params, [
            "bank_code" => "required",
            "account_number" => "required",
            "amount" => "required",
            "remark" => "required",
        ]);

        if (!empty($failed_fields)) {
            $faileds = implode(", ", $failed_fields);
            throw new BaseException($faileds, 
                ErrorConstant::ERROR_CODE_CREATE_FAILED, 400);
        }

        $secret = config('secret', 'key');
        $password = config('secret', 'password');
        $encoded_secret = base64_encode("$secret:$password");

        $disburse_curl = new DisburseEndpointModel();
        $disburse_curl->intialize($params);
        $disburse_curl->setHeader("Authorization", "basic $encoded_secret");
        $disburse_curl->setHeader('Content-type', 'application/x-www-form-urlencoded');

        $disburse_curl->callEndpoint();
        $data = $disburse_curl->respBody();

        if (empty($data->id)) {
            throw new BaseException(MessageConstant::MESSAGE_CREATE_FAILED, 
                ErrorConstant::ERROR_CODE_CREATE_FAILED, 400);
        }

        $requestBody = serialize($params);
        $responseBody = serialize($data);

        $created_disburse = new DisburseDatabaseModel();
        $created_disburse = $created_disburse->createDisburse($data, $requestBody, $responseBody);

        if (empty($created_disburse)) {
            throw new BaseException(MessageConstant::MESSAGE_CREATE_FAILED, 
                ErrorConstant::ERROR_CODE_CREATE_FAILED, 400);
        }

        return $created_disburse;
    }

    public static function list($params) {
        $status = $params['status'] ?? "";

        $disburse = new DisburseDatabaseModel();

        if (empty($status)) {
            $list_of_disburse = $disburse->findAllDisburseData();
        } else {
            $list_of_disburse = $disburse->findAllDisburseDataByStatus($status);
        }

        return $list_of_disburse;
    }

    public static function update($params) {
        $failed_fields = self::validate($params, [
            "id" => "required",
        ]);

        if (!empty($failed_fields)) {
            $faileds = implode(", ", $failed_fields);
            throw new BaseException($faileds, 
                ErrorConstant::ERROR_CODE_CREATE_FAILED, 400);
        }

        $id = $params['id'];

        $disburse = new DisburseDatabaseModel();
        $disburse = $disburse->findOneDisburseDataByID($id);

        if (empty($disburse)) {
            throw new BaseException(MessageConstant::MESSAGE_NOT_FOUND, 
                ErrorConstant::ERROR_CODE_NOT_FOUND, 400);
        }

        $secret = config('secret', 'key');
        $password = config('secret', 'password');
        $encoded_secret = base64_encode("$secret:$password");

        $disburse_curl = new DisbursementStatusEndpointModel();
        $disburse_curl->setQParams($disburse->ref_id);
        $disburse_curl->setHeader("Authorization", "basic $encoded_secret");
        $disburse_curl->setHeader('Content-type', 'application/x-www-form-urlencoded');

        $disburse_curl->callEndpoint();
        $data = $disburse_curl->respBody();

        if (empty($data->id)) {
            throw new BaseException(MessageConstant::MESSAGE_UPDATE_FAILED, 
                ErrorConstant::ERROR_CODE_UPDATE_FAILED, 400);
        }

        if ($data->status != DisburseConstant::STATUS_PENDING) {
            $disburse = $disburse->updateStatusDisburse($data);
        }

        if (empty($disburse)) {
            throw new BaseException(MessageConstant::MESSAGE_UPDATE_FAILED, 
                ErrorConstant::ERROR_CODE_UPDATE_FAILED, 400);
        }

        return $disburse;
    }

}