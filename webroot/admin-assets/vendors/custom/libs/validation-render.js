
function ajaxValidation(formEL) {
    this.form = formEL;
}

/**
 * serialize form :input all
 * @param input
 */
ajaxValidation.prototype.post = function(url, input) {
    if (typeof input === 'object') {
        var p = input.serialize();
        $.ajax({
            type: "POST",
            url: url,
            data: p,
            dataType: "json",
            success: function(data) {
                //var obj = jQuery.parseJSON(data); if the dataType is not specified as json uncomment this
                // do what ever you want with the server response
            },
            error: function() {
                alert('error handling here');
            }
        });
    }
}