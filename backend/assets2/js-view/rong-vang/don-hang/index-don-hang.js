
$(document).ready(function () {
    $('.btn-them-dong').click(function () {
        // Tạo một dòng mới
        var newRow = $('<tr></tr>');

        // Tạo các ô trong dòng mới
        newRow.append('<td>' + ($('.outside tr').length + 1) + '</td>');
        newRow.append('<td><textarea class="form-control" name="donHang[tenSanPham][]" rows="3"></textarea></td>');
        newRow.append('<td><textarea class="form-control" name="donHang[linkSanPham][]" rows="3"></textarea></td>');

        // Tạo bảng mới có 6 cột
        var attributeTable = $('<td></td>');
        var innerTable = $('<table class="table table-bordered table-striped text-nowrap"></table>');
        innerTable.append('<thead><tr><th width="10%">Ảnh</th><th width="10%">Tên thuộc tính</th><th width="10%">Số lượng</th><th width="10%">Đơn giá(NDT)</th><th width="5%">Thành tiền</th><th width="5%" style="text-align: center"><a class="btn-them-dong2"><i class="fas fa-plus-circle fa-2x"></i></a></th></tr></thead>');
        innerTable.append('<tbody class="inside"></tbody>');
        attributeTable.append(innerTable);
        newRow.append(attributeTable);

        newRow.append('<td><input type="text" name="donHang[tongTien][]" class="form-control" /></td>');

        // Tạo cột mới chứa biểu tượng xóa dòng
        var deleteIconCell = $('<td style="display: flex; justify-content: center;"></td>');
        var deleteIcon = $('<i class="fas fa-trash-alt"></i>');
        var deleteButton = $('<button class="btn btn-danger btn-sm btn-xoa-dong"></button>').append(deleteIcon);
        deleteIconCell.append(deleteButton);
        newRow.append(deleteIconCell);

        // Thêm dòng mới vào bảng
        $('.outside').append(newRow);
    });

    $(document).on('click', '.btn-them-dong2', function () {

        var currentTbody = $(this).closest('table').find('.inside');

        // Tạo một dòng mới
        var newRow = $('<tr></tr>');

        // Tạo các ô trong dòng mới
        newRow.append('<td><textarea class="form-control" name="donHang[anhThuocTinh][]" rows="3"></textarea></td>');
        newRow.append('<td><textarea class="form-control" name="donHang[tenThuocTinh][]" rows="3"></textarea></td>');
        newRow.append('<td><input type="text" name="donHang[soLuong][]" class="form-control" /></td>');
        newRow.append('<td><input type="text" name="donHang[donGia][]" class="form-control" /></td>');
        newRow.append('<td><input type="text" name="donHang[thanhTien][]" class="form-control" /></td>');

        // Tạo cột mới chứa biểu tượng xóa dòng
        var deleteIconCell = $('<td style="display: flex; justify-content: center;"></td>');
        var deleteIcon = $('<i class="fas fa-trash-alt"></i>');
        var deleteButton = $('<button class="btn btn-danger btn-sm btn-xoa-dong"></button>').append(deleteIcon);
        deleteIconCell.append(deleteButton);
        newRow.append(deleteIconCell);

        // Thêm dòng mới vào bảng
        currentTbody.append(newRow);
    });

    // sự kiện click trên biểu tượng xóa dòng
    $('tbody').on('click', '.btn-xoa-dong', function () {
        $(this).closest('tr').remove(); // Xóa dòng chứa biểu tượng đã click
    });
});

$(document).on('change', '.outside', function () {
    var total = 0;

    $(this).find('input[name="donHang[thanhTien][]"]').each(function () {
        var value = parseFloat($(this).val());
        if (!isNaN(value)) {
            total += value;
        }
    });

    $(this).closest('tr').find('input[name="donHang[tongTien][]"]').val(total.toFixed(2));
});

$(document).on('change', '.inside', function () {
    var total = 0;

    // Lặp qua từng hàng trong bảng
    $('.inside tr').each(function() {
        var soLuong = $(this).find('input[name="donHang[soLuong][]"]').val();
        var donGia = $(this).find('input[name="donHang[donGia][]"]').val();

        // Kiểm tra xem cả hai giá trị số lượng và đơn giá có tồn tại và không rỗng
        if (soLuong !== '' && donGia !== '') {
            var thanhTien = parseInt(soLuong) * parseFloat(donGia); // Tính thành tiền
            $(this).find('input[name="donHang[thanhTien][]"]').val(thanhTien.toFixed(2)); // Hiển thị kết quả
            total += thanhTien; // Cộng vào tổng số tiền
        }
    });

    // Hiển thị tổng số tiền trong input có name là donHang[tongTien][]
    $('.outside input[name="donHang[tongTien][]"]').val(total.toFixed(2));
});``

$(document).on('click','.btn-luu-don-hang',function (e) {
    e.preventDefault();
    var $message = '';
    var $loi = 0;
    $(".help-block").html('');

    if ($("#donhang-user_id").val()==''){
        $message += '<p>Vui lòng chọn tên khách hàng</p>';
        $loi++;
    }

    if($loi == 0){
        var data = new FormData($('#form-san-pham')[0]);
        SaveObjectUploadFile("quan-ly-don-hang/save", data, function (data) {
            $("#form-san-pham").html('');
        });
    }else{
        $.alert($message);
    }
});

