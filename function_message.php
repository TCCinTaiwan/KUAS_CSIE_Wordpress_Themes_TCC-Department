<?
/* 顯示公告 */
function tcc_message_table() {
    global $cat, $tag, $post;
    echo '<div class="MessageTable"><table class="tablesorter">';
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
            echo '<a href="' . get_post_permalink() . '">'. get_the_title($post->ID) . '</a></td><td>' . get_post_time(__('Y/m/d','tcc')) . '</td><td>';
            the_tags('', ',','');
            echo '</td></tr>';
        endwhile;
    endif;
    echo '</tbody></table></div>';
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
