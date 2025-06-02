<?php
/**
 * Copyright (c) 2025 by Granit Nebiu
 *
 * All rights are reserved. Reproduction or transmission in whole or in part, in
 * any form or by any means, electronic, mechanical or otherwise, is prohibited
 * without the prior written consent of the copyright owner.
 *
 * Functions and definitions
 *
 * @package WordPress
 * @subpackage Elanders
 * @author Granit Nebiu, Granit Nebiu
 * @since 1.0
 */


get_header(); ?>
    <div id="primary" class="content-area container">
        <main id="main" class="site-main container" role="main">
            <section class="error-404 not-found">
                <div class="error-404-container container d-flex flex-column gap-5 align-items-center justify-content-center">
                    <img
                            class="image-404"
                            src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/404.png' ); ?>"
                            alt="<?php esc_attr_e( 'Page 404', 'mucivi' ); ?>"
                    />
                    <div class="not-found-badge">
                        <?php esc_html_e( 'Page non trouvée', 'mucivi' ); ?>
                    </div>

                    <p class="text-center">
                        <?php esc_html_e( "Cette page n'est pas disponible.", 'mucivi' ); ?><br/>
                        <?php esc_html_e( "Le lien que vous avez suivi est peut-être rompu, ou la page a pu être supprimée.", 'mucivi' ); ?>
                    </p>

                    <a
                            class="btn-full btn-full-red"
                            href="<?php echo esc_url( home_url( '/' ) ); ?>"
                            title="<?php esc_attr_e( "Retour à l'accueil", 'mucivi' ); ?>"
                    >
                        <?php esc_html_e( "Retour à l'accueil", 'mucivi' ); ?>
                    </a>
                </div>

            </section>
        </main>
    </div>

<?php get_footer(); ?>



