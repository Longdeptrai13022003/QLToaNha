$(document).ready(function () {
    $(document).on('click', '.them-don-vi-thuc-hien', function (e) {
        e.preventDefault();
        $.ajax({
            url: 'index.php?r=danh-muc/get-don-vi',
            beforeSend: function () {
                Metronic.blockUI();
            },
            success: function (data) {
                var $options = '<option></option>';
                $.each(data, function (k, obj) {
                    $options += '<option value="'+obj.id+'">'+obj.name+'</option>';
                });

                $("#table-don-vi-thuc-hien tbody").append(
                    `<tr>
                        <td>
                            <select class="form-control don-vi-thuc-hien" name="DonViThucHien[]">`+$options+`</select>
                            <label class="control-label">Chủ trì</label>
                            <select class="form-control don-vi-chu-tri" name="ChuTri[]">
                                <option>Không</option>
                                <option>Có</option>
                            </select>
                        </td>
                        <td><textarea name="NoiDungCongViec[]" rows="4" class="form-control"></textarea></td>
                        <td class="text"><a class="text-danger btn-xoa-don-vi-thuc-hien"><i class="fa fa-minus"></i></a></td>
                    </tr>`
                )
            },
            complete: function () {
                Metronic.unblockUI();
            },
            error: function (r1,r2) {
                $.alert(r1.responseText);
            }
        });
    });

    $(document).on('click', '.them-don-vi-tham-dinh', function (e) {
        e.preventDefault();
        $.ajax({
            url: 'index.php?r=danh-muc/get-don-vi',
            beforeSend: function () {
                Metronic.blockUI();
            },
            success: function (data) {
                var $options = '<option></option>';
                $.each(data, function (k, obj) {
                    $options += '<option value="'+obj.id+'">'+obj.name+'</option>';
                });

                $("#table-don-vi-tham-van tbody").append(
                    `<tr>
                        <td>
                            <select class="form-control don-vi-tham-van" name="DonViThamVan[]">`+$options+`</select>
                        </td>
                        <td class="text"><a class="text-danger btn-xoa-don-vi-thuc-hien"><i class="fa fa-minus"></i></a></td>
                    </tr>`
                )
            },
            complete: function () {
                Metronic.unblockUI();
            },
            error: function (r1,r2) {
                $.alert(r1.responseText);
            }
        });
    });

    $(document).on('click', '.btn-xoa-don-vi-thuc-hien, .btn-xoa-don-vi-tham-van', function (e) {
        e.preventDefault();
        var $myTr = $(this).parent().parent();
        var $data = $(this).attr('data-value');

        $.confirm(
            {
                content: 'Bạn có chắc chắn muốn xóa dữ liệu này?',
                title: 'Thông báo',
                type: 'danger',
                icon: 'fa fa-warning',
                buttons: {
                    btnOK: {
                        text: '<i class="fa fa-check"></i> Chấp nhận',
                        btnClass: 'btn-primary',
                        action: function () {
                            if(typeof $data != 'undefined'){
                                viewData('giao-viec/xoa-don-vi-thuc-hien-tham-van', {
                                    donVi: $data
                                }, 'm', function (data) {
                                    $myTr.remove();
                                })
                            }else
                                $myTr.remove();
                        }
                    },
                    btnCancel: {
                        text: '<i class="fa fa-ban"></i> Hủy',
                    }
                }
            }
        )
    });

    $(document).on('click', '.btn-save', function (e) {
        e.preventDefault();
        if($("#thuchiencongviec-tieu_de").val().trim() == '')
            $.alert('Chưa nhập tiêu đề công việc');
        else if($("#thuchiencongviec-noi_dung").val().trim() == '')
            $.alert('Chưa nhập nội dung công việc');
        else if($("#table-don-vi-thuc-hien tbody tr").length == 0)
            $.alert('Vui lòng chọn ít nhất một đơn vị thực hiện công việc');
        else{
            var $chuTri = 0,
                $slDonViThucHien = 0;
            $($("#table-don-vi-thuc-hien tbody tr").each(function () {
                if($(this).find('.don-vi-chu-tri').val() != '')
                    $chuTri++;
                if($(this).find('.don-vi-thuc-hien').val() != '')
                    $slDonViThucHien++;
            }));
            if($chuTri == 0)
                $.alert('Vui lòng chọn ít nhất một đơn vị chủ trì công việc');
            else if($slDonViThucHien != $("#table-don-vi-thuc-hien tbody tr").length)
                $.alert('Vui lòng nhập đầy đủ số lượng đơn vị thực hiện công việc');
            else{
                var data = new FormData($('#form-giao-viec')[0]);
                SaveObjectUploadFile('giao-viec/save', data, function (data) {
                    $("#form-giao-viec").html('');
                });
            }
        }
    });

    $(document).on('click', '.btn-xoa-de-xuat', function (e) {
        e.preventDefault();
        var $congviec = $(this).attr('data-value');
        $.confirm({
            content: 'Bạn có chắc chắn muốn xóa công việc này?',
            title: 'Thông báo',
            buttons: {
                btnOK: {
                    text: 'Đồng ý',
                    btnClass: 'btn-primary',
                    action: function () {
                        viewData("thuc-hien-cong-viec/delete&id=" + $congviec, {
                            congViec: $congviec
                        }, 'm', function () {
                            $.pjax.reload({container: "#crud-datatable-pjax"});
                        })
                    }
                },
                btnHuy: {
                    text: 'Hủy và đóng lại'
                }
            }
        })
    });

    $(document).on('click', '.btn-xoa-file-dinh-kem', function (e) {
        e.preventDefault();
        var $file = $(this).attr('data-value'),
            $myLi = $(this).parent();
        $.confirm({
            content: 'Bạn có chắc chắn muốn xóa file này?',
            title: 'Thông báo',
            buttons: {
                btnOK: {
                    text: 'Đồng ý',
                    btnClass: 'btn-primary',
                    action: function () {
                        viewData("thuc-hien-cong-viec/xoa-file-dinh-kem", {
                            file: $file
                        }, 'm', function () {
                            $myLi.remove();
                        })
                    }
                },
                btnHuy: {
                    text: 'Hủy và đóng lại'
                }
            }
        })
    });

    $(document).on('click', '.btn-xem-chi-tiet', function (e) {
        e.preventDefault();
        viewData('thuc-hien-cong-viec/view-giao-viec', {denghi: $(this).attr('data-value')}, 'xl');
    });


});
