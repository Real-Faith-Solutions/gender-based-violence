var rootURL = location.origin+'/';

function changeRootURL(url){
    rootURL = url;
}

// Get case status and disable editing if status is "Closed"

if(($('#case_no').val()) && (location.href.includes('edit-created-case'))){ // If Encoded and Edit page

  $.ajax({
    url: rootURL + 'api/v1/case/get-case-status/' + $('#case_no').val(),
    success: function (case_status) {

      if(case_status == 'Closed'){

        Swal.fire({
          icon: 'error',
          title: 'Case Closed',
          text: 'This case is already closed editing will be disabled',
          showConfirmButton: false,
          timer: 5000
        });

        // Hide submit, save and upload button
        $('* [value="Add Multiple Record"]').attr('hidden','hidden');
        $('* [value="Add Multiple Intervention"]').attr('hidden','hidden');
        $('* [value="Submit"]').attr('hidden','hidden');
        $('* [value="Save"]').attr('hidden','hidden');
        $('#upload_button').attr('hidden','hidden');

        // removed onclick delete function on additional record
        $('[onclick^="deleteSpecificAdditionalFamilyBackgroundModal"]').removeAttr('onclick');
        $('[onclick^="deleteSpecificAdditionalIncidenceDetailsModal"]').removeAttr('onclick');
        $('[onclick^="deleteSpecificAdditionalPerpetratorDetailsModal"]').removeAttr('onclick');
        $('[onclick^="deleteSpecificAdditionalInterventionModuleModal"]').removeAttr('onclick');
        $('[onclick^="deleteCaseUploadedFilesModal"]').removeAttr('onclick');

        // removed onclick closed modal function on additional record
        $('[onclick^="closeAdditionalFamilyBackgroundForm"]').removeAttr('onclick');
        $('[onclick^="closeAdditionalIncidenceDetailsForm"]').removeAttr('onclick');
        $('[onclick^="closeAdditionalPerpetratorDetailsForm"]').removeAttr('onclick');
        $('[onclick^="closeAdditionalInterventionModuleForm"]').removeAttr('onclick');

        // Make input, select, and textarea disabled and readonly
        $('* [type="checkbox"]').attr('disabled','disabled');
        $('* [type="radio"]').attr('disabled','disabled');
        $('* input').attr('readonly','readonly');
        $('* select').attr('disabled','disabled');
        $('* textarea').attr('readonly','readonly');
  
      }
    }
  });
}

$(document).ready(function(){

  // Get case_no and deploy on modal forms on edit case

  var caseNo = $('#case_no').val();

  $('#fam_back_case_no_modal').val(caseNo);
  $('#inci_det_case_no_modal').val(caseNo);
  $('#perp_det_case_no_modal').val(caseNo);
  $('#inter_mod_case_no_modal').val(caseNo);

  $('#case_no').on("change", function(){

    Swal.fire({
      icon: 'question',
      title: 'Validating...',
      text: 'Validating Case No. if not in use',
      showConfirmButton: false,
      timer: 2000
    })
    
    // Get case_no and deploy on modal forms on create case

    var caseNo = $('#case_no').val();

    $('#fam_back_case_no_modal').val(caseNo);
    $('#inci_det_case_no_modal').val(caseNo);
    $('#perp_det_case_no_modal').val(caseNo);
    $('#inter_mod_case_no_modal').val(caseNo);

    // Check if Case No. is already recorded in the database

    $.ajax({
        url: rootURL + 'api/v1/case/validate-case-no/' + $('#case_no').val(),
        success: function (result) {
            if(result == 'Case No. already exists on the database'){
              Swal.fire({
                icon: 'error',
                title: 'Stop',
                text: 'Case No. already exists on the database',
              })
            }else{
              Swal.fire({
                icon: 'success',
                title: 'Passed',
                text: 'You may proceed encoding',
                showConfirmButton: false,
                timer: 2000
              })
            }        
        }
    });

  });

  // Calculate Age

  // Personal Details
  $('[name="birth_date"]').on('change', function(){
    dob = new Date($('[name="birth_date"]').val());
    var today = new Date();
    var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
    $('[name="age"]').val(age);
  });

  // Perpetrator Details
  $('[name="perp_d_birthdate"]').on('change', function(){
  dob = new Date($('[name="perp_d_birthdate"]').val());
  var today = new Date();
  var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
  $('[name="perp_d_age"]').val(age);
  });

  // Perpetrator Details Modal
  $('[name="perp_d_birthdate_modal"]').on('change', function(){
  dob = new Date($('[name="perp_d_birthdate_modal"]').val());
  var today = new Date();
  var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
  $('[name="perp_d_age_modal"]').val(age);
  });

  // Disable Dashboard GBV Cases Reporting per Month year input field
  $('#year_select').on('change', function(){
    $('#year_input').attr('disabled','disabled');
    $('#year_input').val($('#year_select').val());
  });

  // Disable Dashboard GBV Cases Reporting per Month year select field
  $('#year_input').on('change', function(){
    $('#year_select').attr('disabled','disabled');
    $('#year_select').val($('#year_input').val());
  });

});

function showHideFunction(checkBoxID, componentID) {
    var isBoxChecked = $(checkBoxID).is(":checked");

    if (isBoxChecked == true) {
        $(componentID).show();
    } else {
        $(componentID).hide();
    }
}

function showHideMicro5(checkBoxID, componentID) {
    var isBoxChecked = $(checkBoxID).is(":checked");

    if (isBoxChecked == true) {
        $('#micr_form_1').show();
        $('#micr_form_2').show();
        $('#micr_form_3').show();
        $('#micr_form_4').show();
    } else {
        $('#micr_form_1').hide();
        $('#micr_form_2').hide();
        $('#micr_form_3').hide();
        $('#micr_form_4').hide();
    }
}

$(document).ready(function () {

    var current_fs, next_fs, previous_fs; //fieldsets
    var opacity;

    $(".next").click(function () {

        current_fs = $(this).parent();
        next_fs = $(this).parent().next();

        //Add Class Active
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

        //show the next fieldset
        next_fs.show();
        //hide the current fieldset with style
        current_fs.animate({ opacity: 0 }, {
            step: function (now) {
                // for making fielset appear animation
                opacity = 1 - now;

                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                next_fs.css({ 'opacity': opacity });
            },
            duration: 600
        });
    });

    $(".previous").click(function () {

        current_fs = $(this).parent();
        previous_fs = $(this).parent().prev();

        //Remove class active
        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

        //show the previous fieldset
        previous_fs.show();

        //hide the current fieldset with style
        current_fs.animate({ opacity: 0 }, {
            step: function (now) {
                // for making fielset appear animation
                opacity = 1 - now;

                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                previous_fs.css({ 'opacity': opacity });
            },
            duration: 600
        });
    });

    $('.radio-group .radio').click(function () {
        $(this).parent().find('.radio').removeClass('selected');
        $(this).addClass('selected');
    });

    $(".submit").click(function () {
        return false;
    })

});

// Automated Dropdowns Location

var my_handlers = {

    // Personal Details
    fill_provinces: function () {

        var region_code = $(this).val();
        $('#province').ph_locations('fetch_list', [{ "region_code": region_code }]);

    },

    fill_cities: function () {

        var province_code = $(this).val();
        $('#city').ph_locations('fetch_list', [{ "province_code": province_code }]);
    },


    fill_barangays: function () {

        var city_code = $(this).val();
        $('#barangay').ph_locations('fetch_list', [{ "city_code": city_code }]);
    },

    // Family Background
    fill_provinces_fb: function () {

        var region_code = $(this).val();
        $('#fam_back_province').ph_locations('fetch_list', [{ "region_code": region_code }]);
    },

    fill_cities_fb: function () {

        var province_code = $(this).val();
        $('#fam_back_city').ph_locations('fetch_list', [{ "province_code": province_code }]);
    },


    fill_barangays_fb: function () {

        var city_code = $(this).val();
        $('#fam_back_barangay').ph_locations('fetch_list', [{ "city_code": city_code }]);
    },

    // Incidence Details
    fill_provinces_id: function () {

        var region_code = $(this).val();
        $('#inci_det_province').ph_locations('fetch_list', [{ "region_code": region_code }]);

    },

    fill_cities_id: function () {

        var province_code = $(this).val();
        $('#inci_det_city').ph_locations('fetch_list', [{ "province_code": province_code }]);
    },


    fill_barangays_id: function () {

        var city_code = $(this).val();
        $('#inci_det_barangay').ph_locations('fetch_list', [{ "city_code": city_code }]);
    },

    // Perpetrator Details
    fill_provinces_pd: function () {

        var region_code = $(this).val();
        $('#perp_d_province').ph_locations('fetch_list', [{ "region_code": region_code }]);

    },

    fill_cities_pd: function () {

        var province_code = $(this).val();
        $('#perp_d_city').ph_locations('fetch_list', [{ "province_code": province_code }]);
    },


    fill_barangays_pd: function () {

        var city_code = $(this).val();
        $('#perp_d_barangay').ph_locations('fetch_list', [{ "city_code": city_code }]);
    },

    // User Address
    fill_provinces_ua: function () {

        var region_code = $(this).val();
        $('#user_province').ph_locations('fetch_list', [{ "region_code": region_code }]);

    },

    fill_cities_ua: function () {

        var province_code = $(this).val();
        $('#user_municipality').ph_locations('fetch_list', [{ "province_code": province_code }]);
    },


    fill_barangays_ua: function () {

        var city_code = $(this).val();
        $('#user_barangay').ph_locations('fetch_list', [{ "city_code": city_code }]);
    },

    // Additional Family Background Address
    fill_provinces_afb: function () {

        var region_code = $(this).val();
        $('#fam_back_province_modal').ph_locations('fetch_list', [{ "region_code": region_code }]);

    },

    fill_cities_afb: function () {

        var province_code = $(this).val();
        $('#fam_back_city_modal').ph_locations('fetch_list', [{ "province_code": province_code }]);
    },


    fill_barangays_afb: function () {

        var city_code = $(this).val();
        $('#fam_back_barangay_modal').ph_locations('fetch_list', [{ "city_code": city_code }]);
    },

    // Additional Incidence Details Address
    fill_provinces_aid: function () {

        var region_code = $(this).val();
        $('#inci_det_province_modal').ph_locations('fetch_list', [{ "region_code": region_code }]);

    },

    fill_cities_aid: function () {

        var province_code = $(this).val();
        $('#inci_det_city_modal').ph_locations('fetch_list', [{ "province_code": province_code }]);
    },


    fill_barangays_aid: function () {

        var city_code = $(this).val();
        $('#inci_det_barangay_modal').ph_locations('fetch_list', [{ "city_code": city_code }]);
    },

    // Additional Perpetrator Details Address
    fill_provinces_aperp_d: function () {

        var region_code = $(this).val();
        $('#perp_d_province_modal').ph_locations('fetch_list', [{ "region_code": region_code }]);

    },

    fill_cities_aperp_d: function () {

        var province_code = $(this).val();
        $('#perp_d_city_modal').ph_locations('fetch_list', [{ "province_code": province_code }]);
    },


    fill_barangays_aperp_d: function () {

        var city_code = $(this).val();
        $('#perp_d_barangay_modal').ph_locations('fetch_list', [{ "city_code": city_code }]);
    }
};

