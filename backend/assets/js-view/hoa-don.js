$(document).ready(function () {
    var tr;
    setTimeout(function () {
        $('#thang').trigger('change');
    }, 100);
    $('#thang, #nam').select2();
    function tienDien(soDau, soCuoi, bangGiaID, callback) {
        $.ajax({
            url: 'index.php?r=phong-khach/get-tien-dien',
            type: 'post',
            dataType: 'json',
            data: {soDau: soDau, soCuoi: soCuoi, bangGiaID: bangGiaID},
            success: function (data) {
                callback(data.tienDien);
            },
            error: function () {
                callback(0);
            }
        });
    }
    function tienNuoc(soDau, soCuoi, bangGiaID, callback) {
        $.ajax({
            url: 'index.php?r=gia-nuoc/get-tien-nuoc',
            type: 'post',
            dataType: 'json',
            data: {soDau: soDau, soCuoi: soCuoi, bangGiaID: bangGiaID},
            success: function (data) {
                callback(data.tienNuoc);
            },
            error: function () {
                callback(0);
            }
        });
    }

    function getNganHan(){
        var loai = $('#goi_thue').val();
        if (loai === 'thang'){
            $('#thang').trigger('change');
            return;
        }
        var thang = $('#thang').val(),
            nam = $('#nam').val(),
            toaNha = $('#toa_nha').val();
        $.ajax({
            url: 'index.php?r=hoa-don/get-ngan-han',
            type: 'post',
            data: {loai:loai, thang: thang, nam: nam, toa_nha_id: toaNha},
            dataType: 'json',
            success: function(data) {
                var saveBtn = '<a href="#" class="btn btn-success" id="btn-thanh-toan"><i class="fa fa-money"></i> Tạo giao dịch</a>',
                    doanhThu = '';
                $('#bang-hoa-don').html(data.content);
                $('.thongbao').html('');
                doanhThu = parseInt(data.doanhThu);
                $('.btn-save-bill').html(saveBtn);
                $('.doanh-thu').html(doanhThu.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
            },
            error: function(r1, r2) {
                console.log(r1);
            }
        });
    }

    $(document).on('change','#goi_thue',function (e){
        e.preventDefault();
        getNganHan();
    });
    function updateTongTien(trLocal = null){
        var tr = trLocal || window.tr; // Ưu tiên sử dụng trLocal, nếu không sẽ dùng tr toàn cục
        if (!tr) {
            console.error("Không tìm thấy đối tượng tr!");
            return;
        }
        var id = tr.find('.check-chon').val();
        // var bangDienID = $('#gia_dien').val();

        var dienDau = tr.find('.so-dau').val(),
            dienCuoi = tr.find('.so-cuoi').val(),
            phuPhi = tr.find('.phu-phi').val();

        var nuocDau = '-1',
            nuocCuoi = '-1';
        if (tr.find('.so-nuoc-dau').length > 0) {
            nuocDau = tr.find('.so-nuoc-dau').val();
            nuocCuoi = tr.find('.so-nuoc-cuoi').val();
        }
        console.log(id);

        $.ajax({
            url: 'index.php?r=hoa-don/cap-nhap-dich-vu',
            type: 'post',
            data: {dienDau: dienDau, dienCuoi: dienCuoi, nuocDau: nuocDau, nuocCuoi: nuocCuoi, phuPhi: phuPhi, hoaDonID: id, thang: $('#thang').val(), nam: $('#nam').val()},
            dataType: 'json',
            success: function(data) {
                if (data.success){
                    tr.find('.tong_tien').html(data.thanh_tien);
                    tr.find('.thanh-tien-dien').html(data.tienDien);
                    tr.find('.thanh-tien-nuoc').html(data.tienNuoc);
                    var doanhThu = $('.doanh-thu').html().toString().replace(/\./g, '');
                    if (doanhThu.trim() !== ''){
                        $('.doanh-thu').html((parseInt(doanhThu) + parseInt(data.chenhLech)).toLocaleString('vi-VN'));
                    }
                    if ($('#thanh-cong').is(':empty')){
                        $('#thanh-cong').html('<center><span class="text-success h4">Cập nhật hóa đơn thành công</span></center>');
                        setTimeout(function() {
                            $('#thanh-cong').fadeOut('slow', function() {
                                $(this).html('');
                                $(this).show();
                            });
                        }, 3000);
                    }
                }
            },
            error: function(r1, r2) {
                console.log(r1);
            }
        });
    }

    $(document).on('change input','.so-dau, .so-cuoi, .phu-phi',function (e){
        e.preventDefault();
        tr = $(this).closest('tr');
        updateTongTien(tr);
    });

    $(document).on('change','.so-nuoc-dau, .so-nuoc-cuoi',function (e){
        var trL = $(this).closest('tr');
        var soDau = trL.find('.so-nuoc-dau').val().toString().replace(/\./g, '');
        var soCuoi = trL.find('.so-nuoc-cuoi').val().toString().replace(/\./g, '');

        if (soDau.trim() === '' || soCuoi.trim() === ''){
            return;
        }
        updateTongTien(trL);
    });

    $(document).on('change','#thang, #nam, #toa_nha, #kieu_tien_nuoc',function (e){
        var loai = $('#goi_thue').val();
        var thang = $('#thang').val(),
            nam = $('#nam').val(),
            toaNha = $('#toa_nha').val();
        var today = new Date();
        var curMonth = today.getMonth() + 1,
            curYear = today.getFullYear();
        var kieuTienNuoc = $('#kieu_tien_nuoc').val();
        if (thang === '' || nam === '' || toaNha === ''){
            return;
        }
        if (loai === 'thang'){
            $.ajax({
                url: 'index.php?r=hoa-don/get-hoa-don',
                type: 'post',
                data: { thang: thang, nam: nam, toa_nha_id: toaNha, kieuTienNuoc: kieuTienNuoc},
                dataType: 'json',
                success: function(data) {
                    var saveBtn = '',
                        doanhThu = '',
                        check = (parseInt(nam) === curYear && parseInt(thang) === curMonth-1) ||
                            (parseInt(thang) === 12 && curMonth === 1 && parseInt(nam) === curYear-1) ||
                            (parseInt(nam) === curYear && parseInt(thang) === curMonth ||
                            (parseInt(thang) === curMonth + 1 && parseInt(nam) === curYear) ||
                            (parseInt(thang) === 1 && parseInt(nam) === curYear+1));
                    $('#bang-hoa-don').html(data.content);
                    if(data.soLuong !== 0 && check){
                        saveBtn = '<a href="#" class="btn btn-success" id="btn-thanh-toan"><i class="fa fa-money"></i> Tạo giao dịch</a>';
                        $('.thongbao').html('');
                    }
                    doanhThu = parseInt(data.doanhThu);
                    $('.btn-save-bill').html(saveBtn);
                    // $('#hoaDons').html(htmls);
                    $('.doanh-thu').html(doanhThu.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                },
                error: function(r1, r2) {
                    console.log(r1);
                }
            });
        }else{
            getNganHan();
        }
    });

    $(document).on('change', '[id^="tong_tien"]', function (e){
        var id = $(this).attr('id');
        var index = id.match(/\d+/);

        var doanhThu = 0;
        $('[id^="tong_tien').each(function() {
            var value = $(this).val().replace(/\./g, '');
            doanhThu += parseInt(value) || 0;
        });
        $('.doanh-thu').html(doanhThu.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
    });

    $(document).on('click', '.btn-print',function (e){
        e.preventDefault();
        var hoaDon = $(this).attr('data-value');
        var loaiIn = $(this).attr('loai-in');
        $.ajax({
            url: 'index.php?r=hoa-don/print',
            type: 'post',
            dataType: 'json',
            data: {hoaDon: hoaDon, loaiIn: loaiIn},
            beforeSend: function (){
                Metronic.blockUI();
            },
            success: function (data){
                $('#print-block').html(data.hoaDon).printArea();
            },
            error: function (r1,r2){
                $('.thongbao').html(getMessage(r1.responseText));
            },
            complete: function (){
                Metronic.unblockUI();
            }
        });
    });

    $(document).on('click', '.btn-in-nhieu',function (e){
        e.preventDefault();
        var loaiIn = $(this).attr('loai-in'),
            thang = parseInt($('#thang').val()),
            nam = parseInt($('#nam').val()),
            toaNha = $('#toa_nha').val();
        if(toaNha === ''){
            $.alert({
                title: 'Thiếu thông tin',
                content: 'Chưa chọn tòa nhà'
            });
        }else{
            $.ajax({
                url: 'index.php?r=hoa-don/print',
                type: 'post',
                dataType: 'json',
                data: {loaiIn: loaiIn, thang: thang, nam: nam, toaNha: toaNha},
                beforeSend: function (){
                    Metronic.blockUI();
                },
                success: function (data){
                    $('#print-block').html(data.hoaDon).printArea();
                },
                error: function (r1,r2){
                    $('.thongbao').html(getMessage(r1.responseText));
                },
                complete: function (){
                    Metronic.unblockUI();
                }
            });
        }
    });

    $(document).on('click', '.btn-print-month',function (e){
        e.preventDefault();
        var self;
        $.dialog({
            content: function () {
                self = this;
                return $.ajax({
                    url: 'index.php?r=hoa-don/in-theo-thang',
                    type: 'get',
                    dataType: 'json'
                }).success(function (data) {
                    self.setContent(data.content);
                    self.setTitle(data.title);
                    self.setType('blue');
                }).error(function (r1, r2) {
                    self.setContent(getMessage(r1.responseText));
                    self.setTitle('Thông báo');
                    self.setType('red');
                    self.$$btnSave.prop('disabled', true);
                    return false;
                });
            },
            columnClass: 'l',
        });
    });

    $(document).on('click', '#btn-thanh-toan', function (e){
        e.preventDefault();
        var formData = new FormData($('#form-lap-hoa-don')[0]);
        var self;
        if ($('input[name="thanhToan[]"]:checked').length === 0) {
            alert('Vui lòng chọn ít nhất 1 hóa đơn!');
        } else {
            $.dialog({
                content: function () {
                    self = this;
                    return $.ajax({
                        url: 'index.php?r=hoa-don/thanh-toan',
                        type: 'post',
                        data: formData,
                        dataType: 'json',
                        processData: false,
                        contentType: false,
                    }).success(function (data) {
                        self.setContent(data.content);
                        self.setTitle(data.title);
                        self.setType('blue');
                    }).error(function (r1, r2) {
                        self.setContent(getMessage(r1.responseText));
                        self.setTitle('Thông báo');
                        self.setType('red');
                        return false;
                    });
                },
                columnClass: 'l',
            });
        }
    });

    function parseNumber(str) {
        return parseInt(str.replace(/\./g, ''), 10) || 0;
    }

    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    $(document).on('keydown', '.hien-thi-so-tien', function (e) {
        const allowedKeys = [8, 9, 13, 27, 46, 110, 190, 35, 36, 37, 38, 39, 40];
        if ((e.keyCode >= 48 && e.keyCode <= 57 && !e.shiftKey) ||
            (e.keyCode >= 96 && e.keyCode <= 105) ||
            allowedKeys.includes(e.keyCode) ||
            (e.ctrlKey && ['A', 'C', 'V', 'X'].includes(e.key.toUpperCase()))
        ) {
            return;
        }
        e.preventDefault();
    });

    $(document).on('input', '.hien-thi-so-tien', function () {
        const $this = $(this);
        let rawValue = $this.val().replace(/\D/g, '');
        let formatted = rawValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        $this.val(formatted);
    });

    $(document).on('change', '.so-cuoi', function () {
        const $this = $(this);
        const $row = $this.closest('.row');
        const $soDau = $row.find('.so-dau');
        const valDau = parseNumber($soDau.val());
        const valCuoi = parseNumber($this.val());

        if (valCuoi < valDau) {
            $this.val(formatNumber(valDau));
        }
    });


    $(document).on('click', '.btn-giao-dich', function (e){
        e.preventDefault();
        var loai = $(this).attr('data-value');
        $('#gui_thong_bao').val(loai);
        var formData = new FormData($('#form-tao-giao-dich')[0]);
        var phaiTraValues = $('input[name="phai_tra[]"]').map(function() {
            return $(this).val();
        }).get();

        var hasError = false;
        phaiTraValues.forEach(function(value) {
            var numberValue = parseInt(value.replace(/\./g, ''));

            if (numberValue < 1000) {
                hasError = true;
            }
        });

        if (hasError) {
            alert('Số tiền phải trả tối thiểu là 1000 đồng!');
        }else{
            $.ajax({
                url: 'index.php?r=hoa-don/lap-giao-dich',
                type: 'post',
                dataType: 'json',
                data: formData,
                processData: false,
                contentType: false,
                success: function (data){
                    if(data.success){
                        $('.block-giao-dich').html(data.content);
                        $('#toa_nha').trigger('change');
                    }
                },
                error: function (r1,r2){
                },
            });
        }
    });

    $(document).on('click','#btn-huy-hoa-don',function (e){
        e.preventDefault();
        var hoaDonID = $(this).attr('data-value');
        var ID = parseInt(hoaDonID);
        if (confirm('Hủy hóa đơn sẽ xóa toàn bộ giao dịch trước đó! Bạn có chắc chắn muốn thực hiện thao tác này?')){
            $.ajax({
                url: 'index.php?r=hoa-don/delete',
                type: 'post',
                dataType: 'json',
                data: {ID: ID},
                success: function (data){
                    if (data.success){
                        $('.thongbao').html('<div class="note note-success">'+data.content+'</div>');
                        $.pjax({container: "#crud-datatable-pjax"});
                    }
                },
                error: function (r1,r2){
                    $('.thongbao').html(getMessage(r1.responseText));
                },
            });
        }
    });

    $(document).on('change', '.check-chon', function (e) {
        if ($(this).is(':checked')) {
            $(this).closest('tr').css('background-color', 'rgba(66, 139, 202, 0.2)');
        } else {
            $(this).closest('tr').css('background-color', '');
        }
    });

    $(document).on('change', '.chon-tat-ca',function (e){
        let isChecked = $(this).data('checked') || false;
        $('.check-chon').prop('checked', !isChecked).trigger('change');
        $(this).data('checked', !isChecked);
    });

    $(document).on('change', '#gia_nuoc',function (e){
        e.preventDefault();
        var id = $(this).val();
        if(id !== null){
            $.ajax({
                url: 'index.php?r=gia-nuoc/get-bang-gia',
                type: 'post',
                dataType: 'json',
                data: {id: id},
                success: function (data) {
                    var htmls = '';
                    $.each(data.content, function (k, obj){
                        htmls += '<tr>';
                        for (var i = 0; i < Object.keys(obj).length; i++){
                            var key = Object.keys(obj)[i];
                            var value = obj[key];
                            htmls += '<td>'+value+'</td>';
                        }
                        htmls += '</tr>';
                    });
                    $('#bang_nuoc').html(htmls);
                },
                error: function (r1,r2) {
                    console.log(r1);
                }
            });
        }
    });
    var dialogOCung;
    var oCung;
    var thanhTienNuoc;
    function setupSaveOCungHandler(trLocal, thanhTienNuoc) {
        $(document).on('click', '#save-o-cung', function (e) {
            e.preventDefault();
            var formData = new FormData($('#form-o-cung')[0]);
            $("#loading").show();
            $.ajax({
                url: 'index.php?r=hoa-don/save-o-cung',
                type: 'post',
                dataType: 'json',
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    if (data.success) {
                        $('.thongbao').html('<div class="note note-success">' + data.content + '</div>');
                        dialogOCung.close();
                        trLocal.find('.so-thanh-vien').html(data.so_nguoi);
                        thanhTienNuoc.html(data.thanh_tien);
                        updateTongTien(trLocal);
                    }
                },
                error: function (r1, r2) {
                    console.error(r1);
                },
            }).always(function () {
                $("#loading").hide();
            });
        });
    }

    $(document).on('click', '.btn-update-member', function (e) {
        e.preventDefault();
        let trLocal = $(this).closest('tr'); // Lưu tr cục bộ
        var id = trLocal.find('.check-chon').val();
        oCung = trLocal.find('.so-thanh-vien');
        thanhTienNuoc = trLocal.find('.thanh-tien-nuoc');
        $.dialog({
            content: function () {
                dialogOCung = this;
                return $.ajax({
                    url: 'index.php?r=hoa-don/get-o-cung',
                    type: 'post',
                    dataType: 'json',
                    data: { id: id }
                }).success(function (data) {
                    dialogOCung.setContent(data.content);
                    dialogOCung.setTitle(data.title);
                    dialogOCung.setType('blue');

                    // Truyền trLocal cho hàm xử lý tiếp theo
                    setupSaveOCungHandler(trLocal, thanhTienNuoc);
                }).error(function (r1, r2) {
                    dialogOCung.setContent(getMessage(r1.responseText));
                    return false;
                });
            },
            columnClass: 'l',
        });
    });

    $(document).on('click','.them-o-cung',function (e){
        e.preventDefault();
        tr = $(this).closest('tr');
        tr.after('<tr><td><input type="text" name="ho_ten[]" class="form-control"></td>' +
            '<td><input type="text" name="dien_thoai[]" class="form-control"></td>' +
            '<td><center><a href="#" class="text-primary them-o-cung"><i class="fa fa-plus"></i></a></center></td>' +
            '<td><center><a href="#" class="text-danger xoa-o-cung"><i class="fa fa-trash"></i></a></center></td></tr>');
    });
    $(document).on('click', '.xoa-o-cung', function (e) {
        e.preventDefault();
        tr = $(this).closest('tr');
        var table = tr.closest('table');

        if (table.find('tr').length > 2) {
            tr.remove();
        } else {
            tr.html('<td><input type="text" name="ho_ten[]" class="form-control"></td>' +
                '<td><input type="text" name="dien_thoai[]" class="form-control"></td>' +
                '<td><center><a href="#" class="text-primary them-o-cung"><i class="fa fa-plus"></i></a></center></td>' +
                '<td><center><a href="#" class="text-danger xoa-o-cung"><i class="fa fa-trash"></i></a></center></td>');
        }
    });
    $(document).on('click', 'tr',function (e){
        if ($(e.target).is('input[type="checkbox"]')) return;
        if ($(e.target).is('input[type="text"]')) return;
        if ($(e.target).is('input[type="file"]')) return;
        if ($(e.target).is('i')) return;
        if ($(e.target).is('a')) return;
        if ($(e.target).is('img')) return;

        // Tìm checkbox gần nhất trong tr và chuyển đổi trạng thái
        let $checkbox = $(this).find('.check-chon').first();
        $checkbox.prop('checked', !$checkbox.prop('checked'));
        $checkbox.trigger('change');
    });
    $(document).on('change', '.anh-dien', function (e) {
        e.preventDefault();
        let fileInput = this.files[0];
        var hang = $(this).closest('tr');
        var id = hang.find('.check-chon').val();

        if (fileInput) {
            let formData = new FormData();
            formData.append('id', id);
            formData.append('file', fileInput);

            $.ajax({
                url: 'index.php?r=hoa-don/chon-anh',
                type: 'post',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    if (data.success){
                        hang.find('img').attr('src', data.anh);
                        $('.thongbao').html('<div class="note note-success">Thêm ảnh số điện thành công!</div>');
                    }
                },
                error: function(r1, r2) {
                    console.log(r1);
                }
            });
        }
    });
    $(document).on('click', '.xoa-anh', function (e) {
        e.preventDefault();
        var hang = $(this).closest('tr');
        var id = hang.find('.check-chon').val();

        if(confirm('Bạn có chắc chắn muốn xóa ảnh này?')){
            $.ajax({
                url: 'index.php?r=hoa-don/xoa-anh',
                type: 'post',
                data: {id: id},
                dataType: 'json',
                success: function(data) {
                    if (data.success){
                        hang.find('img').attr('src', data.anh);
                        $('.thongbao').html('<div class="note note-success">Xoá ảnh số điện thành công!</div>');
                    }
                },
                error: function(r1, r2) {
                    console.log(r1);
                }
            });
        }
    });
});