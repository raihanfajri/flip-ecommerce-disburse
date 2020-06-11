<?php

require_once __DIR__ . '/../../helpers/Global.php';
require_once __DIR__ . '/../../helpers/Env.php';

use helpers\Env;

Env::load();

$config = config('database', "disburse_db");

$servername = $config['db_host'] . ":" . $config['db_port'];

function openConnection ($servername, $config, $dbname = null) {
    return new mysqli($servername, $config['db_username'], $config['db_password'], $dbname);
}

$conn = openConnection($servername, $config);

if ($conn->connect_error) {
    die ("Could not connect to database server\n");
}

echo "Database server connected\n";

$sql = "CREATE DATABASE " . $config['db_database'];
if ($conn->query($sql) === TRUE) {
  echo "Database ". $config['db_database'] ." created successfully\n";
} else {
  echo "Error creating database: " . $conn->error . "\n";
}

$conn->close();

$conn = openConnection($servername, $config, $config['db_database']);

$table = "disburse";

$sql = "CREATE TABLE IF NOT EXISTS $table (
        id BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        ref_id BIGINT(20) DEFAULT NULL,
        amount DECIMAL(20,2) DEFAULT NULL,
        status VARCHAR(20) DEFAULT NULL,
        bank_code VARCHAR(6) DEFAULT NULL,
        account_number VARCHAR(20) DEFAULT NULL,
        remark TEXT DEFAULT NULL,   
        receipt TEXT DEFAULT NULL,
        time_served DATETIME DEFAULT NULL,
        fee DECIMAL(20,2) DEFAULT NULL,
        created_at DATETIME DEFAULT NULL,
        updated_at DATETIME DEFAULT NULL,
        request TEXT DEFAULT NULL,
        response TEXT DEFAULT NULL,
        third_party VARCHAR(255) DEFAULT NULL
    )";
    
if ($conn->query($sql) === TRUE) {
    echo "Table $table created successfully\n";
} else {
    echo "Error creating table: " . $conn->error . "\n";
}

$conn->close();