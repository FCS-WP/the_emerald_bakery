<?php get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <?php if ( have_posts() ) : ?>

            <header class="page-header">
                <h1 class="page-title"><?php single_term_title(); ?></h1>
            </header>

            <div class="store-list">
                <?php while ( have_posts() ) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <header class="entry-header">
                            <h2 class="entry-title"><?php the_title(); ?></h2>
                        </header><!-- .entry-header -->

                        <div class="entry-content">
                            <?php the_content(); ?>
                            <!-- Display other store information here -->
                        </div><!-- .entry-content -->
                    </article><!-- #post-<?php the_ID(); ?> -->
                <?php endwhile; ?>
            </div><!-- .store-list -->

        <?php else : ?>

            <p><?php esc_html_e( 'No stores found', 'textdomain' ); ?></p>

        <?php endif; ?>

    </main><!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