$(function () {

    // Personal Details
    $('#region').on('change', my_handlers.fill_provinces);
    $('#province').on('change', my_handlers.fill_cities);
    $('#city').on('change', my_handlers.fill_barangays);

    $('#region').ph_locations({ 'location_type': 'regions' });
    $('#province').ph_locations({ 'location_type': 'provinces' });
    $('#city').ph_locations({ 'location_type': 'cities' });
    $('#barangay').ph_locations({ 'location_type': 'barangays' });
    $('#region').ph_locations('fetch_list');


    // Change select option to input box if Error fetching PH Location dropdown list
    $('#region').on('click',function(){

      if($('#region option:selected').val() == ''){

        $('#region').parent().empty().html(`
          <span><p class="card-text">Region<span class="asterisk">*</span></p></span>
          <input type="text" id="region_id" name="region" placeholder="Error Fetching PH Location" class="w-100 form-control"/>
        `);
        $('#province').parent().empty().html(`
          <span><p class="card-text">Province<span class="asterisk">*</span></p></span>
          <input type="text" id="province_id" name="province" placeholder="Error Fetching PH Location" class="w-100 form-control"/>
        `);
        $('#city').parent().empty().html(`
          <span><p class="card-text">City/Municipality<span class="asterisk">*</span></p></span>
          <input type="text" id="city_id" name="city" placeholder="Error Fetching PH Location" class="w-100 form-control"/>
        `);
        $('#barangay').parent().empty().html(`
          <span><p class="card-text">Barangay<span class="asterisk">*</span></p></span>
          <input type="text" id="barangay_id" name="barangay" placeholder="Error Fetching PH Location" class="w-100 form-control"/>
        `);

      }
    });

    // Family Background
    $('#fam_back_region').on('change', my_handlers.fill_provinces_fb);
    $('#fam_back_province').on('change', my_handlers.fill_cities_fb);
    $('#fam_back_city').on('change', my_handlers.fill_barangays_fb);

    $('#fam_back_region').ph_locations({ 'location_type': 'regions' });
    $('#fam_back_province').ph_locations({ 'location_type': 'provinces' });
    $('#fam_back_city').ph_locations({ 'location_type': 'cities' });
    $('#fam_back_barangay').ph_locations({ 'location_type': 'barangays' });
    $('#fam_back_region').ph_locations('fetch_list');

    // Change select option to input box if Error fetching PH Location dropdown list
    $('#fam_back_region').on('click',function(){

      if($('#fam_back_region option:selected').val() == ''){

        $('#fam_back_region').parent().empty().html(`
          <span><p class="card-text">Region<span class="asterisk">*</span></p></span>
          <input type="text" id="fam_back_region_id" name="fam_back_region" placeholder="Error Fetching PH Location" class="w-100 form-control"/>
        `);
        $('#fam_back_province').parent().empty().html(`
          <span><p class="card-text">Province<span class="asterisk">*</span></p></span>
          <input type="text" id="fam_back_province_id" name="fam_back_province" placeholder="Error Fetching PH Location" class="w-100 form-control"/>
        `);
        $('#fam_back_city').parent().empty().html(`
          <span><p class="card-text">City/Municipality<span class="asterisk">*</span></p></span>
          <input type="text" id="fam_back_city_id" name="fam_back_city" placeholder="Error Fetching PH Location" class="w-100 form-control"/>
        `);
        $('#fam_back_barangay').parent().empty().html(`
          <span><p class="card-text">Barangay<span class="asterisk">*</span></p></span>
          <input type="text" id="fam_back_barangay_id" name="fam_back_barangay" placeholder="Error Fetching PH Location" class="w-100 form-control"/>
        `);

      }                                      
    });

    // Incidence Details
    $('#inci_det_region').on('change', my_handlers.fill_provinces_id);
    $('#inci_det_province').on('change', my_handlers.fill_cities_id);
    $('#inci_det_city').on('change', my_handlers.fill_barangays_id);

    $('#inci_det_region').ph_locations({ 'location_type': 'regions' });
    $('#inci_det_province').ph_locations({ 'location_type': 'provinces' });
    $('#inci_det_city').ph_locations({ 'location_type': 'cities' });
    $('#inci_det_barangay').ph_locations({ 'location_type': 'barangays' });
    $('#inci_det_region').ph_locations('fetch_list');

    // Change select option to input box if Error fetching PH Location dropdown list
    $('#inci_det_region').on('click',function(){

      if($('#inci_det_region option:selected').val() == ''){

        $('#inci_det_region').parent().empty().html(`
          <span><p class="card-text">Region<span class="asterisk">*</span></p></span>
          <input type="text" id="inci_det_region_id" name="inci_det_region" placeholder="Error Fetching PH Location" class="w-100 form-control"/>
        `);
        $('#inci_det_province').parent().empty().html(`
          <span><p class="card-text">Province<span class="asterisk">*</span></p></span>
          <input type="text" id="inci_det_province_id" name="inci_det_province" placeholder="Error Fetching PH Location" class="w-100 form-control"/>
        `);
        $('#inci_det_city').parent().empty().html(`
          <span><p class="card-text">City/Municipality<span class="asterisk">*</span></p></span>
          <input type="text" id="inci_det_city_id" name="inci_det_city" placeholder="Error Fetching PH Location" class="w-100 form-control"/>
        `);
        $('#inci_det_barangay').parent().empty().html(`
          <span><p class="card-text">Barangay<span class="asterisk">*</span></p></span>
          <input type="text" id="inci_det_barangay_id" name="inci_det_barangay" placeholder="Error Fetching PH Location" class="w-100 form-control"/>
        `);
                                            
      }
    });

    // Perpetrator Details
    $('#perp_d_region').on('change', my_handlers.fill_provinces_pd);
    $('#perp_d_province').on('change', my_handlers.fill_cities_pd);
    $('#perp_d_city').on('change', my_handlers.fill_barangays_pd);

    $('#perp_d_region').ph_locations({ 'location_type': 'regions' });
    $('#perp_d_province').ph_locations({ 'location_type': 'provinces' });
    $('#perp_d_city').ph_locations({ 'location_type': 'cities' });
    $('#perp_d_barangay').ph_locations({ 'location_type': 'barangays' });
    $('#perp_d_region').ph_locations('fetch_list');

    // Change select option to input box if Error fetching PH Location dropdown list
    $('#perp_d_region').on('click',function(){

      if($('#perp_d_region option:selected').val() == ''){

        $('#perp_d_region').parent().empty().html(`
          <span><p class="card-text">Region<span class="asterisk">*</span></p></span>
          <input type="text" id="perp_d_region_id" name="perp_d_region" placeholder="Error Fetching PH Location" class="w-100 form-control"/>
        `);
        $('#perp_d_province').parent().empty().html(`
          <span><p class="card-text">Province<span class="asterisk">*</span></p></span>
          <input type="text" id="perp_d_province_id" name="perp_d_province" placeholder="Error Fetching PH Location" class="w-100 form-control"/>
        `);
        $('#perp_d_city').parent().empty().html(`
          <span><p class="card-text">City/Municipality<span class="asterisk">*</span></p></span>
          <input type="text" id="perp_d_city_id" name="perp_d_city" placeholder="Error Fetching PH Location" class="w-100 form-control"/>
        `);
        $('#perp_d_barangay').parent().empty().html(`
          <span><p class="card-text">Barangay<span class="asterisk">*</span></p></span>
          <input type="text" id="perp_d_barangay_id" name="perp_d_barangay" placeholder="Error Fetching PH Location" class="w-100 form-control"/>
        `);
                                              
      }
    });

    // User Address
    $('#user_region').on('change', my_handlers.fill_provinces_ua);
    $('#user_province').on('change', my_handlers.fill_cities_ua);
    $('#user_municipality').on('change', my_handlers.fill_barangays_ua);

    $('#user_region').ph_locations({ 'location_type': 'regions' });
    $('#user_province').ph_locations({ 'location_type': 'provinces' });
    $('#user_municipality').ph_locations({ 'location_type': 'cities' });
    $('#user_barangay').ph_locations({ 'location_type': 'barangays' });
    $('#user_region').ph_locations('fetch_list');

    // Change select option to input box if Error fetching PH Location dropdown list
    $('#user_region').on('click',function(){

      if($('#user_region option:selected').val() == ''){

        $('#user_region').parent().empty().html(`
          <span><p class="card-text">Region<span class="asterisk">*</span></p></span>
          <input type="text" id="user_region_id" name="user_region" placeholder="Error Fetching PH Location" class="w-100 form-control" required/>
        `);
        $('#user_province').parent().empty().html(`
          <span><p class="card-text">Province<span class="asterisk">*</span></p></span>
          <input type="text" id="user_province_id" name="user_province" placeholder="Error Fetching PH Location" class="w-100 form-control" required/>
        `);
        $('#user_municipality').parent().empty().html(`
          <span><p class="card-text">City/Municipality<span class="asterisk">*</span></p></span>
          <input type="text" id="user_municipality_id" name="user_municipality" placeholder="Error Fetching PH Location" class="w-100 form-control" required/>
        `);
        $('#user_barangay').parent().empty().html(`
          <span><p class="card-text">Barangay<span class="asterisk">*</span></p></span>
          <input type="text" id="user_barangay_id" name="user_barangay" placeholder="Error Fetching PH Location" class="w-100 form-control" required/>
        `);
                                            
      }
    });

    // Additional Family Background Address
    $('#fam_back_region_modal').on('change', my_handlers.fill_provinces_afb);
    $('#fam_back_province_modal').on('change', my_handlers.fill_cities_afb);
    $('#fam_back_city_modal').on('change', my_handlers.fill_barangays_afb);

    $('#fam_back_region_modal').ph_locations({ 'location_type': 'regions' });
    $('#fam_back_province_modal').ph_locations({ 'location_type': 'provinces' });
    $('#fam_back_city_modal').ph_locations({ 'location_type': 'cities' });
    $('#fam_back_barangay_modal').ph_locations({ 'location_type': 'barangays' });
    $('#fam_back_region_modal').ph_locations('fetch_list');

    // Change select option to input box if Error fetching PH Location dropdown list
    $('#fam_back_region_modal').on('click',function(){

      if($('#fam_back_region_modal option:selected').val() == ''){

        $('#fam_back_region_modal').parent().empty().html(`
          <span><p class="card-text">Region<span class="asterisk">*</span></p></span>
          <input type="text" id="fam_back_region_modal_id" name="fam_back_region_modal" placeholder="Error Fetching PH Location" class="w-100 form-control" required/>
        `);
        $('#fam_back_province_modal').parent().empty().html(`
          <span><p class="card-text">Province<span class="asterisk">*</span></p></span>
          <input type="text" id="fam_back_province_modal_id" name="fam_back_province_modal" placeholder="Error Fetching PH Location" class="w-100 form-control" required/>
        `);
        $('#fam_back_city_modal').parent().empty().html(`
          <span><p class="card-text">City/Municipality<span class="asterisk">*</span></p></span>
          <input type="text" id="fam_back_city_modal_id" name="fam_back_city_modal" placeholder="Error Fetching PH Location" class="w-100 form-control" required/>
        `);
        $('#fam_back_barangay_modal').parent().empty().html(`
          <span><p class="card-text">Barangay<span class="asterisk">*</span></p></span>
          <input type="text" id="fam_back_barangay_modal_id" name="fam_back_barangay_modal" placeholder="Error Fetching PH Location" class="w-100 form-control" required/>
        `);
                                            
      }
    });

    // Additional Incidence Details Address
    $('#inci_det_region_modal').on('change', my_handlers.fill_provinces_aid);
    $('#inci_det_province_modal').on('change', my_handlers.fill_cities_aid);
    $('#inci_det_city_modal').on('change', my_handlers.fill_barangays_aid);

    $('#inci_det_region_modal').ph_locations({ 'location_type': 'regions' });
    $('#inci_det_province_modal').ph_locations({ 'location_type': 'provinces' });
    $('#inci_det_city_modal').ph_locations({ 'location_type': 'cities' });
    $('#inci_det_barangay_modal').ph_locations({ 'location_type': 'barangays' });
    $('#inci_det_region_modal').ph_locations('fetch_list');

    // Change select option to input box if Error fetching PH Location dropdown list
    $('#inci_det_region_modal').on('click',function(){

      if($('#inci_det_region_modal option:selected').val() == ''){

        $('#inci_det_region_modal').parent().empty().html(`
          <span><p class="card-text">Region<span class="asterisk">*</span></p></span>
          <input type="text" id="inci_det_region_modal_id" name="inci_det_region_modal" placeholder="Error Fetching PH Location" class="w-100 form-control" required/>
        `);
        $('#inci_det_province_modal').parent().empty().html(`
          <span><p class="card-text">Province<span class="asterisk">*</span></p></span>
          <input type="text" id="inci_det_province_modal_id" name="inci_det_province_modal" placeholder="Error Fetching PH Location" class="w-100 form-control" required/>
        `);
        $('#inci_det_city_modal').parent().empty().html(`
          <span><p class="card-text">City/Municipality<span class="asterisk">*</span></p></span>
          <input type="text" id="inci_det_city_modal_id" name="inci_det_city_modal" placeholder="Error Fetching PH Location" class="w-100 form-control" required/>
        `);
        $('#inci_det_barangay_modal').parent().empty().html(`
          <span><p class="card-text">Barangay<span class="asterisk">*</span></p></span>
          <input type="text" id="inci_det_barangay_modal_id" name="inci_det_barangay_modal" placeholder="Error Fetching PH Location" class="w-100 form-control" required/>
        `);
                                              
      }
    });

    // Additional Perpetrator Details Address
    $('#perp_d_region_modal').on('change', my_handlers.fill_provinces_aperp_d);
    $('#perp_d_province_modal').on('change', my_handlers.fill_cities_aperp_d);
    $('#perp_d_city_modal').on('change', my_handlers.fill_barangays_aperp_d);

    $('#perp_d_region_modal').ph_locations({ 'location_type': 'regions' });
    $('#perp_d_province_modal').ph_locations({ 'location_type': 'provinces' });
    $('#perp_d_city_modal').ph_locations({ 'location_type': 'cities' });
    $('#perp_d_barangay_modal').ph_locations({ 'location_type': 'barangays' });
    $('#perp_d_region_modal').ph_locations('fetch_list');

    // Change select option to input box if Error fetching PH Location dropdown list
    $('#perp_d_region_modal').on('click',function(){

      if($('#perp_d_region_modal option:selected').val() == ''){

        $('#perp_d_region_modal').parent().empty().html(`
          <span><p class="card-text">Region<span class="asterisk">*</span></p></span>
          <input type="text" id="perp_d_region_modal_id" name="perp_d_region_modal" placeholder="Error Fetching PH Location" class="w-100 form-control" required/>
        `);
        $('#perp_d_province_modal').parent().empty().html(`
          <span><p class="card-text">Province<span class="asterisk">*</span></p></span>
          <input type="text" id="perp_d_province_modal_id" name="perp_d_province_modal" placeholder="Error Fetching PH Location" class="w-100 form-control" required/>
        `);
        $('#perp_d_city_modal').parent().empty().html(`
          <span><p class="card-text">City/Municipality<span class="asterisk">*</span></p></span>
          <input type="text" id="perp_d_city_modal_id" name="perp_d_city_modal" placeholder="Error Fetching PH Location" class="w-100 form-control" required/>
        `);
        $('#perp_d_barangay_modal').parent().empty().html(`
          <span><p class="card-text">Barangay<span class="asterisk">*</span></p></span>
          <input type="text" id="perp_d_barangay_modal_id" name="perp_d_barangay_modal" placeholder="Error Fetching PH Location" class="w-100 form-control" required/>
        `);
                                              
      }
    });
});

