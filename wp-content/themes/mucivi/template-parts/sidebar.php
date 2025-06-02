<div id="secondary-sidebar" class="widget-area newsroom-sidebar">
    <?php
    if (defined('ICL_LANGUAGE_CODE')) {
        if(ICL_LANGUAGE_CODE=='en'){
            if ( is_active_sidebar( 'newsroom_en' ) ) {
                dynamic_sidebar( 'newsroom_en' );
            }
        }else if(ICL_LANGUAGE_CODE=='fr'){
            if ( is_active_sidebar( 'newsroom_fr' ) ) {
                dynamic_sidebar( 'newsroom_fr' );
            }
        }else if(ICL_LANGUAGE_CODE=='de'){
            if ( is_active_sidebar( 'newsroom_de' ) ) {
                dynamic_sidebar( 'newsroom_de' );
            }
        }
    }
    ?>
</div><!-- #secondary-sidebar -->