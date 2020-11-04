<?php

namespace wpsync\webspark;

class Product_Import
{
    public static function create($data){
        $post_data = array(
            'post_title'    => $data->name,
            'post_content'  => $data->description,
            'post_status'   => 'publish',
            'post_type' => "product",
        );
        $price = str_replace('$', '', $data->price);
        $post_id = wp_insert_post($post_data);
        update_post_meta($post_id,'_sku',$data->sku);
        update_post_meta($post_id,'_price',$price);
        update_post_meta($post_id,'_regular_price',$price);
        update_post_meta($post_id,'_stock',$data->in_stock);
        update_post_meta($post_id,'webspark_product_image',$data->picture);
        wc_delete_product_transients();
    }

    public static function check_post($sku){
        $product_id = wc_get_product_id_by_sku( $sku );
        if($product_id){
            return $product_id;
        }
        return false;
    }

    public static function update($post_id, $data){
        $post_data = array(
            'ID'    => $post_id,
            'post_content'  => $data->description,
            'post_title'    => $data->name,
            'post_type' => "product",
        );
        wp_update_post( wp_slash($post_data) );
        $price = str_replace('$', '', $data->price);
        update_post_meta($post_id,'_sku',$data->sku);
        update_post_meta($post_id,'_price',$price);
        update_post_meta($post_id,'_regular_price',$price);
        update_post_meta($post_id,'_stock',$data->in_stock);
        update_post_meta($post_id,'webspark_product_image',$data->picture);
        wc_delete_product_transients();
    }

    public static function delete(){

    }
}