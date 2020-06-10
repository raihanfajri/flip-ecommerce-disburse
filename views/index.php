<?php
?>

<html>
  <head>
    <title>Disburse</title>
    <link rel='stylesheet' href='/css/style.css' />
  </head>
  <body>
    <div class="navbar">
      <h3>Disburse</h3>
    </div>
    <div class="wrapper">
      <div class="box box-2">
          <form id="form">
            <div class="wrapper">
                <div class="box-1">
                    <label>Bank Code :</label>
                    <input id="bank_code" type="text">
                </div>
                <div class="box-1">
                    <label>Account Number :</label>
                    <input id="acc_number" type="text">
                </div>
            </div>
            <div class="wrapper">
                <div class="box-1">
                    <label>Amount :</label>
                    <input id="amount" type="number" min="0">
                </div>
                <div class="box-1">
                    <label>Remark :</label>
                    <input id="remark" type="text">
                </div>
            </div>
            <div class="wrapper">
                <span id="msg" class="msg"></span>
            </div>
            <div class="wrapper">
                <div class="box-1" style="text-align: center;">
                    <button type="button" id="submitButton">Submit</button>
                </div>
            </div>
          </form>
      </div>
    </div>
    <div class="wrapper">
      <div class="box box-2">
        <div class="output">
          <label>Disburse List :</label>
          <table>
            <tr>
                <th>REF ID</th>
                <th>Bank Code</th>
                <th>Account Number</th>
                <th>Amount</th>
                <th>Remark</th>
                <th>Fee</th>
                <th>Reciept</th>
                <th>Disbursed Date</th>
                <th>Status</th>
            </tr>
            </table>
        </div>
      </div>
    </div>
  </body>
</html>

<script src="/js/request.js"></script>