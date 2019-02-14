
function ajaxValidation(formEL) {
    this.form = formEL;
    this.blockUIelement = '';
}

/**
 * serialize form :input all
 * @param input
 */
ajaxValidation.prototype.post = function(url, input, callback) {
    var that = this;
    if (typeof input === 'object') {
        var p = input.serializeArray();
        p.push({name: "_csrfToken", value: $("input[name=_csrfToken]").val()});
        mApp.block(that.blockUIelement,{
            overlayColor:"#000000",
            type:"loader",
            state:"success" ,
            message:"Please wait..."
        });
        $.ajax({
            type: "POST",
            url: url,
            data: p,
            //dataType: "json",
            success: function(data) {
                //var obj = jQuery.parseJSON(data); if the dataType is not specified as json uncomment this
                // do what ever you want with the server response
                mApp.unblock(that.blockUIelement);
                if (data instanceof Array) {
                    callback({success: true});
                } else if (typeof data === 'object') {
                    if (typeof callback === 'function') {
                        callback({success: false});
                    }

                    for (let [key, value] of Object.entries(data)) {
                        let input = that.form.find(`input[name="${key}"]`)
                            .addClass('is-invalid');
                        that.appendTextInput(input, value);
                    }
                }
            },
            error: function() {
                mApp.unblock(that.blockUIelement);
            }
        });
    }
}

ajaxValidation.prototype.setblockUI = function(el) {
    this.blockUIelement = el;
}

ajaxValidation.prototype.appendTextInput = function (el, message) {
    let out = '<div class="error invalid-feedback">';
    let len = Object.entries(message).length;
    if (len > 1) {
        out += '<ul style="margin-left: -30px;">';
    }
    for (let [key, value] of Object.entries(message)) {
        console.log(value);
        out += len > 1 ? `<li>${value}</li>` : value;
    }
    if (len > 1) {
        out += '</ul>';
    }
    out += '</div>';
    el.parents('.form-group').addClass('validate is-invalid');
    if (el.parents('.input-group').find('.input-group-append').length) {
        el.parents('.input-group').after(out);
    } else {
        el.after(out);
    }
}