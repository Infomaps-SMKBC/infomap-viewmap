<script>
        var mymap = L.map('map').setView([9.37158000, 78.83077000], 6);
        
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 400,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(mymap);
        var ulbgroup = L.featureGroup().addTo(mymap);
        var wkt = new Wkt.Wkt();
        
    function getULBlatLog(){
        $value1  = $('#ulb').val();
        $key='name';
        if($value1!=null || $value!='All'){
                $.ajax({
                type:'GET',
                url:'{{ route("admin.getsinglecolumnValuewithId") }}?table=master_u_l_b_s&id=name&column=latlog&key='+$key+'&value='+$value1+'',
                success:function(response){
                    $.each(response, function (i) { 
                        ulbgroup.clearLayers();
                        var wktString = "POLYGON("+response[i]['latlog']+")";
                        // Create WKT object
                        wkt.read(wktString);
                        // Convert WKT to Leaflet geometry
                        var polygon = wkt.toObject({
                            color: 'black',
                            fillOpacity: 0.016,
                            weight: 5,
                            dashArray: '10, 6',
                            lineCap: 'circle',
                        });
                        // Add polygon to the map
                        polygon.addTo(ulbgroup).bindPopup('ULB : '+ $value1 +''); 
                        mymap.fitBounds(polygon.getBounds(),4);
                    });
                }
                });     
            } else{
                $.ajax({
                type:'GET',
                url:'{{ route("admin.getsinglecolumnValueWithTable") }}?table=master_u_l_b_s&column=latlog',
                success:function(response){
                    $.each(response, function (i) {
                        
                        var wktString = "POLYGON("+response[i]['latlog']+")";
                        // Create WKT object
                        wkt.read(wktString);
                        // Convert WKT to Leaflet geometry
                        var polygon = wkt.toObject({
                            color: 'red',
                            fillOpacity: 0.016,
                            weight: 5,
                            dashArray: '10, 6',
                            lineCap: 'circle',
                        });
                        // Add polygon to the map
                        polygon.addTo(ulbgroup).bindPopup('ULB : '+$value1); 

                        mymap.fitBounds(polygon.getBounds());
                    });
                }
                });  
            }
    }

   
   
    var wardgroup = L.featureGroup().addTo(mymap);
    function getWardlatLog(){
        var ward  = $('#ward').val();
        var ulb  = $('#ulb').val();
        
                $.ajax({
                type:'GET',
                url:'{{ route("admin.getWardAll") }}?ward='+ward+'&ulb='+ulb,
                success:function(response){
                    $.each(response, function (i) { 
                        if(ward!='' && ward!=null){
                            wardgroup.clearLayers();
                        } 
                        var wktString = "POLYGON("+response[i]['latlog']+")";
                        // Create WKT object
                        wkt.read(wktString);
                        // Convert WKT to Leaflet geometry
                        var polygon = wkt.toObject({
                            color: 'red',
                            fillOpacity: 0.016,
                            weight: 5,
                            dashArray: '10, 6',
                            lineCap: 'circle',
                        });
                        mymap.fitBounds(polygon.getBounds());
                        // Add polygon to the map
                        polygon.addTo(wardgroup).bindPopup('Ward :'+response[i]['ward']); 
                    });
                    
                }
                });     
    }



    var propertygroup = L.featureGroup().addTo(mymap);

    
    function getPropertylatLog(){
        var ward  = $('#ward').val();
        var ulb  = $('#ulb').val();
        var property = $('#property').val();
        var constructions = $('#constructions').val();
        var services = $('#services').val();
        var floor = $('#floor').val();
        layerGroup.clearLayers();
        if(ward!=null){
                $.ajax({
                type:'GET',
                url:'{{ route("admin.getProperty") }}?ulb='+ulb+'&ward='+ward+'&property='+property+'&constructions='+constructions+'&services='+services+'&floor='+floor,
                success:function(response){          
                    var res = JSON.parse(response);
                    propertygroup.clearLayers();
                    poiGroup.clearLayers();
                    var element = res.data;
                    $.each(element, function (i) {
                      
                        var wktString = "POLYGON("+element[i]['latlog']+")";
                        wkt.read(wktString);
                        if(element[i]['usage']=='RESIDENTIAL'){
                          
                            var polygon = wkt.toObject({
                                color: '#02f502',weight:2,fillOpacity: 1
                            });
                            // Add polygon to the map
                        }else if(element[i]['usage']=='COMMERCIAL'){
                            
                            var polygon = wkt.toObject({
                                color: '#ffcc00',weight:1,fillOpacity: 0.18
                            });
                            // Add polygon to the map
                        }else if(element[i]['usage']=='OTHERS'){
                           
                            var polygon = wkt.toObject({
                                color: '#fe5a40',weight:1,fillOpacity: 0.18
                            });
                            // Add polygon to the map
                        }else if(element[i]['usage']=='VACANT LAND'){
                           
                           var polygon = wkt.toObject({
                                color: '#114f4b',weight:1,fillOpacity: 0.08
                           });
                           // Add polygon to the map
                        }else if(element[i]['usage']=='VACANT LAND WITH CON'){
                           
                           var polygon = wkt.toObject({
                                color: '#114f4b',weight:1,fillOpacity: 0.08
                           });
                           // Add polygon to the map
                        }else if(element[i]['usage']=='RELIGIOUS'){
                           
                           var polygon = wkt.toObject({
                                color: '#68019c',weight:1,fillOpacity: 0.08
                           });
                           // Add polygon to the map
                        }else if(element[i]['usage']=='EDUCATIONAL'){
                           
                           var polygon = wkt.toObject({
                            color: '#795548',weight:1,fillOpacity: 0.08
                           });
                           // Add polygon to the map
                        }else{
                            var polygon = wkt.toObject({
                                color: '#f702b2',weight:1,fillOpacity: 0.18
                            });
                            // Add polygon to the map
                        }

                        var content ="Owner Name : "+element[i]['mis_owner']+"</br> Property : "+element[i]['usage']+"</br> GIS ID : "+element[i]['topo_id']+"</br> Tax ID : "+element[i]['tax_number']
                        +"</br> Construction : "+element[i]['construction']
                        +"</br></br><button class='btn btn-primary' onClick='showPropertyDetails("+element[i]['id']+")'>View Details</button>";
                        polygon.addTo(propertygroup).bindPopup(content); 
                    });
                }
                });    
                getSteet();
                showLayerDetails(); 
                getViewmapCount();
                poi();
                utility();
                getConstructionSelect();
                roadSelect();
                $('.filter2').css('display','block');
            } 
    }

    var roadgroup = L.featureGroup().addTo(mymap);
    function getRoadlatLog(){
        var ward  = $('#ward').val();
        var ulb  = $('#ulb').val();
        var roadType  = $('#roads').val();
        var street_name  = $('#street').val();
        //alert(street_name);
        if(street_name==null){
            street_name = '';
        }
        roadgroup.clearLayers();
        
                $.ajax({
                type:'GET',
                url:'{{ route("admin.getRoadDetails") }}?ward='+ward+'&ulb='+ulb+'&roadType='+roadType+'&street_name='+street_name,
                success:function(response){  
                    var element = response;
                    $.each(element, function (i) {
                        var wktString = "LINESTRING("+element[i]['latlog']+")";
                        // Create WKT object
                        wkt.read(wktString);
                        // Convert WKT to Leaflet geometry
                        if(element[i]['road_type']=='Bituminous Road'){
                            var polygon = wkt.toObject({color: '#848c45',weight:5});
                        }else if(element[i]['road_type']=='WBM Road'){
                            var polygon = wkt.toObject({color: '#997407',weight:5});
                        }else if(element[i]['road_type']=='CC'){
                            var polygon = wkt.toObject({color: '#844583',weight:5});
                        }else if(element[i]['road_type']=='Concrete Road'){
                            var polygon = wkt.toObject({color: '#6c516c',weight:5});
                        }else if(element[i]['road_type']=='Earthen Road'){
                            var polygon = wkt.toObject({color: '#fe05fc',weight:5});
                        }else if(element[i]['road_type']=='Mud Road'){
                            var polygon = wkt.toObject({color: '#c54c8f',weight:5});
                        }else if(element[i]['road_type']=='Soil Road'){
                            var polygon = wkt.toObject({color: '#844583',weight:5});
                        }else if(element[i]['road_type']=='Cement Road'){
                            var polygon = wkt.toObject({color: '#293d3d',weight:5});
                        }else if(element[i]['road_type']=='Stone Road'){
                            var polygon = wkt.toObject({color: '#eb07e9',weight:5});
                        }else if(element[i]['road_type']=='Thar Road'){
                            var polygon = wkt.toObject({color: '#b53dfa',weight:5});
                        }else if(element[i]['road_type']=='Other'){
                            var polygon = wkt.toObject({color: '#b53dfa',weight:5});
                        }else if(element[i]['road_type']=='NA'){
                            var polygon = wkt.toObject({color: '#b53dfa',weight:5});
                        }else if(element[i]['road_type']=='Express Highway'){
                            var polygon = wkt.toObject({color: '#b53dfa',weight:5});
                        }
                        // Add polygon to the map
                        var content ="Street Name -"+element[i]['street_name']+"<br> Road Type - "+element[i]['road_type']+"<br>Ward No. - "+element[i]['ward']+"<br>  Width(Ft.)- "+element[i]['road_width']+"<br>Length (M) - "+element[i]['distance_m']+"";

                        polygon.addTo(roadgroup).bindPopup(content); 
                    });
                }
                });     
            
    }


    function showPropertyDetails(id){
        var ward  = $('#ward').val();
        var ulb  = $('#ulb').val();
        $.ajax({
                type:'GET',
                url:'{{ route("admin.getPropertyModel") }}?table=builduing&id='+id+'&ward='+ward+'&ulb='+ulb,
                success:function(response){
                    //console.log(response);
                    $('#getSingleWardData').html(response);
                    $('#myModal').modal('show');
                }
            });

    }

    function showLayerDetails(){
        var ward  = $('#ward').val();
        var ulb_name  = $('#ulb').val();
        $.ajax({
                type:'GET',
                url:'{{ route("admin.getLayer") }}?ward='+ward+'&ulb_name='+ulb_name,
                success:function(response){
                    $('#layer_li').html(response);
                    //console.log(response);
                }
            });
    }

    function getViewmapCount(){
        $ward  = $('#ward').val();
        $ulb_name  = $('#ulb').val();
        $.ajax({
                type:'GET',
                url:'{{ route("admin.getViewmapCount") }}?ward='+$ward+'&ulb_name='+$ulb_name,
                success:function(response){
                    var res = JSON.parse(response);
                    $('.total_commercial').html(res.total_commercial);
                    $('.total_residential').html(res.total_residential);
                    $('.total_mixed_use').html(res.total_mixed_use);
                    $('.total_religious').html(res.total_religious);
                    $('.total_educational').html(res.total_educational);
                    $('.total_govt').html(res.total_govt);
                    $('.total_vaant_lant').html(res.total_vaant_lant);
                    $('.total_others').html(res.total_others);
                    $('.total_tax_paid').html(res.total_tax_paid);
                    $('.total_no_tax_paid').html(res.total_no_tax_paid);
                }
            });
    }
