$(document).ready(function () {
    $(document).on('click', '.btn-huy-khoi-phuc-hoat-dong', function (e) {
        e.preventDefault();
        var $uid = $(this).attr('data-value');
        if (confirm('Bạn có chắc chắn muốn thực hiện việc này?')) {
            $.ajax({
                url: 'index.php?r=user/change-status',
                type: 'post',
                data: {uid: $uid},
                success: function (response) {
                    if (response.status === 'success') {
                        $.pjax({container: "#crud-datatable-pjax"});
                    } else {
                        alert('Có lỗi xảy ra. Vui lòng thử lại.');
                    }
                },
                error: function () {
                    alert('Có lỗi xảy ra. Vui lòng thử lại.');
                }
            });
        }
    });

    $(document).on('click', '.btn-them-nhan-vien', function (e) {
        e.preventDefault();
        $("#modal-nhanvien").modal('show');
    });

    $(document).on('click', '.btn-search-khach-hang', function (e) {
        e.preventDefault();
        loadForm({type: 'load_form_search_khach_hang'}, 'l', function (data) {
            // Xử lý thành công, nếu cần
        }, function () {
            var maKH = $('#maKH').val();
            var tenKH = $('#tenKH').val();
            var dienThoaiKH = $('#dienThoaiKH').val();
            var username = $('#username').val();
            var email = $('#email').val();
            var vi_dien_tu = $('#vi_dien_tu').val();
            $('#quanlykhachhangsearch-id').val(maKH).trigger('change');
            $('#quanlykhachhangsearch-hoten').val(tenKH).trigger('change');
            $('#quanlykhachhangsearch-dien_thoai').val(dienThoaiKH).trigger('change');
            $('#quanlykhachhangsearch-username').val(username).trigger('change');
            $('#quanlykhachhangsearch-email').val(email).trigger('change');
            $('#quanlykhachhangsearch-vi_dien_tu').val(vi_dien_tu).trigger('change');
        });
    });

    $(document).on('click','.btn-chi-tiet',function (e) {
        e.preventDefault();
        viewData('user/xem-chi-tiet',{id: $(this).attr('data-value')},'xl')
    });


    $(document).on('click', '#btn-xoa-anh-dai-dien', function (e) {
        e.preventDefault();
        var $idUser = $(this).attr('data-value');
        var $loaiAnh = $(this).attr('loai-anh');
        var $Anh = $(this).parent().find('#hinh-anh');
        var $btn = $(this);
        if (confirm('Bạn có chắc chắn muốn xóa ảnh này?')) {
            $.ajax({
                url: 'index.php?r=user/xoa-anh',
                type: 'post',
                data: {idUser: $idUser, loaiAnh: $loaiAnh},
                success: function (response) {
                    if (response.status === 'success') {
                        $Anh.attr('src','http://localhost/quanlytoanha/hinh-anh/no-image.jpg');
                        $btn.remove();
                        $.pjax({container: "#crud-datatable-pjax"});
                    } else {
                        alert('Có lỗi xảy ra. Vui lòng thử lại.');
                    }
                },
                error: function () {
                    alert('Có lỗi xảy ra. Vui lòng thử lại.');
                }
            });
        }
    });


});
