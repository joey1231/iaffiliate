<div class="card-block">
	  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary" @click="save" :disabled="submitting" >{{$button_name}}</button>
</div>