<?
/* 後臺主題選單 */
class ThemeOptions {
     static function getOptions() {
          $options = get_option('theme_tcc_options');
          //清除用：$options = NULL;
          // $options = NULL;
          if (!is_array($options)) {
               $languages_list = ThemeOptions::get_languages_list();
               foreach ($languages_list as $language) {
                    $options[$language] = Array(
                         'footer' => Array(),
                         'marquee' => Array(),
                         'flex' => Array()
                    );
               }
          }
          return $options;
     }
     static function get_languages_list() { //取得支援的語言清單
          $languages_list = Array();
          $transient_pll_languages_list = get_option('_transient_pll_languages_list');
          foreach ($transient_pll_languages_list as $language) {
               $languages_list[$language['locale']] = $language['locale'];
          }
          return $languages_list;
     }
     static function init() {
          if(isset($_POST['option_save'])) {
               $options = ThemeOptions::getOptions();
               $languages_list = ThemeOptions::get_languages_list();
               foreach ($languages_list as $language) {
                    foreach ($options[$language] as $option_key => $option) {
                         $post_name = $option_key . '_' . $language;
                         if (isset($_POST[$post_name])) {
                              $post_array = array_filter($_POST[$post_name]);
                              $options[$language][$option_key] = Array();
                              foreach ($post_array as $post_item) {
                                   $options[$language][$option_key][] = $post_item;
                              }
                         }
                    }
               }
               update_option('theme_tcc_options', $options);
          }
          add_menu_page('My Theme Options', __('Theme Options', 'tcc'), 'manage_options', 'theme_menu', array('ThemeOptions','theme_options'));
          add_submenu_page('theme_menu','FlexSlider Options', __('FlexSlider Options', 'tcc'), 'manage_options', 'theme_menu2', array('ThemeOptions','flexslider_options'));
          add_submenu_page('theme_menu','Marquee Options', __('Marquee', 'tcc'), 'manage_options', 'theme_menu3', array('ThemeOptions','marquee_options'));
     }
     /* 載入主題 */
     static function theme_activation() {
         if($GLOBALS['pagenow'] != 'themes.php' || !isset($_GET['activated']))
             return;
         wp_redirect(admin_url('admin.php?page=theme_menu')); //進入後台主題選單
         die;
     }
     //已知Bug：輸入項目不能留白，不然會對不到!!!!!!
     //待增加功能：一頁多欄位(資料也要跟著改格式)。
     static function show_page($page, $display_debug = false) {
          if (!current_user_can('manage_options')) {
               wp_die(__('You do not have sufficient permissions to access this page.' ));
          }
          $options = ThemeOptions::getOptions();
          $pages = Array(
               'theme_options' => Array(
                    'title' => __('Theme Options', 'tcc'),
                    'fileds' => Array(
                         'title' => __('Footer Info:', 'tcc'),
                         'id' => 'footer'
                    )
               ),
               'flexslider_options' => Array(
                    'title' => __('Setting the FlexSlider contents', 'tcc'),
                    'fileds' => Array(
                         'title' => __('FlexSlider Contents:', 'tcc'),
                         'id' => 'flex'
                    )
               ),
               'marquee_options' => Array(
                    'title' => __('Setting the marquee message', 'tcc'),
                    'fileds' => Array(
                         'title' => __('Marquee Message:', 'tcc'),
                         'id' => 'marquee'
                    )
               )
          );
          $page = $pages[$page];
          // echo '<pre>' . var_dump($page) . '</pre>';//顯示
               echo '<script>jQuery(document).ready(function() {jQuery("#add_' . $page['fileds']['id'] . '").click(function() {jQuery("#' .  $page['fileds']['id'] . '_list > br:last").after("';
               foreach ($options as $option_key => $option) {
                    echo '<input type=\'text\' name=\'' .  $page['fileds']['id'] . '_' . $option_key . '[]\' />';
               }
               echo '<br />");});});</script>';

          echo '<div class="wrap"><h1>' . $page['title'] . '</h1><form method="post" name="form" id="form">';
               echo '<p><div id="' .  $page['fileds']['id'] . '_list"><h3>' . $page['fileds']['title'] . '</h3>';
               for ($i = 0; $i < count($options[get_locale()][ $page['fileds']['id']]); $i++) {
                    foreach ($options as $option_key => $option) {
                         echo '<input type="text" name="' .  $page['fileds']['id'] . '_' . $option_key . '[]" value="' . $option[ $page['fileds']['id']][$i]. '"/>';
                    }
                    echo '<br />';
               }
               foreach ($options as $option_key => $option) {
                    echo '<input type="text" name="' .  $page['fileds']['id'] . '_' . $option_key . '[]" />';
               }
               echo '<br /></div><input type="button" id="add_' .  $page['fileds']['id'] . '" value="增加項目" /></p>';
          wp_nonce_field('update-options');
          echo '<input type="hidden" name="action" value="update" />
               <input type="hidden" name="page_options" value="logo" />
               <p class="submit">
                    <input type="submit" name="option_save" value="' . __('Save Settings','tcc') . '" />
               </p>
          </form>
          </div>';
          /* MCE Editer */
          $editor_id = 'content';
          $content = RRRRRGGG;
          wp_editor($content, $editor_id, $settings = array());
          // default settings
          $settings = array(
               'wpautop' => true, // use wpautop?
               'media_buttons' => true, // show insert/upload button(s)
               'textarea_name' => $editor_id, // set the textarea name to something different, square brackets [] can be used here
               'textarea_rows' => get_option('default_post_edit_rows', 10), // rows="..."
               'tabindex' => '',
               'editor_css' => '', // intended for extra styles for both visual and HTML editors buttons, needs to include the <style> tags, can use "scoped".
               'editor_class' => '', // add extra class(es) to the editor textarea
               'teeny' => true, // output the minimal editor config used in Press This
               'dfw' => true, // replace the default fullscreen with DFW (supported on the front-end in WordPress 3.4)
               'tinymce' => true, // load TinyMCE, can be used to pass settings directly to TinyMCE using an array()
               'quicktags' => true // load Quicktags, can be used to pass settings directly to Quicktags using an array()
          );

          if ($display_debug) {
               echo '<pre>';
               var_dump($options);// 顯示變數
               echo '</pre>';
          }
     }
     /* 主題選項 */
     static function theme_options() {
          ThemeOptions::show_page('theme_options', true);
     }

