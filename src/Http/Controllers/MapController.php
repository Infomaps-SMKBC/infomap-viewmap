<?php

namespace Infomap\Viewmap\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Infomap\Viewmap\Models\Layer;
use Infomap\Viewmap\Models\Property;
use Infomap\Viewmap\Models\PropertyDetails;
use Auth;
use Illuminate\Support\Facades\Cache;
use DataTables;
class MapController extends Controller
{
    public function viewmap(){
        return view('viewmap::admin.viewmap.viewmap');
    }

    public function getPropertycache(Request $request){
       $key=$request->ward.$request->ulb;
         $records = Cache::get('$key');
        if(empty($records)){
          
            // Cache the result of the query for 30 minutes
            $records = Cache::remember('$key', 30, function () use($request){
                return  Property::join('property_details','properties.id','property_details.property_id')
                ->where('properties.ward',$request->ward)
                ->where('properties.ulb_name',$request->ulb)
                ->select('property_details.mis_owner','properties.usage','property_details.tax_number','properties.topo_id','properties.construction','properties.id','properties.latlog')
                ->get();
            });
        
        }
              
        $json = [
                    'status'  => 200,
                    'message' => 'Properties data fetch.',
                    'data'    => !empty($records) ? $records : null
                ];

        return json_encode($json);
    }
    public function getProperty(Request $request){
        $column = $request->column;
         $records = Property::join('property_details','properties.id','property_details.property_id')
                ->where('properties.ward',$request->ward)
                ->where('properties.ulb_name',$request->ulb)
                ->select('property_details.mis_owner','properties.usage','property_details.tax_number','properties.topo_id','properties.construction','properties.id','properties.latlog','properties.nooffloor')
                ->get();

            if(isset($request->property)){
                $usage =$request->property;
			    $usagearray1 = explode(",",$usage);
                $records = $records->whereIn('usage',$usagearray1);
            }

            if(isset($request->constructions)){
                $constructions =$request->constructions;
			     $constructionsarray1 = explode(",",$constructions);
                $records = $records->whereIn('construction',$constructionsarray1);
            }
            if(isset($request->floor)){
                $data = explode(" ",$request->floor);
                 $data0 = $data[0];
                
                if($request->floor=='G'){
                    $floorData=$data0;  
                }else{
                    $data1 = $data[1];
                    $floorData=$data0."+".$data1;
                }
                 $records = $records->where('nooffloor',$floorData);
            }
            if(isset($request->services)){
                $records = $records->whereIn('construction',$request->services);
            }
                $json = [
                    'status'  => 200,
                    'message' => 'Properties data fetch.',
                    'data'    => !empty($records) ? $records : null
                ];
        return json_encode($json);
    }
    public function getWards(Request $request){
        $column = $request->column;
        return DB::table($request->table)->where($request->key2,$request->value2)->where($request->key,$request->value)->where($request->key1,$request->value1)->select($column)->get();
    }


