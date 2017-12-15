@extends('backpack::layout')

@section('after_styles')
<style>
  th, td {
    word-spacing: nowrap;
  }
</style>
@endsection

@section('header')
    <section class="content-header">
      <h1>
        Categories
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('category') }}">Category</a></li>
        <li class="active">Home</li>
      </ol>
    </section>
@endsection

@section('content')
<div class="box" style="padding: 10px;">
  <div class="box-default">
    <div class="row">
        <div class="col-md-12">
	        @if (count($errors) > 0)
	            <div class="alert alert-danger alert-dismissible" role="alert">
	            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                <ul style='margin-left: 10px;'>
	                    @foreach ($errors->all() as $error)
	                        <li>{{ $error }}</li>
	                    @endforeach
	                </ul>
	            </div>
	        @endif
	 		<form method="post" action="{{ url('category') }}" class="form-inline" id="categoryCreationForm" style="margin: 10px 0px;">
	 			{{ csrf_field() }}
	 			<div class="form-group">
		 			<input type="text" name="name" value="{{ old('name') }}" class='form-control' id='category-name' style='display:none' placeholder='Category Name' />
		 		</div>
	 			<div class="form-group">
	 				<button type="button" id="new" class="btn btn-md btn-success" style="margin-right:5px;" ><span class="glyphicon glyphicon-plus"></span> Add</button>
	 				<button type="button" id="hide" class="btn btn-md btn-default" style="margin-right:5px;display:none;"><span class="glyphicon glyphicon-eye-close"></span> Hide</button>
	 			</div>
 			</form>
			<table class="table table-hover table-condensed table-bordered table-striped" id="categoryTable">
				<thead>
					<th>Name</th>
					<th class="col-sm-2 no-sort"></th>
				</thead>
			</table>
        </div>
    </div>
  </div>
</div>
@endsection

@section('after_scripts')
<script type="text/javascript">
	$(document).ready(function() {
		var table = $('#categoryTable').DataTable( {
	    	columnDefs:[
				{ targets: 'no-sort', orderable: false },
	    	],
		    language: {
		        searchPlaceholder: "Search..."
		    },
	    	"dom": "<'row'<'col-sm-8'l><'col-sm-3'f>>" +
						    "<'row'<'col-sm-12'<'toolbar'>>>" +
						    "<'row'<'col-sm-12'tr>>" +
						    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
			"processing": true,
	        ajax: "{{ url('category') }}",
	        columns: [
	            { data: "name" },
	            { data: function(callback){
	            	return `
	            		<button type="button" data-id="`+callback.id+`" class="btn btn-sm btn-default edit">Edit</button>
	            		<button type="button" data-id="`+callback.id+`" class="btn btn-sm btn-danger delete">Delete</button>
	            	`;
	            } }
	        ],
	    } );

	 	$("div.toolbar").html(`
		`);

		$('#new').on('click',function(){
			if($('#category-name').is(':hidden'))
			{		
				$('#category-name').toggle(400)
				$('#hide').toggle(400)
			}
			else
			{
				$('#categoryCreationForm').submit()
			}
		})

		$('#hide').on('click',function(){
			$('#category-name').toggle(400)
			$('#hide').toggle(400)
		})

		$('#categoryTable').on('click','.edit',function(){
	    	id = $(this).data('id')
	    	swal({
			  title: "Input Category!",
			  input: "text",
			  showCancelButton: true,
			  confirmButtonText: 'Submit',
			  showLoaderOnConfirm: true,
			  text: "Input the new category you want to update it to",
			  allowOutsideClick: false,
			  preConfirm: (text) => {
			    return new Promise((resolve) => {
			      setTimeout(() => {
			        if (text === '') {
			          swal.showValidationError(
			            'You need to write something.'
			          )
			        }
			        resolve()
			      }, 2000)
			    })
			  },
			}).then((result) => {
			  if (result.value === "") {
			    swal.showInputError("You need to write something!");
			    return false
			  }

			  if (result.value) {
			  	inputValue = result.value
				  $.ajax({
				    headers: {
				        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				    },
				  	type: 'put',
				  	url: '{{ url("category") }}' + '/' + id,
				  	dataType: 'json',
				  	data: {
				  		'name': inputValue
				  	},
				  	success: function(response){
				  		if(response == 'success')
				  		{
				  			swal('Success','Information Updated','success')	
				  		}
				  		else
				  		swal('Error','Problem Occurred while processing your data','error')
				  		table.ajax.reload();
				  	},
				  	error: function(){
				  		swal('Error','Problem Occurred while processing your data','error')
				  	}
				  })
			  }
			})
		});

	    $('#categoryTable').on('click','.delete',function(){
	    	id = $(this).data('id')
	    	swal({
	          title: "Are you sure?",
	          text: "This category will be deleted?",
			  type: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Yes, delete it!',
			  cancelButtonText: 'No, cancel!',
			  confirmButtonClass: 'btn btn-success',
			  cancelButtonClass: 'btn btn-danger',
			  buttonsStyling: false,
			  reverseButtons: true
			}).then((result) => {
			  if (result.value) {
					$.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
					type: 'delete',
					url: '{{ url("category") }}' + "/" + id,
					data: {
						'id': id
					},
					dataType: 'json',
					success: function(response){
						if(response == 'success'){
							swal('Operation Successful','Room Category removed','success')
			        		table.ajax.reload();
			        	}else{
							swal('Operation Unsuccessful','Error occurred while deleting a record','error')
						}
					},
					error: function(){
						swal('Operation Unsuccessful','Error occurred while deleting a record','error')
					}
				});
			  } else if (result.dismiss === 'cancel') {
			    swal("Cancelled", "Operation Cancelled", "error");
			  }
			})
	    });
	} );
</script>
@endsection
