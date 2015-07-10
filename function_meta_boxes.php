<?
/* 文章相關參數 */

/**
 * 編輯文章時，呼叫文章參數設定。
 */
function call_MetaBoxes() {
    new Expiration(); //文章過期
    new Redirect(); //文章重導向
}
if (is_admin()) {
    add_action('load-post.php', 'call_MetaBoxes');
    add_action('load-post-new.php', 'call_MetaBoxes');
}

/** 
 * 文章過期時間設定函式
 */
class Expiration {
    /**
     * 建構子，掛上對應動作
     */
    public function __construct() {
        add_action('add_meta_boxes', array($this, 'add'));
        add_action('save_post', array($this, 'save'));
    }

    /**
     * 定義文章相關參數變數
     */
    public function add($post_type) {
        $post_types = array('post', 'page'); //限制文章相關參數適用文章類型
        if (in_array($post_type, $post_types)) {
            add_meta_box(
                'expiration',//前台頁面ID
                __('expiration', 'tcc'),//顯示的標題
                array($this, 'render'),
                $post_type,//可以使用的文章類型'post','page','dashboard','link','attachment','custom_post_type','comment' 
                'side',//輸入方塊位置'normal' , 'advanced' , 'side'
                'high'//優先權'high', 'core', 'default', 'low'
            );
        }
    }

    /**
     * 給予Meta Box內容.
     *
     * @param WP_Post $post 文章物件.
     */
    public function render($post) {
    
        // Add an nonce field so we can check for it later.
        wp_nonce_field( 'expiration_custom_box', 'expiration_custom_box_nonce' );

        // Use get_post_meta to retrieve an existing value from the database.
        $expiration = get_post_meta($post->ID, '_expiration', true);
        $expiration_date = date_format(date_create($expiration), 'Y-m-d');
        $expiration_time = date_format(date_create($expiration), 'H:i');
        // Display the form, using the current value.
        echo '<label for="expiration_date">' . __('Enter the expiration date of the post or page.', 'tcc' ) . '</label><br/>';
        echo '<input type="date" id="expiration_date" name="expiration_date" value="' . (($expiration != '') ? esc_attr($expiration_date) : '') . '" size="25" /><br/>';
        
        // Display the form, using the current value.
        echo '<label for="expiration_time">' . __('Enter the expiration time of the post or page.', 'tcc' ) . '</label><br/>';
        echo '<input type="time" id="expiration_time" name="expiration_time" value="' . (($expiration != '') ? esc_attr($expiration_time) : '') . '" size="25" /><br/>';
    }
    /**
     * 儲存文章時，儲存文章參數設定。
     *
     * @param int $post_id 儲存文章的文章ID
     */
    public function save($post_id) {
    
        /*
         * We need to verify this came from the our screen and with proper authorization,
         * because save_post can be triggered at other times.
         */
        
        // Check if our nonce is set.
        if ( ! isset( $_POST['expiration_custom_box_nonce'] ) )
            return $post_id;

        $nonce = $_POST['expiration_custom_box_nonce'];

        // Verify that the nonce is valid.
        if ( ! wp_verify_nonce( $nonce, 'expiration_custom_box' ) )
            return $post_id;

        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
            return $post_id;

        // Check the user's permissions.
        if ( 'page' == $_POST['post_type'] ) {
            if ( ! current_user_can( 'edit_page', $post_id ) )
                return $post_id;
        } else {
            if ( ! current_user_can( 'edit_post', $post_id ) )
                return $post_id;
        }

        /* OK, its safe for us to save the data now. */

        // Sanitize the user input.
        $expiration_date = (($_POST['expiration_date'] == '') && ($_POST['expiration_time'] != '')) ? date_format(date(), "Y-m-d") : $_POST['expiration_date'];//預設為當天
        $expiration_time = (($_POST['expiration_time'] == '') && ($_POST['expiration_date'] != '')) ? '00:00' : $_POST['expiration_time'];//預設00:00
        // Update the meta field.
        update_post_meta($post_id, '_expiration', date_format(date_create($expiration_date . " " . $expiration_time . ":00"), 'Y/m/d H:i:s'));
    }
}


