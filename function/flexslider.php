<?
function tcc_flexslider() {
    echo '<div class="flexslider_box"><h2 class="hide">' . __('Flex Slider', 'tcc') . '</h2><div class="flexslider"><ul class="slides">';
    $options = ThemeOptions::getOptions(); //載入主題設定值
    $lang = get_locale();
    $flexCount = count($options[$lang]['flex']['title']);
    if ($flexCount > 0) {
        for ($i = 0; $i < $flexCount; $i ++) {
            echo '<li><div class=' . $options[$lang]['flex']['style'][$i] . '><img src=' . $options[$lang]['flex']['image'][$i] . '><div><h3>' . $options[$lang]['flex']['title'][$i] . '</h3></div></div></li>';
        }
    }
    else 
    {
        // 預設圖片牆
        for ($i = 1; $i <= 4; $i ++) {
            echo '<li><img src="';
            bloginfo('template_directory');
            echo '/images/image' . $i . '.jpg"/></li>';
        }
    }
    echo '</ul></div></div>';
}