</script>


<script type="text/javascript">
 function showViewDetails1(){
    $('#showViewDetails').modal('show');
        var ward  = $('#ward').val();
        var ulb  = $('#ulb').val();
        var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.getPropertyViewModel") }}?ward='+ward+'&ulb='+ulb,
        columns: [
            {data: 'tax_number'},
            {data: 'topo_id'},
            {data: 'ward'},
            {data: 'mis_owner'},
            {data: 'usage'},
            {data: 'construction'},
            {data: 'water_connection_no'},
            {data: 'ugd_conn_no'},
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
        ]
    });
  };

  function poi(){
    var ward  = $('#ward').val();
    var ulb_name  = $('#ulb').val();
    $.ajax({
        type: 'get',
        url: '{{ route("admin.getPOI") }}?ward='+ward+'&ulb_name='+ulb_name,
        success: function(response) {
            //console.log(response);
            // Handle success response
            // $('#poi').val([]);
            $("#poi").html(response);					 
			$("#poi").multiselect("rebuild");
        },
        error: function(xhr, status, error) {
            // Handle error
            console.error(xhr.responseText);
        }
    });
  }

  function utility(){
    var ward  = $('#ward').val();
    var ulb_name  = $('#ulb').val();
    $.ajax({
        type: 'get',
        url: '{{ route("admin.getUtility") }}?ward='+ward+'&ulb_name='+ulb_name,
        success: function(response) {
            // Handle success response
            //console.log(response);
            $(".utility").html(response);					 
			$(".utility").multiselect("rebuild");
        },
        error: function(xhr, status, error) {
            // Handle error
            console.error(xhr.responseText);
        }
    });
  }
 
