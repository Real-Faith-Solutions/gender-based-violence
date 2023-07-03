<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\Helpers;
use App\Http\Controllers\ForbesTopController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\AmortizationContoller;
use App\Http\Controllers\CollateralController;
use App\Http\Controllers\ChequeController;
use App\Http\Controllers\BorrowerController;
use App\Http\Controllers\DeductionController;
use App\Http\Controllers\AnalysisRequestController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\DirectoryController;
use App\Http\Controllers\DirectoryTypeController;
use App\Http\Controllers\CaseRequestController;
use App\Http\Controllers\CaseController;
use App\Http\Controllers\ParentPageRedirect;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Reports;
use App\Http\Controllers\PlaceOfIncidencesController;
use App\Http\Controllers\RelationshipToVictimSurvivorsController;
use App\Http\Controllers\ReligionsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ForgotPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ParentPageRedirect::class, 'homePage']);

Route::group([
    'prefix'     => 'api/v1',
], function () {
    Route::get('users', [UserController::class, 'getUsers'])->middleware('userauth');

    Route::group([
        'prefix'     => 'case',
    ], function () {
        Route::post('add', [CaseController::class, 'addNewCase'])->middleware('userauth');
        Route::get('record', [CaseController::class, 'getCase'])->middleware('userauth');
        Route::get('search/{id}', [CaseController::class, 'getCaseByID'])->middleware('userauth');
        Route::post('upload/{case_no}', [CaseController::class, 'uploadFilesForCase'])->middleware('userauth');
        Route::get('case-files/{case_no}', [CaseController::class, 'getUploadedFilesInCase'])->middleware('userauth');
        Route::delete('delete-case-files/{id}/{case_no}/{file}', [CaseController::class, 'deleteUploadedFilesInCase'])->middleware('userauth');
        Route::get('validate-case-no/{case_no}', [CaseController::class, 'validateCaseNo'])->middleware('userauth');
        Route::get('search-directory/{service_provider}', [CaseController::class, 'searchDirectory'])->middleware('userauth');
        Route::get('search-directory-details/{id}', [CaseController::class, 'searchDirectoryDetails'])->middleware('userauth');
        Route::get('get-relationship-to-victim-survivors-list', [CaseController::class, 'getRelationshipToVictimSurvivorsList'])->middleware('userauth');
        Route::get('get-place-of-incidences-list', [CaseController::class, 'getPlaceOfIncidencesList'])->middleware('userauth');
        Route::get('get-religions-list', [CaseController::class, 'getReligionsList'])->middleware('userauth');
        Route::get('get-service-provider-list', [CaseController::class, 'getDirectoryTypeList'])->middleware('userauth');
        Route::get('get-case-form-status/{case_no}', [CaseController::class, 'getCaseFormStatus'])->middleware('userauth');
        Route::get('get-case-status/{case_no}', [CaseController::class, 'getCaseStatus'])->middleware('userauth');
        Route::get('get-user-masterlist-rights', [CaseController::class, 'getUserMasterListRights'])->middleware('userauth');
        Route::get('migate-data-in-new-column-for-cases-table', [CaseController::class, 'migateDataInNewColumnForCasesTable'])->middleware('userauth');

        // Additional security and redirect
        Route::get('add', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
        Route::get('upload/{case_no}', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
        Route::get('upload/', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
        Route::get('delete-case-files/{id}/{case_no}/{file}', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
        Route::get('delete-case-files/', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
        Route::get('validate-case-no', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
        Route::get('case-files/', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
    });

    Route::group([
        'prefix'     => 'family-background-infos',
    ], function () {
        Route::post('add', [CaseController::class, 'addFamilyBackgroundInfos'])->middleware('userauth');
        Route::get('record', [CaseController::class, 'getFamilyBackgroundInfos'])->middleware('userauth');
        Route::get('get/{case_no_modal}', [CaseController::class, 'getDataFamByCaseNo'])->middleware('userauth');
        Route::get('get-specific-additional-record/{id}', [CaseController::class, 'getDataFamByID'])->middleware('userauth');
        Route::post('update/{id}', [CaseController::class, 'updateFamilyBackgroundInfos'])->middleware('userauth');
        Route::delete('delete/{id}', [CaseController::class, 'deleteFamilyBackgroundInfos'])->middleware('userauth');

        // Additional security and redirect
        Route::get('add', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
        Route::get('update/{id}', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
        Route::get('update', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
        Route::get('delete/{id}', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
        Route::get('delete', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
    });

    Route::group([
        'prefix'     => 'incidence-detail-infos',
    ], function () {
        Route::post('add', [CaseController::class, 'addIncidenceDetailInfos'])->middleware('userauth');
        Route::get('record', [CaseController::class, 'getIncidenceDetailInfos'])->middleware('userauth');
        Route::get('get/{case_no_modal}', [CaseController::class, 'getDataInciByCaseNo'])->middleware('userauth');
        Route::get('get-specific-additional-record/{id}', [CaseController::class, 'getDataInciByID'])->middleware('userauth');
        Route::post('update/{id}', [CaseController::class, 'updateIncidenceDetailInfos'])->middleware('userauth');
        Route::delete('delete/{id}', [CaseController::class, 'deleteIncidenceDetailInfos'])->middleware('userauth');

        // Additional security and redirect
        Route::get('add', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
        Route::get('update/{id}', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
        Route::get('update', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
        Route::get('delete/{id}', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
        Route::get('delete', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
    });

    Route::group([
        'prefix'     => 'perpetrator-detail-infos',
    ], function () {
        Route::post('add', [CaseController::class, 'addPerpetratorDetailInfos'])->middleware('userauth');
        Route::get('record', [CaseController::class, 'getPerpetratorDetailInfos'])->middleware('userauth');
        Route::get('get/{case_no_modal}', [CaseController::class, 'getDataPerpetByCaseNo'])->middleware('userauth');
        Route::get('get-specific-additional-record/{id}', [CaseController::class, 'getDataPerpetByID'])->middleware('userauth');
        Route::post('update/{id}', [CaseController::class, 'updatePerpetratorDetailInfos'])->middleware('userauth');
        Route::delete('delete/{id}', [CaseController::class, 'deletePerpetratorDetailInfos'])->middleware('userauth');

        // Additional security and redirect
        Route::get('update/{id}', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
        Route::get('update', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
        Route::get('delete/{id}', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
        Route::get('delete', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
    });

    Route::group([
        'prefix'     => 'intervention-module-infos',
    ], function () {
        Route::post('add', [CaseController::class, 'addInterventionModuleInfos'])->middleware('userauth');
        Route::get('record', [CaseController::class, 'getInterventionModuleInfos'])->middleware('userauth');
        Route::get('get/{case_no_modal}', [CaseController::class, 'getDataInterByCaseNo'])->middleware('userauth');
        Route::get('get-specific-additional-record/{id}', [CaseController::class, 'getDataInterByID'])->middleware('userauth');
        Route::post('update/{id}', [CaseController::class, 'updateInterventionModuleInfos'])->middleware('userauth');
        Route::delete('delete/{id}', [CaseController::class, 'deleteInterventionModuleInfos'])->middleware('userauth');

        // Additional security and redirect
        Route::get('add', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
        Route::get('update/{id}', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
        Route::get('update', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
        Route::get('delete/{id}', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
        Route::get('delete', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
    });

    Route::group([
        'prefix'     => 'master-list',
    ], function () {
        Route::get('add', [CaseController::class, 'addNewCase'])->middleware('userauth');
        Route::get('record', [CaseController::class, 'getCase'])->middleware('userauth');
    });

    Route::group([
        'prefix'     => 'directory',
    ], function () {
        Route::post('add', [DirectoryController::class, 'addDirectory'])->middleware('userauth');
        Route::put('update/{id}', [DirectoryController::class, 'updateDirectory'])->middleware('userauth');
        Route::delete('delete/{id}', [DirectoryController::class, 'deleteDirectory'])->middleware('userauth');
        Route::post('record', [DirectoryController::class, 'getDirectory'])->middleware('userauth');

        // Additional security and redirect
        Route::get('add', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
        Route::get('update/{id}', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
        Route::get('update', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
        Route::get('delete/{id}', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
        Route::get('delete', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
    });

    Route::group([
        'prefix'     => 'case-request',
    ], function () {
        Route::get('add', [CaseRequestController::class, 'addCaseRequest'])->middleware('userauth');
        Route::get('record', [CaseRequestController::class, 'getCaseRequest'])->middleware('userauth');
    });

    Route::group([
        'prefix'     => 'directory-type',
    ], function () {
        Route::post('add', [DirectoryTypeController::class, 'addDirectoryType'])->middleware('userauth');
        Route::put('update/{id}', [DirectoryTypeController::class, 'updateDirectoryType'])->middleware('userauth');
        Route::delete('delete/{id}', [DirectoryTypeController::class, 'deleteDirectoryType'])->middleware('userauth');
        Route::get('record', [DirectoryTypeController::class, 'getDirectoryType'])->middleware('userauth');

        // Additional security and redirect
        Route::get('add', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
        Route::get('update/{id}', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
        Route::get('update', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
        Route::get('delete/{id}', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
        Route::get('delete', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
    });

    Route::group([
        'prefix'     => 'user',
    ], function () {
        Route::post('add', [UserController::class, 'addUser'])->name('user')->middleware('userauth');
        Route::put('update/{id}', [UserController::class, 'updateUser'])->middleware('userauth');
        Route::delete('delete/{id}', [UserController::class, 'deleteUser'])->middleware('userauth');
        Route::post('search', [UserController::class, 'getUserByLastName'])->middleware('userauth');
        // Route::get('record', [UserController::class, 'getUser'])->middleware('userauth');

         // Additional security and redirect
         Route::get('add', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
         Route::get('update/{id}', [UserController::class, 'getUpdateCreatedUserPage'])->middleware('userauth');
         Route::get('delete/{id}', [UserController::class, 'getDeteleCreatedUserPage'])->middleware('userauth');
         Route::get('update', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
         Route::get('delete', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
    });

    Route::group([
        'prefix'     => 'user-role',
    ], function () {
        Route::post('add', [UserRoleController::class, 'addUserRole'])->middleware('userauth');
        Route::put('update/{id}', [UserRoleController::class, 'updateUserRole'])->middleware('userauth');
        Route::delete('delete/{id}', [UserRoleController::class, 'deleteUserRole'])->middleware('userauth');
        // Route::get('record', [UserRoleController::class, 'getUserRole'])->middleware('userauth');

        // Additional security and redirect
        Route::get('add', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
        Route::get('delete/{id}', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
        Route::get('delete', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
        Route::get('update/{id}', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
        Route::get('update/', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
    });

    Route::group([
        'prefix'     => 'facility',
    ], function () {
        Route::get('add', [FacilityController::class, 'addFacility'])->middleware('userauth');
        Route::get('record', [FacilityController::class, 'getFacility'])->middleware('userauth');
    });

    Route::group([
        'prefix'     => 'client',
    ], function () {
        Route::get('add', [ClientController::class, 'addNewClient'])->middleware('userauth');
        Route::get('record', [ClientController::class, 'getClients'])->middleware('userauth');
    });

    Route::group([
        'prefix'     => 'relationship-to-victim-survivor',
    ], function () {
        Route::post('add', [RelationshipToVictimSurvivorsController::class, 'addRelationshipToVictimSurvivors'])->middleware('userauth');
        Route::put('update/{id}', [RelationshipToVictimSurvivorsController::class, 'updateRelationshipToVictimSurvivors'])->middleware('userauth');
        Route::delete('delete/{id}', [RelationshipToVictimSurvivorsController::class, 'deleteRelationshipToVictimSurvivors'])->middleware('userauth');
        Route::post('record', [RelationshipToVictimSurvivorsController::class, 'getRelationshipToVictimSurvivors'])->middleware('userauth');

        // Additional security and redirect
        Route::get('add', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
        Route::get('update/{id}', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
        Route::get('update', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
        Route::get('delete/{id}', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
        Route::get('delete', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
    });

    Route::group([
        'prefix'     => 'place-of-incidence',
    ], function () {
        Route::post('add', [PlaceOfIncidencesController::class, 'addPlaceOfIncidences'])->middleware('userauth');
        Route::put('update/{id}', [PlaceOfIncidencesController::class, 'updatePlaceOfIncidences'])->middleware('userauth');
        Route::delete('delete/{id}', [PlaceOfIncidencesController::class, 'deletePlaceOfIncidences'])->middleware('userauth');
        Route::post('record', [PlaceOfIncidencesController::class, 'getPlaceOfIncidences'])->middleware('userauth');

        // Additional security and redirect
        Route::get('add', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
        Route::get('update/{id}', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
        Route::get('update', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
        Route::get('delete/{id}', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
        Route::get('delete', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
    });

    Route::group([
        'prefix'     => 'religions',
    ], function () {
        Route::post('add', [ReligionsController::class, 'addReligions'])->middleware('userauth');
        Route::put('update/{id}', [ReligionsController::class, 'updateReligions'])->middleware('userauth');
        Route::delete('delete/{id}', [ReligionsController::class, 'deleteReligions'])->middleware('userauth');
        Route::post('record', [ReligionsController::class, 'getReligions'])->middleware('userauth');

        // Additional security and redirect
        Route::get('add', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
        Route::get('update/{id}', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
        Route::get('update', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
        Route::get('delete/{id}', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
        Route::get('delete', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
    });

    Route::group([
        'prefix'     => 'profile',
    ], function () {
        Route::post('change-password', [ProfileController::class, 'userChangePassword'])->middleware('userauth');

        // Additional security and redirect
        Route::get('change-password', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
    });

    Route::group([
        'prefix'     => 'password',
    ], function () {
        Route::post('reset-password', [ForgotPasswordController::class, 'getPasswordUpdatePage'])->name('password.update');

        // Additional security and redirect
        Route::get('reset-password', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');
    });

});

Route::group([
    'prefix'     => 'user',
    'middleware' => 'userauth',
], function () {
    // Route::get('dashboard', [ForbesTopController::class, 'getMostCounts']);

    // // User add and records
    // Route::post('add', [UserController::class, 'addUser']);
    // Route::get('add', [ParentPageRedirect::class, 'getApiAddHomePage']);
    // Route::get('record', [UserController::class, 'getUser']);

    // /// Table Records Functionality Routes
    // // Route::get('csv-records', [ForbesTopController::class, 'getRecipients']);
    // // Route::post('csv-search', [ForbesTopController::class, 'findRecipients']);

    // /// CSV Functionality Routes
    // // Route::get('csv-upload', function () {
    // //     return view('csvuploader');
    // // });
    // // Route::post('csv-upload', [ForbesTopController::class, 'uploadCSVContent']);

    // // Route::get('message', function () {
    // //     return view('message');
    // // });

    // Route::get('user-records', [UserController::class, 'getUsersTable'])->middleware('userauth');
});


/// User Auth Functionality Routes

Route::get('/login', [ParentPageRedirect::class, 'loginHomePage'])->middleware('userauth');
Route::post('/login', [AuthController::class, 'userLogin'])->name('login');
Route::get('/forgot-password', [ForgotPasswordController::class, 'forgotPasswordHomePage'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'forgotPasswordHomePage'])->name('password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'getPasswordResetPage'])->name('password.reset');
Route::get('/logout', [AuthController::class, 'userLogout'])->middleware('userauth');

// Route::get('/registration', [ParentPageRedirect::class, 'registrationHomePage']);

// Additional security and redirect
Route::get('/reset-password', [ParentPageRedirect::class, 'getApiAddHomePage'])->middleware('userauth');


// User Auth Functionality Routes

Route::group([
    'prefix'     => 'admin',
    'middleware' => 'userauth',
], function () {
    Route::get('/', [ParentPageRedirect::class, 'adminHomePage']);

    Route::group([
        'prefix'     => 'dashboard',
    ], function () {
        Route::get('/', [Dashboard::class, 'getDashboardPage']);
        Route::post('/', [Dashboard::class, 'getDashboardPage']);
    });

    Route::group([
        'prefix'     => 'maintenance',
    ], function () {
        Route::get('/', [ParentPageRedirect::class, 'maintenanceHomePage']);
        Route::get('/directory', [DirectoryController::class, 'getDirectoriesPage']);
        Route::get('/directory-type', [DirectoryTypeController::class, 'getDirectoriesTypePage']);
        Route::get('/relationship-to-victim-survivor', [RelationshipToVictimSurvivorsController::class, 'getRelationshipToVictimSurvivorsPage']);
        Route::get('/place-of-incidence', [PlaceOfIncidencesController::class, 'getPlaceOfIncidencesPage']);
        Route::get('/religions', [ReligionsController::class, 'getReligionsPage']);
        Route::get('/directory/edit-created-directory/{id}', [DirectoryController::class, 'editDirectoriesPage']);
        Route::get('/directory/search/{directory_last_name_search}', [DirectoryController::class, 'getSearchDirectoriesByLastName']);

        // Additional security and redirect
        Route::get('/directory/search', [ParentPageRedirect::class, 'getSearchDirectoriesByLastNameHomePage']);
    });

    Route::group([
        'prefix'     => 'rights-management',
    ], function () {
        Route::get('/', [ParentPageRedirect::class, 'rightsManagementHomePage']);
        Route::get('/user-role', [UserRoleController::class, 'getUserRolesPage']);
        Route::get('/user', [UserController::class, 'getUsersTable']);
        Route::get('/user/edit-created-user/{id}', [UserController::class, 'editUser']);
        Route::get('/user-role/edit-created-user-role/{id}', [UserRoleController::class, 'editUserRole']);
        Route::get('/user/search/{user_last_name_search}', [UserController::class, 'getSearchUserByLastName']);

        // Additional security and redirect
        Route::get('/user/edit-created-user', [ParentPageRedirect::class, 'editUserformHomePage']);
        Route::get('/user-role/edit-created-user-role/', [ParentPageRedirect::class, 'editUserRoleformHomePage']);
        Route::get('/user/search', [ParentPageRedirect::class, 'getSearchUserByLastNameHomePage']);
    });

    Route::group([
        'prefix'     => 'case-folder',
    ], function () {
        Route::get('/', [ParentPageRedirect::class, 'caseFolderHomePage']);
        Route::get('/master-list', [CaseController::class, 'getCasesPage']);
        Route::get('/create-case', [CaseController::class, 'getCreateCasePage']);
        Route::get('/edit-created-case/{case_no}', [CaseController::class, 'editCaseform']);
        Route::get('/view-created-case/{case_no}', [CaseController::class, 'viewCaseform']);
        Route::put('/update-created-case/{case_no}', [CaseController::class, 'updateCaseform']);
        Route::get('/master-list/search/{case_search_option}/{case_no_or_last_name_search}', [CaseController::class, 'getSearchCasesPage']);

        // Additional security and redirect
        Route::get('/update-created-case/{case_no}', [CaseController::class, 'getUpdateCreatedCasePage']);
        Route::get('/edit-created-case', [ParentPageRedirect::class, 'editCaseformHomePage']);
        Route::get('/view-created-case', [ParentPageRedirect::class, 'viewCaseformHomePage']);
        Route::get('/update-created-case', [ParentPageRedirect::class, 'updateCaseformHomePage']);
        Route::get('/master-list/search/{case_search_option}/', [ParentPageRedirect::class, 'getSearchCasesHomePage']);
    });

    Route::group([
        'prefix'     => 'report',
    ], function () {
        // Route::get('/', [Reports::class, 'getReportsPage']); // Report Page didn't use
        Route::get('/', [ParentPageRedirect::class, 'getReportHomePage']);
        Route::get('/list-of-cases-per-status-report', [Reports::class, 'getListOfCasesPerStatusReport']);
        Route::get('/list-of-perpetrator-relationship-to-victim', [Reports::class, 'getListOfPerpetratorRelationshipToVictim']);
        Route::get('/list-of-gbv-cases-per-month', [Reports::class, 'getListOfGBVCasesPerMonth']);
        Route::get('/sort-list-of-gbv-cases-per-month/{date_from}/{date_to}', [Reports::class, 'getSortListOfGBVCasesPerMonth']);
        Route::get('/list-of-gbv-cases-per-municipality', [Reports::class, 'getListOfGBVCasesPerMunicipality']);
        Route::get('/list-of-gbv-cases-per-province', [Reports::class, 'getListOfGBVCasesPerProvince']);
        Route::get('/list-of-gbv-cases-per-form-of-violence', [Reports::class, 'getListOfGBVCasesPerFormOfViolence']);

        // Additional security and redirect
        Route::get('/sort-list-of-gbv-cases-per-month', [ParentPageRedirect::class, 'getSortListOfGBVCasesPerMonthHomePage']);
    });

    Route::group([
        'prefix'     => 'profile',
    ], function () {
        Route::get('/', [ProfileController::class, 'getProfilePage']);

    });
});
