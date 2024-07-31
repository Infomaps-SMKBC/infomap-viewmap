@extends('viewmap::admin.viewmap.app')
@section('body')

@include('viewmap::admin.viewmap.style')
<div class="filter flt">
    <div class="row m-1 d-flex justify-content-around" style="padding-right: 30px;">
    
            <div class="form-group col-md-1 col-6">
                <label for="inputEmail4">Country</label>
                <select id="country"  name="country" class="form-control js-example-basic-single" onChange="getStates();">
                    <option value="">Country...</option>
                </select>
            </div>


            <div class="form-group col-md-1 col-6">
                <label for="inputEmail4">State</label>
                <select id="state"  name="state" class="form-control js-example-basic-single" onChange="getDistricts();">
                    <option value="">State...</option>
                </select>
            </div>

            <div class="form-group col-md-1 col-6">
                <label for="inputEmail4">District</label>
                <select id="district"  name="district" class="form-control js-example-basic-single" onChange="getTahsil();">
                    <option value="">District...</option>
                </select>
            </div>
            <div class="form-group col-md-1 col-6">
                <label for="inputEmail4">Tahsil</label>
                <select id="tahsil"  name="tahsil" class="form-control js-example-basic-single" onChange="getBlock();">
                    <option value="">Tahsil...</option>
                </select>
            </div>
            <div class="form-group col-md-1 col-6">
                <label for="inputEmail4">Block</label>
                <select id="block"  name="block" class="form-control js-example-basic-single" onchange="getULB();">
                    <option value="">Block...</option>
                </select>
            </div>
            <div class="form-group col-md-1 col-6">
                <label for="inputEmail4">ULB</label>
                <select id="ulb"  name="ulb" class="form-control js-example-basic-single" onchange="getULBlatLog(); getWard();getWardlatLog();" >
                    <option value="">ULB...</option>
                </select>
            </div>
            <div class="form-group col-md-1 col-6">
                <label for="inputEmail4">Ward</label>
                <select id="ward"  name="ward" class="form-control js-example-basic-single" onchange="getWardlatLog();getPropertylatLog(); getRoadlatLog(); poi();" >
                    <option value="">Ward...</option>
                </select>
            </div>
            
            <div class="form-group col-md-1 col-6">
                <label for="inputEmail4">Street</label>
                <select id="street"  name="street" class="form-control js-example-basic-single" onchange="getStreetMap();">
                    <option value="">Street...</option>
                </select>
            </div>
    </div>

    <div class="filter2" style="display: none;" >
        <div class="row divFilter" style="padding-left:40px;padding-right: 70px;">
                <select id="poi" name="poi[]" multiple class="form-control getPOIMap" onchange="getPOIMap();">
            </select>
                <select id="utility" name="utility[]" multiple class="form-control utility"  onchange="getUtitlityMap();">
            </select>
            <select id="property" name="property[]" multiple class="form-control"  onchange="getpropertyMap();">
            </select>
            <select id="constructions" name="constructions[]" multiple class="form-control"  onchange="getConstructionsMap();">
            </select>
            <select id="roads" name="roads[]" multiple class="form-control"  onchange="getRoadsMap();">
            </select>
            <div class="col-2" style="display: none">
                    <select id="services" name="services"  onChange="getServices();" class="form-control js-example-basic-single floor">                                                    
                        <option value="">-Services-</option>
                        <option value="one">Property Tax No Due </option>
                        <option value="two">Property Tax Due Less Than-20K </option>
                        <option value="three">Property Tax Due 20-50K </option>
                        <option value="four">Property Tax Due 50-100K </option>
                        <option value="five">Property Tax Due Above 100K </option>
                    </select>
                </div>
                <div class="col-1">
                    <select id="floor" name="floor" class="form-control js-example-basic-single floor" onChange="getFloorRecord();">
                        <option value="">-Floor-</option>
                        <option value="Basement">Basement</option>
                        <option value="G">G</option>
                        <option value="G+1">G+1</option>
                        <option value="G+2">G+2</option>
                        <option value="G+3">G+3</option>
                        <option value="G+4">G+4</option>
                        <option value="G+5">G+5</option>
                        <option value="G+6">G+6</option>
                        <option value="G+7">G+7</option>
                        <option value="G+8">G+8</option>
                    </select>
                </div>
                <div class="col-1">
                    <button type="button" class="btn dropdown-toggle draingeCss" data-toggle="dropdown">
                        Drainage
                    </button>
                    <div class="dropdown-menu" style="weight:100%; overflow-y:auto;">
                        <ul style="list-style-type: none; margin-left: 10px;padding: 0;">  
                        <li><input type="checkbox" id="SSD" name="SSD" value="SSD" onchange="getmanholeline();"><label for="SSD"> SSD</label> </li>
                        <li><input type="checkbox" id="culvert" name="culvert" value="Culvert" onClick="getculvert();"> <label for="Culvert"> Culvert</label></li>
                    </ul>
                    <ul style="list-style-type: none; margin-left: 10px;padding: 0;">

                        <li><input type="checkbox" id="manholes" name="manholes" value="Manholes" onClick="getmanhole();" value="Manholes"><label for="Manholes"> Manholes</label> </li>
                        <li><input type="checkbox" id="ugd" name="ugd" value="UGD" onClick="getugd();" > <label for="UGD"> UGD</label></li>
                    </ul>
                    </div>
                </div>
            
            <div class="col-1" style="display: none">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    Water Supply
                </button>
                <div class="dropdown-menu" style="width:100%; overflow-y:auto;">
                    <ul style="list-style-type: none; margin-left: 10px;padding: 0;">
                        <li><input type="checkbox" id="WaterSupply" name="WaterSupply" value="WaterSupply" onClick="getwaterSupply();"> <label for="WaterSupply">Water Supply</label> </li>
                        <li><input type="checkbox" id="Borewell" name="Borewell" value="Borewell" onClick="getutilityBore();"><label for="Borewell"> Borewell </label>  </a></li>
                    </ul>
                </div>
            
            </div>

            <div class="col-1" style="display: none">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    Project Status
                </button>
                <div class="dropdown-menu" style="width:100%; overflow-y:auto;">
                    <ul style="list-style-type: none; margin-left: 10px;padding: 0;">
                        <li><input type="checkbox" id="pendingproject" name="pendingproject" onClick="getpendingProject('Pending');"> <label for="pendingproject"> Pending</label></li>
                        <li><input type="checkbox" id="approved" name="approved" onClick="getapproveProject('Approved');"> <label for="approved">Approved </label> </li>
                        <li><input type="checkbox" id="WIP" name="WIP" onClick="getwipProject('WIP');"> <label for="wip">WIP </label> </li>
                        <li><input type="checkbox" id="completed" name="completed" onClick="getcompletedProject('Completed');">  <label for="completed"> Completed</label> </li>
                    </ul>

                </div>
            </div>

        </div>    
        <div class="row m-4 divFilter  justify-content-around" style="display: none;">
            <button class="btn btn-warning"> <b><i class="bi bi-buildings"></i> <span class="total_commercial"></span> Commercial</b></button>
            <button class="btn btn-success ml-1 fw-bold"> <b><i class="bi bi-houses"></i> <span class="total_residential"></span> Residential </b></button>
            <button class="btn btn-info ml-1"> <b> <i class="bi bi-list-check"></i> <span class="total_mixed_use"></span> Mixed use </b></button>
            <button class="btn btn-secondary ml-1"> <b> <span class="total_religious" ></span> RELIGIOUS</b></button>
            <button class="btn btn-success ml-1"> <b> <i class="bi bi-book"></i> <span class="total_educational" ></span> Educational </b></button>
            <button class="btn ml-1" style="background: #eb053c63"> <b> <i class="bi bi-bank"></i>  <span class="total_govt" ></span> Government </b></button>
            <button class="btn ml-1" style="background: #114f4b30"> <b> <span class="total_vaant_lant" ></span> Vacant Plot </b></button>
            <button class="btn btn-danger ml-1"> <b> <i class="bi bi-list-ul"></i> <span class="total_others" ></span> Others  </b></button>
            <button class="btn ml-1" style="background: #eb63001f"> <b><i class="bi bi-buildings"></i> <span class="total_tax_paid" ></span> Tax </b></button>
            <button class="btn ml-1" style="background: #ff6c6c2e"> <b><i class="bi bi-buildings"></i> <span class="total_no_tax_paid" ></span> No Tax   </b> </button>

        </div>
        <div class="row m-4" style="position: fixed; display: inline-block; left:10px;bottom:30px">
            <button class="btn btn-success" onclick="fetch_data();"> <i class="fa fa-table"></i> Show List</button>
            <div class="dropdown ml-1" id="layer_li"> 
               
            </div>
        </div>
        <div class="" style="position: fixed;right:20px;bottom:60px;background:white;padding:20px;">
            <span style="color:black;  border-radius:40px;"><b><i class="bi bi-buildings"></i> <span class="total_commercial"></span> Commercial <b></span></br>
            <span style="color: black; border-radius:40px;"><b><i class="bi bi-houses"></i> <span class="total_residential"></span> Residential </b></span></br>
            <span style="color:black; border-radius:40px;"><b> <i class="bi bi-list-check"></i> <span class="total_mixed_use"></span> Mixed use </b></span></br>
            <span style="color: black; border-radius:40px;"><b> <img src="{{ asset('admin/images/religion.png') }}" style="height:18px"> <span class="total_religious" ></span> RELIGIOUS</b></span></br>
            <span style="color: black; border-radius:40px;"><b> <i class="bi bi-book"></i> <span class="total_educational" ></span> Educational </b></span></br>       
            <span style="color: black; border-radius:40px;"><b> <i class="bi bi-bank"></i>  <span class="total_govt" ></span> Government </b></span></br>
            <span style="color: black; border-radius:40px;"> <b> <img src="{{ asset('admin/images/location_vant.png') }}" style="height:18px"> <span class="total_vaant_lant" ></span> Vacant Plot </b></span></br>
            <span style="color: black; border-radius:40px;"> <b>  <i class="bi bi-list-ul"></i> <span class="total_others" ></span> Others </b></span></br>
            <span style="color: black; border-radius:40px;"> <b> <i class="bi bi-buildings"></i> <span class="total_tax_paid" ></span> Tax </b></span></br>
            <span style="color: black; border-radius:40px;"> <b> <i class="bi bi-buildings"></i> <span class="total_no_tax_paid" ></span> No Tax </b></span></br>

        </div>
    </div>
</div>
<!-- Map Load -->
<div class="map">
    <div id="map" style="z-index:1"></div>
</div>

@include('viewmap::admin.viewmap.viewmap_js')
@include('viewmap::admin.viewmap.viewmapAjax')
@include('viewmap::admin.viewmap.viewmap_model')
@include('viewmap::admin.viewmap.js')
@endsection
