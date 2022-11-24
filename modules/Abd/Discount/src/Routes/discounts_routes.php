<?php
Route::group(["middleware" => "auth"], function ($router){
    $router->get("/discounts", "DiscountController@index")->name("discounts.index");
    $router->post("/discounts", "DiscountController@store")->name("discounts.store");


    //    $router->get('/discounts', [
//        "uses" => "DiscountController@index",
//        "as" => "discounts.index"
//    ]);
});
