// Start of submit form using Sweet Alert


function submitCreateCaseForm($formStatus){

    Swal.fire({
        title: 'Do you want to save the changes?',
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'Save',
        denyButtonText: `Don't save`,
    }).then((result) => {
        if (result.isConfirmed) {

            $("#form_status").val($formStatus);
            $.ajax({
                type: "POST",
                url: rootURL + 'api/v1/case/add',
                data: $("#msform").serialize(),
                success: function(response) {

                    if (response === 'Case successfully created and submitted'){
                        Swal.fire({
                            icon: 'success',
                            title: 'Saved!',
                            html: `<center>Case successfully created and submitted.</center>`
                        });
                        $('#error-form').empty();
                        location.assign(rootURL + 'admin/case-folder/master-list');
                    }
                    else if (response === 'Case successfully saved as draft'){
                        Swal.fire({
                            icon: 'success',
                            title: 'Saved!',
                            html: `<center>Case successfully saved as draft.</center>`
                        });
                        $('#error-form').empty();
                        location.assign(rootURL + 'admin/case-folder/master-list');
                    }
                    else if (response === `Sorry you don't have the rights to create case please contact the administrator`){
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            html: `<center>Sorry you don't have the rights to create case please contact the administrator.</center>`
                        });
                        $('#error-form').empty();
                        location.assign(rootURL + 'admin/case-folder/master-list');
                    }
                    else{

                        Swal.fire('The case was not created!', '', 'error');

                        html = "";
                        $.each(response, function( index, value ) {
                            html += '<p class="d-flex justify-content-center text-danger">'+ value +'</p>';
                        });
                        html += '<hr>';

                        $('#error-form').empty().prepend(html);
                    }
                }
            });
        } else if (result.isDenied) {

            Swal.fire('Changes are not saved', '', 'info')
        }
    });

}


// End of submit form using Sweet Alert

// Start of submit Edit case form using Sweet Alert

function submitEditCaseForm($formStatus, $case_no){

    Swal.fire({
        title: 'Do you want to save the changes?',
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'Save',
        denyButtonText: `Don't save`,
    }).then((result) => {
        if (result.isConfirmed) {

            $("#form_status").val($formStatus);
            $.ajax({
                type: "POST",
                url: rootURL + 'admin/case-folder/update-created-case/' + $case_no,
                data: $("#msform").serialize(),
                success: function(response) {

                    if (response === 'Case successfully submitted'){
                        Swal.fire({
                            icon: 'success',
                            title: 'Saved!',
                            html: `<center>Case successfully submitted.</center>`
                        });
                        $('#error-form').empty();
                        location.assign(rootURL + 'admin/case-folder/master-list');
                    }
                    else if (response === 'Case successfully saved as draft'){
                        Swal.fire({
                            icon: 'success',
                            title: 'Saved!',
                            html: `<center>Case successfully saved as draft.</center>`
                        });
                        $('#error-form').empty();
                        location.assign(rootURL + 'admin/case-folder/master-list');
                    }
                    else if (response === 'Case already closed editing was disabled'){
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            html: `<center>Case already closed editing was disabled.</center>`
                        });
                        $('#error-form').empty();
                        location.assign(rootURL + 'admin/case-folder/master-list');
                    }
                    else if (response === `Sorry you don't have the rights to update this case please contact the administrator`){
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            html: `<center>Sorry you don't have the rights to update this case please contact the administrator.</center>`
                        });
                        $('#error-form').empty();
                        location.assign(rootURL + 'admin/case-folder/master-list');
                    }
                    else{

                        Swal.fire('Updating the case was unsuccessful!', '', 'error');

                        html = "";
                        $.each(response, function( index, value ) {
                            html += '<p class="d-flex justify-content-center text-danger">'+ value +'</p>';
                        });
                        html += '<hr>';

                        $('#error-form').empty().prepend(html);
                    }

                }
            });
        } else if (result.isDenied) {

            Swal.fire('Changes are not saved', '', 'info')
        }
    });

}

// End of submit Edit case form using Sweet Alert


// Start of upload file form javascript script

if($('#upload_file_form').html()){

    const form = document.querySelector("#upload_file_form"),
    fileInput = form.querySelector("#file"),
    progressArea = document.querySelector(".progress-area"),
    uploadedArea = document.querySelector(".uploaded-area");

    form.addEventListener("click", ()=>{

        if($('#case_no').val() != ""){
            fileInput.click();
        }
        else{
            Swal.fire('Case No. must be filled');
        }

    });

    fileInput.onchange = ({target}) =>{

        let file = target.files[0];
        if(file){
            let fileName = file.name;

            if(fileName.legth >=12){
                let splitName = fileName.split('.');
                fileName = splitName[0].substring(0, 12) + "... ." + splitName[1];
            }
            uploadFile(fileName);
        }
    }

    function uploadFile(name){

        let xhr = new XMLHttpRequest();
        xhr.open("POST", rootURL + 'api/v1/case/upload/'+ $("#case_no").val());

        // Start upload progress event listener

        xhr.upload.addEventListener("progress", ({loaded, total}) =>{

            let fileLoaded = Math.floor((loaded / total) * 100); // getting loaded file size
            let fileTotal = Math.floor(total / 1000); // getting filesize in kb
            let fileSize;
            (fileTotal < 1024) ? fileSize = fileTotal + " KB" : fileSize = (loaded / (1024 * 1024)).toFixed(2) + " MB";
            let progressHTML = `<li class="row" style="background: #fceae8; margin-bottom: 10px; list-style: none; padding: 15px 20px; border-radius: 5px; display: flex; justify-content: space-between;">
                                    <i class="fa fa-file-alt" style="font-size: 30px; color: #eb6c60;"></i>
                                    <div class="content" style="width: 89%; margin-left: 15px;">
                                        <div class="details" style="display: flex; align-items: center; margin-bottom: 7px; justify-content: space-between;">
                                            <span class="name" style="font-size: 14px;">${name} - Uploading</span>
                                            <span class="percent" style="font-size: 14px;">${fileLoaded}50%</span>
                                        </div>
                                        <div class="progress-bar" style="height: 16px; width: 100%; background: #fff; margin-bottom: 4px; border-radius: 30px;">
                                            <div class="progress" style="height: 100%; width: ${fileLoaded}%; background: #eb6c60; border-radius: inherit;"></div>
                                        </div>
                                    </div>
                                </li>`;

            uploadedArea.classList.add("onprogress");
            progressArea.innerHTML = progressHTML;

            if(loaded == total){

                    progressArea.innerHTML = "";

                    let uploadedHTML = `<li class="row" style="background: #fceae8; margin-bottom: 10px; list-style: none; padding: 15px 20px; border-radius: 5px; display: flex; justify-content: space-between;">
                                            <div class="content" style="display: flex; align-items: center;">
                                                <i class="fa fa-file-alt" style="font-size: 30px; color: #eb6c60;"></i>
                                                <div class="details" style="display: flex; margin-left: 15px; flex-direction: column;">
                                                    <span class="name" style="font-size: 14px;">${name} - Uploaded</span>
                                                    <span class="size" style="font-size: 11px; color: #404040;">${fileSize}</span>
                                                </div>
                                            </div>
                                            <i class="fa fa-check" style="color: #eb6c60; font-size: 16px;"></i>
                                        </li>`;

                uploadedArea.classList.remove("onprogress")
                uploadedArea.insertAdjacentHTML("afterbegin", uploadedHTML);

            }
        });

        // Check server response status

        xhr.onreadystatechange = function() {
            if (xhr.readyState == XMLHttpRequest.DONE) {

                // Check User Authorization

                if(xhr.responseText == `Sorry you don't have the rights to upload files, uploaded file was not saved please contact the administrator`){

                    let progressHTML = `<header style="color: #eb6c60; font-size: 17px; font-weight: 600; text-align: center;">Sorry you don't have the rights to upload files, uploaded file was not saved please contact the administrator</header>`;

                    progressArea.innerHTML = progressHTML;
                }
                else if(xhr.responseText == `Case already closed, the uploaded file was not saved`){

                    let progressHTML = `<header style="color: #eb6c60; font-size: 17px; font-weight: 600; text-align: center;">Case already closed, the uploaded file was not saved</header>`;

                    progressArea.innerHTML = progressHTML;

                }
            }
        }

        let formData = new FormData(form);
        xhr.send(formData);
    }

}

// End of upload file form javascript script


// Start of getting the case uploaded files link

function closeUploadFileModalForm(){

    $.ajax({
        url: rootURL + 'api/v1/case/case-files/'+ $("#case_no").val(),
        success: function (result) {

            // Empty Uploaded files Table
            $("#case_uploaded_files_table_data").empty();

            result.uploaded_files_in_case.forEach(element => {
                $('#case_uploaded_files_table_data').append('<tr>'+
                '<td>'+
                ((result.master_list_rights_delete == true) ? '<a href="javascript:void(0);" class="text-orange-icon" onclick="deleteCaseUploadedFilesModal('+ element['id'] +', `'+ element['case_no'] +'`,`'+ element['file'] +'`)"><i class="fa fa-trash"></i></a>' : '') +
                '</td>'+
                '<td><a href="'+ rootURL +''+ element['file_location'] +'">'+ element['file'] +'</a></td>'+
                '<td>'+ new Date(element['created_at']).toISOString().split('T')[0] +'</td>'+
                '</tr>');
            });
        }
    });
}


// End of getting the case uploaded files link

// Start of deleting case uploaded files Sweet Alert modal


    function deleteCaseUploadedFilesModal($id, $case_no, $file){
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: rootURL + 'api/v1/case/delete-case-files/' + $id + '/' + $case_no + '/' + $file,
                    data: {
                        _method: 'delete',
                    },
                    success: function(response) {

                        if (response === 'The file was successfully deleted'){
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                html: `<center>The file was successfully deleted.</center>`
                            });
                            closeUploadFileModalForm();
                        }
                        else if (response === `Sorry you don't have the rights to delete case record please contact the administrator`){
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                html: `<center>Sorry you don't have the rights to delete case record please contact the administrator.</center>`
                            });
                            closeUploadFileModalForm();
                        }
                        else if (response === 'Case already closed delete was disabled'){
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                html: `<center>Case already closed delete was disabled.</center>`
                            });
                            closeUploadFileModalForm();
                        }
                        else{
                            Swal.fire('The file was not deleted!', '', 'error');
                        }
                    }
                });

            }else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }
        });
    }


// End of deleting case uploaded files Sweet Alert modal

// Start of submit additional Family Background info form using Sweet Alert


function submitAdditionalFamilyBackgroundForm(){

    Swal.fire({
        title: 'Do you want to save the changes?',
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'Save',
        denyButtonText: `Don't save`,
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                type: "POST",
                url: rootURL + 'api/v1/family-background-infos/add',
                data: $('#fam_back_infos').serialize(),
                success: function(response) {

                    if (response === `Creating Family Background Info Success`){
                        Swal.fire({
                            icon: 'success',
                            title: 'Saved!',
                            html: `<center>Creating Family Background Info Success.</center>`
                        });
                        closeAdditionalFamilyBackgroundForm();
                        $('#fam_back_modal').modal('toggle');
                        $('#fam_back_infos').trigger("reset");
                        $('#add-family-background-error-form').empty();
                    }
                    else if (response === `Sorry you don't have the rights to add record please contact the administrator`){
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            html: `<center>Sorry you don't have the rights to add record please contact the administrator.</center>`
                        });
                        closeAdditionalFamilyBackgroundForm();
                        $('#fam_back_modal').modal('toggle');
                        $('#fam_back_infos').trigger("reset");
                        $('#add-family-background-error-form').empty();
                    }
                    else if (response === `Case already closed add record was disabled`){
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            html: `<center>Case already closed add record was disabled.</center>`
                        });
                        closeAdditionalFamilyBackgroundForm();
                        $('#fam_back_modal').modal('toggle');
                        $('#fam_back_infos').trigger("reset");
                        $('#add-family-background-error-form').empty();
                    }
                    else{

                        Swal.fire('The Family Background info was not created!', '', 'error');

                        html = "";
                        $.each(response, function( index, value ) {
                            html += '<p class="d-flex justify-content-center text-danger">'+ value +'</p>';
                        });
                        html += '<hr>';

                        $('#add-family-background-error-form').empty().prepend(html);
                    }
                }
            });
        } else if (result.isDenied) {

            Swal.fire('Changes are not saved', '', 'info')
        }
    });

}

