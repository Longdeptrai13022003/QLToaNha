$(document).ready(function () {
    $(document).on('input change', '.don_gia', function () {
        let rawValue = $(this).val().replace(/\D/g, '');
        let formattedValue = rawValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        $(this).val(formattedValue);
    });
    $(document).on('click','.save-phong',function (e){
        e.preventDefault();
        var formData = new FormData($('#form-danh-muc')[0]);
        $.ajax({
            url: 'index.php?r=danh-muc/save-phong',
            type: 'post',
            dataType: 'json',
            data: formData,
            contentType: false,
            processData: false
        }).success(function (data){
            if (data.success){
                $('#ajaxCrudModal').modal('hide');
                $('.thongbao').html('<div class="note note-success">' + data.content + '</div>');
                $.pjax({container: "#crud-datatable-pjax"});
            }else {
                alert(data.content);
            }
        }).error(function (r1,r2){
            console.log(r1.responseText);
        });
    });
    $(document).on('click','.update-phong',function (e){
        e.preventDefault();
        var formData = new FormData($('#form-danh-muc')[0]);
        $.ajax({
            url: 'index.php?r=danh-muc/update-phong',
            type: 'post',
            dataType: 'json',
            data: formData,
            contentType: false,
            processData: false
        }).success(function (data){
            if (data.success){
                $('#ajaxCrudModal').modal('hide');
                $('.thongbao').html('<div class="note note-success">' + data.content + '</div>');
                $.pjax({container: "#crud-datatable-pjax"});
            }else {
                alert(data.content);
            }
        }).error(function (r1,r2){
            console.log(r1.responseText);
        });
    });
    $(document).on('click','#xoa-phong',function (e){
        e.preventDefault();
        if(confirm('Bạn có chắc chắn muốn xóa phòng?')){
            $.ajax({
                url: 'index.php?r=danh-muc/xoa-phong',
                type: 'post',
                dataType: 'json',
                data: {id: $(this).attr('data-value')},
            }).success(function (data){
                if (data.success){
                    $('.thongbao').html('<div class="note note-success">' + data.content + '</div>');
                    $.pjax({container: "#crud-datatable-pjax"});
                }else {
                    alert(data.content);
                }
            }).error(function (r1,r2){
                console.log(r1.responseText);
            });
        }
    });
});