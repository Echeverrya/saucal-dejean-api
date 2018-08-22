<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; //Prevent direct access
}
?>

<div id="dapi_accordion">
    <h3 class="ui-state-active"><?php echo __("Settings", "woocommerce-dejean-api"); ?></h3>
    <div>
        <form id="alphanumeric_list_form" name="alphanumeric_list_form" action="" method="post">
            <div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="api_url"><?php echo __("API URL", "woocommerce-dejean-api"); ?></label>
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="api_url" id="api_url" value="<?php echo isset($dataLoaded['dapi_api_url']) ? $dataLoaded['dapi_api_url'] : 'http://www.exampleapi.com/v1/'; ?>"> <span><em><?php echo __("Please provide the URL on where the information will be fetched"); ?></em></span>
            </div>
            <div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="alphanumeric_list"><?php echo __("Enter the alphanumeric filters", "woocommerce-dejean-api"); ?></label>
                <select name="alphanumeric_list[]" id="alphanumeric_list" multiple="multiple">
                    <?php
                    if(isset($dataLoaded['dapi_elements_list'])){
                        foreach ($dataLoaded['dapi_elements_list'] as $item) { ?>
                            <option value="<?php echo $item ?>"><?php echo $item; ?></option>
                        <?php }
                    }
                    ?>
                </select>
                <input type="text" style="width: 80%;margin-right: 5px;" name="alphanumeric_item" id="alphanumeric_item" placeholder="<?php echo __("Type the filter...", "woocommerce-dejean-api"); ?>"/><button type="button" onclick="addNewItem()" name="add_item" id="add_item"><?php echo __("Add Item", "woocommerce-dejean-api"); ?></button>
                <span><em><?php echo __("Press 'Add Item' to add a new item. Select an item and press DELETE key to remove it"); ?></em></span>
            </div>
            <?php wp_nonce_field( 'alphanumeric_list_nonce' ); ?>
            <div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide" style="text-align: center;padding-top: 10px">
                <input type="hidden" name="action" value="fetch_api"/>
                <button type="button" onclick="fetchApi()"><?php echo __("Fetch API", "woocommerce-dejean-api"); ?></button>
            </div>
        </form>
    </div>
    <h3 class="<?php echo ($dataLoaded['need_fetch']) ? '' : 'ui-state-disabled' ?>"><?php echo __("Preview Data", "woocommerce-dejean-api"); ?></h3>
    <div>
        <div id="api_response" style="display: <?php echo ($dataLoaded['need_fetch'] == true) ? 'block' : 'none' ?>;">
            <?php require(DAPI_PLUGIN_DIR.'templates/elements_list.php'); ?>
        </div>
    </div>
</div>