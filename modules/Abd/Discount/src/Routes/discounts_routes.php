<?php
Route::group(["middleware" => "auth"], function ($router){
    $router->get("/discounts", "DiscountController@index")->name("discounts.index");


    //    $router->get('/discounts', [
//        "uses" => "DiscountController@index",
//        "as" => "discounts.index"
//    ]);
});
