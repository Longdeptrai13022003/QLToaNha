$(document).ready(function () {
    $(document).on('click','.btn-dat-hang',function (e){
        e.preventDefault();
        var sanPham = $(this).closest('.product-grid');
        var name = sanPham.find('img').attr('alt');
        $('#exampleModal').modal('show');
        $('#tim-hieu-them').html('');
        $('#ten-san-pham-modal').html(name);
        $('#loai-tieu-de').html('Đặt hàng');
    });
    $(document).on('click', '.xac-nhan-dat-hang', function (e) {
        e.preventDefault();
        $("#loading").show();
        var hoTen = $('.ho_ten').val();
        var dienThoai = $('.dien_thoai').val();
        var tenSP = $('#ten-san-pham-modal').html();
        var token = $('#token').val();
        var email = $('#email-nhan-thong-tin').val(),
            title = "Có đơn hàng mới từ xôi khúc An",
            phanThem = "Tên sản phẩm: " + tenSP;

        if (hoTen.trim() === '' || dienThoai === ''){
            alert('Vui lòng nhập họ tên và điện thoại!');
            return;
        }
        var settings = {
            "url": "https://vody.andin.asia/index.php?r=api/send-mail",
            "method": "POST",
            "data": JSON.stringify({
                "email": email,
                "token": token,
                "title": title,
                "name": $("#name-gui-thong-tin").val(),
                "content": "Họ tên khách: " + hoTen + "<br/>" +
                    "Điện thoại: " + dienThoai + "<br/>" +
                    phanThem
            }),
        };

        $.ajax(settings)
            .done(function (response) {
                console.log(response);
                $("#loading").hide();
                if (response.success){
                    $('.ho_ten').val('');
                    $('.dien_thoai').val('');
                    $('#ten-san-pham-modal').html('');
                    $('#exampleModal').modal('hide');

                    // Hiển thị thông báo thành công
                    $('body').append('<div id="success-alert" style="position: fixed; top: 20px; right: 20px; background: #4CAF50; color: white; padding: 10px 20px; border-radius: 5px; z-index: 9999;">' +
                        'Gửi thông tin thành công!' +
                        '</div>');

                    // Tự động ẩn thông báo sau 3 giây
                    setTimeout(function () {
                        $('#success-alert').fadeOut('slow', function () {
                            $(this).remove();
                        });
                    }, 3000);
                }else {
                    alert(response.content);
                }
            })
            .fail(function (error) {
                console.log(error);
                $("#loading").hide();
                alert('Hệ thống đang bận, vui lòng thử lại sau!');
            });
    });
    $(document).on('click','.btn-uu-dai',function (e){
        e.preventDefault();
        $("#loading").show();
        var dienThoai = $('.dien-thoai-uu-dai').val();
        var token = $('#token').val();
        var email = $('#email-nhan-thong-tin').val();

        if (dienThoai === ''){
            alert('Vui lòng nhập điện thoại!');
            return;
        }
        var settings = {
            "url": "https://vody.andin.asia/index.php?r=api/send-mail",
            "method": "POST",
            "data": JSON.stringify({
                "email": email,
                "name": $("#name-gui-thong-tin").val(),
                "token": token,
                "title": "Có yêu cầu nhận ưu đãi mới từ xôi khúc An",
                "content": "Điện thoại: " + dienThoai + "<br/>"
            }),
        };

        $.ajax(settings)
            .done(function (response) {
                console.log(response);
                $("#loading").hide();
                if (response.success){
                    $('.dien-thoai-uu-dai').val('');
                    // Hiển thị thông báo thành công
                    $('body').append('<div id="success-alert" style="position: fixed; top: 20px; right: 20px; background: #4CAF50; color: white; padding: 10px 20px; border-radius: 5px; z-index: 9999;">' +
                        'Gửi thông tin thành công!' +
                        '</div>');

                    // Tự động ẩn thông báo sau 3 giây
                    setTimeout(function () {
                        $('#success-alert').fadeOut('slow', function () {
                            $(this).remove();
                        });
                    }, 3000);
                }else {
                    alert(response.content);
                }
            })
            .fail(function (error) {
                console.log(error);
                $("#loading").hide();
                alert('Hệ thống đang bận, vui lòng thử lại sau!');
            });
    });
});