     /* 圖片牆選項 */
     static function flexslider_options() {
          ThemeOptions::show_page('flexslider_options');
     }

     /* 跑馬燈選項 */
     static function marquee_options() {
          ThemeOptions::show_page('marquee_options');
     }
}
add_action('admin_menu', array('ThemeOptions', 'init'));
add_action('load-themes.php', array('ThemeOptions', 'theme_activation'));





// /* 後臺主題選單 */
// class ThemeOptions {
//      static function getOptions() {
//           $options = get_option('theme_tcc_options');
//           //清除用：$options = NULL;
//           if (!is_array($options)) {
//                $options['footer'] = Array(
//                     'zh' => Array(),
//                     'en' => Array()
//                );
//                $options['marquee'] = Array(
//                     'zh' => Array(),
//                     'en' => Array()
//                );

//                $options['flex'] = Array(
//                     'zh' => Array(),
//                     'en' => Array()
//                );
//           }
//           return $options;
//      }
//      static function init() {
//           if(isset($_POST['option_save'])) {
//                $options = ThemeOptions::getOptions();
//                // 頁尾資訊
//                if(isset($_POST['footer'])) {
//                     $footer = array_filter($_POST['footer']);
//                     $options['footer']['zh'] = Array();
//                     foreach ($footer as $key => $value) {
//                          $options['footer']['zh'][] = $value;
//                     }
//                }
//                if(isset($_POST['footer_en'])) {
//                     $footer_en = array_filter($_POST['footer_en']);
//                     $options['footer']['en'] = Array();
//                     foreach ($footer_en as $key => $value) {
//                          $options['footer']['en'][] = $value;
//                     }
//                }
               
//                // FlexSlider
//                if(isset($_POST['flex'])) {
//                     $flex = array_filter($_POST['flex']);
//                     $options['flex']['zh'] = Array();
//                     foreach ($flex as $key => $value) {
//                          $options['flex']['zh'][] = $value;
//                     }
//                }
//                if(isset($_POST['flex_en'])) {
//                     $marquee_en = array_filter($_POST['flex_en']);
//                     $options['flex']['en'] = Array();
//                     foreach ($marquee_en as $key => $value) {
//                          $options['flex']['en'][] = $value;
//                     }
//                }

//                // 跑馬燈顯示訊息
//                if(isset($_POST['marquee'])) {
//                     $marquee = array_filter($_POST['marquee']);
//                     $options['marquee']['zh'] = Array();
//                     foreach ($marquee as $key => $value) {
//                          $options['marquee']['zh'][] = $value;
//                     }
//                }
//                if(isset($_POST['marquee_en'])) {
//                     $marquee_en = array_filter($_POST['marquee_en']);
//                     $options['marquee']['en'] = Array();
//                     foreach ($marquee_en as $key => $value) {
//                          $options['marquee']['en'][] = $value;
//                     }
//                }

//                update_option('theme_tcc_options', $options);
//           } else {
//                ThemeOptions::getOptions();
//           }
//           add_menu_page( 'My Theme Options', __('Theme Options', 'tcc'), 'manage_options', 'theme_menu', array('ThemeOptions','theme_options') );
//           add_submenu_page( 'theme_menu','FlexSlider Options', __('FlexSlider Options', 'tcc'), 'manage_options', 'theme_menu2', array('ThemeOptions','flexslider_options') );
//           add_submenu_page( 'theme_menu','Marquee Options', __('Marquee', 'tcc'), 'manage_options', 'theme_menu3', array('ThemeOptions','marquee_options'));
//      }
//      /* 載入主題 */
//      static function theme_activation(){
//          if($GLOBALS['pagenow'] != 'themes.php' || !isset($_GET['activated']))
//              return;
//          wp_redirect(admin_url('admin.php?page=theme_menu')); //進入後台主題選單
//          die;
//      }

