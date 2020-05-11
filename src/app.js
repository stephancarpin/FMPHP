
//Create Record Using Ajax
function create_record_ajax() {

    var operation   = document.getElementById("create_o").value;
    var name       = document.getElementById("name").value;
    var surname    = document.getElementById("surname").value;
    var tasks_name = document.getElementById("tasks_name").value;
    var progress   = document.getElementById("progress").value;

    console.log(progress);

    var data = new FormData();

    data.append('operation' ,'operation' )
    data.append('name', name);
    data.append('surname', surname);
    data.append('tasks_name', tasks_name);
    data.append('progress', progress);



    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Typical action to be performed when the document is ready:
           // document.getElementById("demo").innerHTML = xhttp.responseText;
            location.reload();
            console.log(xhttp.responseText);
        }
    };
    xhttp.open("GET", "./src/ajax.php", true);
    xhttp.send(data);
}


