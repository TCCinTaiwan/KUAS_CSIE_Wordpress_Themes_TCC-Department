jQuery(document).ready(function($) {
    $(document).on('click', '.wp-pagenavi a, .sidebar a', function(e) {
        e.preventDefault();
        $.ajax({
            type: "GET",
            url: $(this).attr('href'),
            beforeSend: function() {
                $('.loading').html('<img src="/ajax-loader.gif" class="loading"></img>');
            },
            dataType: "html",
            success: function(out) {
                result = $(out).find('.tablesorter > tbody');
                $('.tablesorter').html(result);

                belownav = $(out).find('.wp-pagenavi');
                $('.wp-pagenavi').remove();
                $('.tablesorter').after(belownav);

                $('.loading').html('');
            }
        });
    });
    $(document).on('click', '#navigation a', function(e) {
        if (e['target'].target == '') {
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: $(this).attr('href'),
                beforeSend: function() {
                    $('.loading').html('<img src="/ajax-loader.gif" class="loading"></img>');
                },
                dataType: "html",
                success: function(out) {
                    result = $(out).find('.content > *');
                    $('.content').html(result);


                    $('.flexslider').flexslider({
                        animation: "slide"
                    });//圖片牆啟動
                }
            });
        }
    });

});