//      /* 主題選項 */
//      static function theme_options() {
//           if (!current_user_can('manage_options')) {
//                wp_die(__('You do not have sufficient permissions to access this page.' ));
//           }
//           $options = ThemeOptions::getOptions();
//           echo '<script src="'.get_template_directory_uri().'/js/function_theme_options.js"></script>';
//           echo '<div class="wrap">
//                <h1>主題管理頁面</h1>

//                <form method="post" name="form" id="form">
//                ';
//           echo '<p><div id="footer_list"><h3>底部資訊:</h3>';
//                for ($i = 0; $i < count($options['footer']['zh']); $i++) {
//                     echo '<input type="text" name="footer[]" value="'.$options['footer']['zh'][$i].'"/><input type="text" name="footer_en[]" value="'.$options['footer']['en'][$i].'"/><br />';
//                }
//                echo '<input type="text" name="footer[]" /><input type="text" name="footer_en[]" /><br /></div><input type="button" id="add_footer" name="add_footer" value="增加項目" /></p>';
//           wp_nonce_field('update-options');
//           echo '<input type="hidden" name="action" value="update" />
//                <input type="hidden" name="page_options" value="logo" />
//                <p class="submit">
//                     <input type="submit" name="option_save" value="'.__('Save Settings','tcc').'" />
//                </p>
//           </form>
//           </div>';
//           // 顯示變數
//           echo '<pre>';
//           var_dump($options);
//           echo '</pre>';
//      }

//      /* 圖片牆選項 */
//      static function flexslider_options() {
//           if (!current_user_can( 'manage_options' ))  {
//                wp_die(__('You do not have sufficient permissions to access this page.' ) );
//           }
//           $options = ThemeOptions::getOptions();
//           echo '<script src="'.get_template_directory_uri().'/js/function_theme_options.js"></script>';

//           echo '<div class="wrap">
//                <h1>' . __('Setting the FlexSlider images', 'tcc') . '</h1>
//                <form method="post" name="form" id="form">
//                <p>
//                <div id="flex_list"><h3>FlexSlider圖片:</h3>';
//                for ($i = 0; $i < count($options['flex']['zh']); $i++) {
//                     echo '<input type="text" name="flex[]" value="' . $options['flex']['zh'][$i] . '"/>
//                     <input type="text" name="flex_en[]" value="'.$options['flex']['en'][$i].'"/><br />';
//                }
//                echo '<input type="text" name="flex[]"/>
//                <input type="text" name="flex_en[]"/><br />
//                </div>
//                <input type="button" id="add_flex" name="add_flex" value="增加項目" />
//                </p>';
//           wp_nonce_field('update-options');
//           echo '<input type="hidden" name="action" value="update" />
//                <input type="hidden" name="page_options" value="logo" />
//                <p class="submit">
//                     <input type="submit" name="option_save" value="'.__('Save Settings','tcc').'" />
//                </p>
//                </form>
//                </div>';
//      }

//      /* 跑馬燈選項 */
//      static function marquee_options() {
//           if (!current_user_can('manage_options'))  {
//                wp_die(__('You do not have sufficient permissions to access this page.'));
//           }
//           $options = ThemeOptions::getOptions();
//           echo '<script src="' . get_template_directory_uri() . '/js/function_theme_options.js"></script>';

//           echo '<div class="wrap">
//                <h1>' . __('Setting the marquee message','tcc') . '</h1>
//                <form method="post" name="form" id="form">
//                <p><div id="marquee_list"><h3>跑馬燈訊息:</h3>';
//                for ($i = 0; $i < count($options['marquee']['zh']); $i++) {
//                     echo '<input type="text" name="marquee[]" value="' . $options['marquee']['zh'][$i] . '"/><input type="text" name="marquee_en[]" value="' . $options['marquee']['en'][$i] . '"/><br />';
//                }
//                echo '<input type="text" name="marquee[]"/><input type="text" name="marquee_en[]"/><br /></div><input type="button" id="add_marquee" name="add_marquee" value="增加項目" /></p>';
//           wp_nonce_field('update-options');
//           echo '<input type="hidden" name="action" value="update" />
//                <input type="hidden" name="page_options" value="logo" />
//                <p class="submit">
//                     <input type="submit" name="option_save" value="' . __('Save Settings','tcc') . '" />
//                </p>
//           </form>
//           </div>';
//      }
// }
// add_action('admin_menu', array('ThemeOptions', 'init'));
// add_action('load-themes.php', array('ThemeOptions', 'theme_activation'));
