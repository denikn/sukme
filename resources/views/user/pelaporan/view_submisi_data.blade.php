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
				<li class="breadcrumb-item active" aria-current="page">Detail Submisi</li>
			</ol>
		</nav>
		<div class="d-flex align-items-center">
			<div class="mr-auto">
				<h3 class="m-subheader__title ">
					Detail submisi #{{ $submission->sip_trx_form_submission_id }}
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

	    $(document).ready(function(){
	      
	      //get value
	      $.get("{{ URL::to('api/v1/activities/'.$form->sip_ref_forms_activity_id.'/forms/'.$form->sip_ref_forms_id.'/values/'.$submission->sip_trx_form_submission_id) }}", function(data, status){
	          
	          var html = ''; 
	          
	          for(var i=0; i < data.length;i++){

	          	html = html + '<h3>'+data[i].sip_ref_sub_forms_title+'</h3>';
	          	html = html + '<div class="table-responsive"><table class="table">';

	          	for(var a=0; a < data[i].rows.length; a++){
	          		
	          		var tmpParent = data[i].rows[a].sip_ref_rows_type_parent;
	          		var tmpColSpan = tmpParent == 'parent' ? 'colspan="'+(data[i].rows[a].values.length + 3)+'"' : '';
	          		var tmpBullet = tmpParent == 'parent' ? '' : '*';

	          		html = html + '<tr><td '+tmpColSpan+'>'+tmpBullet+data[i].rows[a].sip_ref_rows_title+'</td>';

	          		for(var b = 0; b < data[i].rows[a].values.length;b++){
	          			
	          			if(data[i].rows[a].values[b].value) html = html + '<td>'+data[i].rows[a].values[b].value.sip_trx_form_values_value_string+'</td>';

	          		}

	          		html = html+ '</tr>';

	          	}

	          	html = html + '</table></div>';

	          }

	          $('#form-table-here').html(html);
	      });
	      
	    });
	  </script>
	@endsection