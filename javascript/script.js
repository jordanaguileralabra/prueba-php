function getCity() {
    var id_region = document.getElementById("id_region").value;

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("comuna").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "controllers/getCity.php?id_region=" + id_region, true);
    xmlhttp.send();
}
