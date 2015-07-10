<? get_header();?>
<div class="content">
    <div class="article">
        <? if (have_posts()) :?>
            <? while (have_posts()) : the_post();?>
                <article class="article-content">
                    <h1 class="article-title"><a href="<? the_permalink();?>"><? the_title();?></a></h1>
                    <div class="article-meta">
                        <span><?the_time(__('Y/n/j','tcc'));?> / <?the_category(' , ');?> / <?the_tags('', ' , ', '');?></span>
                        <!-- <span><?the_time(__('Y/n/j','tcc'));?></span><span> / </span>
                        <span><?the_tags('', ' , ','');?></span><span> / </span>
                        <span><?the_category(',');?></span> -->
                        </div>
                    <? the_content();?>
                    <div class="clearfix"></div>
                </article>
            <? endwhile;?>
        <? else :?>
            <article class="article-content">
                <h1><?_e('Search Results', 'tcc');?></h1>
                <p><?_e('Sorry, I can not find the article you are searching for, you can try other keywords to find again.', 'tcc');?></p>
                <? get_search_form();?>
            </article>
        <? endif;?>
        <? wp_pagenavi();?>
    </div>
    <div class="sidebar">
    <? get_sidebar();?>
    </div>
</div>
<? get_footer();?>