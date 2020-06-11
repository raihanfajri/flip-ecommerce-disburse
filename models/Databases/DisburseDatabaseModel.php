<?php

namespace models\Databases;

use helpers\Constants\DatabaseConstant;

class DisburseDatabaseModel extends BaseDatabaseModel {

    protected $table = "disburse";
    protected $database = DatabaseConstant::DISBURSE_DB;

    public $id;
    public $ref_id;
    public $amount;
    public $status;
    public $bank_code;
    public $account_number;
    public $remark;
    public $reciept;
    public $time_served;
    public $fee;



}