<?php
/* Custom Post Type - links */
function show_links_custom_fields() {

    $js_src = includes_url('js/tinymce/') . 'tinymce.min.js';
    $css_src = includes_url('css/') . 'editor.css';

    wp_register_style('tinymce_css', $css_src);
    wp_enqueue_style('tinymce_css');

    global $post;

    $main_links_data = get_post_meta($post->ID, 'links_fields', true);
    $flag = 0;
    ?>



    <div class="repeater">

        <input type="hidden" name="linksMetaNonce" value="<?php echo wp_create_nonce( "linksFields" ); ?>">

        <div id="gn-wrapper-links" class="gn-wrapper-cpt">

            <?php

            if (is_array($main_links_data) && count($main_links_data) > 0) {
                foreach ($main_links_data as $key => $value) {
             
	                $icon           = $value["icon"] ?? "";
                    $btn_text       = $value["button_text"] ?? "";
                    $btn_link       = $value["button_link"] ?? "";
                    $btn_link_type  = $value["link_type"] ?? "";

                    echo '<div class="main-links cpt-element" data-count="' . $flag . '">

                            <div class="sortButtons">
                                <button type="button" class="btn btn-sm btn-primary float-right mr-1 sort-down">
                                    <span class="dashicons dashicons-arrow-down-alt2"></span>
                                </button>
                                <button type="button" class="btn btn-sm btn-primary float-right mr-1 sort-up">
                                    <span class="dashicons dashicons-arrow-up-alt2"></span>
                                </button>
                            </div>
                            
                            <div id="box-wrapper-' . $flag . '" class="main-links-box cpt-box">
                                <div class="click-area">
                                    <h3>Link #' . ($flag + 1) . '</h3>
                                </div>

                                <div class="content-area">
                                    <dl>
                                        <div>
                                            <hr>
                                        </div>
                                        
                                            
                                         <div class="elements-links-container">
                                            <div class="elements-links-left">
                                                <dt>' . __("Icon Optional", "mucivi") . '</dt>
                                                     <select name="links_fields['.$flag.'][icon]" class="icon-option">
                                                        <option value="none" '. selected($icon, "none", false) .'>none</option>
                                                        <option value="bi bi-facebook" '. selected($icon, "bi bi-facebook", false) .'>facebook</option>
                                                        <option value="bi bi-linkedin" '. selected($icon, "bi bi-linkedin", false) .'>linkedin</option>
                                                        <option value="bi bi-twitter-x" '. selected($icon, "bi bi-twitter-x", false) .'>twitter</option>
                                                        <option value="bi bi-instagram" '. selected($icon, "bi bi-instagram", false) .'>instagram</option>
                                                        <option value="bi bi-box-arrow-up-right" '. selected($icon, "bi bi-box-arrow-up-right", false) .'>link</option>
                                                    </select>
                                            </div>
                                        
                                        
                                            <div class="element-announcements-inputs">
                                      
                                            <div class="elements-links-right">
                                                <div class="element-links-inputs">
                                                <dt>' . __("Button Text", "mucivi") . '</dt>
                                                    <input type="text" 
                                                    name="links_fields[' . $flag . '][button_text]" 
                                                    placeholder="' . __('Write here', "mucivi") . '..." 
                                                    class="regular-text" 
                                                    value="' . $btn_text . '">
                                                </div>
                                                
                                                <div class="element-links-inputs">
                                                <dt>' . __("Button Link", "mucivi") . '</dt>
                                                    <input type="text" 
                                                    name="links_fields[' . $flag . '][button_link]" 
                                                    placeholder="' . __('Write here', "mucivi") . '..." 
                                                    class="regular-text" 
                                                    value="' . $btn_link . '">
                                                </div>
                                                
                                                  <div class="element-links-inputs">
                                                <dt>' . __("Link Type", "mucivi") . '</dt>
                                                     <select name="links_fields['.$flag.'][link_type]" class="links-option">
                                                        <option value="_blank" '. selected($btn_link_type, "_blank", false) .'>Open link in new tab</option>
                                                        <option value="_self" '. selected($btn_link_type, "_self", false) .'>Open link in the same window</option>
                                                    </select>
                                                </div>
                                        </div>
                         
                                      <div class="cpt-remove">
                                        <button type="button" data-type="cpt-element" class="remove">' . __('Remove links', "mucivi") . '</button>
                                     </div>
                                    
                                    </dl>
                                </div>                            
                            </div>
						</div>';

                    $flag = $flag + 1;
                }

            }
            ?>

        </div>

        <button type="button" class="add"><?php _e('Add links', "mucivi"); ?></button>
    </div>

    <script>
        jQuery(document).ready(function () {

            jQuery(".add").click(function () {

                jQuery(".add").hide();

                let count = getExistingElements(".main-links");

                var links_html = `<div class="main-links cpt-element" data-count="${count}">
                        <div class="sortButtons">
                        <button type="button" class="btn btn-sm btn-primary float-right mr-1 sort-down">
                            <span class="dashicons dashicons-arrow-down-alt2"></span>
                        </button>
                        <button type="button" class="btn btn-sm btn-primary float-right mr-1 sort-up">
                            <span class="dashicons dashicons-arrow-up-alt2"></span>
                        </button>
                    </div>

                    <div id="box-wrapper-${count}" class="marken-box cpt-box">

                        <div class="click-area">
                            <h3>Link #${count}</h3>
                        </div>

                        <div class="content-area link">
                            <dl>
                                <div>
                                    <hr>
                                </div>
                                        <div class="elements-links-container">
                                            <div class="elements-links-left">
                                         
                                                 <dt><?php _e('Icon Optional"', "mucivi"); ?></dt>
                                                    <select name="announcements_fields[${count}][headline_color]">
                                                       <option value="none">none</option>
                                                        <option value="bi bi-facebook">facebook</option>
                                                        <option value="bi bi-linkedin" >linkedin</option>
                                                        <option value="bi bi-twitter-x">twitter</option>
                                                        <option value="bi bi-instagram"instagram</option>
                                                        <option value="bi bi-box-arrow-up-right">link</option>
                                                    </select>
                                                    
                                                   <dt>' . __("", "mucivi") . '</dt>
                                                     <select name="links_fields['.$flag.'][icon]" class="icon-option">
                                                 
                                                    </select>
                                                    
                                                    
                                            </div>
                                           <div class="elements-links-right">

                                                <div class="element-links-inputs">
                                                <dt><?php _e('Button Text', "mucivi"); ?></dt>
                                                    <input type="text"
                                                    name="links_fields[${count}][button_text]"
                                                    placeholder="<?php _e('Write here',"mucivi"); ?>..."
                                                    class="regular-text"
                                                    value="">
                                                </div>

                                                <div class="element-links-inputs">
                                                <dt><?php _e('Button Link"', "mucivi"); ?></dt>
                                                    <input type="text"
                                                    name="links_fields[${count}][button_link]"
                                                    placeholder="<?php _e('Write here',"mucivi"); ?>..."
                                                    class="regular-text"
                                                    value="">
                                                </div>

                                                <div class="element-links-inputs">
                                                <dt><?php _e('Link Type"', "mucivi"); ?></dt>
                                                    <select name="links_fields[${count}][link_type]">
                                                        <option value="_blank">Open link in the same window</option>
                                                        <option value="_self">Open link in new tab</option>
                                                    </select>
                                                </div>
                                        </div>
                                 <div class="cpt-remove">
                                    <button type="button" data-type="cpt-element" class="remove"><?php _e( 'Remove link', "mucivi"); ?></button>
                                </div>
                            </dl>
                        </div>
                    </div>

                </div>`;

                jQuery('#gn-wrapper-links').append(links_html);

                let target = "<?php echo admin_url('admin-ajax.php'); ?>";

                let createWpEditor = function(editor_id, editor_name) {
                    console.log(editor_id);
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

                // Description Editor
                let description_id = "links_fields_" + count + "_description";
                let description_name = "links_fields[" + count + "][description]";
                createWpEditor(description_id, description_name);

                setButtons();
                resetSort();
            });

            setButtons();
        });

        // Init sort buttons
        function setButtons() {
            jQuery('button').show();
            jQuery('.main-links button.sort-up').first().hide();
            jQuery('.main-links button.sort-down').last().hide();
        }

        // sort Buttons order
        function resetSort() {
            var j = 0;
            jQuery('.main-links').each(function () {
                jQuery(this).attr("data-sort", j);
                j++;
            });
        }

    </script>
    <?php
}

/* END - Custom Post Type - links */
