$(document).ready(function () {
    $(document).on('click', '.btn-nhap-ma-van-don', function (e){
        e.preventDefault();
        loadForm({type: 'load_form_nhap_ma_van_don', 'idPhieu': $(this).attr('data-value')}, 'm', function (data) {
        }, function () {
            SaveObject('yeu-cau-giao-hang/luu-ma-van-don-phieu-yeu-cau-giao', $("#form-luu-ma-van-don").serializeArray(), function (data) {
                $.pjax.reload({container: '#crud-datatable-pjax'});
            })
        });
    });

    $(document).on('click', '.btn-luu-sdt-nha-xe', function (e){
        e.preventDefault();
        loadForm({type: 'load_form_luu_sdt_nha_xe', 'idPhieu': $(this).attr('data-value')}, 'm', function (data) {
        }, function () {
            SaveObject('yeu-cau-giao-hang/luu-sdt-nha-xe', $("#form-luu-sdt-nha-xe").serializeArray(), function (data) {
                $.pjax.reload({container: '#crud-datatable-pjax'});
            })
        });
    });

    $(document).on('click', '.btn-luu-chi-phi-khac', function (e){
        e.preventDefault();
        loadForm({type: 'load_form_luu_chi_phi', 'idPhieu': $(this).attr('data-value')}, 'm', function (data) {
        }, function () {
            SaveObject('yeu-cau-giao-hang/luu-chi-phi', $("#form-luu-chi-phi-khac").serializeArray(), function (data) {
                $.pjax.reload({container: '#crud-datatable-pjax'});
            })
        });
    });

    $(document).on('change', '.phiDongGoi', function (e){
        e.preventDefault();
        console.log(1)
        var value = parseInt($(this).val());
        if (isNaN(value) || value < 0) {
            this.value = 0;
        }
    });
});