// End of submit additional Family Background info form using Sweet Alert


// Start of getting the additional Family Background info

function closeAdditionalFamilyBackgroundForm(){

    $.ajax({
        url: rootURL + 'api/v1/family-background-infos/get/' + $('#case_no').val(),
        success: function (result) {

            // Empty Additional Family Background Table
            $("#fam_back_table_tbody").empty();

            result.dataFam.forEach(element => {
                $('#fam_back_table_tbody').append('<tr>'+
                '<td>'+
                    ((result.master_list_rights_revise == true) ? '<a href="javascript:void(0)" class="text-orange-icon" data-bs-toggle="modal" data-bs-target="#fam_back_modal" onclick="getSpecificAdditionalFamilyBackgroundForm('+ element['id'] +', `Edit`)"><i class="fa fa-edit"></i></a>' : '') +
                    '<a href="javascript:void(0)" class="text-orange-icon" data-bs-toggle="modal" data-bs-target="#fam_back_modal" onclick="getSpecificAdditionalFamilyBackgroundForm('+ element['id'] +', `View`)"><i class="fa fa-eye"></i></a>'+
                    ((result.master_list_rights_delete == true) ? '<a href="javascript:void(0)" class="text-orange-icon" onclick="deleteSpecificAdditionalFamilyBackgroundModal('+ element['id'] +')"><i class="fa fa-trash"></i></a>' : '') +
                '</td>'+
                '<td>'+ ((element['name_par_guar_modal'] == null) ? '-' : element['name_par_guar_modal']) +'</td>'+
                '<td>'+ ((element['rel_vict_sur_modal'] == null) ? '-' : element['rel_vict_sur_modal']) +'</td>'+
                '<td>'+ ((element['age_vict_sur_modal'] == null) ? '-' : element['age_vict_sur_modal']) +'</td>'+
                '<td>'+ ((element['job_vict_sur_modal'] == null) ? '-' : element['job_vict_sur_modal']) +'</td>'+
                '<td>'+ ((element['fam_back_house_no_modal'] == null) ? '' : element['fam_back_house_no_modal']) + ' ' + ((element['fam_back_street_modal'] == null) ? '' : element['fam_back_street_modal']) + ' ' + ((element['fam_back_barangay_modal'] == null) ? '' : element['fam_back_barangay_modal']) + ' ' + ((element['fam_back_city_modal'] == null) ? '' : element['fam_back_city_modal']) + '</td>'+
                '<td>'+ ((element['fam_back_cont_num_modal'] == null) ? '-' : element['fam_back_cont_num_modal']) +'</td>'+
                '</tr>');
            });
        }
    });

    // Reset Relationship to the Victim-Survivor dropdown list

    $.ajax({
        url: rootURL + 'api/v1/case/get-relationship-to-victim-survivors-list',
        success: function (result) {

            // Empty Dropdown List
            $("#rel_vict_sur_modal").empty();

            $('#rel_vict_sur_modal').prepend('<option value="">Please Select</option>');

            result.forEach(element => {
                $('#rel_vict_sur_modal').append('<option value="'+ element['item_name'] +'">'+ element['item_name'] +'</option>');
            });

            $('#rel_vict_sur_modal').append('<option value="Other Relatives, Specify:">Other Relatives, Specify:</option>');
        }
    });

    // Unhide Save Button
    $('#fam_back_modal_save').removeAttr('hidden');

    // Removed disabled and readonly in input, and select option
    $('#fam_back_infos * input').removeAttr('readonly');
    $('#fam_back_infos * select').removeAttr('disabled');

    // Reset address field and removed onclick changeAddress() function

    $('#fam_back_region_modal').empty().prop('onclick', null);
    $('#fam_back_province_modal').empty().prop('onclick', null);
    $('#fam_back_city_modal').empty().prop('onclick', null);
    $('#fam_back_barangay_modal').empty().prop('onclick', null);

    $('#fam_back_region_modal').append('<option value="">Please Select</option>');

    // Reset Automated Dropdowns Location

    $('#fam_back_region_modal').ph_locations('fetch_list');

    // Set Other input field to readonly
    $('#rttvs_if_oth_pls_spec_modal').attr('readonly','readonly');

    // Remove Relationship to the Victim-Survivor: onclick attribute changeRelationshipToTheVictimSurvivor() function
    $('#rel_vict_sur_modal').attr('onclick','');

    // Reset form
    $('#fam_back_infos').trigger("reset");
    $('#fam_back_infos').attr('onsubmit','submitAdditionalFamilyBackgroundForm()');

}


// End of getting the additional Family Background info

// Start of editing the additional Family Background specific info


function getSpecificAdditionalFamilyBackgroundForm(id, option){

    // Open Sweet alert for waiting time to the populate data

    Swal.fire({
        icon: 'info',
        title: 'Populating data...',
        showConfirmButton: true,
    })

    if(option == 'View'){

        // Hide Save Button
        $('#fam_back_modal_save').attr('hidden','hidden');

        // Set input, and select option to disabled and readonly
        $('#fam_back_infos * input').attr('readonly','readonly');
        $('#fam_back_infos * select').attr('disabled','disabled');

    }

    else if(option == 'Edit'){

        // Set Modal form tag onsubmit attribute to update function
        $('#fam_back_infos').attr('onsubmit','updateAdditionalFamilyBackgroundForm('+ id +')');

        // Set Relationship to the Victim-Survivor: onclick attribute to changeRelationshipToTheVictimSurvivor() function
        $('#rel_vict_sur_modal').attr('onclick','changeRelationshipToTheVictimSurvivor("rel_vict_sur_modal")');

        // Set address field onclick attribute to changeAddress() function
        $('#fam_back_region_modal').empty().attr('onclick', 'changeAddress("fam_back_region_modal", "fam_back_province_modal", "fam_back_city_modal", "fam_back_barangay_modal")');
        $('#fam_back_province_modal').empty().attr('onclick', 'changeAddress("fam_back_region_modal", "fam_back_province_modal", "fam_back_city_modal", "fam_back_barangay_modal")');
        $('#fam_back_city_modal').empty().attr('onclick', 'changeAddress("fam_back_region_modal", "fam_back_province_modal", "fam_back_city_modal", "fam_back_barangay_modal")');
        $('#fam_back_barangay_modal').empty().attr('onclick', 'changeAddress("fam_back_region_modal", "fam_back_province_modal", "fam_back_city_modal", "fam_back_barangay_modal")');

    }

    $.ajax({
        url: rootURL + 'api/v1/family-background-infos/get-specific-additional-record/' + id,
        success: function (result) {

            // Populate result to Family Background add record Modal

            $('#name_par_guar_modal').val(result.name_par_guar_modal);
            $('#job_vict_sur_modal').val(result.job_vict_sur_modal);
            $('#age_vict_sur_modal').val(result.age_vict_sur_modal);
            $('#rel_vict_sur_modal').empty().html('<option value="'+ result.rel_vict_sur_modal +'" selected>'+ result.rel_vict_sur_modal +'</option>');
            $('#rttvs_if_oth_pls_spec_modal').val(result.rttvs_if_oth_pls_spec_modal);
            $('#fam_back_house_no_modal').val(result.fam_back_house_no_modal);
            $('#fam_back_street_modal').val(result.fam_back_street_modal);
            $('#fam_back_region_modal').empty().html('<option value="'+ result.fam_back_region_modal +'" selected>'+ result.fam_back_region_modal +'</option>');
            $('#fam_back_region_modal_id').val(result.fam_back_region_modal);
            $('#fam_back_province_modal').empty().html('<option value="'+ result.fam_back_province_modal +'" selected>'+ result.fam_back_province_modal +'</option>');
            $('#fam_back_province_modal_id').val(result.fam_back_province_modal);
            $('#fam_back_city_modal').empty().html('<option value="'+ result.fam_back_city_modal +'" selected>'+ result.fam_back_city_modal +'</option>');
            $('#fam_back_city_modal_id').val(result.fam_back_city_modal);
            $('#fam_back_barangay_modal').empty().html('<option value="'+ result.fam_back_barangay_modal +'" selected>'+ result.fam_back_barangay_modal +'</option>');
            $('#fam_back_barangay_modal_id').val(result.fam_back_barangay_modal);
            $('#fam_back_cont_num_modal').val(result.fam_back_cont_num_modal);

            // Close Sweet Alert after populating the data

            Swal.close();

            if(option == 'Edit'){

                // Removed or set readonly to other input field

                if ((result.rel_vict_sur_modal == 'Other Relatives, Specify:')  || (result.rel_vict_sur_modal == 'Immediate Family Members, Specify:') || (result.rel_vict_sur_modal == 'Stepfamily Members, Specify:')) {

                    $('.relvicInputModal').removeAttr('readonly');
                }else{

                    $('.relvicInputModal').attr('readonly','readonly');
                }
            }

        }
    });
}


// End of editing the additional Family Background specific info

// Start of update additional Family Background info form using Sweet Alert


function updateAdditionalFamilyBackgroundForm(id){

    Swal.fire({
        title: 'Do you want to save the changes?',
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'Save',
        denyButtonText: `Don't save`,
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                type: "POST",
                url: rootURL + 'api/v1/family-background-infos/update/'+ id,
                data: $("#fam_back_infos").serialize(),
                success: function(response) {

                    if (response === 'Updating Family Background Info Success'){
                        Swal.fire({
                            icon: 'success',
                            title: 'Saved!',
                            html: `<center>Updating Family Background Info Success.</center>`
                        });
                        closeAdditionalFamilyBackgroundForm();
                        $('#fam_back_modal').modal('toggle');
                        $('#fam_back_infos').trigger("reset");
                        $('#add-family-background-error-form').empty();
                    }
                    else if (response === 'Case already closed editing was disabled'){
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            html: `<center>Case already closed editing was disabled.</center>`
                        });
                        closeAdditionalFamilyBackgroundForm();
                        $('#fam_back_modal').modal('toggle');
                        $('#fam_back_infos').trigger("reset");
                        $('#add-family-background-error-form').empty();
                    }
                    else if (response === `Sorry you don't have the rights to update this case please contact the administrator`){
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            html: `<center>Sorry you don't have the rights to update this case please contact the administrator.</center>`
                        });
                        closeAdditionalFamilyBackgroundForm();
                        $('#fam_back_modal').modal('toggle');
                        $('#fam_back_infos').trigger("reset");
                        $('#add-family-background-error-form').empty();
                    }
                    else{

                        Swal.fire('The Family Background info was not updated!', '', 'error');

                        html = "";
                        $.each(response, function( index, value ) {
                            html += '<p class="d-flex justify-content-center text-danger">'+ value +'</p>';
                        });
                        html += '<hr>';

                        $('#add-family-background-error-form').empty().prepend(html);
                    }
                }
            });
        } else if (result.isDenied) {

            Swal.fire('Changes are not saved', '', 'info')
        }
    });

}


// End of update additional Family Background info form using Sweet Alert

