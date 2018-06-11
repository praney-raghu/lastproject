<?php

/**
 * Neev routes
 */

Route::group(['middleware' => ['web']], function () {
    // Authentication Routes...
    Route::get('login', 'Ssntpl\Neev\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Ssntpl\Neev\Http\Controllers\Auth\LoginController@login')->name('login.submit');
    Route::post('logout', 'Ssntpl\Neev\Http\Controllers\Auth\LoginController@logout')->name('logout');
    // Registration Routes...
    Route::get('register', 'Ssntpl\Neev\Http\Controllers\Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Ssntpl\Neev\Http\Controllers\Auth\RegisterController@register');
    // Password Reset Routes...
    Route::get('password/reset', 'Ssntpl\Neev\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Ssntpl\Neev\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'Ssntpl\Neev\Http\Controllers\Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Ssntpl\Neev\Http\Controllers\Auth\ResetPasswordController@reset');
});

Route::group(['middleware' => ['web', 'auth']], function () {
    // Route::get('home', 'Ssntpl\Neev\Http\Controllers\User\HomeController@index')->name('user.home');

    Route::get('home', 'Ssntpl\Neev\Http\Controllers\Organisation\HomeController@index')->name('organisation.home');
    Route::get('home/edit', 'Ssntpl\Neev\Http\Controllers\Organisation\HomeController@edit')->name('organisation.newedit');
    
});

Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'user'], function () {

    Route::get('home', 'Ssntpl\Neev\Http\Controllers\User\HomeController@index')->name('user.home');

    Route::get('profile', 'Ssntpl\Neev\Http\Controllers\User\UserProfileController@profile')->name('user.profile');
    Route::patch('profile', 'Ssntpl\Neev\Http\Controllers\User\UserProfileController@editProfile')->name('user.profile');
    Route::get('change_password', 'Ssntpl\Neev\Http\Controllers\User\ChangePasswordController@showChangePasswordForm')->name('user.change_password');
    Route::patch('change_password', 'Ssntpl\Neev\Http\Controllers\User\ChangePasswordController@changePassword')->name('user.change_password');
    Route::get('organisation', 'Ssntpl\Neev\Http\Controllers\Organisation\OrganisationController@index')->name('organisation.index');
    Route::get('organisation/create', 'Ssntpl\Neev\Http\Controllers\Organisation\OrganisationController@create')->name('organisation.create');
    Route::post('organisation', 'Ssntpl\Neev\Http\Controllers\Organisation\OrganisationController@store')->name('organisation.store');
    Route::get('organisation/edit/{organisation}', 'Ssntpl\Neev\Http\Controllers\Organisation\OrganisationController@edit')->name('organisation.edit');
    Route::put('organisation/edit/{organisation}', 'Ssntpl\Neev\Http\Controllers\Organisation\OrganisationController@update')->name('organisation.update');
    Route::delete('organisation/destroy/{organisation}', 'Ssntpl\Neev\Http\Controllers\Organisation\OrganisationController@destroy')->name('organisation.destroy');
    Route::get('organisation/switch/{organisation}', 'Ssntpl\Neev\Http\Controllers\Organisation\OrganisationController@switchOrganisation')->name('organisation.switch');
    Route::get('organisation/switchtopbar/{organisation}', 'Ssntpl\Neev\Http\Controllers\Organisation\OrganisationController@switchOrganisationSameView')->name('organisation.switchSameView');

    Route::get('organisation/members/{organisation}', 'Ssntpl\Neev\Http\Controllers\Organisation\OrganisationMemberController@show')->name('organisation.members.show');
    Route::get('organisation/members/resend/{invite_id}', 'Ssntpl\Neev\Http\Controllers\Organisation\OrganisationMemberController@resendInvite')->name('organisation.members.resend_invite');
    Route::post('organisation/members/{organisation}', 'Ssntpl\Neev\Http\Controllers\Organisation\OrganisationMemberController@invite')->name('organisation.members.invite');
    Route::delete('organisation/members/{organisation}/{user}', 'Ssntpl\Neev\Http\Controllers\Organisation\OrganisationMemberController@destroy')->name('organisation.members.destroy');

    Route::get('organisation/accept/{token}', 'AuthController@acceptInvite')->name('organisation.accept_invite');    

    // Language route
    Route::get('language', 'Ssntpl\Neev\Http\Controllers\Language\LanguageController@index')->name('language.index');
    Route::post('language', 'Ssntpl\Neev\Http\Controllers\Language\LanguageController@setLanguage')->name('language.set');
});

