<?
/* 顯示公告 */
function tcc_message_table() {
    global $cat, $tag, $post;
    echo '<div class="MessageTable"><h2>' . __('News', 'tcc') . '</h2>';
    /* 公告類型選單 */
    echo '<div class="tags"><ul class="nav nav-pills"><li' . (($tag == '') ? ' class="active"' : '') . '><a href="' . home_url('/') . '">' . __('All', 'tcc') . '</a></li>';
    $meta_query = array('relation' => 'OR', array('key' => '_expiration', 'coompare' => '==', 'value' => ''), array('key' => '_expiration', 'value' => date("Y/m/d H:i:s"), 'compare' => '>=', 'type' => 'DATETIME'), array('key' => '_expiration', 'compare' => 'NOT EXISTS'));
    $tags = get_tags(array('orderby' => 'count', 'order' => 'DESC'));
    
    foreach ($tags as $tag_value) {
        $posts = query_posts(array(
            'showposts' => 999999999,
            'paged' => $current,
            'meta_query' => $meta_query,
            'tag' => $tag_value->slug,
            'orderby' => 'date',
            'order' => 'DESC'
        ));
        if (count($posts)) echo '<li' . (($tag == $tag_value->slug) ? ' class="active"' : '') . '><a href="' . get_tag_link($tag_value->term_id) . '">' . $tag_value->name . '<span class="badge">' . count($posts) . '</span></a></li>';
        wp_reset_query();
    }
    echo '</ul></div>';

    echo '<table class="tablesorter">';
    # echo '<thead><tr><th>' . __('Title','tcc') . '</th><th>' . __('Date','tcc') . '</th><th>' . __('Type','tcc') . '</th></tr> </thead>';
    echo '<tbody>';
    if (have_posts()) :
        if (!$current = get_query_var('paged')) {
            $current = 1;
        }
        $meta_query = array('relation' => 'OR', array('key' => '_expiration', 'coompare' => '==', 'value' => ''), array('key' => '_expiration', 'value' => date("Y/m/d H:i:s"), 'compare' => '>=', 'type' => 'DATETIME'), array('key' => '_expiration', 'compare' => 'NOT EXISTS'));
        if (is_category()) {
            query_posts(array(
                'paged' => $current,
                'meta_query' => $meta_query, 
                'cat' => $cat,
                'orderby' => 'date',
                'order' => 'DESC'
            ));
        } else if (is_tag()) {
            query_posts(array(
                'paged' => $current,
                'meta_query' => $meta_query,
                'tag' => $tag,
                'orderby' => 'date',
                'order' => 'DESC'
            ));
        } else {
            query_posts(array(
                'paged' => $current,
                'meta_query' => $meta_query,
                'orderby' => 'date',
                'order' => 'DESC'
            ));
        }
        while (have_posts()):
            the_post();
            echo '<tr><td>';
            tcc_flags();
            tcc_time_flags($post->ID);
            echo '<a href="' . get_post_permalink() . '">'. get_the_title($post->ID) . '</a>';
            tcc_attachments2($post->ID);
            echo '</td><td><a title="' . get_post_time(__('Y/m/d H:i:s','tcc')). '">' . get_post_time(__('Y/m/d','tcc')) . '</a></td><td>';
            the_tags('', ',','');
            echo '</td></tr>';
        endwhile;
    endif;
    echo '</tbody></table>';
    tcc_pagenavi();
    echo '</div>';
}
function tcc_flags() { //判斷緊急、重要標籤
    foreach (get_the_category() as $post_category) {
        if ($post_category->category_nicename == 'primary' || $post_category->category_nicename == 'primary_en')
            echo "<span class='label label-primary'>" . $post_category->cat_name . "</span>";
        elseif ($post_category->category_nicename == 'emergency' || $post_category->category_nicename == 'emergency_en')
            echo "<span class='label label-danger'>" . $post_category->cat_name . "</span>";
    }
}
function tcc_time_flags($post_id = 0) { //判斷時間軸
    $t1 = date("Y-m-d H:i:s",mktime(date("H"), date("i"), date("s"), date("m"), date("d") - 7, date("Y"))); // 7天內新訊息
    $t2 = get_post_time('Y-m-d H:i:s');
    if ($t1 < $t2) {
        echo "<span class='glyphicon glyphicon-ok-sign aria-hidden='true' title='" . __('New', 'tcc') . "' style='color:green;'></span>";
    }
    if (get_post_meta($post_id, '_expiration', true) != '') {
        $t1 = date("Y-m-d H:i:s",mktime(date("H"), date("i"), date("s"), date("m"), date("d") + 7, date("Y"))); // 7天內到期
        $t2 = date_format(date_create(get_post_meta($post_id, '_expiration', true)), 'Y-m-d H:i:s');
        if ($t1 > $t2) {
            echo "<span class='glyphicon glyphicon-time' aria-hidden='true' title='" . __('Upcoming', 'tcc') . "' style='color:red;'></span>";
        }
    }
}

