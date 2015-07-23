<?get_header();?>
<div class="content">
    <div class="article">
        <?while (have_posts()) : the_post();?>
            <article class="article-content">
                <h1 class="article-title"><? the_title();?></h1>
                <div class="thumbnail-img"><?the_post_thumbnail('large');?></div>
                <?
                the_content();
                if (is_page()) { //取得子網頁
                    $args = array(
                        'post_status' => 'publish',
                        'post_type' => 'page',
                        'post_parent' => $post->ID,
                        'orderby' => 'menu_order',
                        'order' => 'ASC',
                        'nopaging' => true,
                    );
                    $pages = get_posts($args);
                    foreach ($pages as $post) {
                        setup_postdata($post);
                        get_sub_page();
                    }
                }
                ?>
                <div class="clearfix"></div>
            </article>
        <?endwhile;?>
    </div>
    <div class="sidebar">
        <?get_sidebar();?>
    </div>
</div>
<?
get_footer();
wp_reset_postdata();
?>