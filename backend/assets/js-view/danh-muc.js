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

    function loadForm2($url, $dataInput, $size = 'm', callbackSuccess, callbackSave) {
        $.confirm({
            content: function () {
                var self = this;
                return $.ajax({
                    url: 'index.php?r=' + $url,
                    data: $dataInput,
                    type: 'post',
                    dataType: 'json'
                }).success(function (data) {
                    self.setContent(data.content);
                    self.setTitle(data.title);
                    self.setType('default');
                    if(typeof callbackSuccess != "undefined"){
                        callbackSuccess(data,self);
                    }
                }).error(function (r1, r2) {
                    self.setContent(getMessage(r1.responseText));
                    self.setTitle('Lỗi');
                    self.setType('red');
                });
            },
            columnClass: $size,
            buttons: {
                btnSave: {
                    text: '<i class="fa fa-save"></i> Lưu lại',
                    btnClass: 'btn-primary',
                    action: function () {
                        if(typeof callbackSave != "undefined")
                            callbackSave();
                    }
                },
                btnClose: {
                    text: '<i class="fa fa-close"></i> Hủy'
                }
            }
        });
    }

    $(document).on('click', '#btn-bao-cao-thong-ke', function (e) {
        e.preventDefault();
        loadForm2('site/loadform', {type: 'thong_ke_thu_chi'}, 'l', function (data) {

        }, function () {
            if($("#from_ngay_thong_ke").val() == ''){
                $.alert('Chưa nhập ngày thống kê từ');
                return  false;
            }else if($("#to_ngay_thong_ke").val() == ''){
                $.alert('Chưa nhập ngày thống kê đến');
                return  false;
            }else
                taiFileExcel('danh-muc/thong-ke-thu-chi', $("#form-thong-ke").serializeArray());
        }, '<i class="fa fa-file-excel-o"></i> Tải file báo cáo')
    });
});