// Start of deleting additional Family Background info Sweet Alert modal


    function deleteSpecificAdditionalFamilyBackgroundModal(id){
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: rootURL + 'api/v1/family-background-infos/delete/' + id,
                    data: {
                        _method: 'delete',
                    },
                    success: function(response) {

                        if (response === 'The Family Background Info was successfully deleted'){
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                html: `<center>The Family Background Info was successfully deleted.</center>`,
                            });
                            closeAdditionalFamilyBackgroundForm();
                        }
                        else if (response === `Sorry you don't have the rights to delete case record please contact the administrator`){
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                html: `<center>Sorry you don't have the rights to delete case record please contact the administrator.</center>`,
                            });
                            closeAdditionalFamilyBackgroundForm();
                        }
                        else if (response === 'Case already closed delete was disabled'){
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                html: `<center>Case already closed delete was disabled.</center>`,
                            });
                            closeAdditionalFamilyBackgroundForm();
                        }
                        else{
                            Swal.fire('The Family Background Info was not deleted!', '', 'error');
                        }
                    }
                });

            }else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }
        });
    }


// End of deleting additional Family Background info Sweet Alert modal

// Start of submit additional Incidence Details info form using Sweet Alert


function submitAdditionalIncidenceDetailsForm(){

    Swal.fire({
        title: 'Do you want to save the changes?',
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'Save',
        denyButtonText: `Don't save`,
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                type: "POST",
                url: rootURL + 'api/v1/incidence-detail-infos/add',
                data: $("#addIncidenceDetailInfos").serialize(),
                success: function(response) {

                    if (response === `Creating Incidence Details Info Success`){
                        Swal.fire({
                            icon: 'success',
                            title: 'Saved!',
                            html: `<center>Creating Incidence Details Info Success.</center>`
                        });
                        closeAdditionalIncidenceDetailsForm();
                        $('#modalIncidenceDetails').modal('toggle');
                        $('#addIncidenceDetailInfos').trigger("reset");
                        $('#add-incidence-details-error-form').empty();
                    }
                    else if (response === `Sorry you don't have the rights to add record please contact the administrator`){
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            html: `<center>Sorry you don't have the rights to add record please contact the administrator.</center>`
                        });
                        closeAdditionalIncidenceDetailsForm();
                        $('#modalIncidenceDetails').modal('toggle');
                        $('#addIncidenceDetailInfos').trigger("reset");
                        $('#add-incidence-details-error-form').empty();
                    }
                    else if (response === `Case already closed add record was disabled`){
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            html: `<center>Case already closed add record was disabled.</center>`
                        });
                        closeAdditionalIncidenceDetailsForm();
                        $('#modalIncidenceDetails').modal('toggle');
                        $('#addIncidenceDetailInfos').trigger("reset");
                        $('#add-incidence-details-error-form').empty();
                    }
                    else{

                        Swal.fire('The Incidence Details info was not created!', '', 'error');

                        html = "";
                        $.each(response, function( index, value ) {
                            html += '<p class="d-flex justify-content-center text-danger">'+ value +'</p>';
                        });
                        html += '<hr>';

                        $('#add-incidence-details-error-form').empty().prepend(html);
                    }
                }
            });
        } else if (result.isDenied) {

            Swal.fire('Changes are not saved', '', 'info')
        }
    });

}


// End of submit additional Incidence Details info form using Sweet Alert

// Start of getting the additional Incidence Details info


function closeAdditionalIncidenceDetailsForm(){

    $.ajax({
        url: rootURL + 'api/v1/incidence-detail-infos/get/' + $('#case_no').val(),
        success: function (result) {

            // Empty Additional Incidence Details Table
            $("#inci_det_table_tbody").empty();

            result.dataInci.forEach(element => {
                $('#inci_det_table_tbody').append('<tr>'+
                '<td>'+
                    ((result.master_list_rights_revise == true) ? '<a href="javascript:void(0)" class="text-orange-icon" data-bs-toggle="modal" data-bs-target="#modalIncidenceDetails" onclick="getSpecificAdditionalIncidenceDetailsForm('+ element['id'] +', `Edit`)"><i class="fa fa-edit"></i></a>' : '') +
                    '<a href="javascript:void(0)" class="text-orange-icon" data-bs-toggle="modal" data-bs-target="#modalIncidenceDetails" onclick="getSpecificAdditionalIncidenceDetailsForm('+ element['id'] +', `View`)"><i class="fa fa-eye"></i></a>'+
                    ((result.master_list_rights_delete == true) ? '<a href="javascript:void(0)" class="text-orange-icon" onclick="deleteSpecificAdditionalIncidenceDetailsModal('+ element['id'] +')"><i class="fa fa-trash"></i></a>' : '') +
                '</td>'+
                '<td>'+ ((element['id_date_of_inci_modal'] == null) ? '-' : element['id_date_of_inci_modal']) +'</td>'+
                '<td>'+ ((element['id_pla_of_inci_modal'] == null) ? '-' : element['id_pla_of_inci_modal']) +'</td>'+
                '<td>'+ ((element['id_int_part_vio_modal'] == null) ? '' : element['id_int_part_vio_modal']) + ' ' + ((element['id_rape_modal'] == null) ? '' : element['id_rape_modal']) +' ' + ((element['id_traf_per_modal'] == null) ? '' : element['id_traf_per_modal']) +' ' + ((element['id_sex_hara_modal'] == null) ? '' : element['id_sex_hara_modal']) +' '+ ((element['id_chi_abu_modal'] == null) ? '' : element['id_chi_abu_modal']) +'</td>'+
                '<td>'+ ((element['id_descr_inci_modal'] == null) ? '-' : element['id_descr_inci_modal']) +'</td>'+
                '</tr>');
            });
        }
    });

    // Reset Place of Incidence: list

    $.ajax({
        url: rootURL + 'api/v1/case/get-place-of-incidences-list',
        success: function (result) {

            // Empty Dropdown List
            $("#placeinciModal").empty();

            $('#placeinciModal').prepend('<option value="">Please Select</option>');

            result.forEach(element => {
                $('#placeinciModal').append('<option value="'+ element['item_name'] +'">'+ element['item_name'] +'</option>');
            });

            $('#placeinciModal').append('<option value="Others">Others</option>');
        }
    });

    // Unhide Save Button
    $('#inci_det_modal_save').removeAttr('hidden');

    // Removed disabled and readonly in input, checkbox button, textarea and select option
    $('#addIncidenceDetailInfos * input').removeAttr('readonly');
    $('#addIncidenceDetailInfos * select').removeAttr('disabled');
    $('#addIncidenceDetailInfos * [type="checkbox"]').removeAttr('disabled');
    $('#addIncidenceDetailInfos * textarea').removeAttr('readonly');

    // Reset address field and removed onclick changeAddress() function

    $('#inci_det_region_modal').empty().prop('onclick', null);
    $('#inci_det_province_modal').empty().prop('onclick', null);
    $('#inci_det_city_modal').empty().prop('onclick', null);
    $('#inci_det_barangay_modal').empty().prop('onclick', null);

    $('#inci_det_region_modal').append('<option value="">Please Select</option>');

    // Reset Automated Dropdowns Location

    $('#inci_det_region_modal').ph_locations('fetch_list');

    // Set Other input field to readonly
    $('#inputTrafperModal').attr('readonly','readonly');
    $('#inputSexHaModal').attr('readonly','readonly');
    $('#inputchiAedModal').attr('readonly','readonly');
    $('#inputplaceInciModal').attr('readonly','readonly');

    // Reset form
    $('#addIncidenceDetailInfos').trigger("reset");
    $('#addIncidenceDetailInfos * [type="checkbox"]').removeAttr('checked');
    $('#id_was_inc_perp_onl_modal option').removeAttr('selected');
    $('#id_descr_inci_modal').text('');
    $('#addIncidenceDetailInfos').attr('onsubmit','submitAdditionalIncidenceDetailsForm()');
}


// End of getting the additional Incidence Details info

// Start of editing the additional Incidence Details specific info


