<?php
Route::group(['middleware'=>'auth'], function ($router) {
    $router->get('/settlements/create', [
        "uses" => "SettlementController@create",
        "as" => "settlements.create"
    ]);
    $router->post('/settlements/store', [
        "uses" => "SettlementController@store",
        "as" => "settlements.store"
    ]);
    $router->get('/settlements', 'SettlementController@index')->name('settlements.index');
});
