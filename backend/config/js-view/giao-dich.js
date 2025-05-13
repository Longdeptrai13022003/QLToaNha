$(document).ready(function () {
    $(document).on('click','.btn-gui-tin',function (e){
        e.preventDefault();
        if(confirm('Bạn có chắc chắn muốn thực gửi tin tới khách hàng này?')){
            var giaoDichID = $(this).attr('data-value');
            var ID = parseInt(giaoDichID);
            $.ajax({
                url: 'index.php?r=giao-dich/gui-tin-nhan',
                type: 'post',
                dataType: 'json',
                data: {ID: ID},
            }).success(function (data){
                if(data.success){
                    $('.thongbao').html('<div class="note note-success">'+data.content+'</div>');
                }else {
                    alert(data.content);
                }
            }).error(function (r1,r2){
                console.log(r1);
            });
        }
    });
    $(document).on('click','.btn-duyet-trang-thai',function (e){
        var giaoDichID = $(this).attr('data-value');
        var loai = $(this).attr('loai');
        var ID = parseInt(giaoDichID);
        var trangThaiGiaoDich = parseInt(loai);
        console.log(trangThaiGiaoDich);
        if (confirm('Bạn có chắc chắn muốn thực hiện việc này?')){
            $.ajax({
                url: 'index.php?r=giao-dich/duyet-giao-dich',
                type: 'post',
                dataType: 'json',
                data: {ID: ID, trangThai: trangThaiGiaoDich},
            }).success(function (data){
                if(data.success){
                    $('.thongbao').html('<div class="note note-success">'+data.content+'</div>');
                    $('#ajaxCrudModal').modal('hide');
                    $.pjax({container: "#crud-datatable-pjax"});
                }
            }).error(function (r1,r2){
                console.log(r1);
            });
        }
    });
    $(document).on('click','#btn-huy-giao-dich',function (e){
        var giaoDichID = $(this).attr('data-value');
        var ID = parseInt(giaoDichID);
        if (confirm('Bạn có chắc chắn muốn hủy giao dịch?')){
            $.ajax({
                url: 'index.php?r=giao-dich/delete',
                type: 'post',
                dataType: 'json',
                data: {ID: ID},
            }).success(function (data){
                if(data.success){
                    $('.thongbao').html('<div class="note note-success">'+data.content+'</div>');
                    $.pjax({container: "#crud-datatable-pjax"});
                }
            }).error(function (r1,r2){
                console.log(r1);
            });
        }
    });
    function createDatePicker(){
        $("#thoi-gian-tu, #thoi-gian-den").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd/mm/yy'
        });
    }
    createDatePicker();
    $(document).on('pjax:end', function() {
        createDatePicker(); // Khởi tạo lại DatePicker sau khi PJAX load lại
    });
});