function getSpecificAdditionalIncidenceDetailsForm(id, option){

    // Open Sweet alert for waiting time to the populate data

    Swal.fire({
        icon: 'info',
        title: 'Populating data...',
        showConfirmButton: true,
    })

    if(option == 'View'){

        // Hide Save Button
        $('#inci_det_modal_save').attr('hidden','hidden');

        // Set input, checkbox button, textarea and select option to disabled and readonly
        $('#addIncidenceDetailInfos * input').attr('readonly','readonly');
        $('#addIncidenceDetailInfos * select').attr('disabled','disabled');
        $('#addIncidenceDetailInfos * [type="checkbox"]').attr('disabled','disabled');
        $('#addIncidenceDetailInfos * textarea').attr('readonly','readonly');

    }

    else if(option == 'Edit'){

        // Set Modal form tag onsubmit attribute to update function
        $('#addIncidenceDetailInfos').attr('onsubmit','updateAdditionalIncidenceDetailsForm('+ id +')');

        // Set Place of Incidence: onclick attribute to changePlaceOfIncidence() function
        $('#placeinciModal').attr('onclick','changePlaceOfIncidence("placeinciModal")');

        // Set address field onclick attribute to changeAddress() function
        $('#inci_det_region_modal').empty().attr('onclick', 'changeAddress("inci_det_region_modal", "inci_det_province_modal", "inci_det_city_modal", "inci_det_barangay_modal")');
        $('#inci_det_province_modal').empty().attr('onclick', 'changeAddress("inci_det_region_modal", "inci_det_province_modal", "inci_det_city_modal", "inci_det_barangay_modal")');
        $('#inci_det_city_modal').empty().attr('onclick', 'changeAddress("inci_det_region_modal", "inci_det_province_modal", "inci_det_city_modal", "inci_det_barangay_modal")');
        $('#inci_det_barangay_modal').empty().attr('onclick', 'changeAddress("inci_det_region_modal", "inci_det_province_modal", "inci_det_city_modal", "inci_det_barangay_modal")');

    }

    $.ajax({
        url: rootURL + 'api/v1/incidence-detail-infos/get-specific-additional-record/' + id,
        success: function (result) {

            // Populate result to Incidence Details add record Modal

            $('#id_date_int_modal').val(result.id_date_int_modal);
            $('#id_name_intervi_modal').val(result.id_name_intervi_modal);
            $('#id_pos_desi_int_modal').val(result.id_pos_desi_int_modal);

            if(result.id_int_part_vio_modal != null){
                $('#id_int_part_vio_modal').attr('checked', 'checked');
            }
            if(result.id_ipv_phys_modal != null){
                $('#id_ipv_phys_modal').attr('checked', 'checked');
            }
            if(result.id_ipv_sexual_modal != null){
                $('#id_ipv_sexual_modal').attr('checked', 'checked');
            }
            if(result.id_ipv_psycho_modal != null){
                $('#id_ipv_psycho_modal').attr('checked', 'checked');
            }
            if(result.id_ipv_econo_modal != null){
                $('#id_ipv_econo_modal').attr('checked', 'checked');
            }
            if(result.id_rape_modal != null){
                $('#id_rape_modal').attr('checked', 'checked');
            }
            if(result.id_rape_incest_modal != null){
                $('#id_rape_incest_modal').attr('checked', 'checked');
            }
            if(result.id_rape_sta_rape_modal != null){
                $('#id_rape_sta_rape_modal').attr('checked', 'checked');
            }
            if(result.id_rape_sex_int_modal != null){
                $('#id_rape_sex_int_modal').attr('checked', 'checked');
            }
            if(result.id_rape_sex_assa_modal != null){
                $('#id_rape_sex_assa_modal').attr('checked', 'checked');
            }
            if(result.id_rape_mar_rape_modal != null){
                $('#id_rape_mar_rape_modal').attr('checked', 'checked');
            }
            if(result.id_traf_per_modal != null){
                $('#id_traf_per_modal').attr('checked', 'checked');
            }
            if(result.id_traf_per_sex_exp_modal != null){
                $('#id_traf_per_sex_exp_modal').attr('checked', 'checked');
            }
            if(result.id_traf_per_onl_exp_modal != null){
                $('#id_traf_per_onl_exp_modal').attr('checked', 'checked');
            }
            if(result.id_traf_per_others_modal != null){
                $('#trafPerModal').attr('checked', 'checked');
            }

            $('#inputTrafperModal').val(result.id_traf_per_others_spec_modal);

            if(result.id_traf_per_forc_lab_modal != null){
                $('#id_traf_per_forc_lab_modal').attr('checked', 'checked');
            }
            if(result.id_traf_per_srem_org_modal != null){
                $('#id_traf_per_srem_org_modal').attr('checked', 'checked');
            }
            if(result.id_traf_per_prost_modal != null){
                $('#id_traf_per_prost_modal').attr('checked', 'checked');
            }
            if(result.id_sex_hara_modal != null){
                $('#id_sex_hara_modal').attr('checked', 'checked');
            }
            if(result.id_sex_hara_ver_modal != null){
                $('#id_sex_hara_ver_modal').attr('checked', 'checked');
            }
            if(result.id_sex_hara_others_modal != null){
                $('#sexHaModal').attr('checked', 'checked');
            }

            $('#inputSexHaModal').val(result.id_sex_hara_others_spec_modal);

            if(result.id_sex_hara_phys_modal != null){
                $('#id_sex_hara_phys_modal').attr('checked', 'checked');
            }
            if(result.id_sex_hara_use_obj_modal != null){
                $('#id_sex_hara_use_obj_modal').attr('checked', 'checked');
            }
            if(result.id_chi_abu_modal != null){
                $('#id_chi_abu_modal').attr('checked', 'checked');
            }
            if(result.id_chi_abu_efpaccp_modal != null){
                $('#id_chi_abu_efpaccp_modal').attr('checked', 'checked');
            }
            if(result.id_chi_abu_lasc_cond_modal != null){
                $('#id_chi_abu_lasc_cond_modal').attr('checked', 'checked');
            }
            if(result.id_chi_abu_others_modal != null){
                $('#chiAedModal').attr('checked', 'checked');
            }

            $('#inputchiAedModal').val(result.id_chi_abu_others_spec_modal);

            if(result.id_chi_abu_sex_int_modal != null){
                $('#id_chi_abu_sex_int_modal').attr('checked', 'checked');
            }
            if(result.id_chi_abu_phys_abu_modal != null){
                $('#id_chi_abu_phys_abu_modal').attr('checked', 'checked');
            }

            $('#id_descr_inci_modal').text(result.id_descr_inci_modal);
            $('#id_date_of_inci_modal').val(result.id_date_of_inci_modal);
            $('#id_time_of_inci_modal').val(result.id_time_of_inci_modal);
            $('#inci_det_house_no_modal').val(result.inci_det_house_no_modal);
            $('#inci_det_street_modal').val(result.inci_det_street_modal);
            $('#inci_det_region_modal').empty().html('<option value="'+ result.inci_det_region_modal +'" selected>'+ result.inci_det_region_modal +'</option>');
            $('#inci_det_region_modal_id').val(result.inci_det_region_modal);
            $('#inci_det_province_modal').empty().html('<option value="'+ result.inci_det_province_modal +'" selected>'+ result.inci_det_province_modal +'</option>');
            $('#inci_det_province_modal_id').val(result.inci_det_province_modal);
            $('#inci_det_city_modal').empty().html('<option value="'+ result.inci_det_city_modal +'" selected>'+ result.inci_det_city_modal +'</option>');
            $('#inci_det_city_modal_id').val(result.inci_det_city_modal);
            $('#inci_det_barangay_modal').empty().html('<option value="'+ result.inci_det_barangay_modal +'" selected>'+ result.inci_det_barangay_modal +'</option>');
            $('#inci_det_barangay_modal_id').val(result.inci_det_barangay_modal);
            $('#placeinciModal').empty().html('<option value="'+ result.id_pla_of_inci_modal +'" selected>'+ result.id_pla_of_inci_modal +'</option>');
            $('#inputplaceInciModal').val(result.id_pi_oth_pls_spec_modal);
            $('#id_was_inc_perp_onl_modal').empty().html(`
                <option value="">Please Select</option>
                <option value="Yes"`+ ((result.id_was_inc_perp_onl_modal == 'Yes') ? 'selected' : '') +`>Yes</option>
                <option value="No"`+ ((result.id_was_inc_perp_onl_modal == 'No') ? 'selected' : '') +`>No</option>
            `);

            // Close Sweet Alert after populating the data

            Swal.close();

            if(option == 'Edit'){

                // Removed or set readonly to other input field

                if(result.id_traf_per_others_modal != null){
                    $('#inputTrafperModal').removeAttr('readonly');
                }else{
                    $('#inputTrafperModal').attr('readonly','readonly');
                }

                if(result.id_sex_hara_others_modal != null){
                    $('#inputSexHaModal').removeAttr('readonly');
                }else{
                    $('#inputSexHaModal').attr('readonly','readonly');
                }

                if(result.id_chi_abu_others_modal != null){
                    $('#inputchiAedModal').removeAttr('readonly');
                }else{
                    $('#inputchiAedModal').attr('readonly','readonly');
                }

                if (result.id_pla_of_inci_modal == 'Others') {
                    $('#inputplaceInciModal').removeAttr('readonly');
                }else{
                    $('#inputplaceInciModal').attr('readonly','readonly');
                }

            }

        }
    });
}


// End of editing the additional Incidence Details specific info

// Start of update additional Incidence Details info form using Sweet Alert


function updateAdditionalIncidenceDetailsForm(id){

    Swal.fire({
        title: 'Do you want to save the changes?',
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'Save',
        denyButtonText: `Don't save`,
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                type: "POST",
                url: rootURL + 'api/v1/incidence-detail-infos/update/'+ id,
                data: $("#addIncidenceDetailInfos").serialize(),
                success: function(response) {

                    if (response === 'Updating Incidence Details Info Success'){
                        Swal.fire({
                            icon:'success',
                            title: 'Saved!',
                            html: `<center>Updating Incidence Details Info Success.</center>`
                        });
                        closeAdditionalIncidenceDetailsForm();
                        $('#modalIncidenceDetails').modal('toggle');
                        $('#addIncidenceDetailInfos').trigger("reset");
                        $('#add-incidence-details-error-form').empty();
                    }
                    else if (response === 'Case already closed editing was disabled'){
                        Swal.fire({
                            icon:'error',
                            title: 'Error!',
                            html: `<center>Case already closed editing was disabled.</center>`
                        });
                        closeAdditionalIncidenceDetailsForm();
                        $('#modalIncidenceDetails').modal('toggle');
                        $('#addIncidenceDetailInfos').trigger("reset");
                        $('#add-incidence-details-error-form').empty();
                    }
                    else if (response === `Sorry you don't have the rights to update this case please contact the administrator`){
                        Swal.fire({
                            icon:'error',
                            title: 'Error!',
                            html: `<center>Sorry you don't have the rights to update this case please contact the administrator.</center>`
                        });
                        closeAdditionalIncidenceDetailsForm();
                        $('#modalIncidenceDetails').modal('toggle');
                        $('#addIncidenceDetailInfos').trigger("reset");
                        $('#add-incidence-details-error-form').empty();
                    }
                    else{

                        Swal.fire('The Incidence Details info was not updated!', '', 'error');

                        html = "";
                        $.each(response, function( index, value ) {
                            html += '<p class="d-flex justify-content-center text-danger">'+ value +'</p>';
                        });
                        html += '<hr>';

                        $('#add-incidence-details-error-form').empty().prepend(html);
                    }
                }
            });
        } else if (result.isDenied) {

            Swal.fire('Changes are not saved', '', 'info')
        }
    });

}


// End of update additional Incidence Details info form using Sweet Alert

// Start of deleting additional Incidence Details info Sweet Alert modal


    function deleteSpecificAdditionalIncidenceDetailsModal(id){
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: rootURL + 'api/v1/incidence-detail-infos/delete/' + id,
                    data: {
                        _method: 'delete',
                    },
                    success: function(response) {

                        if (response === 'The Incidence Details Info was successfully deleted'){
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                html: '<center>The Incidence Details Info was successfully deleted.</center>'
                            });
                            closeAdditionalIncidenceDetailsForm();
                        }
                        else if (response === `Sorry you don't have the rights to delete case record please contact the administrator`){
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                html: `<center>Sorry you don't have the rights to delete case record please contact the administrator.</center>`
                            });
                            closeAdditionalIncidenceDetailsForm();
                        }
                        else if (response === 'Case already closed delete was disabled'){
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                html: `<center>Case already closed delete was disabled.</center>`
                            });
                            closeAdditionalIncidenceDetailsForm();
                        }
                        else{
                            Swal.fire('The Incidence Details Info was not deleted!', '', 'error');
                        }
                    }
                });

            }else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }
        });
    }


// End of deleting additional Incidence Details info Sweet Alert modal

// Start of submit additional Perpetrator Details info form using Sweet Alert


function submitAdditionalPerpetratorDetailsForm(){

    Swal.fire({
        title: 'Do you want to save the changes?',
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'Save',
        denyButtonText: `Don't save`,
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                type: "POST",
                url: rootURL + 'api/v1/perpetrator-detail-infos/add',
                data: $("#addPerpetratorDetailInfos").serialize(),
                success: function(response) {

                    if (response === `Creating Perpetrator Details Info Success`){
                        Swal.fire({
                            icon: 'success',
                            title: 'Saved!',
                            html: `<center>Creating Perpetrator Details Info Success.</center>`
                        });
                        closeAdditionalPerpetratorDetailsForm();
                        $('#modalPerpetratorDetailInfos').modal('toggle');
                        $('#addPerpetratorDetailInfos').trigger("reset");
                        $('#add-perpetrator-details-error-form').empty();
                    }
                    else if (response === `Sorry you don't have the rights to add record please contact the administrator`){
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            html: `<center>Sorry you don't have the rights to add record please contact the administrator.</center>`
                        });
                        closeAdditionalPerpetratorDetailsForm();
                        $('#modalPerpetratorDetailInfos').modal('toggle');
                        $('#addPerpetratorDetailInfos').trigger("reset");
                        $('#add-perpetrator-details-error-form').empty();
                    }
                    else if (response === `Case already closed add record was disabled`){
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            html: `<center>Case already closed add record was disabled.</center>`
                        });
                        closeAdditionalPerpetratorDetailsForm();
                        $('#modalPerpetratorDetailInfos').modal('toggle');
                        $('#addPerpetratorDetailInfos').trigger("reset");
                        $('#add-perpetrator-details-error-form').empty();
                    }
                    else{

                        Swal.fire('The Perpetrator Details info was not created!', '', 'error');

                        html = "";
                        $.each(response, function( index, value ) {
                            html += '<p class="d-flex justify-content-center text-danger">'+ value +'</p>';
                        });
                        html += '<hr>';

                        $('#add-perpetrator-details-error-form').empty().prepend(html);
                    }
                }
            });
        } else if (result.isDenied) {

            Swal.fire('Changes are not saved', '', 'info')
        }
    });

}


// End of submit additional Perpetrator Details info form using Sweet Alert

// Start of getting the additional Perpetrator Details info


