<!-- Property Details modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Property Detail</h4>
          <button type="button" class="close pclose" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="getSingleWardData">
   
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default pclose" data-dismiss="modal">Close</button>
           </div>
      </div>
    </div>
</div>



<!-- Property Details modal -->
<div class="modal fade" id="showViewDetails" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Building Detail</h4>
          <button type="button" class="close closes" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="buildingbody">
           
                
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default closes" data-dismiss="modal">Close</button>
           </div>
      </div>
    </div>
</div>

<script>
  $(document).on('click','.pclose',function(event){
        event.preventDefault();
        $('#myModal').modal('hide'); 
  })
</script>