var poiGroup = L.featureGroup().addTo(mymap);
function getPOIMap(){
    var poi = $('#poi').val();
    var ward  = $('#ward').val();
    var ulb_name  = $('#ulb').val();
   $.ajax({
        type: 'get',
        url: '{{ route("admin.getPOIMap") }}?ward='+ward+'&ulb_name='+ulb_name+'&utility_name='+poi,
        success: function(response) {
            // Handle success response
            //console.log(response);
            poiGroup.clearLayers();
                    response.forEach(function(element) {
                        var image = element['utilitynaming'];
                        var habIcon = L.icon({iconUrl: '{{url("/")}}/admin/images/'+image, iconSize: [50, 50],});
                        var content ="Ward: "+element['ward']+"</br> Utility Name : "+element['Utility_Name']+"</br> Full Details : "+element['fulldetails']+"</br>";
                        
                        marker = L.marker([element['Y'], element['X']],{icon: habIcon}).addTo(poiGroup).bindPopup(content);
                        
                    });
        },
        error: function(xhr, status, error) {
            // Handle error
            console.error(xhr.responseText);
        }
    });
}

var utilityGroup = L.featureGroup().addTo(mymap);
function getUtitlityMap(){
    var utility = $('#utility').val();
    var ward  = $('#ward').val();
    var ulb_name  = $('#ulb').val();
   $.ajax({
        type: 'get',
        url: '{{ route("admin.getPOIMap") }}?ward='+ward+'&ulb_name='+ulb_name+'&utility_name='+utility,
        success: function(response) {
            // Handle success response
            //console.log(response);
            utilityGroup.clearLayers();
                    response.forEach(function(element) {
                        var image = element['utilitynaming'];
                        var habIcon = L.icon({iconUrl: '{{url("/")}}/admin/images/'+image, iconSize: [50, 50],});
                        var content ="Ward: "+element['ward']+"</br> Utility Name : "+element['Utility_Name']+"</br> Full Details : "+element['fulldetails']+"</br>";
                        
                        marker = L.marker([element['Y'], element['X']],{icon: habIcon}).addTo(utilityGroup).bindPopup(content);
                        
                    });
        },
        error: function(xhr, status, error) {
            // Handle error
            console.error(xhr.responseText);
        }
    });
}


