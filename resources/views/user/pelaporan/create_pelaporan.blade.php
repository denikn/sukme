@extends('layouts.member')

	@section('header')
		<title> Pelaporan | SIP</title>
	@endsection

	@section('content')
		<!-- BEGIN: Subheader -->

	<div class="m-subheader ">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ route('dashboard_member') }}">Home</a></li>
				<li class="breadcrumb-item"><a href="{{ route('view_pelaporan_member',[ "id" => $form->sip_ref_forms_id ]) }}">{{ $form->sip_ref_forms_title }}</a></li>
				<li class="breadcrumb-item active" aria-current="page">Submisi Baru</li>
			</ol>
		</nav>
		<div class="d-flex align-items-center">
			<div class="mr-auto">
				<h3 class="m-subheader__title ">
					Submisi Baru {{ $form->sip_ref_forms_title }}
				</h3>
			</div>
		</div>
	</div>
	<!-- END: Subheader -->
	<div class="m-content">

		<div class="row">
			<div class="col-xl-12">
				<!--begin:: Widgets/Application Sales-->
				<div class="m-portlet m-portlet--full-height ">

					<div class="m-portlet__body">
						<div class="alert alert-success text-center" role="alert" id="alert">
						</div>
						<div id="form-table-here">

						</div>
					</div>

				</div>
				<!--end:: Widgets/Application Sales-->
			</div>

		</div>
	</div>
	@stop

	@section('scripts')
	  <script type="text/javascript">

	    function sendData(){
	      var frm = $("#post-data");
	      var data = frm.serialize();

	      	$("#send-post-data").prop('disabled',true);

	        $.ajax({
	            type: frm.attr('method'),
	            url: frm.attr('action'),
	            data: data,
	            success: function (data) {
	                $("#form-table-here").hide()
	                $("#alert").show().html('<h4 class="alert-heading">Submisi Telah Masuk.</h4><hr><a class="btn btn-primary" href="{{ route('view_pelaporan_member',[ "id" => $form->sip_ref_forms_id ]) }}">Kembali</a>');
	            },
	            error: function (data) {
	                console.log('An error occurred.');
	                console.log(data);
	                $("#send-post-data").prop('disabled',false);
	            },
	        });
			
			return false;
	    }

	    $(document).ready(function(){
	      
	      $("#alert").hide();

	      //get params
	      $.get("{{ URL::to('api/v1/activities/'.$form->sip_ref_forms_activity_id.'/forms/'.$form->sip_ref_forms_id.'/params') }}", function(data, status){
	          

	          var input = '<form method="post" id="post-data" action="{{ URL::to('api/v1/activities/'.$form->sip_ref_forms_id.'/forms?by='.Auth::user()->user_id) }}">';

	          for(var i=0; i < data.length;i++){

	            var show_type = data[i].sip_ref_sub_forms_show_type;
	            var send_type = data[i].sip_ref_sub_forms_send_type;

	            input+='<h3>'+data[i].sip_ref_sub_forms_title+'</h3>';

	            for(var a=0; a < data[i].tables.length;a++){
	              
	              var group = data[i].tables[a];

	              input+='<div class="table-responsive" style="overflow-x: scroll;margin-bottom:20px;"><table class="table">';
	              input+='<thead><tr><th></th>';

	              //columns parent
	              for(var c=0; c < group.groupcolumns.length;c++){

	                var grcolumns = group.groupcolumns[c];
	                var colspace = grcolumns.children.length ? 'colspan="'+grcolumns.children.length+'"' : '';
	                var rowspace = grcolumns.children.length ? '' : 'rowspan="2"';

	                input+='<th class="full-width-td text-center" '+colspace+' '+rowspace+'>'+grcolumns.sip_ref_columns_title+'</th>';

	              }

	              input+='</tr><tr><th></th>';

	              //columns children
	              for(var c=0; c < group.groupcolumns.length;c++){

	                var grcolumns = group.groupcolumns[c];
	                var title = grcolumns.sip_ref_rows_show_title ? grcolumns.sip_ref_rows_title : '';

	               	// columns children
	               	for(var cc=0; cc < grcolumns.children.length;cc++){

	               		var child = grcolumns.children[cc];
		                input+='<th class="full-width-td text-right">'+child.sip_ref_columns_title+'</th>';	 

	               	}
	              
	              }

	              input+='</tr></thead>';
	              input+='<tbody>';

	              //rows
	              for(var r=0; r < group.grouprows.length;r++){

	                var grrows = group.grouprows[r];	                
	                input+='<tr>';

	                var colspace = grrows.children.length ? 'colspan="'+grrows.children.length+'"' : '';
	                var title = grrows.sip_ref_rows_show_title ? grrows.sip_ref_rows_title : '';

	                input+='<td '+colspace+'>'+(r+1)+'.'+title+'</td>';
	                
	                if(!grrows.children.length){

	                  for(var codes=0;codes < grrows.codes.length;codes++){
	                  	if(grrows.codes[codes].column){
		                    input+='<td style="min-width:100px;"><input type="'+grrows.codes[codes].column.sip_ref_columns_val_type+'" class="form-control" name="'+grrows.codes[codes].sip_trx_row_values_code+'" placeholder="Input '+grrows.codes[codes].column.sip_ref_columns_title+' Here" required></td>';	                  		
	                  	}
	                  } 

	                }

	                //childs
	                for(var children=0; children < grrows.children.length;children++){
	                  
	                  var child = grrows.children[children];
	                  var title = child.sip_ref_rows_show_title ? child.sip_ref_rows_title : '';

	                  input+='<tr>';
	                  input+='<td>-'+title+'</td>';

	                  for(var codes=0;codes < child.codes.length;codes++){
	                    input+='<td><input type="'+child.codes[codes].column.sip_ref_columns_val_type+'" class="form-control" name="'+child.codes[codes].sip_trx_row_values_code+'" placeholder="Input '+group.groupcolumns[codes].sip_ref_columns_title+' Here" required></td>';
	                  }
	                  input+='</tr>';
	                }
	                input+='</tr>';
	              }

	              input+='<tbody>';
	              input+='</table></div>';
	            }

	          }

	          input+='<div class="m-portlet__foot m-portlet__foot--fit"><div class="m-form__actions"><div class="row"><div class="col-12"><br><button type="button" class="btn btn-accent m-btn m-btn--air m-btn--custom float-right" onClick="sendData()" id="send-post-data">Submit</button></div></div></div></div></form>';

	          $('#form-table-here').html(input);

	      });
	      
	    });
	  </script>
	@endsection