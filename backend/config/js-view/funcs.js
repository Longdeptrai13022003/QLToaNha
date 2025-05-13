/**
 * Created by HungLuongHien on 6/24/2016.
 */
function createTypeHeadCallback(target, action, callback){
    $(target).typeahead({
        source: function (query, process) {
            var states = [];
            return $.get('index.php?r=autocomplete/'+action, { query: query }, function (data) {
                callback(data, states, process);
            }, 'json');
        },
    });
}

function setDatePicker() {
    $('.datepicker').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy',
        language: 'vi',
        todayBtn: true,
        todayHighlight: true
    });
}

function createForm(action, regionBody, regionFooter){
    $.ajax({
        url: "index.php?r="+action,
        method: 'GET',
        async: false,
        beforeSend: function () {
        },
        error: function (response) {
        },
        success: function (response) {
            $(regionBody).html(response.content);
            $(regionFooter).html(response.footer);
        },
        contentType: false,
        cache: false,
        processData: false
    });
}

function convertNumberFromString($val){
    if($val === '')
        return 0;
    else{
        var $number = $val;
        while ($number.indexOf(',') >= 0)
            $number = $number.replace(',','');
        return $number;
    }
}

function dmY2Ymd($str){
    var $arr = $str.split('/');
    return $arr[2] + '-' + $arr[1] + '-' + $arr[0];
}

/**
 * $from: d/m/Y
 * $to: d/m/Y
 * @param $from
 * @param $to
 */
function tinhSoNgay($from, $to){
    $from = new Date(dmY2Ymd($from));
    $to = new Date(dmY2Ymd($to));
    return Math.floor(new Date($to - $from)/1000/60/60/24);
}
