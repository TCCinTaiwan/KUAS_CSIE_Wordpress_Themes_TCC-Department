jQuery(document).ready(function($) {
    $(document).on('click', '.wp-pagenavi a, .tags a', function(e) {
        e.preventDefault();
        $.ajax({
            type: "GET",
            url: $(this).attr('href'),
            beforeSend: function() {
                $('.loading').removeClass('hide');
            },
            dataType: "html",
            success: function(out) {
                history.pushState(null, out.title, this.url);
                $('.lang-item').html($(out).find('.lang-item > *')); //多語言
                $('title').html(out.match(/<title>(.*?)<\/title>/)[1]); //換網頁標題
                if($(".tablesorter").length != 0) { //判斷是否同樣是首頁
                    $('.tablesorter').html( $(out).find('.tablesorter > tbody'));
                    $('.wp-pagenavi').remove();
                    $('.tablesorter').after($(out).find('.wp-pagenavi'));
                    $('.tags').html($(out).find('.tags > ul'));
                } else {
                    $('#content').html($(out).find('#content > *'));
                    $('title').html(out.match(/<title>(.*?)<\/title>/)[1]);
                    $('.flexslider').flexslider({
                        animation: "slide"
                    });//圖片牆啟動
                }
                // $('.loading').html('');
                $('.loading').addClass('hide');
            }
        });
    });
    $(document).on('click', '#navigation a', function(e) {
        if (e['target'].target != '') return;
        e.preventDefault();
        $.ajax({
            type: "GET",
            url: $(this).attr('href'),
            beforeSend: function() {
                $('.loading').removeClass('hide');
            },
            dataType: "html",
            success: function(out) {
                history.pushState(null, out.title, this.url);
                $('#content').html($(out).find('#content > *'));
                $('#wp-toolbar').html($(out).find('#wp-toolbar > *')); //標題列
                $('.lang-item').html($(out).find('.lang-item > *')); //多語言
                $('title').html(out.match(/<title>(.*?)<\/title>/)[1]); //換網頁標題

                $('.flexslider').flexslider({
                    animation: "slide"
                });//圖片牆啟動
                $('.loading').addClass('hide');
            }
        });
    });
    $(window).on("popstate", function(e) {
        // $('title').html(e.state.title);
        $('.loading').removeClass('hide');
        $('title').html(httpGet(location.href).match(/<title>(.*?)<\/title>/)[1]); //換網頁標題
        $("#content").load(location.href + " #content>*", function() {
            $('.flexslider').flexslider({
                animation: "slide"
            });//圖片牆啟動
            $('.loading').addClass('hide');
        });
        
        
        // e.preventDefault();
    });

    function httpGet(theUrl)
    {
        var xmlHttp = new XMLHttpRequest();
        xmlHttp.open( "GET", theUrl, false );
        xmlHttp.send( null );
        return xmlHttp.responseText;
    }
});