// Personal Details get Address Name

$('#region').change(function(){
    $('#region_id').val($("#region option:selected").text());
});
$('#province').change(function(){
    $('#province_id').val($("#province option:selected").text());
});
$('#city').change(function(){
    $('#city_id').val($("#city option:selected").text());
});
$('#barangay').change(function(){
    $('#barangay_id').val($("#barangay option:selected").text());
});

// Family Background get Address Name

$('#fam_back_region').change(function(){
    $('#fam_back_region_id').val($("#fam_back_region option:selected").text());
});
$('#fam_back_province').change(function(){
    $('#fam_back_province_id').val($("#fam_back_province option:selected").text());
});
$('#fam_back_city').change(function(){
    $('#fam_back_city_id').val($("#fam_back_city option:selected").text());
});
$('#fam_back_barangay').change(function(){
    $('#fam_back_barangay_id').val($("#fam_back_barangay option:selected").text());
});

// Incidence Details get Address Name

$('#inci_det_region').change(function(){
    $('#inci_det_region_id').val($("#inci_det_region option:selected").text());
});
$('#inci_det_province').change(function(){
    $('#inci_det_province_id').val($("#inci_det_province option:selected").text());
});
$('#inci_det_city').change(function(){
    $('#inci_det_city_id').val($("#inci_det_city option:selected").text());
});
$('#inci_det_barangay').change(function(){
    $('#inci_det_barangay_id').val($("#inci_det_barangay option:selected").text());
});


// Perpetrator Details get Address Name

$('#perp_d_region').change(function(){
    $('#perp_d_region_id').val($("#perp_d_region option:selected").text());
});
$('#perp_d_province').change(function(){
    $('#perp_d_province_id').val($("#perp_d_province option:selected").text());
});
$('#perp_d_city').change(function(){
    $('#perp_d_city_id').val($("#perp_d_city option:selected").text());
});
$('#perp_d_barangay').change(function(){
    $('#perp_d_barangay_id').val($("#perp_d_barangay option:selected").text());
});

// User Address get Address Name

$('#user_region').change(function(){
    $('#user_region_id').val($("#user_region option:selected").text());
});
$('#user_province').change(function(){
    $('#user_province_id').val($("#user_province option:selected").text());
});
$('#user_municipality').change(function(){
    $('#user_municipality_id').val($("#user_municipality option:selected").text());
});
$('#user_barangay').change(function(){
    $('#user_barangay_id').val($("#user_barangay option:selected").text());
});

// Additional Family Background Address get Address Name

$('#fam_back_region_modal').change(function(){
    $('#fam_back_region_modal_id').val($("#fam_back_region_modal option:selected").text());
});
$('#fam_back_province_modal').change(function(){
    $('#fam_back_province_modal_id').val($("#fam_back_province_modal option:selected").text());
});
$('#fam_back_city_modal').change(function(){
    $('#fam_back_city_modal_id').val($("#fam_back_city_modal option:selected").text());
});
$('#fam_back_barangay_modal').change(function(){
    $('#fam_back_barangay_modal_id').val($("#fam_back_barangay_modal option:selected").text());
});

// Additional Incidence Details Address get Address Name

$('#inci_det_region_modal').change(function(){
    $('#inci_det_region_modal_id').val($("#inci_det_region_modal option:selected").text());
});
$('#inci_det_province_modal').change(function(){
    $('#inci_det_province_modal_id').val($("#inci_det_province_modal option:selected").text());
});
$('#inci_det_city_modal').change(function(){
    $('#inci_det_city_modal_id').val($("#inci_det_city_modal option:selected").text());
});
$('#inci_det_barangay_modal').change(function(){
    $('#inci_det_barangay_modal_id').val($("#inci_det_barangay_modal option:selected").text());
});

// Additional Perpetrator Details Address get Address Name

$('#perp_d_region_modal').change(function(){
    $('#perp_d_region_modal_id').val($("#perp_d_region_modal option:selected").text());
});
$('#perp_d_province_modal').change(function(){
    $('#perp_d_province_modal_id').val($("#perp_d_province_modal option:selected").text());
});
$('#perp_d_city_modal').change(function(){
    $('#perp_d_city_modal_id').val($("#perp_d_city_modal option:selected").text());
});
$('#perp_d_barangay_modal').change(function(){
    $('#perp_d_barangay_modal_id').val($("#perp_d_barangay_modal option:selected").text());
});

// Start of change address on edit Case confirmation

