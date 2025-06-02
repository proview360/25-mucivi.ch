<?php get_header(); ?>
<div class="container newsroom-container">
    <div id="primary" class="content-area content-single-post-preview pe-0 pe-lg-5">
        <section id="main" class="site-main">
            <?php
            while ( have_posts() ) : the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <h1 class="entry-title gn-h2"><?php the_title(); ?></h1>
                        <div class="entry-meta newsroom-entry-meta pt-2 pb-4">
                                <span class="posted-on pe-1">
                                <?php $archive_year  = get_the_time('Y');
                                $archive_month = get_the_time('m');
                                $archive_day   = get_the_time('d');
                                echo '<a href="'.get_day_link( $archive_year, $archive_month, $archive_day ).'">'.get_the_date('F j, Y H:i').'</a>';
                                ?>
                                </span>  •
                            <span class="category ps-1">
                                    <?php the_category( ', ' ); ?>
                                </span>
                        </div><!-- .entry-meta -->
                    </header><!-- .entry-header -->

                    <div class="newsroom-entry-content">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="newsroom-entry-thumbnail mb-4">
                                <?php
                                // 'full' can be swapped for any registered image size: 'thumbnail', 'medium', 'large'…
                                the_post_thumbnail( 'full', [
                                    'class' => 'img-fluid',    // bootstrap class, adjust as needed
                                    'alt'   => get_the_title(), // good for accessibility
                                ] );
                                ?>
                            </div>
                        <?php endif; ?>

                        <?php the_content(); ?>
                    </div><!-- .entry-content -->
                </article><!-- #post-<?php the_ID(); ?> -->

                <?php
                // Display comments if enabled
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;

            endwhile; // End of the loop.

            //Previous/next post navigation
            echo '<div class="newsroom-next-prev">';
                the_post_navigation(array(
                    'next_text' =>
                        '<i class="bi bi-chevron-left"></i>'.
                        '<span class="meta-nav" aria-hidden="true">' . __( 'Plus récents', 'mucivi' ) . '</span> ' .
                        '<span class="screen-reader-text">' . __( 'Plus récents', 'mucivi' ) . '</span> ',
                    'prev_text' =>
                        '<span class="meta-nav" aria-hidden="true">' . __( 'Plus anciens', 'mucivi' ) . '</span> ' .
                        '<span class="screen-reader-text">' . __( 'Plus anciens', 'mucivi' ) . '</span> '.
                        '<i class="bi bi-chevron-right"></i>',

                ));
            echo '</div>';

            ?>
        </section><!-- #main -->
    </div><!-- #primary -->

</div>
<?php get_template_part( 'template-parts/sidebar' ); ?>
<?php get_footer(); ?>
