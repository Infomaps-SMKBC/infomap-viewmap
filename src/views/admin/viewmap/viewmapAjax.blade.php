<script>

function getCountries(id=0){
  
  $.ajax({
  type:'GET',
  url:'{{ route("admin.getSelectOption2") }}?table=master_countries&id=id&column=name',
  success:function(response){
      console.log(response);
      $("#country").html(response);
      $("#country").val(id);
      $('#country').trigger('change'); 
      document.getElementById("country").value = "<?php echo  old('country',isset($data->name) ? $data->name : ''); ?>";
      
  }
  });
}   
//load country function
getCountries();



function getStates(id=0){
  $value  = $('#country').val();
  if($value!=null){
        $key='country_id';
        $.ajax({
        type:'GET',
        url:'{{ route("admin.getSelectWhere") }}?table=master_states&id=id&column=name&key='+$key+'&value='+$value,
        success:function(response){
            console.log(response);
            $("#state").html(response);
            $("#state").val(id);
            $('#state').trigger('change'); 
            document.getElementById("state").value = "<?php echo  old('state',isset($data->state_id) ? $data->state_id : ''); ?>";
        }
        });
    }
}   


function getDistricts(id=0){
  $value  = $('#state').val();
  $key='state_id';
  if($value!=null){
        $.ajax({
        type:'GET',
        url:'{{ route("admin.getSelectWhere") }}?table=master_disticts&id=id&column=name&key='+$key+'&value='+$value,
        success:function(response){
            //console.log(response);
            $("#district").html(response);
            $("#district").val(id);
            $('#district').trigger('change'); 
            document.getElementById("district").value = "<?php echo  old('district',isset($data->district_id) ? $data->district_id : ''); ?>";
        }
        });
    }
}


function getTahsil(id=0){
  $value  = $('#district').val();
  $key='district_id';
  if($value!=null){
        $.ajax({
        type:'GET',
        url:'{{ route("admin.getSelectWhere") }}?table=master_tahsils&id=id&column=name&key='+$key+'&value='+$value,
        success:function(response){
            //console.log(response);
            $("#tahsil").html(response);
            $("#tahsil").val(id);
            $('#tahsil').trigger('change'); 
            document.getElementById("tahsil").value = "<?php echo  old('district',isset($data->tahsil_id) ? $data->tahsil_id : ''); ?>";
        }
        });
    }
}


function getBlock(id=0){
  $value  = $('#tahsil').val();
  $key='tahsil_id';
  if($value!=null){
        $.ajax({
        type:'GET',
        url:'{{ route("admin.getSelectWhere") }}?table=master_tahsils&id=id&column=name&key='+$key+'&value='+$value,
        success:function(response){
            $("#block").html(response);
            $("#block").val(id);
            $('#block').trigger('change'); 
            document.getElementById("block").value = "<?php echo  old('block',isset($data->block_id) ? $data->block_id : ''); ?>";
        }
        });
    }
}

function getULB(id){
  $value  = $('#block').val();
  $key='block_id';
  if($value!=null){
        $.ajax({
        type:'GET',
        url:'{{ route("admin.getSelectOption2") }}?table=master_u_l_b_s&id=name&column=name&key='+$key+'&value='+$value,
        success:function(response){
            $("#ulb").html(response);
            $("#ulb").val(id);
            $('#ulb').trigger('change'); 
           
        }
        });
    }
}

getULB();

function getSteet(id=0){
  var ward  = $('#ward').val();
  var ulb  = $('#ulb').val();
  if(ward!=null){
        $.ajax({
        type:'GET',
        url:'{{ route("admin.getStreetSelect") }}?ward='+ward+'&ulb_name='+ulb,
        success:function(response){
            $("#street").html(response);
            $("#street").val(id);
            $('#street').trigger('change');
        }
        });
    }
}

function getWard(id=0){
  var ulb  = $('#ulb').val();
  if(ulb!=null){
        $.ajax({
        type:'GET',
        url:'{{ route("admin.getWardSelect") }}?ulb_name='+ulb,
        success:function(response){
           
            $("#ward").html(response);
            $("#ward").val(id);
            $('#ward').trigger('change');
        }
        });
    }
}

</script>
<script>
$(document).ready(function(){
 $('#poi').multiselect({
  includeSelectAllOption: true,
  nonSelectedText: 'Select POI',
  enableFiltering: true,
  enableCaseInsensitiveFiltering: true,
  buttonWidth:'200px',
  backgroundColor:'red'
 });
 
});

$(document).ready(function(){
 $('#utility').multiselect({
  includeSelectAllOption: true,
  nonSelectedText: 'Select Utility',
  enableFiltering: true,
  enableCaseInsensitiveFiltering: true,
  buttonWidth:'200px'
 });
 
});


$(document).ready(function(){
 $('#drainage').multiselect({
  includeSelectAllOption: true,
  nonSelectedText: 'Select Drainage',
  enableFiltering: true,
  enableCaseInsensitiveFiltering: true,
  buttonWidth:'200px'
 });
 
});



$(document).ready(function(){
 $('#drainage').multiselect({
  includeSelectAllOption: true,
  nonSelectedText: 'Select Drainage',
  enableFiltering: true,
  enableCaseInsensitiveFiltering: true,
  buttonWidth:'200px'
 });
 
});

$(document).ready(function(){
 $('#waterSupply').multiselect({
  includeSelectAllOption: true,
  nonSelectedText: 'Select Water Supply',
  enableFiltering: true,
  enableCaseInsensitiveFiltering: true,
  buttonWidth:'200px'
 });
 
});

$(document).ready(function(){
 $('#projectStatus').multiselect({
  includeSelectAllOption: true,
  nonSelectedText: 'Select Project Status',
  enableFiltering: true,
  enableCaseInsensitiveFiltering: true,
  buttonWidth:'200px'
 });
 
});

$(document).ready(function(){
 $('#property').multiselect({
  includeSelectAllOption: true,
  nonSelectedText: 'Select Property',
  enableFiltering: true,
  enableCaseInsensitiveFiltering: true,
  buttonWidth:'200px'
 });
 
});

$(document).ready(function(){
 $('#constructions').multiselect({
  includeSelectAllOption: true,
  nonSelectedText: 'Select Constructions',
  enableFiltering: true,
  enableCaseInsensitiveFiltering: true,
  buttonWidth:'200px'
 });
 
});

$(document).ready(function(){
 $('#roads').multiselect({
  includeSelectAllOption: true,
  nonSelectedText: 'Roads',
  enableFiltering: true,
  enableCaseInsensitiveFiltering: true,
  buttonWidth:'200px'
 });
 
});

</script>