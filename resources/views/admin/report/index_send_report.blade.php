@extends('layouts.admin')

@section('content')
<section class="section">
  <h1 class="section-header">
    <div>Offline Transfer</div>
  </h1>
  <nav aria-label="breadcrumb">
  	<ol class="breadcrumb">
  		<li class="breadcrumb-item"><a href="{{ route('dashboard_admin') }}">Home</a></li>
  		<li class="breadcrumb-item active" aria-current="page">Offline Transfer</li>
  	</ol>
  </nav>
	
	@if (session()->has('message'))
		<div class="alert alert-{{ session()->get('status') ? 'success' : 'warning' }} alert-dismissible fade show" role="alert">
		  {{ session()->get('message') }}
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>
	@endif

	<div class="section-body">

        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Filter Data</h5>
                <form class="form-inline">

                  <div class="form-group mx-sm-3 mb-2">
                    <label for="exampleInputEmail1">Data From &nbsp;</label>
                  <input class="form-control" value="{{ request('from') }}" type="date" name="from">
                  </div>
                  <div class="form-group mx-sm-3 mb-2">
                    <label for="exampleInputEmail1">Data To &nbsp;</label>
                  <input class="form-control" value="{{ request('to') }}" type="date" name="to">
                  </div>
                  <button type="submit" class="btn btn-primary">Generate</button>

                </form>
              </div>
            </div>

          </div>

        </div>

        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Logs</h5>
				<div class="table-responsive">
					<!--begin::Table-->
					<table class="table">
						<!--begin::Thead-->
						<thead>
							<tr>
								<td class="m-widget11__app">
									Activity
								</td>
								<td class="m-widget11__sales">
									Created At
								</td>
							</tr>
						</thead>
						<!--end::Thead-->
						<!--begin::Tbody-->
						<tbody>
							@foreach($logs as $data)
							<tr>
								<td>
									{{ $data->sip_trx_user_logs_desc }}
								</td>
								<td>
									{{ $data->created_at }}
								</td>
							</tr>
							@endforeach
						</tbody>
						<!--end::Tbody-->
					</table>
					<!--end::Table-->
				</div>

				{{ $logs->links('vendor.pagination.bootstrap-4') }}
              </div>
            </div>

          </div>

        </div>

		@if(trim(request('from')) !== '' && trim(request('to')) !== '')

        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
				<div class="row">
					<div class="col-12">
					  <a class="btn btn-success float-right" href="{{ route('download_json_activity_member',['from' => request('from'), 'to' => request('to')]) }}">
					    Download
					  </a>
					</div>
				</div>
              </div>
            </div>

          </div>

        </div>
		<div class="row">
			<div class="col-xl-12">

				@foreach($activities as $activity)
                <div class="card mb-3">
                    <div class="card-header">
                      <h4>{{ $activity->sip_ref_activities_name }}</h4>
                    </div>
                    <div class="card-body">

                    	@foreach($activity['forms'] as $form) 
						<div class="accordion mb-3" id="accordionExample">
						  <div class="card">
						    <div class="card-header" id="headingOne">
						      <h5 class="mb-0">
						        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse{{ $form->sip_ref_forms_id }}" aria-expanded="true" aria-controls="collapseOne">
						          {{ $form->sip_ref_forms_title }}
						        </button>
						      </h5>
						    </div>

						    <div id="collapse{{ $form->sip_ref_forms_id }}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
						      <div class="card-body">

					            @foreach($form->subs as $sub)
					              @if($sub->sip_ref_sub_forms_report_show)

				                      <h4>{{ $sub->sip_ref_sub_forms_title }} Table</h4>

				                      <div class="table-responsive mb-3" style="overflow-x: scroll;">
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

					              @endif
					            @endforeach

						      </div>
						    </div>
						  </div>
						</div>
                		@endforeach

                    </div>
                </div>
                @endforeach

			</div>
		</div>
		@endif

	</div>

</section>
@endsection