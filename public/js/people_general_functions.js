function toCurrency(num) {
    if (num != null) {
        num  = parseFloat(num);
        if (num % 1 == 0) {
            result = num
                .toFixed(0) // always 0 decimal digits
                .replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1 ') + ' €';
            
        } else {
            result = num
                .toFixed(2) // always two decimal digits
                .replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1 ') + ' €';
        }
    } else {
        result = print_null(num);
    }
    return result;
  }
  
function print_null(some_text) {
    if (some_text == null) {
        result = '-';
    } else {
        result = some_text;
    }
    return result;
}

function flash_message(result,msg,delay=2000){
    if (result == 'success'){
        box_type = 'success';
        message_type = 'success';
        if (typeof delay == 'undefined') {
            delay=2000;
        }
    }
    else if (result == 'error') {
        box_type = 'danger';
        message_type = 'error';
        if (typeof delay == 'undefined') {
            delay=10000;
        }
    }
    else if (result == 'warning') {
        box_type = 'warning';
        message_type = 'warning';
        if (typeof delay == 'undefined') {
            delay=5000;
        }
    }

    $('#flash-message').empty();
    var box = $('<div id="delete-message" class="alert alert-'+box_type+' alert-dismissible flash-'+message_type+'" role="alert"><button href="#" class="close" data-dismiss="alert" aria-label="close">&times;</button>'+msg+'</div>');
    $('#flash-message').append(box);
    $('#delete-message').delay(delay).queue(function () {
        $(this).addClass('animated flipOutX')
    });
}