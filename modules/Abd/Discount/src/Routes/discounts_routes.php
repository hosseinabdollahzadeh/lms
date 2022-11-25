<?php
Route::group(["middleware" => "auth"], function ($router){
    $router->get("/discounts", "DiscountController@index")->name("discounts.index");
    $router->post("/discounts", "DiscountController@store")->name("discounts.store");
    $router->delete("/discounts/{discount}", "DiscountController@destroy")->name("discounts.destroy");
    $router->get("/discounts/{discount}/edit", "DiscountController@edit")->name("discounts.edit");
    $router->patch("/discounts/{discount}", "DiscountController@update")->name("discounts.update");


    //    $router->get('/discounts', [
//        "uses" => "DiscountController@index",
//        "as" => "discounts.index"
//    ]);
});
