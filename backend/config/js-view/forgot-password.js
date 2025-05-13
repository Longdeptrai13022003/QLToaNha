$(document).ready(function () {
    $(document).on('click', '.cap-mat-khau-moi', function (e) {
        e.preventDefault();
        $.confirm({
            content: function () {
                var self = this;
                return $.ajax({
                    url: 'index.php?r=site/forgot-password',
                    data: $("#forgot-password-form").serializeArray(),
                    type: 'post',
                    dataType: 'json'
                }).success(function (data) {
                    self.setContent(data.content);
                    self.setTitle(data.title);
                    self.setType('blue');
                }).error(function (r1, r2) {
                    // self.setContent(getMessage();
                    $.alert(r1.responseText);
                    self.setTitle('Thông báo');
                    self.setType('red');
                    return false;
                });
            },
            columnClass: 'm',
            buttons: {
                btnClose: {
                    text: '<i class="fa fa-close"></i> Đóng lại'
                }
            }
        });
    })
})
