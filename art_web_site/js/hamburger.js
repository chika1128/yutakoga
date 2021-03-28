//スマホ用ハンバーガーメニュー
$(function () {
    if (window.matchMedia('(max-width: 900px)').matches) {
        $('.Toggle').click(function () {
            $(this).toggleClass('opened');
            $('nav').toggleClass('opened');
        });
        //メニュークリック後イベント時にもう１度Toggleクリック（メニューを閉じる）
        $('nav a[href]').on('click', function (event) {
            $('.Toggle').trigger('click');
        });
    };
});