function changeAddressOnEditCase(select_tag_region_id, select_tag_province_id, select_tag_city_id, select_tag_barangay_id,){

    Swal.fire({
        title: 'Do you want to change the address?',
        html: "<center>Existing address will be reset!</center>",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
    if (result.isConfirmed) {

        // Reset address field and removed onclick changeAddressOnEditCase() function

        $('#'+ select_tag_region_id +'').empty().prop('onclick', null);
        $('#'+ select_tag_province_id +'').empty().prop('onclick', null);
        $('#'+ select_tag_city_id +'').empty().prop('onclick', null);
        $('#'+ select_tag_barangay_id +'').empty().prop('onclick', null);

        $('#'+ select_tag_region_id +'').append('<option value="">Please Select</option>');

        // Reset hidden input address field

        $('#'+ select_tag_region_id +'_id').val('');
        $('#'+ select_tag_province_id +'_id').val('');
        $('#'+ select_tag_city_id +'_id').val('');
        $('#'+ select_tag_barangay_id +'_id').val('');

        // Reset Automated Dropdowns Location

        var my_handlers = {

          // Personal Details
          fill_provinces: function () {

              var region_code = $(this).val();
              $('#'+ select_tag_province_id +'').ph_locations('fetch_list', [{ "region_code": region_code }]);

          },

          fill_cities: function () {

              var province_code = $(this).val();
              $('#'+ select_tag_city_id +'').ph_locations('fetch_list', [{ "province_code": province_code }]);
          },


          fill_barangays: function () {

              var city_code = $(this).val();
              $('#'+ select_tag_barangay_id +'').ph_locations('fetch_list', [{ "city_code": city_code }]);
          }
        };

        $(function () {

          // Personal Details
          $('#'+ select_tag_region_id +'').on('change', my_handlers.fill_provinces);
          $('#'+ select_tag_province_id +'').on('change', my_handlers.fill_cities);
          $('#'+ select_tag_city_id +'').on('change', my_handlers.fill_barangays);
      
          $('#'+ select_tag_region_id +'').ph_locations({ 'location_type': 'regions' });
          $('#'+ select_tag_province_id +'').ph_locations({ 'location_type': 'provinces' });
          $('#'+ select_tag_city_id +'').ph_locations({ 'location_type': 'cities' });
          $('#'+ select_tag_barangay_id +'').ph_locations({ 'location_type': 'barangays' });
          $('#'+ select_tag_region_id +'').ph_locations('fetch_list');
      
      
          // Change select option to input box if Error fetching PH Location dropdown list
          $('#'+ select_tag_region_id +'').on('click',function(){
      
            if($('#'+ select_tag_region_id +' option:selected').val() == ''){
      
              $('#'+ select_tag_region_id +'').parent().empty().html(`
                <span><p class="card-text">Region<span class="asterisk">*</span></p></span>
                <input type="text" id="`+ select_tag_region_id +`_id" name="`+ select_tag_region_id.replace('edit_','') +`" placeholder="Error Fetching PH Location" class="w-100 form-control"/>
              `);
              $('#'+ select_tag_province_id +'').parent().empty().html(`
                <span><p class="card-text">Province<span class="asterisk">*</span></p></span>
                <input type="text" id="`+ select_tag_province_id +`_id" name="`+ select_tag_province_id.replace('edit_','') +`" placeholder="Error Fetching PH Location" class="w-100 form-control"/>
              `);
              $('#'+ select_tag_city_id +'').parent().empty().html(`
                <span><p class="card-text">City/Municipality<span class="asterisk">*</span></p></span>
                <input type="text" id="`+ select_tag_city_id +`_id" name="`+ select_tag_city_id.replace('edit_','') +`" placeholder="Error Fetching PH Location" class="w-100 form-control"/>
              `);
              $('#'+ select_tag_barangay_id +'').parent().empty().html(`
                <span><p class="card-text">Barangay<span class="asterisk">*</span></p></span>
                <input type="text" id="`+ select_tag_barangay_id +`_id" name="`+ select_tag_barangay_id.replace('edit_','') +`" placeholder="Error Fetching PH Location" class="w-100 form-control"/>
              `);
      
            }
          });
        });

        // Additional Perpetrator Details Address get Address Name

        $('#'+ select_tag_region_id +'').change(function(){
          $('#'+ select_tag_region_id +'_id').val($('#'+ select_tag_region_id +' option:selected').text());
        });
        $('#'+ select_tag_province_id +'').change(function(){
          $('#'+ select_tag_province_id +'_id').val($('#'+ select_tag_province_id +' option:selected').text());
        });
        $('#'+ select_tag_city_id +'').change(function(){
          $('#'+ select_tag_city_id +'_id').val($('#'+ select_tag_city_id +' option:selected').text());
        });
        $('#'+ select_tag_barangay_id +'').change(function(){
          $('#'+ select_tag_barangay_id +'_id').val($('#'+ select_tag_barangay_id +' option:selected').text());
        });
        
    }
    });
}

// End of change address on edit Case confirmation 


// Cascading Dropdown in Intervention Module form

var im_type_of_serviceObject = {
    "Temporary Shelter": {
        "A. Half Way Home": [],
        "B. Crisis Intervention Including Rescue": [],
        "C. Emergency Shelter": [],
        "D. Psychosocial Support": [],
        "E. Others": [],
    },
    "Medical Services": {
        "A. First Aid": [],
        "B. Medico-Legal Exam": [],
        "C. Provision of Appropriate Medical Treatment": [],
        "D. Issuance of Medical Certificate": [],
        "E. Medical Check-up": [],
        "F. Others": [],
    },
    "Legal, Safety and Security": {
        "A. Receipt and Recording of Complaints": [],
        "B. Enforcement of TPO/PPO": [],
        "C. Rescue Operation for VAWC Cases": [],
        "D. Forensic Interview and Investigations": [],
        "E. Prosecution": [],
        "F. Issuance/Enforcement of Barangay Protection Order (BPO)": [],
        "G. Others": [],
    },
    "Others": {
        "A. Others": [],
    }
}

window.onload = function () {

  if(document.getElementById("im_type_of_service")){
    var im_type_of_serviceSel = document.getElementById("im_type_of_service");
    var im_speci_intervSel = document.getElementById("im_speci_interv");
    for (var x in im_type_of_serviceObject) {
        im_type_of_serviceSel.options[im_type_of_serviceSel.options.length] = new Option(x, x);
    }
    im_type_of_serviceSel.onchange = function () {
        //empty Service- dropdowns
        im_speci_intervSel.length = 1;
        //display correct values
        for (var y in im_type_of_serviceObject[this.value]) {
            im_speci_intervSel.options[im_speci_intervSel.options.length] = new Option(y, y);
        }
    }
    im_speci_intervSel.onchange = function () {
        //display correct values
        var z = im_type_of_serviceObject[im_type_of_serviceSel.value][this.value];
        for (var i = 0; i < z.length; i++) {
            // chapterSel.options[chapterSel.options.length] = new Option(z[i], z[i]);
        }
    }
  }

  if(document.getElementById("im_type_of_service_modal")){
    var im_type_of_service_modalSel = document.getElementById("im_type_of_service_modal");
    var im_speci_interv_modalSel = document.getElementById("im_speci_interv_modal");
    for (var x in im_type_of_serviceObject) {
        im_type_of_service_modalSel.options[im_type_of_service_modalSel.options.length] = new Option(x, x);
    }
    im_type_of_service_modalSel.onchange = function () {
        //empty Service- dropdowns
        im_speci_interv_modalSel.length = 1;
        //display correct values
        for (var y in im_type_of_serviceObject[this.value]) {
            im_speci_interv_modalSel.options[im_speci_interv_modalSel.options.length] = new Option(y, y);
        }
    }
    im_speci_interv_modalSel.onchange = function () {
        //display correct values
        var z = im_type_of_serviceObject[im_type_of_service_modalSel.value][this.value];
        for (var i = 0; i < z.length; i++) {
            // chapterSel.options[chapterSel.options.length] = new Option(z[i], z[i]);
        }
    }
  }
}

// Start of change Type of Service/Specific Interventions

function changeTypeOfServiceAndSpecificInterventions(type_of_service, specific_interventions){

  Swal.fire({
    title: 'Do you want to change the Type of Service/Specific Interventions?',
    html: "<center>Existing Type of Service/Specific Interventions will be reset!</center>",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes'
  }).then((result) => {
  if (result.isConfirmed) {

    // Reset Type of Service and Specific Interventions then removed onclick changeTypeOfServiceAndSpecificInterventions() function

    $('#'+ type_of_service +'').empty().prop('onclick', null);
    $('#'+ specific_interventions +'').empty().prop('onclick', null);

    // Add Please Select Option
    
    $('#'+ type_of_service +'').prepend('<option value="">Please Select</option>');
    $('#'+ specific_interventions +'').prepend('<option value="">Please Select</option>');

    // Cascading Dropdown in Intervention Module form

    var im_type_of_serviceObject = {
      "Temporary Shelter": {
          "A. Half Way Home": [],
          "B. Crisis Intervention Including Rescue": [],
          "C. Emergency Shelter": [],
          "D. Psychosocial Support": [],
          "E. Others": [],
      },
      "Medical Services": {
          "A. First Aid": [],
          "B. Medico-Legal Exam": [],
          "C. Provision of Appropriate Medical Treatment": [],
          "D. Issuance of Medical Certificate": [],
          "E. Medical Check-up": [],
          "F. Others": [],
      },
      "Legal, Safety and Security": {
          "A. Receipt and Recording of Complaints": [],
          "B. Enforcement of TPO/PPO": [],
          "C. Rescue Operation for VAWC Cases": [],
          "D. Forensic Interview and Investigations": [],
          "E. Prosecution": [],
          "F. Issuance/Enforcement of Barangay Protection Order (BPO)": [],
          "G. Others": [],
      },
      "Others": {
          "A. Others": [],
      }
    }

    
    var im_type_of_serviceSel = document.getElementById(type_of_service);
    var im_speci_intervSel = document.getElementById(specific_interventions);
    for (var x in im_type_of_serviceObject) {
        im_type_of_serviceSel.options[im_type_of_serviceSel.options.length] = new Option(x, x);
    }
    im_type_of_serviceSel.onchange = function () {
        //empty Service- dropdowns
        im_speci_intervSel.length = 1;
        //display correct values
        for (var y in im_type_of_serviceObject[this.value]) {
            im_speci_intervSel.options[im_speci_intervSel.options.length] = new Option(y, y);
        }
    }
    im_speci_intervSel.onchange = function () {
        //display correct values
        var z = im_type_of_serviceObject[im_type_of_serviceSel.value][this.value];
        for (var i = 0; i < z.length; i++) {
            // chapterSel.options[chapterSel.options.length] = new Option(z[i], z[i]);
        }
    }
    
      
  }
  });
}

// End of change Type of Service/Specific Interventions

// Start of disabling If Other input box function


// Start of Personal Details disabling If Others input box

// Start of disabling Personal Details Religion Others input box

$(function() {
    $('.religionInput').attr('readonly', 'readonly')

    if ($('#religion option:selected').val() == 'Others') {

      $('#inputRel').removeAttr('readonly');
    }

    $('#religion').change(function(e) {
      var selected_type = $(this).val();

      if (selected_type == 'Others') {

        $('#inputRel').removeAttr('readonly');
      }
      else if (selected_type) {
        $('#inputRel').attr('readonly', 'readonly');
      }
    });
  });

// End of disabling Personal Details Religion Others input box

// Start of disabling Personal Details Nationality Others input box

$(function() {
    $('.nationalityInput').attr('readonly', 'readonly')

    if ($('#nationality option:selected').val() == 'Others') {

      $('#inputNa').removeAttr('readonly');
    }

    $('#nationality').change(function(e) {
      var selected_type = $(this).val();

      if (selected_type == 'Others') {

        $('#inputNa').removeAttr('readonly');
      }
      else if (selected_type) {
        $('#inputNa').attr('readonly', 'readonly');
      }
    });
  });

// End of disabling Personal Details Nationality Others input box

// Start of disabling Personal Details Ethnicity Others input box

$(function() {
    $('.ethnicityInput').attr('readonly', 'readonly')

    if ($('#ethnicity option:selected').val() == 'Others') {

      $('#inputEth').removeAttr('readonly');
    }

    $('#ethnicity').change(function(e) {
      var selected_type = $(this).val();

      if (selected_type == 'Others') {

        $('#inputEth').removeAttr('readonly');
      }
      else if (selected_type) {
        $('#inputEth').attr('readonly', 'readonly');
      }
    });
  });

// End of disabling Personal Details Ethnicity Others input box

// Start of disabling Employment Status Self-employed input box

