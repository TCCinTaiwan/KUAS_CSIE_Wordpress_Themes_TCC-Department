<?
/* 後臺主題選單 */
class ThemeOptions {
     static function getOptions() {
          $options = get_option('theme_tcc_options');
          //清除用：$options = NULL;
          if (!is_array($options)) {
               $options['footer'] = Array(
                    'zh' => Array(),
                    'en' => Array()
               );
               // $options['logo'] = '';
               
               $options['marquee'] = Array(
                    'zh' => Array(),
                    'en' => Array()
               );

               $options['flex'] = Array(
                    'zh' => Array(),
                    'en' => Array()
               );
          }
          return $options;
     }
     static function init() {
          if(isset($_POST['option_save'])) {
               $options = ThemeOptions::getOptions();
               // 頁尾資訊
               if(isset($_POST['footer'])) {
                    $footer = array_filter($_POST['footer']);
                    $options['footer']['zh'] = Array();
                    foreach ($footer as $key => $value) {
                         $options['footer']['zh'][] = $value;
                    }
               }
               if(isset($_POST['footer_en'])) {
                    $footer_en = array_filter($_POST['footer_en']);
                    $options['footer']['en'] = Array();
                    foreach ($footer_en as $key => $value) {
                         $options['footer']['en'][] = $value;
                    }
               }
               // if (isset($_POST['logo'])) {
               //      $options['logo'] = stripslashes($_POST['logo']);
               // }
               
               // FlexSlider
               if(isset($_POST['flex'])) {
                    $flex = array_filter($_POST['flex']);
                    $options['flex']['zh'] = Array();
                    foreach ($flex as $key => $value) {
                         $options['flex']['zh'][] = $value;
                    }
               }
               if(isset($_POST['flex_en'])) {
                    $marquee_en = array_filter($_POST['flex_en']);
                    $options['flex']['en'] = Array();
                    foreach ($marquee_en as $key => $value) {
                         $options['flex']['en'][] = $value;
                    }
               }

               // 跑馬燈顯示訊息
               if(isset($_POST['marquee'])) {
                    $marquee = array_filter($_POST['marquee']);
                    $options['marquee']['zh'] = Array();
                    foreach ($marquee as $key => $value) {
                         $options['marquee']['zh'][] = $value;
                    }
               }
               if(isset($_POST['marquee_en'])) {
                    $marquee_en = array_filter($_POST['marquee_en']);
                    $options['marquee']['en'] = Array();
                    foreach ($marquee_en as $key => $value) {
                         $options['marquee']['en'][] = $value;
                    }
               }

               update_option('theme_tcc_options', $options);
          } else {
               ThemeOptions::getOptions();
          }
          add_menu_page( 'My Theme Options', __('Theme Options', 'tcc'), 'manage_options', 'theme_menu', array('ThemeOptions','theme_options') );
          add_submenu_page( 'theme_menu','FlexSlider Options', __('FlexSlider Options', 'tcc'), 'manage_options', 'theme_menu2', array('ThemeOptions','flexslider_options') );
          add_submenu_page( 'theme_menu','Marquee Options', __('Marquee', 'tcc'), 'manage_options', 'theme_menu3', array('ThemeOptions','marquee_options'));
     }
     /* 載入主題 */
     static function theme_activation(){
         if($GLOBALS['pagenow'] != 'themes.php' || !isset($_GET['activated']))
             return;
         wp_redirect(admin_url('admin.php?page=theme_menu')); //進入後台主題選單
         die;
     }

