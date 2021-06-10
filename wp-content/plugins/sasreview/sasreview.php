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
        wp_enqueue_style('sasReviewStyle', plugins_url('/assets/admin/styles.css', __FILE__));
        wp_enqueue_script('sasReviewScript', plugins_url('/assets/admin/scripts.js', __FILE__));
    }

    //метод для подключения css and js файлов
    public function enqueue_front(){
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
//закончил тут
    public function setting_init(){
        register_setting('plugin_settings','booking_settings_options');

        add_settings_section('sasplugin_settings_section', esc_html__('Settings','sasplugin'), [$this, 'settings_section_html'],'sasplugin_settings');

        add_settings_field('posts_per_page', esc_html__('Posts per page','sasplugin'), [$this, 'posts_per_page_html'], 'sasplugin_settings', 'sasplugin_settings_section');

        //add_settings_field('title_for_rooms', esc_html__('Archive page title','sasplugin'), [$this, 'title_for_rooms_html'], 'sasplugin_settings', 'sasplugin_settings_section');

    }




}



if (class_exists('SasReview')) {
    $sasReview = new SasReview();
    $sasReview->register();
}

register_activation_hook(__FILE__, array( $sasReview, 'activation'));
register_deactivation_hook(__FILE__, array( $sasReview, 'deactivation'));