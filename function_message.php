<?
/* 顯示公告 */
function tcc_message_table() {
    global $cat, $tag, $post;
    echo '<div class="MessageTable"><h1>' . __('News', 'tcc') . '</h1><div class="loading"></div><table class="tablesorter">';
    //echo '<thead><tr><th>' . __('Title','tcc') . '</th><th>' . __('Date','tcc') . '</th><th>' . __('Type','tcc') . '</th></tr> </thead>';
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
            foreach (get_the_category() as $post_category) { //判斷緊急、重要標籤
                if ($post_category->category_nicename == 'primary' || $post_category->category_nicename == 'primary_en')
                    echo "<span class='label label-primary'>" . $post_category->cat_name . "</span>";
                elseif ($post_category->category_nicename == 'emergency' || $post_category->category_nicename == 'emergency_en')
                    echo "<span class='label label-danger'>" . $post_category->cat_name . "</span>";
            }
            //$expiration  = new DateTime(get_post_meta($post->ID, '_expiration', true));
            // 判斷過期if ($expiration >= new DateTime(date("y-m-d H:i:s"))) :
            echo '<a href="' . get_post_permalink() . '">'. get_the_title($post->ID) . '</a>';



            $attachments = get_posts( array(
                'post_type' => 'attachment',
                'posts_per_page' => 0,
                'post_parent' => $post->ID
            ));
            if ($attachments) {
                foreach ( $attachments as $attachment ) {
                    switch ($attachment->post_mime_type) {
                        case 'text/plain'://純文字
                            $filetype = 'file-text-o';
                            break;
                        case 'text/html'://HTML文檔
                            $filetype = 'file-code-o';
                            break;
                        case 'application/xhtml+xml'://XHTML文檔
                            $filetype = 'file-o';
                            break;
                        case 'image/gif'://GIF圖像
                            $filetype = 'file-image-o';
                            break;
                        case 'image/pjpeg'://JPEG圖像(image/jpeg)
                            $filetype = 'file-image-o';
                            break;
                        case 'image/x-png'://PNG圖像(image/png)
                            $filetype = 'file-image-o';
                            break;
                        case 'video/mpeg'://MPEG動畫
                            $filetype = 'file-video-o';
                            break;
                        case 'application/octet-stream'://任意的二進位數據
                            $filetype = 'file-text';
                            break;
                        case 'application/pdf'://PDF文檔
                            $filetype = 'file-pdf-o';
                            break;
                        case 'application/msword'://Microsoft Word文件
                            $filetype = 'file-word-o';
                            break;
                        case 'application/vnd.wap.xhtml+xml'://wap1.0+
                            $filetype = 'file-o';
                            break;
                        case 'application/xhtml+xml'://wap2.0+
                            $filetype = 'file-o';
                            break;
                        case 'message/rfc822'://RFC 822形式
                            $filetype = 'file-o';
                            break;
                        case 'multipart/alternative'://HTML郵件的HTML形式和純文本形式，相同內容使用不同形式表示
                            $filetype = 'file-o';
                            break;
                        case 'application/x-www-form-urlencoded'://使用HTTP的POST方法提交的表單
                            $filetype = 'file-o';
                            break;
                        case 'multipart/form-data'://同上，但主要用於表單提交時伴隨文件上傳的場合
                            $filetype = 'file-o';
                            break;
                        default:
                            $filetype = 'file-o';
                            break;
                    }
                    // echo wp_get_attachment_image($attachment->ID, false);
                    // var_dump($attachment);
                    echo '<a href="' . wp_get_attachment_url($attachment->ID) . '" title="' . $attachment->post_title . '(' . wpatt_format_bytes(filesize(get_attached_file($attachment->ID))) . ')">
                    <i class="fa fa-' . $filetype . '"></i>
                    </a>';
                    // echo wp_get_attachment_link($attachment->ID, 'medium', 'False', 'True');
                }
            }

            echo '</td><td>' . get_post_time(__('Y/m/d','tcc')) . '</td><td>';
            the_tags('', ',','');
            echo '</td></tr>';
        endwhile;
    endif;
    echo '</tbody></table>';
    tcc_pagenavi();
    echo '</div>';
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
    // <div class="btn-group" role="group" aria-label="First group">
    // <button type="button" class="btn btn-default">1</button>
    // <button type="button" class="btn btn-default">2</button>
    // <button type="button" class="btn btn-default">3</button>
    // <button type="button" class="btn btn-default">4</button>
    // </div>
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
