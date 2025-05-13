function getError($object, $str){
    if($object.val() == ''){
        $object.parent().find('.help-block').text($str);
        $object.parent().find('.help-block').addClass('text-danger');
        return 1;
    }
    return  0;
}

function createTablePlan(){
    $.ajax({
        url:'index.php?r=quan-ly-cong-viec/tao-bang-ke-hoach',
        data: $("#form-lap-ke-hoach").serializeArray(),
        dataType: 'json',
        type: 'post',
        beforeSend: function () {
            Metronic.blockUI();
        },
        success: function (data) {
            $("#table-lap-ke-hoach").html(data.content);
        },
        complete: function () {
            Metronic.unblockUI();
        }
    })
}

$(document).ready(function () {
    $(document).on('click', '.btn-tao-ke-hoach', function (e) {
        e.preventDefault();
        $(".help-block").html('');
        var $loi = getError($("#lapkehoach-nam"), "Vui lòng nhập số năm");
        $loi += getError($("#lapkehoach-type"), 'Vui lòng chọn phân loại kế hoạch');
        $loi += getError($("#lapkehoach-phong_ban_id"), 'Vui lòng chọn phòng ban');
        if($("#lapkehoach-type").val() == 'Công việc, nhiệm vụ')
            $loi += getError($("#lapkehoach-chuc_vu_id"), 'Vui lòng chọn vị trí công việc');
        if($loi == 0){
            if($("#table-lap-ke-hoach").html().trim() == ''){
                createTablePlan();
            }else{
                $.alert({
                    title: 'Thông báo',
                    type: 'orange',
                    content: 'Bạn có chắc chắn muốn thay đổi kế hoạch?',
                    buttons: {
                        btnAccept: {
                            text: '<i class="fa fa-check-circle-o"></i> Đồng ý',
                            action: function(){
                                $("#so-luong-nhom").val(0);
                                createTablePlan();
                            },
                            btnClass: 'btn-primary'
                        },
                        btnCancel: {
                            text: '<i class="fa fa-ban"></i> Huỷ'
                        }
                    }
                });
            }

        }
    });

    $(document).on('change', '#lapkehoach-phong_ban_id', function (e) {
        if($("#lapkehoach-nam").val() != '' && $("#lapkehoach-type").val() != '' && $(this).val() != ''){
            if($("#lapkehoach-type").val() == 'Kế hoạch mục tiêu'){
                $("#lapkehoach-chuc_vu_id").empty();

                // Load thông tin nhiệm vụ phòng ban
                $.ajax({
                    url: 'index.php?r=phong-ban/get-nhiem-vu',
                    data: {phong_ban: $('#lapkehoach-phong_ban_id').val(), nam: $("#lapkehoach-nam").val()},
                    dataType: 'json',
                    type: 'post',
                    beforeSend: function(){
                        $("#table-lap-ke-hoach, .thongbao").html('');
                        Metronic.blockUI();
                    },
                    success: function (data) {
                        $("#table-lap-ke-hoach").html(data.content);
                    },
                    error: function (r1, r2) {
                        $('.thongbao').html(r1.responseText);
                    },
                    complete: function () {
                        Metronic.unblockUI();
                    }
                })
            }
            else if($("#lapkehoach-type").val() == 'Công việc, nhiệm vụ'){
                $("#table-lap-ke-hoach").html('');
                $.ajax({
                    url: 'index.php?r=phong-ban/get-vi-tri-nhan-vien',
                    data: {phongban: $("#lapkehoach-phong_ban_id").val()},
                    dataType: 'json',
                    type: 'post',
                    beforeSend: function () {
                        $('#lapkehoach-chuc_vu_id').empty();
                        $("#lapkehoach-chuc_vu_id").append('<option></option>');
                        Metronic.blockUI();
                    },
                    success: function (data) {
                        $.each(data.nhanviens, function (k, obj) {
                            $("#lapkehoach-chuc_vu_id").append('<option value="'+obj.chuc_vu_id+'">'+obj.chuc_vu+'</option>');
                        })
                    },
                    complete: function () {
                        Metronic.unblockUI();
                    }
                });
            }
        }else
            $("#table-lap-ke-hoach").html('');

    });

    $(document).on('change', '#lapkehoach-nam', function () {
        if($(this).val() != ''){
            if($("#lapkehoach-type").val() == 'Kế hoạch mục tiêu' && $("#lapkehoach-phong_ban_id").val() !='')
                $("#lapkehoach-phong_ban_id").change();
            else if($("#lapkehoach-type").val() == 'Công việc, nhiệm vụ' && $("#lapkehoach-chuc_vu_id").val() != ''){

            }
            else{
                $("#table-lap-ke-hoach").html('');
            }
        }

    });

    $(document).on('click','.btn-save-cong-viec', function (e) {
        e.preventDefault();
        var $url = '';
        if($("#lapkehoach-type").val() == 'Kế hoạch mục tiêu')
            $url = 'save-ke-hoach-phong-ban';
        else
            $url = 'save-muc-tieu-vi-tri';
        SaveObject('quan-ly-cong-viec/'+$url, $("#form-lap-ke-hoach").serializeArray(), function (data) {
            $("#lapkehoach-phong_ban_id").val('');
            $("#lapkehoach-phong_ban_id").change();
        });
    });

    // $(document).on('change', '#lapkehoach-chuc_vu_id', function () {
    //     if($("#lapkehoach-nam").val() != '' && $("#lapkehoach-quy").val() != '') {
    //         $.ajax({
    //             url: 'index.php?r=quan-ly-cong-viec/lap-ke-hoach-nhan-vien',
    //             data: {nam: $("#lapkehoach-nam").val(), chuc_vu: $("#lapkehoach-chuc_vu_id").val(), phongban: $("#lapkehoach-phong_ban_id").val(), quy: $("#lapkehoach-quy").val()},
    //             dataType: 'json',
    //             type: 'post',
    //             beforeSend: function () {
    //                 Metronic.blockUI();
    //                 $('.thongbao').html('');
    //                 $("#table-lap-ke-hoach").html('');
    //             },
    //             success: function (data) {
    //                 $("#table-lap-ke-hoach").html(data.content);
    //             },
    //             error: function (r1, r2) {
    //                 $('.thongbao').html(r1.responseText);
    //             },
    //             complete: function () {
    //                 Metronic.unblockUI();
    //             }
    //         });
    //     }else{
    //         $.alert({
    //             content: 'Chưa có đủ thông tin Năm, Quý, vị trí công việc để lập',
    //             title: 'Thông báo'
    //         })
    //     }
    // });
    //
    $(document).on('change', '#lapkehoach-chuc_vu_id', function () {
        if($("#lapkehoach-nam").val() != '') {
            $.ajax({
                url: 'index.php?r=quan-ly-cong-viec/lap-ke-hoach-nhan-vien',
                data: {nam: $("#lapkehoach-nam").val(), chuc_vu: $("#lapkehoach-chuc_vu_id").val(), phongban: $("#lapkehoach-phong_ban_id").val(), quy: $("#lapkehoach-quy").val()},
                dataType: 'json',
                type: 'post',
                beforeSend: function () {
                    Metronic.blockUI();
                    $('.thongbao').html('');
                    $("#table-lap-ke-hoach").html('');
                },
                success: function (data) {
                    $("#table-lap-ke-hoach").html(data.content);
                    $('.input-diem-so').each(function () {
                        $(this).change();
                    })
                },
                error: function (r1, r2) {
                    $('.thongbao').html(r1.responseText);
                },
                complete: function () {
                    Metronic.unblockUI();
                }
            });
        }else{
            $.alert({
                content: 'Chưa có đủ thông tin Năm, Quý, vị trí công việc để lập',
                title: 'Thông báo'
            })
        }
    });

    $(document).on('click', '.btn-save-cong-viec-nhan-vien', function (e) {
        e.preventDefault();
        var $soluongnvien = $(".tong-diem-nhan-vien").length;
        var $loi = 0;
        $('.tong-diem-nhan-vien').each(function () {
            if(parseInt($(this).text()) > 100)
                $loi++;
        });
        if($loi > 0)
            $.alert('Vui lòng nhập dưới 100 điểm cho mỗi nhân viên');
        else
            SaveObject('quan-ly-cong-viec/save-cong-viec-nhan-vien', $("#form-lap-ke-hoach").serializeArray(), function (data) {
            // $("#lapkehoach-chuc_vu_id").val('');
            // $("#lapkehoach-chuc_vu_id").change();
            })
    });

    $(document).on('change', '#lapkehoach-type', function () {
        if($(this).val() == 'Kế hoạch mục tiêu' || $(this).val() == 'Kế hoạch tập đoàn'){
            $("#lapkehoach-quy, #lapkehoach-chuc_vu_id").attr('disabled', 'disabled');
            if($(this).val() == 'Kế hoạch tập đoàn'){
                $("#lapkehoach-chi_nhanh_id, #lapkehoach-phong_ban_id").attr('disabled', 'disabled');
            }else {
                $("#lapkehoach-chi_nhanh_id, #lapkehoach-quy, #lapkehoach-phong_ban_id").removeAttr('disabled');
            }
            $("#lapkehoach-chuc_vu_id").empty();
            if($("#lapkehoach-phong_ban_id").val() != '' && $("#lapkehoach-nam").val() != '')
                $("#lapkehoach-nam").change();
            else
                $("#table-lap-ke-hoach").html('');
        }else if($(this).val() == 'Công việc, nhiệm vụ'){
            $("#lapkehoach-quy, #lapkehoach-chuc_vu_id").removeAttr('disabled');

            if($("#lapkehoach-phong_ban_id").val() != '')
                $("#lapkehoach-phong_ban_id").change();
        }else{

        }
    });
    $(document).on('change', '.input-diem-so', function () {
        var $dataNhanVien = $(this).attr('data-nhan-vien');
        var $tong_diem = 0;
        $('.input-diem-so-' + $dataNhanVien).each(function () {
            var $myTd = $(this).parent();

            if($myTd.find('.input-thuc-hien').val() == 1){
                $tong_diem += ($(this).val() === '' ? 0 :  Number($(this).val()));
                $tong_diem = parseFloat($tong_diem.toFixed(2));
            }
        });
        $("#tong-diem-"+$dataNhanVien).text($tong_diem);
    });

    $(document).on('change', '.input-thuc-hien', function () {
        var $myTd = $(this).parent();
        $myTd.find('.input-diem-so').change();
    });

    $(document).on('change', '#lapkehoach-quy', function () {
        $("#lapkehoach-chuc_vu_id").change();
    })


});
