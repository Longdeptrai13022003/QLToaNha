$(document).ready(function () {
    $('.drop-select').select2();
    setTimeout(function () {
        $('#toa-nha-id').trigger('change');
    }, 100);
    function thongKe() {
        var toaNhaID = $('#toa-nha-id').val(),
            thang = parseInt($('#thang_tk').val()),
            nam = parseInt($('#nam_tk').val());
        $.ajax({
            url: 'index.php?r=danh-muc/get-chi-phi',
            type: 'post',
            data: {toaNhaID: toaNhaID, thang: thang, nam: nam},
            dataType: 'json',
            success: function (data) {
                if (data.success) {
                    $('#list-chi-phi').html(data.content);
                    $('.tong-chi').html(data.tongTien);
                    $('.da_thanh_Toan').html(data.daThanhToan);
                    $('.con_lai').html(data.conLai);
                } else {
                    alert(data.content);
                }
            },
            error: function (r1, r2) {
                console.log(r1);
            }
        });
    }

    $(document).on('input', '.display-number', function (e) {
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
        $('#select2-chosen-2').html(thang);
        $('#select2-chosen-3').html(nam);
    });

    $(document).on('change', '.drop-select', function (e) {
        e.preventDefault();
        thongKe();
    });

    function danhLaiSTT(table){
        table.find('tbody tr').each(function (index) {
            $(this).find('td:first').text(index + 1);
        });
    }
    $(document).on('click', '.them-chi-phi', function (e) {
        e.preventDefault();
        var table = $(this).closest('table');
        var tr = $(this).closest('tr');
        var html = '<tr>\n' +
            '<input type="hidden" value="-1" name="chiTietID" class="chiTietID">' +
            '        <td></td>\n' +
            '        <td><input type="text" name="ten_chi_phi" class="form-control ten_chi_phi"></td>\n' +
            '        <td><input type="text" name="ghi_chu" class="form-control ghi_chu"></td>\n' +
            '<input type="hidden" value="1" name="moi_gioi" class="moi_gioi">' +
            '        <td><input type="text" name="tong_tien" class="form-control tong_tien display-number text-right" value="0"></td>\n' +
            '        <td><input type="text" name="da_thanh_toan" class="form-control da_thanh_toan display-number text-right" value="0"></td>\n' +
            '        <td><center><a href="#" class="text-primary them-chi-phi"><i class="fa fa-plus"></i></a></center></td>\n' +
            '        <td><center><a href="#" class="text-danger xoa-chi-phi"><i class="fa fa-trash"></i></a></center></td>\n' +
            '    </tr>';
        tr.after(html);
        danhLaiSTT(table);
    });
    $(document).on('click', '.xoa-chi-phi', function (e) {
        e.preventDefault();
        var table = $(this).closest('table');
        var tr = $(this).closest('tr');
        if(tr.find('.moi_gioi').val() === '0'){
            alert('Không thể xóa chi phí môi giới!');
            return;
        }
        if(confirm('Bạn có chắc chắn muốn xóa chi phí?')){
            $.ajax({
                url: 'index.php?r=danh-muc/xoa-chi-phi',
                type: 'post',
                data: {chiTietID: tr.find('.chiTietID').val()},
                dataType: 'json',
                success: function (data) {
                    if (data.success) {
                        tr.remove();
                        $('.thongbao').html('<div class="note note-success">' + data.content + '</div>');
                        danhLaiSTT(table);
                    } else {
                        alert(data.content);
                    }
                },
                error: function (r1, r2) {
                    console.log(r1);
                }
            });
        }
    });

    $(document).on('change', '.da_thanh_toan, .ten_chi_phi, .ghi_chu, .tong_tien', function (e) {
        e.preventDefault();
        var row = $(this).closest('tr');
        var loai = row.find('.moi_gioi').val();
        var ghiChu = row.find('.ghi_chu').val(),
            chiTietID = row.find('.chiTietID').val(),
            daThanhToan = '',
            tongTien = '',
            tenChiPhi = row.find('.ten_chi_phi').val(),
            toaNhaID = $('#toa-nha-id').val(),
            thang = parseInt($('#thang_tk').val()),
            nam = parseInt($('#nam_tk').val());

        console.log(chiTietID);
        if(loai !== '0'){
            daThanhToan = row.find('.da_thanh_toan').val();
            tongTien = row.find('.tong_tien').val();
            if(daThanhToan.trim() === '' || tongTien.trim() === '' || tenChiPhi.trim() === ''){
                return;
            }
        }

        $.ajax({
            url: 'index.php?r=danh-muc/luu-chi-phi',
            type: 'post',
            data: {chiTietID: chiTietID, daThanhToan: daThanhToan, tongTien: tongTien, tenChiPhi: tenChiPhi, ghiChu: ghiChu, toaNhaID: toaNhaID, thang: thang, nam: nam},
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