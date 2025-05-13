$(document).ready(function () {
    $('.drop-select').select2();
    setTimeout(function () {
        $('#thang').trigger('change');
        $('#toa-nha-id').trigger('change');
    }, 100);
    $(document).on('change','#thang, #nam, #toa_nha',function (e){
        e.preventDefault();
        var thang = $('#thang').val(),
            nam = $('#nam').val(),
            toaNha = $('#toa_nha').val();
        var today = new Date();
        var curMonth = today.getMonth() + 1,
            curYear = today.getFullYear();

        $.ajax({
            url: 'index.php?r=danh-muc/get-chi-phi',
            type: 'post',
            data: { thang: thang, nam: nam, toaNhaID: toaNha },
            dataType: 'json',
            success: function(data) {
                var htmls = '',
                    group_btn = '';
                $.each(data.content, function (k, obj){
                    htmls += '<tr>';
                    for (var i = 0; i < Object.keys(obj).length; i++) {
                        var key = Object.keys(obj)[i];
                        var value = obj[key];
                        if(i === 0){
                            htmls += '<td>'+value+'</td><input type="hidden" class="form-control" id="ten-chi-phi" value="'+value+'" name="ten_chi_phi[]">';
                        }
                        else if (i === 1){
                            htmls += '<td><input type="text" class="form-control" value="'+value+'" name="ghi_chu[]"></td>';
                        }else if (i === 2){
                            htmls += '<td><input type="text" class="form-control text-right thanh_tien display-number" value="'+value+'" name="thanh_tien[]"></td>';
                        }else{
                            htmls += '<td><input type="text" class="form-control text-right da_thanh_toan display-number" value="'+value+'" name="da_thanh_toan[]"></td>';
                        }
                    }
                    htmls += '<td><center><a href="#" class="text-danger xoa-chi-phi"><i class="fa fa-trash"></i></a></center></td>';
                    htmls += '</tr>';
                });
                group_btn += '<a href="#" class="btn btn-primary" id="them-chi-phi"><i class="fa fa-plus"> Thêm chi phí</i></a>' +
                    '<a href="#" class="btn btn-success" id="luu-chi-phi"><i class="fa fa-save"> Lưu thay đổi</i></a>';
                $('.btn-them').html(group_btn);
                $('#thong_ke').html(htmls);
                $('.tong-chi').html('TỔNG CHI: '+data.tongChi);
                $('.tong-thu').html('TỔNG THU: <span id="tongThu">'+data.tongThu+'</span>');
                $('.loi-nhuan').html('LỢI NHUẬN: '+data.loiNhuan);
            },
            error: function(r1, r2) {
                console.log(r1);
            }
        });
    });
    function updateTongChiPhi(){
        let total = 0;

        $('.thanh_tien').each(function() {
            let value = parseFloat($(this).val().replace(/\./g, "")) || 0;
            total += value;
        });
        let tongThu = $('#tongThu').html(); // Lấy nội dung từ thẻ HTML
        let tongThuInt = parseInt(tongThu.replace(/\./g, ""), 10) || 0;

        let loiNhuan = tongThuInt - total;

        let formattedTotal = total.toLocaleString('vi-VN');
        let formattedLoiNhuan = loiNhuan.toLocaleString('vi-VN');
        $('.tong-chi').html('TỔNG CHI: ' + formattedTotal);
        $('.loi-nhuan').html('LỢI NHUẬN: '+formattedLoiNhuan);
    }
    function thongKe(){
        var toaNhaID = $('#toa-nha-id').val(),
            phongID = $('#phong-id').val(),
            thang = parseInt($('#thang_tk').val()),
            nam = parseInt($('#nam_tk').val()),
            loai = $('#loai-hoa-don').attr('loai');
        $.ajax({
            url: 'index.php?r=hoa-don/thong-ke',
            type: 'post',
            data: {toaNhaID: toaNhaID, phongID: phongID, thang: thang, nam: nam, loai: loai},
            dataType: 'json',
            success: function(data) {
                if (data.success){
                    $('#list-hoa-don').html(data.content);
                    $('.hoan-thanh').html(data.hoanThanh);
                    $('.da-thanh-toan').html(data.daHoanThanh);
                    $('.cong-no').html(data.congNo);
                    $('.con-no').html(data.conNo);
                }else{
                    alert(data.content);
                }
            },
            error: function(r1, r2) {
                console.log(r1);
            }
        });
    }

    $(document).on('click','#them-chi-phi',function (e){
        e.preventDefault();
        var table = $('.danh-sach-chi-phi');
        // var htmls = $('#thong_ke').html();
        var htmls = '<tr><td><input type="text" class="form-control" id="ten-chi-phi" name="ten_chi_phi_them[]"></td>' +
            '<td><input type="text" class="form-control" id="ghi-chu" name="ghi_chu_them[]"></td>' +
            '<td><input type="text" class="form-control text-right thanh_tien display-number" value="0" name="thanh_tien_them[]"></td>' +
            '<td><input type="text" class="form-control text-right da_thanh_toan display-number" value="0" name="da_thanh_toan_them[]"></td>' +
            '<td><center><a href="#" class="text-danger xoa-chi-phi"><i class="fa fa-trash"></i></a></center></td></tr>';
        table.find('tbody').append(htmls);
    });

    $(document).on('click', '.xoa-chi-phi',function (e){
        e.preventDefault();
        if (confirm('Bạn có chắc chắn muốn thực hiện thao tác này?')){
            var parent = $(this).closest('tr');
            var tenChiPhi = parent.find('input[id="ten-chi-phi"]').val();
            var thang = $('#thang').val(),
                nam = $('#nam').val(),
                toaNha = $('#toa_nha').val();
            $.ajax({
                url: 'index.php?r=danh-muc/xoa-chi-phi',
                type: 'post',
                dataType: 'json',
                data: {tenChiPhi: tenChiPhi, thang: thang, nam: nam, toaNha:toaNha},
            }).success(function (data){
                parent.remove();
                updateTongChiPhi();
                $('.thongbao').html('<div class="note note-success">Xóa chi phí thành công!</div>');
            }).error(function (r1,r2){
                console.log(r1.responseText);
            });
        }
    });

    $(document).on('input change','.thanh_tien',function (e){
        e.preventDefault();
        updateTongChiPhi();
    });
    $(document).on('input change','.display-number',function (e){
        e.preventDefault();
        let rawValue = $(this).val().replace(/\D/g, '');
        let formattedValue = rawValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        $(this).val(formattedValue);
    });

    $(document).on('click','#luu-chi-phi',function (e){
        e.preventDefault();
        var loi = false;
        $('input[id="ten-chi-phi"]').each(function() {
            var value = $(this).val().trim();
            if (value === '') {
                loi = true;
            }
        });
        if (loi){
            $.alert({
                title: 'Tên chi phí không hợp lệ!',
                content: 'Vui lòng nhập tên chi phí!',
            });
        }else{
            var formData = new FormData($('#form-chi-phi')[0]);
            $.ajax({
                url: 'index.php?r=danh-muc/luu-chi-phi',
                type: 'post',
                dataType: 'json',
                data: formData,
                contentType: false,
                processData: false
            }).success(function (data){
                $('.thongbao').html('<div class="note note-success">Lưu chi phí dự án thành công!</div>');
            }).error(function (r1,r2){
                console.log(r1.responseText);
            });
        }
    });

    $(document).on('click','.change-month', function (e){
        e.preventDefault();
        var loai = parseInt($(this).attr('loai'));
        var thang = parseInt($('#thang_tk').val()),
            nam = parseInt($('#nam_tk').val());

        if (loai === 1){
            thang += 1;
            if (thang === 13){
                thang = 1;
                nam += 1;
            }
        }else{
            thang -= 1;
            if (thang === 0){
                thang = 12;
                nam -= 1;
            }
        }
        $('#thang_tk').val(thang);
        $('#nam_tk').val(nam).trigger('change');
        $('#select2-chosen-3').html(thang);
        $('#select2-chosen-4').html(nam);
    });

    $(document).on('change','#toa-nha-id',function (e){
        e.preventDefault();
        $.ajax({
            url: 'index.php?r=danh-muc/tim-phong-o',
            type: 'post',
            data: {idToaNha: $('#toa-nha-id').val()},
            dataType: 'json',
            success: function(data) {
                if (data.success){
                    var options = '<option value="">--Chọn--</option>';
                    $.each(data.content, function (k, obj){
                        options += '<option value="' + obj.id + '">' + obj.name + '</option>';
                    });
                    $('#phong-id').html(options);
                }else{
                    alert(data.content);
                }
            },
            error: function(r1, r2) {
                console.log(r1);
            }
        });
    });

    $(document).on('click','#loai-hoa-don',function (e){
        e.preventDefault();
        var loai = $(this).attr('loai');
        var text = '';
        if(loai === 'hoan thanh'){
            loai = 'con no';
            text = 'Còn nợ';
        }else{
            loai = 'hoan thanh';
            text = 'Hoàn thành';
        }
        $(this).attr('loai', loai);
        $(this).html(text);
        thongKe();
    });

    $(document).on('change','.drop-select',function (e){
        e.preventDefault();
        thongKe();
    });
});