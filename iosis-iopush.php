<?php
/*
Plugin Name: ioPUSH by IOSIS
Plugin URI: https://www.iosis.io/io-push/
Description: The most powerful push technology. Reach your users at any time, wherever they are, and increase click-through-rates and convert website visitors into subscribers. Simply enable the plugin and start collecting subscribers!
Author: IOSIS
Version: 1.0
screenshot-1.png
screenshot-2.png
screenshot-3.png
screenshot-4.png
iosis-iopush.php
Author URI: https://www.iosis.io

This relies on the actions being present in the themes header.php and footer.php
* header.php code before the closing </head> tag
*   wp_head();
*
*/

//------------------------------------------------------------------------//
//---Config---------------------------------------------------------------//
//------------------------------------------------------------------------//


$clhf_header_iopush_script = '
<!-- Start Iopush Asynchronous Code -->
<script type="text/javascript">
(function(){
  
  var iopush = document.createElement(\'script\'); 
 iopush_el = document.getElementsByTagName(\'script\')[0]; 
 iopush.async=false; 
 iopush.src=\'https://www.iopushtech.com/iopush.js\'; 
 iopush.id=\'iopush_messaging_script\'; 
 iopush_el.parentNode.insertBefore(iopush,iopush_el); 
 iopush.onload = function(){  
 var s = document.createElement(\'script\'),
    el = document.getElementsByTagName(\'script\')[0];
  s.async = true;
  var b= Math.random();
    s.src=\'https://www.iopushtech.com/subscription/permission.js?rndstr=\'+b+\'&pid=IOPUSH_HASH\';
  console.log(s.src);
    s.id=\'myScript\';   el.parentNode.insertBefore(s, el);}; })();
</script>
<!-- End Iopush Asynchronous Code -->
';



							

//------------------------------------------------------------------------//
//---Hook-----------------------------------------------------------------//
//------------------------------------------------------------------------//

add_action ( 'wp_head', 'iosis_clhf_headercode',1 );
add_action( 'admin_menu', 'iosis_clhf_plugin_menu' );
add_action( 'admin_init', 'iosis_clhf_register_mysettings' );
add_action( 'admin_notices','iosis_clhf_warn_nosettings');

//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//
// options page link
function iosis_clhf_plugin_menu() {
 // add_options_page('ioPUSH', 'ioPUSH', 'create_users', 'clhf_iopush_options', 'clhf_plugin_options');
    add_options_page('ioPUSH by IOSIS', 'ioPUSH by IOSIS', 'create_users', 'iosis_clhf_iopush_options', 'iosis_clhf_plugin_options');
}

// whitelist settings
function iosis_clhf_register_mysettings(){
  register_setting('iosis_clhf_iopush_options','iopush_hash');
  // register_setting('iosis_clhf_iopush_options','iopush_segment');
  // register_setting('iosis_clhf_iopush_options','pageId');
}

//------------------------------------------------------------------------//
//---Output Functions-----------------------------------------------------//
//------------------------------------------------------------------------//
function iosis_clhf_headercode(){
  // runs in the header
  global $clhf_header_iopush_script;
   $iopush_hash = get_option('iopush_hash');
  //  $iopush_segment = get_option('iopush_segment');
  //  $pageId=get_option('pageId');

  if($iopush_hash){
  
   echo str_replace('IOPUSH_HASH', $iopush_hash, $clhf_header_iopush_script);// str_replace('IOPUSH_SEGMENT', $iopush_segment, str_replace('IOPUSH_HASH', $iopush_hash, $clhf_header_iopush_script)); // only output if options were saved
 
  //     if(is_page($pageId)){ 
  //  echo  str_replace('IOPUSH_SEGMENT', $iopush_segment, str_replace('IOPUSH_HASH', $iopush_hash, $clhf_header_iopush_script)); // only output if options were saved
  //     }
  }
 
}
//------------------------------------------------------------------------//
//---Page Output Functions------------------------------------------------//
//------------------------------------------------------------------------//
// options page
function iosis_clhf_plugin_options() {
  echo '<div class="wrap">';?>

  <h2>ioPUSH</h2>
  <p>You need to have an <a target="_blank" href="https://www.iosis.io/io-push/">ioPUSH</a> account in order to use this plugin. This plugin will insert the needed code into your Wordpress blog automatically without any manual coding. In order to use it, please enter your ioPUSH Product ID. The ID can be found in your <i>Profile Details</i> section or you can just click on this <a target="_blank" href="https://www.iopushtech.com/iopush/#/profile/edit">Link</a> when logged in. </p> Make sure to enter the ID in your Wordpress Settings.

  <form method="post" action="options.php">
  <?php settings_fields( 'iosis_clhf_iopush_options' ); ?>
  <table class="form-table">
        <tr valign="top">
            <th scope="row">Your ioPUSH Product ID </th>
            <td><input type="text" name="iopush_hash" value="<?php echo get_option('iopush_hash'); ?>" /></td>
        </tr>
          <!-- <tr valign="top">
            <th scope="row">Your ioPUSH Segment ID</th>
            <td><input type="text" name="iopush_segment" value="<?php echo get_option('iopush_segment'); ?>" /></td>
        </tr> 
         <tr valign="top">
            <th scope="row">Your Page ID</th>
            <td><input type="text" name="pageId" value="<?php echo get_option('pageId'); ?>" /></td>
        </tr>  -->
  </table>
  
  <p class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /></p>
<br /><br />
<!-- <h1 style="margin-bottom: 40px;">Send Instant Push Notifications from your Desktop and Mobile WordPress Sites</h1>
<img src="https://www.iopushtech.com/iopush/assets/images/home-img.png" />

<p style="margin-top:20px">ioPUSH is an integrated, client-based engagement and monitoring platform which enables publishers to fully evaluate user behavior and target them with specific content at any given time while the user is surfing the web. It is the web-based application used for sending marketing notification/messages to the targeted users in the form of campaigns, RSS push messages, and welcome messages.
<br /><br />
To enable it for your WordPress site, signup for free at <a target="_blank" href="https://www.iosis.io/io-push/">https://www.iosis.io/io-push/</a>. Or get in touch with us: <a href="mailto:contact@iosis.io">contact@iosis.io</a> -->

</p>
<?php
  echo '</div>';
}

function iosis_clhf_warn_nosettings(){
    if (!is_admin())
        return;

  $clhf_option = get_option("iopush_hash");
  if (!$clhf_option){

    echo "<div class='updated fade'><p><strong>ioPUSH is almost ready.</strong> Please <a target=\"_blank\" href=\"options-general.php?page=iosis_clhf_iopush_options\">enter your Product ID</a> to get started.</p></div>";

  }
}
?>