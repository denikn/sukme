@extends('layouts.member')

	@section('header')
		<title> Report {{ $activity->sip_ref_activities_name }} | SIP</title>
	@endsection

	@section('content')
		<!-- BEGIN: Subheader -->
	<div class="m-subheader ">
		<div class="d-flex align-items-center">
			<div class="mr-auto">
				<h3 class="m-subheader__title ">
					Report {{ $activity->sip_ref_activities_name }}
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
					<div class="m-portlet__head">
						<div class="m-portlet__head-caption">
							<div class="m-portlet__head-title">
								<h3 class="m-portlet__head-text">
									Filter Report
								</h3>
							</div>
						</div>
					</div>
					<div class="m-portlet__body">

						<form class="form-inline">
						  <div class="form-group mx-sm-3 mb-2">
						    <label for="exampleInputEmail1">Form &nbsp;</label>
							<select name="sip_ref_forms_id" class="form-control" required>
							  <option disabled SELECTED>Pilih Form</option>
							  @foreach($activity->forms()->where('sip_ref_forms_status','active')->get() as $form) 
							  	<option value="{{ $form->sip_ref_forms_id }}" {{ request('sip_ref_forms_id') == $form->sip_ref_forms_id ? 'SELECTED' : '' }}>{{ $form->sip_ref_forms_title }}</option>
							  @endforeach
							</select>
					 	  </div>
						  <div class="form-group mx-sm-3 mb-2">
						    <label for="exampleInputEmail1">Data From &nbsp;</label>
							<input class="form-control" value="{{ request('from') }}" type="date" name="from">
						  </div>
						  <div class="form-group mx-sm-3 mb-2">
						    <label for="exampleInputEmail1">Data To &nbsp;</label>
							<input class="form-control" value="{{ request('to') }}"  type="date" name="to">
						  </div>
						  <button type="submit" class="btn btn-primary mb-2">Filter</button>
						</form>

					</div>
				</div>
				<!--end:: Widgets/Application Sales-->

			</div>

		</div>
		@if(is_object($form) && trim(request('from')) !== '' && trim(request('to')) !== '')

			<div class="row">
				<div class="col-xl-12">
					
					<!--begin:: Widgets/Application Sales-->
					<div class="m-portlet m-portlet--full-height ">

						<div class="m-portlet__body">

							<div class="row">
								<div class="col-12">
									<div class="dropdown pull-right">
									  <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									    Download
									  </button>
									  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
									    <a class="dropdown-item" href="{{ route('download_excel_activity_member',['id' => $activity->sip_ref_activities_id,'from' => request('from'), 'to' => request('to')]) }}">Excel</a>
									  </div>
									</div>
								</div>
							</div>

						</div>
					</div>
					<!--end:: Widgets/Application Sales-->

				</div>

			</div>
            @foreach($subs as $sub)
              @if($sub->sip_ref_sub_forms_report_show)
              <div class="row">
                <div class="col-12">

                  <div class="card mb-3">
                    <div class="card-header">
                      <h4>{{ $sub->sip_ref_sub_forms_title }} Table</h4>
                    </div>
                    <div class="card-body">

                      <div class="table-responsive" style="overflow-x: scroll;">
                        <table class="table table-striped">
                          <tr>
                            <th>Params</th>
                            @foreach($sub->rows as $row)
                              <th>{{ $row->sip_ref_rows_title }}</th>
                            @endforeach
                          </tr>
                                                 
                          @foreach($sub->columns as $col)
                          <tr>
                              <th>{{ $col->sip_ref_columns_title }}</th>

                              @foreach($sub->rows as $row)
                              <th>
                                  {{ $row['value'] }}
                              </th>
                              @endforeach
                          </tr>
                          @endforeach

                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              @endif
            @endforeach

		@endif
	</div>
	@stop