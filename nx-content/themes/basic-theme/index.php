<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php bloginfo('name'); ?> - <?php is_front_page() ? bloginfo('description') : nx_title(''); ?></title>
    <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>">
    <?php nx_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php if (function_exists('nx_body_open')) { nx_body_open(); } ?>
    
    <div class="container">
        <header>
            <h1><?php bloginfo('name'); ?></h1>
            <p><?php bloginfo('description'); ?></p>
            
            <nav>
                <?php 
                if (function_exists('nx_nav_menu')) {
                    nx_nav_menu(array(
                        'theme_location' => 'primary',
                        'fallback_cb' => false
                    ));
                }
                ?>
            </nav>
        </header>

        <main>
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <div class="entry-content">
                            <?php the_content(); ?>
                        </div>
                    </article>
                <?php endwhile; ?>
            <?php else : ?>
                <article>
                    <h2>No content found</h2>
                    <p>Sorry, no posts matched your criteria.</p>
                </article>
            <?php endif; ?>
        </main>

        <footer>
            <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?></p>
            <?php nx_footer(); ?>
        </footer>
    </div>
</body>
</html> 