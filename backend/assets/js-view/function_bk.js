// function blockPage(){
//     <div className="spinner-border text-info" role="status">
//         <span className="sr-only">Loading...</span>
//     </div>
// }

window.blockPage = function blockPage() {
    $.blockUI({
        message: '<div class="spinner-border text-primary" role="status"></div>',
        css: {
            backgroundColor: 'transparent',
            border: '0'
        },
        overlayCSS: {
            backgroundColor: '#fff',
            opacity: 0.8
        }
    });
}
window.unblockPage = function unblockPage() {
    $.unblockUI();
}

function resetForm() {
    window.location.reload();
}

function getDataInSelector(element) {
    var data = '';
    if (element.text() == "--Chọn--") {
        data = element.val();
    } else {
        data = element.text();
    }
    console.log(data);
    return data;
}

$(document).ready(function () {
    // $('li a.en').click(function (){
    //     $('li.nav-item a font').css('font-size','10pt');
    // });
    $('.nav-item.has-dropdown').after().click(function(){
        $(this).find('ul.dropdown-menu').toggleClass("show");
    });
    $(window).on("load", function () {
        $(".preloader").fadeOut(5000);
        $(".preloader").remove();
    });

    /* ------------------  Background INSERT ------------------ */

    var $bgSection = $(".bg-section");
    var $bgPattern = $(".bg-pattern");
    var $colBg = $(".col-bg");

    $bgSection.each(function () {
        var bgSrc = $(this).children("img").attr("src");
        var bgUrl = "url(" + bgSrc + ")";
        $(this).parent().css("backgroundImage", bgUrl);
        $(this).parent().addClass("bg-section");
        $(this).remove();
    });

    $bgPattern.each(function () {
        var bgSrc = $(this).children("img").attr("src");
        var bgUrl = "url(" + bgSrc + ")";
        $(this).parent().css("backgroundImage", bgUrl);
        $(this).parent().addClass("bg-pattern");
        $(this).remove();
    });

    $colBg.each(function () {
        var bgSrc = $(this).children("img").attr("src");
        var bgUrl = "url(" + bgSrc + ")";
        $(this).parent().css("backgroundImage", bgUrl);
        $(this).parent().addClass("col-bg");
        $(this).remove();
    });

    /* ------------------  NAV MODULE  ------------------ */

    var $moduleIcon = $(".module-icon"),
        $moduleCancel = $(".module-cancel");
    $moduleIcon.on("click", function (e) {
        $(this).parent().siblings().removeClass("module-active"); // Remove the class .active form any sibiling.
        $(this).parent(".module").toggleClass("module-active"); //Add the class .active to parent .module for this element.
        e.stopPropagation();
    });
    // If Click on [ Search-cancel ] Link
    $moduleCancel.on("click", function (e) {
        $(".module").removeClass("module-active");
        e.stopPropagation();
        e.preventDefault();
        $(".wrapper").removeClass("sidearea-active");
    });

    $(".sidearea-icon").on("click", function () {
        if ($(this).parent().hasClass("module-active")) {
            $(".wrapper").addClass("sidearea-active");
            $(this).addClass("module-sidearea-close");
        } else {
            $(".wrapper").removeClass("sidearea-active");
            $(this).removeClass("module-sidearea-close");
        }
    });
    $(".module-cart .module-icon").click(function () {
        $(this).siblings(".cart-box").toggleClass("active");
    });
    //Close Modules On Clicking OutSide
    $(document).click(function () {
        if ($(".cart-box").hasClass("active")) {
            $(".module-cart .module-icon").click();
        }

        if ($(".module-sidearea").hasClass("module-active")) {
            $(".module-sidearea .module-cancel").click();
            $(".wrapper").removeClass("sidearea-active");
        }
    });
    //Close Modules On Pressing Esc
    $(document).keyup(function (e) {
        // ESCAPE key pressed
        if (e.keyCode == 27) {
            if ($(".cart-box").hasClass("active")) {
                $(".module-cart .module-icon").click();
            }
            if ($(".module-search").hasClass("module-active")) {
                $(".module-search .module-cancel").click();
            }
            if ($(".module-sidearea").hasClass("module-active")) {
                $(".module-sidearea .module-cancel").click();
                $(".wrapper").removeClass("sidearea-active");
            }
        }
    });

    $(
        ".cart-box , .module-cart .module-icon , .module-search .form-search , .module-sidearea .module-sidearea-wrap"
    ).click(function (e) {
        e.stopPropagation();
    });

    /* ------------------  MOBILE MENU ------------------ */

    var $dropToggle = $("[data-toggle='dropdown']");
    $dropToggle.on("click", function (event) {
        event.preventDefault();
        event.stopPropagation();
        $(this).parent().siblings().removeClass("show");
        $(this).parent().toggleClass("show");
    });

    /*POPUP HEADER */
    $(".toggle-icon").click(function () {
        $(".popup-menu").addClass("active");
    });
    $(".popup-close i").click(function () {
        $(".popup-menu").removeClass("active");
    });
    $(document).keyup(function (e) {
        // ESCAPE key pressed
        if (e.keyCode == 27) {
            if ($(".popup-menu").hasClass("active")) {
                $(".popup-close i").click();
            }
        }
    });

    /* ------------------ HEADER FIXED ------------------ */

    $(window).scroll(function () {
        if ($(document).scrollTop() > 120) {
            $("#primary-menu").addClass("navbar-fixed");
        } else {
            $("#primary-menu").removeClass("navbar-fixed");
        }
    });
    /* ------------------  COUNTER UP ------------------ */

    $.fn.zyCounter = function (options) {
        var settings = $.extend(
            {
                duration: 40,
                easing: "swing",
            },
            options
        );
        return this.each(function () {
            var $this = $(this);

            var startCounter = function () {
                var numbers = [];
                var length = $this.length;
                var number = $this.text();
                var isComma = /[,\-]/.test(number);
                var isFloat = /[,\-]/.test(number);
                var number = number.replace(/,/g, "");
                var divisions = settings.duration;
                var decimalPlaces = isFloat ? (number.split(".")[1] || []).length : 0;

                // make number string to array for displaying counterup
                for (var rcn = divisions; rcn >= 1; rcn--) {
                    var newNum = parseInt((number / divisions) * rcn);
                    if (isFloat) {
                        newNum = parseFloat((number / divisions) * rcn).toFixed(
                            decimalPlaces
                        );
                    }
                    if (isComma) {
                        while (/(\d+)(\d{3})/.test(newNum.toString())) {
                            newNum = newNum
                                .toString()
                                .replace(/(\d+)(\d{3})/, "$1" + "," + "$2");
                        }
                    }

                    numbers.unshift(newNum);
                }
                var counterUpDisplay = function () {
                    $this.text(numbers.shift());
                    setTimeout(counterUpDisplay, settings.duration);
                };
                setTimeout(counterUpDisplay, settings.duration);
            }; // end function

            //bind with waypoints
            $this.waypoint(startCounter, {
                offset: "100%",
                triggerOnce: true,
            });
        });
    };

    $(".counting").zyCounter();

    /* ------------------ COUNTDOWN DATE ------------------ */

    $(document).ready(function () {
        if ($(".countdown").length > 0) {
            $(".countdown").each(function () {
                var $countDown = $(this),
                    countDate = $countDown.data("count-date"),
                    newDate = new Date(countDate);
                $countDown.countdown({
                    until: newDate,
                    format: "MMMM Do , h:mm:ss a",
                });
            });
        }
        $(".js-form-bao-gia").validate({
            onfocusout: false,
            onkeyup: false,
            onclick: false,
            rules: {
                "name": {
                    required: true,
                },
                "company": {
                    required: true,
                }
            }
        });

    });

    /* ------------------  AJAX MAILCHIMP ------------------ */

    $(".mailchimp").ajaxChimp({
        url: "http://wplly.us5.list-manage.com/subscribe/post?u=91b69df995c1c90e1de2f6497&id=aa0f2ab5fa", //Replace with your own mailchimp Campaigns URL.
        callback: chimpCallback,
    });

    function chimpCallback(resp) {
        if (resp.result === "success") {
            $(".subscribe-alert")
                .html('<div class="alert alert-success">' + resp.msg + "</div>")
                .fadeIn(1000);
            //$('.subscribe-alert').delay(6000).fadeOut();
        } else if (resp.result === "error") {
            $(".subscribe-alert")
                .html('<div class="alert alert-danger">' + resp.msg + "</div>")
                .fadeIn(1000);
        }
    }

    $(".subscribe-alert").on("click", function () {
        $(this).fadeOut();
    });

    /* ------------------  AJAX CAMPAIGN MONITOR  ------------------ */

    $("#campaignmonitor").submit(function (e) {
        e.preventDefault();
        $.getJSON(
            this.action + "?callback=?",
            $(this).serialize(),
            function (data) {
                if (data.Status === 400) {
                    alert("Error: " + data.Message);
                } else {
                    // 200
                    alert("Success: " + data.Message);
                }
            }
        );
    });

    /* ------------------ OWL CAROUSEL ------------------ */

    var $carouselDirection = $("html").attr("dir");
    if ($carouselDirection == "rtl") {
        var $carouselrtl = true;
    } else {
        var $carouselrtl = false;
    }

    $(".carousel").each(function () {
        var $Carousel = $(this);
        $Carousel.owlCarousel({
            loop: $Carousel.data("loop"),
            autoplay: $Carousel.data("autoplay"),
            margin: $Carousel.data("space"),
            nav: $Carousel.data("nav"),
            dots: $Carousel.data("dots"),
            center: $Carousel.data("center"),
            dotsSpeed: $Carousel.data("speed"),
            animateOut: "fadeOut",
            responsive: {
                0: {
                    items: 1,
                },
                567: {
                    items: 1,
                    margin: 0,
                },
                600: {
                    items: $Carousel.data("slide-rs"),
                },
                1000: {
                    items: $Carousel.data("slide"),
                },
            },
        });
    });

    $(".custom-carousel").each(function () {
        var $Carousel = $(this);
        $Carousel.owlCarousel({
            loop: $Carousel.data("loop"),
            autoplay: $Carousel.data("autoplay"),
            margin: $Carousel.data("space"),
            nav: $Carousel.data("nav"),
            dots: $Carousel.data("dots"),
            center: $Carousel.data("center"),
            dotsSpeed: $Carousel.data("speed"),
            dotsContainer: "#carousel-custom-dots",
            responsive: {
                0: {
                    items: 1,
                },
                600: {
                    items: $Carousel.data("slide-rs"),
                },
                1000: {
                    items: $Carousel.data("slide"),
                },
            },
        });
    });
    $(".custom-carousel").owlCarousel({
        thumbs: true,
        thumbsPrerendered: true,
    });
    $("#carousel-custom-dots .owl-dot").click(function () {
        $(this).siblings(".owl-dot").removeClass("active");
        $(this).addClass("active");
        $(".custom-carousel").trigger("to.owl.carousel", [$(this).index(), 300]);
    });

    $(".custom-carousel").on("changed.owl.carousel", function (event) {
        var items = event.item.count; // Number of items
        var item = event.item.index; // Position of the current item
        var owlDots = document.querySelectorAll("#carousel-custom-dots .owl-dot");
        if (owlDots.length > 0) {
            owlDots[item].click();
        }
    });

    /* ------------------ MAGNIFIC POPUP ------------------ */

    var $imgPopup = $(".img-popup");
    $imgPopup.magnificPopup({
        type: "image",
    });
    $(".img-gallery-item").magnificPopup({
        type: "image",
        gallery: {
            enabled: true,
        },
    });

    /* ------------------  MAGNIFIC POPUP VIDEO ------------------ */

    $(".popup-video,.popup-gmaps").magnificPopup({
        disableOn: 700,
        mainClass: "mfp-fade",
        removalDelay: 0,
        preloader: false,
        fixedContentPos: false,
        type: "iframe",
        iframe: {
            markup:
                '<div class="mfp-iframe-scaler">' +
                '<div class="mfp-close"></div>' +
                '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>' +
                "</div>",
            patterns: {
                youtube: {
                    index: "youtube.com/",
                    id: "v=",
                    src: "//www.youtube.com/embed/%id%?autoplay=1",
                },
            },
            srcAction: "iframe_src",
        },
    });

    /* ------------------  BACK TO TOP ------------------ */

    var backTop = $("#back-to-top");

    if (backTop.length) {
        var scrollTrigger = 200, // px
            backToTop = function () {
                var scrollTop = $(window).scrollTop();
                if (scrollTop > scrollTrigger) {
                    backTop.addClass("show");
                } else {
                    backTop.removeClass("show");
                }
            };
        backToTop();
        $(window).on("scroll", function () {
            backToTop();
        });
        backTop.on("click", function (e) {
            e.preventDefault();
            $("html,body").animate(
                {
                    scrollTop: 0,
                },
                700
            );
        });
    }

    /* ------------------ GALLERY FLITER ------------------ */

    var $galleryFilter = $(".gallery-filter"),
        galleryLength = $galleryFilter.length,
        protfolioFinder = $galleryFilter.find("a"),
        $galleryAll = $("#gallery-all");

    // init Isotope For gallery
    protfolioFinder.on("click", function (e) {
        e.preventDefault();
        $galleryFilter.find("a.active-filter").removeClass("active-filter");
        $(this).addClass("active-filter");
    });
    if (galleryLength > 0) {
        $galleryAll.imagesLoaded().progress(function () {
            $galleryAll.isotope({
                filter: "*",
                animationOptions: {
                    duration: 750,
                    itemSelector: ".gallery-item",
                    easing: "linear",
                    queue: false,
                },
            });
        });
    }
    protfolioFinder.on("click", function (e) {
        e.preventDefault();
        var $selector = $(this).attr("data-filter");
        $galleryAll.imagesLoaded().progress(function () {
            $galleryAll.isotope({
                filter: $selector,
                animationOptions: {
                    duration: 750,
                    itemSelector: ".gallery-item",
                    easing: "linear",
                    queue: false,
                },
            });
            return false;
        });
    });

    /* ------------------ WORK FLITER ------------------ */

    var $workFilter = $(".cases-filter"),
        workLength = $workFilter.length,
        workFinder = $workFilter.find("a"),
        $workAll = $("#all-cases");

    // init Isotope For gallery
    workFinder.on("click", function (e) {
        e.preventDefault();
        $workFilter.find("a.active-filter").removeClass("active-filter");
        $(this).addClass("active-filter");
    });
    if (workLength > 0) {
        $workAll.imagesLoaded().progress(function () {
            $workAll.isotope({
                filter: "*",
                animationOptions: {
                    duration: 750,
                    itemSelector: ".work-item",
                    easing: "linear",
                    queue: false,
                },
            });
        });
    }
    workFinder.on("click", function (e) {
        e.preventDefault();
        var $selector = $(this).attr("data-filter");
        $workAll.imagesLoaded().progress(function () {
            $workAll.isotope({
                filter: $selector,
                animationOptions: {
                    duration: 750,
                    itemSelector: ".work-item",
                    easing: "linear",
                    queue: false,
                },
            });
            return false;
        });
    });

    /* ------------------  SCROLL TO ------------------ */

    var aScroll = $('a[data-scroll="scrollTo"]');
    aScroll.on("click", function (event) {
        var target = $($(this).attr("href"));
        if (target.length) {
            event.preventDefault();
            $("html, body").animate(
                {
                    scrollTop: target.offset().top,
                },
                1000
            );
            if ($(this).hasClass("menu-item")) {
                $(this).parent().addClass("active");
                $(this).parent().siblings().removeClass("active");
            }
        }
    });

    /* ------------------ PROGRESS BAR ------------------ */

    $(".progressbar").each(function () {
        $(this).waypoint(
            function () {
                var progressBar = $(".progress-bar"),
                    progressBarTitle = $(".progress-title .value");
                progressBar.each(function () {
                    $(this).css("width", $(this).attr("aria-valuenow") + "%");
                });
                progressBarTitle.each(function () {
                    $(this).css("opacity", 1);
                });
            },
            {
                triggerOnce: true,
                offset: "bottom-in-view",
            }
        );
    });

    /* ------------------  AJAX CONTACT FORM  ------------------ */

    var contactForm = $(".contactForm"),
        contactResult = $(".contact-result");
    var btnImport = $("#import-data");
    contactForm.on("submit", function (e) {
        var data;
        data = new FormData();
        data.append("file-excel", $("input[type='file']")[0].files[0]);
        $.ajax({
            url: "https://xnkbluesky.com/app/index.php?r=service/import-excel",
            data: data,
            type: "POST",
            processData: false,
            contentType: false,
            success: function (data) {
                alertify.success('Import thành công các tuyến hàng');
                // resetForm();
            },
            error: function (e) {
                console.log(e.responseText);
            },
        });
        e.preventDefault();

        return false;
    });

    /* ------------------ LOAD MORE ------------------ */

    $("#loadMore").on("click", function (e) {
        e.preventDefault();
        $(".content.d-none").slice(0, 3).removeClass("d-none");
        if ($(".content.d-none").length == 0) {
            $("#loadMore").addClass("d-none");
        }
    });

    /* ------------------ ACCORDIONS ------------------ */

    $(".collapse").on("shown.bs.collapse", function () {
        $(this).parent(".card").addClass("active-acc");
    });
    $(".collapse").on("hidden.bs.collapse", function () {
        $(this).parent(".card").removeClass("active-acc");
    });

    /* ------------------  SELECT BOX ------------------ */

//   if ($(".js-form-bao-gia").length > 0) {
//     const loaiHang = $(".js-loai-hang");
//     const cangDen = $(".js-cang-den");
//     const cangDi = $(".js-cang-di");
//     const loaiCont = $(".js-loai-cont");
//     const cbm = $("input[name='cbm']");
//     const khoiLuong = $("input[name='kg']");
//     const matHang = $("input[name='mat-hang']");
//     const vanChuyen = $(".js-van-chuyen");
//     const phone = $("input[name='phone']");
//     const name = $("input[name='name']");
//     const company = $("input[name='company']");
//     const email = $("input[name='email']");
//
//     var ajaxLoaiHang = $.ajax({
//       context: $(".js-loai-hang"),
//       dataType: "json",
//       url: "https://app.xnkbluesky.com/service/get-loai-hang",
//     });
//
//     var ajaxCang = $.ajax({
//       context: $(".js-cang-den"),
//       dataType: "json",
//       url: "https://app.xnkbluesky.com/service/get-cang",
//     });
//
//     var ajaxLoaiCont = $.ajax({
//       context: $(".js-loai-cont"),
//       dataType: "json",
//       url: "https://app.xnkbluesky.com/service/get-loai-cont",
//     });
//
//     var ajaxVanChuyen = $.ajax({
//       context: $(".js-van-chuyen"),
//       dataType: "json",
//       url: "https://app.xnkbluesky.com/service/get-van-chuyen",
//     });
//
//     $.when(ajaxLoaiHang, ajaxCang, ajaxLoaiCont, ajaxVanChuyen).done(function (
//       r1,
//       r2,
//       r3,
//       r4
//     ) {
//       // Each returned resolve has the following structure:
//       // [data, textStatus, jqXHR]
//       // e.g. To access returned data, access the array at index 0
//       $(
//         ".js-loai-hang,.js-cang-den,.js-cang-di,.js-loai-cont,.js-van-chuyen"
//       ).empty();
//       loaiHang.append("<option value=''> --Chọn--</option>");
//       $.each(r1[0].data, function (index, item) {
//         loaiHang.append(
//           "<option " + " value=" + item.id + ">" + item.name + "</option>"
//         );
//       });
//       cangDen.append("<option value=''> --Chọn--</option>");
//       $.each(r2[0].data, function (index, item) {
//         cangDen.append(
//           "<option " + " value=" + item.id + ">" + item.name + "</option>"
//         );
//       });
//       cangDi.append("<option value=''> --Chọn--</option>");
//       $.each(r2[0].data, function (index, item) {
//         cangDi.append(
//           "<option " + " value=" + item.id + ">" + item.name + "</option>"
//         );
//       });
//       loaiCont.append("<option value=''> --Chọn--</option>");
//       $.each(r3[0].data, function (index, item) {
//         loaiCont.append(
//           "<option " + " value=" + item.id + ">" + item.name + "</option>"
//         );
//       });
//       vanChuyen.append("<option value=''> --Chọn--</option>");
//       $.each(r4[0].data, function (index, item) {
//         vanChuyen.append(
//           "<option " + " value=" + item.id + ">" + item.name + "</option>"
//         );
//       });
//       $("select[id$='lang']").niceSelect();
//     });
//     loaiHang.change(function (e) {
//       if ($(this).find("option:selected").val() == 13) {
//         loaiCont.parentsUntil(".js-hidden").parent().removeClass("d-none");
//       } else {
//         loaiCont.parentsUntil(".js-hidden").parent().addClass("d-none");
//       }
//
//       if ($(this).find("option:selected").val() == 12) {
//         cbm.parent().removeClass("d-none");
//       } else {
//         cbm.parent().addClass("d-none");
//       }
//     });
//     $(".js-submit-bao-gia").on("click", function (e) {
//       e.preventDefault();
//       if (phone.val() == '') {
//         phone.after(`<span class="text-red">Số điện thoại không được để trống</span>`);
//       }else {
//         $.ajax({
//           data: {
//             loai_hang: loaiHang.val(),
//             cang_den: parseInt(cangDen.val()),
//             cang_di: parseInt(cangDi.val()),
//             khoi_luong: parseFloat(khoiLuong.val()),
//             ten_hang: matHang.val(),
//             van_chuyen: vanChuyen.val(),
//             cbm: parseInt(cbm.val()),
//           },
//           dataType: "json",
//           type: "post",
//           url: "https://app.xnkbluesky.com/service/search-tuyen-hang",
//         })
//           .done(function (data) {
//             // If successful
//             if ($(".transform-price").length > 0) {
//               $(".transform-price").html(
//                 `<span>Giá vận chuyển của bạn là: ${data.data[0].tong_thanh_toan}</span><span class="text-red ml-3">LH: <a href="tel:0981636575">0981636575</a></span>`
//               );
//             }
//
//             $.ajax({
//               url: "https://app.hpmap.vn/service/xac-thuc-email-logistics",
//               dataTpe: "json",
//               type: "post",
//               data: {
//                 from: "info@xnkbluesky.com",
//                 to: "info@xnkbluesky.com",
//                 subject: "Nhận báo giá từ website",
//                 name: "XNKBluesky",
//                 content: `<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
// <html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml" lang="en">
//
// <head>
//   <link rel="stylesheet" type="text/css" hs-webfonts="true" href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap">
//   <title>Email báo giá</title>
//   <meta property="og:title" content="Email template">
//
//   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
//
//   <meta http-equiv="X-UA-Compatible" content="IE=edge">
//
//   <meta name="viewport" content="width=device-width, initial-scale=1.0">
//
//   <style type="text/css">
//     a {
//       text-decoration: underline;
//       color: inherit;
//       font-weight: bold;
//       color: #253342;
//     }
//
//     h1 {
//       font-size: 56px;
//     }
//
//     h2 {
//       font-size: 28px;
//       font-weight: 900;
//       margin-bottom: 0;
//       margin-top: 0;
//     }
//     h3 {
//       font-weight: 900;
//       margin-bottom: 0;
//       margin-top: 0;
//     }
//
//     p {
//       font-weight: 400;
//     }
//
//     td {
//       vertical-align: top;
//     }
//
//     #email {
//       margin: auto;
//       width: 100%;
//       background-color: white;
//
//     }
//
//     button {
//       font: inherit;
//       background-color: #FF7A59;
//       border: none;
//       padding: 10px;
//       text-transform: uppercase;
//       letter-spacing: 2px;
//       font-weight: 900;
//       color: white;
//       border-radius: 5px;
//       box-shadow: 3px 3px #d94c53;
//     }
//
//     .subtle-link {
//       font-size: 9px;
//       text-transform: uppercase;
//       letter-spacing: 1px;
//       color: #CBD6E2;
//     }
//
//     #email-identity {
//       color: #fff;
//       background-color: #153e90;
//       padding: 10px 15px;
//       font: inherit;
//       border: none;
//       padding: 10px;
//       text-transform: uppercase;
//       letter-spacing: 2px;
//       font-weight: 900;
//       color: white;
//       border-radius: 5px;
//       box-shadow: 3px 3px #153e90;
//       text-decoration: unset;
//     }
//   </style>
//
// </head>
//
// <body bgcolor="#F5F8FA" style="width: 100%; margin: auto 0; padding:0; font-family:Roboto, sans-serif; font-size:18px; color:#33475B; word-break:break-word">
//
//   <! View in Browser Link -->
//
//     <div id="email">
//       <! Banner -->
//         <table role="presentation" style="padding: 30px 30px 30px 60px;" width="100%">
//           <tr>
//
//             <td bgcolor="#153e90" align="center" style="color: white;">
//
//               <img alt="BLuesky" src="https://xnkbluesky.com/sites/default/files/logo-white.png" width="400px" align="middle">
//
//               <h1> Chào mừng đến với HaiPhongLogistic </h1>
//
//             </td>
//         </table>
//         <table role="presentation" border="0" cellpadding="0" cellspacing="10px" style="padding: 30px 30px 30px 60px;" width="100%">
//               <tr>
//                 <td><h2> Nhận báo giá và tra cứu</h2>
//                 <p>
//                   Chào mừng bạn đến với HaiPhongLogistic.
//                 </p></td>
//               </tr>
//               <tr>
//                 <td><h3> Thông tin báo giá và tra cứu</h3></td>
//               </tr>
//               <tr>
//                 <td><strong> Loại hàng</strong>: ${loaiHang.find("option:selected").text()}</td>
//               </tr>
//               <tr>
//                 <td><strong> Cảng đến</strong>: ${cangDen.find("option:selected").text()}</td>
//               </tr>
//               <tr>
//                 <td><strong> Cảng đi</strong>: ${cangDi.find("option:selected").text()}</td>
//               </tr>
//               <tr>
//                 <td><strong> Khối lượng </strong>: ${khoiLuong.val()}</td>
//               </tr>
//               <tr>
//                 <td><strong> Tên hàng</strong>: ${matHang.val()}</td>
//               </tr>
//               <tr>
//                 <td><strong> Vận chuyện</strong>: ${vanChuyen.val()}</td>
//               </tr>
//               <tr>
//                 <td><strong> CBM</strong>: ${cbm.val()}</td>
//               </tr>
//               <tr>
//                 <td><h3> Thông tin liên hệ</h3></td>
//               </tr>
//               <tr>
//                 <td><strong> Họ tên</strong>: ${name.val()}</td>
//               </tr>
//               <tr>
//                 <td><strong> Tên công ty</strong>: ${company.val()}</td>
//               </tr>
//               <tr>
//                 <td><strong> Số điện thoại</strong>: ${phone.val()}</td>
//               </tr>
//               <tr>
//                 <td><strong> Email</strong>: ${email.val()}</td>
//               </tr>
//           </table>
//     </div>
// </body>
//
// </html>`,
//               },
//               success: function (data) {
//                 console.log(data);
//
//               },
//               error: function (data) {
//                 console.log(data);
//               },
//             });
//
//
//             console.log(data);
//           })
//           .fail(function (jqXHR, textStatus, errorThrown) {
//             // If fail
//             console.log(textStatus + ": " + errorThrown);
//           });
//       }
//     });
//     $('.js-hidden-quy-doi-kich-thuoc').css('display','none');
//     $('.js-visible-quy-doi-kich-thuoc').on('click', function (e){
//
//       e.preventDefault();
//       $('.js-hidden-quy-doi-kich-thuoc').slideToggle();
//     })
//     $('.js-submit-quy-doi-kich-thuoc').on('click', function (e){
//       const width = $('input[name="width"]');
//       const height = $('input[name="height"]');
//       const length = $('input[name="length"]');
//       const quantity = $('input[name="quantity"]');
//       let cbm = '';
//       let kgs = '';
//       e.preventDefault();
//       cbm = (width.val()*height.val()*length.val()) * quantity.val();
//       kgs = cbm * 166.67;
//       $('.js-so-khoi-cbm').text(cbm);
//       $('.js-so-khoi-kgs').text(kgs.toFixed(2));
//
//     })
//   }


    /* ------------------  CONTACT FORM TOGGLE ------------------ */
    $('#goog-gt-tt').replaceWith(' ');

    $(".contact-types .button").click(function () {
        if ($(".contact-card .contact-body").hasClass($(this).data("form"))) {
            return false;
        }
        $(this).siblings(".button").removeClass("active");
        $(this).addClass("active");
        $(".contact-card .contact-body").toggleClass(
            "trackFormActive quoteFormActive"
        );
    });

    function filterPriceTable(num) {
        if (num)
            return num
    }

    $(document).on('click', '.js-submit-search', function (e) {
        e.preventDefault();
        $(this).parentsUntil('.contact-body').find('.js-form-bao-gia').submit();
        const name = $(this).parentsUntil('.contact-body').find('[name="name"]').val();
        const company = $(this).parentsUntil('.contact-body').find('[name="company"]').val();
        const phone = $(this).parentsUntil('.contact-body').find('[name="phone"]').val();
        const email = $(this).parentsUntil('.contact-body').find('[name="email"]').val();
        const loaiCont = $(this).parentsUntil('.contact-body').find('[name="loai_cont"]').val();
        const portFrom = $(this).parentsUntil('.contact-body').find('[name="port-from"] option:selected').text();
        const portTo = $(this).parentsUntil('.contact-body').find('[name="port-to"] option:selected').text();
        const valueMass = $(this).parentsUntil('.js-form-bao-gia').find('[name="mass"]').val();
        const valueLength = $(this).parentsUntil('.js-form-bao-gia').find('[name="length"]').val();
        const valueWidth = $(this).parentsUntil('.js-form-bao-gia').find('[name="width"]').val();
        const valueHeight = $(this).parentsUntil('.js-form-bao-gia').find('[name="height"]').val();
        const Cont20GP = $(this).parentsUntil('.js-form-bao-gia').find('[name="20GP"]').val();
        const Cont40GP = $(this).parentsUntil('.js-form-bao-gia').find('[name="40GP"]').val();
        const Cont20RF = $(this).parentsUntil('.js-form-bao-gia').find('[name="20RF"]').val();
        const Cont40HC = $(this).parentsUntil('.js-form-bao-gia').find('[name="40HC"]').val();
        const Cont40RF = $(this).parentsUntil('.js-form-bao-gia').find('[name="40RF"]').val();
        let cbm = $(this).parentsUntil('.js-form-bao-gia').find('[name="cbm"]').val();
        let subjectCbm = $(this).parentsUntil('.js-form-bao-gia').find('[name="cbm"]');
        let subjectMass = $(this).parentsUntil('.js-form-bao-gia').find('[name="mass"]');
        let subjectLength = $(this).parentsUntil('.js-form-bao-gia').find('[name="length"]');
        let subjectWidth = $(this).parentsUntil('.js-form-bao-gia').find('[name="width"]');
        let subjectHeight = $(this).parentsUntil('.js-form-bao-gia').find('[name="height"]');
        let resultSea = $(this).parentsUntil('.js-form-bao-gia').find('.results-sea');
        let resultAir = $(this).parentsUntil('.js-form-bao-gia').find('.results-air');
        const loaiHangId = $(this).data('value');
        const tableFCL = $(this).parentsUntil('.contact-body').parent().next();
        let table = '';
        let check = true;
        if (name === '') {
            if ($(".error-name").length > 0) {
                $(".error-name").html('<p class="text-danger error-name">*Họ tên không được để trống</p>');
            } else {
                $(this).parentsUntil('.contact-body').find('[name="name"]').after(`<p class="text-danger error-name">*Họ tên không được để trống</p>`);
            }
        }
        if (company === '') {
            if ($(".error-company").length > 0) {
                $(".error-company").html('<p class="text-danger error-company">*Công ty không được để trống</p>');
            } else {
                $(this).parentsUntil('.contact-body').find('[name="company"]').after(`<p class="text-danger error-company">*Công ty không được để trống</p>`);
            }
        }
        if (phone === '') {
            if ($(".error-phone").length > 0) {
                $(".error-phone").html('<p class="text-danger error-phone">*Số điện thoại không được để trống</p>');
            } else {
                $(this).parentsUntil('.contact-body').find('[name="phone"]').after(`<p class="text-danger error-phone">*Số điện thoại không được để trống</p>`);
            }
        }
        if (valueLength === '' && valueHeight === '' && valueWidth === '' && cbm === '') {
            // if($(".error-cbm").length > 0){
            //   $(".error-cbm").html('<p class="text-danger error-cbm">*Cbm  không được để trống</p>');
            // }else {
            //   $(this).parentsUntil('.error-cbm').find('[name="cbm"]').after(`<p class="text-danger error-cbm">*Cbm không được để trống</p>`);
            // }
            if ($(".error-mass").length > 0) {
                $(".error-mass").html('<p class="text-danger error-mass">*Kích thước  không được để trống</p>');
            } else {
                $(this).parentsUntil('.error-mass').find('[name="mass"]').after(`<p class="text-danger error-mass">*Kích thước không được để trống</p>`);
            }
        }
        if (valueLength === '' && valueHeight === '' && valueWidth === '' && cbm === '' || phone === '' || company === '' || name === '') {
            check = false;
        } else {
            check = true;
        }

        if (check) {
            $(".error-mass,.error-phone,.error-company,.error-name").remove();
            let length = 0;
            let width = 0;
            let height = 0;
            let mass = 0;
            let mathSea = 0;
            let mathAir = 0;
            let mathCbm = 0;
            subjectLength.each(function (index, value) {
                mathSea = mathSea + (($(subjectWidth[index]).val() * 1 * $(subjectHeight[index]).val() * $(subjectLength[index]).val() * $(subjectMass[index]).val()) / 1000000);
                mathAir = mathAir + (($(subjectWidth[index]).val() * 1 * $(subjectHeight[index]).val() * $(subjectLength[index]).val() * $(subjectMass[index]).val()) / 1000000) * 166.67;
            })
            mathSea = mathSea.toFixed(2);
            mathAir = mathAir.toFixed(2);

            if (loaiHangId == 32) {
                mathCbm = mathAir;
                $(this).parentsUntil('.js-form-bao-gia').find('[name="cbm"]').val(mathCbm);
            } else {
                mathCbm = mathSea;
                $(this).parentsUntil('.js-form-bao-gia').find('[name="cbm"]').val(mathCbm);
            }
            if (cbm * 1 > mathCbm * 1) {
                mathCbm = cbm;
                $(this).parentsUntil('.js-form-bao-gia').find('[name="cbm"]').val(mathCbm);
            }
            if (resultSea.length > 0) {
                resultSea.text(mathSea)
            }
            if (resultAir.length > 0) {
                resultAir.text(mathAir)
            }
            const conts = $('.input-number');
            const typeConts = {};
            const valueTypeConts = [];
            conts.map(function (index, value) {
                typeConts[$(this).attr('name').trim()] = $(this).val();
                if ($(this).val() > 0) {
                    valueTypeConts.push($(this).attr('name'));
                }
            });
            $.ajax({
                type: "POST",
                url: "/get-loai-hang",
                data: {
                    'loai_hang_id': loaiHangId,
                    'loai_cont': JSON.stringify(valueTypeConts),
                    'cang_den': portTo,
                    'cang_di': portFrom,
                },
                dataType: 'json',
                success: function (data) {
                    if (data.success == false) {
                        alertify.error(data.content)
                        return false;
                    }
                    console.log($(document).height())
                    table = table + `<h5 class="mb-2 mt-5">Danh sách các tuyến hiện có</h5>
                    <table class="table table-bordered table-white">
                          <thead>
                          <tr>
                            <th scope="col">Cảng đi</th>
                            <th scope="col">Cảng đến</th>
                            <th scope="col">Carrier</th>
                            <th scope="col">Loại hàng</th>
                            <th scope="col">Số cbm</th>
                            <th scope="col">Lịch tàu</th>
                            <th scope="col">Freetime</th>
                            <th scope="col">Transit time</th>
                            <th scope="col">LOCAL CHARGE</th>
                            <th scope="col" width="16%">Đơn giá</th>
                            <th scope="col">Tổng</th>
                            <th scope="col" ></th>
                          </tr>
                          </thead>
                          <tbody>`;
                    $.each(data, function (index, value) {
                        if (loaiHangId === 'FCL') {
                            arrPrice = value.bang_gia.map(function (item) {
                                return typeConts[item.type.trim()] * item.don_gia;
                            });
                            total = arrPrice.reduce((sum, cur) => sum + cur);
                            total=parseFloat(total)+ parseFloat(value.tuyen_hang.field_tong_phu_phi.replaceAll(',','')) ;
                            total = total.toLocaleString('en-US', {
                                style: 'currency',
                                currency: 'USD',
                                minimumFractionDigits: 1
                            });
                            tablePrice = value.bang_gia[0].don_vi_tinh.split("/")[0];
                        } else {
                            total = value.bang_gia.don_gia * mathCbm;
                            total=parseFloat(total)+ parseFloat(value.tuyen_hang.field_tong_phu_phi.replaceAll(',','')) ;
                            total = total.toLocaleString('en-US', {
                                style: 'currency',
                                currency: 'USD',
                                minimumFractionDigits: 1
                            });
                            tablePrice = value.bang_gia.don_vi_tinh.split("/")[0];
                        }
                        table = table + `<tr>
                        <td>${value.tuyen_hang.field_pod}</td>
                        <td>${value.tuyen_hang.field_pol}</td>
                        <td>${value.tuyen_hang.field_carrier}</td>
                        <td>${value.tuyen_hang.field_sectors}</td>
                        <td class="valCBM">${mathCbm}</td>
                        <td>${value.tuyen_hang.field_cut_of_customs_etd}</td>
                        <td>${value.tuyen_hang.field_transit_tim}</td>
                        <td>${value.tuyen_hang.field_pod_free_time}</td>
                        <td>${value.tuyen_hang.field_tong_phu_phi} ${tablePrice}</td>
                         <td class="don_gia">${value.don_gia} </td>
                        <td class="text-right total-price"> ${total} ${tablePrice}</td>
                        <td class="text-center"><a href="/booking" class="btn btn-primary js-booking-fcl" style="width: 110px" data-value="${value.tuyen_hang.id}">Booking</a></td>
                        </tr>`
                    });
                    table = table + `</tbody>
                        </table>`;
                    tableFCL.html(table);
                    tableFCL.html(table);
                    $(".container").animate({scrollTop: $(document).height()}, 1000);
                    var $t = $(this);
                    //Email o day
                    $.ajax({
                        url: "https://www.haiphonglog.com/app/index.php?r=new-api%2Fsend-mail",
                        dataTpe: "json",
                        type: "post",
                        data: {
                            hoTen: name,
                            tenCongTy: company,
                            email: email,
                            dienThoai: phone,
                            noiDung: `<table role="presentation" border="0" cellpadding="0" cellspacing="10px" style="padding: 30px 30px 30px 60px;" width="100%">
              <tr>
                <td><h3> Thông tin liên hệ</h3></td>
              </tr>
              <tr>
                <td><strong> Họ tên</strong>: ${name}</td>
              </tr>
              <tr>
                <td><strong> Tên công ty</strong>: ${company}</td>
              </tr>
              <tr>
                <td><strong> Số điện thoại</strong>: ${phone}</td>
              </tr>
              <tr>
                <td><strong> Email</strong>: ${email}</td>
              </tr>
             
          </table><div style="padding: 30px 30px 30px 60px;" width="100%">
          ${table}</div>`,
                        },
                        success: function (data) {
                            console.log('thành công');
                        },
                        error: function (data) {
                            console.log(data);
                        },
                    });
//         $.ajax({
//             url: "https://app.happyhomehaiphong.com/index.php?r=service/send-mail",
//             dataTpe: "json",
//             type: "post",
//             data: {
//                 from: "info@xnkbluesky.com",
//                 to: email,
//                 subject: "Nhận báo giá từ website",
//                 name: "HaiPhongLogistic",
//                 content: `<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
// <html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml" lang="en">
//
// <head>
//   <link rel="stylesheet" type="text/css" hs-webfonts="true" href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap">
//   <title>Email báo giá</title>
//   <meta property="og:title" content="Email template">
//
//   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
//
//   <meta http-equiv="X-UA-Compatible" content="IE=edge">
//
//   <meta name="viewport" content="width=device-width, initial-scale=1.0">
//
//   <style type="text/css">
//     a {
//       text-decoration: underline;
//       color: inherit;
//       font-weight: bold;
//       color: #253342;
//     }
//
//     h1 {
//       font-size: 56px;
//     }
//
//     h2 {
//       font-size: 28px;
//       font-weight: 900;
//       margin-bottom: 0;
//       margin-top: 0;
//     }
//     h3 {
//       font-weight: 900;
//       margin-bottom: 0;
//       margin-top: 0;
//     }
//
//     p {
//       font-weight: 400;
//     }
//
//     td {
//       vertical-align: top;
//     }
//     th{
//       text-align: left;
//     }
//
//     #email {
//       margin: auto;
//       width: 100%;
//       background-color: white;
//
//     }
//
//     button {
//       font: inherit;
//       background-color: #FF7A59;
//       border: none;
//       padding: 10px;
//       text-transform: uppercase;
//       letter-spacing: 2px;
//       font-weight: 900;
//       color: white;
//       border-radius: 5px;
//       box-shadow: 3px 3px #d94c53;
//     }
//
//     .subtle-link {
//       font-size: 9px;
//       text-transform: uppercase;
//       letter-spacing: 1px;
//       color: #CBD6E2;
//     }
//
//     #email-identity {
//       color: #fff;
//       background-color: #153e90;
//       padding: 10px 15px;
//       font: inherit;
//       border: none;
//       padding: 10px;
//       text-transform: uppercase;
//       letter-spacing: 2px;
//       font-weight: 900;
//       color: white;
//       border-radius: 5px;
//       box-shadow: 3px 3px #153e90;
//       text-decoration: unset;
//     }
//   </style>
//
// </head>
//
// <body bgcolor="#F5F8FA" style="width: 100%; margin: auto 0; padding:0; font-family:Roboto, sans-serif; font-size:18px; color:#33475B; word-break:break-word">
//
//
//     <div id="email">
//       <! Banner -->
//         <table role="presentation" style="padding: 30px 30px 30px 60px;" width="100%">
//           <tr>
//
//             <td bgcolor="#153e90" align="center" style="color: white;">
//
//               <img alt="BLuesky" src="https://xnkbluesky.com/sites/default/files/logo-xnkbluesky-5.png" width="400px" align="middle">
//
//               <h1> Chào mừng đến với HaiPhongLogistic </h1>
//
//             </td>
//         </table>
//         <table role="presentation" border="0" cellpadding="0" cellspacing="10px" style="padding: 30px 30px 30px 60px;" width="100%">
//               <tr>
//                 <td><h2> Nhận báo giá và tra cứu</h2>
//                 <p>
//                   Chào mừng bạn đến với HaiPhongLogistic.
//                 </p></td>
//               </tr>
//               <tr>
//                 <td><h3> Thông tin liên hệ</h3></td>
//               </tr>
//               <tr>
//                 <td><strong> Họ tên</strong>: ${name}</td>
//               </tr>
//               <tr>
//                 <td><strong> Tên công ty</strong>: ${company}</td>
//               </tr>
//               <tr>
//                 <td><strong> Số điện thoại</strong>: ${phone}</td>
//               </tr>
//               <tr>
//                 <td><strong> Email</strong>: ${email}</td>
//               </tr>
//           </table>
//           <div style="padding: 30px 30px 30px 60px;" width="100%">
//           ${table}
//
// </div>
//     </div>
// </body>
//
// </html>`,
//             },
//             success: function (data) {
//                 console.log('thành công');
//             },
//             error: function (data) {
//                 console.log(data);
//             },
//         });
                },
                error: function (e) {
                    console.log(e);
                }
            });

        }
    })

    $(document).on('click', '.js-booking-fcl', function (e) {
        const table = $(this).parentsUntil('.table-quote').parent();
        const name = table.prev().find('[name="name"]').val();
        const company = table.prev().find('[name="company"]').val();
        const phone = table.prev().find('[name="phone"]').val();
        const email = table.prev().find('[name="email"]').val();
        const name_product = table.prev().find('[name="name_product"]').val();
        const booking = $(this).parent().parent().html();
        const totalPrice = $(this).parent().parent().find('.total-price').text();
        const valCBM = $(this).parent().parent().find('.valCBM').text();
        const conts = $('.input-number');
        const typeConts = [];
        let tableAddTypeConts = "";
        var donGia = $(this).parent().parent().find('.don_gia').text().split('<br>');

        conts.map(function (index, value) {
            if ($(this).val() > 0) {
                tableAddTypeConts += "{{}}" + $(this).attr('name').trim() + "-" + $(this).val();
            }
        });
        sessionStorage.setItem('name', name);
        sessionStorage.setItem('company', company);
        sessionStorage.setItem('phone', phone);
        sessionStorage.setItem('email', email);
        sessionStorage.setItem('tuyen_hang_id', $(this).data('value'));
        sessionStorage.setItem('cbm', $(this).data('cbm'));
        sessionStorage.setItem('name_product', name_product);
        sessionStorage.setItem('totalPrice', totalPrice);
        sessionStorage.setItem('valCBM', valCBM);
        sessionStorage.setItem('typeConts', tableAddTypeConts);
    })

    if (sessionStorage.getItem('email')) {
        $('.js-form-booking [name="email"]').val(sessionStorage.getItem('email'));
    }
    if (sessionStorage.getItem('name')) {
        $('.js-form-booking [name="name"]').val(sessionStorage.getItem('name'));
    }
    if (sessionStorage.getItem('phone')) {
        $('.js-form-booking [name="phone"]').val(sessionStorage.getItem('phone'));
    }
    if (sessionStorage.getItem('company')) {
        $('.js-form-booking [name="company"]').val(sessionStorage.getItem('company'));
    }

    if (sessionStorage.getItem('tuyen_hang_id')) {
        var loaiCont = "";
        if (sessionStorage.getItem('typeConts')) {
            loaiCont = sessionStorage.getItem('typeConts');
        }
        $.ajax({
            type: "POST",
            url: "/get-tuyen-hang",
            data: {
                'tuyen_hang_id': sessionStorage.getItem('tuyen_hang_id'),
                'loai_cont': loaiCont,
            },
            dataType: 'json',
            success: function (data) {
                sessionStorage.setItem('cang_di', data.data.tuyen_hang.field_pol);
                sessionStorage.setItem('cang_den', data.data.tuyen_hang.field_pod);
                sessionStorage.setItem('run_time', data.data.tuyen_hang.field_transit_tim);
                sessionStorage.setItem('loai_hang', data.data.tuyen_hang.field_sectors);
                sessionStorage.setItem('lich_tau', data.data.tuyen_hang.field_cut_of_customs_etd);
                sessionStorage.setItem('thoi_gia_cho', data.data.tuyen_hang.field_pod_free_time);
                sessionStorage.setItem('bang_gia_chinh', JSON.stringify(data.data.bang_gia_chinh));
                if (loaiCont != "")
                    sessionStorage.setItem('bang_gia_cont', JSON.stringify(data.data.bang_gia_cont));
                sessionStorage.setItem('bang_gia_phat_sinh', JSON.stringify(data.data.bang_gia_phat_sinh));

                $('input[name="cang_di"]').val(data.data.tuyen_hang.field_pol);
                $('input[name="cang_den"]').val(data.data.tuyen_hang.field_pod);
                $('input[name="run_time"]').val(data.data.tuyen_hang.field_transit_tim);
                $('input[name="loai_hang"]').val(data.data.tuyen_hang.field_sectors);
                $('input[name="lich_tau"]').val(data.data.tuyen_hang.field_cut_of_customs_etd);
                $('input[name="thoi_gia_cho"]').val(data.data.tuyen_hang.field_pod_free_time);
                $('.table-quote-price').html(data.data.bang_gia_chinh);
                if (data.data.tuyen_hang.field_sectors == 'FCL') {
                    if (sessionStorage.getItem('typeConts')) {
                        $('.table-booking-cont tbody').html(data.data.bang_gia_cont);
                        $('.container').removeClass('hidden');
                    }
                }
                $('.table-booking-price tbody').html(`<td>${sessionStorage.getItem('valCBM')}</td><td>${sessionStorage.getItem('totalPrice')}</td>`)
            },
            error: function (e) {
                console.log(e);
            }
        });
    }

    // $(document).on('click','.js-submit-air', function (e) {
    //   e.preventDefault();
    //   const name = $(this).parentsUntil('.js-form-bao-gia').find('[name="name"]').val();
    //   const company = $(this).parentsUntil('.js-form-bao-gia').find('[name="company"]').val();
    //   const phone = $(this).parentsUntil('.js-form-bao-gia').find('[name="phone"]').val();
    //   const email = $(this).parentsUntil('.js-form-bao-gia').find('[name="email"]').val();
    //   const mass = $(this).parentsUntil('.js-form-bao-gia').find('[name="mass"]').val();
    //   const length = $(this).parentsUntil('.js-form-bao-gia').find('[name="length"]').val();
    //   const width = $(this).parentsUntil('.js-form-bao-gia').find('[name="width"]').val();
    //   const height = $(this).parentsUntil('.js-form-bao-gia').find('[name="height"]').val();
    //   let cbm = $(this).parentsUntil('.js-form-bao-gia').find('[name="cbm"]').val();
    //   const loaiCont = $(this).parentsUntil('.js-form-bao-gia').find('[name="loai_cont"]').val();
    //   const loaiHangId = $(this).data('value') * 1;
    //   if (cbm == ''){
    //     if (loaiHangId == 32){
    //       cbm = (length * width * height)/167;
    //       cbm = cbm.toFixed(2);
    //     }else {
    //       cbm = (length * width * height)/1000;
    //       cbm = cbm.toFixed(2);
    //     }
    //   }
    //   const tableFCL = $('.table-quote');
    //   let table = '';
    //   $.ajax({
    //     type: "POST",
    //     url: "https://app.xnkbluesky.com/index.php?r=service/get-loai-hang",
    //     data: {
    //       'loai_hang_id': loaiHangId,
    //       'loai_cont_id': loaiCont
    //     },
    //     dataType: 'json',
    //     success: function (data) {
    //       console.log(data);
    //       table = table + `<h5 class="mb-2 mt-5">Danh sách các tuyến hiện có</h5>
    //       <table class="table table-bordered table-white">
    //                         <thead>
    //                         <tr>
    //                           <th scope="col">Cảng đến</th>
    //                           <th scope="col">Cảng đi</th>
    //                           <th scope="col">Loại hàng</th>
    //                           <th scope="col">Giá</th>
    //                           <th scope="col">Lịch tàu</th>
    //                           <th scope="col">TG chạy</th>
    //                           <th scope="col">TG chờ</th>
    //                           <th scope="col"></th>
    //                         </tr>
    //                         </thead>
    //                         <tbody>`;
    //       $.each(data, function (index, value) {
    //         table = table + `<tr>
    //           <td>${value.tuyen_hang.cang_den}</td>
    //           <td>${value.tuyen_hang.cang_di}</td>
    //           <td>${value.tuyen_hang.loai_hang}</td>
    //           <td class="text-right">${value.bang_gia.don_gia} ${value.bang_gia.don_vi_tinh}</td>
    //           <td>${value.tuyen_hang.cut_of_customs_etd}</td>
    //           <td>${value.tuyen_hang.transit}</td>
    //           <td>${value.tuyen_hang.pod_free_time}</td>
    //           <td class="text-center"><a href="/booking" class="btn btn-primary js-booking-fcl" data-value="${value.tuyen_hang.id}" data-cbm="${cbm}">Booking</a></td>
    //           </tr>`
    //       });
    //       table = table + `</tbody>
    //                       </table>`;
    //       tableFCL.html(table);
    //     },
    //     error: function (e) {
    //       console.log(e);
    //     }
    //   });
    // })

    $(document).on('click', '.js-send-email', function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "/save-booking",
            data: {
                hoten: sessionStorage.getItem('name'),
                ten_cong_ty: sessionStorage.getItem('company'),
                dien_thoai: sessionStorage.getItem('phone'),
                email: sessionStorage.getItem('email'),
                tuyen_hang_id: sessionStorage.getItem('tuyen_hang_id'),
                ghi_chu: $('#form-booking [name="contact"]').val(),
                ten_hang: sessionStorage.getItem('name_product'),
            },
            dataType: 'json',
            success: function (data) {
                let bang_gia_chinh = JSON.parse(sessionStorage.getItem('bang_gia_chinh'));
                var bang_gia_cont = "";
                if (sessionStorage.getItem('bang_gia_cont'))
                    bang_gia_cont =`  <table role="presentation" border="0" cellpadding="0" cellspacing="10px" style="padding: 30px 30px 30px 60px;max-width: 768px" width="100%">
                            <tr>
                <td><h3> Bảng giá chính</h3></td>
              </tr>
              <tr>
                <th> Tên cước phí </th>
                <th> Loại </th>
                <th> Giá </th>
                <th> Đơn vị tính </th>
              </tr>
              <tbody>
               `+JSON.parse(sessionStorage.getItem('bang_gia_cont'))+`
</tbody>


          </table>`;
                $.ajax({
                    url: "https://app.happyhomehaiphong.com/index.php?r=service/send-mail",
                    dataTpe: "json",
                    type: "post",
                    data: {
                        from: "info@xnkbluesky.com",
                        to: sessionStorage.getItem('email'),
                        subject: "Nhận báo giá từ website",
                        name: "XNKBluesky",
                        content: `<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"   lang="en">

<head>
  <link rel="stylesheet" type="text/css" hs-webfonts="true" href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap">
  <title>Email báo giá</title>
  <meta property="og:title" content="Email template">

  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <style type="text/css">
    a {
      text-decoration: underline;
      color: inherit;
      font-weight: bold;
      color: #253342;
    }

    h1 {
      font-size: 56px;
    }

    h2 {
      font-size: 28px;
      font-weight: 900;
      margin-bottom: 0;
      margin-top: 0;
    }
    h3 {
      font-weight: 900;
      margin-bottom: 0;
      margin-top: 0;
    }

    p {
      font-weight: 400;
    }

    td {
      vertical-align: top;
    }
    th{
      text-align: left;
    }

    #email {
      margin: auto;
      width: 100%;
      background-color: white;

    }

    button {
      font: inherit;
      background-color: #FF7A59;
      border: none;
      padding: 10px;
      text-transform: uppercase;
      letter-spacing: 2px;
      font-weight: 900;
      color: white;
      border-radius: 5px;
      box-shadow: 3px 3px #d94c53;
    }

    .subtle-link {
      font-size: 9px;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: #CBD6E2;
    }

    #email-identity {
      color: #fff;
      background-color: #153e90;
      padding: 10px 15px;
      font: inherit;
      border: none;
      padding: 10px;
      text-transform: uppercase;
      letter-spacing: 2px;
      font-weight: 900;
      color: white;
      border-radius: 5px;
      box-shadow: 3px 3px #153e90;
      text-decoration: unset;
    }
  </style>

</head>

<body bgcolor="#F5F8FA" style="width: 100%; margin: auto 0; padding:0; font-family:Roboto, sans-serif; font-size:18px; color:#33475B; word-break:break-word">
    <div id="email">
        <table role="presentation" style="padding: 30px 30px 30px 60px;" width="100%">
          <tr>

            <td bgcolor="#153e90" align="center" style="color: white;">

              <img alt="BLuesky" src="https://xnkbluesky.com/sites/default/files/logo-xnkbluesky-5.png" width="400px" align="middle">

              <h1> Chào mừng đến với HaiPhongLogistic </h1>

            </td>
        </table>
        <table role="presentation" border="0" cellpadding="0" cellspacing="10px" style="padding: 30px 30px 30px 60px;" width="100%">
              <tr>
                <td><h2> Nhận báo giá và tra cứu</h2>
                <p>
                  Chào mừng bạn đến với HaiPhongLogistic.
                </p></td>
              </tr>
              <tr>
                <td><h3> Liên hệ và hỗ trợ</h3></td>
              </tr>
               <tr>
                <td><strong> Điện thoại</strong>: <a href="tel:02253688885">02253.688.885</a></td>
              </tr>
                <tr>
                <td><strong> Điện thoại dự phòng</strong>: <a href="tel:0814833340">0814.833.340</a></td>
              </tr>
              <tr>
                <td><strong> Email</strong>: <a href="mailto:info@xnkbluesky.com">info@xnkbluesky.com</a></td>
              </tr>
               <tr>
                <td><strong> Email dự phòng</strong>: <a href="mailto:dangtuan@xnkbluesky.com">dangtuan@xnkbluesky.com</a></td>
              </tr>
              <tr style="height: 30px">
                <td><strong> Địa chỉ</strong>: <a href="https://goo.gl/maps/7w7Dv4FgJ24WTabB9">Phòng 411, 282 Đà Nẵng, phường Vạn Mỹ, Quận Ngô Quyền, Hải Phòng</a><br></td>
             </tr>

              <tr>
                <td><h3> Thông tin khách hàng</h3></td>
              </tr>
              <tr>
                <td><strong> Họ tên</strong>: ${sessionStorage.getItem('name')}</td>
              </tr>
              <tr>
                <td><strong> Tên công ty</strong>: ${sessionStorage.getItem('company')}</td>
              </tr>
              <tr>
                <td><strong> Số điện thoại</strong>: ${sessionStorage.getItem('phone')}</td>
              </tr>
              <tr>
                <td><strong> Email</strong>: ${sessionStorage.getItem('email')}</td>
              </tr>
          </table>
          <table role="presentation" border="0" cellpadding="0" cellspacing="10px" style="padding: 30px 30px 30px 60px;" width="100%">
              <tr>
                <td><h3> Thông tin tuyến hàng</h3></td>
              </tr>
              <tr>
                <td><strong> Cảng đi</strong>: ${sessionStorage.getItem('cang_di')}</td>
              </tr>
              <tr>
                <td><strong> Cảng Đến</strong>: ${sessionStorage.getItem('cang_den')}</td>
              </tr>

              <tr>
                <td><strong> Thời Gian Chạy</strong>: ${sessionStorage.getItem('run_time')}</td>
              </tr>
              <tr>
                <td><strong> Loại Hàng</strong>: ${sessionStorage.getItem('loai_hang')}</td>
              </tr>
              <tr>
                <td><strong> Lịch tàu</strong>: ${sessionStorage.getItem('lich_tau')}</td>
              </tr>
              <tr>
                <td><strong> CBM</strong>: ${sessionStorage.getItem('valCBM')}</td>
              </tr>
              <tr>
                <td><strong> Tổng tiền</strong>: ${sessionStorage.getItem('totalPrice')}</td>
              </tr>
          </table>
           ${bang_gia_cont}

          <table role="presentation" border="0" cellpadding="0" cellspacing="10px" style="padding: 30px 30px 30px 60px;max-width: 768px" width="100%">
<tr>
                <td><h3> Thông tin tuyến hàng</h3></td>
              </tr>
${bang_gia_chinh}
          </table>

    </div>
</body>

</html>`,
                    },
                    success: function (data) {
                        console.log(data);
                        sessionStorage.clear();
                        window.location.href = 'https://www.xnkbluesky.com/cam-ban-da-gui-yeu-cau';
                    },
                    error: function (data) {
                        console.log(data);
                    },
                });

            },
            error: function (e) {
                console.log(e);
            }
        });
    })
    $(document).on('click', '.js-add-item-size', function (e) {
        e.preventDefault();
        $(this).parent().prev().after(`<div class="row item-size">
                              <div class="col-md-3">
                                <input class="form-control" type="text" name="mass" placeholder="Khối lượng" kl_vkbd_parsed="true">
                              </div>
                              <div class="col-md-3">
                                <input class="form-control" type="text" name="length" placeholder="Chiều dài(cm)" kl_vkbd_parsed="true">
                              </div>
                              <div class="col-md-3">
                                <input class="form-control" type="text" name="width" placeholder="Chiều rộng(cm)" kl_vkbd_parsed="true">
                              </div>
                              <div class="col-md-3">
                                <input class="form-control" type="text" name="height" placeholder="Chiều cao(cm)" kl_vkbd_parsed="true">
                              </div>
                            </div>`);
    })
    $(document).on('click', '.js-delete-item-size', function (e) {
        e.preventDefault();
        const ItemSize = $('.item-size');
        if (ItemSize.length > 1) {
            ItemSize[ItemSize.length - 1].remove();
        }
    })
    $('.input-number-increment').click(function () {
        var $input = $(this).parents('.input-number-group').find('.input-number');
        var val = parseInt($input.val(), 10);
        $input.val(val + 1);
    });

    $('.input-number-decrement').click(function () {
        var $input = $(this).parents('.input-number-group').find('.input-number');
        var val = parseInt($input.val(), 10);
        $input.val(val - 1 < 0 ? 0 : val - 1);
    })

    function matchCustom(params, data) {
        console.log(data);
        console.log(params);
        if ($.trim(params.term) === '') {
            return data;
        }

        if (typeof data.text === 'undefined') {
            return null;
        }

        if (data.text.indexOf(params.term) > -1) {
            var modifiedData = $.extend({}, data, true);
            modifiedData.text += ' (matched)';

            return modifiedData;
        }

        return null;
    }

    // $('#port-from').select2({
    //     minimumInputLength: 2,
    //     minimumResultsForSearch: 10,
    //     ajax: {
    //         url: 'https://shaiphonglogistics.andin.asia/index.php?r=new-api%2Fget-list-port',
    //         dataType: 'json',
    //         type: "GET",
    //         data: function (params) {
    //           return {
    //             search: params.term
    //           }
    //         },
    //         processResults: function (data) {
    //             console.log(data);
    //             if (data.success) {
    //                 return {
    //                     results: $.map(data.content, function (item) {
    //                         return {
    //                             text: item.text,
    //                             id: item.id
    //                         }
    //                     })
    //                 };
    //             } else {
    //                 return { results: [] };
    //             }
    //         }
    //     },
    // })

    // $('#port-to').select2({
    //     minimumInputLength: 3,
    //     minimumResultsForSearch: 10,
    //     ajax: {
    //         url: '/get-cang-den',
    //         dataType: 'json',
    //         type: "GET",
    //         data: function (params) {
    //             var queryParameters = {
    //                 cang_den: params.term,
    //             }
    //             return queryParameters;
    //         },
    //         processResults: function (data) {
    //             return {
    //                 results: $.map(data['data'], function (item) {
    //                     return {
    //                         text: item.cang_den,
    //                         id: item.id
    //                     }
    //                 })
    //             };
    //         }
    //     }
    // })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        let id = $(e.currentTarget).attr('href');
        const portFrom = $(e.currentTarget).parentsUntil('.nav.nav-tabs').parent().next().find(id).find('.port-from');
        const loaiHangId = portFrom.data('value');
        portFrom.select2();
        const portTo = $(e.currentTarget).parentsUntil('.nav.nav-tabs').parent().next().find(id).find('.port-to');
        portTo.select2();
    });
    $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
        let id = $(e.currentTarget).attr('href');
        const portFrom = $(e.currentTarget).parentsUntil('.nav.nav-tabs').parent().next().find(id).find('.port-from');
        const loaiHangId = portFrom.data('value');
        portFrom.select2();
        const portTo = $(e.currentTarget).parentsUntil('.nav.nav-tabs').parent().next().find(id).find('.port-to');
        portTo.select2();
    });
    $('#profile-tab').trigger('click');
    //set su kien cho form
    $(document).on('click', '.btn-edit', function (e) {
        var title_cp = $(this).parent().parent().find('.text-title').text()
        var field_gia = "";
        var field_don_vi_tinh = $(this).parent().parent().find('.field_don_vi_tinh').text()
        var nid = $(this).attr('data-value')
        $(this).parent().parent().find('td').hide();
        $(this).parent().parent().append(`
            <td  class="block-edit"><input placeholder="Tên cước phí" name="title_cp" value="` + title_cp + `" class="form-control"></td>
            <td class="block-edit"><input placeholder="Giá" value="` + field_gia + `" name="field_gia" class="form-control text-right numeral-mask"></td>
            <td class="block-edit"><input placeholder="Đơn vị tính" value="` + field_don_vi_tinh + `" name="field_don_vi_tinh" class="form-control"></td>
            <td style="vertical-align: inherit"  class="text-center block-edit"><a href="#" class="text-success btn-save-row" data-value="` + nid + `"><i class="fa fa-save"></i></a></td>
            <td style="vertical-align: inherit"   class="text-center block-edit"><a href="#" class="text-danger btn-back-row"><i class="fa-solid fa-rotate-right"></i></a></td>
        `)
        if ($(".numeral-mask").length) {
            $(".numeral-mask").each(function () {
                new Cleave(this, {
                    numeral: true,
                    numeralThousandsGroupStyle: 'thousand'
                });
            })
        }

    })
    $(document).on('click', '.btn-back-row', function (e) {
        $(this).parent().parent().find('td').show();
        $(this).parent().parent().find('.block-edit').remove()
    })
    $(document).on('click', '.btn-huy-modal-tuyen-hang', function (e) {
        $("#modal-tuyen-hang").modal('hide');
        $("#modal-xem-tuyen-hang").modal('hide');
    });

    //xem , sua , xoa tuyen hang
    $(document).on('click', '.btn-xem-tuyen-hang', function (e) {
        e.preventDefault();
        $.ajax({
            url: '/load-tuyen-hang',
            dataType: 'json',
            data: {
                token: $("#tokenbody").val(),
                id: $(this).attr('data-value'),
            },
            type: 'post',
            beforeSend: function () {
                blockPage();
            },
            success: function (data) {
                $("#modal-xem-tuyen-hang").modal('show');
                $("#title-modal-xem-tuyen-hang").text('Xem tuyến hàng');
                $.each(data, function (key, value) {
                    $("#modal-xem-tuyen-hang #" + key).html(value)
                })
            },
            complete: function () {
                unblockPage();
                // loadDate()
            },
            error: function (r1, r2) {
                // getToastError(r1);
            }
        })

    });

    function getDataColumn($value, $attr = '') {
        return {
            attr: $attr,
            value: $value
        }
    }

    function loadDataTable($table, $data, $column, $perPage = 1, $countPage = 0) {
        var $strRow = '';
        $.each($data, function (index, $item) {
            var $strCol = '<tr >';
            $.each($column, function (key, value) {
                if (value.attr != '') {
                    $strCol += `
        <td ` + value.attr + `>` + $item[value.value] + `</td> `
                } else {
                    $strCol += `
        <td>` + $item[value.value] + `</td> `
                }
            })
            $strCol += '</tr>'
            $strRow += $strCol;
        })
        if ($countPage > 1) {
            var $strPa = '<li class="page-item prev-item"><a class="page-link" data-value="1" href="#"></a></li>';
            var $startPage = parseInt($perPage) - 2 > 0 ? parseInt($perPage) - 2 : 1;
            var $endPage = parseInt($perPage) + 2 <= $countPage ? parseInt($perPage) + 2 : $countPage;

            for (var $i = $startPage; $i <= $endPage; $i++) {
                var pre = "";
                var next = "";
                var active = "";
                if ($i == 1) {
                    pre = "prev-item";
                }
                if ($i == $countPage) {
                    next = 'next-item';
                }
                if ($i == parseInt($perPage)) {
                    active = "active";
                }
                $strPa += '<li class="page-item  ' + active + '"><a class="page-link"  data-value="' + $i + '" href="#">' + $i + '</a></li>';
            }
            $strPa += '<li class="page-item  next-item"><a class="page-link" data-value="' + $countPage + '" href="#"></a></li>';
            $($table + " table tfoot .pagination").html($strPa);
        }


        $($table + " table tbody").html($strRow);
        $($table + " table tbody tr").slice(0, 5).show();
        $($table + " table tbody tr").attr("style", "");

    }

    $(document).on('click', '.btn-remove-cuoc-phi-tuyen-hang', function (e) {
        Swal.fire({
            title: 'Xác nhận xóa Cước phí',
            text: "Bạn có chắc chắn khi thực hiện thao tác này không !",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Xác nhận'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/remove-cuoc-phi',
                    dataType: 'json',
                    data: {
                        token: $("#tokenbody").val(),
                        id: $(this).attr('data-value'),
                    },
                    type: 'post',
                    beforeSend: function () {
                        blockPage();
                    },
                    success: function (data) {
                        if (data.success == true) {
                            $.ajax({
                                url: '/load-list-cuoc-phi',
                                dataType: 'json',
                                data: {
                                    token: $("#tokenbody").val(),
                                    id: $("#modal-xem-tuyen-hang #nid").text(),
                                },
                                type: 'post',
                                beforeSend: function () {
                                    blockPage();
                                },
                                success: function (data) {
                                    $("#list_cuoc_phi").html(data.data.body)
                                    $("#sumPrice").html(data.data.sum)

                                },
                                complete: function () {
                                    unblockPage();
                                    // loadDate()
                                },
                                error: function (r1, r2) {
                                    // getToastError(r1);
                                }
                            })
                            alertify.success(data.content)

                        } else {
                            alertify.error(data.content)
                        }
                    },
                    complete: function () {
                        unblockPage();
                        // loadDate()
                    },
                    error: function (r1, r2) {
                        // getToastError(r1);
                    }
                })
            }
        })
    })
    $(document).on('click', '.btn-save-row', function (e) {
        e.preventDefault();
        $.ajax({
            url: '/save-bang-gia-tuyen-hang',
            dataType: 'json',
            data: {
                token: $("#tokenbody").val(),
                nid: $("#modal-xem-tuyen-hang #nid").text(),
                nid_cuoc_phi: $(this).attr('data-value'),
                title_cp: $(this).parent().parent().find("input[name='title_cp']").val(),
                field_gia: $(this).parent().parent().find("input[name='field_gia']").val(),
                field_don_vi_tinh: $(this).parent().parent().find("input[name='field_don_vi_tinh']").val(),
            },
            type: 'post',
            beforeSend: function () {
                blockPage();
            },
            success: function (data) {
                if (data.success == true) {
                    $.ajax({
                        url: '/load-list-cuoc-phi',
                        dataType: 'json',
                        data: {
                            token: $("#tokenbody").val(),
                            id: $("#modal-xem-tuyen-hang #nid").text(),
                        },
                        type: 'post',
                        beforeSend: function () {
                            blockPage();
                        },
                        success: function (data) {
                            $("#list_cuoc_phi").html(data.data.body)
                            $("#sumPrice").html(data.data.sum)

                        },
                        complete: function () {
                            unblockPage();
                            // loadDate()
                        },
                        error: function (r1, r2) {
                            // getToastError(r1);
                        }
                    })
                    alertify.success(data.content)

                } else {
                    alertify.error(data.content)
                }

            },
            complete: function () {
                unblockPage();
                // loadDate()
            },
            error: function (r1, r2) {
                // getToastError(r1);
            }
        })
    })
    $(document).on('click', '.btn-remove-row', function (e) {
        e.preventDefault()
        $(this).parent().parent().remove()
    })
    $(document).on('click', '.btn-them-cuoc-phi', function (e) {
        var strRow = `<tr>
            <td><input placeholder="Tên cước phí" name="title_cp" class="form-control"></td>
            <td><input placeholder="Giá" name="field_gia" class="form-control text-right numeral-mask"></td>
            <td><input placeholder="Đơn vị tính" name="field_don_vi_tinh" class="form-control"></td>
            <td style="vertical-align: inherit"  class="text-center"><a href="#" class="text-success btn-save-row" data-value=""><i class="fa fa-save"></i></a></td>
            <td style="vertical-align: inherit"   class="text-center"><a href="#" class="text-danger btn-remove-row"><i class="fa fa-trash"></i></a></td>
        </tr>`
        $("#list_cuoc_phi").append(strRow)
        if ($(".numeral-mask").length) {
            $(".numeral-mask").each(function () {
                new Cleave(this, {
                    numeral: true,
                    numeralThousandsGroupStyle: 'thousand'
                });
            })
        }
    })
    $(document).on('click', '.btn-sua-tuyen-hang', function (e) {
        e.preventDefault();
        $.ajax({
            url: '/load-tuyen-hang',
            dataType: 'json',
            data: {
                token: $("#tokenbody").val(),
                id: $(this).attr('data-value'),
            },
            type: 'post',
            beforeSend: function () {
                blockPage();
            },
            success: function (data) {
                $("#modal-tuyen-hang").modal('show');
                $('#form-tuyen-hang')[0].reset();
                $("#title-modal-thanh-toan").text('Sửa tuyến hàng');
                $('.field-role .form-check').remove();
                $('.name').val(data.title);
                $('.name').attr('readonly', true);
                //set du lieu
                $('#nid').val(data.nid);
                $('#title').val(data.title);
                $('#field-pol').val(data.field_pol);
                $('#field-pod').val(data.field_pod);
                $('#field-sectors').val(data.field_sectors);
                $('#field-carrier').val(data.field_carrier);
                $('#field-20gp').val(data.field_20gp);
                $('#field-20rf').val(data.field_20rf);
                $('#field-40gp').val(data.field_40gp);
                $('#field-40hq').val(data.field_40hq);
                $('#field-40rf').val(data.field_40rf);
                $('#field-kg').val(data.field_kg);
                $('#field-cbm').val(data.field_cbm);
                $('#field-cut-of-customs-etd').val(data.field_cut_of_customs_etd);
                $('#field-transit-tim').val(data.field_transit_tim);
                $('#field-pod-free-time').val(data.field_pod_free_time);
                $('#field-mbl-type').val(data.field_mbl_type);
                $('#field-validity').val(data.field_validity);
                $('#field-pod-terminal').val(data.field_pod_terminal);
                //undisabled
                $('#field-pol').attr("disabled", false);
                $('#field-pod').attr("disabled", false);
                $('#field-sectors').attr("disabled", false);
                $('#field-carrier').attr("disabled", false);
                $('#field-20gp').attr("disabled", false);
                $('#field-20rf').attr("disabled", false);
                $('#field-40gp').attr("disabled", false);
                $('#field-40hq').attr("disabled", false);
                $('#field-40rf').attr("disabled", false);
                $('#field-kg').attr("disabled", false);
                $('#field-cbm').attr("disabled", false);
                $('#field-cut-of-customs-etd').attr("disabled", false);
                $('#field-transit-tim').attr("disabled", false);
                $('#field-pod-free-time').attr("disabled", false);
                $('#field-mbl-type').attr("disabled", false);
                $('#field-validity').attr("disabled", false);
                $('#field-pod-terminal').attr("disabled", false);
                $('.btn-save-tuyen-hang').removeClass("hidden");

            },
            complete: function () {
                unblockPage();
                // loadDate()
            },
            error: function (r1, r2) {
                // getToastError(r1);
            }
        })

    });
    $(document).on('click', '.btn-save-tuyen-hang', function (e) {
        e.preventDefault();
        $.ajax({
            url: '/save-tuyen-hang',
            dataType: 'json',
            data: $('#form-tuyen-hang').serializeArray(),
            type: 'post',
            beforeSend: function () {
                blockPage();
            },
            success: function (data) {
                alertify.success('Lưu thành công tuyến hàng');
                resetForm();
            },
            complete: function () {
                unblockPage();
                // loadDate()
            },
            error: function (r1, r2) {
                alertify.error(r1);
            }
        })

    });
    $(document).on('change', '.selectAll', function (e) {
        $(".block_remove form input").remove()
        $('.selectItem').prop('checked',$(this).prop('checked')).change()
        if ($(".block_remove form input").length>0){
            $(".views-field-nothing-1").html("<a class='text-danger btn-remove-all'><i class='fa fa-trash'></a>").addClass("text-center");
        }else {
            $(".views-field-nothing-1").html("DELETE").addClass("text-right");
        }

    })
    $(document).on('change', '.selectItem', function (e) {
        if ($(this).prop('checked')==true){
            $(".block_remove form").append(`<input name="ids[]" value="`+$(this).val()+`">`)
        }else
        {
            $(".block_remove form input[value='"+$(this).val()+"']").remove()
        }
        if ($(".block_remove form input").length>0){
            $(".views-field-nothing-1").html("<a class='text-danger btn-remove-all'><i class='fa fa-trash'></a>").addClass("text-center");
        }else {
            $(".views-field-nothing-1").html("DELETE").addClass("text-right");
        }
    })
    $(document).on('click', '.btn-remove-all', function (e) {
        var $data = $(".block_remove form").serializeArray();
        $data.push({name:"token",value:$(".tokenbody").val()})
        e.preventDefault();
        Swal.fire({
            title: 'Xác nhận xóa tuyến hàng',
            text: "Bạn có chắc chắn khi thực hiện thao tác này không !",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Xác nhận'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/xoa-nhieu-tuyen-hang',
                    data: $data,
                    dataType: 'json',
                    type: 'post',
                    beforeSend: function () {
                        blockPage();
                    },
                    success: function (data) {
                        alertify.success(data.content);
                        resetForm();
                    },
                    complete: function () {
                        unblockPage();
                    },
                    error: function (r1, r2) {
                        alertify.error(r1);
                    }
                });
            }
        })

    });
    $(document).on('click', '.btn-xoa-tuyen-hang', function (e) {
        e.preventDefault();
        Swal.fire({
            title: 'Xác nhận xóa tuyến hàng',
            text: "Bạn có chắc chắn khi thực hiện thao tác này không !",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Xác nhận'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/xoa-tuyen-hang',
                    data: {
                        token: $("#tokenbody").val(),
                        id: $(this).attr('data-value'),
                    },
                    dataType: 'json',
                    type: 'post',
                    beforeSend: function () {
                        blockPage();
                    },
                    success: function (data) {
                        alertify.success(data.content);
                        resetForm();
                    },
                    complete: function () {
                        unblockPage();
                    },
                    error: function (r1, r2) {
                        alertify.error(r1);
                    }
                });
            }
        })

    });

    //search tuyen hang
    $('#field-search-pod').select2({
        minimumInputLength: 2,
        minimumResultsForSearch: 10,
        ajax: {
            url: '/get-cang-di',
            dataType: 'json',
            type: "GET",
            data: function (params) {
                var queryParameters = {
                    cang_di: params.term,
                }
                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: $.map(data['data'], function (item) {
                        return {
                            text: item.cang_di,
                            id: item.id
                        }
                    })
                };
            }
        }
    })
    $('#field-search-pol').select2({
        minimumInputLength: 2,
        minimumResultsForSearch: 10,
        ajax: {
            url: '/get-cang-den',
            dataType: 'json',
            type: "GET",
            data: function (params) {
                var queryParameters = {
                    cang_den: params.term,
                }
                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: $.map(data['data'], function (item) {
                        return {
                            text: item.cang_den,
                            id: item.id
                        }
                    })
                };
            }
        }
    })
    $('#field-search-carrier').select2({
        minimumInputLength: 2,
        minimumResultsForSearch: 10,
        ajax: {
            url: '/get-carrier',
            dataType: 'json',
            type: "GET",
            data: function (params) {
                var queryParameters = {
                    carrier: params.term,
                }
                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: $.map(data['data'], function (item) {
                        return {
                            text: item.carrier,
                            id: item.id
                        }
                    })
                };
            }
        }
    })
    $(document).on('change', '#field-search-pod', function () {
        var str = getDataInSelector($(this).children('option:selected'));
        $('#edit-field-pol-value').val(str);
    })
    $(document).on('change', '#field-search-pol', function () {
        var str = getDataInSelector($(this).children('option:selected'));
        $('#edit-field-pod-value').val(str);
    })
    $(document).on('change', '#field-search-sectors', function () {
        $('#edit-field-sectors-value').val($(this).children('option:selected').val());
    })
    $(document).on('change', '#field-search-carrier', function () {
        var str = getDataInSelector($(this).children('option:selected'));
        $('#edit-field-carrier-value').val(str);
    })
    $(document).on('change', '#field-search-cuoc-hang', function () {
        //reset tat ca select
        $('#edit-field-loai-container-value').val($(this).val());
    })
    $('.btn-tim-kiem-tuyen-hang').click(function () {
        $('#edit-submit-danh-sach-noi-dung').click();
    });
    //fix loi giao dien remote select
    $('#field-search-pol ~ .select2.select2-container.select2-container--default')
        .css('z-index', 0);
    $('#field-search-pod ~ .select2.select2-container.select2-container--default')
        .css('z-index', 0);
    $('#field-search-carrier ~ .select2.select2-container.select2-container--default')
        .css('z-index', 0);
    //reset cac hop tim kiem
    $('#field-search-pol').change();
    $('#field-search-pod').change();
    $('#field-search-sectors').change();
    $('#field-search-carrier').change();
    $('#field-search-cuoc-hang').change();
    $('.port-from').each(function (index, element){
        $(element).select2().trigger('change');
    });
    $('.port-to').each(function (index, element){
        $(element).select2().trigger('change');
    });
})