$(function() {
    $('.selfemployedInput').attr('readonly', 'readonly')

    if ($('#employment_status option:selected').val() == 'Employed') {

      $('#if_self_emp_pls_ind').removeAttr('readonly');
    }
    else if ($('#employment_status option:selected').val() == 'Self-Employed') {

      $('#if_self_emp_pls_ind').removeAttr('readonly');
    }

    $('#employment_status').change(function(e) {
      var selected_type = $(this).val();

      if (selected_type == 'Employed') {

        $('#if_self_emp_pls_ind').removeAttr('readonly');
      }
      else if (selected_type == 'Self-Employed') {

        $('#if_self_emp_pls_ind').removeAttr('readonly');
      }
      else if (selected_type) {
        $('#if_self_emp_pls_ind').attr('readonly', 'readonly');
      }
    });
  });

// End of disabling Employment Status Self-employed input box

// Start of disabling Is PWD input box

$(function() {
    $('.ifpwdInput').attr('readonly', 'readonly')

    if ($('#is_pwd_yes_radio').is(':checked')) {

      $('#if_pwd_pls_specify').removeAttr('readonly');
    }

    $('.ispwd').change(function(e) {
      var selected_type = $(this).val();

      if (selected_type == 'Yes') {

        $('#if_pwd_pls_specify').removeAttr('readonly');
      }
      else if (selected_type) {
        $('#if_pwd_pls_specify').attr('readonly', 'readonly');
      }
    });
  });

// End of disabling Is PWD input box

// End of Personal Details disabling If Others input box


// Start of Family Backgrounds disabling If Others input box

// Start of disabling Family Background Relationship to the Victim-Survivor: if others input box

$(function() {
    $('.relvicInput').attr('readonly', 'readonly')

    if (($('#relvic option:selected').val() == 'Other Relatives, Specify:')  || ($('#relvic option:selected').val() == 'Immediate Family Members, Specify:') || ($('#relvic option:selected').val() == 'Stepfamily Members, Specify:')) {

      $('#inputRelvic').removeAttr('readonly');
    }

    $('#relvic').change(function(e) {
      var selected_type = $(this).val();

      if ((selected_type == 'Other Relatives, Specify:')  || (selected_type == 'Immediate Family Members, Specify:') || (selected_type == 'Stepfamily Members, Specify:')) {

        $('#inputRelvic').removeAttr('readonly');
      }
      else if (selected_type) {
        $('#inputRelvic').attr('readonly', 'readonly');
      }
    });
  });

// End of disabling Family Background Relationship to the Victim-Survivor: if others input box

// End of Family Backgrounds disabling If Others input box


// Start of Incidence Details disabling If Others input box

// Start of disabling Trafficking in Person Others input box

if ($('#trafPer').is(':checked')) {
  $('#inputTrafper').removeAttr('readonly');
} else {
  $('#inputTrafper').attr('readonly', 'readonly');
}

function trafPers() {
    if ($('#trafPer').is(':checked')) {
        $('#inputTrafper').removeAttr('readonly');
    } else {
        $('#inputTrafper').attr('readonly', 'readonly');
    }
}

// End of disabling Trafficking in Person Others input box

// Start of disabling Sexual Harassment Others input box

if ($('#sexHa').is(':checked')) {
  $('#inputSexHa').removeAttr('readonly');
} else {
  $('#inputSexHa').attr('readonly', 'readonly');
}

function sexHas() {
    if ($('#sexHa').is(':checked')) {
        $('#inputSexHa').removeAttr('readonly');
    } else {
        $('#inputSexHa').attr('readonly', 'readonly');
    }
}

// End of disabling Sexual Harassment Others input box

// Start of disabling Child Abuse, Exploitation and Discrimination Others input box

if ($('#chiAed').is(':checked')) {
  $('#inputchiAed').removeAttr('readonly');
} else {
  $('#inputchiAed').attr('readonly', 'readonly');
}

function chiAeds() {
    if ($('#chiAed').is(':checked')) {
        $('#inputchiAed').removeAttr('readonly');
    } else {
        $('#inputchiAed').attr('readonly', 'readonly');
    }
}

// End of disabling Child Abuse, Exploitation and Discrimination Others input box

// Start of disabling Place of Incidence: Others input box

$(function() {
    $('.placeInci').attr('readonly', 'readonly')

    if ($('#placeinci option:selected').val() == 'Others') {

      $('#inputplaceInci').removeAttr('readonly');
    }

    $('#placeinci').change(function(e) {
      var selected_type = $(this).val();

      if (selected_type == 'Others') {

        $('#inputplaceInci').removeAttr('readonly');
      }
      else if (selected_type) {
        $('#inputplaceInci').attr('readonly', 'readonly');
      }
    });
  });

// End of disabling Place of Incidence: Others input box

// End of Incidence Details disabling If Others input box


// Start of Perpetrator Details disabling If Others input box

 // Check Case No. form status

 if($('#case_no').val()){ // If Encoded
  $.ajax({
    url: rootURL + 'api/v1/case/get-case-form-status/' + $('#case_no').val(),
    success: function (result) {

      var case_form_status = result;

      if(case_form_status != 'Submitted'){

        // Start of disabling Perpetrator Details Relationship to the Victim-Survivor: if others input box
      
        $(function() {
          $('.relVicsur').attr('readonly', 'readonly')
      
          if (($('#relvicsur option:selected').val() == 'Other Relatives, Specify:') || ($('#relvicsur option:selected').val() == 'Immediate Family Members, Specify:') || ($('#relvicsur option:selected').val() == 'Stepfamily Members, Specify:')) {
      
            $('#inputrelvicsur').removeAttr('readonly');
          }
      
          $('#relvicsur').change(function(e) {
            var selected_type = $(this).val();
      
            if ((selected_type == 'Other Relatives, Specify:') || (selected_type == 'Immediate Family Members, Specify:') || (selected_type == 'Stepfamily Members, Specify:')) {
      
              $('#inputrelvicsur').removeAttr('readonly');
            }
            else if (selected_type) {
              $('#inputrelvicsur').attr('readonly', 'readonly');
            }
          });
        });
      
        // End of disabling Perpetrator Details Relationship to the Victim-Survivor: if others input box
      
        // Start of disabling Perpetrator Details Nationality Others input box
      
        $(function() {
          $('.narelVicsur').attr('readonly', 'readonly')
      
          if ($('#narelvicsur option:selected').val() == 'Others') {
      
            $('#nainputrelvicsur').removeAttr('readonly');
          }
      
          $('#narelvicsur').change(function(e) {
            var selected_type = $(this).val();
      
            if (selected_type == 'Others') {
      
              $('#nainputrelvicsur').removeAttr('readonly');
            }
            else if (selected_type) {
              $('#nainputrelvicsur').attr('readonly', 'readonly');
            }
          });
        });
      
        // End of disabling Perpetrator Details Nationality Others input box
      
        // Start of disabling Perpetrator Details Religion Others input box
      
        $(function() {
          $('.rerelVicsur').attr('readonly', 'readonly')
      
          if ($('#rerelvicsur option:selected').val() == 'Others') {
      
            $('#reinputrelvicsur').removeAttr('readonly');
          }
      
          $('#rerelvicsur').change(function(e) {
            var selected_type = $(this).val();
      
            if (selected_type == 'Others') {
      
              $('#reinputrelvicsur').removeAttr('readonly');
            }
            else if (selected_type) {
              $('#reinputrelvicsur').attr('readonly', 'readonly');
            }
          });
        });
      
        // End of disabling Perpetrator Details Religion Others input box
      
        // Start of disabling Perpetrator Details Is Perpetrator Minor?: input box
      
        $(function() {
        $('#perp_d_if_yes_pls_ind').attr('readonly', 'readonly')
      
        if($('#perp_d_is_pm_yes_radio').is(':checked')){
      
          $('#perp_d_if_yes_pls_ind').removeAttr('readonly');
        }
      
        $('.perp_d_is_perp_minor').on('change', function(){
      
          if($('#perp_d_is_pm_yes_radio').is(':checked')){
      
            $('#perp_d_if_yes_pls_ind').removeAttr('readonly');
          }
          else {
            $('#perp_d_if_yes_pls_ind').attr('readonly', 'readonly');
          }
        });
        });
      
        // End of disabling Perpetrator Details Is Perpetrator Minor?: input box
      
        // Start of disabling Perpetrator Details Relationship of guardian to Perpetrator: if others input box
      
        $(function() {
          $('.garrelVicsur').attr('readonly', 'readonly')
      
          if ($('#garrelvicsur option:selected').val() == 'Others') {
      
            $('#garinputrelvicsur').removeAttr('readonly');
          }
      
          $('#garrelvicsur').change(function(e) {
            var selected_type = $(this).val();
      
            if (selected_type == 'Others') {
      
              $('#garinputrelvicsur').removeAttr('readonly');
            }
            else if (selected_type) {
              $('#garinputrelvicsur').attr('readonly', 'readonly');
            }
          });
        });
      
        // End of disabling Perpetrator Details Relationship of guardian to Perpetrator: if others input box
      
      }
      

    }
  });
}else{ // If not Encoded

    // Start of disabling Perpetrator Details Relationship to the Victim-Survivor: if others input box

    $(function() {
      $('.relVicsur').attr('readonly', 'readonly')
  
      if (($('#relvicsur option:selected').val() == 'Other Relatives, Specify:') || ($('#relvicsur option:selected').val() == 'Immediate Family Members, Specify:') || ($('#relvicsur option:selected').val() == 'Stepfamily Members, Specify:')) {
  
        $('#inputrelvicsur').removeAttr('readonly');
      }
  
      $('#relvicsur').change(function(e) {
        var selected_type = $(this).val();
  
        if ((selected_type == 'Other Relatives, Specify:') || (selected_type == 'Immediate Family Members, Specify:') || (selected_type == 'Stepfamily Members, Specify:')) {
  
          $('#inputrelvicsur').removeAttr('readonly');
        }
        else if (selected_type) {
          $('#inputrelvicsur').attr('readonly', 'readonly');
        }
      });
    });
  
    // End of disabling Perpetrator Details Relationship to the Victim-Survivor: if others input box
  
    // Start of disabling Perpetrator Details Nationality Others input box
  
    $(function() {
      $('.narelVicsur').attr('readonly', 'readonly')
  
      if ($('#narelvicsur option:selected').val() == 'Others') {
  
        $('#nainputrelvicsur').removeAttr('readonly');
      }
  
      $('#narelvicsur').change(function(e) {
        var selected_type = $(this).val();
  
        if (selected_type == 'Others') {
  
          $('#nainputrelvicsur').removeAttr('readonly');
        }
        else if (selected_type) {
          $('#nainputrelvicsur').attr('readonly', 'readonly');
        }
      });
    });
  
    // End of disabling Perpetrator Details Nationality Others input box
  
    // Start of disabling Perpetrator Details Religion Others input box
  
    $(function() {
      $('.rerelVicsur').attr('readonly', 'readonly')
  
      if ($('#rerelvicsur option:selected').val() == 'Others') {
  
        $('#reinputrelvicsur').removeAttr('readonly');
      }
  
      $('#rerelvicsur').change(function(e) {
        var selected_type = $(this).val();
  
        if (selected_type == 'Others') {
  
          $('#reinputrelvicsur').removeAttr('readonly');
        }
        else if (selected_type) {
          $('#reinputrelvicsur').attr('readonly', 'readonly');
        }
      });
    });
  
    // End of disabling Perpetrator Details Religion Others input box
  
    // Start of disabling Perpetrator Details Is Perpetrator Minor?: input box
  
    $(function() {
    $('#perp_d_if_yes_pls_ind').attr('readonly', 'readonly')
  
    if($('#perp_d_is_pm_yes_radio').is(':checked')){
  
      $('#perp_d_if_yes_pls_ind').removeAttr('readonly');
    }
  
    $('.perp_d_is_perp_minor').on('change', function(){
  
      if($('#perp_d_is_pm_yes_radio').is(':checked')){
  
        $('#perp_d_if_yes_pls_ind').removeAttr('readonly');
      }
      else {
        $('#perp_d_if_yes_pls_ind').attr('readonly', 'readonly');
      }
    });
    });
  
    // End of disabling Perpetrator Details Is Perpetrator Minor?: input box
  
    // Start of disabling Perpetrator Details Relationship of guardian to Perpetrator: if others input box
  
    $(function() {
      $('.garrelVicsur').attr('readonly', 'readonly')
  
      if ($('#garrelvicsur option:selected').val() == 'Others') {
  
        $('#garinputrelvicsur').removeAttr('readonly');
      }
  
      $('#garrelvicsur').change(function(e) {
        var selected_type = $(this).val();
  
        if (selected_type == 'Others') {
  
          $('#garinputrelvicsur').removeAttr('readonly');
        }
        else if (selected_type) {
          $('#garinputrelvicsur').attr('readonly', 'readonly');
        }
      });
    });
  
    // End of disabling Perpetrator Details Relationship of guardian to Perpetrator: if others input box
}