function closeAdditionalPerpetratorDetailsForm(){

    $.ajax({
        url: rootURL + 'api/v1/perpetrator-detail-infos/get/' + $('#case_no').val(),
        success: function (result) {

            // Empty Additional Perpetrator Details Table
            $("#perp_det_table_tbody").empty();

            result.dataPerpet.forEach(element => {
                $('#perp_det_table_tbody').append('<tr>'+
                '<td>'+
                    '<a href="javascript:void(0)" class="text-orange-icon" data-bs-toggle="modal" data-bs-target="#modalPerpetratorDetailInfos" onclick="getSpecificAdditionalPerpetratorDetailsForm('+ element['id'] +', `View`)"><i class="fa fa-eye"></i></a>'+
                    ((result.master_list_rights_delete == true) ? '<a href="javascript:void(0)" class="text-orange-icon" onclick="deleteSpecificAdditionalPerpetratorDetailsModal('+ element['id'] +')"><i class="fa fa-trash"></i></a>' : '') +
                '</td>'+
                '<td>'+ ((element['perp_d_last_name_modal'] == null) ? '-' : element['perp_d_last_name_modal']) +'</td>'+
                '<td>'+ ((element['perp_d_middle_name_modal'] == null) ? '-' : element['perp_d_middle_name_modal']) +'</td>'+
                '<td>'+ ((element['perp_d_first_name_modal'] == null) ? '-' : element['perp_d_first_name_modal']) +'</td>'+
                '<td>'+ ((element['perp_d_age_modal'] == null) ? '-' : element['perp_d_age_modal']) +'</td>'+
                '<td>'+ ((element['perp_d_rel_victim_modal'] == null) ? '-' : element['perp_d_rel_victim_modal']) +'</td>'+
                '</tr>');
            });
        }
    });

    // Unhide Save Button
    $('#perp_det_modal_save').removeAttr('hidden');

    // Removed disabled and readonly in input, radio button, and select option
    $('#addPerpetratorDetailInfos * input').removeAttr('readonly');
    $('#addPerpetratorDetailInfos * select').removeAttr('disabled');
    $('#addPerpetratorDetailInfos * [type="radio"]').removeAttr('disabled');
    $('#addPerpetratorDetailInfos * textarea').removeAttr('readonly');

    // Set Others input field to readonly
    $('#inputrelvicsurModal').attr('readonly','readonly');
    $('#nainputrelvicsurModal').attr('readonly','readonly');
    $('#reinputrelvicsurModal').attr('readonly','readonly');
    $('#perp_d_if_yes_pls_ind_modal').attr('readonly','readonly');
    $('#garinputrelvicsurModal').attr('readonly','readonly');

    // Reset Relationship to the Victim-Survivor dropdown list

    $.ajax({
        url: rootURL + 'api/v1/case/get-relationship-to-victim-survivors-list',
        success: function (result) {

            // Empty Dropdown List
            $("#relvicsurModal").empty();

            $('#relvicsurModal').prepend('<option value="">Please Select</option>');

            result.forEach(element => {
                $('#relvicsurModal').append('<option value="'+ element['item_name'] +'">'+ element['item_name'] +'</option>');
            });

            $('#relvicsurModal').append('<option value="Other Relatives, Specify:">Other Relatives, Specify:</option>');
        }
    });

     // Reset Religion list

     $.ajax({
        url: rootURL + 'api/v1/case/get-religions-list',
        success: function (result) {

            // Empty Dropdown List
            $("#rerelvicsurModal").empty();

            $('#rerelvicsurModal').prepend('<option value="">Please Select</option>');

            result.forEach(element => {
                $('#rerelvicsurModal').append('<option value="'+ element['item_name'] +'">'+ element['item_name'] +'</option>');
            });

            $('#rerelvicsurModal').append('<option value="Others">Others</option>');
        }
    });

    // Reset address field and removed onclick changeAddress() function

    $('#perp_d_region_modal').empty().prop('onclick', null);
    $('#perp_d_province_modal').empty().prop('onclick', null);
    $('#perp_d_city_modal').empty().prop('onclick', null);
    $('#perp_d_barangay_modal').empty().prop('onclick', null);

    $('#perp_d_region_modal').append('<option value="">Please Select</option>');

    // Reset Automated Dropdowns Location

    $('#perp_d_region_modal').ph_locations('fetch_list');

    // Remove Relationship to the Victim-Survivor: onclick attribute changeRelationshipToTheVictimSurvivor() function
    $('#relvicsurModal').attr('onclick','');

    // Remove Religion onclick attribute changeReligion() function
    $('#rerelvicsurModal').attr('onclick','');

    // Reset form
    $('#addPerpetratorDetailInfos').trigger("reset");
    $('#addPerpetratorDetailInfos * [type="radio"]').removeAttr('checked');
    $('#perp_d_educ_att_modal option').removeAttr('selected');
    $('#narelvicsurModal option').removeAttr('selected');
    $('#garrelvicsurModal option').removeAttr('selected');
    $('#perp_d_oth_info_perp_modal').text('');
    $('#addPerpetratorDetailInfos').attr('onsubmit','submitAdditionalPerpetratorDetailsForm()');
}


// End of getting the additional Perpetrator Details info

// Start of editing the additional Perpetrator Details specific info


function getSpecificAdditionalPerpetratorDetailsForm(id, option){

    // Open Sweet alert for waiting time to the populate data

    Swal.fire({
        icon: 'info',
        title: 'Populating data...',
        showConfirmButton: true,
    })

    if(option == 'View'){

        // Hide Save Button
        $('#perp_det_modal_save').attr('hidden','hidden');

        // Set input, radio button, and select option to disabled and readonly
        $('#addPerpetratorDetailInfos * input').attr('readonly','readonly');
        $('#addPerpetratorDetailInfos * select').attr('disabled','disabled');
        $('#addPerpetratorDetailInfos * [type="radio"]').attr('disabled','disabled');
        $('#addPerpetratorDetailInfos * textarea').attr('readonly','readonly');

    }

    // Uncomment if edit will be enable

    // else if(option == 'Edit'){

    //     // Set Modal form tag onsubmit attribute to update function
    //     $('#addPerpetratorDetailInfos').attr('onsubmit','updateAdditionalPerpetratorDetailsForm('+ id +')');

    //     // Set Relationship to the Victim-Survivor: onclick attribute to changeRelationshipToTheVictimSurvivor() function
    //     $('#relvicsurModal').attr('onclick','changeRelationshipToTheVictimSurvivor("relvicsurModal")');

    //     // Set Religion onclick attribute to changeReligion() function
    //     $('#rerelvicsurModal').attr('onclick','changeReligion("rerelvicsurModal")');

    //     // Set address field onclick attribute to changeAddress() function
    //     $('#perp_d_region_modal').empty().attr('onclick', 'changeAddress("perp_d_region_modal", "perp_d_province_modal", "perp_d_city_modal", "perp_d_barangay_modal")');
    //     $('#perp_d_province_modal').empty().attr('onclick', 'changeAddress("perp_d_region_modal", "perp_d_province_modal", "perp_d_city_modal", "perp_d_barangay_modal")');
    //     $('#perp_d_city_modal').empty().attr('onclick', 'changeAddress("perp_d_region_modal", "perp_d_province_modal", "perp_d_city_modal", "perp_d_barangay_modal")');
    //     $('#perp_d_barangay_modal').empty().attr('onclick', 'changeAddress("perp_d_region_modal", "perp_d_province_modal", "perp_d_city_modal", "perp_d_barangay_modal")');

    // }

    $.ajax({
        url: rootURL + 'api/v1/perpetrator-detail-infos/get-specific-additional-record/' + id,
        success: function (result) {

            // Populate result to Perpetrator Details add record Modal

            $('#perp_d_last_name_modal').val(result.perp_d_last_name_modal);
            $('#perp_d_first_name_modal').val(result.perp_d_first_name_modal);
            $('#perp_d_middle_name_modal').val(result.perp_d_middle_name_modal);
            $('#perp_d_extension_name_modal').val(result.perp_d_extension_name_modal);
            $('#perp_d_alias_name_modal').val(result.perp_d_alias_name_modal);

            if(result.perp_d_sex_radio_modal == 'Male'){
                $('#perp_d_sex_male_radio_modal').attr('checked', 'checked');
            }
            if(result.perp_d_sex_radio_modal == 'Female'){
                $('#perp_d_sex_female_radio_modal').attr('checked', 'checked');
            }

            $('#perp_d_birthdate_modal').val(result.perp_d_birthdate_modal);
            $('#perp_d_age_modal').val(result.perp_d_age_modal);
            $('#relvicsurModal').empty().html('<option value="'+ result.perp_d_rel_victim_modal +'" selected>'+ result.perp_d_rel_victim_modal +'</option>');
            $('#inputrelvicsurModal').val(result.perp_d_rel_vic_pls_spec_modal);
            $('#perp_d_occup_modal').val(result.perp_d_occup_modal);
            $('#perp_d_educ_att_modal').val(result.perp_d_educ_att_modal);

            $('#perp_d_educ_att_modal').empty().html(`
                <option value="">Please Select</option>
                <option value="No Formal Education"`+ ((result.perp_d_educ_att_modal == 'No Formal Education') ? 'selected' : '') +`>No Formal Education</option>
                <option value="Elementary Level/Graduate"`+ ((result.perp_d_educ_att_modal == 'Elementary Level/Graduate') ? 'selected' : '') +`>Elementary Level/Graduate</option>
                <option value="Junior High School Level/Graduate"`+ ((result.perp_d_educ_att_modal == 'Junior High School Level/Graduate') ? 'selected' : '') +`>Junior High School Level/Graduate</option>
                <option value="Senior High School Level/Graduate"`+ ((result.perp_d_educ_att_modal == 'Senior High School Level/Graduate') ? 'selected' : '') +`>Senior High School Level/Graduate</option>
                <option value="Technical/Vocational"`+ ((result.perp_d_educ_att_modal == 'Technical/Vocational') ? 'selected' : '') +`>Technical/Vocational</option>
                <option value="College Level/Graduate"`+ ((result.perp_d_educ_att_modal == 'College Level/Graduate') ? 'selected' : '') +`>College Level/Graduate</option>
                <option value="Post Graduate"`+ ((result.perp_d_educ_att_modal == 'Post Graduate') ? 'selected' : '') +`>Post Graduate</option>
            `);

            $('#narelvicsurModal').empty().html(`
                <option value="">Please Select</option>
                <option value="Filipino"`+ ((result.perp_d_nationality_modal == 'Filipino') ? 'selected' : '') +`>Filipino</option>
                <option value="Others"`+ ((result.perp_d_nationality_modal == 'Others') ? 'selected' : '') +`>Others</option>
            `);

            $('#nainputrelvicsurModal').val(result.perp_d_nat_if_oth_pls_spec_modal);
            $('#rerelvicsurModal').empty().html('<option value="'+ result.perp_d_religion_modal +'" selected>'+ result.perp_d_religion_modal +'</option>');
            $('#reinputrelvicsurModal').val(result.perp_d_rel_if_oth_pls_spec_modal);
            $('#perp_d_house_no_modal').val(result.perp_d_house_no_modal);
            $('#perp_d_street_modal').val(result.perp_d_street_modal);
            $('#perp_d_region_modal').empty().html('<option value="'+ result.perp_d_region_modal +'" selected>'+ result.perp_d_region_modal +'</option>');
            $('#perp_d_region_modal_id').val(result.perp_d_region_modal);
            $('#perp_d_province_modal').empty().html('<option value="'+ result.perp_d_province_modal +'" selected>'+ result.perp_d_province_modal +'</option>');
            $('#perp_d_province_modal_id').val(result.perp_d_province_modal);
            $('#perp_d_city_modal').empty().html('<option value="'+ result.perp_d_city_modal +'" selected>'+ result.perp_d_city_modal +'</option>');
            $('#perp_d_city_modal_id').val(result.perp_d_city_modal);
            $('#perp_d_barangay_modal').empty().html('<option value="'+ result.perp_d_barangay_modal +'" selected>'+ result.perp_d_barangay_modal +'</option>');
            $('#perp_d_barangay_modal_id').val(result.perp_d_barangay_modal);
            $('#perp_d_curr_loc_modal').val(result.perp_d_curr_loc_modal);

            if(result.perp_d_is_perp_minor_modal == 'Yes'){
                $('#perp_d_is_pm_yes_radio_modal').attr('checked', 'checked');
            }
            if(result.perp_d_is_perp_minor_modal == 'No'){
                $('#perp_d_is_pm_no_radio_modal').attr('checked', 'checked');
            }

            $('#perp_d_if_yes_pls_ind_modal').val(result.perp_d_if_yes_pls_ind_modal);
            $('#perp_d_addr_par_gua_modal').val(result.perp_d_addr_par_gua_modal);
            $('#perp_d_cont_par_gua_modal').val(result.perp_d_cont_par_gua_modal);

            $('#garrelvicsurModal').empty().html(`
                <option value="">Please Select</option>
                <option value="Father"`+ ((result.perp_d_rel_guar_perp_modal == 'Father') ? 'selected' : '') +`>Father</option>
                <option value="Mother"`+ ((result.perp_d_rel_guar_perp_modal == 'Mother') ? 'selected' : '') +`>Mother</option>
                <option value="Others"`+ ((result.perp_d_rel_guar_perp_modal == 'Others') ? 'selected' : '') +`>Others</option>
            `);

            $('#garinputrelvicsurModal').val(result.perp_d_rel_rgp_pls_spec_modal);
            $('#perp_d_oth_info_perp_modal').text(result.perp_d_oth_info_perp_modal);

            // Close Sweet Alert after populating the data

            Swal.close();

            // Uncomment if edit will be enable

            // if(option == 'Edit'){

            //     // Removed or set readonly to other input field

            //     if ((result.perp_d_rel_victim_modal == 'Other Relatives, Specify:') || (result.perp_d_rel_victim_modal == 'Immediate Family Members, Specify:') || (result.perp_d_rel_victim_modal == 'Stepfamily Members, Specify:')) {
            //         $('#inputrelvicsurModal').removeAttr('readonly');
            //     }else{
            //         $('#inputrelvicsurModal').attr('readonly','readonly');
            //     }

            //     if (result.perp_d_nationality_modal == 'Others') {
            //         $('#nainputrelvicsurModal').removeAttr('readonly');
            //     }else{
            //         $('#nainputrelvicsurModal').attr('readonly','readonly');
            //     }

            //     if (result.perp_d_religion_modal == 'Others') {
            //         $('#reinputrelvicsurModal').removeAttr('readonly');
            //     }else{
            //         $('#reinputrelvicsurModal').attr('readonly','readonly');
            //     }

            //     if(result.perp_d_is_perp_minor_modal == 'Yes'){
            //         $('#perp_d_if_yes_pls_ind_modal').removeAttr('readonly');
            //     }else{
            //         $('#perp_d_if_yes_pls_ind_modal').attr('readonly','readonly');
            //     }

            //     if (result.perp_d_rel_guar_perp_modal == 'Others') {
            //         $('#garinputrelvicsurModal').removeAttr('readonly');
            //     }else{
            //         $('#garinputrelvicsurModal').attr('readonly','readonly');
            //     }

            // }

        }
    });
}


