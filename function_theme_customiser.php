<?
/* 主題自訂風格 */
class ThemeCustomiser {
    function customize_colors($wp_manager){
        //選擇跑馬燈文字顏色
        $wp_manager->add_setting('marquee_text_color', array(
            'default' => '#000000',
        ) );
        $wp_manager->add_control(new WP_Customize_Color_Control($wp_manager, 'marquee_text_color', array(
            'label' => __( 'Marquee Text Color', 'tcc' ),
            'section' => 'colors',
            'settings' => 'marquee_text_color',
            'priority' => 100
        ) ) );
    }

    function add_customize_color(){
        $marquee_text_color = get_theme_mod('marquee_text_color');
        if($marquee_text_color) echo '<style>.marquee li{color:' . $marquee_text_color . ';}</style>';
 
        $background_color = get_theme_mod('background_color');
        if($background_color) echo '<style>body{color:' . $background_color . ';}</style>';

        $header_textcolor = get_theme_mod('header_textcolor');
        if($header_textcolor) echo '<style>header{color:' . $header_textcolor . ';}</style>';
    }
}
add_action('wp_head', array('ThemeCustomiser', 'add_customize_color'));
add_action('customize_register', array('ThemeCustomiser', 'customize_colors'));/* 標題圖像 */
add_theme_support('custom-header', array(
    'default-image'          => get_template_directory_uri() . '/images/header.png',
    'random-default'         => false, //默認隨機圖片
    'width'                  => 1100,
    'height'                 => 240,
    'flex-width'             => true,
    'flex-height'            => true,
    'header-text'            => true, //自訂標題文字顏色
    'default-text-color'     => '#000000', //默認文字顏色
    'uploads'                => true, //是否允許上傳
    'wp-head-callback'       => '',
    'admin-head-callback'    => '',
    'admin-preview-callback' => '',
));//自定表頭圖

add_theme_support('custom-background', array(
    'default-color'          => '#6CC',
    'default-image'          => get_template_directory_uri() . '/images/background.jpg',
    'wp-head-callback'       => '_custom_background_cb',
    'admin-head-callback'    => '',
    'admin-preview-callback' => ''
));//自定背景顏色

        // $wp_manager->add_section('footer', array(
        //     'title' => __('footer', 'tcc'),
        //     'priority' => 36,
        // ) );
        // $wp_manager->add_setting( 'adress', array(
        //     'default' => __('', 'tcc' ),
        // ));
        // $wp_manager->add_control( 'adress', array(
        //     'label' => __( 'adress', 'tcc' ),
        //     'section' => 'footer',
        //     'type' => 'text',
        //     'priority' => 1
        // ));

        // //文本框
        // $wp_manager->add_setting( 'textbox_setting', array(
        //     'default' => __( '默认值', 'tcc' ),
        // ) );

        // $wp_manager->add_control( 'textbox_setting', array(
        //     'label' => __( '文本框', 'tcc' ),
        //     'section' => 'style',
        //     'type' => 'text',
        //     'priority' => 1
        // ) );

        // //复选框
        // $wp_manager->add_setting( 'checkbox_setting', array(
        //     'default' => '1',
        // ) );

        // $wp_manager->add_control( 'checkbox_setting', array(
        //     'label' => __( '复选框', 'tcc' ),
        //     'section' => 'style',
        //     'type' => 'checkbox',
        //     'priority' => 2
        // ) );

        // //单选框
        // $wp_manager->add_setting( 'radio_setting', array(
        //     'default' => '1',
        // ) );

        // $wp_manager->add_control( 'radio_setting', array(
        //     'label' => __( '单选框', 'tcc' ),
        //     'section' => 'style',
        //     'type' => 'radio',
        //     'choices' => array( '1' => '方案一', '2' => '方案二', '3' => '方案三', '4' => '方案四', '5' => '方案五' ),
        //     'priority' => 3
        // ) );

        // //选择框
        // $wp_manager->add_setting( 'select_setting', array(
        //     'default' => '1',
        // ) );

        // $wp_manager->add_control( 'select_setting', array(
        //     'label' => __( '选择框', 'tcc' ),
        //     'section' => 'style',
        //     'type' => 'select',
        //     'choices' => array( '1' => '方案一', '2' => '方案二', '3' => '方案三', '4' => '方案四', '5' => '方案五' ),
        //     'priority' => 4
        // ) );

        // //選擇頁面
        // $wp_manager->add_setting( 'dropdown_pages_setting', array(
        //     'default' => '1',
        // ) );
        // $wp_manager->add_control( 'dropdown_pages_setting', array(
        //     'label' => __( '選擇頁面', 'tcc' ),
        //     'section' => 'colors',
        //     'type' => 'dropdown-pages',
        //     'priority' => 5
        // ) );


    //     //上傳文件
    //     $wp_manager->add_setting( 'upload_setting', array(
    //         'default' => '',
    //     ) );

    //     $wp_manager->add_control( new WP_Customize_Upload_Control( $wp_manager, 'upload_setting', array(
    //         'label' => __( '上傳文件', 'tcc' ),
    //         'section' => 'style',
    //         'settings' => 'upload_setting',
    //         'priority' => 7
    //     ) ) );

    //     //上傳圖片
    //     $wp_manager->add_setting( 'image_setting', array(
    //         'default' => '',
    //     ) );

    //     $wp_manager->add_control( new WP_Customize_Image_Control( $wp_manager, 'image_setting', array(
    //         'label' => __( '上傳圖片', 'tcc' ),
    //         'section' => 'style',
    //         'settings' => 'image_setting',
    //         'priority' => 8
    //     ) ) );