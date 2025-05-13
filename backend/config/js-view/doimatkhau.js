/**
 * Created by hungluong on 7/24/17.
 */

$(document).ready(function () {
    $(document).on('click', '.btn-doimatkhau', function (e) {
        e.preventDefault();
        $("#modal-doimatkhau").modal('show');
    });

    $(document).on('click', '.btn-thuchiendoimatkhau', function (e) {
        e.preventDefault();
        if($("#mat-khau-cu").val() == ''){
            alert('Chưa nhập mật khẩu cũ');
            $("#mat-khau-cu").focus();
        }else if($("#mat-khau-moi").val().length < 6){
            alert("Mật khẩu mới phải chứ ít nhất 6 ký tự");
            $("#mat-khau-moi").focus();
        }else if($("#nhap-lai-matkhaumoi").val() != $("#mat-khau-moi").val()){
            alert("Nhập lại mật khẩu mới không trùng khớp");
            $("#nhap-lai-matkhaumoi").focus();
        }else{
            $.ajax({
                url: 'index.php?r=site/doimatkhau',
                data: $("#form-doimatkhau").serializeArray(),
                dataType:'json',
                type: 'post',
                beforeSend: function () {
                    Metronic.blockUI({target: "#modal-doimatkhau .modal-content"});
                    $('.thongbao').html('');
                },
                success: function (data) {
                    $('.thongbao').html(data.message);
                    alert('Đổi mật khẩu thành công, vui lòng đăng nhập lại vào hệ thống!');
                    $("#form-doimatkhau")[0].reset();
                    $("#modal-doimatkhau").modal('hide');
                    window.location = 'index.php?r=site/logout';
                },
                error: function (r1, r2) {
                    $('.thongbao').html(getErrorString(r1.responseText));
                },
                complete: function () {
                    Metronic.unblockUI("#modal-doimatkhau .modal-content");
                }
            })
        }
    })
});