// End of editing the additional Perpetrator Details specific info

// Start of update additional Perpetrator Details info form using Sweet Alert


function updateAdditionalPerpetratorDetailsForm(id){

    Swal.fire({
        title: 'Do you want to save the changes?',
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'Save',
        denyButtonText: `Don't save`,
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                type: "POST",
                url: rootURL + 'api/v1/perpetrator-detail-infos/update/'+ id,
                data: $("#addPerpetratorDetailInfos").serialize(),
                success: function(response) {

                    if (response === 'Updating Perpetrator Details Info Success'){
                        Swal.fire({
                            icon: 'success',
                            title: 'Saved!',
                            html: `<center>Updating Perpetrator Details Info Success.</center>`
                        });
                        closeAdditionalPerpetratorDetailsForm();
                        $('#modalPerpetratorDetailInfos').modal('toggle');
                        $('#addPerpetratorDetailInfos').trigger("reset");
                        $('#add-perpetrator-details-error-form').empty();
                    }
                    else if (response === 'Case already closed editing was disabled'){
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            html: `<center>Case already closed editing was disabled.</center>`
                        });
                        closeAdditionalPerpetratorDetailsForm();
                        $('#modalPerpetratorDetailInfos').modal('toggle');
                        $('#addPerpetratorDetailInfos').trigger("reset");
                        $('#add-perpetrator-details-error-form').empty();
                    }
                    else if (response === `Sorry you don't have the rights to update this case please contact the administrator`){
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            html: `<center>Sorry you don't have the rights to update this case please contact the administrator.</center>`
                        });
                        closeAdditionalPerpetratorDetailsForm();
                        $('#modalPerpetratorDetailInfos').modal('toggle');
                        $('#addPerpetratorDetailInfos').trigger("reset");
                        $('#add-perpetrator-details-error-form').empty();
                    }
                    else{

                        Swal.fire('The Perpetrator Details info was not updated!', '', 'error');

                        html = "";
                        $.each(response, function( index, value ) {
                            html += '<p class="d-flex justify-content-center text-danger">'+ value +'</p>';
                        });
                        html += '<hr>';

                        $('#add-perpetrator-details-error-form').empty().prepend(html);
                    }
                }
            });
        } else if (result.isDenied) {

            Swal.fire('Changes are not saved', '', 'info')
        }
    });

}


// End of update additional Perpetrator Details info form using Sweet Alert

// Start of deleting additional Perpetrator Details info Sweet Alert modal


    function deleteSpecificAdditionalPerpetratorDetailsModal(id){
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: rootURL + 'api/v1/perpetrator-detail-infos/delete/' + id,
                    data: {
                        _method: 'delete',
                    },
                    success: function(response) {

                        if (response === 'The Perpetrator Details Info was successfully deleted'){
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                html: `<center>The Perpetrator Details Info was successfully deleted.</center>`
                            });
                            closeAdditionalPerpetratorDetailsForm();
                        }
                        else if (response === `Sorry you don't have the rights to delete case record please contact the administrator`){
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                html: `<center>Sorry you don't have the rights to delete case record please contact the administrator.</center>`
                            });
                            closeAdditionalPerpetratorDetailsForm();
                        }
                        else if (response === 'Case already closed delete was disabled'){
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                html: `<center>Case already closed delete was disabled.</center>`
                            });
                            closeAdditionalPerpetratorDetailsForm();
                        }
                        else{
                            Swal.fire('The Perpetrator Details Info was not deleted!', '', 'error');
                        }
                    }
                });

            }else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }
        });
    }


// End of deleting additional Perpetrator Details info Sweet Alert modal

// Start of change additional Perpetrator Details info Relationship to the Victim-Survivor confirmation using Sweet Alert


function changePerpetratorDetailsRelationshipToTheVictimSurvivor(){

    Swal.fire({
        title: 'Do you want to change the Relationship to the Victim-Survivor?',
        html: "<center>Existing Relationship to the Victim-Survivor will be reset!</center>",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: rootURL + 'api/v1/case/get-relationship-to-victim-survivors-list',
                success: function (result) {

                    // Remove Relationship to the Victim-Survivor: onclick attribute changePerpetratorDetailsRelationshipToTheVictimSurvivor() function
                    $('#relvicsurModal').prop('onclick', null);

                    // Empty Dropdown List
                    $("#relvicsurModal").empty();

                    $('#relvicsurModal').prepend('<option value="">Please Select</option>');

                    result.forEach(element => {
                        $('#relvicsurModal').append('<option value="'+ element['item_name'] +'">'+ element['item_name'] +'</option>');
                    });

                    $('#relvicsurModal').append('<option value="Other Relatives, Specify:">Other Relatives, Specify:</option>');
                }
            });
        }
    });
}


// End of change additional Perpetrator Details info Relationship to the Victim-Survivor confirmation using Sweet Alert

// Start of submit additional Intervention Module info form using Sweet Alert


function submitAdditionalInterventionModuleForm(){

    Swal.fire({
        title: 'Do you want to save the changes?',
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'Save',
        denyButtonText: `Don't save`,
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                type: "POST",
                url: rootURL + 'api/v1/intervention-module-infos/add',
                data: $("#addInterventionModulenfos").serialize(),
                success: function(response) {

                    if (response === `Creating Intervention Module Info Success`){
                        Swal.fire({
                            icon: 'success',
                            title: 'Saved!',
                            html: `<center>Creating Intervention Module Info Success.</center>`
                        });
                        closeAdditionalInterventionModuleForm();
                        $('#modalInterventionModuleInfos').modal('toggle');
                        $('#addInterventionModulenfos').trigger("reset");
                        $('#add-intervention-module-error-form').empty();
                    }
                    else if (response === `Sorry you don't have the rights to add record please contact the administrator`){
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            html: `<center>Sorry you don't have the rights to add record please contact the administrator.</center>`
                        });
                        closeAdditionalInterventionModuleForm();
                        $('#modalInterventionModuleInfos').modal('toggle');
                        $('#addInterventionModulenfos').trigger("reset");
                        $('#add-intervention-module-error-form').empty();
                    }
                    else if (response === `Case already closed add record was disabled`){
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            html: `<center>Case already closed add record was disabled.</center>`
                        });
                        closeAdditionalInterventionModuleForm();
                        $('#modalInterventionModuleInfos').modal('toggle');
                        $('#addInterventionModulenfos').trigger("reset");
                        $('#add-intervention-module-error-form').empty();
                    }
                    else{

                        Swal.fire('The Intervention Module info was not created!', '', 'error');

                        html = "";
                        $.each(response, function( index, value ) {
                            html += '<p class="d-flex justify-content-center text-danger">'+ value +'</p>';
                        });
                        html += '<hr>';

                        $('#add-intervention-module-error-form').empty().prepend(html);
                    }
                }
            });
        } else if (result.isDenied) {

            Swal.fire('Changes are not saved', '', 'info')
        }
    });

}


// End of submit additional Intervention Module info form using Sweet Alert

// Start of getting the additional Intervention Module info


