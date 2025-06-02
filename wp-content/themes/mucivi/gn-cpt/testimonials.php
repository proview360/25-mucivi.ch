<?php
/* Custom Post Type - Testimonial */
function show_testimonial_custom_fields() {

    $js_src  = includes_url('js/tinymce/') . 'tinymce.min.js';
    $css_src = includes_url('css/') . 'editor.css';

    wp_register_style('tinymce_css', $css_src);
    wp_enqueue_style('tinymce_css');

    global $post;
    $meta = get_post_meta($post->ID,'testimonial_fields',true);
    $c = 0;

    ?>

    <script src="<?php echo $js_src; ?>" type="text/javascript"></script>
    <div>

        <input type="hidden" name="testimonial_meta_nonce" value="<?php echo wp_create_nonce( "save_testimonial_fields" ); ?>">

        <div class="testimonial-settings">

            <h3>Testimonailn</h3>

        </div>

        <div id="gn-wrapper-testimonial" class="gn-wrapper-cpt">

            <?php

            if ( is_array($meta) && count( $meta ) > 0 )
            {
                foreach( $meta["testimonial"] as $testimonial )
                {
                    $quote      = $testimonial["quote"] ?? "";
                    $stars      = $testimonial["stars"] ?? "";
                    $name       = $testimonial["full_name"] ?? "";
                    $job        = $testimonial["job"] ?? "";

                    echo '<div class="testimonial cpt-element" data-count="'.$c.'">

            <div class="sortButtons">
                <button type="button" class="btn btn-sm btn-primary float-right mr-1 sort-down">
                    <span class="dashicons dashicons-arrow-down-alt2"></span>
                </button>
                <button type="button" class="btn btn-sm btn-primary float-right mr-1 sort-up">
                    <span class="dashicons dashicons-arrow-up-alt2"></span>
                </button>
            </div>
            
            <div id="box-wrapper-'.$c.'" class="testimonial-box cpt-box">
                
                <div class="click-area">
                    <h3>Testimonail #'.($c+1).'</h3>
                </div>                
                
                <div class="content-area"> <!--Hier bei JS einfach link als Klasse-->
                    <dl>
                        <dt></dt>
                        <dd>
                            <hr>
                        </dd>   
                        <dt>'.__('Stars', "mucivi").'</dt>
                        <dd>
                           <select name="testimonial_fields[testimonial]['.$c.'][stars]" class="teaser-option">                                                
                                <option value="1" '. selected($stars, "1", false) .'>1</option>
                                <option value="2" '. selected($stars, "2", false) .'>2</option>
                                <option value="3" '. selected($stars, "3", false) .'>3</option>
                                <option value="4" '. selected($stars, "4", false) .'>4</option>
                                <option value="5" '. selected($stars, "5", false) .'>5</option>
                            </select>
                        </dd> 
                        
                                           
                        
                        <dt>'.__('Content',"mucivi").'</dt>
                               <dd>
                               '.getWpEditor($quote, "testimonial_fields_" . $c . "_quote", "testimonial_fields[testimonial][" . $c . "][quote]").'
                               </dd>
                        
                        <dt>'.__('Full Name',"mucivi").'</dt>
                        <dd>
                            <input type="text" name="testimonial_fields[testimonial]['.$c.'][full_name]" 
                                placeholder="'.__('Write here',"mucivi").'..." 
                                class="regular-text" value="'.$name.'">
                        </dd>
                        
                        <dt>'.__('Job',"mucivi").'</dt>
                        <dd>
                            <input type="text" name="testimonial_fields[testimonial]['.$c.'][job]" 
                                placeholder="'.__('Write here',"mucivi").'..." 
                                class="regular-text" value="'.$job.'">
                        </dd>

                        <div class="cpt-remove">
                            <button type="button" class="remove" data-type="cpt-element">'.__('Remove Testimonial', "mucivi").'</button>
                        </div>
                    </dl>
                </div>
            </div>
        </div>';
                    $c = $c+1;
                }
            }

            ?>
        </div>
        <button type="button" class="add"><?php _e('Add Testimonial',"mucivi"); ?></button>
    </div>

    <script>

        jQuery(document).ready(function() {

            jQuery(".add").click(function() {

                jQuery(".add").hide();

                let count = getExistingElements(".testimonial");
                console.log(count);

                var testimonialHTML = `<div class="testimonial cpt-element" data-count="${count}">

                        <div class="sortButtons">
                        <button type="button" class="btn btn-sm btn-primary float-right mr-1 sort-down">
                            <span class="dashicons dashicons-arrow-down-alt2"></span>
                        </button>
                        <button type="button" class="btn btn-sm btn-primary float-right mr-1 sort-up">
                            <span class="dashicons dashicons-arrow-up-alt2"></span>
                        </button>
                    </div>

                    <div id="box-wrapper-${count}" class="testimonial-box cpt-box">

                        <div class="click-area">
                            <h3>Testimonail #${count}</h3>
                        </div>

                        <div class="content-area link">
                            <dl>
                                <dt></dt>
                                <dd>
                                    <hr>
                                </dd>
                                <dt><?php _e('Stars', "mucivi"); ?></dt>
                                <dd>

                                   <select name="testimonial_fields[testimonial][${count}][stars]" class="teaser-option">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </dd>
                                <dt><?php _e('Content',"mucivi"); ?></dt>
                                    <dd>
                                        <span id="box-${count}-testimonial_fields_${count}_quote">    </span>
                                    </dd>
                                <dd>


                                <dt><?php _e('Full Name',"mucivi"); ?></dt>
                                <dd>
                                    <input type="text" name="testimonial_fields[testimonial][${count}][full_name]"
                                    placeholder="<?php _e('Write here',"mucivi"); ?>..."
                                    class="regular-text" value="">
                                </dd>

                                <dt><?php _e('Job',"mucivi"); ?></dt>
                                <dd>
                                    <input type="text" name="testimonial_fields[testimonial][${count}][job]"
                                    placeholder="<?php _e('Write here',"mucivi"); ?>..."
                                    class="regular-text" value="">
                                </dd>

                                <div class="cpt-remove">
                                    <button type="button" class="remove" data-type="cpt-element"><?php _e('Remove Testimonial', "mucivi"); ?></button>
                                </div>
                            </dl>
                        </div>
                    </div>

                </div>`;

                jQuery('#gn-wrapper-testimonial').append( testimonialHTML );

                let target = "<?php echo admin_url('admin-ajax.php'); ?>";

                let createWpEditor = function(editor_id, editor_name) {
                    let data_text = {
                        'action': 'gn_get_text_editor',
                        'text_editor_id': editor_id,
                        'textarea_name': editor_name
                    }

                    jQuery.post(target, data_text, function (response) {
                        let cont = "span#box-" + count + "-" + editor_id;
                        jQuery(cont).append(response);
                        tinymce.execCommand('mceAddEditor', false, editor_id);
                        quicktags({id: editor_id});

                        jQuery(".add").show();
                    });
                }

                // Content Editor
                let content_id = "testimonial_fields_" + count + "_quote";
                let content_name = "testimonial_fields[testimonial][" + count + "][quote]";

                // console.log(content_id);
                // console.log(content_name);
                createWpEditor(content_id, content_name);

                setButtons();
                resetSort();
            });

            setButtons();
        });

        // Init sort buttons
        function setButtons(){
            jQuery('button').show();
            jQuery('.testimonial button.sort-up').first().hide();
            jQuery('.testimonial button.sort-down').last().hide();
        }

        // sort Buttons order
        function resetSort(){
            var i=0;
            jQuery('.testimonial').each(function(){
                jQuery(this).attr("data-sort", i);
                i++;
            });
        }

    </script>
<?php }
/* END - Custom Post Type - Testimonial */