// End of Perpetrator Details disabling If Others input box


// Start of Intervention Module disabling If Others input box

// Start of disabling Type of Service if others input box

$(function() {
    $('.typeofService').attr('readonly', 'readonly')

    if ($('.typeofservice option:selected').val() == 'Others') {

      $('#inputtypeofService').removeAttr('readonly');
    }

    $('.typeofservice').change(function(e) {
      var selected_type = $(this).val();

      if (selected_type == 'Others') {

        $('#inputtypeofService').removeAttr('readonly');
      }
      else if (selected_type) {
        $('#inputtypeofService').attr('readonly', 'readonly');
      }
    });
  });

// End of disabling Type of Service if others input box

// Start of disabling Specific Interventions: if others input box

$(function() {
    $('.speInts').attr('readonly', 'readonly')

    if ($('.speInt option:selected').val() == 'E. Others') {

      $('#inputspeInt').removeAttr('readonly');
    }
    else if ($('.speInt option:selected').val() == 'A. Others') {

      $('#inputspeInt').removeAttr('readonly');
    }
    else if ($('.speInt option:selected').val() == 'F. Others') {

      $('#inputspeInt').removeAttr('readonly');
    }
    else if ($('.speInt option:selected').val() == 'G. Others') {

      $('#inputspeInt').removeAttr('readonly');
    }

    $('.speInt').change(function(e) {
      var selected_type = $(this).val();

      if (selected_type == 'E. Others') {

        $('#inputspeInt').removeAttr('readonly');
      }
      else if (selected_type == 'A. Others') {

        $('#inputspeInt').removeAttr('readonly');
      }
      else if (selected_type == 'F. Others') {

        $('#inputspeInt').removeAttr('readonly');
      }
      else if (selected_type == 'G. Others') {

        $('#inputspeInt').removeAttr('readonly');
      }
      else if (selected_type) {
        $('#inputspeInt').attr('readonly', 'readonly');
      }
    });
  });

// End of disabling Specific Interventions: if others input box

// Start of disabling Service Provider: if others input box

$(function() {
    $('.serviceproviders').attr('readonly', 'readonly')

    if ($('#serviceprovider option:selected').val() == 'Others') {

      $('#inputserviceprovider').removeAttr('readonly');
    }

    $('#serviceprovider').change(function(e) {
      
      var selected_type = $(this).val();

      if (selected_type == 'Others') {

        $('#inputserviceprovider').removeAttr('readonly');
      }
      else if (selected_type) {
        $('#inputserviceprovider').attr('readonly', 'readonly');
      }
    });
  });

// End of disabling Service Provider: if others input box

// End of Intervention Module disabling If Others input box


// Start of Referral Module disabling If Others input box

// Start of disabling "If Yes, Please indicate the details of referring organization:" input field

$(function() {
    $('#rm_name_ref_org').attr('readonly', 'readonly')
    $('#rm_ref_fro_ref_org').attr('readonly', 'readonly')
    $('#rm_addr_ref_org').attr('readonly', 'readonly')
    $('#rm_referred_by').attr('readonly', 'readonly')
    $('#rm_position_title').attr('readonly', 'readonly')
    $('#rm_contact_no').attr('readonly', 'readonly')
    $('#rm_email_add').attr('readonly', 'readonly')

    if ($('#rm_was_cli_ref_org_yes_radio').is(':checked')) {

      $('#rm_name_ref_org').removeAttr('readonly', 'readonly')
      $('#rm_ref_fro_ref_org').removeAttr('readonly', 'readonly')
      $('#rm_addr_ref_org').removeAttr('readonly', 'readonly')
      $('#rm_referred_by').removeAttr('readonly', 'readonly')
      $('#rm_position_title').removeAttr('readonly', 'readonly')
      $('#rm_contact_no').removeAttr('readonly', 'readonly')
      $('#rm_email_add').removeAttr('readonly', 'readonly')
    }

    $('.rm_was_cli_ref_by_org').change(function(e) {
      var selected_type = $(this).val();

      if (selected_type == 'Yes') {

        $('#rm_name_ref_org').removeAttr('readonly', 'readonly')
        $('#rm_ref_fro_ref_org').removeAttr('readonly', 'readonly')
        $('#rm_addr_ref_org').removeAttr('readonly', 'readonly')
        $('#rm_referred_by').removeAttr('readonly', 'readonly')
        $('#rm_position_title').removeAttr('readonly', 'readonly')
        $('#rm_contact_no').removeAttr('readonly', 'readonly')
        $('#rm_email_add').removeAttr('readonly', 'readonly')
      }
      else if (selected_type) {

        $('#rm_name_ref_org').attr('readonly', 'readonly')
        $('#rm_ref_fro_ref_org').attr('readonly', 'readonly')
        $('#rm_addr_ref_org').attr('readonly', 'readonly')
        $('#rm_referred_by').attr('readonly', 'readonly')
        $('#rm_position_title').attr('readonly', 'readonly')
        $('#rm_contact_no').attr('readonly', 'readonly')
        $('#rm_email_add').attr('readonly', 'readonly')
      }
    });
  });

// End of disabling "If Yes, Please indicate the details of referring organization:" input field

// End of Referral Module disabling If Others input box


// End of disabling If Other input box function


// Start of disabling Modal if Other input box function


// Start of Family Backgrounds Modal disabling If Others input box

// Start of disabling Family Background Modal Relationship to the Victim-Survivor: if others input box

$(function() {
    $('.relvicInputModal').attr('readonly', 'readonly')

    if (($('#rel_vict_sur_modal option:selected').val() == 'Other Relatives, Specify:')  || ($('#rel_vict_sur_modal option:selected').val() == 'Immediate Family Members, Specify:') || ($('#rel_vict_sur_modal option:selected').val() == 'Stepfamily Members, Specify:')) {

      $('.relvicInputModal').removeAttr('readonly');
    }

    $('#rel_vict_sur_modal').change(function(e) {
      var selected_type = $(this).val();

      if ((selected_type == 'Other Relatives, Specify:')  || (selected_type == 'Immediate Family Members, Specify:') || (selected_type == 'Stepfamily Members, Specify:')) {

        $('.relvicInputModal').removeAttr('readonly');
      }
      else if (selected_type) {
        $('.relvicInputModal').attr('readonly', 'readonly');
      }
    });
  });

// End of disabling Family Background Modal Relationship to the Victim-Survivor: if others input box

// End of Family Backgrounds Modal disabling If Others input box


// Start of Incidence Details Modal disabling If Others input box

// Start of disabling Trafficking in Person Others input box

$(function(){

    $('#inputTrafperModal').attr('readonly', 'readonly');

    if ($('#trafPerModal').is(':checked')) {
      $('#inputTrafperModal').removeAttr('readonly');
    }

    $('#trafPerModal').on("change", function(){

        if ($('#trafPerModal').is(':checked')) {
            $('#inputTrafperModal').removeAttr('readonly');
        } else {
            $('#inputTrafperModal').attr('readonly', 'readonly');
        }
    });
});

// End of disabling Trafficking in Person Others input box

// Start of disabling Sexual Harassment Others input box

$(function(){

    $('#inputSexHaModal').attr('readonly', 'readonly');

    if ($('#sexHaModal').is(':checked')) {
      $('#inputSexHaModal').removeAttr('readonly');
    }

    $('#sexHaModal').on("change", function(){
        
        if ($('#sexHaModal').is(':checked')) {
            $('#inputSexHaModal').removeAttr('readonly');
        } else {
            $('#inputSexHaModal').attr('readonly', 'readonly');
        }
    });
});

// End of disabling Sexual Harassment Others input box

// Start of disabling Child Abuse, Exploitation and Discrimination Others input box

$(function(){

    $('#inputchiAedModal').attr('readonly', 'readonly');

    if ($('#chiAedModal').is(':checked')) {
      $('#inputchiAedModal').removeAttr('readonly');
    }

    $('#chiAedModal').on("change", function(){

        if ($('#chiAedModal').is(':checked')) {
            $('#inputchiAedModal').removeAttr('readonly');
        } else {
            $('#inputchiAedModal').attr('readonly', 'readonly');
        }
    });
});

// End of disabling Child Abuse, Exploitation and Discrimination Others input box

// Start of disabling Place of Incidence: Others input box

$(function() {
    $('.placeInciModal').attr('readonly', 'readonly')

    if ($('#placeinciModal option:selected').val() == 'Others') {

      $('#inputplaceInciModal').removeAttr('readonly');
    }

    $('#placeinciModal').change(function(e) {
      var selected_type = $(this).val();

      if (selected_type == 'Others') {

        $('#inputplaceInciModal').removeAttr('readonly');
      }
      else if (selected_type) {
        $('#inputplaceInciModal').attr('readonly', 'readonly');
      }
    });
  });

// End of disabling Place of Incidence: Others input box

// End of Incidence Details Modal disabling If Others input box


// Start of Perpetrator Details Modal disabling If Others input box

// Start of disabling Perpetrator Details Modal Relationship to the Victim-Survivor: if others input box

