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
			'blogid' => '14',
			'formid' => '6',
      'field' => '2',
      'link' => 'www.ellsworthamericaninc.com/view-cancellations/',
		), $atts, 'hcc_cancel' );

	global $wpdb;
  $calquery = "SELECT * from ea_14_rg_lead_detail where form_id=".$atts['formid']." and field_number=".$atts['field']." ";
  $today_dt = new DateTime('today');
  $today_str = $today_dt->format("Y-m-d");
  $tomorrow_dt =  new DateTime('tomorrow');
  $tomorrow_str = $tomorrow->format("Y-m-d");
  $calquery .= " anc value in ()'".$today_str."', '".$tomorrow_str."' )";

	return $calquery;
	}
}
add_shortcode('hcc_cancel', 'hcc_cancel_link');
