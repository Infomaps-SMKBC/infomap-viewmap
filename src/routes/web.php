<?php

use Infomap\Viewmap\Http\Controllers\MapController;
use Infomap\Viewmap\Http\Controllers\AdminController;
use Infomap\Viewmap\Http\Controllers\CaptchaController;
use Infomap\Viewmap\Http\Controllers\MasterController;

Route::group(['prefix'=>'admin','as'=>'admin.'], function(){

    Route::get('/view-map', [MapController::class,'viewmap'])->name('viewmap');
    //master route
    Route::get('/common-get-select', [AdminController::class, 'getSelectOption']);

    Route::get('/common-get-select2', [AdminController::class, 'getSelectOption2'])->name('getSelectOption2');

    Route::get('/common-get-single', [AdminController::class, 'getValueStatic2']);

    //master get single row value
    Route::get('/get-single-row-value', [AdminController::class, 'getsingleRowValue'])->name('getsingleRowValue');

    //master get table value
    Route::get('/get-table', [AdminController::class, 'getRecords'])->name('getRecords');

    //master get table value with condtion
    Route::get('/get-table-with-contions', [AdminController::class, 'getRecords2'])->name('getRecordContions');

    //master get table value with condtion
    Route::get('/get-select-with-contions', [AdminController::class, 'getSelectWhere'])->name('getSelectWhere');
    
    //master get table value with condtion
     Route::get('/get-select-single-column-with-id', [AdminController::class, 'getsinglecolumnValuewithId'])->name('getsinglecolumnValuewithId');
     //master get table value with condtion
     Route::get('/get-select-column-with-table', [AdminController::class, 'getsinglecolumnValueWithTable'])->name('getsinglecolumnValueWithTable');
    
         //master get table value with condtion
    Route::get('/get-select-with-contions-two', [AdminController::class, 'getSelectWhereTwo'])->name('getSelectWhereTwo');

     //master get table value with condtion
     Route::get('/get-select-single-column-with-id2', [AdminController::class, 'getsinglecolumnValuewithIdtwo'])->name('getsinglecolumnValuewithIdtwo');

     //master get table value with condtion
     Route::get('/get-select-single-column-with-id3', [AdminController::class, 'getsinglecolumnValuewithId3'])->name('getsinglecolumnValuewithId3');

    //get all ward data for viewmap filter
    Route::get('/get-wards-records', [MasterController::class, 'getWardAll'])->name('getWardAll');


    //property data
    Route::get('/get-property-records', [MapController::class, 'getProperty'])->name('getProperty');
    Route::get('/get-property-for-model', [MapController::class, 'getPropertyModel'])->name('getPropertyModel');
    Route::get('/get-property-for-view-model', [MapController::class, 'getPropertyViewModel'])->name('getPropertyViewModel');
    Route::get('/get-layer', [MapController::class, 'getLayer'])->name('getLayer');
    Route::get('/get-viewmap-count', [MapController::class, 'getViewmapCount'])->name('getViewmapCount');
    //Route::get('/insert', [MapController::class, 'getBuildtoproperty'])->name('getBuildtoproperty');

    //get poi all data
    Route::get('/get-poi-records', [MasterController::class, 'getPOI'])->name('getPOI');
    //get Utility all data
    Route::get('/get-utility-records', [MasterController::class, 'getUtility'])->name('getUtility');

    //get Utility all data
    Route::get('/get-poi-mapshow', [MapController::class, 'getPOIMap'])->name('getPOIMap');

    //get SSD all data
    Route::get('/get-ssd-mapshow', [MapController::class, 'getSSDMap'])->name('getSSDMap');

    //get Culvert show in map
    Route::get('/get-culvert-mapshow', [MapController::class, 'getculvertMap'])->name('getculvertMap');

    //get manhole show in map
    Route::get('/get-manhole-mapshow', [MapController::class, 'getmanholesMap'])->name('getmanholesMap');

    //get manhole show in map
    Route::get('/get-ugd-mapshow', [MapController::class, 'getugd'])->name('getugd');

    //get property select show in map
    Route::get('/get-property-select', [MasterController::class, 'getPropertySelect'])->name('getPropertySelect');
    
    //get contruction show in map
    Route::get('/get-construction-select', [MasterController::class, 'getConstructionSelect'])->name('getConstructionSelect');

    //get Roads Select in map
    Route::get('/get-road-select', [MasterController::class, 'getRoadSelect'])->name('getRoadSelect');

    //get Roads Select in map
    Route::get('/get-road-details', [MapController::class, 'getRoadDetails'])->name('getRoadDetails');

    //get ward Select  
    Route::get('/get-wards', [MasterController::class, 'getWardSelect'])->name('getWardSelect');

    //get Street Select  
    Route::get('/get-streets', [MasterController::class, 'getStreetSelect'])->name('getStreetSelect');

    //get properties details fetch  
    Route::get('/get-buidling-fetch', [MapController::class, 'getProFetch'])->name('getProFetch');

    //get Layer show in map 
    Route::get('/get-layer-may', [MapController::class, 'layerMap'])->name('layerMap');
    //clear cache config view
    Route::get('/clear', function() {

        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('config:cache');
        Artisan::call('view:clear');
     
        return "Cleared!";
     
     });
     
      //get Layer show in map 
    Route::get('/get-floor-records', [MapController::class, 'getFloorRegords'])->name('getFloorRegords');

   });

?>