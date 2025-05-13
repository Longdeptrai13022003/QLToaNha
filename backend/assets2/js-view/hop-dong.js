$(document).ready(function () {
    // Khởi tạo FullCalendar
    $('#calendar').fullCalendar({
        header: {
            right: 'title',
            center: '',
            left: 'prev,next,today,month,agendaWeek,agendaDay'
        },
        buttonText: {
            today: 'Hôm nay',
            month: 'Tháng',
            week: 'Tuần',
            day: 'Ngày',
        },
        events: function (start, end, timezone, callback) {
            var phongId = $('#phongkhach-phong_id').val();
            if (phongId === null){
                return;
            }
            $.ajax({
                url: 'index.php?r=phong-khach/get-lich-dat',
                type: 'POST',
                dataType: 'json',
                data: {
                    id: phongId,
                    start: start.format('YYYY-MM-DD'),
                    end: end.format('YYYY-MM-DD')
                },
                success: function (response) {
                    if (response.success) {
                        callback(response.result); // Cập nhật sự kiện vào FullCalendar
                    } else {
                        alert('Không có dữ liệu lịch đặt');
                    }
                },
                error: function (r1,r2) {
                    console.log(r1.message);
                }
            });
        }
    });

    $('#phongkhach-phong_id').select2();
    setTimeout(function () {
        $('#phongkhach-phong_id').trigger('change');
    }, 100);
    $('#ajaxCrudModal').on('shown.bs.modal', function () {
        $('.toanha_input').trigger('change');
    });

    function updatePhong(){
        if($('#toa-nha-id').val()===''){
            $('#phongkhach-phong_id').empty();
            $('#select2-chosen-1').html('');
            $('#ten_phong').html('');
            $('#bang_gia').html('');
        }else{
            var ngayTu = $('#phongkhach-thoi_gian_hop_dong_tu').val() + ' ' + $('#gio_vao').val() + ':' + $('#phut_vao').val();
            var ngayDen = $('#phongkhach-thoi_gian_hop_dong_den').val() + ' ' + $('#gio_ra').val() + ':' + $('#phut_ra').val();
            $.ajax({
                url: 'index.php?r=danh-muc/tim-phong-o',
                type: 'post',
                data: { idToaNha: $('#toa-nha-id').val(), ngayTu: ngayTu, ngayDen: ngayDen},
                dataType: 'json',
                success: function(data) {
                    if (data.success){
                        $('#select2-chosen-1').html('');
                        $('#ten_phong').html('');
                        $('#bang_gia').html('');
                        var options = '<option value="">--Chọn--</option>';
                        $.each(data.content, function (k, obj){
                            options += '<option value="' + obj.id + '">' + obj.name + '</option>';
                        });
                        $('#phongkhach-phong_id').html(options);
                    }else{
                        alert(data.content);
                    }
                },
                error: function(r1, r2) {
                    console.log(r1);
                }
            });
        }
    }
    function getForm(id){
        if ($('#hop_dong_id').length){
            id = parseInt($('#hop_dong_id').val());
        }
        var goi = $('#phongkhach-loai_hop_dong').val();

        if (goi === ''){
            return;
        }
        if (goi === 'thang'){
            if (!$('#so_thang').length){
                var html = '<tr><td>Số tháng: </td><td id="so_thang" class="text-right"></td></tr>';
                $('#block-so-thang').html(html);
                $('#phongkhach-phong_id').trigger('change');
            }
            $.ajax({
                url: 'index.php?r=phong-khach/get-form-thong-tin',
                type: 'post',
                data: {goi: goi, id:id},
                dataType: 'json',
                success: function(data) {
                    if (data.success){
                        $('#block-thong-tin').html(data.content);
                    }
                },
                error: function(r1, r2) {
                    console.log(r1);
                }
            });
        }else{
            $('#block-thong-tin').html('');
            $('#block-so-thang').html('');

            var time = $('#phongkhach-thoi_gian_hop_dong_tu').val() + ' ' + $('#gio_vao').val() + ':' + $('#phut_vao').val();
            $.ajax({
                url: 'index.php?r=danh-muc/get-ngay-thang',
                type: 'post',
                data: {goi: goi, time: time},
                dataType: 'json',
                success: function(data) {
                    if (data.success){
                        $('#phongkhach-thoi_gian_hop_dong_den').val(data.ngay);
                        $('#gio_ra').val(data.gio);
                        $('#phut_ra').val(data.phut);
                    }
                },
                error: function(r1, r2) {
                    console.log(r1);
                }
            });
        }
    }
    getForm(-1);
    $(document).on('change','#phongkhach-loai_hop_dong',function (e){
        e.preventDefault();
        $('#phongkhach-phong_id').trigger('change');
        getForm(-1);
        updateMoiGioi();
    });

    function updateBangGia(){
        var id = $('#phongkhach-phong_id').val();
        if(id === null){
            return;
        }
        console.log(id);
        $.ajax({
            url: 'index.php?r=danh-muc/get-bang-gia',
            type: 'post',
            data: {id: id},
            dataType: 'json',
            success: function(data) {
                if (data.success){
                    var giaDichVus = data.content;
                    var html = '';
                    $.each(giaDichVus, function (index, item) {
                        html += '<tr><td>' + item.label + '</td><td><input class="text-right form-control txt_dich_vu" name="'+item.name+'" type="text" value="' + parseInt(item.value).toLocaleString('it-IT') + '"></td></tr>';
                    });
                    $('#bang_gia').html(html);
                    $('#ten_phong').html(data.tenPhong);
                }
            },
            error: function(r1, r2) {
                console.log(r1);
            }
        });
    }

    $(document).on('change','#toa-nha-id',function (e){
        e.preventDefault();
        updatePhong();
    });

    function getDiffDate(){
        var fromDate = $('#phongkhach-thoi_gian_hop_dong_tu').val(),
            toDate = $('#phongkhach-thoi_gian_hop_dong_den').val();
        var arrFromDate = fromDate.split('/');
        var arrToDate = toDate.split('/');
        var d1 = new Date(arrFromDate[2],arrFromDate[1]-1,arrFromDate[0]);
        var d2 = new Date(arrToDate[2],arrToDate[1]-1,arrToDate[0]);

        var truMili = Math.abs(d2 - d1);
        return  Math.ceil(truMili / (1000 * 60 * 60 * 24)) + 1;
    }
    function updateMoiGioi(){
        var goi = $('#phongkhach-loai_hop_dong').val();
        var moiGioi = parseInt($('#phongkhach-moi_gioi').val().replace(/\./g, '')) || 0,
            thanhTien = 0,
            donGia = parseInt($("#don_gia").text().replaceAll('.','')) || 0,
            kieuMoiGioi = $('#phongkhach-kieu_moi_gioi').val(),
            phiMoiGioi = 0;

        if (goi === 'thang'){
            thanhTien = parseInt($('#don_gia').text().replace(/\./g, '')) || 0;
        }else if (goi === 'ngay'){
            thanhTien = donGia * getDiffDate();
        }else if (goi === '3_gio'){
            thanhTien = 3 * donGia;
        }else if (goi === '6_gio'){
            thanhTien = 6 * donGia;
        }
        if (kieuMoiGioi === '%'){
            phiMoiGioi = thanhTien * moiGioi / 100;
        }else{
            phiMoiGioi = moiGioi;
        }
        $('#so_tien_moi_gioi').text(phiMoiGioi.toLocaleString('vi',{maximumFractionDigits: 0}));
    }
    $(document).on('change','#phongkhach-moi_gioi, #thanh_tien_sau_chiet_khau, #phongkhach-kieu_moi_gioi',function (e){
        e.preventDefault();
        updateMoiGioi();
    });

    $(document).on('change','#phongkhach-phong_id',function (e){
        e.preventDefault();
        if ($(this).val() === ''){
            return;
        }
        $('#calendar').fullCalendar('refetchEvents');
        $.ajax({
            url: 'index.php?r=danh-muc/get-don-gia-phong',
            type: 'post',
            data: { idPhong: $(this).val(), goi: $('#phongkhach-loai_hop_dong').val()},
            dataType: 'json',
            success: function(data) {
                if(data.success){
                    var donGia = data.content === null ? 0 : parseInt(data.content).toLocaleString('vi',{maximumFractionDigits: 0});
                    $('#don_gia').text(donGia);
                    updateTongTien();
                    updateBangGia();
                }
                else {
                    $('#don_gia').text(0);
                }
            },
            error: function(r1, r2) {
                console.log(r1);
            }
        });
    });
    function formatCurrency(number) {
        return number.toLocaleString('vi-VN');
    }
    $(document).on('change', '#phongkhach-thoi_gian_hop_dong_tu, #phongkhach-thoi_gian_hop_dong_den, #gio_vao, #gio_ra, #phut_vao, #phut_ra', function (e){
        e.preventDefault();
        if ($('#phongkhach-loai_hop_dong').val() !== 'thang' && $('#phongkhach-loai_hop_dong').val() !== 'ngay'){
            getForm(-1);
        }
        updateTongTien();
        // setTimeout(function () {
        //     updatePhong();
        // }, 100);
    });
    $(document).on('change', '#phongkhach-chiet_khau, #phongkhach-kieu_chiet_khau,#phongkhach-coc_truoc', function (e){
        e.preventDefault();
        updateTongTien();
    });

    function parseDate(input) {
        var parts = input.split('/');
        return new Date(parts[2], parts[1] - 1, parts[0]);
    }
    function createDatePicker(){
        $("#thoi-gian-tu-tu, #thoi-gian-tu-den, #thoi-gian-den-tu, #thoi-gian-den-den").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd/mm/yy'
        });
    }
    createDatePicker();
    $(document).on('pjax:end', function() {
        createDatePicker(); // Khởi tạo lại DatePicker sau khi PJAX load lại
    });

    function updateTongTien(donGiaPhong = null) {
        var donGia = donGiaPhong !== null ? parseInt(donGiaPhong.replaceAll('.','')) : ($('#don_gia').text() === '' ? 0 :  parseInt($("#don_gia").text().replaceAll('.',''))),
            tienChietKhau = 0,
            thanhTien = 0,
            giaTriChietKhau = $('#phongkhach-chiet_khau').val().replaceAll(/\./g, ''),
            fromDate = $('#phongkhach-thoi_gian_hop_dong_tu').val(),
            toDate = $('#phongkhach-thoi_gian_hop_dong_den').val();

        var goi = $('#phongkhach-loai_hop_dong').val();

        giaTriChietKhau = giaTriChietKhau === '' ? 0 : parseInt(giaTriChietKhau);
        if($('#phongkhach-kieu_chiet_khau').val()==='%'){
            tienChietKhau = parseInt(giaTriChietKhau*donGia/100);
        }
        else{
            tienChietKhau = giaTriChietKhau;
        }

        var arrFromDate = fromDate.split('/');
        var arrToDate = toDate.split('/');
        var tongTien = donGia-tienChietKhau;
        if (goi === 'thang'){
            var soNam = parseInt(arrToDate[2]) - (parseInt(arrFromDate[2])),
                soThangChenhLech = (parseInt(arrToDate[1])-parseInt(arrFromDate[1]))+1+soNam*12;
            tongTien = tongTien*soThangChenhLech;

            $('#so_thang').text(soThangChenhLech);
        }else if (goi === 'ngay'){
            tongTien = tongTien * getDiffDate();
        }

        thanhTien = tongTien;
        $('#so_tien_chiet_khau').text(tienChietKhau.toLocaleString('vi',{maximumFractionDigits: 0}));
        $('#thanh_tien_sau_chiet_khau').text(thanhTien.toLocaleString('vi',{maximumFractionDigits: 0})).trigger('change');

        var tienCoc = parseInt($('#phongkhach-coc_truoc').val().replaceAll(/\./g, '') === '' ? 0 : parseInt($('#phongkhach-coc_truoc').val().replaceAll(/\./g, '')));
        $('#con-lai-phai-tra').text((thanhTien - tienCoc).toLocaleString('vi',{maximumFractionDigits: 0}));
    }
    $(document).on('click','.btn-save-hop-dong',function (e){
        e.preventDefault();
        if ($('#phongkhach-loai_hop_dong').val() === ''){
            alert('Vui lòng chọn gói thuê phòng!');
            return;
        }
        var formData = new FormData($('#form-them-hop-dong')[0]);
        $.ajax({
            url: 'index.php?r=phong-khach/save-hop-dong',
            type: 'post',
            dataType: 'json',
            data: formData,
            contentType: false,
            processData: false
        }).success(function (data){
            if (data.success){
                $.confirm({
                    title: 'Thành công',
                    content: data.content,
                    buttons: {
                        'quay_lai': {
                            text: 'Quay lại danh sách',
                            btnClass: 'btn-blue',
                            action: function () {
                                window.location.href = 'index.php?r=phong-khach/index';
                            }
                        },
                        'tao_them': {
                            text: 'Tạo thêm',
                            btnClass: 'btn-green',
                            action: function () {
                                location.reload();
                            }
                        }
                    }
                });
            }else {
                alert(data.content);
            }
        }).error(function (r1,r2){
            console.log(r1.responseText);
        });
    });

    function recursiveLoadForm(modelData, errorData) {
        loadForm({type: 'load_form_khach_hang', model: modelData, error: errorData}, 'l', function (data) {
        }, function () {
            var formData = new FormData($("#form-khach-hang")[0]);

            SaveObjectUploadFile('user/popup-khach-hang', formData, function (response) {
                if (response.success) {
                    $.pjax.reload({ container: '#crud-datatable-pjax' });
                } else {
                    recursiveLoadForm(response.model, response.error);
                }
            });
        });
    }

    var dialogKhachHang;
    $(document).on('click', '#btn-them-khach-hang', function (e){
        e.preventDefault();
        $.dialog({
            content: function () {
                dialogKhachHang = this;
                return $.ajax({
                    url: 'index.php?r=user/them-khach-hang',
                    type: 'get',
                    dataType: 'json'
                }).success(function (data) {
                    var $bockSaveBtn = '<p class="padding-top-10px text-right"><a href="#" class="btn btn-primary btn-save-khach-hang"><i class="fa fa-save"></i> Lưu khách hàng</a></p>';
                    dialogKhachHang.setContent('<div id="block-form-user">'+data.content+'</div>'+$bockSaveBtn);
                    dialogKhachHang.setTitle(data.title);
                    dialogKhachHang.setType('blue');
                }).error(function (r1, r2) {
                    dialogKhachHang.setContent(getMessage(r1.responseText));
                    dialogKhachHang.setTitle('Thông báo');
                    dialogKhachHang.setType('red');
                    dialogKhachHang.$$btnSave.prop('disabled', true);
                    return false;
                });
            },
            columnClass: 'l',
        });
    });

    var dialogSale;
    $(document).on('click', '#btn-them-sale', function (e){
        e.preventDefault();
        $.dialog({
            content: function () {
                dialogSale = this;
                return $.ajax({
                    url: 'index.php?r=user/create',
                    type: 'get',
                    dataType: 'json'
                }).success(function (data) {
                    var $bockSaveBtn = '<p class="padding-top-10px text-right"><a href="#" class="btn btn-primary btn-save-sale"><i class="fa fa-save"></i> Lưu sale</a></p>';
                    dialogSale.setContent('<div id="block-form-user">'+data.content+'</div>'+$bockSaveBtn);
                    dialogSale.setTitle(data.title);
                    dialogSale.setType('blue');
                }).error(function (r1, r2) {
                    dialogSale.setContent(getMessage(r1.responseText));
                    dialogSale.setTitle('Thông báo');
                    dialogSale.setType('red');
                    dialogSale.$$btnSave.prop('disabled', true);
                    return false;
                });
            },
            columnClass: 'l',
        });
    });

    $(document).on('click', '#btn-chon-khach-hang', function (e){
        e.preventDefault();
        $('#modal-danh-sach-khach-hang').modal('show');
    });

    $(document).on('click', '#btn-chon-sale', function (e){
        e.preventDefault();
        $('#modal-danh-sach-sale').modal('show');
    });

    $(document).on('click change', '.chon-khach-hang-radio-btn', function (e){
        var idkhachhang = $(this).val(),
            hoten = $(this).parent().parent().parent().find('.td-ho-ten').text(),
            dienthoai = $(this).parent().parent().parent().find('.td-dien-thoai').text(),
            btnXoaKhachDaChon = "<a href=\"#\" class=\"text-danger\" id=\"xoa-khach-da-chon\"><i class=\"fa fa-close\"></i> Xóa</a>";
        $('#phongkhach-khach_hang_id').val(idkhachhang);
        $('#khach-hang-da-chon').html('<strong>Khách: </strong>'+hoten+' ('+dienthoai+') '+ btnXoaKhachDaChon);
    });

    $(document).on('click change', '.chon-sale-radio-btn', function (e){
        var idSale = $(this).val(),
            hoten = $(this).parent().parent().parent().find('.td-ho-ten').text(),
            dienthoai = $(this).parent().parent().parent().find('.td-dien-thoai').text(),
            btnXoaSaleDaChon = "<a href=\"#\" class=\"text-danger\" id=\"xoa-sale-da-chon\"><i class=\"fa fa-close\"></i> Xóa</a>";
        $('#phongkhach-sale_id').val(idSale);
        $('#sale-da-chon').html('<strong>Sale: </strong>'+hoten+' ('+dienthoai+') '+ btnXoaSaleDaChon);
    });

    $(document).on('click', '#btn-quay-lai-danh-sach', function (e){
        e.preventDefault();
        window.location.href = 'index.php?r=phong-khach/index';
    });

    $(document).on('click', '#xoa-khach-da-chon', function (e){
        e.preventDefault();
        $('#khach-hang-da-chon').html('');
        $('#phongkhach-khach_hang_id').val('');
    });

    $(document).on('click', '#xoa-sale-da-chon', function (e){
        e.preventDefault();
        $('#sale-da-chon').html('');
        $('#phongkhach-sale_id').val('');
    });

    $(document).on('click', '.btn-save-khach-hang',function (e){
        e.preventDefault();
        var data = new FormData($("#form-them-khach-hang")[0]);
        $.ajax({
            url: 'index.php?r=user/them-khach-hang',
            type: 'post',
            dataType: 'json',
            data: data,
            contentType: false,
            processData: false
        }).success(function (data){
            $('#block-form-user').html(data.content);
            if(data.success){
                $('.btn-save-khach-hang').parent().remove();
                $('.thongbao').html('<div class="note note-success">Thêm khách hàng thành công!</div>');
                dialogKhachHang.close();

                $.pjax.reload({container: '#crud-datatable-pjax', timeout: 2000});
            }
        }).error(function (r1,r2){

        });
    });

    $(document).on('click', '.btn-save-sale',function (e){
        e.preventDefault();
        var data = new FormData($("#form-them-user")[0]);
        $.ajax({
            url: 'index.php?r=user/create',
            type: 'post',
            dataType: 'json',
            data: data,
            contentType: false,
            processData: false
        }).success(function (data){
            $('#block-form-user').html(data.content);
            if(data.success){
                $('.btn-save-sale').parent().remove();
                $('.thongbao').html('<div class="note note-success">Thêm Sale thành công!</div>');
                dialogSale.close();

                $.pjax.reload({container: '#crud-datatable-sale-pjax', timeout: 2000});
            }
        }).error(function (r1,r2){

        });
    });

    $(document).on('click', '.btn-update-hop-dong',function (e){
        e.preventDefault();
        if ($('#phongkhach-loai_hop_dong').val() === ''){
            alert('Vui lòng chọn gói thuê phòng!');
            return;
        }
        if (confirm('Chỉnh sửa hợp đồng sẽ làm mới hóa đơn và giao dịch')){
            var formData = new FormData($('#form-them-hop-dong')[0]);
            $.ajax({
                url: 'index.php?r=phong-khach/save-update',
                type: 'post',
                dataType: 'json',
                data: formData,
                contentType: false,
                processData: false
            }).success(function (data){
                if (data.success){
                    $.confirm({
                        title: 'Thành công',
                        content: data.content,
                        buttons: {
                            'quay_lai': {
                                text: 'Quay lại danh sách',
                                btnClass: 'btn-blue',
                                action: function () {
                                    window.location.href = 'index.php?r=phong-khach/index';
                                }
                            },
                            'tao_them': {
                                text: 'Chỉnh sửa',
                                btnClass: 'btn-green',
                                action: function () {
                                    location.reload();
                                }
                            }
                        }
                    });
                }else {
                    alert(data.content);
                }
            }).error(function (r1,r2){
                console.log(r1.responseText);
            });
        }
    });

    $(document).on('click','.btn-xoa-hop-dong',function (e){
        e.preventDefault();
        var hopDongID = $(this).attr('data-value');
        $.ajax({
            url: 'index.php?r=phong-khach/kiem-tra',
            type: 'post',
            dataType: 'json',
            data: {hopDongID: hopDongID},
        }).success(function (data){
            if (data.success){
                if (confirm('Bạn có chắc chắn muốn xóa hợp đồng?')) {
                    $.ajax({
                        url: 'index.php?r=phong-khach/delete',
                        type: 'post',
                        data: {hopDongID: hopDongID},
                        success: function (response) {
                            if (response.success) {
                                $('.thongbao').html('<div class="note note-success">' + response.content + '</div>');
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
            }
            else
                alert('Chỉ xóa hợp đồng trong 48 giờ sau khi tạo!');
        }).error(function (r1,r2){

        });
    });

    $(document).on('click','#btn-xoa-anh-hop-dong',function (e){
        e.preventDefault();
        var fid = $(this).attr('data-value');
        var parent = $(this).parent();
        if (confirm('Bạn có chắc chắn muốn xóa ảnh này?')){
            $.ajax({
                url: 'index.php?r=phong-khach/xoa-file-hop-dong',
                type: 'post',
                data: {fid: fid},
                success: function (response) {
                    if (response.success) {
                        parent.remove();
                    } else {
                        alert('Không tìm thấy file hợp đồng!');
                    }
                },
                error: function () {
                    alert('Có lỗi xảy ra. Vui lòng thử lại.');
                }
            });
        }
    });

    $(document).on('click','.btn-thanh-toan',function (e){
        e.preventDefault();
        var conLai = parseInt($('#con_lai').val()),
            soTien = parseInt($('#so_tien').val().replaceAll(/\./g, '')),
            toiThieu = 0;
        var fileInput = document.getElementById('anh-chuyen-khoan');

        $.ajax({
            url: 'index.php?r=cauhinh/get-minimum',
            type: 'get',
            success: function (response) {
                if (response.success){
                    toiThieu = parseInt(response.content);
                }
                if (soTien <= toiThieu){
                    alert('Số tiền giao dịch phải lớn hơn ' + toiThieu.toString() + '!');
                }
                else if(conLai < soTien){
                    alert('Số tiền giao dịch vượt quá số tiền cần trả!');
                }
                else if(fileInput.files.length === 0){
                    alert('Chưa chọn ảnh chuyển khoản cho giao dịch!');
                }
                else {
                    var data = new FormData($('#form-thanh-toan')[0]);
                    $.ajax({
                        url: 'index.php?r=phong-khach/save-giao-dich',
                        type: 'post',
                        data: data,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            if (response.success){
                                $('#form-thanh-toan').html('<p class="text-success">Thanh toán hợp đồng thành công!</p>');
                                $('.btn-thanh-toan').remove();
                                $('.btn-dong').remove();
                                $.pjax.reload({container: '#crud-datatable-pjax', timeout: 2000});
                            }
                            else {
                                $('#form-thanh-toan').html('Đã xảy ra lỗi!');
                            }
                        },
                        error: function () {
                            alert('Có lỗi xảy ra. Vui lòng thử lại.');
                        }
                    });
                }
            },
            error: function () {
                alert('Không lấy được số tiền tối thiểu');
            }
        });
    });

    $(document).on('click','.btn-thanh-toan-moi-gioi',function (e){
        e.preventDefault();
        var conLai = parseInt($('#con_lai').val()),
            soTien = parseInt($('#so_tien').val().replaceAll(/\./g, '')),
            toiThieu = 0;

        $.ajax({
            url: 'index.php?r=cauhinh/get-minimum',
            type: 'get',
            success: function (response) {
                if (response.success){
                    toiThieu = parseInt(response.content);
                }
                if (soTien <= toiThieu){
                    alert('Số tiền giao dịch phải lớn hơn ' + toiThieu.toString() + '!');
                }
                else if(conLai < soTien){
                    alert('Số tiền giao dịch vượt quá số tiền cần trả!');
                }
                else {
                    var data = new FormData($('#form-thanh-toan-moi-gioi')[0]);
                    $.ajax({
                        url: 'index.php?r=phong-khach/save-moi-gioi',
                        type: 'post',
                        data: data,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            if (response.success){
                                $('#ajaxCrudModal').modal('hide');
                                $('.thongbao').html('<div class="note note-success">Thanh toán môi giới hợp đồng thành công!</div>');
                                $.pjax.reload({container: '#crud-datatable-pjax', timeout: 2000});
                            }
                            else {
                                $('#form-thanh-toan-moi-gioi').html(response.content);
                            }
                        },
                        error: function () {
                            alert('Có lỗi xảy ra. Vui lòng thử lại.');
                        }
                    });
                }
            },
            error: function () {
                alert('Không lấy được số tiền tối thiểu');
            }
        });
    });

    $(document).on('click', '#btn-sua-hop-dong', function (e){
        e.preventDefault();
        var hopDongID = parseInt($(this).attr('data-value'));
        console.log(hopDongID);
        $.ajax({
            url: 'index.php?r=phong-khach/kiem-tra',
            type: 'post',
            dataType: 'json',
            data: {hopDongID: hopDongID},
        }).success(function (data){
            if (data.success)
                window.location.href = 'index.php?r=phong-khach/update&id=' + hopDongID;
            else
                alert('Chỉ sửa hợp đồng trong '+data.thoiGian+' giờ sau khi tạo!');
        }).error(function (r1,r2){

        });
    });

    $(document).on('click', '#btn-purchase',function (e){
        var modal = $('#ajaxCrudModal');
        modal.find('.modal-dialog').removeClass('modal-lg').removeClass('modal-sm');
        modal.find('.modal-dialog').addClass('');
        modal.modal('show');
    });

    $(document).on('click', '#btn-view',function (e){
        var modal = $('#ajaxCrudModal');
        modal.find('.modal-dialog').removeClass('').removeClass('modal-sm');
        modal.find('.modal-dialog').addClass('modal-lg');
        modal.modal('show');
    });

    $(document).on('click', '.table-khach-hang tr', function (e) {
        var radioButton = $(this).find('.chon-khach-hang-radio-btn');
        if (!radioButton.prop('checked')) {
            radioButton.prop('checked', true).trigger('change');
        }
    });

    $(document).on('click', '.table-sale tr', function (e) {
        var radioButton = $(this).find('.chon-sale-radio-btn');
        if (!radioButton.prop('checked')) {
            radioButton.prop('checked', true).trigger('change');
        }
    });

    $(document).on('input change', '#so_tien, .hien_thi_tien, .txt_dich_vu',function (e){
        let rawValue = $(this).val().replace(/\D/g, '');
        let formattedValue = rawValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        $(this).val(formattedValue);
    });

    $(document).on('click','.btn-them-o-cung',function (e){
        e.preventDefault();
        var row = $(this).closest('tr');
        var htmls = '<tr><td><input type="text" name="ho_ten[]" class="form-control"></td>' +
            '<td><input type="text" name="dien_thoai[]" class="form-control"></td>' +
            '<td id="re-them"><center><a href="#" class="text-primary btn-them-o-cung"><i class="fa fa-plus"></i></a></center></td>' +
            '<td><center><a href="#" class="text-danger btn-xoa-o-cung" id="xoa-du-lieu"><i class="fa fa-trash"></i></a></center></td></tr>';
        row.after(htmls);
    });

    $(document).on('click','.btn-xoa-o-cung',function (e){
        e.preventDefault();
        var row = $(this).closest('tr');
        var totalRows = row.siblings('tr').length + 1; // Đếm tổng số hàng trong bảng (bao gồm hàng hiện tại)

        if (totalRows > 1) {
            row.remove();
        } else {
            alert('Không thể xóa! Cần giữ lại ít nhất một hàng!');
        }
    });
    $(document).on('click','.btn-hoan-thanh',function (e){
        e.preventDefault();
        var hopDongID = $(this).attr('data-value'),
            loai = $(this).attr('loai');
        if (confirm('Bạn có chắc chắn muốn xóa hợp đồng?')) {
            $.ajax({
                url: 'index.php?r=phong-khach/hoan-thanh',
                type: 'post',
                data: {id: hopDongID,loai: loai},
                success: function (response) {
                    if (response.success) {
                        $('.thongbao').html('<div class="note note-success">' + response.content + '</div>');
                        $.pjax({container: "#crud-datatable-pjax"});
                    } else {
                        alert(response.content);
                    }
                },
                error: function () {
                    alert('Có lỗi xảy ra. Vui lòng thử lại.');
                }
            });
        }
    });
});