Route::group(['middleware' => ['web', 'auth:admin'], 'prefix' => config('neev.admin_route'), 'as' => 'admin.'], function () {
    Route::get('/', 'Ssntpl\Neev\Http\Controllers\Admin\HomeController@index')->name('home');
    Route::resource('permissions', 'Ssntpl\Neev\Http\Controllers\Admin\PermissionsController');
    Route::post('permissions_mass_destroy', 'Ssntpl\Neev\Http\Controllers\Admin\PermissionsController@massDestroy')->name('permissions.mass_destroy');
    Route::resource('roles', 'Ssntpl\Neev\Http\Controllers\Admin\RolesController');
    Route::post('roles_mass_destroy', 'Ssntpl\Neev\Http\Controllers\Admin\RolesController@massDestroy')->name('roles.mass_destroy');
    Route::resource('users', 'Ssntpl\Neev\Http\Controllers\Admin\UsersController');
    Route::post('users_mass_destroy', 'Ssntpl\Neev\Http\Controllers\Admin\UsersController@massDestroy')->name('users.mass_destroy');
    Route::resource('clients', 'Ssntpl\Neev\Http\Controllers\Admin\ClientsController');
    Route::post('clients_mass_destroy', 'Ssntpl\Neev\Http\Controllers\Admin\ClientsController@massDestroy')->name('clients.mass_destroy');

    // User Impersonation
    Route::get('impersonate/guest', 'Ssntpl\Neev\Http\Controllers\Admin\ImpersonateController@impersonateGuest')->name('impersonateGuest');
    Route::get('impersonate/stop', 'Ssntpl\Neev\Http\Controllers\Admin\ImpersonateController@stopImpersonation')->name('stopImpersonation');
    Route::get('impersonate/{user}', 'Ssntpl\Neev\Http\Controllers\Admin\ImpersonateController@impersonateUser')->name('impersonateUser');
    
    // Language Translation routes
    Route::get('translation', 'Ssntpl\Neev\Http\Controllers\Language\LanguageController@show')->name('translation.index');
    Route::post('translation', 'Ssntpl\Neev\Http\Controllers\Language\LanguageController@getGroupTranslations')->name('translation.getGroup');
    Route::post('translation/set', 'Ssntpl\Neev\Http\Controllers\Language\LanguageController@set')->name('translation.set');
    Route::post('translation/edit', 'Ssntpl\Neev\Http\Controllers\Language\LanguageController@update')->name('translation.edit');

    Route::get('tokens', 'Ssntpl\Neev\Http\Controllers\API\TokenController@index')->name('tokens.index');

    // Module Management routes
    Route::get('modules', 'Ssntpl\Neev\Http\Controllers\Module\ModuleController@index')->name('modules.index');
    Route::get('modules/{moduleName}', 'Ssntpl\Neev\Http\Controllers\Module\ModuleController@update')->name('modules.update');
    Route::delete('modules/destroy/{moduleName}', 'Ssntpl\Neev\Http\Controllers\Module\ModuleController@destroy')->name('modules.destroy');
});

// Neev system routes
Route::view(config('neev.organisation_not_found_route'), 'neev::errors.organisationNotFound')->middleware('web');

// Neev Installation routes
Route::group(['middleware' => ['web'], 'prefix' => config('neev.install_route'), 'as' => 'install.'], function() {
    Route::get('/', 'Ssntpl\Neev\Http\Controllers\System\InstallController@index')->name('welcome');
    Route::post('testDBConnection', 'Ssntpl\Neev\Http\Controllers\System\InstallController@testDBConnection')->name('testDBConnection');
    Route::post('finish', 'Ssntpl\Neev\Http\Controllers\System\InstallController@install')->name('finish');
});

// API Routes
Route::group(['prefix' => 'api','middleware' => 'auth:api'], function () {
    Route::get('organisation', 'Ssntpl\Neev\Http\Controllers\API\OrganisationController@index');
});