$(function() {
    $('.relVicsurModal').attr('readonly', 'readonly')

    if (($('#relvicsurModal option:selected').val() == 'Other Relatives, Specify:') || ($('#relvicsurModal option:selected').val() == 'Immediate Family Members, Specify:') || ($('#relvicsurModal option:selected').val() == 'Stepfamily Members, Specify:')) {

      $('#inputrelvicsurModal').removeAttr('readonly');
    }

    $('#relvicsurModal').change(function(e) {
      var selected_type = $(this).val();

      if ((selected_type == 'Other Relatives, Specify:') || (selected_type == 'Immediate Family Members, Specify:') || (selected_type == 'Stepfamily Members, Specify:')) {

        $('#inputrelvicsurModal').removeAttr('readonly');
      }
      else if (selected_type) {
        $('#inputrelvicsurModal').attr('readonly', 'readonly');
      }
    });
  });

// End of disabling Perpetrator Details Modal Relationship to the Victim-Survivor: if others input box

// Start of disabling Perpetrator Details Modal Nationality Others input box

$(function() {
    $('.narelVicsurModal').attr('readonly', 'readonly')

    if ($('#narelvicsurModal option:selected').val() == 'Others') {

      $('#nainputrelvicsurModal').removeAttr('readonly');
    }

    $('#narelvicsurModal').change(function(e) {
      var selected_type = $(this).val();

      if (selected_type == 'Others') {

        $('#nainputrelvicsurModal').removeAttr('readonly');
      }
      else if (selected_type) {
        $('#nainputrelvicsurModal').attr('readonly', 'readonly');
      }
    });
  });

// End of disabling Perpetrator Details Modal Nationality Others input box

// Start of disabling Perpetrator Details Modal Religion Others input box

$(function() {
    $('.rerelVicsurModal').attr('readonly', 'readonly')

    if ($('#rerelvicsurModal option:selected').val() == 'Others') {

      $('#reinputrelvicsurModal').removeAttr('readonly');
    }

    $('#rerelvicsurModal').change(function(e) {
      var selected_type = $(this).val();

      if (selected_type == 'Others') {

        $('#reinputrelvicsurModal').removeAttr('readonly');
      }
      else if (selected_type) {
        $('#reinputrelvicsurModal').attr('readonly', 'readonly');
      }
    });
  });

// End of disabling Perpetrator Details Modal Religion Others input box

// Start of disabling Perpetrator Details Is Perpetrator Minor?: input box

$(function() {
  $('#perp_d_if_yes_pls_ind_modal').attr('readonly', 'readonly')

  if($('#perp_d_is_pm_yes_radio_modal').is(':checked')){

    $('#perp_d_if_yes_pls_ind_modal').removeAttr('readonly');
  }

  $('.perp_d_is_perp_minor_modal').on('change', function(){

    if($('#perp_d_is_pm_yes_radio_modal').is(':checked')){

      $('#perp_d_if_yes_pls_ind_modal').removeAttr('readonly');
    }
    else {
      $('#perp_d_if_yes_pls_ind_modal').attr('readonly', 'readonly');
    }
  });
});

// End of disabling Perpetrator Details Is Perpetrator Minor?: input box

// Start of disabling Perpetrator Details Modal Relationship of guardian to Perpetrator: if others input box

$(function() {
    $('.garrelVicsurModal').attr('readonly', 'readonly')

    if ($('#garrelvicsurModal option:selected').val() == 'Others') {

      $('#garinputrelvicsurModal').removeAttr('readonly');
    }

    $('#garrelvicsurModal').change(function(e) {
      var selected_type = $(this).val();

      if (selected_type == 'Others') {

        $('#garinputrelvicsurModal').removeAttr('readonly');
      }
      else if (selected_type) {
        $('#garinputrelvicsurModal').attr('readonly', 'readonly');
      }
    });
  });

// End of disabling Perpetrator Details Modal Relationship of guardian to Perpetrator: if others input box

// End of Perpetrator Details Modal disabling If Others input box


// Start of Intervention Module Modal disabling If Others input box

// Start of disabling Type of Service if others input box

$(function() {
    $('.typeofServiceModal').attr('readonly', 'readonly')

    if ($('#im_type_of_service_modal option:selected').val() == 'Others') {

      $('#inputtypeofServiceModal').removeAttr('readonly');
    }

    $('#im_type_of_service_modal').change(function(e) {
      var selected_type = $(this).val();

      if (selected_type == 'Others') {

        $('#inputtypeofServiceModal').removeAttr('readonly');
      }
      else if (selected_type) {
        $('#inputtypeofServiceModal').attr('readonly', 'readonly');
      }
    });
  });

// End of disabling Type of Service if others input box

// Start of disabling Specific Interventions: if others input box

$(function() {
    $('.speIntsModal').attr('readonly', 'readonly')

    if ($('#im_speci_interv_modal option:selected').val() == 'E. Others') {

      $('#inputspeIntModal').removeAttr('readonly');
    }
    else if ($('#im_speci_interv_modal option:selected').val() == 'A. Others') {

      $('#inputspeIntModal').removeAttr('readonly');
    }
    else if ($('#im_speci_interv_modal option:selected').val() == 'F. Others') {

      $('#inputspeIntModal').removeAttr('readonly');
    }
    else if ($('#im_speci_interv_modal option:selected').val() == 'G. Others') {

      $('#inputspeIntModal').removeAttr('readonly');
    }

    $('#im_speci_interv_modal').change(function(e) {
      var selected_type = $(this).val();

      if (selected_type == 'E. Others') {

        $('#inputspeIntModal').removeAttr('readonly');
      }
      else if (selected_type == 'A. Others') {

        $('#inputspeIntModal').removeAttr('readonly');
      }
      else if (selected_type == 'F. Others') {

        $('#inputspeIntModal').removeAttr('readonly');
      }
      else if (selected_type == 'G. Others') {

        $('#inputspeIntModal').removeAttr('readonly');
      }
      else if (selected_type) {
        $('#inputspeIntModal').attr('readonly', 'readonly');
      }
    });
  });

// End of disabling Specific Interventions: if others input box

// Start of disabling Service Provider: if others input box

$(function() {
    $('.serviceprovidersModal').attr('readonly', 'readonly')

    if ($('#serviceproviderModal option:selected').val() == 'Others') {

      $('#inputserviceproviderModal').removeAttr('readonly');
    }

    $('#serviceproviderModal').change(function(e) {
      var selected_type = $(this).val();

      if (selected_type == 'Others') {

        $('#inputserviceproviderModal').removeAttr('readonly');
      }
      else if (selected_type) {
        $('#inputserviceproviderModal').attr('readonly', 'readonly');
      }
    });
  });

// End of disabling Service Provider: if others input box

// End of Intervention Module Modal disabling If Others input box

// End of disabling Modal if Other input box function


// Start of disabling Service Provider drop-down list Add/Edit User

$(function() {
    var selected_option =  $('#role option:selected').val();

    if(selected_option != 'Service Provider'){
        $('#user_service_provider').attr('disabled', 'disabled');
        $('#user_service_provider option:selected').removeAttr('selected');
    }
    $('#role').change(function() {
      var selected_type = $(this).val();

      if (selected_type == 'Service Provider') {

        $('#user_service_provider').removeAttr('disabled');
      }
      else if (selected_type) {
        $('#user_service_provider').attr('disabled', 'disabled');
        $('#user_service_provider option:selected').removeAttr('selected');
      }
    });
  });

// End of disabling Service Provider drop-down list Add/Edit User

// Start of Search Directories

$('#serviceprovider').change(function(){
    
    var service_provider = $('#serviceprovider option:selected').val();

    $.ajax({
        url: rootURL + 'api/v1/case/search-directory/'+ service_provider,
        success: function (result) {    

            if(result == ''){

              // For Details of Service Provider:

              $('#im_dsp_full_name').parent().empty().html(`<span><p class="card-text">Full Name</p></span>
              <input id="im_dsp_full_name" name="im_dsp_full_name" class="w-100 form-control" placeholder="No Directories"/>`);

              $('#im_dsp_post_desi').val('');
              $('#im_dsp_email').val('');
              $('#im_dsp_contact_no_1').val('');
              $('#im_dsp_contact_no_2').val('');
              $('#im_dsp_contact_no_3').val('');


              // For Details of Alternate Service Provider:

              $('#im_dasp_full_name').parent().empty().html(`<span><p class="card-text">Full Name</p></span>
              <input id="im_dasp_full_name" name="im_dasp_full_name" class="w-100 form-control" placeholder="No Directories"/>`);

              $('#im_dasp_post_desi').val('');
              $('#im_dasp_email').val('');
              $('#im_dasp_contact_no_1').val('');
              $('#im_dasp_contact_no_2').val('');
              $('#im_dasp_contact_no_3').val('');

            }else{

              // For Details of Service Provider:

              $('#im_dsp_full_name').parent().html(`
                <span><p class="card-text">Full Name</p></span>
                <select id="im_dsp_full_name" aria-aria-controls='example' class="date-picker w-100 form-control">
                  <option value="">Please Select</option>
                </select>
                <input type="hidden" class="w-100 form-control" name="im_dsp_full_name" id="im_dsp_full_name_id"/>
              `);

              $('#im_dsp_post_desi').val('');
              $('#im_dsp_email').val('');
              $('#im_dsp_contact_no_1').val('');
              $('#im_dsp_contact_no_2').val('');
              $('#im_dsp_contact_no_3').val('');


              // For Details of Alternate Service Provider:

              $('#im_dasp_full_name').parent().html(`
              <span><p class="card-text">Full Name</p></span>
              <select id="im_dasp_full_name" aria-aria-controls='example' class="date-picker w-100 form-control">
                <option value="">Please Select</option>
              </select>
              <input type="hidden" class="w-100 form-control" name="im_dasp_full_name" id="im_dasp_full_name_id"/>
              `);

              $('#im_dasp_post_desi').val('');
              $('#im_dasp_email').val('');
              $('#im_dasp_contact_no_1').val('');
              $('#im_dasp_contact_no_2').val('');
              $('#im_dasp_contact_no_3').val('');

              result.forEach(element => {
  
                $('#im_dsp_full_name').append(`<option value="`+ element['id'] +`">`+ element['dir_first_name'] +` `+ element['dir_last_name'] +`</option>`);
                $('#im_dasp_full_name').append(`<option value="`+ element['id'] +`">`+ element['dir_first_name'] +` `+ element['dir_last_name'] +`</option>`);
  
              });

              // Start of Search Directories Details

              $('#im_dsp_full_name').change(function(){
                  
                var service_provider_details = $('#im_dsp_full_name option:selected').val();

                // Put Name Text value to im_dsp_full_name_id hidden input
                $('#im_dsp_full_name_id').val($('#im_dsp_full_name option:selected').text());

                $.ajax({
                    url: rootURL + 'api/v1/case/search-directory-details/'+ service_provider_details,
                    success: function (result) {    

                      $('#im_dsp_post_desi').val(result.dir_post_desi);
                      $('#im_dsp_email').val(result.dir_email);
                      $('#im_dsp_contact_no_1').val(result.dir_contact_no_1);
                      $('#im_dsp_contact_no_2').val(result.dir_contact_no_2);
                      $('#im_dsp_contact_no_3').val(result.dir_contact_no_3);
                    }
                });

              });

              // End of Search Directories Details

              // Start of Search Directories Details

              $('#im_dasp_full_name').change(function(){
    
                var service_provider_details = $('#im_dasp_full_name option:selected').val();

                // Put Name Text value to im_dasp_full_name_id hidden input
                $('#im_dasp_full_name_id').val($('#im_dasp_full_name option:selected').text());

                $.ajax({
                    url: rootURL + 'api/v1/case/search-directory-details/'+ service_provider_details,
                    success: function (result) {    

                      $('#im_dasp_post_desi').val(result.dir_post_desi);
                      $('#im_dasp_email').val(result.dir_email);
                      $('#im_dasp_contact_no_1').val(result.dir_contact_no_1);
                      $('#im_dasp_contact_no_2').val(result.dir_contact_no_2);
                      $('#im_dasp_contact_no_3').val(result.dir_contact_no_3);
                    }
                });

              });

              // End of Search Directories Details
            }

          
        }
    });

});

