<?php

namespace wpsync\webspark;

use wpsync\webspark\Wpsync_Webspark;
use wpsync\webspark\Product_Import;

class Wpsync_Cron
{
    public function __construct()
    {
        add_filter('cron_schedules', [$this, 'cron_add_five_min']);
        add_action('wp', [$this, 'activation']);
        add_action('get_product_event', [$this, 'get_products_cron']);
    }

    function cron_add_five_min($schedules)
    {
        $schedules['five_min'] = array(
            'interval' => 60 * 60,
            'display' => '2 min'
        );
        return $schedules;
    }

    function activation()
    {
        if (!wp_next_scheduled('get_product_event')) {
            wp_schedule_event(time(), 'hourly', 'get_product_event');
        }
    }

    function get_products_cron()
    {
        $datas = json_decode(Wpsync_Webspark::get_instance()->get_api_data());
        if(!empty($datas)){
            foreach ($datas as $data) {
                $post_id = Product_Import::check_post($data->sku);
                if(!$post_id) {
                    Product_Import::create($data);
                }else{
                    Product_Import::update($post_id, $data);
                }
            }
        }
        //Product_Import::create();
    }
}