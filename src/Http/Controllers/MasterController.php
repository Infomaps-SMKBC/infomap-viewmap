<?php

namespace Infomap\Viewmap\Http\Controllers;

use Illuminate\Http\Request;
use Infomap\Viewmap\Models\Ward;
use DB;
class MasterController extends Controller
{
    public function getWardAll(Request $request){
        
        if(isset($request->ulb)){
           $records = Ward::where('ulb_name',$request->ulb)->select('ward','latlog','ulb_name')->get();
        

            if($request->ward!='' &&  $request->ward!='null'){
                 $records = $records->where('ward',$request->ward);
            }

            return $records ;
        }
    }



    public function getPOI(Request $request){
        $records  = DB::table('utility')
                    ->where('ulb_name',$request->ulb_name)
                    ->where('ward',$request->ward)->where('pointtype','poi')
                    ->where('Utility_Name','!=','Manhole')
                    ->groupBy('Utility_Name')->orderBy('Utility_Name','ASC')->select('Utility_Name')->get();
       $html='';
       foreach($records as $row)
       {
        $count = DB::table('utility') ->where('ulb_name',$request->ulb_name)->where('ward',$request->ward)->where('Utility_Name',$row->Utility_Name)->count();
        $html.='<option value="'.$row->Utility_Name.'">'.$row->Utility_Name.'('.$count.')</option>';
       }
       return $html;
    }




    public function getUtility(Request $request){
        $records  = DB::table('utility')
                     ->where('ulb_name',$request->ulb_name)
                     ->where('ward',$request->ward)
                     ->whereNotIn('feature_type',['polyline','polygon'])
                     ->where('pointtype','utility')
                     ->groupBy('Utility_Name')
                     ->orderBy('Utility_Name','ASC')
                     ->select('Utility_Name')
                     ->get();
        $html='';
        foreach($records as $row)
        {
         $count = DB::table('utility') ->where('ulb_name',$request->ulb_name)->where('ward',$request->ward)->where('Utility_Name',$row->Utility_Name)->count();
         $html.='<option value="'.$row->Utility_Name.'">'.$row->Utility_Name.'('.$count.')</option>';
        }
        return $html;
     }

    public function getPropertySelect(Request $request){
         $request->all();
        $records  = DB::table('properties')
                     ->where('ulb_name',$request->ulb_name)
                     ->where('ward',$request->ward)
                     ->select('usage')
                     ->groupBy('usage')
                     ->get();
        $html='';
        foreach($records as $row)
        {
         $count = DB::table('properties') ->where('ulb_name',$request->ulb_name)->where('ward',$request->ward)->where('usage',$row->usage)->count();
         $html.='<option value="'.$row->usage.'">'.$row->usage.'('.$count.')</option>';
        }
        return $html;
     }

    public function getConstructionSelect(Request $request){
        $request->all();
       $records  = DB::table('properties')
                    ->where('ulb_name',$request->ulb_name)
                    ->where('ward',$request->ward)
                    ->select('construction')
                    ->groupBy('construction')
                    ->get();
       $html='';
       foreach($records as $row)
       {
        $count = DB::table('properties') ->where('ulb_name',$request->ulb_name)->where('ward',$request->ward)->where('construction',$row->construction)->count();
        $html.='<option value="'.$row->construction.'">'.$row->construction.'('.$count.')</option>';
       }
       return $html;
    }

    // ==============Start Road Select Option=======================================================

    public function getRoadSelect(Request $request){
        $records  = DB::table('road_details')
                    ->where('ulb_name',$request->ulb_name)
                    ->where('ward',$request->ward)
                    ->groupBy('road_type')->orderBy('road_type','ASC')->select('road_type')->get();
       $html='';
       foreach($records as $row)
       {
        $html.='<option value="'.$row->road_type.'">'.$row->road_type.'</option>';
       }
       return $html;
    }

    //======================End Road Select Option=================================================

    // ==============Start Street Name Select Option=======================================================

    public function getStreetSelect(Request $request){
        $records  = DB::table('road_details')
                    ->where('ulb_name',$request->ulb_name)
                    ->where('ward',$request->ward)
                    ->groupBy('street_name')->orderBy('street_name','ASC')->select('street_name')->get();
       $html='';
       foreach($records as $row)
       {
        $html.='<option value="'.$row->street_name.'">'.$row->street_name.'</option>';
       }
       return $html;
    }

    //======================End Street Name Select Option================================================


     // ==============Start Street Name Select Option=======================================================

     public function getWardSelect(Request $request){
        $records  = DB::table('wards')
                    ->where('ulb_name',$request->ulb_name)
                    ->groupBy('ward')->orderBy('ward','ASC')->select('ward')->get();
       $html='';
       foreach($records as $row)
       {
        $html.='<option value="'.$row->ward.'">'.$row->ward.'</option>';
       }
       return $html;
    }

    //======================End Street Name Select Option================================================

}