/** 
 * 重定址函式
 */
class Redirect {
    /**
     * 建構子，掛上對應動作
     */
    public function __construct() {
        add_action('add_meta_boxes', array($this, 'add'));
        add_action('save_post', array($this, 'save'));
    }

    /**
     * 定義文章相關參數變數
     */
    public function add($post_type) {
        $post_types = array('post', 'page'); //限制文章相關參數適用文章類型
        if (in_array($post_type, $post_types)) {
            add_meta_box(
                'redirect',//前台頁面ID
                __('redirect', 'tcc'),//顯示的標題
                array($this, 'render'),
                $post_type,//可以使用的文章類型'post','page','dashboard','link','attachment','custom_post_type','comment' 
                'side',//輸入方塊位置'normal' , 'advanced' , 'side'
                'high'//優先權'high', 'core', 'default', 'low'
            );
        }
    }

    /**
     * 給予Meta Box內容.
     *
     * @param WP_Post $post 文章物件.
     */
    public function render($post) {
    
        // Add an nonce field so we can check for it later.
        wp_nonce_field( 'redirect_custom_box', 'redirect_custom_box_nonce' );

        // Use get_post_meta to retrieve an existing value from the database.
        $redirect = get_post_meta($post->ID, '_redirect', true);
        // Display the form, using the current value.
        echo '<label for="redirect">' . __('Enter the redirect URL of the post or page.', 'tcc' ) . '</label><br/>';
        echo '<input type="url" id="redirect" name="redirect" value="' . (($redirect != '') ? esc_attr($redirect) : '') . '" size="25" /><br/>';

        // Use get_post_meta to retrieve an existing value from the database.
        $redirect_target = get_post_meta($post->ID, '_redirect_target', true);
        // Display the form, using the current value.
        echo '<label for="redirect_target">' . __('Enter the redirect target of the post or page.', 'tcc' ) . '</label><br/>';
        echo '<input type="text" id="redirect_target" name="redirect_target" value="' . (($redirect_target != '') ? esc_attr($redirect_target) : '') . '" size="25" /><br/>';
    }
    /**
     * 儲存文章時，儲存文章參數設定。
     *
     * @param int $post_id 儲存文章的文章ID
     */
    public function save($post_id) {
    
        /*
         * We need to verify this came from the our screen and with proper authorization,
         * because save_post can be triggered at other times.
         */
        // Check if our nonce is set.
        if ( ! isset( $_POST['redirect_custom_box_nonce']))
            return $post_id;

        $nonce = $_POST['redirect_custom_box_nonce'];

        // Verify that the nonce is valid.
        if ( ! wp_verify_nonce($nonce, 'redirect_custom_box'))
            return $post_id;

        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
            return $post_id;

        // Check the user's permissions.
        if ('page' == $_POST['post_type']) {
            if (! current_user_can('edit_page', $post_id))
                return $post_id;
        } else {
            if (! current_user_can('edit_post', $post_id))
                return $post_id;
        }

        /* OK, its safe for us to save the data now. */

        // Sanitize the user input.
        $redirect = $_POST['redirect'];
        $redirect_target = $_POST['redirect_target'];
        // Update the meta field.
        update_post_meta($post_id, '_redirect', $redirect);
        update_post_meta($post_id, '_redirect_target', $redirect_target);
    }
}


add_filter('manage_posts_columns', 'columns');
add_filter('manage_pages_columns', 'columns');
add_action('manage_posts_custom_column', 'custom_columns', 5, 2);
add_action('manage_pages_custom_column', 'custom_columns', 5, 2);

function columns($columns) {
    return array_merge(
        $columns, 
        array(
            'expiration' => __('Expiration', 'tcc'),
            'redirect' => __('Redirect', 'tcc')
        )
    );
}
function custom_columns($column, $post_id) {
    if ($column === 'expiration') {
        echo get_post_meta($post_id, '_expiration', true);
    } else if ($column === 'redirect') {
        echo get_post_meta($post_id, '_redirect', true);
    }
}
