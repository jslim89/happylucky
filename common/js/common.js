function redirect (url, open_window) {
	if (open_window == true)
		window.open(url, '_blank');
	else
		window.location.href = url;
}

/*
 * Get the query string
 *
 * @param query string's variable
 * return string (if param doesn't exist, return null)
 */
function query_string(param) {
    var href = location.search; 
    var url = $.query.load (href);
    var qs =  url.get (param);
    return (qs == '') ? null : qs;
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

function ui_confirm(title, message) {
    var is_confirmed = false;
    var content = '<p>'+message+'</p>';
    $('#confirm-dialog').attr({title: title});
    $('#confirm-dialog').html(content);
    $('#confirm-dialog').dialog({
                            buttons: {
                                Ok: function() {
                                       is_confirmed = true;
                                       $(this).dialog('close');
                                    },
                                Cancel: function() {
                                       $(this).dialog('close');
                                    }
                            }
                        });
    alert(is_confirmed);
    return is_confirmed;
}

$(document).ready(function() {
    $('a[rel=lightbox]').lightBox();

    $('#confirm-dialog').dialog({
        autoOpen: false,
        resizable: false,
        height: 140,
        modal: true
    });

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

    // Jquery UI icons for mouse hover
    $('ul#icons li').hover(
        function() { $(this).addClass('ui-state-hover'); },
        function() { $(this).removeClass('ui-state-hover'); }
    );

    $('input.date').each(function() {
        var id = $(this).attr('id');
        $(this).attr('readonly', true)
        .datepicker({
            showOn: 'button',
            buttonImage: base_url+'images/icons/calendar.png',
            buttonImageOnly: true,
            dateFormat: 'd MM yy',
            showAnim: 'slideDown',
            changeMonth: true,
            changeYear: true,
            showOtherMonths: true,
            selectOtherMonths: true
        });
        $(this).after ('<img src="'+base_url+'images/icons/eraser.png" class="hand-cursor" onclick="empty_input (\''+$(this).attr('id')+'\')">');
    });

    $('span.expander').expander({
        userCollapseText: lang_less,
        expandText: lang_more
    });
});

function empty_input(id) {
    $('#'+id).val('');
}

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

/*
 * Prompt confirmation when tend to delete something
 *
 * @delete_url refer to the URL that process the deletion
 * @row_id refer to a specific row in a table
 */
function delete_row_confirmation(delete_url, row_id) {
    var content = '<p>'+lang_confirm_delete+'</p>';
    $('#confirm-dialog').attr({title: lang_confirmation});
    $('#confirm-dialog').html(content);
    $('#confirm-dialog').dialog({
                            buttons: {
                                Ok: function() {
                                        if($.isArray(row_id)) { // delete multiple rows
                                            // each delete_url is map to each row_id
                                            // the key must be the same
                                            // i.e. delete_url[3] map to row_id[3]
                                            $.each(row_id, function(key, value) {
                                                delete_row(delete_url[key], value);
                                            });
                                        }
                                        else {
                                            delete_row(delete_url, row_id);
                                        }
                                        $(this).dialog('close');
                                    },
                                Cancel: function() {
                                       $(this).dialog('close');
                                    }
                            }
                        });
    $('#confirm-dialog').dialog('open');
}

/*
 * @delete_url URL correspond to the object that want to delete
 * @row_id refer to the table row, after successfully 
 *         deleted, the row will be faded out
 */
function delete_row(delete_url, row_id) {
    $.ajax({
        url: delete_url,
        success: function(data) {
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(errorThrown);
        }
    });
    $('#'+row_id).fadeOut(3000);
    setTimeout(function() {
        $('#'+row_id).remove();
    }, 3100);
}

function add_to_cart(product_id, quantity) {
    if(quantity == null) quantity = 1;
    $.ajax({
        url: base_url + 'cart/add/' + product_id + '/' + quantity,
        type: 'POST',
        dataType: 'json',
        // data: 'quantity='+quantity,
        success: function(data) {
            // TODO: update cart content
            if(data.status == 1) {
                $('#add_to_cart_status_'+product_id).text(lang_added_to_cart)
                                                    .removeClass('warning')
                                                    .addClass('success');
            }
            else {
                $('#add_to_cart_status_'+product_id).text(lang_add_to_cart_failed)
                                                    .removeClass('success')
                                                    .addClass('warning');
            }
        },
        complete: function() {
            $('#add_to_cart_status_'+product_id).show();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(errorThrown);
        }
    });
}

/* redirect_in_second
 *
 * @param obj_id element id
 * @param timeout in second
 * @param url where you want to redirect
 */
function redirect_in_second(obj_id, timeout, url) {
    var timer = new Date();
    timer.setSeconds(timer.getSeconds() + (timeout + 0.5));
    $('span#temp-countdown').countdown({
        until: timer,
        format: 'S',
        onTick: function(periods) {
            $('#'+obj_id).text(periods[6]);
        },
        onExpiry: function() {
            if(url != null) redirect(url);
        }
    });
}
