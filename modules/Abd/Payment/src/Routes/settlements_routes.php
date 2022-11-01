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
    $router->get('/settlements/{settlement}/edit', [
        "uses" => "SettlementController@edit",
        "as" => "settlements.edit"
    ]);
    $router->patch('/settlements/{settlement}', [
        "uses" => "SettlementController@update",
        "as" => "settlements.update"
    ]);
    $router->get('/settlements', [
        "uses" => "SettlementController@index",
        "as" => "settlements.index"
    ]);
});
