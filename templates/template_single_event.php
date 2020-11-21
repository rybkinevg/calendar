<?php get_header(); ?>

<p>123</p>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php var_dump(get_post_meta($post->ID)) ?>
    <?php endwhile;
else : ?>
    <p>Записей нет.</p>
<?php endif; ?>

<?php get_footer(); ?>