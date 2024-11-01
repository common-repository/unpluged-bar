<?php
/*
Plugin Name: unpluged bar
Plugin URI: http://wordpress.freeall.org/?p=360&lang=en
Description: An undepended donation campaign progress bar
Author: Asaf Chertkoff (FreeAllWeb GUILD)
Author URI: http://wordpress.freeall.org
Version: 1.0
Text Domain: unpluged-bar
*/

/*  Copyright 2009  Asaf Chertkoff  (email : asaf@freeallweb.org)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

add_action('admin_menu', 'unpbr_create_menu');
add_action('init','unpbr_activate_shortcode');
add_action('init','unpbr_loadlang');
   
function unpbr_create_menu() {
	add_submenu_page('plugins.php','unpluged bar','unpluged bar','administrator','unpluged_bar','unpbr_show_menu_page');
}

function unpbr_loadlang() {
load_plugin_textdomain('unpluged-bar','',plugin_basename( dirname( __FILE__ ).'/translation'));
}

function unpbr_show_menu_page() {
	$unpbr_goal = 'unpbr_opt_goal'; 					// goal option name
	$unpbr_tilnow = 'unpbr_opt_tilnow';				// what we have 'till now option name
	$unpbr_link = 'unpbr_opt_link';					// link to donation option name
	
	$hidden_field_name = 'hiddensubmit'; 			// hidden input name
	$unpbr_goal_field_name = 'goal_donation'; 	// goal field name
	$unpbr_tilnow_field_name = 'until_now';		// until now field name 
	$unpbr_link_field_name = 'link';					// link to donation field name
	
	$unpbr_goal_val = get_option( $unpbr_goal );
	$unpbr_tilnow_val = get_option( $unpbr_tilnow );
	$unpbr_link_val = get_option ( $unpbr_link );
	$unpbr_width_of_middle_val = get_option('unpbr_opt_width_of_middle');
	$unpbr_alter_of_pre_text_val = get_option('unpbr_alter_of_pre_text');
	$unpbr_alter_of_text1_val = get_option('unpbr_alter_of_text1');
	$unpbr_alter_of_text2_val = get_option('unpbr_alter_of_text2');
	$unpbr_bg_of_box_val = get_option('unpbr_bgofbox');
  	
  	if( $_POST[ $hidden_field_name ] == 'Y' ) {
		$unpbr_goal_val = $_POST[ $unpbr_goal_field_name ];
		$unpbr_tilnow_val = $_POST[ $unpbr_tilnow_field_name ];
		$unpbr_link_val = $_POST[ $unpbr_link_field_name ];	
		$unpbr_width_of_middle_val = $_POST['width_of_middle'];	
		$unpbr_alter_of_text1_val = $_POST['alter_of_text1'];
		$unpbr_alter_of_text2_val = $_POST['alter_of_text2'];
		$unpbr_alter_of_pre_text_val = $_POST['alter_of_pre_text'];
		$unpbr_bg_of_box_val = $_POST['bgofbox'];

		update_option($unpbr_goal, $unpbr_goal_val );
		update_option($unpbr_tilnow, $unpbr_tilnow_val);
		update_option($unpbr_link, $unpbr_link_val);
		update_option('unpbr_opt_width_of_middle', $unpbr_width_of_middle_val);
		update_option('unpbr_alter_of_text1', $unpbr_alter_of_text1_val);
		update_option('unpbr_alter_of_text2', $unpbr_alter_of_text2_val);
		update_option('unpbr_alter_of_pre_text', $unpbr_alter_of_pre_text_val);
		update_option('unpbr_bgofbox', $unpbr_bg_of_box_val);
		
	}

 	echo '<div class="wrap">';
 	echo '<h1>'.__('unpluged bar 1.0','unpluged-bar').'</h1>';
 	echo '<p>'.__('This plugin was built for a specific personal usage, and for that it is good as it is. if it will prove to be needed, i will try to improve the plugin.','unpluged-bar').'</p>';
 	echo '<p>'.__('To activate the plugin you\'ll need to paste the shortcode [unpbr] to the specific post or page, and set the donation goal and present state.','unpluged-bar').'</p>';
  	echo '</div><hr/>';

 	echo '<div class="wrap"><h2>'.__('Settings','unpluged-bar').'</h2>';
	echo '<form name="unpbr_form" method="post" action="">';
	echo '<input type="hidden" name="'. $hidden_field_name .'" value="Y">';

	echo '<p>'. __('The goal of this doantion campaign:','unpluged-bar'); 
	echo '<input type="text" name="'.$unpbr_goal_field_name.'" value="'.$unpbr_goal_val.'" size="15">';
	echo '</p>'; 
	echo '<p>'. __('The present state of this donation campaign:','unpluged-bar'); 
	echo '<input type="text" name="'.$unpbr_tilnow_field_name.'" value="'.$unpbr_tilnow_val.'" size="15">';
	echo '</p>'; 
	echo '<p>'. __('Link to donation page:','unpluged-bar'); 
	echo '<input type="text" name="'.$unpbr_link_field_name.'" value="'.$unpbr_link_val.'" size="40">';
	echo '</p>'; 
	echo '<p>'. __('Width of the middle part of the bar:','unpluged-bar'); 
	echo '<input type="text" name="width_of_middle" value="'.$unpbr_width_of_middle_val.'" size="15"><br/>';
	echo '<span style="font-size:85%">'.__('just the number of pixels (without adding the "px").','unpluged-bar');
	echo '<br/>';
	echo __('You can play with this attribute a bit, until it will please you.','unpluged-bar').'</span>';
	echo '<br/>';
	echo '</p>'; 
	echo '<p><strong>'.__('Alternate texts','unpluged-bar').'</strong><br/>';
	echo '<span style="font-size:85%">'.__('if you want that different will appear above & below the bar, submit it here.','unpluged-bar').'</span>';
	echo '<br/>'.__('Alternate text for "Our donation campaign:"','unpluged-bar').'<br/>';
	echo '<input type="text" name="alter_of_pre_text" value="'.$unpbr_alter_of_pre_text_val.'" size="50"><br/>';	
	echo '<br/>'.__('Alternate text for "Until now your good will brought to us:"','unpluged-bar').'<br/>';
	echo '<input type="text" name="alter_of_text2" value="'.$unpbr_alter_of_text2_val.'" size="50"><br/>';
	echo '<br/>'.__('Alternate text for "We want to reach:"','unpluged-bar').'<br/>';
		echo '<input type="text" name="alter_of_text1" value="'.$unpbr_alter_of_text1_val.'" size="50"><br/>'; 
	echo '</p>';
	echo '<p><strong>'.__('Style of donation box','unpluged-bar').'</strong><br/>';
	echo '<span style="font-size:85%">'.__('Here you can change the styling of the entire donation box, with css syntax','unpluged-bar').'</span><br/>';
	echo __('Background:','unpluged-bar').'<br/><input type="text" name="bgofbox" value="'.$unpbr_bg_of_box_val.'" size="30"><br/>';	
	echo '</p><p class="submit">';
	echo '<input type="submit" name="Submit" value="'. __('save settings','unpluged-bar').'" />';
	echo '</p></form></div>';
	echo '<hr/><div class="warp"><h3>'.__('If you want to give something back:','unpluged-bar').'</h3>';
	echo '<form action="https://www.paypal.com/cgi-bin/webscr" method="post"><input type="hidden" name="cmd" value="_s-xclick"><input type="hidden" name="hosted_button_id" value="9810099"><input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!"><img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1"></form>';
	echo '<p><a href="http://www.amazon.com/wishlist/21SEN5UC15V17/ref=reg_hu-wl_goto-registry?_encoding=UTF8&sort=date-added" alt="'.__('My Amazon Wishlist','embed-bbpress').'">'.__('My Amazon Wishlist','unpluged-bar').'</a></p></div>';
}

function unpbr_activate_shortcode() {
	add_shortcode( 'unpbr', 'unpbr_embeding_the_object' );
}

function unpbr_embeding_the_object () {
	$unpbr_goal = 'unpbr_opt_goal'; 					// goal option name
	$unpbr_tilnow = 'unpbr_opt_tilnow';				// what we have till now option name
	$unpbr_link = 'unpbr_opt_link';
	
	$unpbr_goal_val = get_option($unpbr_goal);
	$unpbr_tilnow_val = get_option($unpbr_tilnow);
	$unpbr_link_val = get_option($unpbr_link);
	$unpbr_width_of_middle_val = get_option('unpbr_opt_width_of_middle');
	$unpbr_alter_of_text1_val = get_option('unpbr_alter_of_text1');
	$unpbr_alter_of_text2_val = get_option('unpbr_alter_of_text2');
	$unpbr_alter_of_pre_text_val = get_option('unpbr_alter_of_pre_text');
	$unpbr_bg_of_box_val = get_option('unpbr_bgofbox');
	
	
	$unpbr_precentage = round(($unpbr_tilnow_val/$unpbr_goal_val)*100);
	$plgurl = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));  
	if ($unpbr_tilnow_val == $unpbr_goal_val) {
		$check='2';
	} else {
		$check='';
	}

	$textval1 = ($unpbr_alter_of_text1_val ? $unpbr_alter_of_text1_val : __(' Until now your good will brought to us:','unpluged-bar'));
	$textval2 =  ($unpbr_alter_of_text2_val ? $unpbr_alter_of_text2_val : __('We want to reach:','unpluged-bar'));
	$pretextval = ($unpbr_alter_of_pre_text_val ? $unpbr_alter_of_pre_text_val : __('Our donation campaign:','unpluged-bar'));
	$bgofboxval = ($unpbr_bg_of_box_val ? $unpbr_bg_of_box_val : "" );
	
	$curURL = unpbr_curPageURL();
	if ($curURL!=$unpbr_link_val) {
		$endtext ='<a href="'.$unpbr_link_val.'" style="font-weight:bold">'.__(' We need your help','unpluged-bar').'.</a></div>';
	}else {
		$endtext .=__(' We need your help','unpluged-bar').'</div>';
	}
	
$unpbr_rtlplug ='<div style="background:'.$bgofboxval.'; text-align:right; line-height:150%; font-weight:bold">'.$pretextval.'<div style="background:inherit;  padding-top:5px; margin-right:auto; margin-left:auto; float:right; text-align:right; width:100%"><div style="width:15px; float:left; background:url(\''.$plgurl.'/images/backgroundleft'.$check.'.png\') 0px 0px no-repeat; height:47px;"></div><div id="progress" style="float:left;height:47px; width:'.$unpbr_width_of_middle_val.'px; background:url(\''.$plgurl.'/images/backgroundmiddle.png\') 0px 0px repeat-x; color:white"><div style="float:right; text-align:left;background-color:#15861c; height:37px; margin-top:3px; width:'.$unpbr_precentage.'%"><div style="color:white; font-weight:bold; font-size:30px; padding-top:2px "> '.$unpbr_precentage.'%</div></div></div><div style="background:url(\''.$plgurl.'/images/backgroundright.png\') 0px 0px no-repeat; height:47px; width:15px; float:left"></div></div><div style="width:100%;float:right; text-align:right; padding-top:3px; font-weight:bold; background:inherit">'.$textval1.$unpbr_goal_val.__('$','unpluged-bar').$textval2.$unpbr_tilnow_val.__('$','unpluged-bar').$endtext.'</div>';

$unpbr_ltrplug ='<div style="background:'.$bgofboxval.'; text-align:left; line-height:150%; font-weight:bold">'.$pretextval.'<div style="background:inherit; padding-top:5px; margin-right:auto; margin-left:auto; float:left; text-align:left; width:100%"><div style="width:15px; float:right; background:url(\''.$plgurl.'/images/ltr/backgroundright'.$check.'.png\') 0px 0px no-repeat; height:47px;"></div><div id="progress" style="float:right;height:47px; width:'.$unpbr_width_of_middle_val.'px; background:url(\''.$plgurl.'/images/backgroundmiddle.png\') 0px 0px repeat-x; color:white"><div style="float:left; text-align:right;background-color:#15861c; height:37px; margin-top:3px; width:'.$unpbr_precentage.'%"><div style="color:white; font-weight:bold; font-size:30px; padding-top:2px "> '.$unpbr_precentage.'%</div></div></div><div style="background:url(\''.$plgurl.'/images/ltr/backgroundleft.png\') 0px 0px no-repeat; height:47px; width:15px; float:right"></div></div><div style="width:100%;float:left; text-align:left;  padding-top:3px; font-weight:bold; background:inherit">'.$textval1.$unpbr_goal_val.__('$','unpluged-bar').$textval2.$unpbr_tilnow_val.__('$','unpluged-bar').$endtext.'</div>';

        if ($GLOBALS['my_transposh_plugin']) {
           if (in_array($GLOBALS['my_transposh_plugin']->target_language, $GLOBALS['rtl_languages'])) {
              $unpbr_output .= $unpbr_rtlplug;
           } else {
              $unpbr_output .=$unpbr_ltrplug;
           }
       }else {
           if (get_bloginfo('text_direction')=='rtl') {
            $unpbr_output .= $unpbr_rtlplug;
           } else $unpbr_output .= $unpbr_ltrplug;
       }    
       return $unpbr_output;
}

	function unpbr_curPageURL() {
    $pageURL = 'http';
     
    if ($_SERVER["HTTPS"] == "on") {
        $pageURL .= "s";
    }

     $pageURL .= "://";
     if ($_SERVER["SERVER_PORT"] != "80") {
          $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
     } else {
          $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
     }

  return $pageURL;
}
?>
