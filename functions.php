<?
@ini_set("upload_max_size" , "200M");   //單一檔案大小最大值
@ini_set("post_max_size", "200M");   //表單傳輸的最大值(通常比upload_max_size大)
@ini_set("max_execution_time", "300");   //Script執行時間上限(單位：秒)
date_default_timezone_set('Asia/Taipei'); 
include_once('function_theme_options.php'); //主題選單
include_once('function_theme_customiser.php'); //主題自訂風格
include_once('function_meta_boxes.php'); //主題文章相關參數
include_once('function_plugin.php'); //插件
include_once('function_message.php'); //訊息


/*移除不必要meta資訊*/
remove_action( 'wp_head', 'wp_generator' ) ; 
remove_action( 'wp_head', 'wlwmanifest_link' ) ; 
remove_action( 'wp_head', 'rsd_link' ) ;

/*停用 WordPress 迴響的 HTML 功能*/
add_filter( 'pre_comment_content', 'wp_specialchars' );

load_theme_textdomain('tcc', get_template_directory() . '/languages');/*多國語言支持*/
function theme_setup() {
    load_theme_textdomain('tcc', get_template_directory() . '/languages');/*多國語言支持*/
    add_theme_support('post-thumbnails');//使用文章特色圖片
    add_theme_support('title-tag');
    add_theme_support('html5', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption'));// 在評論表格、搜尋表格或評論清單等等地方使用 HTML5 標記。
    add_theme_support('menus');
    register_nav_menu('primary', __('Primary Header Navigation', 'tcc'));
}
add_action('after_setup_theme', 'theme_setup');




// add_theme_support('post-formats', array('aside', 'gallery'));// 使用文章格式
/* 右側邊攔 */
if (function_exists('register_sidebar') ) {
    register_sidebar(array(
        'name' => __('Right sidebar', 'tcc'),
        'id' => 'sidebar',
        'description' => __('It appears to the right of the page.', 'tcc'),
        'before_widget' => '<section id="%1$s" class="sidebar-right">',
        'after_widget' => '</section>',
        'before_title' => '<h1 class="sidebar-title">',
        'after_title' => '</h1>'
    ));
}

function tcc_flexslider() {
    echo '<div class="flexslider_box"><div class="flexslider"><ul class="slides">';
    $options = ThemeOptions::getOptions(); //載入主題設定值
    $lang = substr(get_locale(), 0, 2);
    if (count($options['flex'][$lang]) > 0 ) {
        foreach ($options['flex'][$lang] as $key => $value) {
            echo '<li><img src="' . $value . '"/></li>';
        }
    }
    else 
    {
        // 預設圖片牆
        for ($i = 1; $i <= 4; $i ++) {
            echo '<li><img src="http://203.64.91.82/KUAS_CSIE/wordpress_1/wp-content/themes/tcc/images/image' . $i . '.jpg"/></li>';
        }
    }
    echo '</ul></div></div>';
}
/* 留言HTML */
// add_filter( 'pre_comment_content', 'wp_specialchars' );
// register_nav_menus( array(
//     'header_menu' => 'Header Menu',
// ));

/* 顯示留言 */
// function displaycomments($comment, $args, $depth) {
//     $GLOBALS['comment'] = $comment;
//     echo '<li class="comment-list-box"><div class="comment-author">';
//     echo get_avatar($comment, 40); //頭像
//     echo '</div><div class="comment-fn">';
//     printf('<span class="fn">%s</span>',get_comment_author_link());
//     echo '</div><div class="comment-meta">';
//     printf('%1$s %2$s',get_comment_date(__('Y/n/j','tcc')), get_comment_time());
//     edit_comment_link();
//     echo '</div>';
//     if ($comment->comment_approved == '0') :
//         echo '<em class="comment-approved">你的迴響正在審核中。</em>';
//     endif;
//     comment_text();
//     comment_reply_link(array_merge( $args,array('depth' => $depth, 'max_depth' =>$args['max_depth'])));
// }
// 

