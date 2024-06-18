<?php
// Function to read ads.txt content
function read_ads_txt() {
    $file = ABSPATH . 'ads.txt';
    return file_exists($file) ? file_get_contents($file) : '';
}

// Function to write to ads.txt
function write_ads_txt($content) {
    $file = ABSPATH . 'ads.txt';
    file_put_contents($file, $content);
}

// ads.txt editor page
function ads_txt_editor_page() {
    if (isset($_POST['ads_txt_content'])) {
        check_admin_referer('save_ads_txt', 'ads_txt_nonce');
        write_ads_txt(wp_unslash($_POST['ads_txt_content']));
        echo '<div class="updated"><p>ads.txt updated successfully.</p></div>';
    }
    $ads_txt_content = esc_textarea(read_ads_txt());
    ?>
    <div class="wrap">
        <h1>ads.txt Editor</h1>
        <form method="post" action="">
            <?php wp_nonce_field('save_ads_txt', 'ads_txt_nonce'); ?>
            <textarea name="ads_txt_content" rows="20" cols="100" class="large-text"><?php echo $ads_txt_content; ?></textarea>
            <?php submit_button('Save ads.txt'); ?>
        </form>
    </div>
    <?php
}
?>
