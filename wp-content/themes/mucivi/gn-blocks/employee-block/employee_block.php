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
 * @subpackage mucivi
 * @author Granit Nebiu
 * @since 1.0
 */

function gn_employee_block_rc($attributes, $content) {

    global  $theme_path;
    wp_register_style("gn_employee_block",$theme_path."/gn-blocks/employee-block/employee_block.css",array("css-main"),"1");

    // vars
    $uniqid                     = uniqid();
    $employee_post_id           = $attributes["post_id"] ?? "";

    $employee_align_items       = $attributes["align_items"] ?? "";
    $employee_data_array        = get_post_meta($employee_post_id, 'employee_fields', true);
    $employee_data              = $employee_data_array["employee"];
    $employee_background_color  = $attributes["background_color"] ?? "white";

    $full_name                            = $employee_data["full_name"] ?? "";
    $job_title                            = $employee_data["job_title"] ?? "";
    $tel_number                           = $employee_data["tel_number"] ?? "";
    $tel_number_link                      = $employee_data["tel_number_link"] ?? "";
    $email                                = $employee_data["email"] ?? "";
    $fr_enabled                           = $employee_data["fr_enabled"] ?? "no";
    $en_enabled                           = $employee_data["en_enabled"] ?? "no";
    $de_enabled                           = $employee_data["de_enabled"] ?? "no";

    if (!empty($employee_data["image"])) {
        $employee_image = $employee_data["image"];
        $employee_image_html = '<img class="employee-image" src="' . $employee_image . '" alt="Employee Image">';
    }

    $language_bg_image_url = $theme_path."/assets/img/vectors/languageIcon_2.svg";
//            echo '<pre>';
//        echo print_r($employee_data);
//        echo '</pre>';

    $fr_enabled_html = '';
    $en_enabled_html = '';
    $de_enabled_html = '';

    if($fr_enabled === "yes"){
        $fr_enabled_html = '
                        <div class="position-relative d-inline-block">
                            <img src="' . $language_bg_image_url . '" alt="Language Bg Image" class="img-fluid">
                            <span class="position-absolute top-50 start-50 translate-middle bg-white text-danger fw-regular">
                                FR
                            </span>
                        </div>';

    }

    if($en_enabled === "yes"){
        $en_enabled_html = '
                        <div class="position-relative d-inline-block">
                            <img src="' . $language_bg_image_url . '" alt="Language Bg Image" class="img-fluid">
                            <span class="position-absolute top-50 start-50 translate-middle bg-white text-danger fw-regular">
                                EN
                            </span>
                        </div>';

    }

    if($de_enabled === "yes"){
        $de_enabled_html = '
                        <div class="position-relative d-inline-block">
                            <img src="' . $language_bg_image_url . '" alt="Language Bg Image" class="img-fluid">
                            <span class="position-absolute top-50 start-50 translate-middle bg-white text-danger fw-regular">
                                DE
                            </span>
                        </div>';

    }

    $employee_html =  '
        <section class="py-5 employee-block employee-block-with-logo employee-block-id-' . $uniqid . ' bg-color-'.$employee_background_color.'">
                <div class="container">
                    <div class="row">
                    <div class="d-flex flex-column flex-lg-row align-items-'.$employee_align_items.' gap-4">
                        <div class="">
                          '.$employee_image_html.'
                        </div>
                        <div class="">
                               <p class="gn-h3">'.$full_name.'</p> 
                               <p class="job-title text-color-primary mb-2">'.$job_title.'</p> 
                               <a href="tel:'.$tel_number_link.'">'.$tel_number.'</a><br>
                               <a href="mailto:'.$email.'">'.$email.'</a>
                               
                               <div class="mt-5 d-flex gap-2">
                                   '.$fr_enabled_html.'
                                   '.$en_enabled_html.'
                                   '.$de_enabled_html.'
                               </div>
                        </div>
           
                </div>                                            
            </section>';


    return $employee_html;
}
