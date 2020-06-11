<?php

namespace models\Endpoints\Responses;

class DisburseResponseModel extends BaseResponseModel {

    public $id;
    public $amount;
    public $status;
    public $timestamp;
    public $bank_code;
    public $account_number;
    public $beneficiary_name;
    public $remark;
    public $receipt;
    public $time_served;
    public $fee;

}