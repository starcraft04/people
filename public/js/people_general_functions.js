function toCurrency(num) {
    if (num != null) {
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