<?php
get_header(); ?>

    <section class="search-results search-results-mt mt-lg-5">
        <div class="container">
            <h1 class="search-results-title gn-h2"><?php printf( esc_html__( 'Search Results for: %s', 'mucivi' ), '<span>"' . get_search_query() . '"</span>' ); ?></h1>
            <div class="py-5">
                <hr class="horizontal-line" />
            </div>
            <?php if ( have_posts() ) : ?>
                <?php
                // Start the Loop
                while ( have_posts() ) :
                    the_post();
                    ?>
                    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <div class="entry-header">
                            <h2 class="entry-title">
                                <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
                            </h2>

                            <div class="entry-meta search-entry-meta pt-2">
                                <span class="posted-on">
                                <?php $archive_year  = get_the_time('Y');
                                $archive_month = get_the_time('m');
                                $archive_day   = get_the_time('d');
                                echo '<a href="'.get_day_link( $archive_year, $archive_month, $archive_day ).'">'.get_the_date('F j, Y H:i').'</a>';
                                ?>
                                </span>
                                <span class="byline">
                                       <?php
                                           if(get_the_author_posts()){
                                               echo '<span class="px-1">•</span> ';
                                               echo __("BY ", "mucivi");
                                               the_author_posts_link();
                                           }
                                       ?>
                                </span>
                                <span class="category">
                                    <?php
                                        $categories = get_the_category();
                                        if(!empty($categories)){
                                            echo '<span class="px-1">•</span> ';
                                            the_category( ', ' );
                                        }
                                    ?>
                                </span>
                            </div><!-- .entry-meta -->
                        </div><!-- .entry-header -->

                        <div class="py-5">
                            <hr class="horizontal-line" />
                        </div>
                    </div><!-- #post-<?php the_ID(); ?> -->

                <?php endwhile; ?>
                <div class="search-pagination pb-5">
                    <?php
                    // Use pagination if necessary
                    the_posts_pagination( array(
                        'mid_size'  => 2,
                        'prev_text'    => __('<i class="bi bi-chevron-left"></i>'),
                        'next_text'    => __('<i class="bi bi-chevron-right"></i>'),
                    ) );
                    ?>
                </div>

            <?php else : ?>
                <div class="no-results not-found pb-5">
                    <h2 class="entry-title pb-3"><?php esc_html_e( 'Nothing Found', 'mucivi' ); ?></h2>
                    <p class="pb-5"><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'mucivi' ); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </section>

<?php
get_footer();
