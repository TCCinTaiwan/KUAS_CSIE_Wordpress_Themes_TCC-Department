
<h3 class="comment-title"><? comments_number('沒有迴響', '迴響 (1)', '迴響 (%)' );?></h3>
<? if ( have_comments() ) :?>

    <ol class="comment-list">
        <? wp_list_comments('type=comment&callback=displaycomments');?>
    </ol>
    <div class="clearfix"></div>
    <div class="pagenavi">
        <? paginate_comments_links('prev_text=Prev Comments&next_text=Next Comments');?>
    </div>

<? else : ?>

    <? if ( comments_open() ) :?>
        <p>本文還沒有迴響，快來搶頭香！</p>
    <? else :?>
        <p class="nocomments">本文不開放迴響。</p>
    <? endif;?>

<? endif;?>

<? comment_form();?>