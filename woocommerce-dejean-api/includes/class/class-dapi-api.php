<?php

namespace Dejean\Api;

class Dapi_Api
{

    public function __construct()
    {
        //If necessary, we could use an add_action here...
    }

    /**
     * GET a content from an API
     * @param $elements
     * @return array|mixed|object
     */
    public function getContent($elements){
        if(is_array($elements)){
            /*
             *  SAMPLE OF A REQUEST....
             *  The code below was PURPOSELY commented because there was no real URL.
             *
             * */
            /*$transient = get_transient( 'dapi_cache' );
            $api_url = (get_option(dapi_api_url) == false) ? "http://www.exampleapi.com/v1/" : get_option('dapi_api_url');
            if( ! empty( $transient ) ) {
                return $transient;
            }
            $args = array(
                'headers' => array(
                    'Authorization' => 'Basic ' . base64_encode('dapi_username_sample:dapi_password_sample')
                ),
                'body' => array(
                    'data' => $elements
                )
            );
            $response = wp_remote_get($api_url,$args);
            try{
                $decoded_json = json_decode($response['body']);
            } catch ( Exception $ex){
                $decoded_json = json_decode(array());
            }
            set_transient( 'dapi_cache',$decoded_json, DAY_IN_SECONDS );
            return json_decode($response);*/
            return array("STATIC response item 1", "STATIC response item 2", "STATIC response item 3");
        }else{
            return array();
        }
    }

}