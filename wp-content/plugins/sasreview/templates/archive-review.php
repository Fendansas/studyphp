<?php
get_header();
?>

<div class="wrapper">
    <div class="review">
        <p>review</p>
        <input type="text" name="title" placeholder="" value="">

        <p>Изображение</p>
        <input type="file" name="image" placeholder="" value="">

        <br/><br/>

        <input type="submit" name="submit" class="btn btn-default" value="Сохранить">

        <br/><br/>
    </div>

    <div class="review_sasplugin">
        <?php
        if(have_posts()){

        while (have_posts()) { the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>
        <h2><a href="<?php the_permalink(); ?>"> <?php the_title(); ?> </a></h2>
        <?php the_excerpt();?>
    </div>

    <?php }
    //        отоброжение страниц

    echo paginate_links();
    }else{
        echo esc_html__('No posts', 'saspreview');
    }
    ?>
</div>
</div>

<?php get_footer();
?>
