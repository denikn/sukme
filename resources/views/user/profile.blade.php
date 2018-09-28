@extends('layouts.member')

	@section('header')
		<title> Profile | SIP</title>
	@endsection

	@section('content')

		<!-- BEGIN: Subheader -->
		<div class="m-subheader ">
			<div class="d-flex align-items-center">
				<div class="mr-auto">
					<h3 class="m-subheader__title ">
						My Profile
					</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					@if (session()->has('message'))
						<div class="alert alert-{{ session()->get('status') ? 'success' : 'warning' }} alert-dismissible fade show" role="alert">
						  {{ session()->get('message') }}
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
						    <span aria-hidden="true">&times;</span>
						  </button>
						</div>
					@endif
				</div>
			</div>
		</div>
		<!-- END: Subheader -->
		<div class="m-content">
			<div class="row">
				<div class="col-lg-12">
					<div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
						<div class="m-portlet__head">
							<div class="m-portlet__head-tools">
								<ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary" role="tablist">
									<li class="nav-item m-tabs__item">
										<a class="nav-link m-tabs__link active" data-toggle="tab" href="#tab_profile" role="tab">
											<i class="flaticon-share m--hide"></i>
											Update Profile
										</a>
									</li>
									<li class="nav-item m-tabs__item">
										<a class="nav-link m-tabs__link" data-toggle="tab" href="#tab_email" role="tab">
											E-Mail
										</a>
									</li>
									<li class="nav-item m-tabs__item">
										<a class="nav-link m-tabs__link" data-toggle="tab" href="#tab_security" role="tab">
											Security
										</a>
									</li>
									<li class="nav-item m-tabs__item" style="display:none;">
										<a class="nav-link m-tabs__link" data-toggle="tab" href="#tab_setting" role="tab">
											Settings
										</a>
									</li>
								</ul>
							</div>
						</div>
						<div class="tab-content">
							<div class="tab-pane active" id="tab_profile">
								<form method="post" class="m-form m-form--fit m-form--label-align-right" enctype="multipart/form-data" action="{{ route('update_profile_member', [ "id" => Crypt::encryptString(Auth::user()->user_id) ]) }}">
									<div class="m-portlet__body">
										{{ csrf_field() }}
										<div class="form-group m-form__group row">
											<div class="col-10 ml-auto">
												<h3 class="m-form__section">
													Personal Details
												</h3>
											</div>
										</div>
										<div class="form-group m-form__group row">
											<label for="example-text-input" class="col-2 col-form-label">
												Profile Photo
											</label>
											<div class="col-7">
												<input type="file" name="user_img_profile" id="file">
											</div>
										</div>
										<div class="form-group m-form__group row">
											<label for="example-text-input" class="col-2 col-form-label">
												Full Name
											</label>
											<div class="col-7">
												<input class="form-control m-input" type="text" name="user_name" value="{{ Auth::user()->user_name }}">
											</div>
										</div>
										<div class="form-group m-form__group row">
											<label for="example-text-input" class="col-2 col-form-label">
												Phone No.
											</label>
											<div class="col-7">
												<input class="form-control m-input" type="text" name="user_phone" value="{{ Auth::user()->user_phone }}">
											</div>
										</div>
										<div class="form-group m-form__group row">
											<label for="example-text-input" class="col-2 col-form-label">
												Address
											</label>
											<div class="col-7">
												<textarea class="form-control m-input" name="user_address">{{ Auth::user()->user_address }}</textarea>
											</div>
										</div>
										<div class="form-group m-form__group row">
											<label for="example-text-input" class="col-2 col-form-label">
												Description
											</label>
											<div class="col-7">
												<textarea class="form-control m-input" name="user_description">{{ Auth::user()->user_description }}</textarea>
											</div>
										</div>
									</div>
									<div class="m-portlet__foot m-portlet__foot--fit">
										<div class="m-form__actions">
											<div class="row">
												<div class="col-10"></div>
												<div class="col-2">
													<button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">
														Save changes
													</button>
												</div>
											</div>
										</div>
									</div>
								</form>
							</div>
							<div class="tab-pane" id="tab_email">
								<form method="post" action="{{ route('update_email_member', [ "id" => Crypt::encryptString(Auth::user()->user_id) ]) }}" class="m-form m-form--fit m-form--label-align-right">
									<div class="m-portlet__body">
										{{ csrf_field() }}
										<div class="form-group m-form__group row">
											<div class="col-10 ml-auto">
												<h3 class="m-form__section">
													E-Mail
												</h3>
											</div>
										</div>
										<div class="form-group m-form__group row">
											<label for="example-text-input" class="col-2 col-form-label">
												E-Mail
											</label>
											<div class="col-7">
												<input class="form-control m-input" name="email" type="text" value="{{ Auth::user()->email }}">
											</div>
										</div>
									</div>
									<div class="m-portlet__foot m-portlet__foot--fit">
										<div class="m-form__actions">
											<div class="row">
												<div class="col-10"></div>
												<div class="col-2">
													<button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">
														Save changes
													</button>
												</div>
											</div>
										</div>
									</div>
								</form>
							</div>
							<div class="tab-pane" id="tab_security">
								<form method="post" class="m-form m-form--fit m-form--label-align-right" action="{{ route('update_password_member', [ "id" => Crypt::encryptString(Auth::user()->user_id) ]) }}">
									<div class="m-portlet__body">
										{{ csrf_field() }}
										<div class="form-group m-form__group row">
											<div class="col-10 ml-auto">
												<h3 class="m-form__section">
													Security
												</h3>
											</div>
										</div>
										<div class="form-group m-form__group row">
											<label for="example-text-input" class="col-2 col-form-label">
												New Password
											</label>
											<div class="col-7">
												<input class="form-control m-input" name="password" type="password" >
											</div>
										</div>
										<div class="form-group m-form__group row">
											<label for="example-text-input" class="col-2 col-form-label">
												Confirm New Password
											</label>
											<div class="col-7">
												<input class="form-control m-input" name="password_confirmation" type="password">
											</div>
										</div>
									</div>
									<div class="m-portlet__foot m-portlet__foot--fit">
										<div class="m-form__actions">
											<div class="row">
												<div class="col-10"></div>
												<div class="col-2">
													<button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">
														Save changes
													</button>
												</div>
											</div>
										</div>
									</div>
								</form>
							</div>
							<div class="tab-pane" id="tab_setting" style="display:none;">
								<form method="post" class="m-form m-form--fit m-form--label-align-right" action="{{ route('update_setting_member', [ "id" => Crypt::encryptString(Auth::user()->user_id) ]) }}">
									<div class="m-portlet__body">
										{{ csrf_field() }}
										<div class="form-group m-form__group row">
											<div class="col-10 ml-auto">
												<h3 class="m-form__section">
													Setting
												</h3>
											</div>
										</div>
										<div class="form-group m-form__group row">
											<label for="example-text-input" class="col-2 col-form-label">
												Metode Transfer
											</label>
											<div class="col-7">
												<select class="form-control m-input" name="sip_trx_user_configs_trf_type">
												  <option value="online" {{ $config->sip_trx_user_configs_trf_type == 'online' ? 'SELECTED' : '' }}>Online</option>
												  <option value="offline" {{ $config->sip_trx_user_configs_trf_type == 'offline' ? 'SELECTED' : '' }}>Offline</option>
												</select>
											</div>
										</div>
										<div class="form-group m-form__group row">
											<label for="example-text-input" class="col-2 col-form-label">
												Type Transfer Data
											</label>
											<div class="col-7">
												<select class="form-control m-input" name="sip_trx_user_configs_trf_data_type">
												  <option value="bulk" {{ $config->sip_trx_user_configs_trf_data_type == 'bulk' ? 'SELECTED' : '' }}>Bulk</option>
												  <option value="single" {{ $config->sip_trx_user_configs_trf_data_type == 'single' ? 'SELECTED' : '' }}>Single</option>
												</select>
											</div>
										</div>
									</div>
									<div class="m-portlet__foot m-portlet__foot--fit">
										<div class="m-form__actions">
											<div class="row">
												<div class="col-10"></div>
												<div class="col-2">
													<button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">
														Save changes
													</button>
												</div>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	@endsection