var SSDgroup = L.featureGroup().addTo(mymap);
function getmanholeline(){
    
    var ward  = $('#ward').val();
    var ulb_name  = $('#ulb').val();
    var ssd = $("#SSD").is(":checked")
    if(ssd){
        $.ajax({
                type: 'get',
                url: '{{ route("admin.getSSDMap") }}?ward='+ward+'&ulb_name='+ulb_name,
                success: function(response) {
                    $.each(response, function (i) {  
                                var wktString = "LINESTRING("+response[i]['latlog']+")";
                                // Create WKT object
                                wkt.read(wktString);
                                // Convert WKT to Leaflet geometry
                                var polygon = wkt.toObject({color: '#091afc',weight:3});
                                //mymap.fitBounds(polygon.getBounds());
                                // Add polygon to the map
                                polygon.addTo(SSDgroup).bindPopup('SS Drain'); 
                            });
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error(xhr.responseText);
                }
            });
    }else{
        SSDgroup.clearLayers();
    }
}



var culvertGroup = L.featureGroup().addTo(mymap);
function getculvert(){
    var culvert = $('#Culvert').val();
    var ward  = $('#ward').val();
    var ulb_name  = $('#ulb').val();
    var culvert = $("#culvert").is(":checked")
    if(culvert){
        $.ajax({
                type: 'get',
                url: '{{ route("admin.getculvertMap") }}?ward='+ward+'&ulb_name='+ulb_name+'&Culvert='+culvert,
                success: function(response) {
                    $.each(response, function (i) { 
                                if(ward!='' && ward!=null){
                                    culvertGroup.clearLayers();
                                } 
                                var wktString = "POLYGON("+response[i]['latlog']+")";
                                // Create WKT object
                                wkt.read(wktString);
                                // Convert WKT to Leaflet geometry
                                var polygon = wkt.toObject({color: 'black',weight:6});
                                //mymap.fitBounds(polygon.getBounds());
                                // Add polygon to the map
                                polygon.addTo(culvertGroup).bindPopup('Culvert'); 
                            });
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error(xhr.responseText);
                }
            });
    }else{
        culvertGroup.clearLayers();
    }
}

