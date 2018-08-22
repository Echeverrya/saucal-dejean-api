<?php

namespace Dejean\Api;

class Dapi_Preferences
{

    public function __construct()
    {
        //If necessary, we could use an add_action here...
    }

    /**
     * Save the preferences and the list into the database
     * @param $data
     * @return bool
     */
    public function save($data){
        $api_saved = false;
        $list_Saved = false;
        //Save the API URL
        if(!get_option("dapi_api_url")){
            $api_saved = add_option("dapi_api_url",$data['dapi_api_url']);
        }else{
            $api_saved = update_option("dapi_api_url",$data['dapi_api_url']);
        }
        //Save the elements
        if(!get_option("dapi_elements_list")){
            $list_Saved = add_option("dapi_elements_list",$data['dapi_elements_list']);
        }else{
            $list_Saved = update_option("dapi_elements_list",$data['dapi_elements_list']);
        }
        if(($api_saved == true) && ($list_Saved == true)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Load the preferences and the list from the database
     * @return array
     */
    public function load(){
        $data = array();
        $data["dapi_api_url"] = get_option("dapi_api_url");
        $data['dapi_elements_list'] = unserialize(get_option("dapi_elements_list"));
        return $data;
    }

}