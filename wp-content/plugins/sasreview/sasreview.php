<?php
/**
 * Classic Editor
 *
 * Plugin Name: Sas review
 * Plugin URI:  https://github/fendnasas.com
 * Description: My plugin
 * Version:     1.0
 * Author:      Sergey
 * Author URI:  https://github/fendnasas.com
 * Text Domain: sasreview
 */

//делает так чтоб функцию мог вызвать только вордпресс
if (!defined('ABSPATH')) {
    die;
}

class SasReview{

    public function register(){

        add_action('init', [$this, 'custom_post_type']);

        //вызываю метод для подключения css and js
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_front']);

        //Load template подгружаю свою страничку
        add_filter('template_include', [$this,'review_template']);

        // подключаю меню для админа
        add_action('admin_menu', [$this, 'add_admin_menu']);

        // подключаем ссылку на настройки в описании
        add_filter('plugin_action_links_'.plugin_basename(__FILE__),[$this, 'add_plugin_settings_link']);

        add_action('admin_init',[$this,'setting_init']);

//        _________________________
        add_filter('comment_form_default_fields', [$this,'extend_comment_custom_default_fields']);

        add_action( 'comment_form_logged_in_after', [$this,'extend_comment_custom_fields'] );
        add_action( 'comment_form_after_fields', [$this,'extend_comment_custom_fields']);

        add_action( 'comment_post', [$this,'save_extend_comment_meta_data'] );

        add_filter( 'preprocess_comment', [$this,'verify_extend_comment_meta_data'] );

        add_filter( 'comment_text', [$this,'modify_extend_comment']);

        add_action( 'wp_enqueue_scripts', [$this,'check_count_extend_comments'] );

        add_action( 'add_meta_boxes_comment', [$this,'extend_comment_add_meta_box']);

        add_action( 'edit_comment', [$this,'extend_comment_edit_meta_data'] );
//        _________________________
    }

    static function activation()
    {
        flush_rewrite_rules();

    }
    static function deactivation (){
        flush_rewrite_rules();
    }


    //метод для подключения css and js файлов
    public function enqueue_admin(){
        wp_enqueue_script('jquery');
        wp_enqueue_style('sasReviewStyle', plugins_url('/assets/admin/styles.css', __FILE__));
        wp_enqueue_script('sasReviewScript', plugins_url('/assets/admin/scripts.js', __FILE__));
    }

    //метод для подключения css and js файлов
    public function enqueue_front(){
        wp_enqueue_script('jquery');
        wp_enqueue_style('sasReviewStyle', plugins_url('/assets/front/styles.css', __FILE__));
        wp_enqueue_script('sasReviewScript', plugins_url('/assets/front/scripts.js', __FILE__));
    }


    // добавляю админское меню для плагина
    public function add_admin_menu(){
        add_menu_page(
            esc_html__('Sasreview Settings Page', 'sasreview'),
            esc_html__('Sasreview', 'sasreview'),
            'manage_options',
            'sasreview_settings',
            [$this, 'sasreview_page'],
            'dashicons-twitch',
            100
        );
    }

    //Добавляю в описание плагина ссылку на настройки
    public function add_plugin_settings_link($link){
        $custom_link = '<a href="admin.php?page=sasreview_settings">'.esc_html__('Settings', 'sasplugin').'</a>';
        array_push($link, $custom_link);
        return $link;
    }

    //Sasplugin Admin HTML
    public function sasreview_page(){
        require_once plugin_dir_path(__FILE__).'admin/admin.php';
    }

    function custom_post_type()
    {
        register_post_type('saspost',
            [
                'public' => true,
                'has_archive' => true,
                'rewrite' => ['slug' => 'sasposts'],//меняем названеи ссылки
                'label' => esc_html__('SasPost', 'sasreview'),
                'supports' => ['title', 'editor', 'thumbnail']
            ]
        );
    }

    public function setting_init(){
        register_setting('plugin_settings','review_settings_options');

        add_settings_section('saspreview_settings_section', esc_html__('Settings','sasreview'), [$this, 'settings_section_html'],'sasreview_settings');

        add_settings_field('posts_per_page', esc_html__('Posts per page','sasreview'), [$this, 'posts_per_page_html'], 'sasreview_settings', 'sasplugin_settings_section');

        //add_settings_field('title_for_rooms', esc_html__('Archive page title','sasplugin'), [$this, 'title_for_rooms_html'], 'sasplugin_settings', 'sasplugin_settings_section');

    }


    //Settings section html
    public function settings_section_html(){
        echo esc_html__("Hello, my plugin!", 'sasreview');

    }

    //Settings fields HTML
    public function posts_per_page_html(){
        $options = get_option('saspreview_settings_section'); ?>

        <input type="text" name="sasplugin_settings_options[posts_per_page]" value="<?php echo isset($options['posts_per_page']) ? $options['posts_per_page'] : "";  ?>" />

        <?php

    }

