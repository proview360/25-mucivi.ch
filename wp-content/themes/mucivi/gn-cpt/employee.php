<?php
/* Custom Post Type - Employee */
function show_employee_custom_fields() {

	global $post;
	$meta          = get_post_meta( $post->ID, 'employee_fields', true );
	$meta_employee = $meta["employee"] ?? [];

	$img_src                              = $meta_employee["image"] ?? "";
	$img_id                               = $meta_employee["imageId"] ?? "";
//    $img_src_2                            = $meta_employee["image_2"] ?? "";
//    $img_id_2                             = $meta_employee["image_id_2"] ?? "";

    $full_name                            = $meta_employee["full_name"] ?? "";
    $job_title                            = $meta_employee["job_title"] ?? "";
    $tel_number                           = $meta_employee["tel_number"] ?? "";
    $tel_number_link                      = $meta_employee["tel_number_link"] ?? "";
    $email                                = $meta_employee["email"] ?? "";
    $fr_enabled                           = $meta_employee["fr_enabled"] ?? "";
    $en_enabled                           = $meta_employee["en_enabled"] ?? "";
    $de_enabled                           = $meta_employee["de_enabled"] ?? "";

//            echo '<pre>';
//        echo print_r($meta_employee);
//        echo '</pre>';
	?>


    <div id="gn-wrapper-employee" class="location-img-box-wrapper gn-wrapper-cpt">
        <input type="hidden" name="employeeMetaNonce" value="<?php echo wp_create_nonce( "saveEmployeeFields" ); ?>">

        <dl>
            <div id="box-wrapper-1" class="location-box cpt-box">
                <hr>

                <dt>Employee Picture</dt>
                <dd>
                    <input type="hidden" name="employee_fields[employee][image]" class="meta-image"
                           value="<?php echo $img_src ?>">
                    <input type="hidden" name="employee_fields[employee][imageId]" class="meta-image-id"
                           value="<?php echo $img_id ?>">
                    <input type="button" data-id="1" class="button image-upload" value="Browse">
                    <input type="button" class="button image-upload-remove" data-id="1" value="Remove">
                </dd>

                <dt>Employee Preview</dt>
                <dd>
                    <div class="image-preview"><img src="<?php echo $img_src ?>" alt=""></div>
                </dd>

                <dl>
<!--                    <dt>Logo (optional)</dt>-->
<!--                    <dd>-->
<!--                        <input type="hidden" name="employee_fields[employee][image_2]" class="meta-image-2"-->
<!--                               value="--><?php //echo $img_src_2; ?><!--">-->
<!--                        <input type="hidden" name="employee_fields[employee][image_id_2]" class="meta-image-id-2"-->
<!--                               value="--><?php //echo $img_id_2; ?><!--">-->
<!--                        <input type="button" data-id="1" class="button image-upload-2" value="Browse">-->
<!--                        <input type="button" class="button image-upload-remove-2" data-id="1" value="Remove">-->
<!--                    </dd>-->
<!---->
<!--                    <dt>Logo Preview</dt>-->
<!--                    <dd>-->
<!--                        <div class="image-preview-2"><img src="--><?php //echo $img_src_2 ?><!--" alt=""></div>-->
<!--                    </dd>-->

                    <hr>
                </dl>
                <dt>Full Name</dt>
                <dd>
                    <label>
                        <input type="text" name="employee_fields[employee][full_name]" placeholder="Write here.." class="regular-text"
                               value="<?php echo $full_name ?>">
                    </label>
                </dd>

                <dt>Job Title</dt>
                <dd>
                    <label>
                        <input type="text" name="employee_fields[employee][job_title]" placeholder="Write here.." class="regular-text"
                               value="<?php echo $job_title ?>">
                    </label>
                </dd>

                <dt>Tel Number</dt>
                <dd>
                    <label>
                        <input type="text" name="employee_fields[employee][tel_number]" placeholder="Write here.." class="regular-text"
                               value="<?php echo $tel_number ?>">
                    </label>
                </dd>

                <dt>Tel Number Link</dt>
                <dd>
                    <label>
                        <input type="text" name="employee_fields[employee][tel_number_link]" placeholder="Write here.." class="regular-text"
                               value="<?php echo $tel_number_link ?>">
                    </label>
                </dd>

                <dt>Email</dt>
                <dd>
                    <label>
                        <input type="text" name="employee_fields[employee][email]" placeholder="Write here.." class="regular-text"
                               value="<?php echo $email ?>">
                    </label>
                </dd>

<!--                <p class="font-bold"> --><?php //echo __( 'Full Name', 'mucivi' ); ?><!--</p>-->
<!--                --><?php //echo getWpEditor($employee_full_name, "employee_field_full_name", "employee_fields[employee][full_name]") ?>



                <br/>
                <hr>
                <dt>French Language Enable</dt>
                <dd>
                    <label>
                        <select name="employee_fields[employee][fr_enabled]">
                            <option value="yes" <?php selected($fr_enabled, "yes"); ?>>Yes</option>
                            <option value="no" <?php selected($fr_enabled, "no"); ?>>No</option>
                        </select>
                    </label>
                </dd>
                <dt>English Language Enable</dt>
                <dd>
                    <label>
                        <select name="employee_fields[employee][en_enabled]">
                            <option value="yes" <?php selected($en_enabled, "yes"); ?>>Yes</option>
                            <option value="no" <?php selected($en_enabled, "no"); ?>>No</option>
                        </select>
                    </label>
                </dd>
                <dt>German Language Enable</dt>
                <dd>
                    <label>
                        <select name="employee_fields[employee][de_enabled]">
                            <option value="yes" <?php selected($de_enabled, "yes"); ?>>Yes</option>
                            <option value="no" <?php selected($de_enabled, "no"); ?>>No</option>
                        </select>
                    </label>
                </dd>

        </dl>
    </div>

<?php }
/* END - Custom Post Type - Location */