<?php
use App\Http\Controllers\ace\StuffController;
Route::controller(StuffController::class)->group(function () {
    Route::get('/back/announcements', 'announcement')->name('staff.announcements');
    Route::post('/back/login', 'login')->name('staff.login');
    Route::post('/back/staff/resetpasswordstaff', 'resetpass')->name('staff.resetpass');
    Route::post('/back/update', 'update')->name('staff.update');
    Route::post('/back/update/pass', 'updatepassword')->name('staff.update.password');
    Route::get('/back/detailannouncements/{id}', 'detailannouncement')->name('staff.detailannouncements');
    Route::get('/back/handbook', 'handbook')->name('staff.handbook');
    Route::get('/back/detailhandbook/{id}', 'detailhandbook')->name('staff.detailhandbook');
    Route::get('/back/Anti-Bribery and Corruption Policy', 'anti')->name('staff.anti');
    Route::get('/back/Ethics and Compliance Whistleblowing Policy and Procedures', 'ethic')->name('staff.ethic');
    Route::get('/back/setting', 'setting')->name('staff.setting');
    Route::get('/back/logoutstuff', 'logoutstuff')->name('staff.logoutstuff');
    Route::get('/back/nextannouncement/{date}', 'nextannouncement')->name('staff.next.announcement');
    Route::get('/back/backannouncement/{date}', 'backannouncement')->name('staff.back.announcement');
    Route::get('/back/loginstaff', 'loginview')->name('staff.loginback');
    Route::post('/back/resetpassword', 'resetpassword')->name('staff.resetconfir');
    Route::post('/back/agreestaff', 'agreestaff')->name('agree.staff');

});


