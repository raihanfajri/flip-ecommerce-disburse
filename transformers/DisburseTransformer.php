<?php

namespace transformers;

use models\Databases\DisburseDatabaseModel;

class DisburseTransformer {

    public function transform(DisburseDatabaseModel $data) {
        return [
            'id' => (int) $data->id,
            'ref_id' => (int) $data->ref_id,
            'amount' => (float) $data->amount,
            "status"=> (string) $data->status,
            "bank_code"=> (string) $data->bank_code,
            "account_number"=> (string) $data->account_number,
            "remark"=> (string) $data->remark,
            "receipt"=> (string) $data->receipt,
            "time_served"=> (string) $data->time_served,
            "fee"=> (float) $data->fee,
            "created_at"=> (string) $data->created_at,
            "updated_at"=> (string) $data->updated_at,
        ];
    }
}