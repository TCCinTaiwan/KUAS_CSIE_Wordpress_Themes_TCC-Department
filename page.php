<?get_header();?>
<!-- page -->
<div id="content" class="content">
    <div class="article">
        <?
        while (have_posts()):
            the_post();
            show_page($post->ID);
        endwhile;
        ?>
    </div>
</div>
<?
get_footer();
wp_reset_postdata();
?>