    public function getPropertyModel(Request $request){
         $data =Property::leftJoin('property_details','properties.id','property_details.property_id')
                    ->where('properties.id',$request->id)
                    ->where('properties.ulb_name',$request->ulb)
                    ->where('properties.ward',$request->ward)
                    ->select('property_details.tax_number as tax_number','properties.topo_id',
                    'properties.ward','property_details.water_connection_no','property_details.ugd_conn_no'
                    ,'property_details.mis_owner','property_details.owner_mobile','properties.construction')
                    ->first();
       
        $html="<table class='table table-border'>
                        <tr>
                            <th>Topo ID </th>
                            <td>".$data->topo_id."</td>
                        </tr>
                        <tr>
                            <th>Ward No </th>
                            <td>".$data->ward."</td>
                        </tr>
                       <tr>
                            <th>Owner Name (English) </th>
                            <td>".$data->mis_owner."</td>
                        </tr>
                        <tr>
                            <th>Owner Name (Tamil) </th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Door No </th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Mobile No </th>
                             <td>".$data->owner_mobile."</td>
                        </tr>
                        <tr>
                            <th>Street Name </th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Assessment No. </th>
                            <td>".$data->tax_number."</td>
                        </tr>
                        <tr>
                            <th> UGD Conn. No </th>
                            <td>".$data->ugd_conn_no."</td>

                        </tr>

                        <tr>
                            <th>Water Conn. No </th>
                            <td>".$data->water_connection_no."</td>
                        </tr>
                        <tr>
                            <th>Building Usage(MIS) </th>
                            <td>".$data->usage."</td>
                        </tr>
                        <tr>
                            <th>Construction Type </th>
                            <td>".$data->Construction." </td>
                        </tr>
                        <tr>
                            <th>Building Usage (GIS) </th>
                            <td> </td>
                        </tr>
                        <tr>
                            <th> Building GIS Foot </br>
                                Print Area (Sq. Feet)
                            </th>
                            <td> </td>
                        </tr>
                        <tr>
                            <th> Building MIS Foot </br>
                                Print Area (Sq. Feet)
                            </th>
                            <td> </td>
                        </tr>
                        <tr>
                            <th>Floor </th>
                            <td> </td>
                        </tr>
                        <tr>
                            <th>EB Service Number </th>
                            <td> </td>
                        </tr>

                        <tr>
                            <th> Ration Card No. </th>
                            <td> </td>
                        </tr>

                        <tr>
                            <th> GST No. </th>
                            <td> </td>
                        </tr>

                        <tr>
                            <th> Trade License </th>
                            <td> </td>
                        </tr>

                        <tr>
                            <th> Professional Tax </th>
                            <td> </td>
                        </tr>

                        <tr>
                            <th> Prop. Tax Due </th>
                            <td> </td>
                        </tr>

                        <tr>
                            <th> Water Tax Due </th>
                            <td> </td>
                        </tr>

                        <tr>
                            <th> Other Tax Due</th>
                            <td> </td>
                        </tr>

                </table>
                   ";
        return $html;
    }

    // public function getPropertyViewModel11(Request $request){
    //     $records = Property::leftJoin('property_details','properties.id','property_details.property_id');
    //     if(isset($request->ulb)){
    //         $records = $records->where('properties.ulb_name',$request->ulb);
    //     }

    //     if(isset($request->ward)){
    //         $records = $records->where('properties.ward',$request->ward);
    //     }

    //     $records = $records
    //             ->select('properties.topo_id','properties.ward','properties.usage',
    //             'properties.construction','property_details.mis_owner','property_details.tax_number as tax_number',
    //             'property_details.water_connection_no','property_details.ugd_conn_no')
    //             ->paginate(10);
        
    //     $json = [
    //                 'status'  => 200,
    //                 'message' => 'Properties data fetch.',
    //                 'data'    => !empty($records) ? $records : null
    //             ];
    //     return json_encode($json);
        
    // }

