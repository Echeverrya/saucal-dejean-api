<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; //Prevent direct access
}
?>

<?php
if(!empty($api_response)){ ?>
    <h4><?php echo __("Returned items:", "woocommerce-dejean-api"); ?></h4>
    <ul class="api_list_container">
        <?php foreach ($api_response as $item) { ?>
            <li><?php echo $item; ?></li>
        <?php } ?>
    </ul>
<?php }else{ ?>
    <div>
        <p style="text-align: center"><?php echo __("No items to display", "woocommerce-dejean-api"); ?></p>
    </div>
<?php } ?>
