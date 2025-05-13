/** 12/9/2019 12:24 AM**/
/** Admin **/
/** quan-ly-cong-viec-2 **/
$(document).ready(function () {
    $(document).on('click', '.btn-thong-ke', function (e) {
        e.preventDefault();
        if($("#list-phong-ban").val() != ''){
            $.ajax({
                url: 'index.php?r=thong-ke/bao-cao-cong-viec-muc-tieu',
                data: $("#form-bao-cao").serializeArray(),
                dataType: 'json',
                type: 'post',
                beforeSend: function () {
                    Metronic.blockUI();
                    $(".ket-qua").html('');
                },
                success: function (data) {
                    $('.ket-qua').html(data.content);
                    setTimeout(function () {
                        var $tongDiemDatDuoc = 0;
                        var $tongDiemToiDa = 0;
                        $(".tong-diem-nhom").each(function () {
                            var $idparent = $(this).attr('data-value');
                            $("#tong-diem-nhom-" + $idparent).text($(this).find('input').val());
                            var arr_str = ($(this).find('input').val()).split('/');
                            $tongDiemDatDuoc += parseFloat(arr_str[0]);
                            $tongDiemToiDa += parseFloat(arr_str[1]);
                        });
                        $('#tong-diem-nam').html("Điểm đạt được: <span class='text-danger'>" + $tongDiemDatDuoc + '/' + $tongDiemToiDa + '</span>');
                    }, 500);
                },
                error: function (r1, r2) {
                    $('.ket-qua').html(getMessage(r1.responseText));
                },
                complete: function () {
                    Metronic.unblockUI();
                }
            });
        }else
            $.alert({
                content: 'Vui lòng chọn đơn vị để thống kê',
                title:'Thông báo'
            })
    });

    $(document).on('click', '.btn-tai-ket-qua', function (e) {
        e.preventDefault();
        if($("#list-phong-ban").val() != ''){
            $.ajax({
                url: 'index.php?r=bao-cao/export-cong-viec-muc-tieu',
                data: $("#form-bao-cao").serializeArray(),
                dataType: 'json',
                type: 'post',
                beforeSend: function () {
                    $('.thongbao').html('');
                    Metronic.blockUI();
                },
                success: function (data) {
                    $.dialog({
                        title: data.title,
                        content: data.link_file,
                    });
                },
                complete: function () {
                    Metronic.unblockUI();
                },
                error: function (r1, r2) {
                    $('.thongbao').html(r1.responseText);
                }
            });
        }else
            $.alert({
                content: 'Vui lòng chọn đơn vị để thống kê',
                title:'Thông báo'
            })
    });

    $(document).on('click', '.btn-tai-file-pdf', function (e) {
        e.preventDefault();
        if($("#list-phong-ban").val() != ''){
            var $data = $("#form-bao-cao").serializeArray();
            $data.push({name: 'taipdf', value: true});
            viewData('thong-ke/bao-cao-cong-viec-muc-tieu', $data, 'm');
            // window.location = 'index.php?r=bao-cao/cong-viec-don-vi'+$data.serialize();

            // $.ajax({
            //     url: 'index.php?r=',
            //     data: $data,
            //     dataType: 'json',
            //     type: 'post',
            //     beforeSend: function () {
            //     },
            //     success: function (data) {
            //         $('.ket-qua').html(data.content);
            //     },
            //     error: function (r1, r2) {
            //         // $('.ket-qua').html(getMessage(r1.responseText));
            //     },
            //     complete: function () {
            //     }
            // });
        }else
            $.alert({
                content: 'Vui lòng chọn đơn vị để thống kê',
                title:'Thông báo'
            })
    });

    $(document).on('change', '#loai-bao-cao', function () {
        if($(this).val() == 'Quý'){
            $(".bao-cao-quy").removeClass('hidden');
            $(".bao-cao-thang").addClass('hidden');
        }else if($(this).val() == 'Tháng'){
            $(".bao-cao-quy").addClass('hidden');
            $(".bao-cao-thang").removeClass('hidden');
        }else{
            $(".bao-cao-quy").addClass('hidden');
            $(".bao-cao-thang").addClass('hidden');
        }
    })
});
