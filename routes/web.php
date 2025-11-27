<?php

// Route::get('/','WebVerificationController@Home');

Route::get('/', function () {
    $url = 'https://panacea.live/renata';
    return Redirect::to($url);
});

Route::post('/codeverify', 'WebVerificationController@IsValidCode');
Route::post('/phoneverify', 'WebVerificationController@IsValidPhone');
Route::post('/livecheck', 'WebVerificationController@LiveCheck');
Route::post('/resendcode', 'WebVerificationController@ResendCode');

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});




// ========================================
// MUPS QR
// MUPS 40mg link
Route::redirect('/mups', '/MUPS');
Route::get('/MUPS', function () {
    $url = 'https://panacea.live/mups';
    return Redirect::to($url);
});
// ========================================




// =============================== Renata New 2022 ================
Route::get('/renata', 'RenataController@home');