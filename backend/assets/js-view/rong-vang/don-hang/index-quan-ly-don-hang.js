$(document).ready(function () {
    function loadDonHangDaChon(){
        $.ajax({
            url: 'index.php?r=quan-ly-don-hang/get-don-hang-da-chon',
            dataType: 'json',
            type: 'post',
            beforeSend: function (){
                $("#block-don-hang-da-chon").html('');
            },
            success: function (data){
                $("#block-don-hang-da-chon").html('<strong>Đơn hàng đã chọn: </strong>');
                $.each(data, function (k, v){
                    $("#block-don-hang-da-chon").append('<span class="badge badge-warning">'+v+'<a href="#" class="text-danger btn-xoa-don-hang-da-chon" data-value="'+v+'"> <i class="fa fa-close"></i></a></span> ')
                })
            },
            error: function (r1, r2){
                console.log(r1.responseText);
            },
            complete: function (){
            }
        })
    }

    function createDatePicker(){
        $("#ngay-dat-tu, #ngay-dat-den").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd/mm/yy'
        });
    }
    loadDonHangDaChon();
    createDatePicker();

    $(document).on('click', '.btn-xem-chi-tiet-don-hang', function (e) {
        e.preventDefault();
        viewData('quan-ly-don-hang/chi-tiet-don-hang', {
            idDonHang: $(this).attr('data-value')
        }, 'lg');
    });

    loadTongTienGioHang();

    $(document).on('change', '.checkAll', function (e){
        e.preventDefault();
        var checkboxes = document.querySelectorAll('.itemCheckbox');
        for (var checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
        var isChecked = $(this).prop('checked');
        var checkAllValue = $(this).val();

        $('.chon-thanh-toan').each(function() {
            if ($(this).val() === checkAllValue) {
                $(this).prop('checked', isChecked);
            }
        });

        $.ajax({
            url: 'index.php?r=quan-ly-don-hang/chon-thanh-toan',
            data: {
                idDonHang: $(this).val(),
            },
            dataType: 'json',
            type: 'post',
            beforeSend: function (){
            },
            success: function (data){
                if (data && data.totalAmount !== undefined) {
                    $('#total-amount').val(data.totalAmount);
                }
                loadTongTienGioHang();
            },
            error: function (r1, r2){
                console.log(r1.responseText);
            },
            complete: function (){
            }
        })
    });

    $(document).on('change', '.itemCheckbox', function (e){
        e.preventDefault();
        var allChecked = $('.itemCheckbox:checked').length === $('.itemCheckbox').length;
        $('.checkAll').prop('checked', allChecked);

        $.ajax({
            url: 'index.php?r=quan-ly-don-hang/chon-chi-tiet-don-hang',
            data: {
                idDonHang: $(this).val(),
            },
            dataType: 'json',
            type: 'post',
            beforeSend: function (){
            },
            success: function (data){
                if (data && data.totalAmount !== undefined) {
                    $('#total-amount').val(data.totalAmount);
                }
                loadTongTienGioHang();
            },
            error: function (r1, r2){
                console.log(r1.responseText);
            },
            complete: function (){
            }
        })
        if (allChecked) {
            $('.checkAll').trigger('change');
        }
    });

    $(document).on('change', '.quantity_textbox', function (e){
        e.preventDefault();
        var $row = $(this).closest('tr');
        var idDonHang = $(this).data('id-don-hang');
        var value = parseInt($(this).val());
        if (isNaN(value) || value < 1) {
            this.value = 1;
        }
        var quantity = $(this).val();

        var $productInfo = $('#product-info-' + idDonHang);
        var pricePerUnit = parseFloat($productInfo.find('.price').text());

        var tyGia = parseFloat($productInfo.closest('tr').find('.hidden .ty_gia').text());


        var newTotal = quantity * pricePerUnit;
        var newTT = newTotal * tyGia;

        $productInfo.find('.quantity').text(quantity);
        $productInfo.find('.total').text(newTotal.toFixed(2));
        $productInfo.closest('tr').find('.tong_tien').text(newTT.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, '.'));

        var totalAmount = 0;
        $('.tong_tien').each(function () {
            totalAmount += parseFloat($(this).text().replace(/\./g, ''));
        });
        $('.thanh_tien').text(totalAmount.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, '.'));
        $.ajax({
            url: 'index.php?r=quan-ly-don-hang/change-quantity-don-hang',
            data: {
                idDonHang: idDonHang,
                soLuong: quantity
            },
            dataType: 'json',
            type: 'post',
            beforeSend: function (){
            },
            success: function (data){
                if (data && data.totalAmount !== undefined) {
                    $('#total-amount').val(data.totalAmount);
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

    $("#crud-datatable-pjax").on("pjax:success", function () {
        loadDonHangDaChon();
        createDatePicker();
    });

    $(document).on('click', '.btn-xoa-don-hang', function (e){
        e.preventDefault();
        viewData('quan-ly-don-hang/delete-don-hang', {
            'idDonHang': $(this).attr('data-value')
        }, 'l', function (){
            $.pjax.reload({container: "#crud-datatable-pjax"});
            loadDonHangDaChon();
        });
    });

    $(document).on('click', '.btn-thanh-toan', function (e){
        $.ajax({
            url: 'index.php?r=quan-ly-don-hang/thanh-toan-gio-hang',
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert('Thanh toán thành công!');
                } else {
                    alert(response.content);
                }
            },
            error: function() {
                alert('Đã có lỗi xảy ra. Vui lòng thử lại sau.');
            }
        });
    });

    $(document).on('change', '.change-trang-thai-don-hang', function (){
        var selection = $(this),
            trangThaiMoi = $(this).val();

        $.ajax({
            url: 'index.php?r=quan-ly-don-hang/change-status-don-hang',
            data: {
                idDonHang: $(this).attr('data-value'),
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

    $(document).on('change', '.ma-van-don-input', function (){
        var myInput = $(this);
        console.log('2');
        $.ajax({
            url: 'index.php?r=quan-ly-don-hang/update-ma-van-don',
            data: {
                idDonHang: myInput.attr('data-value'),
                maVanDon: myInput.val()
            },
            dataType: 'json',
            type: 'post',
            beforeSend: function (){
                myInput.parent().find('.thong-bao').html('');
                Metronic.blockUI();
            },
            success: function (data){
                if(data.success){
                    myInput.parent().find('.thong-bao').html('<div class="text-success"><i class="fa fa-check-circle"></i> '+data.content+'</div>');

                    setTimeout(function (){
                        myInput.parent().find('.thong-bao').html('');
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

    $(document).on('change', '.khoi-luong-input', function (){
        var myInput = $(this);
        $.ajax({
            url: 'index.php?r=quan-ly-don-hang/update-khoi-luong',
            data: {
                idDonHang: myInput.attr('data-value'),
                khoiLuong: myInput.val()
            },
            dataType: 'json',
            type: 'post',
            beforeSend: function (){
                myInput.parent().find('.thong-bao').html('');
                Metronic.blockUI();
            },
            success: function (data){
                if(data.success){
                    myInput.parent().find('.thong-bao').html('<div class="text-success"><i class="fa fa-check-circle"></i> '+data.content+'</div>');

                    setTimeout(function (){
                        $.pjax.reload({container: "#crud-datatable-pjax"});
                    }, 3000);

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

    $(document).on('change', '.mua-ho-input', function (){
        var myInput = $(this);
        $.ajax({
            url: 'index.php?r=quan-ly-don-hang/update-phi-mua-ho',
            data: {
                idDonHang: myInput.attr('data-value'),
                chiPhiMuaHo: myInput.val()
            },
            dataType: 'json',
            type: 'post',
            beforeSend: function (){
                myInput.parent().find('.thong-bao').html('');
                Metronic.blockUI();
            },
            success: function (data){
                if(data.success){
                    myInput.parent().find('.thong-bao').html('<div class="text-success"><i class="fa fa-check-circle"></i> '+data.content+'</div>');

                    setTimeout(function (){
                        $.pjax.reload({container: "#crud-datatable-pjax"});
                    }, 3000);

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

    $(document).on('change', '.ship-noi-dia-input', function (){
        var myInput = $(this);
        $.ajax({
            url: 'index.php?r=quan-ly-don-hang/update-phi-ship-noi-dia',
            data: {
                idDonHang: myInput.attr('data-value'),
                chiPhiVanChuyen: myInput.val()
            },
            dataType: 'json',
            type: 'post',
            beforeSend: function (){
                myInput.parent().find('.thong-bao').html('');
                Metronic.blockUI();
            },
            success: function (data){
                if(data.success){
                    myInput.parent().find('.thong-bao').html('<div class="text-success"><i class="fa fa-check-circle"></i> '+data.content+'</div>');

                    setTimeout(function (){
                        $.pjax.reload({container: "#crud-datatable-pjax"});
                    }, 3000);

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


    $(document).on('change', '.chon-don-hang', function (e){
        e.preventDefault();
        $.ajax({
            url: 'index.php?r=quan-ly-don-hang/chon-don-hang',
            data: {
                idDonHang: $(this).val(),
            },
            dataType: 'json',
            type: 'post',
            beforeSend: function (){
            },
            success: function (data){
                loadDonHangDaChon();
            },
            error: function (r1, r2){
                console.log(r1.responseText);
            },
            complete: function (){
            }
        })
    });

    function loadTongTienGioHang(){
        $.ajax({
            url: 'index.php?r=quan-ly-don-hang/get-don-hang-thanh-toan',
            dataType: 'json',
            type: 'post',
            beforeSend: function (){
                $("#block-don-hang-da-chon-de-thanh-toan").html('');
            },
            success: function (data){
                $("#block-don-hang-da-chon-de-thanh-toan").html('<strong>Đơn hàng đã chọn để thanh toán: </strong>');
                $.each(data.donHangDaChon, function (k, v){
                    $("#block-don-hang-da-chon-de-thanh-toan").append('<span class="badge badge-warning">'+v+'<a href="#" class="text-danger btn-xoa-don-hang-da-chon-de-thanh-toan" data-value="'+v+'"> <i class="fa fa-close"></i></a></span> ')
                })
                if (data && data.totalAmount !== undefined) {
                    $('#total-amount').val(data.totalAmount);
                }
            },
            error: function (r1, r2){
                console.log(r1.responseText);
            },
            complete: function (){
            }
        })
    }

    $(document).on('change', '.chon-thanh-toan', function (e){
        e.preventDefault();
        $.ajax({
            url: 'index.php?r=quan-ly-don-hang/chon-thanh-toan',
            data: {
                idDonHang: $(this).val(),
            },
            dataType: 'json',
            type: 'post',
            beforeSend: function (){
            },
            success: function (data){
                if (data && data.totalAmount !== undefined) {
                    $('#total-amount').val(data.totalAmount);
                }
                loadTongTienGioHang();
            },
            error: function (r1, r2){
                console.log(r1.responseText);
            },
            complete: function (){
            }
        })
    });
    $('#total-amount').after('<span class="text-grey font-12px"><span class="text-grey"> VNĐ</span></span>');



    $(document).on('click', '.btn-xoa-don-hang-da-chon', function (e){
        e.preventDefault();
        var $me = $(this);
        $.ajax({
            url: 'index.php?r=quan-ly-don-hang/xoa-don-hang-da-chon',
            data: {
                idDonHang: $me.attr('data-value'),
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

    $(document).on('click', '.btn-xoa-don-hang-da-chon-de-thanh-toan', function (e){
        e.preventDefault();
        var $me = $(this);
        $.ajax({
            url: 'index.php?r=quan-ly-don-hang/xoa-don-hang-da-chon-de-thanh-toan',
            data: {
                idDonHang: $me.attr('data-value'),
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

    $(document).on('click', '.btn-update-trang-thai-don-hang', function (e) {
        e.preventDefault();
        loadForm({type: 'load_form_update_trang_thai_don_hang_loat'}, 'l', function (data) {
        }, function () {
            SaveObject('quan-ly-don-hang/luu-trang-thai-don-hang-loat', $("#form-update-status-hang-load").serializeArray(), function (data) {
                $.pjax.reload({container: '#crud-datatable-pjax'});
                loadDonHangDaChon();
            })
        });
    });

    $(document).on('click', '.remove-list-don-hang-update', function (e){
        e.preventDefault();
        $(this).parent().parent().remove();
    });

    $(document).on('click', '.thanh-toan-don-hang', function (e){
        e.preventDefault();
        loadForm({type: 'load_form_thanh_toan_them_don_hang', 'idDonHang': $(this).attr('data-value')}, 'm', function (data) {
        }, function () {
            SaveObject('quan-ly-don-hang/luu-thanh-toan-them', $("#form-update-status-hang-load").serializeArray(), function (data) {
                $.pjax.reload({container: '#crud-datatable-pjax'});
            })
        });
    });

    $(document).on('click', '.btn-download-don-hang', function (e) {
        e.preventDefault();
        $.ajax({
            url: 'index.php?r=quan-ly-don-hang/index',
            data: {exportExcel: true},
            dataType: 'json',
            type: 'post',
            beforeSend: function () {
                $('.thongbao').html('');
                Metronic.blockUI();
            },
            success: function (data) {
                // $.dialog({
                //     title: data.title,
                //     content: data.link_file,
                // });
                if(data.success)
                    window.open(data.link_file, '_blank').focus();
            },
            complete: function () {
                Metronic.unblockUI();
            },
            error: function (r1, r2) {
                $('.thongbao').html(r1.responseText);
            }
        });
    });

    $(document).on('click', '.btn-download-gio-hang', function (e) {
        e.preventDefault();
        $.ajax({
            url: 'index.php?r=quan-ly-don-hang/gio-hang',
            data: {exportExcel: true},
            dataType: 'json',
            type: 'post',
            beforeSend: function () {
                $('.thongbao').html('');
                Metronic.blockUI();
            },
            success: function (data) {
                // $.dialog({
                //     title: data.title,
                //     content: data.link_file,
                // });
                if(data.success)
                    window.open(data.link_file, '_blank').focus();
            },
            complete: function () {
                Metronic.unblockUI();
            },
            error: function (r1, r2) {
                $('.thongbao').html(r1.responseText);
            }
        });
    });

    function getSelectedRows() {
        var $grid = $('#crud-datatable'); // Sử dụng ID của grid cụ thể
        var keys = [];

        $grid.find("input[name='selection[]']:checked").each(function () {
            var key = $(this).closest('tr').data('value');
            if (key !== undefined) {
                keys.push(key);
            }
        });

        return keys;
    }

    $(document).on('click', '.btn-delete-gio-hang', function (e) {
        var rows = getSelectedRows();
        $.ajax({
            url: 'index.php?r=quan-ly-don-hang/xoa-gio-hang-thanh-vien-khac',
            type: 'POST',
            data: {
                rows: rows
            },
            success: function(response) {
                if (response.success) {
                    window.location.reload();
                } else {
                    alert(response.content);
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('Có lỗi xảy ra. Vui lòng thử lại sau.');
            }
        });
    });
});
