@extends('layouts.member')

	@section('header')
		<title> Dashboard | SIP</title>
	@endsection

	@section('content')
		<!-- BEGIN: Subheader -->
	<div class="m-subheader ">
		<div class="d-flex align-items-center">
			<div class="mr-auto">
				<h3 class="m-subheader__title ">
					Dashboard
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
									Submisi Terbaru
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

										<td>
											<b>ID</b>
										</td>
										<td class="m-widget11__app">
											Nama Form
										</td>
										<td class="m-widget11__sales">
											Jenis Aktifitas
										</td>
										<td class="m-widget11__price">
											Created At
										</td>

									</tr>
								</thead>
								<!--end::Thead-->
								<!--begin::Tbody-->
								<tbody>
									@foreach($submissions as $data)
									<tr>

										<td>
											{{ $data->sip_trx_form_submission_id }}
										</td>
										<td>
											{{ $data->form->sip_ref_forms_title }}
										</td>
										<td>
											{{ $data->form->activity->sip_ref_activities_name }}
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

					</div>
				</div>
				<!--end:: Widgets/Application Sales-->
			</div>

		</div>
	</div>
	@stop