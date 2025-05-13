/**
 * Created by hungluong on 7/24/17.
 */

$(document).ready(function () {
    $(document).on('click', '.btn-updateProfile', function (e) {
        e.preventDefault();
        $("#modal-updateProfile").modal('show');
    });

    $(document).on('click', '.btn-saveProfile', function (e) {
        var selection = $('#form-updateProfile')
        $.ajax({
            url: 'index.php?r=site/update-profile',
            data: $("#form-updateProfile").serializeArray(),
            dataType: 'json',
            type: 'post',
            beforeSend: function () {
                selection.parent().find('.thongbao').html('');
                Metronic.blockUI();

            },
            success: function (data) {
                if(data.success){
                    selection.find('.thongbao').html('<div class="text-success"><i class="fa fa-check-circle"></i> '+data.content+'</div>');
                    setTimeout(function (){
                        selection.find('.thongbao').html('');
                    }, 3000);
                    // $.pjax.reload({container: "#crud-datatable-pjax"});
                }else{
                    $.alert(data.content);
                }
            },
            error: function (r1, r2) {
                console.log(r1.responseText);
            },
            complete: function () {
                Metronic.unblockUI();
            }
        })
    })
});