<?php
/**
 * $Desc
 *
 * @author     Gaviasthemes Team     
 * @copyright  Copyright (C) 2020 gaviasthemes. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * 
 */ 
$header = apply_filters('krowd_get_header_layout', null );
?>
<div id="fb-root"></div>
<div id="fb-customer-chat" class="fb-customerchat"></div>

<script>
  window.fbAsyncInit = function() {
    FB.init({
      xfbml            : true,
      version          : 'v10.0'  // or the latest version you are using
    });
  };

  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  document.getElementById('fb-customer-chat').setAttribute("page_id", "1686357274985685");
  document.getElementById('fb-customer-chat').setAttribute("attribution", "biz_inbox");
</script>

<?php
if(!empty($header) && class_exists('Gavias_Themer_Header')){
  get_template_part('header', 'builder');
}else{
  get_template_part('header', 'default');
}