function closeAdditionalInterventionModuleForm(){

    $.ajax({
        url: rootURL + 'api/v1/intervention-module-infos/get/' + $('#case_no').val(),
        success: function (result) {

            // Empty Recommendation Intervention Program Plan Table
            $("#inter_mod_table_tbody").empty();

            result.dataInter.forEach(element => {
                $('#inter_mod_table_tbody').append('<tr>'+
                '<td>'+
                    ((result.master_list_rights_revise == true) ? '<a href="javascript:void(0)" class="text-orange-icon" data-bs-toggle="modal" data-bs-target="#modalInterventionModuleInfos" onclick="getSpecificAdditionalInterventionModuleForm('+ element['id'] +', `Edit`)"><i class="fa fa-edit"></i></a>' : '') +
                    '<a href="javascript:void(0)" class="text-orange-icon" data-bs-toggle="modal" data-bs-target="#modalInterventionModuleInfos" onclick="getSpecificAdditionalInterventionModuleForm('+ element['id'] +', `View`)"><i class="fa fa-eye"></i></a>'+
                    ((result.master_list_rights_delete == true) ? '<a href="javascript:void(0)" class="text-orange-icon" onclick="deleteSpecificAdditionalInterventionModuleModal('+ element['id'] +')"><i class="fa fa-trash"></i></a>' : '') +
                '</td>'+
                '<td>'+ ((element['im_speci_obje_modal'] == null) ? '-' : element['im_speci_obje_modal']) +'</td>'+
                '<td>'+ ((element['im_type_of_service_modal'] == null) ? '-' : element['im_type_of_service_modal']) +'</td>'+
                '<td>'+ ((element['im_speci_interv_modal'] == null) ? '-' : element['im_speci_interv_modal'] ) +'</td>'+
                '<td>'+ ((element['im_target_date_modal'] == null) ? '-' : element['im_target_date_modal']) +'</td>'+
                '<td>'+ ((element['im_if_status_com_pd_modal'] == null) ? '-' : element['im_if_status_com_pd_modal'] ) +'</td>'+
                '<td>'+ ((element['im_serv_prov_modal'] == null) ? '-' : element['im_serv_prov_modal']) +'</td>'+
                '</tr>');
            });
        }
    });

    // Reset Service Provider: dropdown list

    $.ajax({
        url: rootURL + 'api/v1/case/get-service-provider-list',
        success: function (result) {

            // Empty Dropdown List
            $("#serviceproviderModal").empty();

            $('#serviceproviderModal').prepend('<option value="">Please Select</option>');

            result.forEach(element => {
                $('#serviceproviderModal').append('<option value="'+ element['name'] +'">'+ element['name'] +'</option>');
            });

            $('#serviceproviderModal').append('<option value="Others">Others</option>');
        }
    });

    // Remove onclick, readonly and disabled in input, and select option that was disable editing
    $('#im_type_of_service_modal').removeAttr('disabled');
    $('#inputtypeofServiceModal').removeAttr('readonly');
    $('#im_speci_interv_modal').removeAttr('disabled');
    $('#inputspeIntModal').removeAttr('readonly');
    $('#serviceproviderModal').removeAttr('disabled');
    $('#inputserviceproviderModal').removeAttr('readonly');
    $('#im_speci_obje_modal').removeAttr('readonly');
    $('#im_target_date_modal').removeAttr('readonly');
    $('#im_dsp_full_name_modal').removeAttr('onclick');
    $('#im_dsp_post_desi_modal').removeAttr('onclick');
    $('#im_dsp_email_modal').removeAttr('onclick');
    $('#im_dsp_contact_no_1_modal').removeAttr('onclick');
    $('#im_dsp_contact_no_2_modal').removeAttr('onclick');
    $('#im_dsp_contact_no_3_modal').removeAttr('onclick');
    $('#im_dasp_full_name_modal').removeAttr('onclick');
    $('#im_dasp_post_desi_modal').removeAttr('onclick');
    $('#im_dasp_email_modal').removeAttr('onclick');
    $('#im_dasp_contact_no_1_modal').removeAttr('onclick');
    $('#im_dasp_contact_no_2_modal').removeAttr('onclick');
    $('#im_dasp_contact_no_3_modal').removeAttr('onclick');

    // Unhide Save Button
    $('#inter_mod_modal_save').removeAttr('hidden');

    // Removed disabled and readonly in input, textarea and select option
    $('#addInterventionModulenfos * input').removeAttr('readonly');
    $('#addInterventionModulenfos * select').removeAttr('disabled');
    $('#addInterventionModulenfos * textarea').removeAttr('readonly');

    // Start of Reset Type of Service and Specific Interventions

    // Empty Type of Service/Specific Interventions dropdown list

    $('#im_type_of_service_modal').empty();
    $('#im_speci_interv_modal').empty();

    // Add Please Select Option

    $('#im_type_of_service_modal').prepend('<option value="">Please Select</option>');
    $('#im_speci_interv_modal').prepend('<option value="">Please Select</option>');

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


    var im_type_of_serviceSel = document.getElementById('im_type_of_service_modal');
    var im_speci_intervSel = document.getElementById('im_speci_interv_modal');
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

    // End of Reset Type of Service and Specific Interventions

    // Remove Service Provider: onclick attribute changeServiceProvider() function
    $('#serviceproviderModal').attr('onclick','');

    // Remove Type of Service/Specific Interventions onclick attribute changeTypeOfServiceAndSpecificInterventions() function
    $('#im_type_of_service_modal').attr('onclick','');
    $('#im_speci_interv_modal').attr('onclick','');

    // Set Other input field to readonly
    $('#inputtypeofServiceModal').attr('readonly','readonly');
    $('#inputspeIntModal').attr('readonly','readonly');
    $('#inputserviceproviderModal').attr('readonly','readonly');

    // Reset form
    $('#addInterventionModulenfos').trigger("reset");
    $('#addInterventionModulenfos * textarea').text('');
    $('#im_dsp_full_name_modal').empty();
    $('#im_dsp_full_name_modal').val('');
    $('#im_dsp_full_name_modal_id').val('');
    $('#im_dasp_full_name_modal').empty();
    $('#im_dasp_full_name_modal').val('');
    $('#im_dasp_full_name_modal_id').val('');
    $('#addInterventionModulenfos').attr('onsubmit','submitAdditionalInterventionModuleForm()');
}


// End of getting the additional Intervention Module info

// Start of editing the additional Intervention Module specific info


function getSpecificAdditionalInterventionModuleForm(id, option){

    // Open Sweet alert for waiting time to the populate data

    Swal.fire({
        icon: 'info',
        title: 'Populating data...',
        showConfirmButton: true,
    })

    if(option == 'View'){

        // Hide Save Button
        $('#inter_mod_modal_save').attr('hidden','hidden');

        // Set input, textarea and select option to disabled and readonly
        $('#addInterventionModulenfos * input').attr('readonly','readonly');
        $('#addInterventionModulenfos * select').attr('disabled','disabled');
        $('#addInterventionModulenfos * textarea').attr('readonly','readonly');

    }

    else if(option == 'Edit'){

        // Set Modal form tag onsubmit attribute to update function
        $('#addInterventionModulenfos').attr('onsubmit','updateAdditionalInterventionModuleForm('+ id +')');

        // Uncomment if edit was enable

        // // Set Type of Service/Specific Interventions onclick attribute to changeTypeOfServiceAndSpecificInterventions() function
        // $('#im_type_of_service_modal').attr('onclick','changeTypeOfServiceAndSpecificInterventions("im_type_of_service_modal", "im_speci_interv_modal")');
        // $('#im_speci_interv_modal').attr('onclick','changeTypeOfServiceAndSpecificInterventions("im_type_of_service_modal", "im_speci_interv_modal")');

        // // Set Service Provider: onclick attribute to changeServiceProvider() function
        // $('#serviceproviderModal').attr('onclick','changeServiceProvider("serviceproviderModal")');

    }

    $.ajax({
        url: rootURL + 'api/v1/intervention-module-infos/get-specific-additional-record/' + id,
        success: function (result) {

            // Populate result to Intervention Module add record Modal

            $('#im_type_of_service_modal').empty().html(`<option value="`+ result.im_type_of_service_modal +`" selected>`+ result.im_type_of_service_modal +`</option>`);
            $('#inputtypeofServiceModal').val(result.im_typ_serv_if_oth_spec_modal);
            $('#im_speci_interv_modal').empty().html(`
                <option value="">Please Select</option>
                <option value="`+ result.im_speci_interv_modal +`" selected>`+ result.im_speci_interv_modal +`</option>
            `);
            $('#inputspeIntModal').val(result.im_spe_int_if_oth_spec_modal);
            $('#serviceproviderModal [value="'+ result.im_serv_prov_modal +'"]').prop('selected','selected');
            $('#serviceproviderModal').empty().html(`<option value="`+ result.im_serv_prov_modal +`" selected>`+ result.im_serv_prov_modal +`</option>`);
            $('#inputserviceproviderModal').val(result.im_ser_pro_if_oth_spec_modal);
            $('#im_speci_obje_modal').text(result.im_speci_obje_modal);
            $('#im_target_date_modal').val(result.im_target_date_modal);
            $('#im_status_modal [value="'+ result.im_status_modal +'"]').prop('selected','selected');
            $('#im_if_status_com_pd_modal').val(result.im_if_status_com_pd_modal);
            $('#im_dsp_full_name_modal').empty().html(`<option value="`+ result.im_dsp_full_name_modal +`" selected>`+ result.im_dsp_full_name_modal +`</option>`);
            $('#im_dsp_full_name_modal').val(result.im_dsp_full_name_modal);
            $('#im_dsp_full_name_modal_id').val(result.im_dsp_full_name_modal);
            $('#im_dsp_post_desi_modal').val(result.im_dsp_post_desi_modal);
            $('#im_dsp_email_modal').val(result.im_dsp_email_modal);
            $('#im_dsp_contact_no_1_modal').val(result.im_dsp_contact_no_1_modal);
            $('#im_dsp_contact_no_2_modal').val(result.im_dsp_contact_no_2_modal);
            $('#im_dsp_contact_no_3_modal').val(result.im_dsp_contact_no_3_modal);
            $('#im_dasp_full_name_modal').empty().html(`<option value="`+ result.im_dasp_full_name_modal +`" selected>`+ result.im_dasp_full_name_modal +`</option>`);
            $('#im_dasp_full_name_modal').val(result.im_dasp_full_name_modal);
            $('#im_dasp_full_name_modal_id').val(result.im_dasp_full_name_modal);
            $('#im_dasp_post_desi_modal').val(result.im_dasp_post_desi_modal);
            $('#im_dasp_email_modal').val(result.im_dasp_email_modal);
            $('#im_dasp_contact_no_1_modal').val(result.im_dasp_contact_no_1_modal);
            $('#im_dasp_contact_no_2_modal').val(result.im_dasp_contact_no_2_modal);
            $('#im_dasp_contact_no_3_modal').val(result.im_dasp_contact_no_3_modal);
            $('#im_summary_modal').text(result.im_summary_modal);

            // Close Sweet Alert after populating the data

            Swal.close();

            if(option == 'Edit'){

                // Uncomment if edit was enable

                // // Removed or set readonly to other input field

                // ((result.im_type_of_service_modal == 'Others') ? $('#inputtypeofServiceModal').removeAttr('readonly') : $('#inputtypeofServiceModal').attr('readonly','readonly'));
                // if (result.im_speci_interv_modal == 'E. Others') {

                //     $('#inputspeIntModal').removeAttr('readonly');
                // }
                // else if (result.im_speci_interv_modal == 'A. Others') {

                //     $('#inputspeIntModal').removeAttr('readonly');
                // }
                // else if (result.im_speci_interv_modal == 'F. Others') {

                //     $('#inputspeIntModal').removeAttr('readonly');
                // }
                // else if (result.im_speci_interv_modal == 'G. Others') {

                //     $('#inputspeIntModal').removeAttr('readonly');
                // }
                // ((result.im_serv_prov_modal == 'Others') ? $('#inputserviceproviderModal').removeAttr('readonly') : $('#inputserviceproviderModal').attr('readonly','readonly'));


                // Set input, and select option to onclick, readonly and disabled due to editing was disable

                $('#im_type_of_service_modal').attr('disabled','disabled').append('<input type="hidden" class="w-100 form-control" name="im_type_of_service_modal" id="im_type_of_service_modal_id" value="'+ result.im_type_of_service_modal +'"/>');
                $('#inputtypeofServiceModal').attr('readonly','readonly');
                $('#im_speci_interv_modal').attr('disabled','disabled').append('<input type="hidden" class="w-100 form-control" name="im_speci_interv_modal" id="im_speci_interv_modal_id" value="'+ result.im_speci_interv_modal +'"/>');
                $('#inputspeIntModal').attr('readonly','readonly');
                $('#serviceproviderModal').attr('disabled','disabled').append('<input type="hidden" class="w-100 form-control" name="im_serv_prov_modal" id="im_serv_prov_modal_id" value="'+ result.im_serv_prov_modal +'"/>');
                $('#inputserviceproviderModal').attr('readonly','readonly');
                $('#im_speci_obje_modal').attr('readonly','readonly');
                $('#im_target_date_modal').attr('readonly','readonly');
                $('#im_dsp_full_name_modal').attr('onclick','changeDirectories(`serviceproviderModal`, `im_dsp_full_name_modal`, `im_dsp_post_desi_modal`, `im_dsp_email_modal`, `im_dsp_contact_no_1_modal`, `im_dsp_contact_no_2_modal`, `im_dsp_contact_no_3_modal`)');
                $('#im_dsp_post_desi_modal').attr('onclick','changeDirectories(`serviceproviderModal`, `im_dsp_full_name_modal`, `im_dsp_post_desi_modal`, `im_dsp_email_modal`, `im_dsp_contact_no_1_modal`, `im_dsp_contact_no_2_modal`, `im_dsp_contact_no_3_modal`)');
                $('#im_dsp_email_modal').attr('onclick','changeDirectories(`serviceproviderModal`, `im_dsp_full_name_modal`, `im_dsp_post_desi_modal`, `im_dsp_email_modal`, `im_dsp_contact_no_1_modal`, `im_dsp_contact_no_2_modal`, `im_dsp_contact_no_3_modal`)');
                $('#im_dsp_contact_no_1_modal').attr('onclick','changeDirectories(`serviceproviderModal`, `im_dsp_full_name_modal`, `im_dsp_post_desi_modal`, `im_dsp_email_modal`, `im_dsp_contact_no_1_modal`, `im_dsp_contact_no_2_modal`, `im_dsp_contact_no_3_modal`)');
                $('#im_dsp_contact_no_2_modal').attr('onclick','changeDirectories(`serviceproviderModal`, `im_dsp_full_name_modal`, `im_dsp_post_desi_modal`, `im_dsp_email_modal`, `im_dsp_contact_no_1_modal`, `im_dsp_contact_no_2_modal`, `im_dsp_contact_no_3_modal`)');
                $('#im_dsp_contact_no_3_modal').attr('onclick','changeDirectories(`serviceproviderModal`, `im_dsp_full_name_modal`, `im_dsp_post_desi_modal`, `im_dsp_email_modal`, `im_dsp_contact_no_1_modal`, `im_dsp_contact_no_2_modal`, `im_dsp_contact_no_3_modal`)');
                $('#im_dasp_full_name_modal').attr('onclick','changeDirectories(`serviceproviderModal`, `im_dasp_full_name_modal`, `im_dasp_post_desi_modal`, `im_dasp_email_modal`, `im_dasp_contact_no_1_modal`, `im_dasp_contact_no_2_modal`, `im_dasp_contact_no_3_modal`)');
                $('#im_dasp_post_desi_modal').attr('onclick','changeDirectories(`serviceproviderModal`, `im_dasp_full_name_modal`, `im_dasp_post_desi_modal`, `im_dasp_email_modal`, `im_dasp_contact_no_1_modal`, `im_dasp_contact_no_2_modal`, `im_dasp_contact_no_3_modal`)');
                $('#im_dasp_email_modal').attr('onclick','changeDirectories(`serviceproviderModal`, `im_dasp_full_name_modal`, `im_dasp_post_desi_modal`, `im_dasp_email_modal`, `im_dasp_contact_no_1_modal`, `im_dasp_contact_no_2_modal`, `im_dasp_contact_no_3_modal`)');
                $('#im_dasp_contact_no_1_modal').attr('onclick','changeDirectories(`serviceproviderModal`, `im_dasp_full_name_modal`, `im_dasp_post_desi_modal`, `im_dasp_email_modal`, `im_dasp_contact_no_1_modal`, `im_dasp_contact_no_2_modal`, `im_dasp_contact_no_3_modal`)');
                $('#im_dasp_contact_no_2_modal').attr('onclick','changeDirectories(`serviceproviderModal`, `im_dasp_full_name_modal`, `im_dasp_post_desi_modal`, `im_dasp_email_modal`, `im_dasp_contact_no_1_modal`, `im_dasp_contact_no_2_modal`, `im_dasp_contact_no_3_modal`)');
                $('#im_dasp_contact_no_3_modal').attr('onclick','changeDirectories(`serviceproviderModal`, `im_dasp_full_name_modal`, `im_dasp_post_desi_modal`, `im_dasp_email_modal`, `im_dasp_contact_no_1_modal`, `im_dasp_contact_no_2_modal`, `im_dasp_contact_no_3_modal`)');

            }

        }
    });
}


