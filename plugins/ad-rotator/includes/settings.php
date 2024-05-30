<?php
// Function to add in settings menu
add_action('admin_menu', 'adsense_rotator_menu');
function adsense_rotator_menu() {
    add_options_page('Adsense Rotator Settings', 'AdSense Rotator', 'manage_options', 'adsense-rotator', 'adsense_rotator_settings_page');
    add_options_page('ads.txt Editor', 'ads.txt Rotator', 'manage_options', 'ads-txt-editor', 'ads_txt_editor_page');
}

// Function to register settings in WordPress dashboard
add_action('admin_init', 'adsense_rotator_settings');
function adsense_rotator_settings() {
    register_setting('adsense-rotator-settings-group', 'adsense_rotator_ad_units', 'sanitize_ad_units');
    register_setting('adsense-rotator-settings-group', 'adsense_rotator_slot_ids', 'sanitize_ad_units');
    register_setting('adsense-rotator-settings-group', 'insert_ads_after_paragraph_enabled'); 
    register_setting('adsense-rotator-settings-group', 'insert_ads_before_post_enabled');
    register_setting('adsense-rotator-settings-group', 'display_slot_id_enabled');
    register_setting('adsense-rotator-settings-group', 'insert_ads_in_footer_enabled');
    register_setting('adsense-rotator-settings-group', 'insert_ads_after_post_enabled');

}

// Function to sanitize the input in the plugin
function sanitize_ad_units($input){
    if (is_array($input)) {
        foreach($input as $key => $value){
            $input[$key] = sanitize_text_field($value);
        }
    }
    return $input;
}

// Function to sanitize the slot IDs input
function sanitize_slot_ids($input){
    if(is_array($input)){
        foreach($input as $key => $value){
            $input[$key] = sanitize_text_field($value);
        }
    }
    return $input;
}
?>
