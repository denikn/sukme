@extends('layouts.admin')

@section('content')
<section class="section">
  <h1 class="section-header">
    <div>Config</div>
  </h1>
  <nav aria-label="breadcrumb">
  	<ol class="breadcrumb">
  		<li class="breadcrumb-item"><a href="{{ route('dashboard_admin') }}">Home</a></li>
  		<li class="breadcrumb-item active" aria-current="page">Config</li>
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
		  <div class="col-2">
		    <div class="list-group" id="list-tab" role="tablist">
		      <a class="list-group-item list-group-item-action active" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">Meta</a>
		      <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab" aria-controls="profile">Setting</a>
		    </div>
		  </div>
		  <div class="col-8">

		    <div class="tab-content" id="nav-tabContent">
		      <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
				<div class="card">
	              <div class="card-header">
	                <h4>Website Meta Config</h4>
	              </div>
	              <div class="card-body">
	                <div class="row">
	                  <div class="col-12 col-sm-12 col-md-12">
								
						<form method="post" action="{{ route('update_meta_admin') }}">
							{{ csrf_field() }}
						  <div class="form-group">
						    <label for="text">Title</label>
						    <input id="text" name="sip_trx_site_configs_title" value="{{ $config->sip_trx_site_configs_title }}" type="text" class="form-control here">
						  </div>
						  <div class="form-group">
						    <label for="textarea">Description</label> 
						    <textarea id="textarea" name="sip_trx_site_configs_description" cols="40" rows="5" class="form-control">{{ $config->sip_trx_site_configs_description }}</textarea>
						  </div> 
						  <div class="form-group">
						    <label for="textarea">Sisdinkes Api Key</label> 
						    <textarea id="textarea" name="sip_trx_site_configs_key_sisdinkes" cols="40" rows="5" class="form-control">{{ $config->sip_trx_site_configs_key_sisdinkes }}</textarea>
						  </div> 
						  <div class="form-group">
						    <button name="submit" type="submit" class="btn btn-primary float-right">Submit</button>
						  </div>
						</form>

	                  </div>
	                </div>
	              </div>
	            </div>
		      </div>
		      <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">

				<div class="card">
	              <div class="card-header">
	                <h4>Setting</h4>
	              </div>
	              <div class="card-body">
	                <div class="row">
	                  <div class="col-12 col-sm-12 col-md-12">
								
						<form method="post" action="{{ route('update_setting_admin') }}">
							{{ csrf_field() }}
							<div class="form-group m-form__group row">
								<label for="example-text-input" class="col-2 col-form-label">
									Metode Transfer
								</label>
								<div class="col-7">
									<select class="form-control m-input" name="sip_trx_site_configs_trf_type">
									  <option value="online" {{ $config->sip_trx_site_configs_trf_type == 'online' ? 'SELECTED' : '' }}>Online</option>
									  <option value="offline" {{ $config->sip_trx_site_configs_trf_type == 'offline' ? 'SELECTED' : '' }}>Offline</option>
									</select>
								</div>
							</div>
							<div class="form-group m-form__group row">
								<label for="example-text-input" class="col-2 col-form-label">
									Type Transfer Data
								</label>
								<div class="col-7">
									<select class="form-control m-input" name="sip_trx_site_configs_trf_data_type">
									  <option value="bulk" {{ $config->sip_trx_site_configs_trf_data_type == 'bulk' ? 'SELECTED' : '' }}>Bulk</option>
									  <option value="single" {{ $config->sip_trx_site_configs_trf_data_type == 'single' ? 'SELECTED' : '' }}>Single</option>
									</select>
								</div>
							</div>
						  <div class="form-group">
						    <button name="submit" type="submit" class="btn btn-primary float-right">Submit</button>
						  </div>
						</form>

	                  </div>
	                </div>
	              </div>
	            </div>

		      </div>
		    </div>
		  </div>
		</div>

		<div class="row">
		  <div class="col-12">



		  </div>
		</div>

	</div>

</section>
@endsection