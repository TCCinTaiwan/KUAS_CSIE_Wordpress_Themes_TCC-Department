<?get_header();?>
<div class="content">
    <div class="article">
        <?while ( have_posts() ) : the_post();?>
        <article class="article-content">
            <h1 class="article-title"><? the_title();?></h1>
            <div class="article-meta">
                <span><?the_time(__('Y/n/j','tcc'));?> / <?the_category(' , ');?> / <?the_tags('', ' , ', '');?></span>
                <!-- <span><?the_time(__('Y/n/j','tcc'));?></span><span> / </span>
                <span><?the_tags('', ' , ','');?></span><span> / </span>
                <span><?the_category(',');?></span> -->
            </div>
            <?the_content();?>
            <div class="clearfix"><?_e('Expiration date:', 'tcc');echo date_format(date_create(get_post_meta($post->ID, '_expiration', true)), 'm/d/Y H:i:s');?></div>
        </article>
        <div id="comments">
            暫不提供留言功能
        </div>
        <?endwhile;?>
    </div>
    <div class="sidebar">
        <?get_sidebar();?>
    </div>
</div>
<?get_footer();?>