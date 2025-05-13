 /**
 * Created by HungLuongHien on 6/23/2016.
 */
function getMessage(str) {
    return str.replace('Internal Server Error (#500):','');
}
function createTypeHead(target, action, callbackAfterSelect){
    $(target).typeahead({
        source: function (query, process) {
            var states = [];
            return $.get('index.php?r=autocomplete/'+action, { query: query }, function (data) {
                $.each(data, function (i, state) {
                    states.push(state.name);
                });
                return process(states);
            }, 'json');
        },
        afterSelect: function (item) {
            if(typeof callbackAfterSelect != 'undefined')
                callbackAfterSelect(item);
            /*$.ajax({
             url: 'index.php?r=khachhang/getdiachi',
             data: {name: item},
             type: 'post',1
             dataType: 'json',
             success: function (data) {
             $("#diachikhachhang").val(data);
             }
             })*/
        }
    });
}
function setDatePicker() {
    $('.datepicker').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy',
        language: 'vi',
        todayBtn: true,
        todayHighlight: true,
    });
}
function uniqId() {
    return Math.round(new Date().getTime() + (Math.random() * 100));
}

function SaveObjectUploadFile($url_controller_action, $dataInput, callbackSuccess, columnClass){
    if(typeof columnClass == "undefined")
        columnClass = 's';
    // data = new FormData($(modalForm)[0]);
    $.confirm({
        columnClass: columnClass,
        buttons: {
            btnClose: {
                // isHidden: true
                text: '<i class="fa fa-close"></i> Đóng lại'
            }
        },
        content: function () {
            var self = this;
            return $.ajax({
                url: 'index.php?r=' + $url_controller_action,
                type: 'post',
                dataType: 'json',
                data: $dataInput,
                // async: false,
                contentType: false,
                // cache: false,
                processData: false
            }).success(function (data) {
                self.setContent(data.content);
                self.setTitle(data.title);
                self.setType('blue');
                callbackSuccess(data);
            }).error(function (r1, r2) {
                console.log(r1.responseText);
                // self.setContent(getMessage(r1.responseText));
                // self.setTitle('Thông báo');
                // self.setType('red');
                // return false;
            });

        }
    })
}

function SaveObject($url_controller_action, $dataInput, callbackSuccess, columnClass){
    if(typeof columnClass == "undefined")
        columnClass = 's';

    $.dialog({
        columnClass: columnClass,
        content: function () {
            var self = this;
            return $.ajax({
                url: 'index.php?r=' + $url_controller_action,
                type: 'post',
                dataType: 'json',
                data: $dataInput,
            }).success(function (data) {
                self.setContent(data.content);
                self.setTitle(data.title);
                self.setType('blue');
                callbackSuccess(data);
            }).error(function (r1, r2) {
                self.setContent(getMessage(r1.responseText));
                self.setTitle('Thông báo');
                self.setType('red');
                return false;
            });
        }
    })
}

function loadForm($dataInput, $size = 'm', callbackSuccess, callbackSave) {
    $.confirm({
        content: function () {
            var self = this;
            return $.ajax({
                url: 'index.php?r=site/loadform',
                data: $dataInput,
                type: 'post',
                dataType: 'json'
            }).success(function (data) {
                self.setContent(data.content);
                self.setTitle(data.title);
                self.setType('blue');
                callbackSuccess(data);
            }).error(function (r1, r2) {
                self.setContent(getMessage(r1.responseText));
                self.setTitle('Thông báo');
                self.setType('red');
                self.$$btnSave.prop('disabled', true);
                return false;
            });
        },
        columnClass: $size,
        buttons: {
            btnSave: {
                text: '<i class="fa fa-save"></i> Lưu lại',
                btnClass: 'btn-primary',
                action: function () {
                    if(typeof callbackSave != "undefined") return callbackSave();
                }
            },
            btnClose: {
                text: '<i class="fa fa-close"></i> Đóng lại'
            }
        }
    });
}

 function loadFormSearch($dataInput, $size = 'm', callbackSuccess, callbackSave, onContentReady) {
     $.confirm({
         content: function () {
             var self = this;
             return $.ajax({
                 url: 'index.php?r=site/loadform',
                 data: $dataInput,
                 type: 'post',
                 dataType: 'json'
             }).success(function (data) {
                 self.setContent(data.content);
                 self.setTitle(data.title);
                 self.setType('blue');
                 callbackSuccess(data);
             }).error(function (r1, r2) {
                 self.setContent(getMessage(r1.responseText));
                 self.setTitle('Thông báo');
                 self.setType('red');
                 self.$$btnSave.prop('disabled', true);
                 return false;
             });
         },
         onContentReady: function () {
             if(typeof onContentReady != "undefined")
                 onContentReady();
         },
         columnClass: $size,
         buttons: {
             btnSave: {
                 text: '<i class="fa fa-search"></i> Tìm kiếm',
                 btnClass: 'btn-primary',
                 action: function () {
                     if(typeof callbackSave != "undefined") return callbackSave();
                 }
             },
             btnClose: {
                 text: '<i class="fa fa-close"></i> Đóng lại'
             }
         }
     });
 }
