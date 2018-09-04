@extends('layouts.member')

	@section('header')
		<title> {{ $form->sip_ref_forms_title }} | SIP</title>
	@endsection

	@section('content')
		<!-- BEGIN: Subheader -->
	<div class="m-subheader ">
		<div class="d-flex align-items-center">
			<div class="mr-auto">
				<h3 class="m-subheader__title ">
					{{ $form->sip_ref_forms_title }}
				</h3>
			</div>
		</div>
	</div>
	<!-- END: Subheader -->
	<div class="m-content">
		<div class="row">
			<div class="col-12">
				<a href="{{ route('create_pelaporan_member',[ "id" => $form->sip_ref_forms_id ]) }}" class="btn btn-accent m-btn m-btn--air m-btn--custom">
					Submisi Baru
				</a>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-xl-12">
				<!--begin:: Widgets/Application Sales-->
				<div class="m-portlet m-portlet--full-height ">

					<div class="m-portlet__body">

						<div class="table-responsive">
							<!--begin::Table-->
							<table class="table">
								<!--begin::Thead-->
								<thead>
									<tr>
										<td class="m-widget11__app">
											Submission ID
										</td>
										<td class="m-widget11__sales">
											Created At
										</td>
										<td class="m-widget11__total m--align-right">
											Options
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
											{{ $data->created_at }}
										</td>
										<td class="m--align-right m--font-brand">
										  <div class="btn-group" role="group">
										    <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										      Options
										    </button>
										    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
										      <a class="dropdown-item" href="{{ route('view_submisi_member',[ 'id' => $form->sip_ref_forms_id, 'sub' => $data->sip_trx_form_submission_id ]) }}">View</a>
										    </div>
										  </div>
										</td>
									</tr>
									@endforeach
								</tbody>
								<!--end::Tbody-->
							</table>
							<!--end::Table-->
						</div>
						{{ $submissions->links('vendor.pagination.bootstrap-4') }}
					</div>
				</div>
				<!--end:: Widgets/Application Sales-->
			</div>

		</div>
	</div>
	@stop