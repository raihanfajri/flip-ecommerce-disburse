<?php

namespace services;

class BaseService {

    protected static function validate(array $params, array $validator) {
        $required_fields = [];

        foreach ($validator as $key => $val) {
            
            if ($val == "required" && empty($params[$key])) {
                $required_fields[] = $key . " is required";
            }

        }

        return $required_fields;
    }
}