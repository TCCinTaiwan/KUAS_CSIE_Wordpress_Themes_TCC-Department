<?get_header();?><!-- 載入頭部 -->
<div class="content">
    <div class="article">
        <?breadcrumb_init();?><!-- 麵包屑 -->
        <?while (have_posts()) : the_post();?>
            <article class="article-content">
                <h1 class="article-title"><a href="<?the_permalink();?>"><?the_title();?></a></h1>
                <div class="article-meta">
                    <span><?the_time(__('Y/n/j','tcc'));?> / <?the_category(' , ');?> / <?the_tags('', ' , ', '');?></span>
                    <!-- <span><?the_time(__('Y/n/j','tcc'));?></span><span> / </span>
                    <span><?the_tags('', ' , ','');?></span><span> / </span>
                    <span><?the_category(',');?></span> -->
                </div>
                <?the_content();?>
                <div class="clearfix"></div>
            </article>
        <?endwhile;?>
        <?wp_pagenavi();?><!-- 載入自定義頁數選單 -->
    </div>
    <div class="sidebar">
        <?get_sidebar();?><!-- 載入側邊欄 -->
    </div>
</div>
<?get_footer();?><!-- 載入底部 -->