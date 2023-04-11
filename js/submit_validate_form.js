function validate_cnp_field(site_url) {

    var fd = new FormData();
    fd.append('form_submit', '1')
    fd.append('cnp', $("#cnp").val());
    js_submit(site_url, fd, validate_cnp_field_callback)
}

function validate_cnp_field_callback(data) {
    var jdata = JSON.parse(data);

    $("#status").html("");
    if (jdata.success == 1) {
        let r = jdata.isCnpValid;
        let m = (r) ? "Is valid" : "Not valid";
        
        $("#status").html("Is valid");
    
    }
}

function js_submit(site_url, fd, callback) {
    /** @TODO add output function for plugin folder */
    var submitUrl = site_url + "/wp-content/plugins/cnpvalid/process/index.php";


    $.ajax(
        {
            url: submitUrl,
            type: "post",
            data: fd,
            contentType: false,
            processData: false,
            success: function(response) {
                callback(response)
            }
    
        }
    )
}