function loadFormFromUrl($dataInput, $controller_action, $size = 'm', callbackSuccess, callbackSave) {
    $.confirm({
        content: function () {
            var self = this;
            return $.ajax({
                url: 'index.php?r=' + $controller_action,
                data: $dataInput,
                type: 'post',
                dataType: 'json'
            }).success(function (data) {
                self.setContent(data.content);
                self.setTitle(data.title);
                self.setType('blue');
                callbackSuccess(data);
            }).error(function (r1, r2) {
                self.setContent(getMessage(r1.responseText));
                self.setTitle('Thông báo');
                self.setType('red');
                self.$$btnSave.prop('disabled', true);
                return false;
            });
        },
        columnClass: $size,
        buttons: {
            btnSave: {
                text: '<i class="fa fa-save"></i> Lưu lại',
                btnClass: 'btn-primary',
                action: function () {
                    if(typeof callbackSave != "undefined") return callbackSave();
                }
            },
            btnClose: {
                text: '<i class="fa fa-close"></i> Đóng lại'
            }
        }
    });
}

function taiFileExcel($controller_action, $data){
    $.ajax({
        url: 'index.php?r='+$controller_action,
        data: $data,
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
}
function makeid(length) {
    var result           = '';
    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}
function viewData($controller_action, $dataInput, $size, callbackSuccess, onContentReady){
    $.confirm({
        content: function () {
            var self = this;
            return $.ajax({
                url: 'index.php?r=' + $controller_action,
                data: $dataInput,
                type: 'post',
                dataType: 'json'
            }).success(function (data) {
                self.setContent(data.content);
                self.setTitle(data.title);
                self.setType('blue');
                if(typeof callbackSuccess != "undefined")
                    callbackSuccess(data);
            }).error(function (r1, r2) {
                self.setContent(getMessage(r1.responseText));
                self.setTitle('Thông báo');
                self.setType('red');
                return false;
            });
        },
        onContentReady: function () {
            if(typeof onContentReady != "undefined")
                onContentReady();
        },
        columnClass: $size,
        buttons: {
            btnClose: {
                text: '<i class="fa fa-close"></i> Đóng lại'
            }
        }
    });
}
function showAlert($message){
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "positionClass": "toast-top-right",
        "onclick": function () {
            // if($link != '')
            //     window.location = $link
        },
        "showDuration": "10000",
        "hideDuration": "1000",
        "timeOut": "10000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    toastr['info']($message, 'Thông báo');
}
function tinhDiemMoiCaNhan($idNhanVienPhongBan){
    var $diemSo = 0;

    $("tr.tr-nhan-vien-" + $idNhanVienPhongBan).each(function () {
        var $diem = $(this).find('.td-diem-nhan-vien input').val();
        $diem = ($diem == '' ? 0 : (parseFloat($diem)));
        $diemSo += $diem;
        console.log($diem);
        $("#diem-nvien-" + $idNhanVienPhongBan).text(parseFloat($diemSo).toLocaleString('vi', {maximumFractionDigits: 2}));
    });
}
function tinhTongDiemDonVi(){
    var $tongDiem = 0;
    $(".diem-so-don-vi input").each(function () {
        var $diemSo = $(this).val();
        $tongDiem += ($diemSo == '' ? 0 : parseFloat($diemSo));
    });
    $("span#tong-diem").text($tongDiem);
}
jQuery(document).ready(function() {
    Metronic.init(); // init metronic core components
    Layout.init(); // init current layout
    QuickSidebar.init(); // init quick sidebar
    // $(".tien-te").maskMoney({thousands:",", allowZero:true, /*suffix: " VNĐ",*/precision:3});
    $(document).on('click', '.btn-xem-chi-tiet-thuc-hien', function (e) {
        e.preventDefault();
        var $trangThaiCV = $(this).attr('data-value');
        viewData('thuc-hien-cong-viec/xem-chi-tiet-trang-thai', {
            trang_thai_cv: $trangThaiCV
        }, 'l');
    });
    $(document).on('click', '.btn-xem-va-phan-hoi', function (e) {
        e.preventDefault();
        var $idPhanHoi = $(this).attr('data-value');
        var $idNguoiNhan = $(this).attr('data-nguoi_nhan');
        loadForm({type: 'xem_va_phan_hoi', data: $idPhanHoi, nguoiNhan: $idNguoiNhan, da_xem: true}, 'l', function (data) {
            setTimeout(function () {
                $("#nguoi-nhan-phan-hoi").select2();
            }, 500)
        }, function () {
            SaveObject('thuc-hien-cong-viec/phan-hoi', $("#form-phan-hoi").serializeArray(), function (data) {
            });
        })
    });
    // Hiển thị thông báo các công việc đã hoàn thành nhưng chưa duyệt
    // setTimeout(function () {
    //     $.ajax({
    //         url: 'index.php?r=site/get-cong-viec-ht-chua-duyet',
    //         dataType: 'json',
    //         success: function (data) {
    //             if(data.hienThi == 1 && parseInt(data.soluong) > 0){
    //                 toastr.options = {
    //                     "closeButton": true,
    //                     "debug": false,
    //                     "positionClass": "toast-top-right",
    //                     "onclick": function () {
    //                         window.location = 'index.php?r=quan-ly-cong-viec/cho-duyet-hoan-thanh'
    //                     },
    //                     "showDuration": "10000",
    //                     "hideDuration": "1000",
    //                     "timeOut": "10000",
    //                     "extendedTimeOut": "1000",
    //                     "showEasing": "swing",
    //                     "hideEasing": "linear",
    //                     "showMethod": "fadeIn",
    //                     "hideMethod": "fadeOut"
    //                 };
    //                 toastr['info']("Bạn cần duyệt " + data.soluong + " công việc Đã hoàn thành. Click vào để xem chi tiết", "Thông báo");
    //             };
    //         }
    //     })
    // }, 1000);.
    $(document).on('click', '.cap-nhat-trang-thai-cong-viec', function (e) {
        e.preventDefault();
        if($(this).attr('data-type') === 'cv_phong_ban'){
            loadForm({type: 'duyet_de_nghi', phongbanthuchiencv: $(this).attr('data-phong_ban_thuc_hien_tham_dinh')}, 'xl', function (data) {

            }, function () {
                if($("#trangthaithamdinh-trang_thai").val() == ''){
                    $.alert('Vui lòng nhập thông tin trạng thái công việc');
                    $("#trangthaithamdinh-trang_thai").focus();
                    return false;
                }else{
                    SaveObjectUploadFile('thuc-hien-cong-viec/duyet-de-nghi-tham-dinh', new FormData($("#form-capnhat-trangthai-cv")[0]), function (data) {
                        $.pjax.reload({container: "#crud-datatable-pjax"});
                    })
                }
            })
        }else{
            loadForm({type: 'cap_nhat_trang_thai_ca_nhan', denghi: $(this).attr('data-ca_nhan_thuc_hien')}, 'xl', function (data) {

            }, function () {
                if($("#trangthainguoithuchiencv-trang_thai").val() == ''){
                    $.alert('Vui lòng chọn trạng thái công việc cần cập nhật');
                    $("#trangthainguoithuchiencv-trang_thai").focus();
                    return false;
                }else{
                    var data = new FormData($("#form-capnhat-trangthai-cvnv")[0]);
                    return SaveObjectUploadFile('thuc-hien-cong-viec/duyet-de-nghi-ca-nhan', data, function (data) {
                        $.pjax.reload({container: "#crud-datatable-pjax"});
                    });
                }

            })
        }
    });

    $(document).on('click', '.btn-xem-lich-su-thuc-hien', function (e) {
        e.preventDefault();
        $(".modal").css('z-index', '9050');
        viewData('thuc-hien-cong-viec/xem-lich-su-trang-thai', {phongBanThucHien: $(this).attr('data-value')},'l');
    });
    $(document).on('click', '.btn-close-modal', function (e){
        e.preventDefault();
        $("#modal-chi-tiet-cong-viec").modal('hide');
    })

    $(document).on('click', '.btn-xem-chi-tiet-chuc-nang', function (e){
        e.preventDefault();
        if($(this).attr('data-type') === 'cv_ca_nhan'){
            $.ajax({
                url: 'index.php?r=thuc-hien-cong-viec/chi-tiet',
                dataType: 'json',
                type: 'post',
                data: {
                    congViec: $(this).attr('data-value'),
                    idcanhan: $(this).attr('data-canhan')
                },
                beforeSend: function (){
                    Metronic.blockUI();
                },
                complete: function (){
                    Metronic.unblockUI();
                },
                success: function (data){
                    $("#modal-chi-tiet-cong-viec .modal-header").html(data.title + '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>');
                    $("#modal-chi-tiet-cong-viec .modal-body").html(data.content);
                    $("#modal-chi-tiet-cong-viec .modal-footer").html(data.footer);
                    setTimeout(function () {
                        $("#cong-viec-muc-tieu-list, #nguoi-nhan-phan-hoi").select2();
                    }, 500);

                    $("#modal-chi-tiet-cong-viec").modal('show');
                }
            })
        }else if(
            $(this).attr('data-type') !== 'lanh-dao-duyet-cong-viec'
            && $(this).attr('data-type') !== 'de-nghi-tham-van'
        ){
            $.ajax({
                url: 'index.php?r=thuc-hien-cong-viec/chi-tiet-cong-viec-don-vi',
                dataType: 'json',
                type: 'post',
                data: {
                    congViec: $(this).attr('data-value'),
                    idphongban: $(this).attr('data-idphongban')
                },
                beforeSend: function (){
                    Metronic.blockUI();
                },
                complete: function (){
                    Metronic.unblockUI();
                },
                success: function (data){
                    $("#modal-chi-tiet-cong-viec .modal-header").html(data.title + '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>');
                    $("#modal-chi-tiet-cong-viec .modal-body").html(data.content);
                    $("#modal-chi-tiet-cong-viec .modal-footer").html(data.footer);
                    setTimeout(function () {
                        $("#thuchiencongviec-phong_ban_thuc_hien, #nguoi-thuc-hien, #thuchiencongviec-phong_ban_thuc_hien, #cong-viec-muc-tieu-list").select2();
                    }, 500);

                    $("#modal-chi-tiet-cong-viec").modal('show');
                }
            })
        }

    })

    $(document).on('click', '.btn-luu-thuc-hien-cong-viec-ca-nhan', function (e){
        e.preventDefault();
        var data = new FormData($('#form-chi-tiet-cong-viec-ca-nhan')[0]);
        $("#modal-chi-tiet-cong-viec").css('z-index', '999');

        SaveObjectUploadFile('thuc-hien-cong-viec/save-chi-tiet-cong-viec-ca-nhan',
            data, function (data) {
                $("#modal-chi-tiet-cong-viec").modal('hide');
                $("#modal-chi-tiet-cong-viec .modal-body").html('');
                $.pjax.reload({container: "#crud-datatable-pjax"});
            });
    })

    $(document).on('click', '.btn-luu-thuc-hien-cong-viec-don-vi', function (e){
        e.preventDefault();
        var $data = new FormData($("#form-chi-tiet-cong-viec-ca-nhan")[0]);
        $("#modal-chi-tiet-cong-viec").css('z-index', '999');
        SaveObjectUploadFile('thuc-hien-cong-viec/luu-chi-tiet-don-vi-thuc-hien', $data, function (data) {
            $("#modal-chi-tiet-cong-viec").modal('hide');
            $("#modal-chi-tiet-cong-viec .modal-body").html('');
            $.pjax.reload({container: "#crud-datatable-pjax"});
        })
    });

    $(document).on('click', '.btn-edit-trang-thai-cv-muc-tieu', function (e){
        e.preventDefault();
        $.ajax({
            url: 'index.php?r=quan-ly-cong-viec/update-trang-thai-cv-muc-tieu',
            data: {model: $(this).attr('data-value')},
            dataType: 'json',
            type: 'post',
            beforeSend: function (){
                Metronic.blockUI();
                $("#block-ds-file-dinh-kem").html('');
            },
            success: function (data){
                for(const pro in data.model){
                    $("#lichsutinhtrangcv-" + pro ).val(data.model[pro]);
                }
               $(".block-message-if-edit-status-task").html('<div class="alert alert-warning">SỬA THÔNG TIN TRẠNG THÁI. VUI LÒNG NHẤN NÚT CẬP NHẬT NẾU BẠN ĐỒNG Ý CẬP NHẬT LẠI NỘI DUNG TRẠNG THÁI</div>');
                $("#title-tab-thong-tincap-nhat-trang-thai").click();
                $("#form-trang-thai-cv").addClass('bg-warning');
                if(data.fileDinhKems.length > 0){
                    var $ul = '';
                    $.each(data.fileDinhKems, function (item, obj){
                        $ul += '<li><a target="_blank" href="file_cong_van/'+obj.file+'" title="'+obj.file+'" data-value="'+obj.id+'">'+obj.file+'</a> <a href="#" class="text-danger btn-xoa-file-dinh-kem" data-value="'+obj.id+'"><i class="fa fa-close"></i></a></li>';
                    });
                    $(".block-ds-file-dinh-kem").html('<h5>FILE ĐÍNH KÈM</h5><ul>' + $ul + '</ul>');
                }
            },
            complete: function (){
                Metronic.unblockUI();
            }
        })
    })

    // $(document).on('click', '.block-file-dinh-kem', function (e){
    //     e.preventDefault();
    //     window.open('file_cong_van/' + $(this).find('input').val());
    // });
});
