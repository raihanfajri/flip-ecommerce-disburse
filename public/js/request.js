function getList() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let response = JSON.parse(this.responseText);

            if (!empty(response) && response.success && !empty(response.data)) {
                var data_table = "";
                
                document.getElementById("data_table").innerHTML = 
                    "<tr>"+
                        "<th>REF ID</th>"+
                        "<th>Bank Code</th>"+
                        "<th>Account Number</th>"+
                        "<th>Amount</th>"+
                        "<th>Remark</th>"+
                        "<th>Fee</th>"+
                        "<th>Receipt</th>"+
                        "<th>Time Served</th>"+
                        "<th>Status</th>"+
                    "</tr>";

                for (let i in response.data) {
                    let data = response.data[i];

                    data_table += 
                        "<tr>" +
                            "<td>"+data.ref_id+"</td>" +
                            "<td>"+data.bank_code+"</td>" +
                            "<td>"+data.account_number+"</td>" +
                            "<td>"+data.amount+"</td>" +
                            "<td>"+data.remark+"</td>" +
                            "<td>"+data.fee+"</td>" +
                            "<td><a href='"+data.receipt+"'>Open</a></td>" +
                            "<td>"+data.time_served+"</td>" +
                            "<td>"+data.status+"</td>" +
                        "</tr>";
                }

                document.getElementById("data_table").innerHTML += data_table;
            }

        }
    };
    xmlhttp.open("GET", "/api/disburse/list" , true);
    xmlhttp.send();
}

function createDisburse() {

    let req = {
        'bank_code' : document.getElementById('bank_code').value,
        'account_number': document.getElementById('acc_number').value,
        'amount': document.getElementById('amount').value,
        'remark': document.getElementById('remark').value
    }

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4) {
            let response = JSON.parse(this.responseText);

            if (!empty(response)) {
                if (!response.success || empty(response.data)) {
                    alert(response.message);
                }
            }

            getList();
        }
    };
    xmlhttp.open("POST", "/api/disburse" , true);
    xmlhttp.setRequestHeader("Content-type", "application/json");
    xmlhttp.send(JSON.stringify(req));
}

function empty($data) {
    if (typeof $data == "undefined") {
        return true;
    }

    switch ($data) {
        case null:
            return true;
        case {}:
            return true;
        case []:
            return true;
        case "":
            return true;
    }

    return false;
}

getList()