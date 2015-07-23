<?
function tcc_flexslider() {
    //相對位址參照點為網站主目錄
    echo '<div class="flexslider_box"><div class="flexslider"><ul class="slides">';
    $options = ThemeOptions::getOptions(); //載入主題設定值
    $lang = get_locale();
    $flexCount = 1;
    if ($flexCount > 0) {
        foreach ($options[$lang]['flex'] as $key => $value) {
            //echo '<li><img src="' . $value . '"/></li>';
            echo '<li>' . $value . '</li>';
        }
    }
    else 
    {
        // 預設圖片牆
        for ($i = 1; $i <= 4; $i ++) {
            echo '<li><img src="wp-content/themes/tcc/images/image' . $i . '.jpg"/></li>';
        }
    }
    echo '</ul></div></div>';
}
//!!!!!!!!!!!!!!!修改成圖文並茂