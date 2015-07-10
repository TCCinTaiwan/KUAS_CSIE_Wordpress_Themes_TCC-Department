<div>
    <h2><? the_title();?></h2>
    <?
    the_content();
    if (is_page()){
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
            require('get_page.php');
        }

    }
    ?>
    <div class="clearfix"></div>
</div>