    //Проверяю есть ли стозднанная страница пользователем если нету то подгружаю свою,
    // метод вызываю этот метод в register.
    public function review_template($template){

        if(is_post_type_archive('saspost')){
            $theme_files = ['archive-review.php','saspreview/archive-review.php'];
            $exist = locate_template( $theme_files, false);
            if($exist != ''){
                return $exist;
            } else {
                return plugin_dir_path(__FILE__).'templates/archive-review.php';
            }
        }
        return $template;
    }
//    --------------------review-start-------------------------------------
//изменяю стандартыне поля и добавлю поле телефон для не зарегистрированных пользователей
    function extend_comment_custom_default_fields($fields) {

        $commenter = wp_get_current_commenter();
        $req = get_option( 'require_name_email' );
        $aria_req = ( $req ? " aria-required='true'" : '' );
//Автор
        $fields[ 'author' ] = '<p class="comment-form-author">'.
            '<label for="author">' . __( 'Name' ) . '</label>'.
            ( $req ? '<span class="required">*</span>' : '' ).
            '<input id="author" name="author" type="text" value="'. esc_attr( $commenter['comment_author'] ) .
            '" size="30" tabindex="1"' . $aria_req . ' /></p>';
// Емаил
        $fields[ 'email' ] = '<p class="comment-form-email">'.
            '<label for="email">' . __( 'Email' ) . '</label>'.
            ( $req ? '<span class="required">*</span>' : '' ).
            '<input id="email" name="email" type="text" value="'. esc_attr( $commenter['comment_author_email'] ) .
            '" size="30"  tabindex="2"' . $aria_req . ' /></p>';

        $fields[ 'url' ] = '<p class="comment-form-url">'.
            '<label for="url">' . __( 'Website' ) . '</label>'.
            '<input id="url" name="url" type="text" value="'. esc_attr( $commenter['comment_author_url'] ) .
            '" size="30"  tabindex="3" /></p>';
// Телефон
        $fields[ 'phone' ] = '<p class="comment-form-phone">'.
            '<label for="phone">' . __( 'Phone' ) . '</label>'.
            '<input id="phone" name="phone" type="text" size="30"  tabindex="4" /></p>';

        return $fields;
    }
// функция с отзывами и оценкой
// этот вызов функции показыва для зарегистрированного пользователя
//add_action( 'comment_form_logged_in_after', 'extend_comment_custom_fields' );
// если пользовательн не зарегистрирован то сработает эта функция и выведутся поля и для регистраци
//add_action( 'comment_form_after_fields', 'extend_comment_custom_fields' );
    function extend_comment_custom_fields() {



        echo '<p class="comment-form-title">'.
            '<label for="title">' . __( 'Comment Title' ) . '</label>'.
            '<input id="title" name="title" type="text" size="30"/></p>';

        echo '<p class="comment-form-rating">'.
            '<label for="rating">'. __('Rating') . '<span class="required">*</span></label>
			  <span class="commentratingbox">';
// цикл для радио кнопок
        for( $i=1; $i <= 5; $i++ ){
            echo '
		<label class="commentrating" style="display:inline-block;">
			<input type="radio" name="rating" id="rating" value="'. $i .'"/> '. $i .'   
		</label>';
        }

        echo'</span></p>';
    }
// функция для сохранения полей
    function save_extend_comment_meta_data( $comment_id ){

        if( !empty( $_POST['phone'] ) ){
            $phone = sanitize_text_field($_POST['phone']);
            add_comment_meta( $comment_id, 'phone', $phone );
        }

        if( !empty( $_POST['title'] ) ){
            $title = sanitize_text_field($_POST['title']);
            add_comment_meta( $comment_id, 'title', $title );
        }

        if( !empty( $_POST['rating'] ) ){
            $rating = intval($_POST['rating']);
            add_comment_meta( $comment_id, 'rating', $rating );
        }

    }

    // Проверяем, заполнено ли поле "Рейтинг"
//add_filter( 'preprocess_comment', 'verify_extend_comment_meta_data' );
    function verify_extend_comment_meta_data( $commentdata ) {

        // ничего не делаем если это ответ на комментарий
        if ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] === 'replyto-comment' ) {
            return $commentdata;
        }

        if ( empty( $_POST['rating'] ) || ! (int)$_POST['rating'] ) {
            wp_die( __( 'Error: You did not add a rating. Hit the Back button on your Web browser and resubmit your comment with a rating.' ) );
        }

        return $commentdata;
    }

    // отображаем звезды на фронте использую стандартные звезды вродпресс wp_star_rating
    function modify_extend_comment( $text ){
        global $post;

        if( $commenttitle = get_comment_meta( get_comment_ID(), 'title', true ) ) {
            $commenttitle = '<strong>' . esc_attr( $commenttitle ) . '</strong><br/>';
            $text = $commenttitle . $text;
        }

        if( $commentrating = get_comment_meta( get_comment_ID(), 'rating', true ) ) {

            $commentrating = wp_star_rating( array (
                'rating' => $commentrating,
                'echo'=> false
            ));

            $text = $text . $commentrating;
        }

        return $text;
    }

    //подключаю  wp_star_rating и шифты
    // проверяем есть ли у поста коменты и если есть подключаем функцию
