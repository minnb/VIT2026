/**
 * VIT UI — khởi tạo slider sản phẩm theo class thay vì theo id.
 *
 * Lý do: main.js của theme chỉ khởi tạo owlCarousel cho một danh sách id cố định
 * (#jtv-best-sale-slider, #computer-slider...). Các khối danh mục ở trang chủ
 * được render trong @foreach nên không thể dùng id (trùng lặp, HTML không hợp lệ)
 * — hệ quả là chúng không được khởi tạo và các thẻ sản phẩm xếp chồng full width.
 *
 * File này quét mọi phần tử `.js-product-slider` và khởi tạo một lần duy nhất.
 * Yêu cầu: jQuery + owl.carousel.min.js (v1.3.1) đã nạp trước.
 */
(function ($) {
    'use strict';

    if (!$ || !$.fn) {
        return; // khong co jQuery: thoat em, CSS fallback van giu layout dung
    }

    var hasOwl = typeof $.fn.owlCarousel === 'function';

    var OWL_OPTIONS = {
        items: 4,                    // >1000px
        itemsDesktop: [1024, 4],
        itemsDesktopSmall: [900, 3],
        itemsTablet: [640, 2],
        itemsMobile: [480, 1],
        navigation: true,
        navigationText: ['<a class="flex-prev"></a>', '<a class="flex-next"></a>'],
        slideSpeed: 500,
        pagination: false,
        autoPlay: false              // danh mục sản phẩm: để người dùng chủ động
    };

    /**
     * Gan class .is-stuck cho <nav> khi trang da cuon qua khoi header,
     * de CSS thu gon nav va hien logo mini + nut goi nhanh.
     */
    function initStickyNav() {
        var $nav = $('nav.vit-nav').first();
        if (!$nav.length) {
            return;
        }

        var $win = $(window);
        var $header = $('header').first();
        var threshold = 0;
        var ticking = false;

        /**
         * Nguong cuon = day cua <header>. Phai do tu <header> chu KHONG do tu
         * chinh <nav>: khi nav dang dinh top thi .offset().top cua no bang
         * scrollTop, nen neu trang duoc tai trong luc da cuon san (trinh duyet
         * khoi phuc vi tri cu, hoac vao bang anchor) thi nguong se sai vinh vien.
         */
        function measure() {
            threshold = $header.length ? $header.offset().top + $header.outerHeight() : 0;
        }

        function update() {
            ticking = false;

            // Kiem tra moi lan chu khong chi luc tai trang: nguoi dung co the
            // xoay man hinh / doi kich thuoc cua so, khi do CSS chuyen nav
            // giua static (mobile) va sticky (desktop).
            if ($nav.css('position') !== 'sticky') {
                $nav.removeClass('is-stuck');
                return;
            }

            var stuck = $win.scrollTop() > threshold;
            if (stuck !== $nav.hasClass('is-stuck')) {
                $nav.toggleClass('is-stuck', stuck);
                // Truyen trang thai de ben nghe biet la VAO hay THOAT thu gon
                $win.trigger('vit:stuck', [stuck]);
            }
        }

        function schedule() {
            if (!ticking) {
                ticking = true;
                window.requestAnimationFrame ? window.requestAnimationFrame(update) : update();
            }
        }

        $win.on('scroll.vitNav', schedule);
        $win.on('resize.vitNav', function () {
            measure();
            schedule();
        });

        // Do lai sau khi anh tai xong vi chieu cao header co the thay doi
        $win.on('load.vitNav', function () {
            measure();
            schedule();
        });

        measure();
        update();
    }

    /**
     * Mo/dong menu danh muc bang class .is-open tren .navleft-container.
     * Mac dinh LUON dong (ke ca trang chu) de khong che banner slider;
     * chi mo khi nguoi dung bam vao o "Danh muc".
     * Khong dung slideDown/slideUp: jQuery ghi inline style, ma inline style
     * thua !important cua CSS nen menu se ket mo vinh vien.
     */
    function initMegaMenuToggle() {
        var $container = $('.navleft-container');
        if (!$container.length) {
            return;
        }
        var $title = $container.find('.mega-menu-title');

        function isOpen() {
            return $container.hasClass('is-open');
        }

        function syncAria() {
            $title.attr('aria-expanded', isOpen() ? 'true' : 'false');
        }

        function setOpen(open) {
            $container.toggleClass('is-open', open);
            syncAria();
        }

        function toggle(e) {
            e.preventDefault();
            e.stopPropagation();
            setOpen(!isOpen());
        }

        $title.on('click', toggle);
        $title.on('keydown', function (e) {
            if (e.which === 13 || e.which === 32) {   // Enter / Space
                toggle(e);
            }
        });

        $(document).on('click.vitMenu', function (e) {
            if (!$(e.target).closest('.navleft-container').length && isOpen()) {
                setOpen(false);
            }
        });
        $(document).on('keydown.vitMenu', function (e) {
            if (e.which === 27 && isOpen()) {         // Esc
                setOpen(false);
            }
        });

        // Cuon xuong qua nguong (nav thu gon): dong menu de no khong che noi
        // dung dang doc. Cuon nguoc len dau trang thi KHONG dong.
        $(window).on('vit:stuck', function (e, stuck) {
            if (stuck && isOpen()) {
                setOpen(false);
            }
        });

        syncAria();
    }

    /**
     * Card tai lieu o trang chu tu doi qua cac tai lieu khac nhau.
     *
     * Khong dung owlCarousel: owl do va gan chieu cao co dinh cho khung, se
     * pha chieu cao 100% ma card can de bang cot san pham ben canh. O day chi
     * doi class .is-active, CSS lo phan mo dan.
     */
    function initDocRotator() {
        $('.js-doc-rotator').each(function () {
            var $card = $(this);
            var $slides = $card.find('.vit-doc-cta__slide');
            var $dots = $card.find('.vit-doc-cta__dot');

            if ($slides.length < 2) {
                return;
            }

            var interval = parseInt($card.data('interval'), 10) || 5000;
            var current = 0;
            var timer = null;

            // He dieu hanh dat "giam chuyen dong": khong tu quay, nguoi dung
            // van bam dot de doi tai lieu. Kiem tra ngay tu dau vi start() con
            // duoc goi lai tu su kien mouseleave / focusout ben duoi.
            var media = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)');
            var autoPlay = !(media && media.matches);

            function show(index) {
                current = (index + $slides.length) % $slides.length;

                $slides.removeClass('is-active').attr('aria-hidden', 'true')
                    .eq(current).addClass('is-active').attr('aria-hidden', 'false');
                $dots.removeClass('is-active').eq(current).addClass('is-active');
            }

            function start() {
                stop();
                if (!autoPlay) {
                    return;
                }
                timer = window.setInterval(function () {
                    show(current + 1);
                }, interval);
            }

            function stop() {
                if (timer) {
                    window.clearInterval(timer);
                    timer = null;
                }
            }

            $dots.on('click', function () {
                show(parseInt($(this).data('index'), 10) || 0);
                start();                       // dem lai tu dau sau khi nguoi dung chon
            });

            // Dung khi nguoi dung dang doc / dang thao tac ban phim trong card
            $card.on('mouseenter focusin', stop);
            $card.on('mouseleave focusout', start);

            // Tab an sau nen: khong quay vong vo ich
            $(document).on('visibilitychange.vitDoc', function () {
                document.hidden ? stop() : start();
            });

            start();
        });
    }

    $(function () {
        initStickyNav();
        initDocRotator();
        initMegaMenuToggle();

        if (!hasOwl) {
            return; // thieu owl.carousel: CSS luoi du phong van hien thi dung
        }

        // Hero Slider o trang chu
        $('.vit-hero-slider').each(function () {
            var $slider = $(this);
            if ($slider.hasClass('owl-carousel') && $slider.data('owlCarousel')) {
                return;
            }
            $slider.owlCarousel({
                singleItem: true,
                items: 1,
                itemsDesktop: false,
                itemsDesktopSmall: false,
                itemsTablet: false,
                itemsMobile: false,
                navigation: true,
                navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                pagination: true,
                slideSpeed: 600,
                paginationSpeed: 600,
                autoPlay: 5000,
                stopOnHover: true
            });
        });

        // Product sliders o trang chu va cac trang danh muc
        $('.js-product-slider').each(function () {
            var $items = $(this).children('.slider-items');

            // Bỏ qua nếu rỗng hoặc đã được khởi tạo (tránh khởi tạo hai lần)
            if (!$items.length || $items.hasClass('owl-carousel') || $items.children().length === 0) {
                return;
            }

            $items.addClass('vit-slider-ready').owlCarousel(OWL_OPTIONS);
        });
    });
}(window.jQuery));
