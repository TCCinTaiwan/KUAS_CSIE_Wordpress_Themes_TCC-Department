<?get_header();?>
<div id="content" class="content">
    <!-- 跑馬燈 -->
    <section>
        <h2 class='hide'><?_e('Marquee', 'tcc');?></h2>
        <ul id="marquee" class="marquee">
            <?$options = ThemeOptions::getOptions(); //載入主題設定值
            foreach ($options[get_locale()]['marquee']['message'] as $key => $value) {
                echo '<li><h3>'.$value.'</h3></li>';// class="setofont" 引用字型
            }?>
        </ul>
    </section>
    <!-- 跑馬燈 -->
    <div class="article">
        <?tcc_flexslider();?>
        <?tcc_message_table();?>
    </div>
</div>
<?get_footer();?>