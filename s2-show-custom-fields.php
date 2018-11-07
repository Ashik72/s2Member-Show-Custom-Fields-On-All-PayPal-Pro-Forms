<?php
/*
Plugin Name: s2Member Show Custom Fields On All Forms
Plugin URI: https://ashik72.me
Description: s2Member Show Custom Fields On All Forms Plugin
Version: 1.0.1
Author: ashik72
Author URI: https://ashik72.me
License: GPLv2 or later
Text Domain: s2_showfields
*/


require_once 'kint.phar';

/**
 * s2s2_showfields
 */
class s2s2_showfields
{

  private static $instance;

  public static function get_instance() {
      if ( ! isset( self::$instance ) ) {
          self::$instance = new self();
      }

      return self::$instance;
  }

  function __construct() {


    add_action('wp_footer', [$this, 'form_fields_mod'], 10000, 1);
    add_action('template_redirect', [$this, 'update_s2_global']);

  }

  public function update_s2_global() {

    if (!is_user_logged_in()) return;

    $global_data = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"];
    $global_data = json_decode($global_data);


    foreach ($global_data as $key => $data)
      $global_data[$key]->deflt = get_user_field($global_data[$key]->id);

    $global_data = json_encode($global_data);

    $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"] = $global_data;
  }


  public function form_fields_mod($attr)
  {
    ?>

    <script type="text/javascript">

    jQuery(document).ready(function($) {
      $("#s2member-pro-paypal-checkout-form-custom-fields-section").css('display', 'block');

      $("#s2member-pro-paypal-checkout-form-custom-fields-section input[type='text']").each(function(index, el) {
        $(this).prop("disabled", false);
      });

    });
    </script>

    <?php
  }


}

s2s2_showfields::get_instance();
