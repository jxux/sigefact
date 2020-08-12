<?php

$hostname = app(Hyn\Tenancy\Contracts\CurrentHostname::class);

if($hostname) {
    Route::domain($hostname->fqdn)->group(function () {
        Route::middleware(['auth', 'locked.tenant'])->group(function() {


            Route::get('categories', 'CategoryController@index')->name('tenant.categories.index')->middleware('redirect.level');
            Route::get('categories/records', 'CategoryController@records');
            Route::get('categories/columns', 'CategoryController@columns');
            Route::get('categories/record/{category}', 'CategoryController@record');
            Route::post('categories', 'CategoryController@store');
            Route::delete('categories/{category}', 'CategoryController@destroy');

            Route::get('brands', 'BrandController@index')->name('tenant.brands.index')->middleware('redirect.level');
            Route::get('brands/records', 'BrandController@records');
            Route::get('brands/record/{brand}', 'BrandController@record');
            Route::post('brands', 'BrandController@store');
            Route::get('brands/columns', 'BrandController@columns');
            Route::delete('brands/{brand}', 'BrandController@destroy');

            Route::get('incentives', 'IncentiveController@index')->name('tenant.incentives.index')->middleware('redirect.level');
            Route::get('incentives/records', 'IncentiveController@records');
            Route::get('incentives/record/{incentive}', 'IncentiveController@record');
            Route::post('incentives', 'IncentiveController@store');
            Route::get('incentives/columns', 'IncentiveController@columns');
            Route::delete('incentives/{incentive}', 'IncentiveController@destroy');

            Route::get('items/barcode/{item}', 'ItemController@generateBarcode');

            Route::post('items/import/item-price-lists', 'ItemController@importItemPriceLists');

            Route::prefix('lines')->group(function() {
                Route::get('', 'LineController@index')->name('tenant.lines.index');
                Route::get('records', 'LineController@records');
                Route::get('columns', 'LineController@columns');
                Route::get('record/{id}', 'LineController@record');
                Route::post('', 'LineController@store');
                Route::delete('{id}', 'LineController@destroy');
            });

            Route::prefix('families')->group(function() {
                Route::get('', 'FamilyController@index')->name('tenant.families.index');
                Route::get('records', 'FamilyController@records');
                Route::get('columns', 'FamilyController@columns');
                Route::get('record/{id}', 'FamilyController@record');
                Route::post('', 'FamilyController@store');
                Route::delete('{id}', 'FamilyController@destroy');
            });

        });
    });
}
