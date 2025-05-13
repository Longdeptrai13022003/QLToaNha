$(document).ready(function () {
    $('.drop-select').select2();
    setTimeout(function () {
        $('#toa-nha-id').trigger('change');
    }, 100);
    function thongKe() {
        var toaNhaID = $('#toa-nha-id').val(),
            phongID = $('#phong-id').val(),
            thang = parseInt($('#thang_tk').val()),
            nam = parseInt($('#nam_tk').val()),
            loai = $('#loai-hoa-don').attr('loai');
        $.ajax({
            url: 'index.php?r=danh-muc/thong-ke-moi-gioi',
            type: 'post',
            data: {toaNhaID: toaNhaID, phongID: phongID, thang: thang, nam: nam, loai: loai},
            dataType: 'json',
            success: function (data) {
                if (data.success) {
                    $('#list-hoa-don').html(data.content);
                    $('.hoan-thanh').html(data.hoanThanh);
                    $('.da-thanh-toan').html(data.daHoanThanh);
                    $('.cong-no').html(data.congNo);
                    $('.con-no').html(data.conNo);
                } else {
                    alert(data.content);
                }
            },
            error: function (r1, r2) {
                console.log(r1);
            }
        });
    }

    $(document).on('input change', '.display-number', function (e) {
        e.preventDefault();
        let rawValue = $(this).val().replace(/\D/g, '');
        let formattedValue = rawValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        $(this).val(formattedValue);
    });

    $(document).on('click', '.change-month', function (e) {
        e.preventDefault();
        var loai = parseInt($(this).attr('loai'));
        var thang = parseInt($('#thang_tk').val()),
            nam = parseInt($('#nam_tk').val());

        if (loai === 1) {
            thang += 1;
            if (thang === 13) {
                thang = 1;
                nam += 1;
            }
        } else {
            thang -= 1;
            if (thang === 0) {
                thang = 12;
                nam -= 1;
            }
        }
        $('#thang_tk').val(thang);
        $('#nam_tk').val(nam).trigger('change');
        $('#select2-chosen-3').html(thang);
        $('#select2-chosen-4').html(nam);
    });

    $(document).on('change', '#toa-nha-id', function (e) {
        e.preventDefault();
        $.ajax({
            url: 'index.php?r=danh-muc/tim-phong-o',
            type: 'post',
            data: {idToaNha: $('#toa-nha-id').val()},
            dataType: 'json',
            success: function (data) {
                if (data.success) {
                    var options = '<option value="">--Chọn--</option>';
                    $.each(data.content, function (k, obj) {
                        options += '<option value="' + obj.id + '">' + obj.name + '</option>';
                    });
                    $('#phong-id').html(options);
                } else {
                    alert(data.content);
                }
            },
            error: function (r1, r2) {
                console.log(r1);
            }
        });
    });

    $(document).on('click', '#loai-hoa-don', function (e) {
        e.preventDefault();
        var loai = $(this).attr('loai');
        var text = '';
        if (loai === 'hoan thanh') {
            loai = 'con no';
            text = 'Còn nợ';
        } else {
            loai = 'hoan thanh';
            text = 'Hoàn thành';
        }
        $(this).attr('loai', loai);
        $(this).html(text);
        thongKe();
    });

    $(document).on('change', '.drop-select', function (e) {
        e.preventDefault();
        thongKe();
    });
    $(document).on('input', '.da_thanh_toan', function (e) {
        e.preventDefault();
        let rawValue = $(this).val().replace(/\D/g, '');
        let formattedValue = rawValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        $(this).val(formattedValue);
    });
    $(document).on('change', '.da_thanh_toan', function (e) {
        e.preventDefault();
        var row = $(this).closest('tr');
        var daThanhToan = $(this).val();
        var hopDongID = row.find('.hopDongID').val();
        $.ajax({
            url: 'index.php?r=danh-muc/update-moi-gioi',
            type: 'post',
            data: {hopDongID: hopDongID, daThanhToan: daThanhToan},
            dataType: 'json',
            success: function (data) {
                if (data.success) {
                    if ($('#thanh-cong').is(':empty')){
                        $('#thanh-cong').html('<center><span class="text-success h4">' + data.content + '</span></center>');
                        setTimeout(function() {
                            $('#thanh-cong').fadeOut('slow', function() {
                                $(this).html('');
                                $(this).show();
                            });
                        }, 3000);
                    }
                    thongKe();
                } else {
                    alert(data.content);
                }
            },
            error: function (r1, r2) {
                console.log(r1);
            }
        });
    });
});