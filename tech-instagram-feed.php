<?php
/*
Plugin Name: Tech Instagram Feed
Description: This plugin allows to fetch the instagram media in your wordpress site.
Version: 2.3.1
Author: Techvers
Author URI: http://techvers.com/
License: GPLv2 or later
Text Domain: tech
*/

define( 'TECH_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'TECH_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );



add_action('admin_menu', 'tech_admin_menu_pages');
add_action( 'admin_init', 'tech_plugin_scripts' );


function tech_instagram_scripts() {
	
	wp_enqueue_style('techstyle',TECH_PLUGIN_URL.'lib/style/tech_style.css');
	
	
}

add_action( 'wp_enqueue_scripts', 'tech_instagram_scripts' );



function tech_plugin_scripts(){
	if( is_admin() ){
	wp_register_script('tech-instagram-admin-easytab',TECH_PLUGIN_URL.'lib/js/admin-js/jquery.easytabs.min.js');
	wp_register_script('tech-instagram-admin-custom-js',TECH_PLUGIN_URL.'lib/js/admin-js/admin-custom-js.js');
	wp_register_script('tech-instagram-bootstrap-js',TECH_PLUGIN_URL.'lib/js/bootstrap.min.js');
	wp_register_script('tech-instagram-custom-js',TECH_PLUGIN_URL.'lib/js/custom.js');
	wp_register_script( 'custom-script-handle', plugins_url(  'lib/js/admin-js/tech-color-picker.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
	wp_enqueue_style('admin_style',TECH_PLUGIN_URL.'lib/style/admin-panel-style.css');
	wp_register_style('bootstrap-css',TECH_PLUGIN_URL.'lib/style/bootstrap.css');
	// Add the color picker css file       
	wp_enqueue_style( 'wp-color-picker' );  
	// Include our custom jQuery file with WordPress Color Picker dependency
	 
    }
}

//call default data
require_once(TECH_PLUGIN_DIR.'/tech-default-data.php');

//call shortcode file
require_once(TECH_PLUGIN_DIR.'/tech-shortcode.php');

function tech_admin_menu_pages(){
    
    $tech_instaram_hook_suffix = add_menu_page(__('Tech Instagram Feed','tech'), __('Tech Instagram Feed','tech'), 'manage_options', 'tech-instagram', 'tech_instagram_output' );
    //add_submenu_page('my-menu', 'Settings', 'Whatever You Want', 'manage_options', 'my-menu' );
    //add_submenu_page('my-menu', 'Submenu Page Title2', 'Whatever You Want2', 'manage_options', 'my-menu2' );

	add_action('admin_print_scripts-' . $tech_instaram_hook_suffix, 'tech_instagram_admin_scripts');
	
	}

function tech_instagram_admin_scripts() {
        /* Link our already registered script to a page */
        wp_enqueue_script( 'tech-instagram-admin-easytab' );
		wp_enqueue_script( 'tech-instagram-admin-custom-js' );
		wp_enqueue_script( 'tech-instagram-custom-js' );
		wp_enqueue_script( 'custom-script-handle' );
		wp_enqueue_style( 'wp-color-picker' ); 
		wp_enqueue_style( 'admin_style' ); 
		wp_enqueue_style( 'bootstrap-css' ); 
		
    }

function tech_instagram_output()
{
?>
	<body>
 <h2>Tech Instagram Feed</h2>
<div id="tab-container" class='tab-container'>
 <ul class='etabs'>
   <li class='tab'><a href="#tabs1-Gsettings">General Settings</a></li>
   <li class='tab'><a href="#tabs1-Design">Design Customization</a></li>
    <li class='tab'><a href="#tabs1-cssandjs">Custom css and js</a></li>
	<li class='tab'><a href="#tab1-pro">Pro version</a></li>
 </ul>
 <div class='panel-container'>
  <div id="tabs1-Gsettings">

  
  <?php if(isset($_POST['Gsettings'])){
	  $tech_settings = array();
    $tech_settings = get_option('tech_settings');
    $tech_settings['tech_insta_access_token'] = $_POST['tech_insta_access_token'];
    $tech_settings['tech_insta_user_id'] = explode (",",$_POST['tech_insta_user_id']);
        
        // update options
        update_option('tech_settings',$tech_settings);

}?>
  <form  name="tech_form" method="post"><?php $tech_settings = get_option('tech_settings');?>

	<div class="frm_page">
   	<div class="container">
		<h1>General Setting</h1><span ><a style="color: red; float:right"target="_blank" href="http://techvers.com/instagram-pro-template/" 14px;"=""><span>Buy our pro plugin just in 5$</a> </span>
		<div id="loginarea" >
		 <a style="background-color: #4CAF50;border: none;color: white;padding: 8px 29px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 5px 201px;
    cursor: pointer;
    border-radius: 10px;" href="https://instagram.com/oauth/authorize/?client_id=25cf821cdfaf4f72a11d6b0610a47718&scope=basic+public_content&redirect_uri=http://techvers.com/tech-instagram-feed/?return_uri=<?php echo admin_url('admin.php?page=tech-instagram'); ?>&response_type=token" class="loginbutton"><?php _e('Log in and get my Access Token and User ID', 'tech'); ?></a>
		</div>
		<div class="row">
			<div class="col-md-2 col-sm-3">
				<div class="lbl_frm">
				<label>Access Token:</label>
				</div>
			</div>
			<div class="col-md-10  col-sm-9">
				<div class="txtfld_frm">
				<input type="text" placeholder="Paste Your Access Token Here" id="tech_insta_access_token"  name="tech_insta_access_token" value="<?php esc_attr_e($tech_settings['tech_insta_access_token']); ?>"  class="form-control"/><a class="help-client-link" href="http://jelled.com/instagram/access-token" target="_blank">Get Access Token</a>
				</div>
			</div>
		</div>
		<div class="row">
			
			<div class="col-md-2 col-sm-3">
				<div class="lbl_frm">
				<label>User Id:</label>
				</div>
			</div>
			<div class="col-md-10 col-sm-9">
				<div class="txtfld_frm">
				<input type="text" placeholder="Paste Your User Id Here" id="tech_insta_user_id" name="tech_insta_user_id" value="<?php if($tech_settings['tech_insta_user_id']!=''){ esc_attr_e(implode(",",$tech_settings['tech_insta_user_id']));}else{} ?>" class="form-control"/><span> add multiple user id seprate with comma (,).</span><br><a class="help-client-link" href="http://jelled.com/instagram/lookup-user-id" target="_blank">Get User Id</a>
				<!--<p>in a few word, explain what the site is about</p>-->
				</div>
			</div>
		
		</div>
	  <input type="submit" name="Gsettings" value="Save Changes" class="button button-primary"/>
	</div>
   </div>
   
</form> 



  </div>
   <div id="tabs1-Design">
   
   <?php
if(isset($_POST['Csettings'])){
	$tech_settings = array();
$tech_settings = get_option('tech_settings');

$tech_settings['tech_feed_width'] = $_POST['tech_feed_width'];
$tech_settings['tech_feed_width_unit'] = $_POST['tech_feed_width_unit'];
$tech_settings['tech_feed_height'] = $_POST['tech_feed_height'];
$tech_settings['tech_feed_height_unit'] = $_POST['tech_feed_height_unit'];
$tech_settings['tech_feed_background_color'] = $_POST['tech_feed_background_color'];
$tech_settings['tech_feed_number_feeds'] = $_POST['tech_feed_number_feeds'];
$tech_settings['tech_feed_column'] = $_POST['tech_feed_column'];
$tech_settings['tech_feed_header_information'] = $_POST['tech_feed_header_information'];
$tech_settings['tech_media_resolution'] = $_POST['tech_media_resolution'];
$tech_settings['tech_load_more_button_text'] = $_POST['tech_load_more_button_text'];
$tech_settings['tech_feed_padding'] = $_POST['tech_feed_padding'];
$tech_settings['tech_feed_padding_unit'] = $_POST['tech_feed_padding_unit'];
if (isset($_POST['tech_load_more_button'])) {$LoadMOreButton = true;} else {$LoadMOreButton = false;}
$tech_settings['tech_load_more_button'] = $LoadMOreButton;
if (isset($_POST['sortby'])){	
 
  $tech_settings['tech_feed_sortby'] = $_POST['sortby'] ;
}
update_option('tech_settings',$tech_settings);	

	
}


   ?>
  
<form name="custom_form" method="post"><?php $tech_settings = get_option('tech_settings'); 
//print_r($tech_settings);
//wp_die();
?>

<div class="frm_page">
   	<div class="container">
	<h1>Feed Area Settings</h1>
		<div class="row">
			
			<div class="col-md-2 col-sm-3">
				<div class="lbl_frm">
				<label>Width of feed area:</label>
				</div>
			</div>
			<div class="col-md-10  col-sm-9">
				<input type="text" id="tech_feed_width"  name="tech_feed_width" value="<?php esc_attr_e($tech_settings['tech_feed_width']); ?>" size="5" />
                <select name="tech_feed_width_unit">
                    <option value="px" <?php if($tech_settings['tech_feed_width_unit'] == "px") echo 'selected="selected"' ?> ><?php _e('px'); ?></option>
                    <option value="%" <?php if($tech_settings['tech_feed_width_unit'] == "%") echo 'selected="selected"' ?> ><?php _e('%'); ?></option>
                </select>
			</div>
			
		</div>
		<div class="row">
			
			<div class="col-md-2 col-sm-3">
				<div class="lbl_frm">
				<label>height of feed area:</label>
				</div>
			</div>
			<div class="col-md-10 col-sm-9">
				<input type="text" id="tech_feed_height"  name="tech_feed_height" value="<?php esc_attr_e($tech_settings['tech_feed_height']); ?>" size="5" />
                <select name="tech_feed_height_unit">
                    <option value="px" <?php if($tech_settings['tech_feed_height_unit'] == "px") echo 'selected="selected"' ?> ><?php _e('px'); ?></option>
                    <option value="%" <?php if($tech_settings['tech_feed_height_unit'] == "%") echo 'selected="selected"' ?> ><?php _e('%'); ?></option>
                </select>
			</div>
		</div>
		<div class="row">
			
			<div class="col-md-2 col-sm-3">
				<div class="lbl_frm">
				<label>Feed background color:</label>
				</div>
			</div>
			<div class="col-md-10 col-sm-9">
				<div class="txtfld_frm">
				<input type="text" name="tech_feed_background_color" value="<?php esc_attr_e($tech_settings['tech_feed_background_color']);?>" class="tech-color-field" />
				</div>
			</div>
		</div>
		<div class="row">
			
			<div class="col-md-2 col-sm-3">
				<div class="lbl_frm">
				<label>Show Header:</label>
				</div>
			</div>
			<div class="col-md-10 col-sm-9">
				<div class="txtfld_frm">
				 <select name="tech_feed_header_information" style="width:100px;">
                    <option value="yes" <?php if($tech_settings['tech_feed_header_information'] == "yes") echo 'selected="selected"' ?> ><?php _e('Yes'); ?></option>
                    <option value="no" <?php if($tech_settings['tech_feed_header_information'] == "no") echo 'selected="selected"' ?> ><?php _e('No'); ?></option>
                </select>
				<!--<p>Enter the address here if you want your site homepage to be different from the dircetory you installed word press</p>-->
				</div>
			</div>
		</div>
		<!--<input type="submit" name="Csettings" value="Save Changes" class="button button-primary"/>-->
	</div>
   </div>
<hr style="margin-top:5px; margin-bottom:5px;">
   
   <div class="frm_page">
   	<div class="container">
	<h1>Media Setting</h1>
		<div class="row">
			
			<div class="col-md-2 col-sm-3">
				<div class="lbl_frm">
				<label>Media Column:</label>
				</div>
			</div>
			<div class="col-md-10  col-sm-9">
				<div class="txtfld_frm">
						 <select name="tech_feed_column" style="width:19%">
                    <option value="1" <?php if($tech_settings['tech_feed_column'] == "1") echo 'selected="selected"' ?> ><?php _e('1'); ?></option>
                    <option value="2" <?php if($tech_settings['tech_feed_column'] == "2") echo 'selected="selected"' ?> ><?php _e('2'); ?></option>
					<option value="3" <?php if($tech_settings['tech_feed_column'] == "3") echo 'selected="selected"' ?> ><?php _e('3'); ?></option>
                    <option value="4" <?php if($tech_settings['tech_feed_column'] == "4") echo 'selected="selected"' ?> ><?php _e('4'); ?></option>
					<option value="5" <?php if($tech_settings['tech_feed_column'] == "5") echo 'selected="selected"' ?> ><?php _e('5'); ?></option>
                    <option value="6" <?php if($tech_settings['tech_feed_column'] == "6") echo 'selected="selected"' ?> ><?php _e('6'); ?></option>
					<option value="7" <?php if($tech_settings['tech_feed_column'] == "7") echo 'selected="selected"' ?> ><?php _e('7'); ?></option>
                    <option value="8" <?php if($tech_settings['tech_feed_column'] == "8") echo 'selected="selected"' ?> ><?php _e('8'); ?></option>
					<option value="9" <?php if($tech_settings['tech_feed_column'] == "9") echo 'selected="selected"' ?> ><?php _e('9'); ?></option>
                    <option value="10" <?php if($tech_settings['tech_feed_column'] == "10") echo 'selected="selected"' ?> ><?php _e('10'); ?></option>
                </select>
				</div>
			</div>
		</div>
		<div class="row">
			
			<div class="col-md-2 col-sm-3">
				<div class="lbl_frm">
				<label>Number of feeds:</label>
				</div>
			</div>
			<div class="col-md-10 col-sm-9">
				<div class="txtfld_frm">
				
				<td><input type="text" name="tech_feed_number_feeds" value="<?php esc_attr_e($tech_settings['tech_feed_number_feeds']); ?>">
				
				</div>
			</div>
		</div>
		
		
		<div class="row">
			
			<div class="col-md-2 col-sm-3">
				<div class="lbl_frm">
				<label>Sort by:</label>
				</div>
			</div>
			<div class="col-md-10 col-sm-4">
				<div class="txtfld_frm radio_box_pnl">
				<ul>
				<li><input type="radio" name="sortby" class="form-control" value="nosort" <?php if($tech_settings['tech_feed_sortby']=='nosort'){echo 'checked';}?> />
				<span>Newest to oldest</span></li>
				<li><input type="radio" name="sortby" class="form-control" value="random" <?php if($tech_settings['tech_feed_sortby']=='random'){echo 'checked';}?> />
				<span>Random</span></li>
				<li><input type="radio" name="sortby" class="form-control" value="oldest" <?php if($tech_settings['tech_feed_sortby']=='oldest'){echo 'checked';}?> />
				<span>Oldest to newest</span></li>
				</ul>
				</div>
			</div>
			
		</div>
		
		<div class="row">
			
			<div class="col-md-2 col-sm-3">
				<div class="lbl_frm">
				<label>Media Resolution:</label>
				</div>
			</div>
			<div class="col-md-3 col-sm-4">
				<div class="txtfld_frm check_box_pnl">
				<select name="tech_media_resolution" style="width:70%">
                    <option value="Thumbnail" <?php if($tech_settings['tech_media_resolution'] == "Thumbnail") echo 'selected="selected"' ?> ><?php _e('Thumbnail'); ?></option>
                   <option value="LowResolution" <?php if($tech_settings['tech_media_resolution'] == "LowResolution") echo 'selected="selected"' ?> ><?php _e('Medium'); ?></option>
                    <option value="StandardResolution" <?php if($tech_settings['tech_media_resolution'] == "StandardResolution") echo 'selected="selected"' ?> ><?php _e('Standard'); ?></option>
                </select>
				
				</div>
			</div>
			
		</div>
		
		<div class="row">
			
			<div class="col-md-2 col-sm-3">
				<div class="lbl_frm">
				<label>Padding arround feed:</label>
				</div>
			</div>
			<div class="col-md-10  col-sm-9">
				<input type="text" id="tech_feed_padding"  name="tech_feed_padding" value="<?php esc_attr_e($tech_settings['tech_feed_padding']); ?>" size="5" />
                <select name="tech_feed_padding_unit">
                    <option value="px" <?php if($tech_settings['tech_feed_padding_unit'] == "px") echo 'selected="selected"' ?> ><?php _e('px'); ?></option>
                    <option value="%" <?php if($tech_settings['tech_feed_padding_unit'] == "%") echo 'selected="selected"' ?> ><?php _e('%'); ?></option>
                </select>
			</div>
			
		</div>
	
		<!--<input type="submit" name="Csettings" value="Save Changes" class="button button-primary"/>-->
		
	</div>
   </div>
   
   <hr style="margin-top:5px; margin-bottom:5px;">
   
   <div class="frm_page">
   	<div class="container">
	<h1>Button setting</h1>
		<div class="row">
			
			<div class="col-md-2 col-sm-3">
				<div class="lbl_frm">
				<label>load more button text:</label>
				</div>
			</div>
			<div class="col-md-10  col-sm-9">
				<div class="txtfld_frm">
							<input type="text" name="tech_load_more_button_text" value="<?php esc_attr_e($tech_settings['tech_load_more_button_text']); ?>">
				</div>
			</div>
		</div>
		
		
		<div class="row">
			
			<div class="col-md-2 col-sm-3">
				<div class="lbl_frm">
				<label>Show load more button:</label>
				</div>
			</div>
			<div class="col-md-3 col-sm-4">
				<div class="txtfld_frm check_box_pnl">
				<input type="checkbox" id="tech_load_more_button" name="tech_load_more_button" <?php if($tech_settings['tech_load_more_button']== 1){echo "checked";}?> class="form-control1"/>
				
				
				</div>
			</div>
			
		</div>
	<input type="submit" name="Csettings" value="Save Changes" class="button button-primary"/>
		
		
	</div>
   </div>

</form>
  </div>
  <div id="tabs1-cssandjs">
   <?php
if(isset($_POST['CustomCssAndJs'])){
$tech_settings = array();
$tech_settings = get_option('tech_settings');
$tech_settings['tech_insta_custom_css'] = $_POST['tech_insta_custom_css'];
    $tech_settings['tech_insta_custom_js'] = $_POST['tech_insta_custom_js'];
	update_option('tech_settings',$tech_settings);
}
?>

<form  name="CustomCssAndJs" method="post"><?php $tech_settings = get_option('tech_settings'); ?>

		<table class="form-table">
			<tbody>
				<tr valign="top">
					<td style="padding-bottom: 0;">
						<strong style="font-size: 15px;">Custom CSS</strong><br><strong style="font-size: 12px;"></td>
				</tr>
				<tr valign="top">
					<td>
						<textarea name="tech_insta_custom_css" id="tech_insta_custom_css"   style="width: 70%;" rows="7"><?php  esc_attr_e(stripslashes( $tech_settings['tech_insta_custom_css'])); ?></textarea>
					</td>
				</tr>
				<tr valign="top">
					<td style="padding-bottom: 0;">
						<strong style="font-size: 15px;">Custom JavaScript</strong><br><strong style="font-size: 12px;"></td>
				</tr>
				<tr valign="top">
					<td>
						<textarea name="tech_insta_custom_js" id="tech_insta_custom_js"  style="width: 70%;" rows="7"><?php esc_attr_e(stripslashes( $tech_settings['tech_insta_custom_js'])); ?></textarea>
					</td>
				</tr>
			</tbody>
		</table>
	
 

    <input type="submit" name="CustomCssAndJs" value="Save Changes" class="button button-primary"/>
	
	
	
</form> 

  

  </div>
  
  <div id="tab1-pro">
					<form>
					<h2>Pro version features.</h1>
					<p>1.Hashtag Support</p>
					<p>2.Media Caption</p>
					<p>3.Media likes</p>
					<p>4.Media comments</p>
					<p>5.Light box support</p>
					<p>6.Media overlay</p>
					<a class="buy-button buy" target="_blank" href="http://techvers.com/instagram-pro-template/">Buy now<span>$5</span></a>
					<a class="buy-button rate" target="_blank" href="https://wordpress.org/support/view/plugin-reviews/tech-instagram-feed?filter=5"><span>* </span>Rate It</a>
					<a class="buy-button buy-package" target="_blank" href="http://techvers.com/"><span>$ 9</span>Buy All plugin just in $7</a>
					</form>
					</div>
 </div>
</div>

</body>
<?php
	
}


?>