var manholesGroup = L.featureGroup().addTo(mymap);
function getmanhole(){
    var ward  = $('#ward').val();
    var ulb_name  = $('#ulb').val();
    var manholes = $("#manholes").is(":checked");
    if(manholes){
        $.ajax({
                type: 'get',
                url: '{{ route("admin.getmanholesMap") }}?ward='+ward+'&ulb_name='+ulb_name,
                success: function(response) {
                    response.forEach(function(element) {
                                var habIcon = L.icon({iconUrl: '{{url("/")}}/admin/marker/stargate-raw.png', iconSize: [50, 50],});
                                var content ="Manhole No : "+element['manhole_no']+"</br>Ward: "+element['ward']+"</br>";
                                
                                marker = L.marker([element['Y'], element['X']],{icon: habIcon}).addTo(manholesGroup).bindPopup(content);
                                
                            });
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error(xhr.responseText);
                }
            });
        }else{
            manholesGroup.clearLayers();
        }
}

var ugdGroup = L.featureGroup().addTo(mymap);
function getugd(){
    var culvert = $('#Culvert').val();
    var ward  = $('#ward').val();
    var ulb_name  = $('#ulb').val();
    var ugd = $("#ugd").is(":checked");
    if(ugd){
        $.ajax({
                type: 'get',
                url: '{{ route("admin.getugd") }}?ward='+ward+'&ulb_name='+ulb_name+'&Culvert='+culvert,
                success: function(response) {
                            $.each(response, function (i) { 
                                
                                var manholelinetwkt = "LINESTRING("+response[i]['latlog']+")";
                                // Create WKT object
                                wkt.read(manholelinetwkt);
                                // Convert WKT to Leaflet geometry
                                var polygon = wkt.toObject({color: 'black',weight:6});
                                //mymap.fitBounds(polygon.getBounds());
                                // Add polygon to the map
                                polygon.addTo(ugdGroup).bindPopup('UGD'); 
                            });
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error(xhr.responseText);
                }
            });
    }else{
        ugd.clearLayers();
    }
}

$(document).ready(function(){
$("#ward").on('change',function(){
  $ulb_name  = $('#ulb').val();
  $ward  = $('#ward').val();
  if($ward!=null){
        $.ajax({
        type:'GET',
        url:'{{ route("admin.getPropertySelect") }}?ulb_name='+$ulb_name+'&ward='+$ward,
        success:function(response){
            $("#property").html(response);					 
			$("#property").multiselect("rebuild");
        }
        });
    }

});
});


