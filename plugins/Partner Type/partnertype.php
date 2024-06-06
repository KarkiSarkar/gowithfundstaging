<?php
/*
Plugin Name: PartnerType Form
Description: Plugin to generate a custom contact form with file upload and send emails upon submission.
Version: 1.0
Author: Nydoz Team
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Shortcode function to display the form
function sfs_display_form() {
    ob_start();
   ?>
    <form id="simple-form-ui" method="post" action="" enctype="multipart/form-data">
    <input type="hidden" name="sfs_page_name" value="<?php echo get_the_title();?>">
        <p>
            <label for="sfs_name">Name:</label>
            <input type="text" id="sfs_name" name="sfs_name" >
        </p>
        <p>
            <label for="sfs_email">Email:</label>
            <input type="email" id="sfs_email" name="sfs_email" >
        </p>
        <p>
            <label for="sfs_phonenumber">Phonenumber:</label>
            <input type="tel" id="sfs_phonenumber" name="sfs_phonenumber" >
        </p>
        <p>
            <label for="country">Country </label><br/>
            <select id="country" name="country" >
                <option value="">Select a country</option>
                <option value="Afghanistan">Afghanistan</option>
                <option value="Albania">Albania</option>
                <option value="Algeria">Algeria</option>
                <option value="Andorra">Andorra</option>
                <option value="Angola">Angola</option>
                <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                <option value="Argentina">Argentina</option>
                <option value="Armenia">Armenia</option>
                <option value="Australia">Australia</option>
                <option value="Austria">Austria</option>
                <option value="Azerbaijan">Azerbaijan</option>
                <option value="Bahamas">Bahamas</option>
                <option value="Bahrain">Bahrain</option>
                <option value="Bangladesh">Bangladesh</option>
                <option value="Barbados">Barbados</option>
                <option value="Belarus">Belarus</option>
                <option value="Belgium">Belgium</option>
                <option value="Belize">Belize</option>
                <option value="Benin">Benin</option>
                <option value="Bhutan">Bhutan</option>
                <option value="Bolivia">Bolivia</option>
                <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                <option value="Botswana">Botswana</option>
                <option value="Brazil">Brazil</option>
                <option value="Brunei">Brunei</option>
                <option value="Bulgaria">Bulgaria</option>
                <option value="Burkina Faso">Burkina Faso</option>
                <option value="Burundi">Burundi</option>
                <option value="Côte d'Ivoire">Côte d'Ivoire</option>
                <option value="Cabo Verde">Cabo Verde</option>
                <option value="Cambodia">Cambodia</option>
                <option value="Cameroon">Cameroon</option>
                <option value="Canada">Canada</option>
                <option value="Central African Republic">Central African Republic</option>
                <option value="Chad">Chad</option>
                <option value="Chile">Chile</option>
                <option value="China">China</option>
                <option value="Colombia">Colombia</option>
                <option value="Comoros">Comoros</option>
                <option value="Congo (Congo-Brazzaville)">Congo (Congo-Brazzaville)</option>
                <option value="Costa Rica">Costa Rica</option>
                <option value="Croatia">Croatia</option>
                <option value="Cuba">Cuba</option>
                <option value="Cyprus">Cyprus</option>
                <option value="Czechia (Czech Republic)">Czechia (Czech Republic)</option>
                <option value="Democratic Republic of the Congo">Democratic Republic of the Congo</option>
                <option value="Denmark">Denmark</option>
                <option value="Djibouti">Djibouti</option>
                <option value="Dominica">Dominica</option>
                <option value="Dominican Republic">Dominican Republic</option>
                <option value="Ecuador">Ecuador</option>
                <option value="Egypt">Egypt</option>
                <option value="El Salvador">El Salvador</option>
                <option value="Equatorial Guinea">Equatorial Guinea</option>
                <option value="Eritrea">Eritrea</option>
                <option value="Estonia">Estonia</option>
                <option value="Eswatini (fmr. "Swaziland")">Eswatini (fmr. "Swaziland")</option>
                <option value="Ethiopia">Ethiopia</option>
                <option value="Fiji">Fiji</option>
                <option value="Finland">Finland</option>
                <option value="France">France</option>
                <option value="Gabon">Gabon</option>
                <option value="Gambia">Gambia</option>
                <option value="Georgia">Georgia</option>
                <option value="Germany">Germany</option>
                <option value="Ghana">Ghana</option>
                <option value="Greece">Greece</option>
                <option value="Grenada">Grenada</option>
                <option value="Guatemala">Guatemala</option>
                <option value="Guinea">Guinea</option>
                <option value="Guinea-Bissau">Guinea-Bissau</option>
                <option value="Guyana">Guyana</option>
                <option value="Haiti">Haiti</option>
                <option value="Holy See">Holy See</option>
                <option value="Honduras">Honduras</option>
                <option value="Hungary">Hungary</option>
                <option value="Iceland">Iceland</option>
                <option value="India">India</option>
                <option value="Indonesia">Indonesia</option>
                <option value="Iran">Iran</option>
                <option value="Iraq">Iraq</option>
                <option value="Ireland">Ireland</option>
                <option value="Israel">Israel</option>
                <option value="Italy">Italy</option>
                <option value="Jamaica">Jamaica</option>
                <option value="Japan">Japan</option>
                <option value="Jordan">Jordan</option>
                <option value="Kazakhstan">Kazakhstan</option>
                <option value="Kenya">Kenya</option>
                <option value="Kiribati">Kiribati</option>
                <option value="Kuwait">Kuwait</option>
                <option value="Kyrgyzstan">Kyrgyzstan</option>
                <option value="Laos">Laos</option>
                <option value="Latvia">Latvia</option>
                <option value="Lebanon">Lebanon</option>
                <option value="Lesotho">Lesotho</option>
                <option value="Liberia">Liberia</option>
                <option value="Libya">Libya</option>
                <option value="Liechtenstein">Liechtenstein</option>
                <option value="Lithuania">Lithuania</option>
                <option value="Luxembourg">Luxembourg</option>
                <option value="Madagascar">Madagascar</option>
                <option value="Malawi">Malawi</option>
                <option value="Malaysia">Malaysia</option>
                <option value="Maldives">Maldives</option>
                <option value="Mali">Mali</option>
                <option value="Malta">Malta</option>
                <option value="Marshall Islands">Marshall Islands</option>
                <option value="Mauritania">Mauritania</option>
                <option value="Mauritius">Mauritius</option>
                <option value="Mexico">Mexico</option>
                <option value="Micronesia">Micronesia</option>
                <option value="Moldova">Moldova</option>
                <option value="Monaco">Monaco</option>
                <option value="Mongolia">Mongolia</option>
                <option value="Montenegro">Montenegro</option>
                <option value="Morocco">Morocco</option>
                <option value="Mozambique">Mozambique</option>
                <option value="Myanmar (formerly Burma)">Myanmar (formerly Burma)</option>
                <option value="Namibia">Namibia</option>
                <option value="Nauru">Nauru</option>
                <option value="Nepal">Nepal</option>
                <option value="Netherlands">Netherlands</option>
                <option value="New Zealand">New Zealand</option>
                <option value="Nicaragua">Nicaragua</option>
                <option value="Niger">Niger</option>
                <option value="Nigeria">Nigeria</option>
                <option value="North Korea">North Korea</option>
                <option value="North Macedonia">North Macedonia</option>
                <option value="Norway">Norway</option>
                <option value="Oman">Oman</option>
                <option value="Pakistan">Pakistan</option>
                <option value="Palau">Palau</option>
                <option value="Palestine State">Palestine State</option>
                <option value="Panama">Panama</option>
                <option value="Papua New Guinea">Papua New Guinea</option>
                <option value="Paraguay">Paraguay</option>
                <option value="Peru">Peru</option>
                <option value="Philippines">Philippines</option>
                <option value="Poland">Poland</option>
                <option value="Portugal">Portugal</option>
                <option value="Qatar">Qatar</option>
                <option value="Romania">Romania</option>
                <option value="Russia">Russia</option>
                <option value="Rwanda">Rwanda</option>
                <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                <option value="Saint Lucia">Saint Lucia</option>
                <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
                <option value="Samoa">Samoa</option>
                <option value="San Marino">San Marino</option>
                <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                <option value="Saudi Arabia">Saudi Arabia</option>
                <option value="Senegal">Senegal</option>
                <option value="Serbia">Serbia</option>
                <option value="Seychelles">Seychelles</option>
                <option value="Sierra Leone">Sierra Leone</option>
                <option value="Singapore">Singapore</option>
                <option value="Slovakia">Slovakia</option>
                <option value="Slovenia">Slovenia</option>
                <option value="Solomon Islands">Solomon Islands</option>
                <option value="Somalia">Somalia</option>
                <option value="South Africa">South Africa</option>
                <option value="South Korea">South Korea</option>
                <option value="South Sudan">South Sudan</option>
                <option value="Spain">Spain</option>
                <option value="Sri Lanka">Sri Lanka</option>
                <option value="Sudan">Sudan</option>
                <option value="Suriname">Suriname</option>
                <option value="Sweden">Sweden</option>
                <option value="Switzerland">Switzerland</option>
                <option value="Syria">Syria</option>
                <option value="Tajikistan">Tajikistan</option>
                <option value="Tanzania">Tanzania</option>
                <option value="Thailand">Thailand</option>
                <option value="Timor-Leste">Timor-Leste</option>
                <option value="Togo">Togo</option>
                <option value="Tonga">Tonga</option>
                <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                <option value="Tunisia">Tunisia</option>
                <option value="Turkey">Turkey</option>
                <option value="Turkmenistan">Turkmenistan</option>
                <option value="Tuvalu">Tuvalu</option>
                <option value="Uganda">Uganda</option>
                <option value="Ukraine">Ukraine</option>
                <option value="United Arab Emirates">United Arab Emirates</option>
                <option value="United Kingdom">United Kingdom</option>
                <option value="United States of America">United States of America</option>
                <option value="Uruguay">Uruguay</option>
                <option value="Uzbekistan">Uzbekistan</option>
                <option value="Vanuatu">Vanuatu</option>
                <option value="Venezuela">Venezuela</option>
                <option value="Vietnam">Vietnam</option>
                <option value="Yemen">Yemen</option>
                <option value="Zambia">Zambia</option>
                <option value="Zimbabwe">Zimbabwe</option>
            </select>

        </p>
        <p>
            <label for="sfs_message">Message:</label>
            <textarea id="sfs_message" name="sfs_message" ></textarea>
        </p>
        <p>
            <label for="sfs_file">File:</label>
            <input type="file" id="sfs_file" name="sfs_file">
        </p>
        <p>
            <input type="submit" name="sfs_submit" value="Send">
        </p>
        <div id="error-container"></div>
    </form>
    <script>

document.getElementById('simple-form-ui').addEventListener('submit', function(event) {
    var name = document.getElementById('sfs_name').value;
    var email = document.getElementById('sfs_email').value;
    var phoneNumber = document.getElementById('sfs_phonenumber').value;
    var country = document.getElementById('country').value;
    var message = document.getElementById('sfs_message').value;

    var errors = [];

    if (!name) {
        errors.push("Please enter your name.");
        document.getElementById('sfs_name').classList.add('error');
    } else {
        document.getElementById('sfs_name').classList.remove('error');
    }

    if (!email) {
        errors.push("Please enter your email address.");
        document.getElementById('sfs_email').classList.add('error');
    } else if (!validateEmail(email)) {
        errors.push("Please enter a valid email address.");
        document.getElementById('sfs_email').classList.add('error');
    } else {
        document.getElementById('sfs_email').classList.remove('error');
    }

    if (!phoneNumber) {
        errors.push("Please enter your phone number.");
        document.getElementById('sfs_phonenumber').classList.add('error');
    } else {
        document.getElementById('sfs_phonenumber').classList.remove('error');
    }

    if (!country) {
        errors.push("Please select your country.");
        document.getElementById('country').classList.add('error');
    } else {
        document.getElementById('country').classList.remove('error');
    }

    if (!message) {
        errors.push("Please enter your message.");
        document.getElementById('sfs_message').classList.add('error');
    } else {
        document.getElementById('sfs_message').classList.remove('error');
    }

    if (errors.length > 0) {
        event.preventDefault(); // Prevent form submission
        displayErrors(errors);
    }
});

function validateEmail(email) {
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
}

function displayErrors(errors) {
    var errorContainer = document.getElementById('error-container');
    errorContainer.innerHTML = ''; // Clear previous errors

    var errorList = document.createElement('ul');
    errors.forEach(function(error) {
        var listItem = document.createElement('li');
        listItem.textContent = error;
        errorList.appendChild(listItem);
    });

    errorContainer.appendChild(errorList);
}





















  window.fbAsyncInit = function() {
    FB.init({
      appId            : '484103824186469',
      xfbml            : true,
      version          : 'v20.0'
    });
  };
  
  





</script>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>
    <script>
         document.getElementById('simple-form-ui').addEventListener('submit', function(event) {
            var formData = new FormData(this);
            var data = {};
            formData.forEach((value, key) => {
            data[key] = value;
            });

            // Perform the lead tracking with form data
            fbq('track', 'Lead', data);
            // Submit the form after tracking
            this.submit();
        });
    </script>
    <?php
    return ob_get_clean();
}

// Shortcode registration
function sfs_register_shortcodes() {
    add_shortcode('simple_form', 'sfs_display_form');
}
add_action('init', 'sfs_register_shortcodes');

// Handle form submission
function sfs_handle_form_submission() {
    if (isset($_POST['sfs_submit'])) {
        $name = sanitize_text_field($_POST['sfs_name']);
        $email = sanitize_email($_POST['sfs_email']);
        $phonenumber = sanitize_text_field($_POST['sfs_phonenumber']);
        $country = sanitize_text_field($_POST['country']);
        $page_name = isset($_POST['sfs_page_name'])? sanitize_text_field($_POST['sfs_page_name']) : '';
        $message = sanitize_textarea_field($_POST['sfs_message']);
        $file = isset($_FILES['sfs_file'])? $_FILES['sfs_file'] : null;
        
        // Personal email address for receiving form submissions
        $recipient_email = $email; // Replace with your personal email
        
        // Construct email subject with page name (if available)
        $email_subject = 'New Contact Form Submission';
        if (!empty($page_name)) {
            $email_subject.= ' from '. $page_name;
        }
        
        // Construct email message
        $email_message = "<html><body>";
        $email_message.= "<h2>User Request for $page_name</h2>";
        $email_message.= "<p>Name: $name</p>";
        $email_message.= "<p>Email: $email\n</p>";
        $email_message.= "<p>Phonenumber: $phonenumber\n</p>";
        $email_message.= "<p>Country: $country\n</p>";
        $email_message.= "<p>Message:\n$message</p>";
       
        // Handle file upload
        if ($file) {
            $upload_dir = wp_upload_dir();
            $file_name = basename($file['name']);
            $file_path = $upload_dir['path']. '/'. $file_name;
            if (move_uploaded_file($file['tmp_name'], $file_path)) {
                $email_message.= "\n\nFile: $file_name\n";
                $email_message.= "File URL: ". $upload_dir['url']. '/'. $file_name;
            }
        }
        $attachments = array();
        if ($file) {
            $attachments[] = $file_path;
        }
         $email_message.= "</body></html>";
       
        // Example: Send an email
        wp_mail($recipient_email, $email_subject, $email_message, array('Content-Type: text/html; charset=UTF-8', 'From: '. $name. ' <'. $email. '>'), $attachments);
        
        // Display a thank you message
        add_action('the_content', function($content) {
            return '<p>Thank you for your message!</p>'. $content;
        });
    }
}
add_action('wp', 'sfs_handle_form_submission');
function add_facebook_sdk() {
    echo "
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '484103824186469', // Replace with your app ID
          xfbml      : true,
          version    : 'v19.0'
        });
      };

      (function(d, s, id){
         var js, fjs = d.getElementsByTagName(s)[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement(s); js.id = id;
         js.src = \"https://connect.facebook.net/en_US/sdk.js\";
         fjs.parentNode.insertBefore(js, fjs);
       }(document, 'script', 'facebook-jssdk'));
    </script>";
}
add_action('wp_head', 'add_facebook_sdk');

use FacebookAds\Api;
use FacebookAds\Object\ServerSide\Event;
use FacebookAds\Object\ServerSide\EventRequest;
use FacebookAds\Object\ServerSide\UserData;
use FacebookAds\Object\ServerSide\CustomData;

// Handle form submission
function sfs_handle_form_submissions() {
    if (isset($_POST['sfs_submit'])) {
        // Check if 'sfs_page_name' key is set in $_POST array
        $page_name = isset($_POST['sfs_page_name']) ? sanitize_text_field($_POST['sfs_page_name']) : '';

        // Sanitize other form inputs
        $name = isset($_POST['sfs_name']) ? sanitize_text_field($_POST['sfs_name']) : '';
        $email = isset($_POST['sfs_email']) ? sanitize_email($_POST['sfs_email']) : '';
        $message = isset($_POST['sfs_message']) ? sanitize_textarea_field($_POST['sfs_message']) : '';

        // Send data to Facebook Conversion API
        send_event_to_facebook($name, $email, $page_name, $message);
        $thank_you_page_url = home_url('/become-a-partner/thank-you'); // Replace with your thank you page URL
        wp_redirect($thank_you_page_url);
    }
}
add_action('wp', 'sfs_handle_form_submissions');

function send_event_to_facebook($name, $email, $page_name, $message) {
    // Initialize the Facebook SDK
    $access_token = 'EAACoB29AeEoBOxwtPQsgIOmRnNLW34UIadZBvo0isaC48s7jb5ZBP2yWu4secBiwcirJUT286yer8qRlZBaf9lEJPkneGSYnFpWRXpdZAGZAnCNOUYZC39dgeVC8riIChNEUZCYTgVy4tRQXpABY7EqU7APJVZBk5kfyilUalbgP8i5wVp7LhjTpeCQa4MMjYNluZA9iWbDwtAfZBz8ZBXxnM1diO5NY2NBGdq7zWpP1Jo14FQZCRV8hFNwNo1DbpsskbN3kQvQZD'; // Replace with your actual access token
    $pixel_id = '484103824186469'; // Replace with your actual Pixel ID

    Api::init(null, null, $access_token);

    // Create UserData object
    $user_data = (new UserData())
        ->setEmails([hash('sha256', $email)]);

    // Create CustomData object
    $custom_data = (new CustomData())
        ->setContentName($page_name)
        ->setContentCategory('Form Submission')
        ->setContentIds([$message]);

    // Create Event object
    $event = (new Event())
        ->setEventName('Lead')
        ->setEventTime(time())
        ->setUserData($user_data)
        ->setCustomData($custom_data)
        ->setActionSource('website');

    // Create EventRequest object
    $request = (new EventRequest($pixel_id))
        ->setEvents([$event]);

    // Execute the request
    try {
        $response = $request->execute();
        // Log the response or handle it as needed
    } catch (Exception $e) {
        // Handle exceptions
        error_log('Facebook Conversion API error: ' . $e->getMessage());
    }
}


?>