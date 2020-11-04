<?php

/**
 *
 * @wordpress-plugin
 * Plugin Name:       Wpsync webspark
 * Description:       wpsync webspark
 * Version:           1.0.0
 * Author:            Sergey
 * Text Domain:       webspark
 */

if ( ! defined( 'WEBSPARK_PLUGIN_FILE' ) ) {
    define( 'WEBSPARK_PLUGIN_FILE', __FILE__ );
}
if ( ! defined( 'WEBSPARK_PLUGIN_DIR' ) ) {
    define( 'WEBSPARK_PLUGIN_DIR', __DIR__ );
}

require_once WEBSPARK_PLUGIN_DIR . '/vendor/autoload.php';
require_once WEBSPARK_PLUGIN_DIR . '/classes/class-wpsync-webspark.php';
require_once WEBSPARK_PLUGIN_DIR . '/classes/class-wpsync-cron.php';
require_once WEBSPARK_PLUGIN_DIR . '/classes/class-product-import.php';

$cron = new \wpsync\webspark\Wpsync_Cron();

register_deactivation_hook( __FILE__, 'deactivation_webspark_cron');
function deactivation_webspark_cron() {
    wp_clear_scheduled_hook('my_five_min_event');
}
//dump(json_decode(get_transient('webspark')));
//$datas = get_option('qwerty')[0];
//foreach ($datas as $data) {
//    $post_id = \wpsync\webspark\Product_Import::check_post($data->sku);
//    if(!$post_id) {
//        \wpsync\webspark\Product_Import::create($data);
//    }else{
//        \wpsync\webspark\Product_Import::update($post_id, $data);
//    }
//}
//dump(get_option('qwerty'));
//dump(\wpsync\webspark\Wpsync_Webspark::get_instance()->send_order_data());