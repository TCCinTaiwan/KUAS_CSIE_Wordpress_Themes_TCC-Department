<?get_header();?><!-- 載入頭部 -->
<!-- archives -->
<div id="content" class="content">
    <div class="article">
        <?breadcrumb_init();?><!-- 麵包屑 -->
        <?while (have_posts()) : the_post();?>
            <article class="article-content">
                <h1 class="article-title"><a href="<?the_permalink();?>"><?the_title();?></a></h1>
                <div class="article-meta"><span><?the_time(__('Y/n/j','tcc'));?> / <?the_category(' , ');?> / <?the_tags('', ' , ', '');?></span></div>
                <?the_content();?>
                <div class="clearfix"></div>
            </article>
        <?endwhile;?>
        <?wp_pagenavi();?><!-- 載入自定義頁數選單 -->
    </div>
</div>
<?get_footer();?><!-- 載入底部 -->