function getpropertyMap(){
         getPropertylatLog();
    }

        function getConstructionSelect(){
            $ulb_name  = $('#ulb').val();
            $ward  = $('#ward').val();
            if($ward!=null){
                    $.ajax({
                    type:'GET',
                    url:'{{ route("admin.getConstructionSelect") }}?ulb_name='+$ulb_name+'&ward='+$ward+'',
                    success:function(response){
                      //  console.log(response);
                        $("#constructions").html(response);					 
                        $("#constructions").multiselect("rebuild");
                    }
                    });
                }
        }
    //===================================
    function getConstructionsMap(){
        getPropertylatLog();
    }
    //===================================

    function roadSelect(){
    $ulb_name  = $('#ulb').val();
    $ward  = $('#ward').val();
    if($ward!=null){
            $.ajax({
            type:'GET',
            url:'{{ route("admin.getRoadSelect") }}?ulb_name='+$ulb_name+'&ward='+$ward,
            success:function(response){
                $("#roads").html(response);					 
                $("#roads").multiselect("rebuild");
            }
            });
        }
    }

    // ===============Start Fetch Data Road Tyoe Wise====================
    function getRoadsMap(){
        getRoadlatLog();
    }
     //============End  Fetch Data Street Wise=======================

    //============Start Fetch Data Street Wise=======================

    function getStreetMap(){
        getRoadlatLog();
    }
     //============End Fetch Data Street Wise=======================


    //=====Start property Details fetch ================================
   

        $(document).on('click', '.pagination a', function(event){
        event.preventDefault(); 
        var page = $(this).attr('href').split('page=')[1];
        fetch_data(page);
        });

        function fetch_data(page=0)
        {
            var ward  = $('#ward').val();
            var ulb  = $('#ulb').val();
            $.ajax({
            url:"{{route('admin.getProFetch')}}?page="+page+"&ward="+ward+"&ulb_name="+ulb,
            success:function(data)
            {
              
                $('#showViewDetails').modal('show'); 
                $('#buildingbody').html(data);
            }
            });
        }

        $(document).on('click','.closes',function(event){
                event.preventDefault();
                $('#showViewDetails').modal('hide'); 
        })

 
    //=====End property Details fetch ================================


    //=========== Start Layer show in Mao ==========================
    var layerGroup = L.featureGroup().addTo(mymap);
    function showLayerMap(id){
        layerGroup.clearLayers();
        var layer = $('#layername'+id).val();
        status = true;

        if(layer == undefined){
            alert('Data not availble');
        }

        var layername = $('#layername'+id).is(":checked");
        
        if(layername){

                // if(layer=="Building"){
                //     propertygroup.addTo(mymap);
                // }

                // if(layer=='Road'){
                //     roadgroup.addTo(mymap);
                // }
                // if(layer=='Ward Boundary'){

                // }

            var ward  = $('#ward').val();
            var ulb_name = $('#ulb').val();
            layerGroup.clearLayers();
            $.ajax({
                type: 'get',
                url: '{{ route("admin.layerMap") }}?ward='+ward+'&ulb_name='+ulb_name+'&layername='+layer,
                success: function(response) {
                    var res = JSON.parse(response);
                    response = res.data;
                    if(res.feature_type.feature_type=='Point' || res.feature_type.feature_type=='point'){
                        response.forEach(function(element) {
                            var image = element['utilitynaming'];
                                var habIcon = L.icon({iconUrl: '{{url("/")}}/admin/images/'+image, iconSize: [50, 50],});
                                
                                marker = L.marker([element['Y'], element['X']],{icon: habIcon}).addTo(layerGroup).bindPopup(element['ward']);
                                
                            });
                    }

                    if(res.feature_type.feature_type=='Polyline' || res.feature_type.feature_type=='polyline'){
                            $.each(response, function (i) { 
                                
                                var manholelinetwkt = "LINESTRING("+response[i]['latlog']+")";
                                // Create WKT object
                                wkt.read(manholelinetwkt);
                                // Convert WKT to Leaflet geometry
                                var polygon = wkt.toObject({color: res.layergroup.layercolor,weight:6});
                                //mymap.fitBounds(polygon.getBounds());
                                // Add polygon to the map
                                polygon.addTo(layerGroup).bindPopup(response[i]['utility_name']); 
                            }); 
                    }

                    if(res.feature_type.feature_type=='Polygon' || res.feature_type.feature_type=='polygon'){
                            $.each(response, function (i) { 
                                var wktString = "POLYGON("+response[i]['latlog']+")";
                                // Create WKT object
                                wkt.read(wktString);
                                // Convert WKT to Leaflet geometry
                                var polygon = wkt.toObject({color: res.layergroup.layercolor,weight:6});
                                //mymap.fitBounds(polygon.getBounds());
                                // Add polygon to the map
                                polygon.addTo(layerGroup).bindPopup(response[i]['utility_name']); 
                            });
                    }

                    if(res.feature_type.feature_type=='Polygon' || res.feature_type.feature_type=='polygon'){
                            $.each(response, function (i) { 
                                var wktString = "POLYGON("+response[i]['latlog']+")";
                                // Create WKT object
                                wkt.read(wktString);
                                // Convert WKT to Leaflet geometry
                                var polygon = wkt.toObject({color: res.layergroup.layercolor,weight:6});
                                //mymap.fitBounds(polygon.getBounds());
                                // Add polygon to the map
                                polygon.addTo(layerGroup).bindPopup(response[i]['utility_name']); 
                            });
                    }
                    if(res.layergroup=="DroneImage"){
                        alert('Loading Drone/Satellite image take while time. please wait.');
                        var url_to_geotiff_file = "{{url("/")}}/admin/droneImg/"+ulb_name+"/"+res.data.drone_image;
                        fetch(url_to_geotiff_file)
                            .then(response => response.arrayBuffer())
                            .then(arrayBuffer => {
                            parseGeoraster(arrayBuffer).then(georaster => {
                                console.log("georaster:", georaster);
                                var layer = new GeoRasterLayer({
                                    georaster: georaster,
                                    opacity: 7.0,
                                    resolution: 406
                                });
                                layer.addTo(layerGroup);

                                layerGroup.fitBounds(layer.getBounds());

                            });
                        });
                    }                            
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error(xhr.responseText);
                }
            });
        }else{
            layerGroup.clearLayers();
        }

    }
    //=========== End Layer show in Mao ==========================

    //============ Start floor records ============================
    function getFloorRecord(){
        getPropertylatLog();
    }
    //=========== End Fllor Records ================================

     //============ Start floor records ============================
     function getServices(){
        getPropertylatLog();
    }
    //=========== End Fllor Records ================================
</script>