// End of Search Directories

// Start of Search Directories Modal

$('#serviceproviderModal').change(function(){
    
  var service_provider = $('#serviceproviderModal option:selected').val();

  $.ajax({
      url: rootURL + 'api/v1/case/search-directory/'+ service_provider,
      success: function (result) {    

          if(result == ''){ // If no directories found

            // For Details of Service Provider:

            $('#im_dsp_full_name_modal').parent().empty().html(`<span><p class="card-text">Full Name<span class="asterisk">*</span></p></span>
            <input id="im_dsp_full_name_modal" name="im_dsp_full_name_modal" class="w-100 form-control" placeholder="No Directories" required/>`);

            $('#im_dsp_post_desi_modal').val('');
            $('#im_dsp_email_modal').val('');
            $('#im_dsp_contact_no_1_modal').val('');
            $('#im_dsp_contact_no_2_modal').val('');
            $('#im_dsp_contact_no_3_modal').val('');


            // For Details of Alternate Service Provider:

            $('#im_dasp_full_name_modal').parent().empty().html(`<span><p class="card-text">Full Name</p></span>
            <input id="im_dasp_full_name_modal" name="im_dasp_full_name_modal" class="w-100 form-control" placeholder="No Directories"/>`);

            $('#im_dasp_post_desi_modal').val('');
            $('#im_dasp_email_modal').val('');
            $('#im_dasp_contact_no_1_modal').val('');
            $('#im_dasp_contact_no_2_modal').val('');
            $('#im_dasp_contact_no_3_modal').val('');

          }else{ // If with directories found

            // For Details of Service Provider:

            $('#im_dsp_full_name_modal').parent().html(`
              <span><p class="card-text">Full Name<span class="asterisk">*</span></p></span>
              <select id="im_dsp_full_name_modal" aria-aria-controls='example' class="date-picker w-100 form-control" required>
                <option value="">Please Select</option>
              </select>
              <input type="hidden" class="w-100 form-control" name="im_dsp_full_name_modal" id="im_dsp_full_name_modal_id"/>
            `);

            $('#im_dsp_post_desi_modal').val('');
            $('#im_dsp_email_modal').val('');
            $('#im_dsp_contact_no_1_modal').val('');
            $('#im_dsp_contact_no_2_modal').val('');
            $('#im_dsp_contact_no_3_modal').val('');


            // For Details of Alternate Service Provider:

            $('#im_dasp_full_name_modal').parent().html(`
              <span><p class="card-text">Full Name</p></span>
              <select id="im_dasp_full_name_modal" aria-aria-controls='example' class="date-picker w-100 form-control">
                <option value="">Please Select</option>
              </select>
              <input type="hidden" class="w-100 form-control" name="im_dasp_full_name_modal" id="im_dasp_full_name_modal_id"/>
            `);

            $('#im_dasp_post_desi_modal').val('');
            $('#im_dasp_email_modal').val('');
            $('#im_dasp_contact_no_1_modal').val('');
            $('#im_dasp_contact_no_2_modal').val('');
            $('#im_dasp_contact_no_3_modal').val('');

            result.forEach(element => {

              $('#im_dsp_full_name_modal').append(`<option value="`+ element['id'] +`">`+ element['dir_first_name'] +` `+ element['dir_last_name'] +`</option>`);
              $('#im_dasp_full_name_modal').append(`<option value="`+ element['id'] +`">`+ element['dir_first_name'] +` `+ element['dir_last_name'] +`</option>`);

            });

            // Start of Search Directories Modal Details

            $('#im_dsp_full_name_modal').change(function(){
                
              var service_provider_details = $('#im_dsp_full_name_modal option:selected').val();

              // Put Name Text value to im_dsp_full_name_modal_id hidden input
              $('#im_dsp_full_name_modal_id').val($('#im_dsp_full_name_modal option:selected').text());

              $.ajax({
                  url: rootURL + 'api/v1/case/search-directory-details/'+ service_provider_details,
                  success: function (result) {    

                    $('#im_dsp_post_desi_modal').val(result.dir_post_desi);
                    $('#im_dsp_email_modal').val(result.dir_email);
                    $('#im_dsp_contact_no_1_modal').val(result.dir_contact_no_1);
                    $('#im_dsp_contact_no_2_modal').val(result.dir_contact_no_2);
                    $('#im_dsp_contact_no_3_modal').val(result.dir_contact_no_3);
                  }
              });

            });

            // End of Search Directories Modal Details

            // Start of Search Directories Modal Details

            $('#im_dasp_full_name_modal').change(function(){
  
              var service_provider_details = $('#im_dasp_full_name_modal option:selected').val();

              // Put Name Text value to im_dasp_full_name_modal_id hidden input
              $('#im_dasp_full_name_modal_id').val($('#im_dasp_full_name_modal option:selected').text());

              $.ajax({
                  url: rootURL + 'api/v1/case/search-directory-details/'+ service_provider_details,
                  success: function (result) {    

                    $('#im_dasp_post_desi_modal').val(result.dir_post_desi);
                    $('#im_dasp_email_modal').val(result.dir_email);
                    $('#im_dasp_contact_no_1_modal').val(result.dir_contact_no_1);
                    $('#im_dasp_contact_no_2_modal').val(result.dir_contact_no_2);
                    $('#im_dasp_contact_no_3_modal').val(result.dir_contact_no_3);
                  }
              });

            });

            // End of Search Directories Modal Details
          }

        
      }
  });

});

// End of Search Directories Modal

// Start of Edit Directories

function changeDirectories(service_provider_id, service_provider_full_name_id, service_provider_position_id, service_provider_email_id, service_provider_1st_contact_id, service_provider_2nd_contact_id, service_provider_3rd_contact_id){
  
  Swal.fire({
    title: 'Do you want to change the Service Provider details?',
    html: "<center>Existing Service Provider details will be reset!</center>",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes'
  }).then((result) => {
  if (result.isConfirmed) {

    var service_provider = $('#'+ service_provider_id +' option:selected').val();

    $('#'+ service_provider_full_name_id +'').removeAttr('onclick');
    $('#'+ service_provider_position_id +'').removeAttr('onclick');
    $('#'+ service_provider_email_id +'').removeAttr('onclick');
    $('#'+ service_provider_1st_contact_id +'').removeAttr('onclick');
    $('#'+ service_provider_2nd_contact_id +'').removeAttr('onclick');
    $('#'+ service_provider_3rd_contact_id +'').removeAttr('onclick');

    $.ajax({
      url: rootURL + 'api/v1/case/search-directory/'+ service_provider,
      success: function (result) {    
  
        if(result == ''){
  
          // Set Details to empty if no directories
  
          $('#'+ service_provider_full_name_id +'').parent().empty().html(`<span><p class="card-text">Full Name</p></span>
          <input id="`+ service_provider_full_name_id +`" name="`+ service_provider_full_name_id +`" class="w-100 form-control" placeholder="No Directories"/>`);

          $('#'+ service_provider_position_id +'').val('');
          $('#'+ service_provider_email_id +'').val('');
          $('#'+ service_provider_1st_contact_id +'').val('');
          $('#'+ service_provider_2nd_contact_id +'').val('');
          $('#'+ service_provider_3rd_contact_id +'').val('');
  
        }else{
  
          // Set Details to empty if with directories
  
          $('#'+ service_provider_full_name_id +'').parent().html(`
            <span><p class="card-text">Full Name</p></span>
            <select id="`+ service_provider_full_name_id +`" aria-aria-controls='example' class="date-picker w-100 form-control">
              <option value="">Please Select</option>
            </select>
            <input type="hidden" class="w-100 form-control" name="`+ service_provider_full_name_id +`" id="`+ service_provider_full_name_id +`_id"/>
          `);

          $('#'+ service_provider_position_id +'').val('');
          $('#'+ service_provider_email_id +'').val('');
          $('#'+ service_provider_1st_contact_id +'').val('');
          $('#'+ service_provider_2nd_contact_id +'').val('');
          $('#'+ service_provider_3rd_contact_id +'').val('');
  
          result.forEach(element => {

            $('#'+ service_provider_full_name_id +'').append(`<option value="`+ element['id'] +`">`+ element['dir_first_name'] +` `+ element['dir_last_name'] +`</option>`);

          });

          // Start of Search Directories Details

          $('#'+ service_provider_full_name_id +'').change(function(){
  
            var service_provider_details = $('#'+ service_provider_full_name_id +' option:selected').val();

            // Put Name Text value to '+ service_provider_full_name_id +'_id hidden input
            $('#'+ service_provider_full_name_id +'_id').val($('#'+ service_provider_full_name_id +' option:selected').text());

            $.ajax({
                url: rootURL + 'api/v1/case/search-directory-details/'+ service_provider_details,
                success: function (result) {    

                  $('#'+ service_provider_position_id +'').val(result.dir_post_desi);
                  $('#'+ service_provider_email_id +'').val(result.dir_email);
                  $('#'+ service_provider_1st_contact_id +'').val(result.dir_contact_no_1);
                  $('#'+ service_provider_2nd_contact_id +'').val(result.dir_contact_no_2);
                  $('#'+ service_provider_3rd_contact_id +'').val(result.dir_contact_no_3);
                }
            });

          });

          // End of Search Directories Details
  
        }  
      }
    });
      
  }
  });

}

// End of Edit Directories


// Start of Search Function

// Search Case

function searchCase(){

  location.assign(rootURL + 'admin/case-folder/master-list/search/'+ $('#case_search_option option:selected').val() + '/' + $('#case_no_or_last_name_search').val());

}


// Search User

function searchUser(){

  location.assign(rootURL + 'admin/rights-management/user/search/'+ $('#user_last_name_search').val());

}

// Search Directories

function searchDirectories(){
  
  location.assign(rootURL + 'admin/maintenance/directory/search/'+ $('#directory_last_name_search').val());

}

// Sort List of GBV Cases Per Month

function sortListOfGBVCasesPerMonth(){
  
  location.assign(rootURL + 'admin/report/sort-list-of-gbv-cases-per-month/'+ $('#date_from_sort_gbv_cases_per_month').val() +'/'+ $('#date_to_sort_gbv_cases_per_month').val());

}

// End of Search Function

