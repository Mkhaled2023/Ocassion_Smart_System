<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', 'Dash\DashAuthController@adminLogin');
Route::post('hall-manager-login', 'Dash\HallManagerController@hallManagerLogin');
Route::post('register', 'Dash\DashAuthController@adminRegister');
Route::put('update/{id}', 'Dash\DashAuthController@adminUpdate');
Route::get('/all-admins', 'Dash\AdminsController@allAdmins');
//
Route::middleware('auth:api-dash')->group(function () {
    Route::prefix('admin')->group(function () {
        Route::post('/add-admin', 'Dash\AdminsController@addAdmin');
        Route::post('/edit-admin/{AdminId}', 'Dash\AdminsController@editAdmin');
        Route::delete('/delete-admin/{AdminId}', 'Dash\AdminsController@deleteAdmin');
        Route::get('/all-admins', 'Dash\AdminsController@allAdmins');
        Route::get('/single-admin/{AdminId}', 'Dash\AdminsController@singleAdmin');
    });
    Route::prefix('hall')->group(function () {
        Route::post('/add-hall', 'Dash\HallsController@addHall');
        Route::post('/edit-hall/{HallId}', 'Dash\HallsController@editHall');
        Route::delete('/delete-hall/{HallId}', 'Dash\HallsController@deleteHall');
        Route::get('/all-halls', 'Dash\HallsController@allHalls');
        Route::get('/single-hall/{HallId}', 'Dash\HallsController@singleHall');
    });
    Route::prefix('hall-manager')->group(function () {
        Route::post('/add-hall-manager', 'Dash\HallManagerController@addHallManager');
        Route::post('/edit-hall-manager/{HallManagerId}', 'Dash\HallManagerController@editHallManager');
        Route::delete('/delete-hall-manager/{HallManagerId}', 'Dash\HallManagerController@deleteHallManager');
        Route::get('/all-hall-managers', 'Dash\HallManagerController@allHallManagers');
        Route::get('/single-hall-manager/{HallManagerId}', 'Dash\HallManagerController@singleHallManager');
    });
    Route::prefix('event')->group(function () {
        Route::post('/add-event', 'Dash\EventsController@addEvent');
        Route::post('/edit-event/{EventId}', 'Dash\EventsController@editEvent');
        Route::delete('/delete-event/{EventId}', 'Dash\EventsController@deleteEvent');
        Route::get('/all-events', 'Dash\EventsController@allEvents');
        Route::get('/single-event/{EventId}', 'Dash\EventsController@singleEvent');
    });
    Route::prefix('organizer')->group(function () {
        Route::post('/add-organizer', 'Dash\OrganizerController@addOrganizer');
        Route::post('/edit-organizer/{OrganizerId}', 'Dash\OrganizerController@editOrganizer');
        Route::delete('/delete-organizer/{OrganizerId}', 'Dash\OrganizerController@deleteOrganizer');
        Route::get('/all-organizers', 'Dash\OrganizerController@allOrganizers');
        Route::get('/single-organizer/{OrganizerId}', 'Dash\OrganizerController@singleOrganizer');
    });
    Route::get('test-auth', 'Dash\DashAuthController@testAuth');
});


