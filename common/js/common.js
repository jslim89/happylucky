function redirect (url, open_window) {
	if (open_window == true)
		window.open(url, '_blank');
	else
		window.location.href = url;
}

/*
 * offset is start from 0. Default is 1
 * i.e. element_1, offset[0] = element, offset[1] = 1
 *
 * delimiter by default is underscore (_)
 * i.e. element_1 = arr[0] = element
 *                  arr[1] = 1
 */
function get_element_index(obj, offset, delimiter) {
    var obj_id = $(obj).attr('id');
    if(offset == null) offset = 1;
    if(delimiter == null) delimiter = '_';
    var token = obj_id.split(delimiter);
    var index = token[token.length - offset];

    return index;
}

function ui_alert(title, message) {
    var content = '<p>'+message+'</p>';
    $('#message-dialog').attr({title: title});
    $('#message-dialog').html(content);
    $('#message-dialog').dialog({
                            resizable: false,
                            height: 140,
                            modal: true,
                            buttons: {
                                Ok: function() {
                                       $(this).dialog('close');
                                    }
                            }
                        });
}

$(document).ready(function() {
    $('.positive-integer').numeric({decimal: false, negative: false}, function() {
        ui_alert(lang_invalid_input, lang_positive_integer_warning_message);
        this.value = '';
        this.focus();
    }
    ).attr('title', lang_positive_integer_tooltip);

    $('.positive').numeric({negative: false}, function() {
        ui_alert(lang_invalid_input, lang_positive_warning_message);
        this.value = '';
        this.focus();
    }
    ).attr('title', lang_positive_tooltip);

    $('.integer').numeric({decimal: false}, function() {
        ui_alert(lang_invalid_input, lang_integer_warning_message);
        this.value = '';
        this.focus();
    }
    ).attr('title', lang_integer_tooltip);

    $('#check_all').click(function () {
        if($(this).is(':checked')) {
            $('.delete_check').attr('checked', true);
        }
        else {
            $('.delete_check').attr('checked', false);
        }
    });

});

function format_country(country) {
    var value = '';
    if(country.iso_code_3 && country.country_name)
        value = country.iso_code_3 + ' - ' + country.country_name;
    else if(country.country_name)
        value = country.country_name;
    else if(country.iso_code_3)
        value = country.iso_code_3;
    return value;
}
