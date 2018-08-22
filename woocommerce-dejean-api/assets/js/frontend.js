jQuery(document).ready(function(){
    //Accordion...
    jQuery( "#dapi_accordion" ).accordion({
        collapsible: true,
    });

    //Remove a selected item
    jQuery("#alphanumeric_list").keydown(function (e) {
       if(e.keyCode == 46){
           jQuery("option:selected",this).remove();
       }
    });

    //Add a new item
    jQuery("#alphanumeric_item").keydown(function (e) {
      if(e.keyCode == 13){
           //Add a new item
           addNewItem();
           return false;
       }
    });
});

//Add an item to the alphanumeric list
function addNewItem() {
    var regx = /^[A-Za-z0-9 _.-]+$/;
    if((jQuery.trim(jQuery("#alphanumeric_item").val()) != "") && (regx.test(jQuery.trim(jQuery("#alphanumeric_item").val())))){
        jQuery("#alphanumeric_list").append('<option value="'+jQuery("#alphanumeric_item").val()+'">'+jQuery("#alphanumeric_item").val()+'</option>');
        jQuery("#alphanumeric_item").val('').focus();
    }
}

//Save and fetch the API
function fetchApi() {
    jQuery("#alphanumeric_list option").attr("selected", true);
    jQuery("#alphanumeric_list_form").submit();
}

