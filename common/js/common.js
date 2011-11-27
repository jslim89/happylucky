function redirect (url, open_window) {
	if (open_window == true)
		window.open(url, '_blank');
	else
		window.location.href = url;
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

function ui_editor(id, title) {
    $('#ckeditor-dialog').attr({title: title});
    $('#ckeditor-dialog').dialog({
                            resizable: false,
                            height: 440,
                            width: 900,
                            modal: true,
                            buttons: {
                                Done: function() {
                                               $('#'+id).val(
                                                   $('#ckeditor-dialog-done').text()
                                               );
                                               $(this).dialog('close');
                                           },
                                Cancel: function() {
                                                 $(this).dialog('close');
                                             }
                            },
                            close: function() {
                                       $('#'+id).focus();
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
