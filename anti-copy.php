<?php
/*
Plugin Name: MHR-Custom-Anti-Copy
Plugin URI: http://www.mahadirlab.com/en/mhr-custom-anti-copy/
Description: Custom protection for right click and words selection.
Version: 2.0
Author: Mahadir Ahmad
Author URI: http://www.mahadirlab.com/en/
*/

/*
Copyright (C) 2012-2013 Mahadir Network

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

*/
if (!defined("MHR_ANTICOPY_CURRENT_URL"))
    define("MHR_ANTICOPY_CURRENT_URL", WP_PLUGIN_URL . '/' . str_replace(basename(__FILE__), "", plugin_basename(__FILE__)));

function MHR_anti_copy_activated()
{
    //assign default value
    update_option('MHR_set_all_rclick', 0);
    update_option('MHR_set_all_select', 0);
    update_option('MHR_disable_warning', 1);
    update_option('MHR_msg', 'This function is disabled!');

}

function MHR_anti_copy_uninstall()
{
    delete_option('MHR_set_all_rclick');
    delete_option('MHR_set_all_select');
    delete_option('MHR_disable_warning');
    delete_option('MHR_msg');

}

function mhr_shortcode1() //anti select
{
    echo '<script type="text/javascript">disableSelection(document.body)</script>';
}

function mhr_shortcode2() // anti right click without message
{
    echo '<script type="text/javascript">
     if (document.layers){
	 document.captureEvents(Event.MOUSEDOWN);
	 document.onmousedown=clickNS4;	}
     else if (document.all&&!document.getElementById){
	 document.onmousedown=clickIE4;}
	 document.oncontextmenu=new Function("return false")
     </script> ';
}

function mhr_shortcode4() //both
{
    echo '<script type="text/javascript">disableSelection(document.body)</script>';
    echo '<script type="text/javascript">
     if (document.layers){
	 document.captureEvents(Event.MOUSEDOWN);
	 document.onmousedown=clickNS4;	}
     else if (document.all&&!document.getElementById){
	 document.onmousedown=clickIE4;}
	 document.oncontextmenu=new Function("return false")
	 disableSelection(document.body)
     </script> ';
}


//insert javascript function file
function main_func()
{
    echo '<script type="text/javascript" src="' . MHR_ANTICOPY_CURRENT_URL . 'mhrfunction.php "></script>';
}

function setting_all()
{
    $MHR_set_all_rclick = get_option('MHR_set_all_rclick');
    $MHR_set_all_select = get_option('MHR_set_all_select');
    $msg                = get_option('MHR_msg');

    if ($MHR_set_all_rclick == 1) {
        if (!get_option('MHR_disable_warning'))
            $altermsg = "alert(message);";
        echo '<script type="text/javascript">
     var message = "' . $msg . '" ;
     if (document.layers){
	 document.captureEvents(Event.MOUSEDOWN);
	 document.onmousedown=clickNS4;	}
     else if (document.all&&!document.getElementById){
	 document.onmousedown=clickIE4;}
     document.oncontextmenu=new Function("' . $altermsg . 'return false")
     </script> ';
    }

    if ($MHR_set_all_select == 1)
        echo '<script type="text/javascript">disableSelection(document.body)</script>';

}



