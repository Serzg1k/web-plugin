<?php

namespace wpsync\webspark;

use GuzzleHttp\Client;

class Wpsync_Webspark
{

    private static $instance;

    protected $guzzle;

    protected function __construct()
    {

        $client = new Client([
            'base_uri' => 'https://my.api.mockaroo.com/',
            'headers' => ['X-API-Key' => '89b23a40']
        ]);
        $this->guzzle = $client;
    }

    public static function get_instance()
    {
        if (self::$instance != null) {
            return self::$instance;
        }
        return new self;
    }

    public function get_api_data()
    {
        $request = $this->guzzle->get('products.json');
        if ($request->getStatusCode() === 200) {
            return $request->getBody()->getContents();
        }
        return false;
    }

    public function get_cron_data()
    {
        $data = $this->get_api_data();
        if ($data) {
            return $data;
//            set_transient('webspark', $data, 600);
//            update_option('qwerty', $data);
        }
    }

    // @todo need send data
    public function send_order_data($id=1){

        $request = $this->guzzle->post('order.json', [
            'json' => [
                [
                    'name' =>'sku', 'contents' => '[{"sku": "07faf775-9190-4737-b47d-112e6dc3f05a","items": 1}]'
                ]
            ]
        ]);
        if ($request->getStatusCode() === 200) {
            return $request->getBody()->getContents();
        }
    }
}