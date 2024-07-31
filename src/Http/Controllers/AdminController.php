<?php

namespace Infomap\Viewmap\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Captcha;
use DB;

class AdminController extends Controller
{
    public function login(){
        if(isset(Auth::user()->id)){
            return redirect(route('admin.dashboard'));
        }else{
            return view('login'); 
        }
    }

    public function login_post(Request $request){
        //return $request->all();
        $credentials = $request->validate([
            'user_name' => ['required','max:30'],
            'password' => ['required','max:50'],
        ]);

        if (Auth::attempt(['user_name' => $request->user_name,'password' => $request->password, 'status' => 0])) {
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'user_name' => 'The provided credentials do not match our records.',
        ]);

    }

    //rediect to Dashbaord
    public function dashboard(){
        return view('viewmap::admin.dashboard.dashboard');
    }

    // for logut
    public function logout(){
        Auth::logout();
        return redirect(route('login'));
    }

    //create captch
    public function reloadCaptch(){
        if (request()->getMethod() == 'POST') {
            $rules = ['captcha' => 'required|captcha'];
            $validator = validator()->make(request()->all(), $rules);
            if ($validator->fails()) {
                echo '<p style="color: #ff0000;">Incorrect!</p>';
            } else {
                echo '<p style="color: #00ff30;">Matched :)</p>';
            }
        }
    
        $form = '<form method="post" action="captcha-test">';
        $form .= '<input type="hidden" name="_token" value="' . csrf_token() . '">';
        $form .= '<p>' . Captcha::src('default') . '</p>';
        $form .= '<p><input type="text" name="captcha"></p>';
        $form .= '<p><button type="submit" name="check">Check</button></p>';
        $form .= '</form>';
        return $form;
    }
    




    public static function getValueStatic2($table,$column,$key,$value)
    {
         $result = DB::select("SELECT ".$column." FROM ".$table." WHERE ".$key." = ".$value);
         if(empty($result)) { return ''; } else { return $result[0]->$column; }
      
    }


    public static function getSelectOption(Request $request){
        $table = $request->table;       
        $id = $request->id;
        $key = $request->key;
        $value = $request->value;    
        $column = $request->column;

        $companyId = $this->companyId;
        $condition = array('companyId'=>$companyId, $key=>$value);

        $collection=DB::table($table)->where($condition)->get();
        $select_option='';
        $select_option.="<option value='' selected>Select</option>";
        foreach ($collection as $row) {
            $select_option.="<option value='".$row->$id."'>".$row->$column."</option>";
        }
        return $select_option;
    
    }

    public function getSelectOption2(Request $request){
        $table = $request->table;       
        $id = $request->id;        
        $column = $request->column;            
        $collection=DB::table($table)->where('status',0)->get();
        $select_option='';
        $select_option.="<option value='' >Select</option>";
        foreach ($collection as $row) {
            $select_option.="<option value='".$row->$id."'>".$row->$column."</option>";
        }
        return $select_option;    
    
    }


    public function getSelectWhere(Request $request){
        $table = $request->table;       
        $id = $request->id;        
        $column = $request->column;
        $key=$request->key;
        $value=$request->value;            
        $collection=DB::table($table)->where('status',0)->where($key,$value)->select('id',$column)->get();
        $select_option='';
        $select_option.="<option value='All' >All</option>";
        foreach ($collection as $row) {
            $select_option.="<option value='".$row->$id."'>".$row->$column."</option>";
        }
        return $select_option;    
    
    }

    public static function getRecords($table,$key,$id){

        return DB::table($table)
                 ->where($key,$id)
                 ->get();
     }
 
    public static function getRecords2($table,$key,$id,$key2,$value){
 
         return DB::table($table)
                  ->where($key,$id)
                  ->where($key2,$value)
                  ->get();
    }

    public function getsingleRowValue(Request $request){
        return DB::table($request->table)->where($request->key,$request->value)->first();
    }

    public function getsinglecolumnValuewithId(Request $request){
       // $column = "'".$request->column."'";
        $column = $request->column;
        return DB::table($request->table)->where($request->id,$request->value)->select($column)->get();
    }

    public function getsinglecolumnValuewithIdtwo(Request $request){
        // $column = "'".$request->column."'";
         $column = $request->column;
         return DB::table($request->table)->where($request->key,$request->value)->where($request->key1,$request->value1)->select($column)->get();
     }


     public function getsinglecolumnValuewithId3(Request $request){
        // $column = "'".$request->column."'";
         $column = $request->column;
         return DB::table($request->table)->where($request->key,$request->value)->where($request->key1,$request->value1)->select($column)->get();
     }

    public function getsinglecolumnValueWithTable(Request $request){
        // $column = "'".$request->column."'";
         $column = $request->column;
         return DB::table($request->table)->select($column)->get();
     }

     public function getSelectWhereTwo(Request $request){
        $table = $request->table;       
        $id = $request->id;        
        $column = $request->column;
        $key=$request->key;
        $value=$request->value;  
        $key1=$request->key1;
        $value1=$request->value1;            
        $collection=DB::table($table)->where($key,$value)->where($key1,$value1)->select($column)->groupBy($column)->get();
        $select_option='';
        $select_option.="<option value='All' >All</option>";
        foreach ($collection as $row) {
            $select_option.="<option value='".$row->$column."'>".$row->$column."</option>";
        }
        return $select_option;    
    
    }
}