function MHR_Anti_Copy_options_page()
{
    echo '<div class="wrap">
	  <h1><font color="#804000">MHR Custom Anti Copy</font><font size="2" color="#0000FF">version 2.0</font></h1>
     <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
     <input type="hidden" name="cmd" value="_s-xclick">
     <input type="hidden" name="hosted_button_id" value="YQUS4PXZ6UZHQ">
     <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
     <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
     </form>';


    echo '<br><h3>SETTING PAGE</h3><br>';


    if ($_POST['MHR_save']) {
        update_option('MHR_msg', $_POST['MHR_msg']);
        update_option('MHR_set_all_rclick', $_POST['MHR_set_all_rclick']);
        update_option('MHR_set_all_select', $_POST['MHR_set_all_select']);
        update_option('MHR_disable_warning', $_POST['MHR_disable_warning']);

        echo '<div class="updated"><p>Settings saved</p></div>';
    }

    $MHR_set_all_rclick  = get_option('MHR_set_all_rclick');
    $MHR_set_all_select  = get_option('MHR_set_all_select');
    $msg                 = get_option('MHR_msg');
    $MHR_disable_warning = get_option('MHR_disable_warning');

    if ($msg == '')
        update_option('MHR_msg', 'This function is disabled!');

    function chkcheckbox($a)
    {
        if ($a == 1)
            return 'checked="yes"';
    }

    echo '<img src="' . MHR_ANTICOPY_CURRENT_URL . 'anti-copy-paste.jpg" width="151" height="99" border="0">';

?>

<form method="post" id="mhr_options">
      <fieldset class="options">
		<table class="form-table">
			<tr valign="top">
				<th width="33%" scope="row">Warning Message:</th>
				<td>
    <input name="MHR_msg" type="text" id="MHR_msg" value="<?php
    echo get_option('MHR_msg');
?>" size="60"/>
				</td>
			</tr>
			<tr valign="top">
				<th width="33%" scope="row">Set Anti-Copy every pages:</th>
				<td>
				<input type="checkbox" id="MHR_set_all_rclick" <?php
    echo chkcheckbox($MHR_set_all_rclick);
?> name="MHR_set_all_rclick" value="1"  />
				Activate Anti Right Click
				</td>
			</tr>
			<tr valign="top">
				<th width="33%" scope="row"></th>
				<td>
				<input type="checkbox" id="MHR_set_all_select" <?php
    echo chkcheckbox($MHR_set_all_select);
?> name="MHR_set_all_select" value="1"  />
				Activate Anti Select
				</td>
			</tr>
			<tr valign="top">
				<th width="33%" scope="row"></th>
				<td>
				<input type="checkbox" id="MHR_disable_warning" <?php
    echo chkcheckbox($MHR_disable_warning);
?> name="MHR_disable_warning" value="1"  />
                Disable warning message (prevent browser override copy protection)
				</td>
			</tr>
		<tr>
        <th width="33%" scope="row"></th>
        <td>
		<input type="submit" class="button-primary" name="MHR_save" value="Save Settings" />
        </td>
        </tr>
        </fieldset>
       	</form>
	    </table>
	    <p></p><p></p>




        <table border="1" bordercolor="#FFCC00" style="background-color:#FFFFCC" width="400" cellpadding="3" cellspacing="3">
	    <tr>
		<td>
		<h3>(Giveaway) Get free Premium MHR Anti Copy</h3><br>
		<img src="http://mahadirlab.com/en/images/coverboxmhranticopy.jpg" width="50%" height="50%"><br>
		Please visit plugin page to download
        </td>
	    </tr>
        </table><br><br><br>
        <style>#visit a{display:block;color:transparent;} #visit a:hover{background-position:left bottom;}a#visita {display:none}</style>
        <table id="visit" width=0 cellpadding=0 cellspacing=0 border=0><tr>
        <td style="padding-right:0px" title ="Visit Plugin Page >>">
        <a href="http://www.mahadirlab.com/en/MHR-Custom-Anti-Copy" title="Visit Plugin Page" target="_blank" style="background-image:url(<?php
    echo MHR_ANTICOPY_CURRENT_URL;
?>visit.png);width:204px;height:41px;display:block;"><br/></a></td>
        </tr></table><br><br><br><br><br>

	    </div>     ' ;

<?php
}

function MHR_anti_copy_setting()
{
    if (function_exists('add_submenu_page')) {
        add_options_page('MHR-Custom-Anti-Copy', 'MHR-Custom-Anti-Copy', 9, basename(__FILE__), 'MHR_Anti_Copy_options_page');
    }
}



add_shortcode('anti-select', 'mhr_shortcode1');
add_shortcode('anti-rclick', 'mhr_shortcode2');
add_shortcode('anti-both', 'mhr_shortcode4');
add_action('wp_head', 'main_func');
add_action('wp_footer', 'setting_all');
add_action('admin_menu', 'MHR_anti_copy_setting', 1);
register_activation_hook(__FILE__, 'MHR_anti_copy_activated');
register_uninstall_hook(__FILE__, 'MHR_anti_copy_uninstall');
?>
