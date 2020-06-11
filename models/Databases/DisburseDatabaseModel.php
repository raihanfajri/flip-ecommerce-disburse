<?php

namespace models\Databases;

use helpers\Constants\DatabaseConstant;
use models\Endpoints\Responses\DisburseResponseModel;

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
    public $receipt;
    public $time_served;
    public $fee;
    public $created_at;
    public $updated_at;
    public $request;
    public $response;
    public $third_party;

    public function createDisburse(DisburseResponseModel $disburse, $reqBody, $resBody, $third_party = "flip") {
        return $this->setQuery(
            "INSERT INTO " . $this->table . "(ref_id, amount, status, bank_code, account_number, " .
            "remark, receipt, time_served, fee, created_at, request, response, third_party) VALUES " .
            "(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        )->setBindings([
            $disburse->id, $disburse->amount, $disburse->status, $disburse->bank_code, $disburse->account_number,
            $disburse->remark, $disburse->receipt, $disburse->time_served, $disburse->fee, Date("Y-m-d H:i:s"),
            $reqBody, $resBody, $third_party,
        ])->create();
    }

    public function updateStatusDisburse(DisburseResponseModel $disburse) {
        return $this->setQuery(
            "UPDATE " . $this->table . " SET status=?, receipt=?, time_served=?, updated_at=? " .
            "WHERE id=" . $this->id
        )->setBindings([
            $disburse->status, $disburse->receipt, $disburse->time_served, Date("Y-m-d H:i:s")
        ])->update();
    }

    public function findOneDisburseDataByID($id) {
        return $this->setQuery(
            "SELECT id , ref_id, amount, status, bank_code, account_number, remark, receipt, " .
            "time_served, fee, created_at, updated_at, request, response, third_party FROM " . $this->table . " " .
            "WHERE id=? LIMIT 1" 
        )->setBindings([
            $id
        ])->first();
    }

    public function findAllDisburseData() {
        return $this->setQuery(
            "SELECT id , ref_id, amount, status, bank_code, account_number, remark, receipt, " .
            "time_served, fee, created_at, updated_at, request, response, third_party FROM " . $this->table . " " .
            "ORDER BY id DESC" 
        )->get();
    }

    public function findAllDisburseDataByStatus($status) {
        return $this->setQuery(
            "SELECT id , ref_id, amount, status, bank_code, account_number, remark, receipt, " .
            "time_served, fee, created_at, updated_at, request, response, third_party FROM " . $this->table . " " .
            "WHERE status=? ORDER BY id DESC" 
        )->setBindings([
            $status
        ])->get();
    }
}