<?php
/* Custom Post Type - announcements */
function show_announcements_custom_fields() {

    $js_src = includes_url('js/tinymce/') . 'tinymce.min.js';
    $css_src = includes_url('css/') . 'editor.css';

    wp_register_style('tinymce_css', $css_src);
    wp_enqueue_style('tinymce_css');

    global $post;

    $main_announcements_data = get_post_meta($post->ID, 'announcements_fields', true);
    $flag = 0;
    ?>



    <div class="repeater">

        <input type="hidden" name="announcementsMetaNonce" value="<?php echo wp_create_nonce( "announcementsFields" ); ?>">

        <div id="gn-wrapper-announcements" class="gn-wrapper-cpt">

            <?php

            if (is_array($main_announcements_data) && count($main_announcements_data) > 0) {
                foreach ($main_announcements_data as $key => $value) {

                    // values
                    $img_id         = $value["image_id"] ?? "";
                    $img_src        = $value["image"] ?? wp_get_attachment_image_url($img_id, 'medium') ?? "";
                    $description    = $value["description"] ?? "";
                    $headline       = $value["headline"] ?? "";
	                $date           = $value["date"] ?? "";
                    $btn_text       = $value["button_text"] ?? "";
                    $btn_link       = $value["button_link"] ?? "";
                    $btn_link_type  = $value["link_type"] ?? "";

                    echo '<div class="main-announcements cpt-element" data-count="' . $flag . '">

                            <div class="sortButtons">
                                <button type="button" class="btn btn-sm btn-primary float-right mr-1 sort-down">
                                    <span class="dashicons dashicons-arrow-down-alt2"></span>
                                </button>
                                <button type="button" class="btn btn-sm btn-primary float-right mr-1 sort-up">
                                    <span class="dashicons dashicons-arrow-up-alt2"></span>
                                </button>
                            </div>
                            
                            <div id="box-wrapper-' . $flag . '" class="main-announcements-box cpt-box">
                                <div class="click-area">
                                    <h3>Announcements #' . ($flag + 1) . '</h3>
                                </div>

                                <div class="content-area">
                                    <dl>
                                        <div>
                                            <hr>
                                        </div>
                                        
                                            
                                         <div class="elements-announcements-container">
                                            <div class="elements-announcements-left">
                                                <div>
                                                    <dt>' . __('Image', "mucivi") . '</dt>
                                                    <input type="hidden" name="announcements_fields[' . $flag . '][image]" class="meta-image" value="' . $img_src . '">
                                                    <input type="hidden" name="announcements_fields[' . $flag . '][image_id]" class="meta-image-id" value="' . $img_id . '">
                                                    <input type="button" data-id="' . $flag . '" class="button image-upload" value="' . __('Browse', "mucivi") . '">
                                                    <input type="button" class="button image-upload-remove" data-id="' . $flag . '" value="' . __('Remove', "mucivi") . '">
                                                </div>
                                                
                                                <div>                                               
                                                <dt>' . __('Preview', "mucivi") . '</dt>
                                                    <div class="image-preview"><img src="' . $img_src . '" alt=""></div>
                                                </div>
                                                
                                                <div class="element-announcements-inputs">
                                                <dt>' . __("Date (optional)", "mucivi") . '</dt>
                                                    <input type="text"
                                                    name="announcements_fields[' . $flag . '][date]"
                                                    placeholder="' . __('Write here', "mucivi") . '..."
                                                    class="regular-text"
                                                    value="' . $date . '">
                                                </div>
        
        
                                                <div class="element-announcements-inputs">
                                                <dt>' . __("Headline", "mucivi") . '</dt>
                                                    <input type="text" 
                                                    name="announcements_fields[' . $flag . '][headline]" 
                                                    placeholder="' . __('Write here', "mucivi") . '..." 
                                                    class="regular-text" 
                                                    value="' . $headline . '">
                                                </div>
        
                                                
                                                 <div class="elements-announcements-style">
                                                    <dt>' . __('Description', "mucivi") . '</dt>
                                                    ' . getWpEditor($description, "announcements_fields_" . $flag . "_description", "announcements_fields[" . $flag . "][description]") . '
                                                 </div>
                                                
                                            </div>
                                        
                                                <div class="elements-announcements-right">
                                                 
                                              
                                                
                                                <div class="element-announcements-inputs">
                                                <dt>' . __("Button Text", "mucivi") . '</dt>
                                                    <input type="text" 
                                                    name="announcements_fields[' . $flag . '][button_text]" 
                                                    placeholder="' . __('Write here', "mucivi") . '..." 
                                                    class="regular-text" 
                                                    value="' . $btn_text . '">
                                                </div>
                                                
                                                <div class="element-announcements-inputs">
                                                <dt>' . __("Button Link", "mucivi") . '</dt>
                                                    <input type="text" 
                                                    name="announcements_fields[' . $flag . '][button_link]" 
                                                    placeholder="' . __('Write here', "mucivi") . '..." 
                                                    class="regular-text" 
                                                    value="' . $btn_link . '">
                                                </div>
                                                
                                                  <div class="element-announcements-inputs">
                                                <dt>' . __("Link Type", "mucivi") . '</dt>
                                                     <select name="announcements_fields['.$flag.'][link_type]" class="announcements-option">
                                                        <option value="_blank" '. selected($btn_link_type, "_blank", false) .'>Open link in new tab</option>
                                                        <option value="_self" '. selected($btn_link_type, "_self", false) .'>Open link in the same window</option>
                                                    </select>
                                                </div>
                                
                                        </div>
                         
                                      <div class="cpt-remove">
                                        <button type="button" data-type="cpt-element" class="remove">' . __('Remove announcements', "mucivi") . '</button>
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

        <button type="button" class="add"><?php _e('Add announcements', "mucivi"); ?></button>
    </div>

    <script>
        jQuery(document).ready(function () {

            jQuery(".add").click(function () {

                jQuery(".add").hide();

                let count = getExistingElements(".main-announcements");

                var announcements_html = `<div class="main-announcements cpt-element" data-count="${count}">
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
                            <h3>Announcements #${count}</h3>
                        </div>

                        <div class="content-area link">
                            <dl>
                                <div>
                                    <hr>
                                </div>
                                        <div class="elements-announcements-container">
                                            <div class="elements-announcements-left">
                                                <div>
                                                    <dt><?php _e('Picture', "mucivi"); ?></dt>
                                                    <input type="hidden" name="announcements_fields[${count}][image]" class="meta-image" value="">
                                                    <input type="hidden" name="announcements_fields[${count}][image_id]" class="meta-image-id" value="">
                                                    <input type="button" data-id="${count}" class="button image-upload" value="<?php _e('Browse', "mucivi"); ?>">
                                                  <input type="button" data-id="${count}" class="button image-upload-remove" value="<?php _e('Remove', "mucivi"); ?>">
                                                </div>

                                                <div>
                                                <dt><?php _e('Preview', "mucivi"); ?></dt>
                                                           <div class="image-preview"><img src="" alt=""></div>
                                                </div>

                                                <div class="element-announcements-inputs">
                                                <dt><?php _e('Date (optional)', "mucivi"); ?></dt>
                                                    <input type="text"
                                                    name="announcements_fields[${count}][date]"
                                                    placeholder="<?php _e('Write here',"mucivi"); ?>..."
                                                    class="regular-text"
                                                    value="">
                                                </div>
                                                
                                                <div class="element-announcements-inputs">
                                                <dt><?php _e('Headline', "mucivi"); ?></dt>
                                                    <input type="text"
                                                    name="announcements_fields[${count}][headline]"
                                                    placeholder="<?php _e('Write here',"mucivi"); ?>..."
                                                    class="regular-text"
                                                    value="">
                                                </div>

                                                 <div class="elements-announcements-style">
                                                    <dt><?php _e('Description', "mucivi"); ?></dt>
                                                     <span id="box-${count}-announcements_fields_${count}_description">    </span>
                                                 </div>
                                            </div>
                                                <div class="elements-announcements-right">



                                                <div class="element-announcements-inputs">
                                                <dt><?php _e('Button Text', "mucivi"); ?></dt>
                                                    <input type="text"
                                                    name="announcements_fields[${count}][button_text]"
                                                    placeholder="<?php _e('Write here',"mucivi"); ?>..."
                                                    class="regular-text"
                                                    value="">
                                                </div>

                                                <div class="element-announcements-inputs">
                                                <dt><?php _e('Button Link"', "mucivi"); ?></dt>
                                                    <input type="text"
                                                    name="announcements_fields[${count}][button_link]"
                                                    placeholder="<?php _e('Write here',"mucivi"); ?>..."
                                                    class="regular-text"
                                                    value="">
                                                </div>

                                                <div class="element-announcements-inputs">
                                                <dt><?php _e('Link Type"', "mucivi"); ?></dt>
                                                    <select name="announcements_fields[${count}][link_type]">
                                                        <option value="_blank">Open link in the same window</option>
                                                        <option value="_self">Open link in new tab</option>
                                                    </select>
                                                </div>
                                        </div>
                                 <div class="cpt-remove">
                                    <button type="button" data-type="cpt-element" class="remove"><?php _e( 'Remove announcements', "mucivi"); ?></button>
                                </div>
                            </dl>
                        </div>
                    </div>

                </div>`;

                jQuery('#gn-wrapper-announcements').append(announcements_html);

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
                let description_id = "announcements_fields_" + count + "_description";
                let description_name = "announcements_fields[" + count + "][description]";
                createWpEditor(description_id, description_name);

                setButtons();
                resetSort();
            });

            setButtons();
        });

        // Init sort buttons
        function setButtons() {
            jQuery('button').show();
            jQuery('.main-announcements button.sort-up').first().hide();
            jQuery('.main-announcements button.sort-down').last().hide();
        }

        // sort Buttons order
        function resetSort() {
            var j = 0;
            jQuery('.main-announcements').each(function () {
                jQuery(this).attr("data-sort", j);
                j++;
            });
        }

    </script>
    <?php
}

/* END - Custom Post Type - announcements */
