<?php
function slugify($string)
{
  // Convert the string to lowercase
  $string = strtolower($string);

  // Replace spaces and special characters with dashes
  $string = preg_replace('/[^a-z0-9]+/', '_', $string);

  // Remove leading and trailing dashes
  $string = trim($string, '_');

  return $string;
}

function pr($data)
{
  echo '<style>
  #debug_wrapper {
    position: fixed;
    top: 0px;
    left: 0px;
    z-index: 999;
    background: #fff;
    color: #000;
    overflow: auto;
    width: 100%;
    height: 100%;
  }</style>';
    echo '<div id="debug_wrapper"><pre>';

    print_r($data); // or var_dump($data);
    echo "</pre></div>";
    die;

}


//function get user points by id user
function get_user_points_by_id($atts) {
  if ( is_plugin_active( 'woocommerce-points-and-rewards/woocommerce-points-and-rewards.php' ) ) {
    global $wpdb;
    $user_id = intval($atts);

    if ($user_id <= 0) {
        return 0;
    }

    $points = $wpdb->get_var($wpdb->prepare("
        SELECT SUM(points_balance) 
        FROM fcs_data_wc_points_rewards_user_points 
        WHERE user_id = %d", 
        $user_id
    ));

    if ($points === null) {
        return 0;
    }

    return $points;
    
  } else {
    return;
  }
}

