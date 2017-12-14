@extends('backpack::layout')

@section('header')
	<section class="content-header">
		<legend><h3 class="text-muted">Accounts</h3></legend>
	  <ol class="breadcrumb">
	    <li class="active">Account</li>
	  </ol>
	</section>
@endsection

@section('content')
<!-- Default box -->
  <div class="box" style="padding:10px;">
    <div class="box-body">
			<table id='userTable' class="table table-bordered table-hover table-striped table-condensed" width=100%>
				<thead>
					<th>ID</th>
					<th>Email</th>
					<th>Name</th>
				</thead>
				<tbody></tbody>
			</table>

    </div><!-- /.box-body -->
  </div><!-- /.box -->

@endsection

@section('after_scripts')
<script>
	$(document).ready(function() {

	  	var table = $('#userTable').DataTable({
			"pageLength": 100,
	  		select: {
	  			style: 'single'
	  		},
		    language: {
		        searchPlaceholder: "Search..."
		    },
	    	"dom": "<'row'<'col-sm-9'l<'toolbar'>><'col-sm-3'f>>" +
						    "<'row'<'col-sm-12'tr>>" +
						    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
			"processing": true,
			ajax: "{{ url('account') }}",
			columns: [
			  { data: "id" },
			  { data: "name" },
			  { data: "email" },
			],
    	});

	 	$("div.toolbar").html(`
 			<a id="new" href="{{ url('account/create') }}" class="btn btn-primary btn-flat" style="margin-right:5px;padding: 5px 10px;" data-target="reservationItemsAddModal" data-toggle="modal"><span class="glyphicon glyphicon-plus"></span>  
 				New
 			</a>
 			<button id="edit" class="btn btn-default btn-flat" style="margin-right:5px;padding: 6px 10px;" style="display:none;"><span class="glyphicon glyphicon-pencil"></span>  Update</button>
 			<button id="reset" class="btn btn-info btn-flat" style="margin-right:5px;padding: 5px 10px;" style="display:none;"><span class="glyphicon glyphicon"></span> Reset Password</button>
 			<button id="delete" class="btn btn-danger btn-flat" style="margin-right:5px;padding: 5px 10px;" style="display:none;"><span class="glyphicon glyphicon-trash"></span> Remove</button>
		`);

	    $('#new').on('click',function(){
	    	window.location.href = "{{ url('account/create') }}"
	    });

	    $('#reset').on('click',function(){

	        swal({
	          title: "Are you sure?",
	          text: "This will reset this accounts password to the default '12345678'?",
	          type: "warning",
	          showCancelButton: true,
	          confirmButtonText: "Yes, reset it!",
	          cancelButtonText: "No, cancel it!",
	          closeOnConfirm: false,
	          closeOnCancel: false
	        },
	        function(isConfirm){
	          if (isConfirm) {
				$.ajax({
				    headers:
				    {
				        'X-CSRF-Token': $('input[name="_token"]').val()
				    },
					type: 'post',
					url: '{{ url("account/password/reset") }}',
					data: {
						'id': table.row('.selected').data().id
					},
					dataType: 'json',
					success: function(response){
						if(response == 'success'){
							swal('Operation Successful','Password has been reset','success')
						}else{
							swal('Operation Unsuccessful','Error occurred while resetting the password','error')
						}
					},
					error: function(){
						swal('Operation Unsuccessful','Error occurred while resetting the password','error')
					}
				});
	          } else {
	            swal("Cancelled", "Operation Cancelled", "error");
	          }
	        })
	    });

	    $('#edit').on('click',function(){
			try{
				if(table.row('.selected').data().id != null && table.row('.selected').data().id  && table.row('.selected').data().id >= 0)
				{
					window.location.href = "{{ url('account') }}" + '/' + table.row('.selected').data().id + '/edit'
				}
			}catch( error ){
				swal('Oops..','You must choose atleast 1 row','error');
			}
	    });

	    $('#delete').on('click',function(){
			try{
				if(table.row('.selected').data().id != null && table.row('.selected').data().id  && table.row('.selected').data().id >= 0)
				{
			        swal({
			          title: "Are you sure?",
			          text: "Account will be permanently removed",
			          type: "warning",
			          showCancelButton: true,
			          confirmButtonText: "Yes, delete it!",
			          cancelButtonText: "No, cancel it!",
			          closeOnConfirm: false,
			          closeOnCancel: false
			        },
			        function(isConfirm){
			          if (isConfirm) {
     					$.ajax({
						    headers:
						    {
						        'X-CSRF-Token': $('input[name="_token"]').val()
						    },
							type: 'delete',
							url: '{{ url("account/") }}' + "/" + table.row('.selected').data().id,
							data: {
								'id': table.row('.selected').data().id
							},
							dataType: 'json',
							success: function(response){
								if(response == 'success'){
									swal('Operation Successful','Account removed from database','success')
					        	}else if(response == 'invalid'){
									swal('Operation Unsuccessful','You need to have atleast one account','error')
								}else if(response == 'self'){
									swal('Operation Unsuccessful','You cannot remove your own account','error')
								}else{
									swal('Operation Unsuccessful','Error occurred while deleting a record','error')
								}

								table.ajax.reload()
							},
							error: function(){
								swal('Operation Unsuccessful','Error occurred while deleting a record','error')
							}
						});
			          } else {
			            swal("Cancelled", "Operation Cancelled", "error");
			          }
			        })
				}
			}catch( error ){
				swal('Oops..','You must choose atleast 1 row','error');
			}
	    });
	} );
</script>
@endsection
