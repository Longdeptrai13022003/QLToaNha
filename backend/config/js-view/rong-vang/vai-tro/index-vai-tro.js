$(document).ready(function () {
    $(document).on('click', '.btn-xoa-vai-tro', function (e){
        e.preventDefault();
        viewData('vai-tro/delete-vai-tro', {
            id: $(this).attr('data-value')
        }, 'l', function (){
            $.pjax.reload({container: "#crud-datatable-pjax"});
        });
    });
});