    public function getLayer(Request $request){
        $records = Layer::select('main_layer')->groupBy('main_layer')->get();
        $html = '  <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
                    <svg xmlns="http://www.w3.org/2000/svg" height="20" width="22.5" viewBox="0 0 576 512">
                        <path fill="#fcfcfc" d="M264.5 5.2c14.9-6.9 32.1-6.9 47 0l218.6 101c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 149.8C37.4 145.8 32 137.3 32 128s5.4-17.9 13.9-21.8L264.5 5.2zM476.9 209.6l53.2 24.6c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 277.8C37.4 273.8 32 265.3 32 256s5.4-17.9 13.9-21.8l53.2-24.6 152 70.2c23.4 10.8 50.4 10.8 73.8 0l152-70.2zm-152 198.2l152-70.2 53.2 24.6c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 405.8C37.4 401.8 32 393.3 32 384s5.4-17.9 13.9-21.8l53.2-24.6 152 70.2c23.4 10.8 50.4 10.8 73.8 0z"/>
                    </svg>
                         Layer
                  </button>   
        <div class="dropdown-menu" style="height:500px; overflow-y:auto;">';
        foreach($records as $row){
            $html.='<a class="dropdown-item" href="#" style="color:red;text-align:center;"><b>'.$row['main_layer'].'</b></a>';
            
             $records=Layer::where('main_layer',$row->main_layer)->select('sub_layer')->groupBy('sub_layer')->get();
            foreach($records as $data){
                $utility = DB::table('utility')->where('ward',$request->ward)
                                ->where('ulb_name',$request->ulb_name)->where('category',$row->main_layer)
                                ->where('utility_name',$data->sub_layer)
                                ->groupBy('utility_name')->select('utility_name','id')->first();
                            
                if(!empty($utility)){
                     $html.='<a class="dropdown-item" href="#"> <input type="checkbox" name="layername"  id="layername'.$utility->id.'"  value="'.$utility->utility_name.'" onclick="showLayerMap('.$utility->id.')"/>
                             <label for="Layer" style="font-size:16px; color:black;">'.$data['sub_layer'].'</label>
                        </a>';
                }else{
                    $html.='<a class="dropdown-item" href="#"> <input type="checkbox" name="layername"    onclick="showLayerMap();" disabled/>
                             <label for="Layer" style="font-size:16px;color:#a5a4a4">'.$data['sub_layer'].'</label>
                        </a>';
                }
               
              
            }   
                       
        }
        $html.='<a class="dropdown-item" href="#"> <input type="checkbox" name="layername0" id="layername0" value="DroneImage"   onclick="showLayerMap(0);"/>
        <label for="Layer" style="font-size:16px;color:red;"><b>Drone/Satellite Image</b></label>
        </a>';  
        $html.='</div>';
        return $html;
    }

    public function getViewmapCount(Request $request){
     
        $array = array();
       $COMMERCIAL = Property::where('ulb_name',$request->ulb_name)->where('ward',$request->ward)->where('usage','COMMERCIAL')->count('id');
       $RESIDENTIAL =  Property::where('ulb_name',$request->ulb_name)->where('ward',$request->ward)->where('usage','RESIDENTIAL')->count('id');
       $MIXED_USE =  Property::where('ulb_name',$request->ulb_name)->where('ward',$request->ward)->where('usage','MIXED USE')->count('id');
       $RELIGIOUS =  Property::where('ulb_name',$request->ulb_name)->where('ward',$request->ward)->where('usage','RELIGIOUS')->count('id');
       $EDUCATIONAL =  Property::where('ulb_name',$request->ulb_name)->where('ward',$request->ward)->where('usage','EDUCATIONAL')->count('id');
       $GOVT_PROPERTY =  Property::where('ulb_name',$request->ulb_name)->where('ward',$request->ward)->where('usage','GOVT.PROPERTY')->count('id');
       $GOVT_BUILDING =  Property::where('ulb_name',$request->ulb_name)->where('ward',$request->ward)->where('usage','GOVT.BUILDING')->count('id');
       $VACANT_LAND =  Property::where('ulb_name',$request->ulb_name)->where('ward',$request->ward)->where('usage','VACANT LAND')->count('id');
       $OTHERS =  Property::where('ulb_name',$request->ulb_name)->where('ward',$request->ward)->where('usage','OTHERS')->count('id');
       $total_tax_paid =  Property::join('property_details','properties.id','property_details.property_id')
                                ->where('properties.ulb_name',$request->ulb_name)
                                ->where('properties.ward',$request->ward)
                                ->where('property_details.tax_number','!=','Na')->count('properties.id');
        $total_no_tax_paid =  Property::join('property_details','properties.id','property_details.property_id')
                                ->where('properties.ulb_name',$request->ulb_name)
                                ->where('properties.ward',$request->ward)
                                ->where('property_details.tax_number','=','Na')->count('properties.id');

      $data= array(
            'total_commercial'=>$COMMERCIAL,
            'total_residential'=>$RESIDENTIAL,
            'total_mixed_use'=>$MIXED_USE,
            'total_religious'=>$RELIGIOUS,
            'total_educational'=>$EDUCATIONAL,
            'total_govt'=>$GOVT_PROPERTY+$GOVT_BUILDING,
            'total_vaant_lant'=>$VACANT_LAND,
            'total_others'=>$OTHERS,
            'total_tax_paid'=>$total_tax_paid,
            'total_no_tax_paid'=>$total_no_tax_paid
       );

       return json_encode($data);
    }

