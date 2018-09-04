@extends('layouts.member')

	@section('header')
		<title> Activity Logs</title>
	@endsection

	@section('content')
		<!-- BEGIN: Subheader -->
	<div class="m-subheader ">
		<div class="d-flex align-items-center">
			<div class="mr-auto">
				<h3 class="m-subheader__title ">
					Activity Logs
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
									Activity Logs
								</h3>
							</div>
						</div>
					</div>
					<div class="m-portlet__body">

						<div class="table-responsive">
							<!--begin::Table-->
							<table class="table">
								<!--begin::Thead-->
								<thead>
									<tr>
										<td class="m-widget11__app">
											Activity Type
										</td>
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
											{{ $data->sip_trx_user_logs_type }}
										</td>
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
				<!--end:: Widgets/Application Sales-->
			</div>

		</div>

	</div>
	@stop