// End of editing the additional Intervention Module specific info

// Start of update additional Intervention Module info form using Sweet Alert


function updateAdditionalInterventionModuleForm(id){

    Swal.fire({
        title: 'Do you want to save the changes?',
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'Save',
        denyButtonText: `Don't save`,
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                type: "POST",
                url: rootURL + 'api/v1/intervention-module-infos/update/'+ id,
                data: $("#addInterventionModulenfos").serialize(),
                success: function(response) {

                    if (response === 'Updating Intervention Module Info Success'){
                        Swal.fire({
                            icon: 'success',
                            title: 'Saved!',
                            html: `<center>Updating Intervention Module Info Success.</center>`
                        });
                        closeAdditionalInterventionModuleForm();
                        $('#modalInterventionModuleInfos').modal('toggle');
                        $('#addInterventionModulenfos').trigger("reset");
                        $('#add-intervention-module-error-form').empty();
                    }
                    else if (response === 'Case already closed editing was disabled'){
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            html: `<center>Case already closed editing was disabled.</center>`
                        });
                        closeAdditionalInterventionModuleForm();
                        $('#modalInterventionModuleInfos').modal('toggle');
                        $('#addInterventionModulenfos').trigger("reset");
                        $('#add-intervention-module-error-form').empty();
                    }
                    else if (response === `Sorry you don't have the rights to update this case please contact the administrator`){
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            html: `<center>Sorry you don't have the rights to update this case please contact the administrator.</center>`
                        });
                        closeAdditionalInterventionModuleForm();
                        $('#modalInterventionModuleInfos').modal('toggle');
                        $('#addInterventionModulenfos').trigger("reset");
                        $('#add-intervention-module-error-form').empty();
                    }
                    else{

                        Swal.fire('The Intervention Module info was not updated!', '', 'error');

                        html = "";
                        $.each(response, function( index, value ) {
                            html += '<p class="d-flex justify-content-center text-danger">'+ value +'</p>';
                        });
                        html += '<hr>';

                        $('#add-intervention-module-error-form').empty().prepend(html);
                    }
                }
            });
        } else if (result.isDenied) {

            Swal.fire('Changes are not saved', '', 'info')
        }
    });

}


// End of update additional Intervention Module info form using Sweet Alert

// Start of deleting additional Intervention Module info Sweet Alert modal


    function deleteSpecificAdditionalInterventionModuleModal(id){
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: rootURL + 'api/v1/intervention-module-infos/delete/' + id,
                    data: {
                        _method: 'delete',
                    },
                    success: function(response) {

                        if (response === 'The Intervention Module Info was successfully deleted'){
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                html: `<center>The Intervention Module Info was successfully deleted.</html>`
                            });
                            closeAdditionalInterventionModuleForm();
                        }
                        else if (response === `Sorry you don't have the rights to delete case record please contact the administrator`){
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                html: `<center>Sorry you don't have the rights to delete case record please contact the administrator.</html>`
                            });
                            closeAdditionalInterventionModuleForm();
                        }
                        else if (response === 'Case already closed delete was disabled'){
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                html: `<center>Case already closed delete was disabled.</html>`
                            });
                            closeAdditionalInterventionModuleForm();
                        }
                        else{
                            Swal.fire('The Intervention Module Info was not deleted!', '', 'error');
                        }
                    }
                });

            }else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }
        });
    }


// End of deleting additional Intervention Module info Sweet Alert modal

// Start of change Service Provider confirmation using Sweet Alert


function changeServiceProvider(select_tag_id){

    Swal.fire({
        title: 'Do you want to change the Service Provider?',
        html: "<center>Existing Service Provider will be reset!</center>",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: rootURL + 'api/v1/case/get-service-provider-list',
                success: function (result) {

                    // Remove Service Provider: onclick attribute changeServiceProvider() function
                    $('#'+ select_tag_id +'').attr('onclick','');

                    // Empty Dropdown List
                    $('#'+ select_tag_id +'').empty();

                    $('#'+ select_tag_id +'').prepend('<option value="">Please Select</option>');

                    result.forEach(element => {
                        $('#'+ select_tag_id +'').append('<option value="'+ element['name'] +'">'+ element['name'] +'</option>');
                    });

                    $('#'+ select_tag_id +'').append('<option value="Others">Others</option>');
                }
            });
        }
    });
}


// End of change Service Provider confirmation using Sweet Alert

// Start of change Relationship to the Victim-Survivor confirmation using Sweet Alert


function changeRelationshipToTheVictimSurvivor(select_tag_id){

    Swal.fire({
        title: 'Do you want to change the Relationship to the Victim-Survivor?',
        html: "<center>Existing Relationship to the Victim-Survivor will be reset!</center>",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: rootURL + 'api/v1/case/get-relationship-to-victim-survivors-list',
                success: function (result) {

                    // Remove Relationship to the Victim-Survivor: onclick attribute changeRelationshipToTheVictimSurvivor() function
                    $('#'+ select_tag_id +'').prop('onclick', null);

                    // Empty Dropdown List
                    $('#'+ select_tag_id +'').empty();

                    $('#'+ select_tag_id +'').prepend('<option value="">Please Select</option>');

                    result.forEach(element => {
                        $('#'+ select_tag_id +'').append('<option value="'+ element['item_name'] +'">'+ element['item_name'] +'</option>');
                    });

                    $('#'+ select_tag_id +'').append('<option value="Other Relatives, Specify:">Other Relatives, Specify:</option>');
                }
            });
        }
    });
}


// End of change Relationship to the Victim-Survivor confirmation using Sweet Alert

// Start of change Place of Incidence confirmation using Sweet Alert


function changePlaceOfIncidence(select_tag_id){

    Swal.fire({
        title: 'Do you want to change the Place of Incidence?',
        html: "<center>Existing Place of Incidence will be reset!</center>",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: rootURL + 'api/v1/case/get-place-of-incidences-list',
                success: function (result) {

                    // Remove Place of Incidence: onclick attribute changePlaceOfIncidence() function
                    $('#'+ select_tag_id +'').prop('onclick', null);

                    // Empty Dropdown List
                    $('#'+ select_tag_id +'').empty();

                    $('#'+ select_tag_id +'').prepend('<option value="">Please Select</option>');

                    result.forEach(element => {
                        $('#'+ select_tag_id +'').append('<option value="'+ element['item_name'] +'">'+ element['item_name'] +'</option>');
                    });

                    $('#'+ select_tag_id +'').append('<option value="Others">Others</option>');
                }
            });
        }
    });
}


// End of change Place of Incidence confirmation using Sweet Alert

// Start of change Religion confirmation using Sweet Alert


function changeReligion(select_tag_id){

    Swal.fire({
        title: 'Do you want to change the Religion?',
        html: "<center>Existing Religion will be reset!</center>",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: rootURL + 'api/v1/case/get-religions-list',
                success: function (result) {

                    // Remove Religion: onclick attribute changeReligion() function
                    $('#'+ select_tag_id +'').prop('onclick', null);

                    // Empty Dropdown List
                    $('#'+ select_tag_id +'').empty();

                    $('#'+ select_tag_id +'').prepend('<option value="">Please Select</option>');

                    result.forEach(element => {
                        $('#'+ select_tag_id +'').append('<option value="'+ element['item_name'] +'">'+ element['item_name'] +'</option>');
                    });

                    $('#'+ select_tag_id +'').append('<option value="Others">Others</option>');
                }
            });
        }
    });
}


// End of change Religion confirmation using Sweet Alert

// Start of change address confirmation using Sweet Alert


function changeAddress(select_tag_region_id, select_tag_province_id, select_tag_city_id, select_tag_barangay_id,){

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

        // Reset address field and removed onclick changeAddress() function

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

        $('#'+ select_tag_region_id +'').ph_locations('fetch_list');

    }
    });
}


    // under create_case/script for incident details

// checkboxToggle.js

function toggleSubOptions(checkbox) {
    var subOptions = document.querySelectorAll('.form-check-input[name^="id_ipv_"]');
    subOptions.forEach(function (option) {
        option.disabled = !checkbox.checked;
        option.checked = false; // Clear the checkbox
    });
}


function toggleSubOptions_trafficking(checkbox) {
    var subOptions = document.querySelectorAll('.form-check-input[name^="id_traf_per_"]');
    subOptions.forEach(function (option) {
      option.disabled = !checkbox.checked;
      option.checked = false;
    });
  }

  function toggleSubOptions_Sexual_Harassment(checkbox) {
    var subOptions = document.querySelectorAll('.form-check-input[name^="id_sex_hara_"]');
    subOptions.forEach(function (option) {
      option.disabled = !checkbox.checked;
      option.checked = false;
    });
  }

  function toggleSubOptions_Abuse_Discrimination(checkbox) {
    var subOptions = document.querySelectorAll('.form-check-input[name^="id_chi_abu_"]');
    subOptions.forEach(function (option) {
      option.disabled = !checkbox.checked;
      option.checked = false;
    });
  }



// End of change address confirmation using Sweet Alert

// End of Javascript