    //for Data insert in property and properties table form old building table
    public function getBuildtoproperty(){
        $records = DB::table('builduing')->get();
        foreach($records as $data){
            $pro = new Property();
            $pro->ulb_name = $data->ulbname;
            $pro->topo_id = $data->Topo_id;
            $pro->street_id = $data->street_id;
            $pro->property_name = $data->Building_name;
            $pro->property_shape = $data->Building_shape;
            $pro->construction = $data->Construction;
            $pro->area_name = $data->area_name;
            $pro->ward = $data->ward;
            $pro->latlog = $data->latlong;
            $pro->usage = $data->usage;
            $pro->created_by = Auth()->user()->id;
            $pro->save();
            $id = $pro->id;

            $prod = new PropertyDetails();
            $prod->property_id = $id;
            $prod->topo_id=$data->Topo_id;
            $prod->gis_owner = $data->Owner_Name;
            $prod->mis_owner = $data->Owner_Name;
            $prod->tax_number=$data->New_Asses;
            $prod->water_connection_no=$data->waterconn_no;
            $prod->ugd_conn_no=$data->ugdconn_no;
            $prod->tax_amount=$data->tottaxdue;
            $prod->topo_id=$data->Topo_id;
            $prod->created_by = Auth()->user()->id;
            $prod->save();            
        }
    }

