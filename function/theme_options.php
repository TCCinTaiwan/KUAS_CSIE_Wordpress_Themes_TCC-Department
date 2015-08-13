<?
# TCC-Department
# Copyright (C) 2014 - 2015  TCC - john987john987@gmail.com
# This program is distributed under the terms and conditions of the GPL
# See the README and LICENSE files for details

# --------------------------------------------------------
# $Id: function_theme_options.php,v 1.000 2015/07/25 16:46 TCC Exp $
# --------------------------------------------------------

/**
 * 後臺主題選單類別
 *        後臺主題選單相關的方法
 *
 *   @author TCC
 *   @version v1.000
 */
class ThemeOptions {

     /**
      *  初始化
      *        儲存主題選項到資料庫，
      *
      *   @access Public
      *   @author TCC
      *   @version v1.000
      */
     static public function init() {
          if(isset($_POST['option_save'])) {
               $options = ThemeOptions::getOptions();
               $languages_list = ThemeOptions::get_languages_list();
               foreach ($languages_list as $language) {
                    foreach ($options[$language] as $page_key => $page_fileds) {
                         foreach ($page_fileds as $filed_key => $filed_values) {
                              //跨語言
                              $post_name = $page_key . '_' . $filed_key;
                              $post_name .= (isset($_POST[$post_name]) ? '' : '_' . $language) ;
                              if (isset($_POST[$post_name])) {
                                   $post_array = array_filter($_POST[$post_name]);
                                   $options[$language][$page_key][$filed_key] = Array();
                                   foreach ($post_array as $post_item) {
                                        $options[$language][$page_key][$filed_key][] = $post_item;
                                   }
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

     /**
      *  載入主題
      *        安裝完後，導向主題設定主頁。
      *
      *   @access Public
      *   @return void
      *   @author TCC
      *   @version v1.000
      */
     static public function  theme_activation() {
         if($GLOBALS['pagenow'] != 'themes.php' || !isset($_GET['activated']))
             return;
         wp_redirect(admin_url('admin.php?page=theme_menu')); //進入後台主題選單
         die;
     }

     /**
      *  取得主題變數
      *        取得資料庫中主題變數的值，假如不存在，就初始化該值。
      *
      *   @access Public
      *   @return Array
      *   @author TCC
      *   @version v1.000
      */
     static public function  getOptions() {
          $options = get_option('theme_tcc_options');
          #$options = NULL; //清除用：$options = NULL;
          if (!is_array($options)) {
               $languages_list = ThemeOptions::get_languages_list();
               foreach ($languages_list as $language) {
                    $options[$language] = Array(
                         'footer' => Array(
                              'info' => Array()
                         ),
                         'marquee' => Array(
                              'message' => Array()
                         ),
                         'flex' => Array(
                              'title' => Array(),
                              'image' => Array(),
                              'style' => Array(),
                         )
                    );
               }
          }
          return $options;
     }

     /**
      *  取得支援的語言清單
      *        取得Polylang設定的支援語言清單。
      *
      *   @access Public
      *   @return Array
      *   @author TCC
      *   @version v1.000
      */
     static public function  get_languages_list() { 
          $languages_list = Array();
          $transient_pll_languages_list = get_option('_transient_pll_languages_list');
          foreach ($transient_pll_languages_list as $language) {
               $languages_list[$language['locale']] = $language['locale'];
          }
          return $languages_list;
     }

     /**
      *  取得指定支援的語言名字
      *        輸入語言代碼，回傳該語言的名字。
      *
      *   @access Public
      *   @param string $lang
      *   @return mixed 假如有找到回傳名字，沒找到回傳NULL。
      *   @author TCC
      *   @version v1.000
      */
     static public function  get_language_name($lang = 'zh_TW') {
          $transient_pll_languages_list = get_option('_transient_pll_languages_list');
          foreach ($transient_pll_languages_list as $language) {
               if ($language['locale'] == $lang) return $language['name'];
          }
          return NULL;
     }

     /**
      *  顯示主題設定頁面
      *        依照參數顯示不同設定頁面。
      *
      *   @access Public
      *   @param string $page
      *   @param bool $display_debug 是否顯示$pages於網頁。
      *   @var array $pages 各設定頁面內容
      *   @author TCC
      *   @version v1.000
      */
     //已知Bug：輸入項目不能留白，不然會對不到!!!!!!
     static public function  show_page($page, $display_debug = false) {
          if (!current_user_can('manage_options')) {
               wp_die(__('You do not have sufficient permissions to access this page.' ));
          }
          $options = ThemeOptions::getOptions();
          $pages = Array(
               'theme_options' => Array(
                    'title' => __('Theme Options', 'tcc'),
                    'id' => 'footer',
                    'fileds' => Array(
                         Array(
                              'title' => __('Footer Info', 'tcc'),
                              'id' => 'info',
                              'lang' => true,
                              'type' => 'text'
                         )
                    )
               ),
               'marquee_options' => Array(
                    'title' => __('Setting the marquee message', 'tcc'),
                    'id' => 'marquee',
                    'fileds' => Array(
                         Array(
                              'title' => __('Marquee Message:', 'tcc'),
                              'id' => 'message',
                              'lang' => true,
                              'type' => 'text'
                         )
                    )
               ),
               'flexslider_options' => Array(
                    'title' => __('Setting the FlexSlider contents', 'tcc'),
                    'id' => 'flex',
                    'fileds' => Array(
                         Array(
                              'title' => __('FlexSlider Title', 'tcc'),
                              'id' => 'title',
                              'lang' => true,
                              'type' => 'text'
                         ),
                         Array(
                              'title' => __('FlexSlider Image', 'tcc'),
                              'id' => 'image',
                              'lang' => true,
                              'type' => 'text'
                         ),
                         Array(
                              'title' => __('FlexSlider Style', 'tcc'),
                              'id' => 'style',
                              'type' => 'select',
                              'lang' => false,
                              'options' => Array(
                                   'style1' => __('Style 1', 'tcc'),
                                   'style2' => __('Style 2', 'tcc')
                              )
                         )
                    )
               )
          );
          $page = $pages[$page]; //指定頁面
          // JavaScript產生
          echo '<script>
               jQuery(document).ready(function() {jQuery("#add_' . $page['id'] . '").click(function() {jQuery("#' .  $page['id'] . '_list > tr:last").after(\'<tr>';
               foreach ($page['fileds'] as $filed_key => $filed) {
                    echo '<td>';
                    if ($filed['lang']) {
                         foreach ($options as $option_key => $option) {
                              echo '<label>' . ThemeOptions::get_language_name($option_key) . '   </label>';
                              echo ThemeOptions::input_boxs($filed['type'], $page['id'] . '_' . $filed['id'] . '_' . $option_key, '', $filed['options']);
                         }
                    } else {
                         echo ThemeOptions::input_boxs($filed['type'], $page['id'] . '_' . $filed['id'] . '_' . $option_key, '', $filed['options']);
                    }
                    echo '</td>';
               }
               echo '</tr>\');});});
          </script>';
          // CSS 產生
          echo '<style type="text/css">
          .tcc-theme-list-table td {
               vertical-align: middle;
          }
          .tcc-theme-list-table td > label {
               min-width: 100px;
               display: inline-block;
          }
          .tcc-theme-list-table td > input {
               min-width: 90%;
               display: inline-block;
          }
          </style>';

          echo '<div class="wrap"><h1>' . $page['title'] . '</h1><form method="post" name="form" id="form">';

          echo '<div class="tablenav top">
               <div class="alignleft actions bulkactions">
                    <input type="submit" name="option_save" class="button action"  value="' . __('Save Settings','tcc') . '">
                    <input type="button" name="import" class="button"  value="' . __('Import','tcc') . '">
                    <input type="button" name="export" class="button"  value="' . __('Export','tcc') . '">
               </div>
          </div>
          <table class="wp-list-table widefat fixed striped tcc-theme-list-table">
               <thead>
                    <tr>';
               foreach ($page['fileds'] as $filed_key => $filed) {
                    echo '<th scope="col" id="' . $filed['id'] . '" class="manage-column column-name">' . $filed['title'] . '</th>';
               }
               echo '</tr>
               </thead>
               <tbody id="' .  $page['id'] . '_list">';
               for ($i = 0; $i < count($options[get_locale()][$page['id']][$page['fileds'][0]['id']]); $i++) {
                    echo '<tr>';
                    foreach ($page['fileds'] as $filed_key => $filed) {
                         echo '<td>';
                         if ($filed['lang']) {//!!!可以多判斷是否已有設定語言
                              foreach ($options as $option_key => $option) {
                                   echo '<label>' . ThemeOptions::get_language_name($option_key) . '   </label>';
                                   echo ThemeOptions::input_boxs($filed['type'], $page['id'] . '_' . $filed['id'] . '_' . $option_key, $option[$page['id']][$filed['id']][$i], $filed['options']);
                                   
                              }
                         } else {
                              echo ThemeOptions::input_boxs($filed['type'], $page['id'] . '_' .  $filed['id'], $options[get_locale()][$page['id']][$filed['id']][$i], $filed['options']);
                         }
                         echo '</td>';
                    }
                    echo '</tr>';
               }
               echo '<tr>';
               foreach ($page['fileds'] as $filed_key => $filed) {
                    echo '<td>';
                    if ($filed['lang']) {
                         foreach ($options as $option_key => $option) {
                              echo '<label>' . ThemeOptions::get_language_name($option_key) . '   </label>';
                              echo ThemeOptions::input_boxs($filed['type'], $page['id'] . '_' . $filed['id'] . '_' . $option_key, '', $filed['options']);
                         }
                    } else {
                         echo ThemeOptions::input_boxs($filed['type'], $page['id'] . '_' . $filed['id'] . '_' . $option_key, '', $filed['options']);
                    }
                    echo '</td>';
               }
               echo '</tr>
          </tbody>
               <tfoot>
                    <tr>
                         ';
               foreach ($page['fileds'] as $filed_key => $filed) {
                    echo '<th scope="col" id="name" class="manage-column column-name">' . $filed['title'] . '</th>';
               }
               echo '                   
                    </tr>
               </tfoot>
          </table>
          <div class="tablenav bottom">
               <div class="alignleft actions bulkactions">
                    <input type="submit" name="option_save" class="button action"  value="' . __('Save Settings','tcc') . '"><input type="button" id="add_' .  $page['id'] . '" class="button"  value="' . __('Additional Items','tcc') . '">
               </div>
          </div>';

          wp_nonce_field('update-options');
          echo '<input type="hidden" name="action" value="update" />
               <input type="hidden" name="page_options" value="logo" />
          </form></div>';

          ThemeOptions::MCE_Editer();//MCE Editer

          // 顯示變數，方便DEBUG
          if ($display_debug) {
               echo '<pre>';
               var_dump($options);
               echo '</pre>';
          }
     }

     /**
      *  MCE編輯器
      *        顯示編輯器。
      *
      *   @access Public
      *   @author TCC
      *   @version v1.000
      */
     static public function MCE_Editer()
     {
          $editor_id = 'content';
          $content = '';
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
          wp_editor($content, $editor_id, $settings = array());
     }

     /**
      *  產生輸入框陣列
      *        依照傳入的值，回傳欲顯示的輸入框。
      *
      *   @access Public
      *   @param string $type 輸入框類型
      *   @param string $name 輸入框陣列名字，即post接收到的變數名。
      *   @param string $value 輸入框內的值，即預設值或變數當下的值。
      *   @param array $args select的選項陣列
      *   @return string
      *   @author TCC
      *   @version v1.000
      */
     static public function input_boxs($type = 'text', $name = '',$value = '',$args = '') {
          switch ($type) {
               case 'text':
                    return '<input type="text" name="' . $name . '[]" value="' . $value . '"/>';
               case 'select':
                    $output = '<select name="' . $name . '[]">';
                    foreach ($args as $arg_key => $arg_value) {
                         $output .= $value .'<option value="' . $arg_key . '"' . (($value == $arg_key) ? ' selected' : '') . '>' . $arg_value . '</option>';
                    }
                    $output .= '</select>';
                    return $output;
          }
     }

     /**
      *  主題選項
      *        呼叫顯示主題設定頁。
      *
      *   @access Public
      *   @author TCC
      *   @version v1.000
      */
     static public function theme_options() {
          ThemeOptions::show_page('theme_options', true);
     }

     /**
      *  圖片牆選項
      *        呼叫顯示圖片牆設定頁。
      *
      *   @access Public
      *   @author TCC
      *   @version v1.000
      */
     static public function  flexslider_options() {
          ThemeOptions::show_page('flexslider_options');
     }

     /**
      *  跑馬燈選項
      *        呼叫顯示跑馬燈設定頁。
      *
      *   @access Public
      *   @author TCC
      *   @version v1.000
      */
     static public function  marquee_options() {
          ThemeOptions::show_page('marquee_options');
     }
}
add_action('admin_menu', array('ThemeOptions', 'init'));
add_action('load-themes.php', array('ThemeOptions', 'theme_activation'));