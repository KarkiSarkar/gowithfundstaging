<?php
    // Settings page HTML
    function adsense_rotator_settings_page() {
?>
<div class="ad-rotator-header-wrapper">
    <h1 class="ad-rotator-header">AdSense ID Rotator Settings</h1>
</div>
<div class="ad_pl_wrapper">

    <div class="ads-tab">
        <button class="ads-tablinks" onclick="openCity(event, 'ads_id')"  id="defaultOpen">Adsense Id</button>
        <button class="ads-tablinks" onclick="openCity(event, 'ads_field')">Adsense Field</button>
        <p>Use [adsense_ad_with_slot_id] for script with slot id and [rotate_named_adsense_ads] for script without slot id.</p>
        <p><strong>Warning: </strong> Use [adsense_ad_with_slot_id] shortcode only if slot id is enabled.</p>
    </div>
    <div class="ads-tabcontentwrapper">
        <form method="post" action="options.php">
            <?php settings_fields('adsense-rotator-settings-group'); ?>
            <?php do_settings_sections('adsense-rotator-settings-group'); ?>
            <div id="ads_id" class="ads-tabcontent">
                <table class="form-table" id="adsense-rotator-ad-units">
                    <tr valign="top">
                        <th scope="row">Display Slot ID Input</th>
                        <td>
                            <label class="ads-toggle-btn" for="display_slot_id_enabled">
                                <input type="checkbox" id="display_slot_id_enabled" name="display_slot_id_enabled" value="1" <?php checked(1, get_option('display_slot_id_enabled'), true); ?> />
                                <span class="ads-slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Ad Units</th>
                        <td id="ad-units-container">
                            <?php
                                $ad_units = get_option('adsense_rotator_ad_units', array());
                                $slot_ids = get_option('adsense_rotator_slot_ids', array());
                                if (!is_array($ad_units)) {
                                $ad_units = array();
                                }
                                $counter = 1;
                                foreach ($ad_units as $index => $ad_unit) {
                            ?>
                            <div class="ad-unit">
                                <p><?php echo $counter; ?></p>
                                <input type="text" name="adsense_rotator_ad_units[]" value="<?php echo esc_attr($ad_unit); ?>" class="large-text" placeholder="Ad Unit ID" />
                                <input type="text" name="adsense_rotator_slot_ids[]" value="<?php echo isset($slot_ids[$index]) ? esc_attr($slot_ids[$index]) : ''; ?>" class="large-text slot-id-input" placeholder="Slot ID" />
                                <button type="button" class="button remove-ad-unit">Remove</button>
                            </div>
                            <?php
                            $counter++;
                            }
                            ?>
                        </td>
                    </tr>
                </table>
                <button type="button" class="button" id="add-ad-unit">Add Ad Unit</button>
            </div>

            <div id="ads_field" class="ads-tabcontent">
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Insert Ads After Paragraphs</th>
                        <td>
                            <label class="ads-toggle-btn" for="insert_ads_after_paragraph_enabled">
                                <input type="checkbox" id="insert_ads_after_paragraph_enabled" name="insert_ads_after_paragraph_enabled" value="1" <?php checked(1, get_option('insert_ads_after_paragraph_enabled'), true); ?> />
                                <span class="ads-slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Insert Ads Before Post</th>
                        <td>
                            <label class="ads-toggle-btn" for="insert_ads_before_post_enabled">
                                <input type="checkbox" id="insert_ads_before_post_enabled" name="insert_ads_before_post_enabled" value="1" <?php checked(1, get_option('insert_ads_before_post_enabled'), true); ?> />
                                <span class="ads-slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Insert Ads After Post</th>
                        <td>
                            <label class="ads-toggle-btn" for="insert_ads_after_post_enabled">
                                <input type="checkbox" id="insert_ads_after_post_enabled" name="insert_ads_after_post_enabled" value="1" <?php checked(1, get_option('insert_ads_after_post_enabled'), true); ?> />
                                <span class="ads-slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Insert Ads in Footer</th>
                        <td>
                            <label class="ads-toggle-btn" for="insert_ads_in_footer_enabled">
                                <input type="checkbox" id="insert_ads_in_footer_enabled" name="insert_ads_in_footer_enabled" value="1" <?php checked(1, get_option('insert_ads_in_footer_enabled'), true); ?> />
                                <span class="ads-slider"></span>
                            </label>
                        </td>
                    </tr>
                </table>
            </div>
            <script>
                function openCity(evt, cityName) {
                var i, tabcontent, tablinks;
                tabcontent = document.getElementsByClassName("ads-tabcontent");
                for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
                }
                tablinks = document.getElementsByClassName("ads-tablinks");
                for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
                }
                document.getElementById(cityName).style.display = "block";
                evt.currentTarget.className += " active";
                }

                // Get the element with id="defaultOpen" and click on it
                document.getElementById("defaultOpen").click();
            </script>
            <div class="ads-rotate-submit-btn">
                <?php submit_button(); ?>
            </div>
        </form>
    </div>
</div>
<?php } ?>
