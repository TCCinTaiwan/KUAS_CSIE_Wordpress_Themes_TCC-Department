<?
class Plugins {
    /* 必要插件提示 */
    function plugins_messages(){
        $plugin_messages = array();
        include_once(ABSPATH . 'wp-admin/includes/plugin.php' );

        if(is_plugin_inactive('polylang/polylang.php')) {
            // if (is_plugin_page('polylang/polylang.php')) {
            //     $plugin_messages[] = '當前主題要求必須啟用 Polylang 插件';
            // } else {
            $plugin_messages[] = '當前主題要求必須安裝 Polylang 插件，<a href="' . admin_url() . '/plugin-install.php?tab=plugin-information&plugin=polylang&TB_iframe=true" class="thickbox">下載插件2</a>';
            // }
        }
        if(is_plugin_inactive( 'cool-tag-cloud/cool-tag-cloud.php' )) {
            // if (is_plugin_page('cool-tag-cloud/cool-tag-cloud.php')) {
            //     // activate_plugins( 'cool-tag-cloud/cool-tag-cloud.php' );
            //     $plugin_messages[] = '當前主題要求必須啟用 Cool Tag Cloud 插件';
            // } else {
            $plugin_messages[] = '當前主題要求必須安裝 Cool Tag Cloud 插件，<a href="' . admin_url() . '/plugin-install.php?tab=plugin-information&plugin=cool-tag-cloud&TB_iframe=true" class="thickbox">下載插件</a>';
            // }
        }
        if( count( $plugin_messages ) > 0 ){
            echo '<div id="message" class="error">';
                foreach( $plugin_messages as $message ) echo '<p><strong>' . $message . '</strong></p>';
            echo '</div>';
        }
    }
}
add_action('admin_notices', array('Plugins', 'plugins_messages'));
