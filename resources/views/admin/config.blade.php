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
		  <div class="col-12">

				<div class="card">
                  <div class="card-header">
                    <h4>Website Meta Config</h4>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12 col-sm-12 col-md-12">
								
						<form method="post" action="{{ route('update_config_admin') }}">
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
		</div>

	</div>

</section>
@endsection