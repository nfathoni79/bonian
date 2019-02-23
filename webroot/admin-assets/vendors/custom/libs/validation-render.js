
function ajaxValidation(formEL) {
    this.form = formEL;
    this.blockUIelement = '';
}


ajaxValidation.prototype.checkFieldName = function(element, field, matched) {
    let inputs = [];
    element.find(':input:visible').each(function() {
        if (String($(this).attr('name')).replace('[]', '') === field && inputs.indexOf($(this).attr('name')) == -1) {
            inputs.push($(this).attr('name'));
            if (typeof matched === 'function') {
                matched($(this));
            }
            return;
        }
    });
}

ajaxValidation.prototype.extractMessage = function (object) {
    if (this.ObjectLength(object) === 0) {
        return object;
    }
}

ajaxValidation.prototype.extractFields_ = function (object) {
    var o = [];
    var self = this;
    Object.keys(object).map(e => {
        if (typeof object[e] === 'object' && self.ObjectLength(object[e]) > 0) {
            var n = [];
            for( var [key, value] of Object.entries(object[e]) ) {
                if (self.ObjectLength(value) > 0) {
                    n.push('[' + key + ']');
                    for(var f of Object.keys(value)) {
                        var i = '[' + f + ']';
                        o.push({field: e + n.join('') + i, message: self.extractMessage(value[f])});
                    }
                    n = [];
                } else {
                    o.push({field: e + '[' + key + ']', message: self.extractMessage(value)});
                }
            }
        } else {
            o.push({field: e, message: self.extractMessage(object[e])});
        }
    });
    return o;
};

ajaxValidation.prototype.extractFields = function (object) {
    var form = this.flattenObject(object);
    var o = [];
    for(var [key, value] of Object.entries(form)) {

        o.push({field: key, message: value});
    }
    return o;
};


ajaxValidation.prototype.flattenObject = function(obj, inRet, inPrefix) {
    const ret = inRet || {};
    const prefix = inPrefix || '';
    var self = this;
    if (typeof obj === 'object' && obj != null && self.ObjectLength(obj) >= 1) {
        Object.keys(obj).forEach((key) => {
            self.flattenObject(obj[key], ret, prefix === '' ? key : `${prefix}[${key}]`);
        });
    } else if (prefix !== '') {
        ret[prefix] = obj;
    }

    return ret;
}





ajaxValidation.prototype.ObjectLength = function( object ) {
    var length = 0;
    for( var [key, value] of Object.entries(object) ) {
        if (typeof value === 'object') {
            length += 1 + this.ObjectLength(value);
        }
    }
    return length;
};

/**
 * serialize form :input all https://jsfiddle.net/7Lwfx8ty/
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
        that.removeError();
        $.ajax({
            type: "POST",
            url: url,
            data: p,
            //dataType: "json",
            success: function(data) {
                //var obj = jQuery.parseJSON(data); if the dataType is not specified as json uncomment this
                // do what ever you want with the server response
                mApp.unblock(that.blockUIelement);
                if (data.error instanceof Array) {
                    callback({success: true}, data);

                } else if (typeof data.error === 'object') {
                    if (typeof callback === 'function') {
                        callback({success: false}, data);
                    }

                    /*for (let [key, value] of Object.entries(data)) {

                        that.checkFieldName(that.form, key, function(m) {
                            that.appendTextInput(m, value);
                        });
                        //let input = that.form.find(`[name="${key}"]`)
                        //    .addClass('is-invalid');
                        //that.appendTextInput(input, value);
                    }*/

                    let fields = that.extractFields(data.error);
                    for(var field in fields) {
                        //console.log(fields[field].field)
                        that.checkFieldName(that.form, fields[field].field, function(m) {
                            that.appendTextInput(m, fields[field].message);
                        });
                    }
                }
            },
            error: function(data) {
                if (data.status == 403) {
                    location.reload();

                }
                mApp.unblock(that.blockUIelement);
            },
        });
    }
}

ajaxValidation.prototype.setblockUI = function(el) {
    this.blockUIelement = el;
}

ajaxValidation.prototype.removeError = function() {
    this.form.find('.form-group.is-invalid').removeClass('is-invalid');
    this.form.find('.error.form-control-feedback').remove();
    this.form.find('.is-invalid').removeClass('is-invalid');
}

ajaxValidation.prototype.appendTextInput = function (el, message) {
    let out = '<div class="error form-control-feedback">';
    let len = Object.entries(message).length;
    if (len > 1) {
        out += '<ul style="margin-left: -30px;">';
    }
    for (let [key, value] of Object.entries(message)) {
        out += len > 1 ? `<li>${value}</li>` : value;
    }
    if (len > 1) {
        out += '</ul>';
    }
    out += '</div>';


    el.parents('.form-group').addClass('has-danger');
    if (el.parents('.input-group').find('.input-group-append').length || el.parents('.input-group').find('.input-group-prepend').length) {
        el.parents('.input-group').after(out);
    } else if (el.attr('type') === 'checkbox') {
        el.parents('.m-checkbox-inline').after(out);
    } else {

        if (el.hasClass('select2-hidden-accessible')) {
            el.next().after(out);
        } else {
            el.after(out);
        }

    }
}