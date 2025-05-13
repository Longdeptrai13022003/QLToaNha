$(document).ready(function () {
    $(document).on('click', '.btn-duyet-giao-dich', function (e){
        e.preventDefault();
        console.log("$(this).attr('data-value')", $(this).attr('data-value'),)
        $.ajax({
            url: 'index.php?r=giao-dich/duyet-giao-dich',
            data: {
                giaoDich: $(this).attr('data-value'),
                type: $(this).attr('data-type')
            },
            dataType: 'json',
            type: 'post',
            beforeSend: function () {
                Metronic.blockUI();
            },
            success: function (data) {
                if(data.success)
                    $.pjax.reload({container: '#crud-datatable-pjax'});
                else
                    $.alert(data.content);
            },
            error: function (r1, r2) {
                $.alert(r1.responseText);
            },
            complete: function () {
                Metronic.unblockUI();
            }
        });

    })
});
