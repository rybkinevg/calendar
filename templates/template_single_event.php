<?php get_header(); ?>

<p>test autoupdate 0.4</p>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php var_dump(get_post_meta($post->ID)) ?>
    <?php endwhile;
else : ?>
    <p>Записей нет.</p>
<?php endif; ?>

<?php get_footer(); ?>