<?php
/* Custom Post Type - hexagons */

function show_hexagons_custom_fields() {

    $js_src = includes_url('js/tinymce/') . 'tinymce.min.js';
    $css_src = includes_url('css/') . 'editor.css';

    wp_register_style('tinymce_css', $css_src);
    wp_enqueue_style('tinymce_css');

    global $post;

    $main_hexagon_data = get_post_meta($post->ID, 'hexagons_fields', true);
    $flag = 0;

    ?>


    <script src="<?php echo $js_src; ?>" type="text/javascript"></script>
    <div class="hexagon-backend">
        <div class="left-side">

            <input type="hidden" name="hexagonsMetaNonce" value="<?php echo wp_create_nonce( "hexagonsFields" ); ?>">

            <div id="gn-wrapper-hexagon" class="gn-wrapper-cpt">
                <h1>Row 1</h1>
                <?php

                if (is_array($main_hexagon_data) && count($main_hexagon_data) > 0) {
                    foreach ($main_hexagon_data as $key => $value) {

                        // values
                        $img_id             = $value["image_id"] ?? "";
                        $img_src            = $value["image"] ?? wp_get_attachment_image_url($img_id, 'medium') ?? "";
                        $description        = $value["description"] ?? "";
                        $headline           = $value["headline"] ?? "";
                        $image_link          = $value["image_link"] ?? "";

                        $hexagon_color         = $value["hexagon_color"] ?? "";
                        $hexagon_active = "";
                        if($headline !== "" || $img_id != "" || $description !=="" || $hexagon_color !== ""){
                            $hexagon_active = 'active';
                        }
                        echo '<div class="main-hexagon hexagon-'.$hexagon_active.'  cpt-element" data-count="' . $flag . '">
    
                                <div class="sortButtons">
                                    <button type="button" class="btn btn-sm btn-primary float-right mr-1 sort-down">
                                        <span class="dashicons dashicons-arrow-down-alt2"></span>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-primary float-right mr-1 sort-up">
                                        <span class="dashicons dashicons-arrow-up-alt2"></span>
                                    </button>
                                </div>
                                
                                <div id="box-wrapper-' . $flag . '" class="main-hexagon-box cpt-box">
                                    <div class="click-area">
                                        <h3>Hexagon #' . ($flag + 1) . '</h3>
                                    </div>
    
                                    <div class="content-area">
                                        <dl>
                                            <div>
                                                <hr>
                                            </div>
    
                                                    <div class="elements-hexagons-container">
                                                       <div class="elements-hexagons-left">
                                                        <div>
                                                            <dt>' . __('Image', "mucivi") . '</dt>
                                                            <input type="hidden" name="hexagons_fields[' . $flag . '][image]" class="meta-image" value="' . $img_src . '">
                                                            <input type="hidden" name="hexagons_fields[' . $flag . '][image_id]" class="meta-image-id" value="' . $img_id . '">
                                                            <input type="button" data-id="' . $flag . '" class="button image-upload" value="' . __('Browse', "mucivi") . '">
                                                            <input type="button" class="button image-upload-remove" data-id="' . $flag . '" value="' . __('Remove', "mucivi") . '">
                                                        </div>
                                                    <div>                                               
                                                    <dt>' . __('Preview', "mucivi") . '</dt>
                                                        <div class="image-preview"><img src="' . $img_src . '" alt=""></div>
                                                    </div>
                                                    
                                                    <div class="element-hexagon-inputs">                                                
                                                    <dt>' . __("Headline", "mucivi") . '</dt>
                                                        <input type="text" 
                                                        name="hexagons_fields[' . $flag . '][headline]" 
                                                        placeholder="' . __('Write here', "mucivi") . '..." 
                                                        class="regular-text" 
                                                        value="' . $headline . '">
                                                    </div>
                                                    
                                                    <div class="element-hexagon-inputs">                                                
                                                    <dt>' . __("Image Link", "mucivi") . '</dt>
                                                        <input type="text" 
                                                        name="hexagons_fields[' . $flag . '][image_link]" 
                                                        placeholder="' . __('Write here', "mucivi") . '..." 
                                                        class="regular-text" 
                                                        value="' . $image_link . '">
                                                    </div>
                                                    
                                                                                                    
                                                    <div class="element-hexagon-inputs">                                                
                                                    
                                                     <div class="elements-hexagon-style">                   
                                                        <dt>' . __('Description', "mucivi") . '</dt>
                                                        ' . getWpEditor($description, "hexagons_fields_description_$flag", "hexagons_fields[" . $flag . "][description]") . '
                                                     </div>
                                                    
                                                    </div>      
                                               
                                                <div class="elements-hexagons-right">
                                                    <div class="element-hexagon-inputs">    
                                                        <dt>' . __("hexagon Color", "mucivi") . '</dt>
                                                        <input type="text" class="hd-color-field"
                                                               name="hexagons_fields[' . $flag . '][hexagon_color]"
                                                               placeholder="Enter hexagon Color"
                                                               value=' . $hexagon_color . '>
                                                    </div>
                                                 </div>
                                           
                                          <div class="cpt-remove">
                                            <button type="button" data-type="cpt-element" class="remove">' . __('Remove hexagon', "mucivi") . '</button>
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

            <button type="button" class="add"><?php _e('Add hexagon to Row 1', "mucivi"); ?></button>
        </div>

        <div class="right-side">

            <input type="hidden" name="hexagonsMetaNonceRow2" value="<?php echo wp_create_nonce( "hexagonsFieldsRow2" ); ?>">
            <div id="gn-wrapper-hexagon-row2" class="gn-wrapper-cpt">
                <h1>Row 2</h1>
                <?php
                $main_hexagon_data_row2 = get_post_meta($post->ID, 'hexagons_fields_row2', true);
                $flag2 = 0;

                if (is_array($main_hexagon_data_row2) && count($main_hexagon_data_row2) > 0) {
                    foreach ($main_hexagon_data_row2 as $key => $value) {
                        $img_id             = $value["image_id"] ?? "";
                        $img_src            = $value["image"] ?? wp_get_attachment_image_url($img_id, 'medium') ?? "";
                        $description        = $value["description"] ?? "";
                        $headline           = $value["headline"] ?? "";
                        $image_link           = $value["image_link"] ?? "";
                        $hexagon_color      = $value["hexagon_color"] ?? "";
                        $hexagon_active     = "";

                        if($headline !== "" || $img_id != "" || $description !=="" || $hexagon_color !== ""){
                            $hexagon_active = 'active';
                        }

                        echo '<div class="main-hexagon-2 hexagon-'.$hexagon_active.' cpt-element" data-count="' . $flag2 . '">
    
                        <div class="sortButtons">
                            <button type="button" class="btn btn-sm btn-primary float-right mr-1 sort-down">
                                <span class="dashicons dashicons-arrow-down-alt2"></span>
                            </button>
                            <button type="button" class="btn btn-sm btn-primary float-right mr-1 sort-up">
                                <span class="dashicons dashicons-arrow-up-alt2"></span>
                            </button>
                        </div>
                        
                        <div id="box-wrapper-' . $flag2 . '" class="main-hexagon-box cpt-box">
                            <div class="click-area">
                                <h3>Hexagon #' . ($flag2 + 1) . '</h3>
                            </div>
    
                            <div class="content-area">
                                <dl>
                                    <div><hr></div>
    
                                    <div class="elements-hexagons-container">
                                        <div class="elements-hexagons-left">
                                            <div>
                                                <dt>' . __('Image', "mucivi") . '</dt>
                                                <input type="hidden" name="hexagons_fields_row2[' . $flag2 . '][image]" class="meta-image-2" value="' . $img_src . '">
                                                <input type="hidden" name="hexagons_fields_row2[' . $flag2 . '][image_id]" class="meta-image-id-2" value="' . $img_id . '">
                                                <input type="button" data-id="' . $flag2 . '" class="button image-upload-2" value="' . __('Browse', "mucivi") . '">
                                                <input type="button" class="button image-upload-remove-2" data-id="' . $flag2 . '" value="' . __('Remove', "mucivi") . '">
                                            </div>
                                            <div>
                                                <dt>' . __('Preview', "mucivi") . '</dt>
                                                <div class="image-preview-2"><img src="' . $img_src . '" alt=""></div>
                                            </div>
    
                                            <div class="element-hexagon-inputs">
                                                <dt>' . __("Headline", "mucivi") . '</dt>
                                                <input type="text" 
                                                name="hexagons_fields_row2[' . $flag2 . '][headline]" 
                                                placeholder="' . __('Write here', "mucivi") . '..." 
                                                class="regular-text" 
                                                value="' . $headline . '">
                                            </div>
                                            
                                             <div class="element-hexagon-inputs">
                                                <dt>' . __("Image Link", "mucivi") . '</dt>
                                                <input type="text" 
                                                name="hexagons_fields_row2[' . $flag2 . '][image_link]" 
                                                placeholder="' . __('Write here', "mucivi") . '..." 
                                                class="regular-text" 
                                                value="' . $image_link . '">
                                            </div>
    
                                         
    
                                            <div class="elements-hexagon-style">
                                                <dt>' . __('Description', "mucivi") . '</dt>
                                                ' . getWpEditor($description, "hexagons_fields_row2_description_$flag2", "hexagons_fields_row2[" . $flag2 . "][description]") . '
                                            </div>
                                        </div>
    
                                        <div class="elements-hexagons-right">
    
                                            <div class="element-hexagon-inputs">
                                                <dt>' . __("hexagon Color", "mucivi") . '</dt>
                                                <input type="text" class="hd-color-field"
                                                    name="hexagons_fields_row2[' . $flag2 . '][hexagon_color]"
                                                    placeholder="Enter hexagon Color"
                                                    value="' . $hexagon_color . '">
                                            </div>
                                        </div>
                                        
                                        <div class="cpt-remove">
                                            <button type="button" data-type="cpt-element" class="remove">' . __('Remove hexagon', "mucivi") . '</button>
                                        </div>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>';

                        $flag2++;
                    }
                }
                ?>

            </div>

            <button type="button" class="add-row2"><?php _e('Add hexagon to Row 2', "mucivi"); ?></button>

        </div>
    </div>

    <script>
        jQuery(document).ready(function () {
            // Init color pickers
            function colorPickerRow2() {
                if (jQuery('.hd-color-field').length > 0) {
                    jQuery('.hd-color-field').each(function () {
                        jQuery(this).wpColorPicker();
                    });
                }
            }

            // Row 2 - Add button
            jQuery(".add-row2").click(function () {
                jQuery(".add-row2").hide();

                let count = getExistingElements("#gn-wrapper-hexagon-row2 .main-hexagon-2");

                let hexagon_html_2 = `<div class="main-hexagon-2 cpt-element" data-count="${count}">
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
                            <h3>Hexagon #${count}</h3>
                        </div>

                        <div class="content-area link">
                            <dl>
                                <div><hr></div>
                                <div class="elements-hexagons-container">
                                    <div class="elements-hexagons-left">
                                        <div>
                                            <dt><?php _e('Image', "mucivi"); ?></dt>
                                            <input type="hidden" name="hexagons_fields_row2[${count}][image]" class="meta-image-2" value="">
                                            <input type="hidden" name="hexagons_fields_row2[${count}][image_id]" class="meta-image-id-2" value="">
                                            <input type="button" data-id="${count}" class="button image-upload-2" value="<?php _e('Browse', "mucivi"); ?>">
                                            <input type="button" data-id="${count}" class="button image-upload-remove-2" value="<?php _e('Remove', "mucivi"); ?>">
                                        </div>
                                        <div>
                                            <dt><?php _e('Preview', "mucivi"); ?></dt>
                                            <div class="image-preview"><img src="" alt=""></div>
                                        </div>
                                        <div class="element-hexagon-inputs">
                                            <dt><?php _e('Headline', "mucivi"); ?></dt>
                                            <input type="text" name="hexagons_fields_row2[${count}][headline]" placeholder="<?php _e('Write here', "mucivi"); ?>..." class="regular-text" value="">
                                        </div>

                                        <div class="element-hexagon-inputs">
                                            <dt><?php _e('Image Link', "mucivi"); ?></dt>
                                            <input type="text" name="hexagons_fields_row2[${count}][image_link]" placeholder="<?php _e('Write here', "mucivi"); ?>..." class="regular-text" value="">
                                        </div>
                                        <div class="elements-hexagon-style">
                                            <dt><?php _e('Description', "mucivi"); ?></dt>
                                            <span id="box-row2-${count}-hexagons_fields_row2_${count}_description"></span>
                                        </div>
                                    </div>

                                    <div class="elements-hexagons-right">
                                        <div class="element-hexagon-inputs">
                                            <dt><?php _e('hexagon Color', "mucivi"); ?></dt>
                                            <input type="text" class="hd-color-field" name="hexagons_fields_row2[${count}][hexagon_color]" placeholder="<?php _e('Enter hexagon Color', "mucivi"); ?>..." value="">
                                        </div>
                                    </div>

                                    <div class="cpt-remove">
                                        <button type="button" data-type="cpt-element" class="remove"><?php _e('Remove hexagon', "mucivi"); ?></button>
                                    </div>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>`;

                jQuery('#gn-wrapper-hexagon-row2').append(hexagon_html_2);

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

                        jQuery(".add-row2").show();
                    });
                }

                // Description Editor
                let description_id_2 = "hexagons_fields_row2_" + count + "_description";
                let description_name_2 = "hexagons_fields_row2[" + count + "][description]";

                createWpEditor(description_id_2, description_name_2);

                setButtons();
                resetSort();
                colorPickerRow2();
            });

            setButtons();
        });

        // Init sort buttons
        function setButtons() {
            jQuery('button').show();
            jQuery('.main-hexagon-2 button.sort-up').first().hide();
            jQuery('.main-hexagon-2 button.sort-down').last().hide();
        }

        // sort Buttons order
        function resetSort() {
            var j = 0;
            jQuery('.main-hexagon-2').each(function () {
                jQuery(this).attr("data-sort", j);
                j++;
            });
        }
    </script>


    <script>
        jQuery(document).ready(function () {
            //color picker
            function colorPicker() {
                if (jQuery('.hd-color-field').length > 0) {
                    jQuery('.hd-color-field').each(function () {
                        jQuery(this).wpColorPicker();
                    });
                }
            }

            colorPicker();

            jQuery(".add").click(function () {

                jQuery(".add").hide();

                let count = getExistingElements(".main-hexagon");

                var hexagon_html = `<div class="main-hexagon cpt-element" data-count="${count}">
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
                            <h3>Hexagon #${count}</h3>
                        </div>

                        <div class="content-area link">
                            <dl>
                                <div>
                                    <hr>
                                </div>
                                        <div class="elements-hexagons-container">
                                            <div class="elements-hexagons-left">
                                                <div>
                                                    <dt><?php _e('Image', "mucivi"); ?></dt>
                                                    <input type="hidden" name="hexagons_fields[${count}][image]" class="meta-image" value="">
                                                    <input type="hidden" name="hexagons_fields[${count}][image_id]" class="meta-image-id" value="">
                                                    <input type="button" data-id="${count}" class="button image-upload" value="<?php _e('Browse', "mucivi"); ?>">
                                                  <input type="button" data-id="${count}" class="button image-upload-remove" value="<?php _e('Remove', "mucivi"); ?>">
                                                </div>

                                                <div>
                                                <dt><?php _e('Preview', "mucivi"); ?></dt>
                                                           <div class="image-preview"><img src="" alt=""></div>
                                                </div>

                                                <div class="element-hexagon-inputs">
                                                <dt><?php _e('Headline', "mucivi"); ?></dt>
                                                    <input type="text"
                                                    name="hexagons_fields[${count}][headline]"
                                                    placeholder="<?php _e('Write here',"mucivi"); ?>..."
                                                    class="regular-text"
                                                    value="">
                                                </div>

                                                <div class="element-hexagon-inputs">
                                                <dt><?php _e('Image Link', "mucivi"); ?></dt>
                                                    <input type="text"
                                                    name="hexagons_fields[${count}][image_link]"
                                                    placeholder="<?php _e('Write here',"mucivi"); ?>..."
                                                    class="regular-text"
                                                    value="">
                                                </div>


                                                <div class="element-hexagon-inputs">

                                                 <div class="elements-hexagon-style">
                                                    <dt><?php _e('Description', "mucivi"); ?></dt>
                                                     <span id="box-${count}-hexagons_fields_${count}_description">    </span>
                                                 </div>



                                               </div>

                                            <div class="elements-hexagons-right">

                                                     <div class="element-hexagon-inputs">
                                                             <dt><?php _e('hexagon Color', "mucivi"); ?></dt>
                                                            <input type="text" class="hd-color-field"
                                                            name="hexagons_fields[${count}][hexagon_color]"
                                                            placeholder="<?php _e('Enter hexagon Color',"mucivi"); ?>..."
                                                            value="">
                                                     </div>
                                          </div>
                                 <div class="cpt-remove">
                                    <button type="button" data-type="cpt-element" class="remove"><?php _e( 'Remove hexagon', "mucivi"); ?></button>
                                </div>
                            </dl>
                        </div>
                    </div>

                </div>`;

                jQuery('#gn-wrapper-hexagon').append(hexagon_html);

                let target = "<?php echo admin_url('admin-ajax.php'); ?>";

                let createWpEditor = function(editor_id, editor_name) {
                    console.log(editor_id);
                    let data_text = {
                        'action': 'gn_get_text_editor',
                        'text_editor_id': editor_id,
                        'textarea_name': editor_name
                    }

                    jQuery.post(target, data_text, function (response) {

                        let cont = "#box-row2-" + count + "-" + editor_id;
                        jQuery(cont).append(response);
                        tinymce.execCommand('mceAddEditor', false, editor_id);
                        quicktags({id: editor_id});

                        jQuery(".add").show();
                    });
                }

                // Description Editor
                let description_id = "hexagons_fields_" + count + "_description";
                let description_name = "hexagons_fields[" + count + "][description]";

                createWpEditor(description_id, description_name);

                setButtons();
                resetSort();
                colorPicker();
            });

            setButtons();
        });

        // Init sort buttons
        function setButtons() {
            jQuery('button').show();
            jQuery('.main-hexagon button.sort-up').first().hide();
            jQuery('.main-hexagon button.sort-down').last().hide();
        }

        // sort Buttons order
        function resetSort() {
            var j = 0;
            jQuery('.main-hexagon').each(function () {
                jQuery(this).attr("data-sort", j);
                j++;
            });
        }

    </script>
    <?php
}

/* END - Custom Post Type - hexagon */
