<?
    date_default_timezone_set('Asia/Taipei'); 
    $options = ThemeOptions::getOptions(); //載入主題設定值
?>
<!DOCTYPE html>
<html <?language_attributes();?>>
<head>
    <? wp_head();?>
    <title><?bloginfo('name');?></title>

    <meta charset="<? bloginfo('charset');?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="shortcut icon" href="<? bloginfo('template_directory');?>/icon/favicon.png" />
    <link rel="pingback" href="<?bloginfo('pingback_url');?>" />
    <link href="<? bloginfo('template_directory')?>/css/reset.css" media="screen" rel="stylesheet" type="text/css" />
    

    <link href="<? bloginfo('template_directory')?>/style.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="<? bloginfo('template_directory')?>/css/menu.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="<? bloginfo('template_directory')?>/css/comments.css" media="screen" rel="stylesheet" type="text/css" />

    <link href="<? bloginfo('template_directory')?>/css/marquee.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="<? bloginfo('template_directory')?>/css/message.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="<? bloginfo('template_directory')?>/css/flexslider.css" media="screen" rel="stylesheet" type="text/css" />

    <script src="<? bloginfo('template_directory')?>/js/jquery-1.11.2.js"></script>

    <!-- bootstrap -->
    <link rel="stylesheet" href="<? bloginfo('template_directory')?>/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<? bloginfo('template_directory')?>/bootstrap/css/bootstrap-theme.min.css">
    <script src="<? bloginfo('template_directory')?>/bootstrap/js/bootstrap.min.js"></script>
    <!-- bootstrap -->

    <script src="<? bloginfo('template_directory')?>/js/jquery.marquee.min.js"></script>
    <script src="<? bloginfo('template_directory')?>/js/jquery.tablesorter.js"></script>
    <script src="<? bloginfo('template_directory')?>/js/jquery.flexslider-min.js"></script>
    <script src="<? bloginfo('template_directory')?>/js/init.js"></script>
    <link href="<? bloginfo('template_directory')?>/css/style.css" media="screen" rel="stylesheet" type="text/css" />
</head>
<body>
    <!-- 標題控制欄 -->
    <? wp_footer();?>
    <!-- 標題控制欄 -->
    <div class="container">
        <header class="header">
            <ul class='header-link'><? pll_the_languages(array('show_flags' => 1, 'hide_current' => 1));?></ul>
            <ul class='header-link'><li><a href="http://www.kuas.edu.tw/"><img src="<? bloginfo('template_directory');?>/icon/KUAS.ico" width="16">&nbsp;高應大</a></li></ul>
            <!-- .................... -->
            <div class="title">
                <a href="<? bloginfo('url');?>">
                    <img src="<?header_image();?>" height="<?=get_custom_header()->height;?>" width="<?=get_custom_header()->width;?>" alt="" />
                </a><!-- <h1><?bloginfo('name');?></h1> -->  
            </div>
            <!-- 主選單 -->
            <nav id="navigation">
                <?
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'container' => false,
                        'depth' => 3,
                        'show_home' => true,
                        'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>'
                    ));
                ?>
            </nav>
            <!-- 主選單 -->
            <!-- 跑馬燈 -->
            <section>
                <h2 class='hide'><?_e('marquee');?></h2>
                <ul id="marquee" class="marquee">
                    <?foreach ($options['marquee'][substr(get_locale(), 0, 2)] as $key => $value) {
                        echo '<li>'.$value.'</li>';
                    }?>
                </ul>
            </section>
            <!-- 跑馬燈 -->
        </header>