function tcc_attachments($post_id = 0)
{
    $attachments = get_posts(array(
        'post_type' => 'attachment',
        'posts_per_page' => -1,
        'post_parent' => $post_id
    ));
    if ($attachments) {
        echo '<div id="attachments"><h2>' . __('Attachments', 'tcc') . '</h2>';
        foreach ($attachments as $attachment) {
            # var_dump($attachment);
            $filetype = file_icon($attachment->post_mime_type);
            echo '<a href="' . wp_get_attachment_url($attachment->ID) . '" title="' . $attachment->post_title . '(' . format_bytes(filesize(get_attached_file($attachment->ID))) . ')"><i class="filetype ' . $filetype . '"></i> <div>' . $attachment->post_title . '(' . format_bytes(filesize(get_attached_file($attachment->ID))) . ')</div></a>';
        }
        echo '</div>';
    }
}

function tcc_attachments2($post_id = 0)
{
    $attachments = get_posts(array(
        'post_type' => 'attachment',
        'posts_per_page' => -1,
        'post_parent' => $post_id
    ));
    if ($attachments) {
        foreach ($attachments as $attachment) {
            $filetype = file_icon($attachment->post_mime_type);
            echo '<a href="' . wp_get_attachment_url($attachment->ID) . '" title="' . $attachment->post_title . '(' . format_bytes(filesize(get_attached_file($attachment->ID))) . ')"><i class="filetype_16 i-' . $filetype . '"></i></a>';
        }
    }
}
function file_icon($type = '')
{
    switch ($type) {
        case 'text/plain'://純文字
            return 'txt';
        case 'text/html'://HTML文檔
            return 'html';
        case 'application/xhtml+xml'://XHTML文檔
            return 'xml';
        case 'image/gif'://GIF圖像
            return 'gif';
        case 'image/jpeg'://JPEG圖像
        case 'image/pjpeg'://JPEG圖像(image/jpeg)
            return 'jpeg';
        case 'image/png'://PNG圖像
        case 'image/x-png'://PNG圖像(image/png)
            return 'png';
        case 'video/mpeg'://MPEG動畫
            return 'mpeg';
        case 'application/octet-stream'://任意的二進位數據
            return 'bin';
        case 'application/pdf'://PDF文檔
            return 'pdf';
        case 'application/msword'://Microsoft Word文件
            return 'doc';
        case 'application/vnd.wap.xhtml+xml'://wap1.0+
            return 'file-o';
        case 'application/xhtml+xml'://wap2.0+
            return 'file-o';
        case 'message/rfc822'://RFC 822形式
            return 'file-o';
        case 'multipart/alternative'://HTML郵件的HTML形式和純文本形式，相同內容使用不同形式表示
            return 'file-o';
        case 'application/x-www-form-urlencoded'://使用HTTP的POST方法提交的表單
            return 'file-o';
        case 'multipart/form-data'://同上，但主要用於表單提交時伴隨文件上傳的場合
            return 'file-o';
        default:
            return 'file-o';
    }
}
/* 頁數顯示 */
function tcc_pagenavi() {
    global $wp_query;
    $max = $wp_query->max_num_pages;
    if (!$current = get_query_var('paged'))
        $current = 1;
    $args['base'] = str_replace(999999999, '%#%', get_pagenum_link(999999999));
    $args['total'] = $max;
    $args['current'] = $current;
    $args['prev_text'] = '<';
    $args['next_text'] = '>';
    if ($max > 1) {
        echo '<div class="wp-pagenavi"><span class="pages">共 ' . $max . ' 頁</span>' . paginate_links($args) . '</div>';
    }
}

/* 頁數顯示 */
// function wp_pagenavi() {
//     global $wp_query;
//     $max = $wp_query->max_num_pages;
//     if ( !$current = get_query_var('paged') )
//         $current = 1;
//     $args['base'] = str_replace(999999999, '%#%', get_pagenum_link(999999999));
//     $args['total'] = $max;
//     $args['current'] = $current;
//     $args['prev_text'] = '<';
//     $args['next_text'] = '>';
//     if ( $max > 1 ) {
//         echo '<div class="wp-pagenavi"><span class="pages">共 ' . $max . ' 頁</span>' . paginate_links($args) . '</div>';
//     }
// }
// function tcc_old_message_table() {
//     echo '<div class="MessageTable"><table class="tablesorter">';
//     //echo '<thead><tr><th>' . __('Title','tcc') . '</th><th>' . __('Date','tcc') . '</th><th>' . __('Type','tcc') . '</th></tr> </thead>';
//     echo '<tbody>';
//     while (have_posts()):
//         the_post();
//         $expirationtime  = new DateTime(get_post_meta($post->ID, 'expiration_date', true) . " " . get_post_meta($post->ID, 'expiration_time', true));
//         // 判斷過期
//         if ($expirationtime >= new DateTime(date("y-m-d H:i:s"))) :
//             echo '<tr><td>';
//             foreach (get_the_category() as $key => $value) { //判斷緊急、重要標籤
//                 if ($value->category_nicename == 'primary' || $value->category_nicename == 'primary_en')
//                     echo "<span class='label label-primary'>" . $value->cat_name . "</span>";
//                 elseif ($value->category_nicename == 'emergency' || $value->category_nicename == 'emergency_en')
//                     echo "<span class='label label-danger'>" . $value->cat_name . "</span>";
//             }
//             echo '<a href="' . get_post_permalink() . '">' . the_title() . '</a></td><td>' . get_post_time(__('Y/m/d','tcc')) . '</td><td>';
//             the_tags('', ',','');
//             echo '</td></tr>';
//         endif;
//     endwhile;
//     echo '</tbody></table></div>';
// }
