jQuery(document).ready(function() {
    if (jQuery('').datepicker != null) {
        jQuery('.date-picker').datepicker({format: 'dd.mm.yyyy'});
    }
    if (jQuery('').mask != null) {
        jQuery(".phone-number").mask("8 (099) 999-99-99");
        jQuery.mask.definitions['я']='[а-яА-Яa-zA-Z]';
        jQuery(".passport-id").mask("яя 9999999");
        jQuery(".contract_number").mask("9999999");
    }
    if (jQuery('').htmlarea != null) {
        jQuery("textarea.html-area:visible").htmlarea();
    }
    if (jQuery('').popover != null) {
        jQuery('.tooltip-balloon').popover({html:true,trigger:'hover'});
    }
    
    if (jQuery('').tab != null) {
      $('.nav.nav-tabs a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
      })
    }
    if (jQuery('').affix != null) {
      $('.affix_menu').affix();
    }
    initAddressHandlers();
});

function redirect_to(url) {
    window.location.replace(url);
}

function redirect_to_back(url_if_history_empty) {
    if (document.referrer != "" && window.history.length > 0) {
        window.history.go(-1);
    } else if (url_if_history_empty != null) {
        redirect_to(url_if_history_empty);
    } else {
        redirect_to('/');
    }
}

function initAddressHandlers()
{
	jQuery('#city_id').change(handleCityChange);
	jQuery('#street_id').change(handleStreetChange);
	jQuery('#house_id').change(handleHouseChange);
}

function handleCityChange()
{
  jQuery('.city_id_selected').hide();
  jQuery('.street_id_selected').hide();
  jQuery('.house_id_selected').hide();
  jQuery('#street_id_container').html('');
  jQuery('#house_id_container').html('');

	var city = jQuery('#city_id');
  if (city.val() != '') {
    if (jQuery('#street_id_container').length > 0) {
      jQuery('.address_loading').show();
      jQuery.ajax('/address/' + city.val() + '/streets', {
        success: function(data){
          jQuery('.address_loading').hide();
          jQuery('.city_id_selected').show();
          jQuery('#street_id_container').html(data);
          jQuery('#street_id').change(handleStreetChange);
        },
        error: function(data){
          alert(data.statusText);
        }
      });
    } else {
      jQuery('.city_id_selected').show();
    }
    
    if (jQuery('#billing_tariff_id_container').length > 0) {
      jQuery.ajax('/address/' + city.val() + '/tariffs', {
        success: function(data){
          jQuery('#billing_tariff_id_container').html(data);
        },
        error: function(data){
          alert(data.statusText);
        }
      });
    }
  }
}

function handleStreetChange()
{
  var street = jQuery('#street_id');

  jQuery('.street_id_selected').hide();
  jQuery('.house_id_selected').hide();
  jQuery('#house_id_container').html('');
  
  if (street.val() != '') {
    if (jQuery('#house_id_container').length > 0) {
      jQuery('.address_loading').show();
      jQuery.ajax('/address/' + street.val() + '/houses', {
        success: function(data){
          jQuery('.address_loading').hide();
          jQuery('.street_id_selected').show();
          jQuery('#house_id_container').html(data);
          jQuery('#house_id').change(handleHouseChange);
        },
        error: function(data){
          alert(data.statusText);
        }
      });
    } else {
      jQuery('.street_id_selected').show();
    } 
  }
}

function handleHouseChange()
{
  var house = jQuery('#house_id');
  if (house.val() != '') {
    jQuery('.house_id_selected').show();
  } else {
    jQuery('.house_id_selected').hide();
  }
}