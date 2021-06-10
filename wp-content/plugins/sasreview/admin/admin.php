<h1 class="sasplugin_title"><?php esc_html_e('Sasreview Settings', 'sasreview'); ?></h1>
<!--    вывод ошибок-->
<?php settings_errors(); ?>

<div class="sasplugin_content">
    <form method="post" action="options.php">
        <?php
        settings_fields('plugin_settings');
        do_settings_sections('sasreview_settings');
        submit_button();
        ?>
    </form>
</div>
