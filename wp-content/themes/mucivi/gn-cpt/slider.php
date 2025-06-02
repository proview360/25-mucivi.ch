<?php
/* Custom Post Type - sliders */

function show_sliders_custom_fields() {

    $js_src = includes_url('js/tinymce/') . 'tinymce.min.js';
    $css_src = includes_url('css/') . 'editor.css';

    wp_register_style('tinymce_css', $css_src);
    wp_enqueue_style('tinymce_css');

    global $post;

    $meta = get_post_meta($post->ID,'sliders_fields',true);
    $c = 0;

    ?>


    <script src="<?php echo $js_src; ?>" type="text/javascript"></script>
    <div>

        <input type="hidden" name="slidersMetaNonce" value="<?php echo wp_create_nonce( "slidersFields" ); ?>">

        <div class="sliderSettings">

            <h3>Slides</h3>

        </div>

        <div id="gn-wrapper-slider" class="gn-wrapper-cpt">

            <?php

            if ( is_array($meta) && count( $meta ) > 0 )
            {
                foreach( $meta["slides"] as $slide )
                {
                    $headline       = $slide["headline"] ?? '';
                    $headlineType   = $slide["headlineType"] ?? '';
                    $text_headline_color = $slide["text_headline_color"] ?? "";
                    $text_font_weight    = $slide["text_font_weight"] ?? "";
                    $text           = $slide["text"] ?? '';
                    $text           = htmlspecialchars($text);


                    $button1text     = $slide["button1text"] ?? '';
                    $button1link     = $slide["button1link"] ?? '';
                    $button1linktype = $slide["button1linktype"] ?? '';

                    $button2text     = $slide["button2text"] ?? '';
                    $button2link     = $slide["button2link"] ?? '';
                    $button2linktype = $slide["button2linktype"] ?? '';

                    $imgSrc         = $slide["image"];
                    $imgId          = $slide["imageId"];


                    if( isset($slide["btnoption"]) && $slide["btnoption"] !== "" )
                    {
                        $btnOption = $slide["btnoption"];
                    }
                    else
                    {
                        $btnOption = "link";
                    }

                    echo '<div class="slider cpt-element" data-count="'.$c.'">

            <div class="sortButtons">
                <button type="button" class="btn btn-sm btn-primary float-right mr-1 sort-down">
                    <span class="dashicons dashicons-arrow-down-alt2"></span>
                </button>
                <button type="button" class="btn btn-sm btn-primary float-right mr-1 sort-up">
                    <span class="dashicons dashicons-arrow-up-alt2"></span>
                </button>
            </div>
            
            <div id="box-wrapper-'.$c.'" class="slider-box cpt-box">
                
                <div class="click-area">
                    <h3>Slide #'.($c+1).'</h3>
                </div>                
                
                <div class="content-area '.$btnOption.'"> <!--Hier bei JS einfach link als Klasse-->
                    <dl>
                        <dt></dt>
                        <dd>
                            <hr>
                        </dd>
                        
                        <dt>'.__('Picture','mucivi').' - (1900 x 780 px)</dt>
                        <dd>
                            <input type="hidden" name="sliders_fields[slides]['.$c.'][image]" class="meta-image" value="'.$imgSrc.'">
                            <input type="hidden" name="sliders_fields[slides]['.$c.'][imageId]" class="meta-image-id" value="'.$imgId.'">
                            <input type="button" data-id="'.$c.'" class="button image-upload" value="'.__('Browse','mucivi').'">
                            <input type="button" class="button image-upload-remove" data-id="'.$c.'" value="'.__('Remove','mucivi').'">
                        </dd>
                        
                        <dt>'.__('Preview','mucivi').'</dt>
                        <dd>
                            <div class="image-preview"><img src="'.$imgSrc.'" alt=""></div>
                        </dd>
    
                        <dt>
                            '.__('Headline','mucivi').'  
                        </dt>
                        <dd>
                            <input type="text" name="sliders_fields[slides]['.$c.'][headline]" placeholder="'.__('Write here','mucivi').'..." class="regular-text" value="'.$headline.'">
                        </dd>
                        
                        <dt>'.__("Text","mucivi").'</dt>
                        <dd>
                            <input type="text" name="sliders_fields[slides]['.$c.'][text]" placeholder="'.__('Write here','mucivi').'..." class="regular-text" value="'.$text.'">
                        </dd>
                        <dt>'.__("Headline Type","mucivi").'</dt>
                        <dd>
                            <select name="sliders_fields[slides]['.$c.'][headlineType]">
                                <option value="h1" '. selected($headlineType, "h1", false) .'>H1</option>
                                <option value="h2" '. selected($headlineType, "h2", false) .'>H2</option>
                                <option value="h3" '. selected($headlineType, "h3", false) .'>H3</option>
                                <option value="h4" '. selected($headlineType, "h4", false) .'>H4</option>
                                <option value="p" '. selected($headlineType, "p", false) .'>p</option>
                            </select>
                        </dd>       
                        
                        <dt>'.__("Text Color / Headline Color","mucivi").'</dt>
                        <dd>
                            <select name="sliders_fields[slides]['.$c.'][text_headline_color]">
                                <option value="white" '. selected($text_headline_color, "white", false) .'>white</option>
                                <option value="black" '. selected($text_headline_color, "black", false) .'>black</option>
                                <option value="red" '. selected($text_headline_color, "red", false) .'>red</option>
                            </select>
                        </dd>        
                        
                        <dt>'.__("Font Weight","mucivi").'</dt>
                        <dd>
                            <select name="sliders_fields[slides]['.$c.'][text_font_weight]">
                                <option value="regular" '. selected($text_font_weight, "regular", false) .'>Regular</option>
                                <option value="medium" '. selected($text_font_weight, "medium", false) .'>Medium</option>
                                <option value="bold" '. selected($text_font_weight, "bold", false) .'>Bold</option>
                            </select>
                        </dd> 
                        
                        <dt></dt>
                        <dd>
                            <hr class="m-hr">
                        </dd>                        
                        
                        <dt><h1>'.__('Button 1 (left)','mucivi').'</h1></dt>
                        <dd>
                            
                        </dd>
                        <dt>'.__('Text','mucivi').'</dt>
                        <dd>
                            <input type="text" name="sliders_fields[slides]['.$c.'][button1text]" placeholder="'.__('Write here','mucivi').'..." class="regular-text" value="'.$button1text.'">
                        </dd>
                        
                        <dt>'.__('Link','mucivi').'</dt>
                        <dd>
                            <input type="text" name="sliders_fields[slides]['.$c.'][button1link]" placeholder="'.__('Write here','mucivi').'..." class="regular-text" value="'.$button1link.'">
                        </dd>
                        <dt>'.__('Link Type','mucivi').'</dt>
                        <dd>
                            <select name="sliders_fields[slides]['.$c.'][button1linktype]" class="slider-option">
                                <option value="same" '. selected($button1linktype, "same", false) .'>Open link in same window</option>
                                <option value="blank" '. selected($button1linktype, "blank", false) .'>Open link in new tab</option>
                            </select>
                        </dd>
                        
                        <dt><h1>'.__('Button 2 (right)','mucivi').'</h1></dt>
                        <dd>
                            
                        </dd>
                        <dt>'.__('Text','mucivi').'</dt>
                        <dd>
                            <input type="text" name="sliders_fields[slides]['.$c.'][button2text]" placeholder="'.__('Write here','mucivi').'..." class="regular-text" value="'.$button2text.'">
                        </dd>
                        
                        <dt>'.__('Link','mucivi').'</dt>
                        <dd>
                            <input type="text" name="sliders_fields[slides]['.$c.'][button2link]" placeholder="'.__('Write here','mucivi').'..." class="regular-text" value="'.$button2link.'">
                        </dd>
                        <dt>'.__('Link Type','mucivi').'</dt>
                        <dd>
                            <select name="sliders_fields[slides]['.$c.'][buttonlink2type]" class="slider-option">
                                <option value="same" '. selected($button2linktype, "same", false) .'>Open link in same window</option>
                                <option value="blank" '. selected($button2linktype, "blank", false) .'>Open link in new tab</option>
                            </select>
                        </dd>
                        
                        <div class="cpt-remove">
                            <button type="button" class="remove">'.__('Remove Slide', 'mucivi').'</button>
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
        <button type="button" class="add"><?php _e('Add Slide','mucivi'); ?></button>
    </div>

    <script>

        jQuery(document).ready(function() {

            jQuery(".add").click(function() {

                jQuery(".add").hide();

                let count = getExistingElements(".slider");

                var sliderHTML = `<div class="slider cpt-element" data-count="${count}">

                        <div class="sortButtons">
                        <button type="button" class="btn btn-sm btn-primary float-right mr-1 sort-down">
                            <span class="dashicons dashicons-arrow-down-alt2"></span>
                        </button>
                        <button type="button" class="btn btn-sm btn-primary float-right mr-1 sort-up">
                            <span class="dashicons dashicons-arrow-up-alt2"></span>
                        </button>
                    </div>

                    <div id="box-wrapper-${count}" class="slider-box cpt-box">

                        <div class="click-area">
                            <h3>Slide #${count}</h3>
                        </div>

                        <div class="content-area link">
                            <dl>
                                <dt></dt>
                                <dd>
                                    <hr>
                                </dd>

                                <dt><?php _e('Picture','mucivi'); ?> - (1900 x 780 px)</dt>
                                <dd>
                                    <input type="hidden" name="sliders_fields[slides][${count}][image]" class="meta-image" value="">
                                    <input type="hidden" name="sliders_fields[slides][${count}][imageId]" class="meta-image-id" value="">
                                    <input type="button" data-id="${count}" class="button image-upload" value="<?php _e('Browse','mucivi'); ?>">
                                    <input type="button" data-id="${count}" class="button image-upload-remove" value="<?php _e('Remove','mucivi'); ?>">
                                </dd>

                                <dt><?php _e('Preview','mucivi'); ?></dt>
                                <dd>
                                    <div class="image-preview"><img src="" alt=""></div>
                                </dd>

                                <dt><?php _e('Headline','mucivi'); ?></dt>
                                <dd>
                                    <input type="text" name="sliders_fields[slides][${count}][headline]" placeholder="<?php _e('Write here','mucivi'); ?>..." class="regular-text" value="">
                                </dd>

                                <dt><?php _e("Text","mucivi"); ?></dt>
                                <dd>
                                    <input type="text" name="sliders_fields[slides][${count}][text]" placeholder="<?php _e('Write here','mucivi'); ?>..." class="regular-text" value="">
                                </dd>
                                <dt><?php _e("Headline Type","mucivi"); ?></dt>
                                <dd>
                                    <select name="sliders_fields[slides][${count}][headlineType]">
                                        <option value="h1">H1</option>
                                        <option value="h2">H2</option>
                                        <option value="h3">H3</option>
                                        <option value="h4">H4</option>
                                        <option value="p">p</option>
                                    </select>
                                </dd>


                                <dt><?php _e("Text Color / Headline Color","mucivi"); ?></dt>
                                <dd>
                                    <select name="sliders_fields[slides][${count}][text_headline_color]">
                                        <option value="black">Black</option>
                                        <option value="red">Red</option>
                                        <option value="white">white</option>
                                    </select>
                                </dd>

                                <dt><?php _e("Font Weight","mucivi"); ?></dt>
                                <dd>
                                    <select name="sliders_fields[slides][${count}][text_font_weight]">
                                        <option value="regular">Regular</option>
                                        <option value="medium">Medium</option>
                                        <option value="bold">Bold</option>
                                    </select>
                                </dd>


                                <dt></dt>
                                <dd>
                                    <hr class="m-hr">
                                </dd>

                                <dt><h1><?php _e('Button 1 (left)','mucivi'); ?></h1></dt>
                                <dt><?php _e(' Text','mucivi'); ?></dt>
                                <dd>
                                    <input type="text" name="sliders_fields[slides][${count}][button1text]" placeholder="<?php _e('Write here','mucivi'); ?>..." class="regular-text" value="">
                                </dd>

                                <dt><?php _e('Link','mucivi'); ?></dt>
                                <dd>
                                    <input type="text" name="sliders_fields[slides][${count}][button1link]" placeholder="<?php _e('Write here','mucivi'); ?>..." class="regular-text" value="">
                                </dd>


                                <dt><?php _e("Link Type","mucivi"); ?></dt>
                                <dd>
                                    <select name="sliders_fields[slides][${count}][button1linktype]">
                                        <option value="same">Open link in same window</option>
                                        <option value="blank">Open link in new tab</option>
                                    </select>
                                </dd>

                                <dt><h1><?php _e('Button 2 (right)','mucivi'); ?></h1></dt>
                                <dt><?php _e('Text','mucivi'); ?></dt>
                                <dd>
                                    <input type="text" name="sliders_fields[slides][${count}][button2text]" placeholder="<?php _e('Write here','mucivi'); ?>..." class="regular-text" value="">
                                </dd>

                                <dt><?php _e('Link','mucivi'); ?></dt>
                                <dd>
                                    <input type="text" name="sliders_fields[slides][${count}][button2link]" placeholder="<?php _e('Write here','mucivi'); ?>..." class="regular-text" value="">
                                </dd>


                                <dt><?php _e("Link Type","mucivi"); ?></dt>
                                <dd>
                                    <select name="sliders_fields[slides][${count}][buttonlink2type]">
                                        <option value="same">Open link in same window</option>
                                        <option value="blank">Open link in new tab</option>
                                    </select>
                                </dd>

                                <div class="cpt-remove">
                                    <button type="button" class="remove"><?php _e('Remove Slide', 'mucivi'); ?></button>
                                </div>

                            </dl>
                        </div>
                    </div>

                </div>`;

                jQuery('#gn-wrapper-slider').append( sliderHTML );

                setButtons();
                resetSort();
            });

            setButtons();
        });

        // Init sort buttons
        function setButtons(){
            jQuery('button').show();
            jQuery('.slider button.sort-up').first().hide();
            jQuery('.slider button.sort-down').last().hide();
        }

        // sort Buttons order
        function resetSort(){
            var i=0;
            jQuery('.slider').each(function(){
                jQuery(this).attr("data-sort", i);
                i++;
            });
        }

    </script>
<?php }
/* END - Custom Post Type - Slider */
