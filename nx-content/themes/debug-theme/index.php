<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php bloginfo('name'); ?></title>
    <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>">
    <?php nx_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php nx_body_open(); ?>
    
    <header class="site-header">
        <h1 class="site-title"><?php bloginfo('name'); ?></h1>
        <p class="site-description"><?php bloginfo('description'); ?></p>
    </header>

    <main class="content-area">
        <?php
        if (have_posts()) :
            while (have_posts()) : the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                </article>
                <?php
            endwhile;
        else :
            ?>
            <article>
                <h2>No content found</h2>
                <p>Sorry, no posts matched your criteria.</p>
            </article>
            <?php
        endif;
        ?>

        <div class="debug-info">
            <h3>Debug Information</h3>
            <p>Current Theme: <?php echo get_template(); ?></p>
            <p>Stylesheet: <?php echo get_stylesheet(); ?></p>
            <p>Theme Directory: <?php echo get_template_directory(); ?></p>
            <p>PHP Version: <?php echo phpversion(); ?></p>
            <p>Memory Usage: <?php echo round(memory_get_usage() / 1024 / 1024, 2); ?> MB</p>
            <p>Memory Limit: <?php echo ini_get('memory_limit'); ?></p>
        </div>
    </main>

    <footer>
        <?php nx_footer(); ?>
    </footer>
</body>
</html> 