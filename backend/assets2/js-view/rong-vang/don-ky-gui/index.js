$(document).ready(function () {
    function loadDonKyGuiDaChon(){
        $.ajax({
            url: 'index.php?r=quan-ly-don-ky-gui/get-don-ky-gui-da-chon',
            dataType: 'json',
            type: 'post',
            beforeSend: function (){
                $("#block-don-ky-gui-da-chon").html('');
            },
            success: function (data){
                $("#block-don-ky-gui-da-chon").html('<strong>Đơn ký gửi đã chọn: </strong>');
                $.each(data, function (k, v){
                    $("#block-don-ky-gui-da-chon").append('<span class="badge badge-warning">'+v+'<a href="#" class="text-danger btn-xoa-don-ky-gui-da-chon" data-value="'+v+'"> <i class="fa fa-close"></i></a></span> ')
                })
            },
            error: function (r1, r2){
                console.log(r1.responseText);
            },
            complete: function (){
            }
        })
    }
    loadDonKyGuiDaChon();

    $(document).on('change', '.change-trang-thai-don-ky-gui', function (){
        var selection = $(this),
            trangThaiMoi = $(this).val();
        $.ajax({
            url: 'index.php?r=quan-ly-don-ky-gui/change-status-don-ky-gui',
            data: {
                idKyGui: $(this).attr('data-value'),
                trangThaiMoi: trangThaiMoi
            },
            dataType: 'json',
            type: 'post',
            beforeSend: function (){
                selection.parent().find('.thong-bao').html('');
                Metronic.blockUI();
            },
            success: function (data){
                if(data.success){
                    selection.parent().find('.thong-bao').html('<div class="text-success"><i class="fa fa-check-circle"></i> '+data.content+'</div>');

                    setTimeout(function (){
                        selection.parent().find('.thong-bao').html('');
                    }, 3000);
                    // $.pjax.reload({container: "#crud-datatable-pjax"});
                }else{
                    $.alert(data.content);
                }
            },
            error: function (r1, r2){
                console.log(r1.responseText);
            },
            complete: function (){
                Metronic.unblockUI();
            }
        })
    });

    $(document).on('change', '.change-ma-van-don-ky-gui', function (){
        var selection = $(this),
            maVanDon = $(this).val();
        $.ajax({
            url: 'index.php?r=quan-ly-don-ky-gui/change-info-don-ky-gui',
            data: {
                idKyGui: $(this).attr('data-value'),
                maVanDon: maVanDon
            },
            dataType: 'json',
            type: 'post',
            beforeSend: function (){
                selection.parent().find('.thong-bao').html('');
                Metronic.blockUI();
            },
            success: function (data){
                if(data.success){
                    selection.parent().find('.thong-bao').html('<div class="text-success"><i class="fa fa-check-circle"></i> '+data.content+'</div>');

                    setTimeout(function (){
                        selection.parent().find('.thong-bao').html('');
                    }, 3000);
                    // $.pjax.reload({container: "#crud-datatable-pjax"});
                }else{
                    $.alert(data.content);
                }
            },
            error: function (r1, r2){
                console.log(r1.responseText);
            },
            complete: function (){
                Metronic.unblockUI();
            }
        })
    });

    $(document).on('change', '.change-ghi-chu-don-ky-gui', function (){
        var selection = $(this),
            ghiChu = $(this).val();
        $.ajax({
            url: 'index.php?r=quan-ly-don-ky-gui/change-info-don-ky-gui',
            data: {
                idKyGui: $(this).attr('data-value'),
                ghiChu: ghiChu
            },
            dataType: 'json',
            type: 'post',
            beforeSend: function (){
                selection.parent().find('.thong-bao').html('');
                Metronic.blockUI();
            },
            success: function (data){
                if(data.success){
                    selection.parent().find('.thong-bao').html('<div class="text-success"><i class="fa fa-check-circle"></i> '+data.content+'</div>');

                    setTimeout(function (){
                        selection.parent().find('.thong-bao').html('');
                    }, 3000);
                    // $.pjax.reload({container: "#crud-datatable-pjax"});
                }else{
                    $.alert(data.content);
                }
            },
            error: function (r1, r2){
                console.log(r1.responseText);
            },
            complete: function (){
                Metronic.unblockUI();
            }
        })
    });

    // function createDatePicker(){
    //     $("#ngay-dat-tu, #ngay-dat-den").datepicker({
    //         changeMonth: true,
    //         changeYear: true,
    //         dateFormat: 'dd/mm/yy'
    //     });
    // }
    // createDatePicker();
    //
    // $("#crud-datatable-pjax").on("pjax:success", function () {
    //     createDatePicker();
    // });

    $(document).on('change', '.chon-don-ky-gui', function (e){
        e.preventDefault();
        $.ajax({
            url: 'index.php?r=quan-ly-don-ky-gui/chon-don-ky-gui',
            data: {
                idKyGui: $(this).val(),
            },
            dataType: 'json',
            type: 'post',
            beforeSend: function (){
            },
            success: function (data){
                loadDonKyGuiDaChon();
            },
            error: function (r1, r2){
                console.log(r1.responseText);
            },
            complete: function (){
            }
        })
    });

    $(document).on('click', '.btn-xoa-don-ky-gui-da-chon', function (e){
        e.preventDefault();
        var $me = $(this);
        $.ajax({
            url: 'index.php?r=quan-ly-don-ky-gui/xoa-don-ky-gui-da-chon',
            data: {
                idKyGui: $me.attr('data-value'),
            },
            dataType: 'json',
            type: 'post',
            beforeSend: function (){
            },
            success: function (data){
                $me.parent().remove();
                $.pjax.reload({container: "#crud-datatable-pjax"});
            },
            error: function (r1, r2){
                console.log(r1.responseText);
            },
            complete: function (){
            }
        })
    });

    $(document).on('click', '.btn-update-trang-thai-don-ky-gui', function (e) {
        e.preventDefault();
        loadForm({type: 'load_form_update_trang_thai_don_ky_gui_loat'}, 'l', function (data) {
        }, function () {
            SaveObject('quan-ly-don-ky-gui/luu-trang-thai-don-ky-gui-hang-loat', $("#form-update-status-hang-loat").serializeArray(), function (data) {
                $.pjax.reload({container: '#crud-datatable-pjax'});
                loadDonKyGuiDaChon();
            })
        });
    });

    $(document).on('click', '.btn-sua-don-ky-gui', function (e) {
        e.preventDefault();
        loadForm({type: 'load_form_sua_don_ky_gui', 'idKyGui': $(this).attr('data-value')}, 'l', function (data) {
        }, function () {
            SaveObject('quan-ly-don-ky-gui/save-don-ky-gui', $("#form-update-don-ky-gui").serializeArray(), function (data) {
                $.pjax.reload({container: '#crud-datatable-pjax'});
            })
        });
    });

    $(document).on('click', '.remove-list-don-ky-gui-update', function (e){
        e.preventDefault();
        $(this).parent().parent().remove();
    });

    $(document).on('click', '.btn-xem-chi-tiet-don-ky-gui', function (e) {
        e.preventDefault();
        viewData('quan-ly-don-ky-gui/xem-chi-tiet-don-ky-gui', {
            idKyGui: $(this).attr('data-value')
        }, 'lg');
    });

    $(document).on('click', '.btn-xoa-don-ky-gui', function (e){
        e.preventDefault();
        viewData('quan-ly-don-ky-gui/delete-don-ky-gui', {
            idKyGui: $(this).attr('data-value')
        }, 'l', function (){
            $.pjax.reload({container: "#crud-datatable-pjax"});
        });
    });

    $('input[name="QuanLyDonKyGuiSearch[field_trang_thai]"]').addClass('hide');

    $(document).on('pjax:end', function () {
        $('input[name="QuanLyDonKyGuiSearch[field_trang_thai]"]').addClass('hide');
    });
    $(document).on('click', '.btn-search-don-ky-gui', function (e) {
        e.preventDefault();
        loadFormSearch({type: 'load_form_search_don_ky_gui'}, 'l', function (data) {
        }, function () {
            var maKH = $('#maKH').val();
            var tenKH = $('#tenKH').val();
            var dienThoaiKH = $('#dienThoaiKH').val();
            var ngayDatTu = $('#ngayDatTu').val();
            console.log(ngayDatTu);
            var ngayDatDen = $('#ngayDatDen').val();
            var maKG = $('#maKG').val();
            var maVanDon = $('#maVanDon').val();
            var trangThai = $('#trangThai').val();
            var daThanhToan = $('#daThanhToan').val();
            console.log(daThanhToan);
            var tenNguoiNhan = $('#tenNguoiNhan').val();
            var dienThoaiNguoiNhan = $('#dienThoaiNguoiNhan').val();
            $('#quanlydonkyguisearch-user_id').val(maKH).trigger('change');
            $('#quanlydonkyguisearch-hoten').val(tenKH).trigger('change');
            $('#quanlydonkyguisearch-dien_thoai').val(dienThoaiKH).trigger('change');
            $('#ngay-dat-tu').val(ngayDatTu).trigger('change');
            $('#ngay-dat-den').val(ngayDatDen).trigger('change');
            $('#quanlydonkyguisearch-id').val(maKG).trigger('change');
            $('#quanlydonkyguisearch-field_ma_van_don_ky_gui').val(maVanDon).trigger('change');
            $('input[name="QuanLyDonKyGuiSearch[field_trang_thai]"]').val(trangThai).trigger('change');

            $('#quanlydonkyguisearch-field_so_tien_da_thanh_toan').val(daThanhToan).trigger('change');

            $('#quanlydonkyguisearch-ho_ten_nguoi_nhan').val(tenNguoiNhan).trigger('change');
            $('#quanlydonkyguisearch-dien_thoai_nguoi_nhan').val(dienThoaiNguoiNhan).trigger('change');
        },function (){
            $('#maKH').val($('#quanlydonkyguisearch-user_id').val());
            $('#tenKH').val($('#quanlydonkyguisearch-hoten').val());
            $('#dienThoaiKH').val($('#quanlydonkyguisearch-dien_thoai').val());
            $('#ngayDatTu').val($('#ngay-dat-tu').val());
            $('#ngayDatDen').val($('#ngay-dat-den').val());
            $('#maKG').val($('#quanlydonkyguisearch-id').val());
            $('#maVanDon').val($('#quanlydonkyguisearch-field_ma_van_don_ky_gui').val());
            $('#trangThai').val($('input[name="QuanLyDonKyGuiSearch[field_trang_thai]"]').val());
            $('#daThanhToan').val($('#quanlydonkyguisearch-field_so_tien_da_thanh_toan').val());
            $('#tenNguoiNhan').val($('#quanlydonkyguisearch-ho_ten_nguoi_nhan').val());
            $('#dienThoaiNguoiNhan').val($('#quanlydonkyguisearch-dien_thoai_nguoi_nhan').val());
        });
    });

    $(document).on('click', '.btn-reset-datatable', function (e) {
        $('#quanlydonkyguisearch-user_id').val("").trigger('change');
        $('#quanlydonkyguisearch-hoten').val("").trigger('change');
        $('#quanlydonkyguisearch-dien_thoai').val("").trigger('change');
        $('#ngay-dat-tu').val("").trigger('change');
        $('#ngay-dat-den').val("").trigger('change');
        $('#quanlydonkyguisearch-id').val("").trigger('change');
        $('#quanlydonkyguisearch-field_ma_van_don_ky_gui').val("").trigger('change');
        $('input[name="QuanLyDonKyGuiSearch[field_trang_thai]"]').val("").trigger('change');

        $('#quanlydonkyguisearch-field_so_tien_da_thanh_toan').val("").trigger('change');

        $('#quanlydonkyguisearch-ho_ten_nguoi_nhan').val("").trigger('change');
        $('#quanlydonkyguisearch-dien_thoai_nguoi_nhan').val("").trigger('change');
    });

});
