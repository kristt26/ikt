var ChartColor = ["#5D62B4", "#54C3BE", "#EF726F", "#F9C446", "rgb(93.0, 98.0, 180.0)", "#21B7EC", "#04BCCC"];
var primaryColor = getComputedStyle(document.body).getPropertyValue('--primary');
var secondaryColor = getComputedStyle(document.body).getPropertyValue('--secondary');
var successColor = getComputedStyle(document.body).getPropertyValue('--success');
var warningColor = getComputedStyle(document.body).getPropertyValue('--warning');
var dangerColor = getComputedStyle(document.body).getPropertyValue('--danger');
var infoColor = getComputedStyle(document.body).getPropertyValue('--info');
var darkColor = getComputedStyle(document.body).getPropertyValue('--dark');
var lightColor = getComputedStyle(document.body).getPropertyValue('--light');

(function ($) {
  'use strict';
  $(function () {
    var body = $('body');
    var contentWrapper = $('.content-wrapper');
    var scroller = $('.container-scroller');
    var footer = $('.footer');
    var sidebar = $('.sidebar');

    //Add active class to nav-link based on url dynamically
    //Active class can be hard coded directly in html file also as required

    function addActiveClass(element) {
      if (current === "") {
        //for root url
        if (element.attr('href').indexOf("index.html") !== -1) {
          element.parents('.nav-item').last().addClass('active');
          if (element.parents('.sub-menu').length) {
            element.closest('.collapse').addClass('show');
            element.addClass('active');
          }
        }
      } else {
        //for other url
        if (element.attr('href').indexOf(current) !== -1) {
          element.parents('.nav-item').last().addClass('active');
          if (element.parents('.sub-menu').length) {
            element.closest('.collapse').addClass('show');
            element.addClass('active');
          }
          if (element.parents('.submenu-item').length) {
            element.addClass('active');
          }
        }
      }
    }

    var current = location.pathname.split("/").slice(-1)[0].replace(/^\/|\/$/g, '');
    $('.nav li a', sidebar).each(function () {
      var $this = $(this);
      addActiveClass($this);
    })

    $('.horizontal-menu .nav li a').each(function () {
      var $this = $(this);
      addActiveClass($this);
    })

    //Close other submenu in sidebar on opening any

    sidebar.on('show.bs.collapse', '.collapse', function () {
      sidebar.find('.collapse.show').collapse('hide');
    });


    //Change sidebar and content-wrapper height
    applyStyles();

    function applyStyles() {
      //Applying perfect scrollbar
      if (!body.hasClass("rtl")) {
        if (body.hasClass("sidebar-fixed")) {
          var fixedSidebarScroll = new PerfectScrollbar('#sidebar .nav');
        }
      }
    }

    $('[data-toggle="minimize"]').on("click", function () {
      if ((body.hasClass('sidebar-toggle-display')) || (body.hasClass('sidebar-absolute'))) {
        body.toggleClass('sidebar-hidden');
      } else {
        body.toggleClass('sidebar-icon-only');
      }
    });

    //checkbox and radios
    $(".form-check label,.form-radio label").append('<i class="input-helper"></i>');

    //fullscreen
    $("#fullscreen-button").on("click", function toggleFullScreen() {
      if ((document.fullScreenElement !== undefined && document.fullScreenElement === null) || (document.msFullscreenElement !== undefined && document.msFullscreenElement === null) || (document.mozFullScreen !== undefined && !document.mozFullScreen) || (document.webkitIsFullScreen !== undefined && !document.webkitIsFullScreen)) {
        if (document.documentElement.requestFullScreen) {
          document.documentElement.requestFullScreen();
        } else if (document.documentElement.mozRequestFullScreen) {
          document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullScreen) {
          document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
        } else if (document.documentElement.msRequestFullscreen) {
          document.documentElement.msRequestFullscreen();
        }
      } else {
        if (document.cancelFullScreen) {
          document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
          document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
          document.webkitCancelFullScreen();
        } else if (document.msExitFullscreen) {
          document.msExitFullscreen();
        }
      }
    })
    function random_item(items) {
      return items[Math.floor(Math.random() * items.length)];
    }
    // setInterval(() => {
    //   if (document.querySelector('.proBanner')) {
    //     let html = [
    //       '<a href="https://stimiksepnop.ac.id" target="_blank"><img src="https://dsm01pap002files.storage.live.com/y4m4u07x4HoQ2Razzbx7yUQhnJAntQCf3QDxFYKvvQLspJqwOArIxVrJZ7DQnVNz1WVpkgssORGRvb_ZuMamIZI_DpcCFoDeS-hPZ6u0dPhVadNTs4YKIMvk7ajJ1Xsw0JowUfoWvhyYAkCsPG5zjtTP7mYqgQFlPEtX5GNsTEdNst-RxQtob38iAL854TwdEP6?width=900&height=200&cropmode=none" height="110px;" alt=""></a>',
    //       '<a href="https://php.id/ref/31827" target="_blank"><img src="http://localhost:8080/temp/assets/images/banner/980x120.png" height="110px;"></a>'
    //     ];
    //     let item = random_item(html);
    //     $("#img").replaceWith(item);
    //   }
    // }, 3000);
    // setTimeout(() => {
    //   if ($.cookie('purple-free-banner') != "true") {
    //     let html = '<div class="col-md-12 p-0 m-0">' +
    //       '<div class="card-body card-body-padding d-flex align-items-center justify-content-between">' +
    //       '<div class="ps-lg-1">' +
    //       '<div class="d-flex align-items-center justify-content-between" id="img">' +
    //       '<a href="https://stimiksepnop.ac.id" target="_blank"><img src="https://dsm01pap002files.storage.live.com/y4m4u07x4HoQ2Razzbx7yUQhnJAntQCf3QDxFYKvvQLspJqwOArIxVrJZ7DQnVNz1WVpkgssORGRvb_ZuMamIZI_DpcCFoDeS-hPZ6u0dPhVadNTs4YKIMvk7ajJ1Xsw0JowUfoWvhyYAkCsPG5zjtTP7mYqgQFlPEtX5GNsTEdNst-RxQtob38iAL854TwdEP6?width=900&height=200&cropmode=none" height="110px;" alt=""></a>' +
    //       '</div>' +
    //       '</div>' +
    //       '<div class="d-flex align-items-center justify-content-between">' +
    //       '<a href="https://stimiksepnop.ac.id/"><i class="mdi mdi-home mr-3 text-black"></i></a>' +
    //       '<button id="bannerClose" class="btn border-0 p-0">' +
    //       '<i class="mdi mdi-close text-black mr-0"></i>' +
    //       '</button>' +
    //       '</div>' +
    //       '</div>' +
    //       '</div>';
    //     $("#proBanner").append(html);
    //     document.querySelector('#proBanner').classList.add('d-flex');
    //     document.querySelector('#proBanner').classList.add('proBanner');
    //     document.querySelector('.navbar').classList.remove('fixed-top');
    //     document.querySelector('.navbar').classList.add('pt-6');

    //   }
    //   else {
    //     document.querySelector('#proBanner').classList.add('d-none');
    //     document.querySelector('.navbar').classList.add('fixed-top');
    //     document.querySelector('#proBanner').classList.remove('proBanner');
    //   }

    //   if ($(".navbar").hasClass("fixed-top")) {
    //     document.querySelector('.page-body-wrapper').classList.remove('pt-0');
    //     document.querySelector('.navbar').classList.remove('pt-6');
    //   }
    //   else {
    //     document.querySelector('.page-body-wrapper').classList.add('pt-0');
    //     document.querySelector('.navbar').classList.add('pt-6');
    //     document.querySelector('.navbar').classList.add('mt-3');

    //   }
    //   if (document.querySelector('#bannerClose')) {
    //     document.querySelector('#bannerClose').addEventListener('click', function () {
    //       document.querySelector('#proBanner').classList.add('d-none');
    //       document.querySelector('#proBanner').classList.remove('d-flex');
    //       document.querySelector('#proBanner').classList.remove('proBanner');
    //       document.querySelector('.navbar').classList.remove('pt-6');
    //       document.querySelector('.navbar').classList.add('fixed-top');
    //       document.querySelector('.page-body-wrapper').classList.add('proBanner-padding-top');
    //       document.querySelector('.navbar').classList.remove('mt-3');
    //       var date = new Date();
    //       date.setTime(date.getTime() + 24 * 60 * 60 * 1000);
    //       $.cookie('purple-free-banner', "true", { expires: date });
    //     });
    //   }
    // }, 2000);
  });
})(jQuery);