     /* 主題選項 */
     static function theme_options() {
          if (!current_user_can('manage_options')) {
               wp_die(__('You do not have sufficient permissions to access this page.' ));
          }
          $options = ThemeOptions::getOptions();
          // $options = NULL;
          // update_option('theme_tcc_options', $options);
          echo '<script src="'.get_template_directory_uri().'/js/function_theme_options.js"></script>';
          echo '<div class="wrap">
               <h1>主題管理頁面</h1>

               <form method="post" name="form" id="form">
               ';
          echo '<p><div id="footer_list"><h3>底部資訊:</h3>';
               for ($i = 0; $i < count($options['footer']['zh']); $i++) {
                    echo '<input type="text" name="footer[]" value="'.$options['footer']['zh'][$i].'"/><input type="text" name="footer_en[]" value="'.$options['footer']['en'][$i].'"/><br />';
               }
               echo '<input type="text" name="footer[]" /><input type="text" name="footer_en[]" /><br /></div><input type="button" id="add_footer" name="add_footer" value="增加項目" /></p>';
          wp_nonce_field('update-options');
          echo '<input type="hidden" name="action" value="update" />
               <input type="hidden" name="page_options" value="logo" />
               <p class="submit">
                    <input type="submit" name="option_save" value="'.__('Save Settings','tcc').'" />
               </p>
          </form>
          </div>';
          // <p>
          //      LOGO:<input name="logo" size="40" value="'.$options['logo'].'" />
          // </p>
          // 顯示變數
          echo '<pre>';
          var_dump($options);
          echo '</pre>';
     }

     /* 圖片牆選項 */
     static function flexslider_options() {
          if (!current_user_can( 'manage_options' ))  {
               wp_die(__('You do not have sufficient permissions to access this page.' ) );
          }
          $options = ThemeOptions::getOptions();
          echo '<script src="'.get_template_directory_uri().'/js/function_theme_options.js"></script>';

          echo '<div class="wrap">
               <h1>' . __('Setting the FlexSlider images', 'tcc') . '</h1>
               <form method="post" name="form" id="form">
               <p>
               <div id="flex_list"><h3>FlexSlider圖片:</h3>';
               for ($i = 0; $i < count($options['flex']['zh']); $i++) {
                    echo '<input type="text" name="flex[]" value="' . $options['flex']['zh'][$i] . '"/>
                    <input type="text" name="flex_en[]" value="'.$options['flex']['en'][$i].'"/><br />';
               }
               echo '<input type="text" name="flex[]"/>
               <input type="text" name="flex_en[]"/><br />
               </div>
               <input type="button" id="add_flex" name="add_flex" value="增加項目" />
               </p>';
          wp_nonce_field('update-options');
          echo '<input type="hidden" name="action" value="update" />
               <input type="hidden" name="page_options" value="logo" />
               <p class="submit">
                    <input type="submit" name="option_save" value="'.__('Save Settings','tcc').'" />
               </p>
               </form>
               </div>';
     }

     /* 跑馬燈選項 */
     static function marquee_options() {
          if ( !current_user_can( 'manage_options' ) )  {
               wp_die(__('You do not have sufficient permissions to access this page.'));
          }
          $options = ThemeOptions::getOptions();
          echo '<script src="' . get_template_directory_uri() . '/js/function_theme_options.js"></script>';

          echo '<div class="wrap">
               <h1>' . __('Setting the marquee message','tcc') . '</h1>
               <form method="post" name="form" id="form">
               <p><div id="marquee_list"><h3>跑馬燈訊息:</h3>';
               for ($i = 0; $i < count($options['marquee']['zh']); $i++) {
                    echo '<input type="text" name="marquee[]" value="' . $options['marquee']['zh'][$i] . '"/><input type="text" name="marquee_en[]" value="' . $options['marquee']['en'][$i] . '"/><br />';
               }
               echo '<input type="text" name="marquee[]"/><input type="text" name="marquee_en[]"/><br /></div><input type="button" id="add_marquee" name="add_marquee" value="增加項目" /></p>';
          wp_nonce_field('update-options');
          echo '<input type="hidden" name="action" value="update" />
               <input type="hidden" name="page_options" value="logo" />
               <p class="submit">
                    <input type="submit" name="option_save" value="' . __('Save Settings','tcc') . '" />
               </p>
          </form>
          </div>';
     }
}
add_action('admin_menu', array('ThemeOptions', 'init'));
add_action('load-themes.php', array('ThemeOptions', 'theme_activation'));