<?
    date_default_timezone_set('Asia/Taipei'); 
    $options = ThemeOptions::getOptions(); //載入主題設定值
?>
<!DOCTYPE html>
<html <?language_attributes();?>>
<head>
    <!-- 網頁文字編碼 -->
    <meta charset="<? bloginfo('charset');?>" />
    <!-- 網頁文字編碼 -->
    
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <!-- 標題列LOGO -->
    <link rel="shortcut icon" href="<? bloginfo('template_directory');?>/icon/favicon.png" />
    <!-- 標題列LOGO -->

    <!-- 追蹤連結文章 -->
    <link rel="pingback" href="<?bloginfo('pingback_url');?>" />
    <!-- 追蹤連結文章 -->

    <!-- 重置CSS -->
    <link href="<? bloginfo('template_directory')?>/css/reset.css" media="screen" rel="stylesheet" type="text/css" />
    <!-- 重置CSS -->
    
    <!-- Awesome 4.3.0 -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <!-- Awesome 4.3.0 -->

    <link href="<?bloginfo('template_directory')?>/css/style.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="<?bloginfo('template_directory')?>/css/menu.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="<?bloginfo('template_directory')?>/css/comments.css" media="screen" rel="stylesheet" type="text/css" />

    <link href="<?bloginfo('template_directory')?>/css/marquee.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="<?bloginfo('template_directory')?>/css/message.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="<?bloginfo('template_directory')?>/css/flexslider.css" media="screen" rel="stylesheet" type="text/css" />

    <script src="<?bloginfo('template_directory')?>/js/jquery-2.1.4.js"></script>

    <!-- bootstrap -->
    <link rel="stylesheet" href="<? bloginfo('template_directory')?>/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<? bloginfo('template_directory')?>/bootstrap/css/bootstrap-theme.min.css">
    <script src="<?bloginfo('template_directory')?>/bootstrap/js/bootstrap.min.js"></script>
    <!-- bootstrap -->

    <!-- justfont字型 -->
    <link href='//fonts.googleapis.com/css?family=Asap:400' rel='stylesheet' type='text/css'>
    <script src="//s3-ap-northeast-1.amazonaws.com/justfont-user-script/jf-34306.js"></script>
    <!-- justfont字型 -->

    <script src="<?bloginfo('template_directory')?>/js/jquery.marquee.min.js"></script>
    <script src="<?bloginfo('template_directory')?>/js/jquery.tablesorter.js"></script>
    <script src="<?bloginfo('template_directory')?>/js/jquery.flexslider-min.js"></script>
    
    <script src="<?bloginfo('template_directory')?>/js/angular.1.4.3.js"></script>

    <!-- 網頁初始化 -->
    <script src="<?bloginfo('template_directory')?>/js/init.js"></script>
    <!-- 網頁初始化 -->

    <script src="<?bloginfo('template_directory')?>/js/ajax.js"></script>
    
    <link href="<?bloginfo('template_directory')?>/style.css" media="screen" rel="stylesheet" type="text/css" />

    <?wp_head();?>
</head>
<body class="custom-background">
    <!-- 標題控制欄 -->
    <? wp_footer();?>
    <!-- 標題控制欄 -->
    <div class="container">
        <header class="header">
            <ul class='header-link'><? pll_the_languages(array('show_flags' => 1, 'hide_current' => 1));?></ul>
            <ul class='header-link'><li><a href="<?_e('http://eng.kuas.edu.tw/', 'tcc');?>"><img src="<? bloginfo('template_directory');?>/icon/KUAS.ico" width="16"><?_e(' KUAS', 'tcc');?></a></li></ul>
            <ul class='header-link'><li><a href="http://goo.gl/forms/6XE5xu3Z6E" Target="external" onclick="window.open('http://goo.gl/forms/6XE5xu3Z6E', 'external', 'width=800,height=600')"><span class="glyphicon glyphicon-stats" aria-hidden="true"></span><?_e(' Bug Tracker', 'tcc');?></a></li></ul>
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
                    <?foreach ($options[get_locale()]['marquee'] as $key => $value) {
                        echo '<li>'.$value.'</li>';// class="setofont" 引用字型
                    }?>
                </ul>
            </section>
            <!-- 跑馬燈 -->
        </header>