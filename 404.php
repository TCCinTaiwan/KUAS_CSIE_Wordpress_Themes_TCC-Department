<? get_header();?>
<div class="content">
    <div class="article">
        <article class="article-content">
            <h1><?_e('404 Page Not Found','tcc' );?></h1>
            <p><?_e('Sorry, could not find the page you want, perhaps has been removed, temporarily closed or an error occurs.','tcc' );?></p>
            <p>
                <a href="<? bloginfo('url');?>" title="<? _e('Home','tcc');?>"><? _e('Home','tcc');?></a>
            </p>
            <h2><?_e('Search by Category', 'tcc');?></h2>
            <ul class="errorlist">
                <? wp_list_categories('orderby=ID&show_count=1&use_desc_for_title=0&title_li=&style=list');?>
            </ul>
        </article>
    </div>
    <div class="sidebar">
        <? get_sidebar();?>
    </div>
</div>
<? get_footer();?>