//add_action( 'wp_enqueue_scripts', 'check_count_extend_comments' );
    function check_count_extend_comments(){
        global $post;

        if( isset($post) && (int)$post->comment_count > 0 ){
            require_once ABSPATH .'wp-admin/includes/template.php';
            add_action('wp_enqueue_scripts', function(){
                wp_enqueue_style('dashicons');
            });

            $stars_css = '
		.star-rating .star-full:before { content: "\f155"; }
		.star-rating .star-empty:before { content: "\f154"; }
		.star-rating .star {
			color: #0074A2;
			display: inline-block;
			font-family: dashicons;
			font-size: 20px;
			font-style: normal;
			font-weight: 400;
			height: 20px;
			line-height: 1;
			text-align: center;
			text-decoration: inherit;
			vertical-align: top;
			width: 20px;
		}
		';

            wp_add_inline_style( 'dashicons', $stars_css );
        }

    }

//add_action( 'add_meta_boxes_comment', 'extend_comment_add_meta_box' );
    function extend_comment_add_meta_box(){
        add_meta_box( 'title', __( 'Comment Metadata - Extend Comment' ), 'extend_comment_meta_box', 'comment', 'normal', 'high' );
    }

// Отображаем наши поля
    function extend_comment_meta_box( $comment ){
        $phone  = get_comment_meta( $comment->comment_ID, 'phone', true );
        $title  = get_comment_meta( $comment->comment_ID, 'title', true );
        $rating = get_comment_meta( $comment->comment_ID, 'rating', true );
//                     получаем данные полей
        //wp_nonce_field() выводит проверочное (защитное, одноразовое)
        // скрытое поле для формы, повышая безопасность
        wp_nonce_field( 'extend_comment_update', 'extend_comment_update', false );
        ?>
            //Очищает содержимое метаполей с помощью esc_attr() и выводит на экран.
        Ничего не проверяет. Если данных нет, то поле будет пустое.
        <p>
            <label for="phone"><?php _e( 'Phone' ); ?></label>
            <input type="text" name="phone" value="<?php echo esc_attr( $phone ); ?>" class="widefat" />
        </p>
        <p>
            <label for="title"><?php _e( 'Comment Title' ); ?></label>
            <input type="text" name="title" value="<?php echo esc_attr( $title ); ?>" class="widefat" />
        </p>
        <p>
            <label for="rating"><?php _e( 'Rating: ' ); ?></label>
            <span class="commentratingbox">
		<?php
        for( $i=1; $i <= 5; $i++ ){
            echo '
		  <span class="commentrating">
			<input type="radio" name="rating" id="rating" value="'. $i .'" '. checked( $i, $rating, 0 ) .'/>
		  </span>';
        }
        ?>
		</span>
        </p>
        <?php
    }

    //сохраням мета поля в админке
    //Проверим nonce-код и если проверка не пройдет - остановим выполнение функции.
    //
    //Проверим переданные данные по каждому полю и если у какого-то поля его нет
    // - удалим само метаполе, чтобы не занимало место в базе данных.
    // Если поле есть обновляем его и незабываем очищать для безопасности.
//add_action( 'edit_comment', 'extend_comment_edit_meta_data' );
    function extend_comment_edit_meta_data( $comment_id ) {
        if( ! isset( $_POST['extend_comment_update'] ) || ! wp_verify_nonce( $_POST['extend_comment_update'], 'extend_comment_update' ) )
            return;

        if( !empty($_POST['phone']) ){
            $phone = sanitize_text_field($_POST['phone']);
            update_comment_meta( $comment_id, 'phone', $phone );
        }
        else
            delete_comment_meta( $comment_id, 'phone');

        if( !empty($_POST['title']) ){
            $title = sanitize_text_field($_POST['title']);
            update_comment_meta( $comment_id, 'title', $title );
        }
        else
            delete_comment_meta( $comment_id, 'title');

        if( !empty($_POST['rating']) ){
            $rating = intval($_POST['rating']);
            update_comment_meta( $comment_id, 'rating', $rating );
        }
        else
            delete_comment_meta( $comment_id, 'rating');

    }









//    --------------------review-end-------------------------------------


}



if (class_exists('SasReview')) {
    $sasReview = new SasReview();
    $sasReview->register();
}

register_activation_hook(__FILE__, array( $sasReview, 'activation'));
register_deactivation_hook(__FILE__, array( $sasReview, 'deactivation'));