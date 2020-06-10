function getList() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(JSON.parse(this.responseText))
        }
    };
    xmlhttp.open("GET", "/api/disburse/list?q=a" , true);
    xmlhttp.send();
}

getList()