    public function getPropertyViewModel(Request $request){
        if ($request->ajax()) {
            $data =Property::leftJoin('property_details','properties.id','property_details.property_id')
                   ->where('properties.ulb_name',$request->ulb)->where('properties.ward',$request->ward)
                   ->select('properties.topo_id','properties.ward','properties.usage',
                'properties.construction','property_details.mis_owner','property_details.tax_number as tax_number',
                'property_details.water_connection_no','property_details.ugd_conn_no')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
        
    }

    public function getPOIMap(Request $request){
         $request->all();

        if($request->utility_name!='')
            {
                $utility =$request->utility_name;
                $utilityarray1 = explode(",",$utility);
               
            }
            else
            {
                $utilityarray1='';
            }

            return $records  = DB::table('utility')
            ->where('ulb_name',$request->ulb_name)
            ->where('ward',$request->ward)
            ->whereIn('Utility_Name',$utilityarray1)
            ->select('X','Y','Utility_Name','id','ward','capacity_unit','utilitynaming','fulldetails')
            ->get();
    }

    public function getSSDMap(Request $request){
        return $records  = DB::table('manhole_line')
           ->where('ulb_name',$request->ulb_name)
           ->where('ward',$request->ward)     
           ->select('latlog','ward', 'poly_id', 'pipe_dia', 'length', 'name')
           ->get();
   }


   public function getculvertMap(Request $request){

        return $records  = DB::table('manhole_line')
        ->where('ulb_name',$request->ulb_name)
        ->where('ward',$request->ward)
        ->select('latlog','ward', 'poly_id', 'pipe_dia', 'length')
        ->get();
    }

    public function getmanholesMap(Request $request){
            return $records  = DB::table('manhole_data')
            ->where('ulb_name',$request->ulb_name)
            ->where('ward',$request->ward)
            ->select('X','Y','ward','manhole_no')
            ->get();
    }
    
    public function getugd(Request $request){
            return $records  = DB::table('ugddata')
                ->where('ulb_name',$request->ulb_name)
                ->where('ward',$request->ward)
                ->get();
    }

    public function getRoadDetails(Request $request){
        $records  = DB::table('road_details')
                        ->where('ulb_name',$request->ulb)
                        ->where('ward',$request->ward)
                        ->select('latlog','id','street_name','road_type','ward','distance_m','distance_k','road_width','mainroadid')
                        ->get();
        if(isset($request->roadType) && $request->roadType!=NULL){
            $roadType =$request->roadType;
            $roadTypeArray1 = explode(",",$roadType);
            $records = $records->whereIn('road_type',$roadTypeArray1);
        }
        if(isset($request->street_name) && $request->street_name!=NULL){
            $roadType =$request->street_name;
            // $roadTypeArray1 = explode(",",$roadType);
            return $records = $records->where('street_name',$roadType);
        }
        return $records;
    }
  
    //====================Start Property Details in List ============================================================
    public function getProFetch(Request $request){
       $data =Property::join('property_details','properties.id','property_details.property_id')
                        ->where('properties.ulb_name',$request->ulb_name)->where('properties.ward',$request->ward)
                        ->select('properties.topo_id','properties.ward','properties.usage',
                        'properties.construction','property_details.mis_owner','property_details.tax_number as tax_number',
                        'property_details.water_connection_no','property_details.ugd_conn_no')->paginate(20);  
       $html=' <div class="table-responsive">
       <table clas="table table-responsive table-hover">
             <thead>
                    <tr class="th_header">
                        <th>S.No.</th>
                        <th>Tax No.</th>
                        <th>Topo ID</th>
                        <th>Ward No</th>
                        <th>Owner Name</th>
                        <th>Property Type</th>
                        <th>Construction</th>
                        <th>Water Conn.</th>
                        <th>UGD Conn. </th>
                    </tr>
                </thead>
                <tbody>

       ';
        $i=1;
        foreach($data as $row){
            $html.="<tr>";
            $html.="<td>".$i++."</td>";
            $html.="<td>".$row->tax_number."</td>";
            $html.="<td>".$row->topo_id."</td>";
            $html.="<td>".$row->ward."</td>";
            $html.="<td>".$row->mis_owner."</td>";
            $html.="<td>".$row->usage."</td>";
            $html.="<td>".$row->construction."</td>";
            $html.="<td>".$row->water_connection_no."</td>";
            $html.="<td>".$row->ugd_conn_no."</td>";
            $html.="</tr>";
        } 
        $pagi= $data->links();
        $html.='</tbody>
                </table>
                <div style="float:right;">';
        $html.=$pagi;
        $html.="</div></div>";
        return  $html;
    }
  //====================End Property Details in List ============================================================
 
  //========================Start Layer Map filter ========================================================================
  public function layerMap(Request $request){
    $ward = $request->ward;
    $ulb_name= $request->ulb_name;
    $layername= $request->layername;
    if($layername=='DroneImage'){
        $records = DB::table('wards')->where('ward',$ward)->where('ulb_name',$ulb_name)->select('drone_image')->first();
        $feature_type = array('layergroup'=>'','layercolor'=>'');
        $data = array('data'=>$records,'feature_type'=>$feature_type,'layergroup'=>$layername);
        return json_encode($data);
    }
    $records = DB::table('utility')
                ->where('ward',$ward)
                ->where('ulb_name',$ulb_name)
                ->where('utility_name',$layername)
                ->select('X','Y','ward','utility_name','utilitynaming','latlog')
                ->get();

    $feature_type = DB::table('utility')->where('ward',$ward)->where('ulb_name',$ulb_name)->where('utility_name',$layername)->select('feature_type')->first();
    $layergroup =DB::table('layers')->where('sub_layer',$layername)->select('layergroup','layercolor')->first();

    $data = array('data'=>$records,'feature_type'=>$feature_type,'layergroup'=>$layergroup);
    return json_encode($data);
  }
 //========================End Layer Map filter ========================================================================


 //================================= Start Floor Records ===============================================================
  public function getFloorRegords(Request $request){
    $ward = $request->ward;
    $ulb_name= $request->ulb_name;
    $floor = $request->floor;
    if($floor!='')
	{
        
    }else{
        $Floor='';
	}
  } 
 //================================= Start Floor Records ===============================================================


}
