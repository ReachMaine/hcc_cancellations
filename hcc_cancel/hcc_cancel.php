<?php
/**
 * @package hcc_cancelations
 * @version 0.1.1
 */

/*
Plugin Name:hcc_cancel

Description: This plugin adds [hcc_cancel], shortcode.  Generates a link to the cancellations page if there are any cancelations submitted
by a gravity form.
Version: 0.1

*/
defined( 'ABSPATH' ) or die( 'Direct access prohibited!' );

/**
 * [hcc_cancel]
 *
 * Returns the html link ot the link IF there a cancellations for today or tomorrow
 */
if (!function_exists('hcc_cancel_link')) {
  function hcc_cancel_link($atts) {
    $atts = shortcode_atts( array(
        'link_text' => 'View Cancelations',
  			'blogid' => '',
  			'formid' => '6',
        'field' => '2',
        'link' => 'www.ellsworthamericaninc.com/view-cancellations/',
  		), $atts, 'hcc_cancel' );
  	global $wpdb;

    $out_str = "";
    $link_text = $atts['link_text'];
    $formid = $atts['formid'];
    $blogid = $atts['blogid'];
    $fieldid = $atts['field'];
    $link =  $atts['link'];
    $table_name = 'ea_14_rg_lead_detail'; // for ea multisite $wpdb->base_prefix
    if ($blogid) {
        $table_name = $wpdb->base_prefix.$blogid."rg_lead_detail";
    } else {
        $table_name = $wpdb->prefix."rg_lead_detail";
    }


    $calquery = "SELECT * from $table_name where form_id='$formid' and field_number='$fieldid' ";
    $today_dt = new DateTime('today');
    $today_str = $today_dt->format("Y-m-d");
    $tomorrow_dt =  new DateTime('tomorrow');
    $tomorrow_str = $tomorrow_dt->format("Y-m-d");
    $calquery .= " and value in ('$today_str', '$tomorrow_str' )";
    $calresult = $wpdb->get_results($calquery);
    //echo "<pre>"; var_dump($calresult); echo "</pre>";
    $out_str = "";
    if ($calresult) {
      $out_str = "<a href='//$link' class='hcc_cancel_link'>$link_text</a>";
    } else {
      //$out_str = "<p>nope.</p>";
    }
    // return $calquery.$out_str;
  	return $out_str;
	}
}
add_shortcode('hcc_cancel', 'hcc_cancel_link');
