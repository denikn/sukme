@extends('layouts.admin')

@section('content')
<section class="section">
  <h1 class="section-header">
    <div>My Profile</div>
  </h1>
  <nav aria-label="breadcrumb">
  	<ol class="breadcrumb">
  		<li class="breadcrumb-item"><a href="{{ route('dashboard_admin') }}">Home</a></li>
  		<li class="breadcrumb-item active" aria-current="page">Profile</li>
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
                    <h4>Bordered Tab</h4>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12 col-sm-12 col-md-2">
                        <ul class="nav nav-pills flex-column" id="myTab2" role="tablist">
                          <li class="nav-item">
                            <a class="nav-link active show" id="home-tab4" data-toggle="tab" href="#home4" role="tab" aria-controls="home" aria-selected="false">Profile</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="profile-tab4" data-toggle="tab" href="#profile4" role="tab" aria-controls="profile" aria-selected="false">E-Mail</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="contact-tab4" data-toggle="tab" href="#contact4" role="tab" aria-controls="contact" aria-selected="true">Security</a>
                          </li>
                        </ul>
                      </div>
                      <div class="col-12 col-sm-12 col-md-10">
                        <div class="tab-content" id="myTab2Content">
                          <div class="tab-pane fade active show" id="home4" role="tabpanel" aria-labelledby="home-tab4">
								
							<form method="post" action="{{ route('update_member_admin', [ "id" => Auth::user()->user_id ]) }}">
								{{ csrf_field() }}
							  <div class="form-group">
							    <label for="text">Name</label>
							    <input id="text" name="user_name" value="{{ Auth::user()->user_name }}" type="text" class="form-control here">
							  </div>
							  <div class="form-group">
							    <label for="text">Phone</label>
							    <input id="text" name="user_phone" value="{{ Auth::user()->user_phone }}" type="text" class="form-control here">
							  </div>
							  <div class="form-group">
							    <label for="textarea">User Address</label> 
							    <textarea id="textarea" name="user_address" cols="40" rows="5" class="form-control">{{ Auth::user()->user_address }}</textarea>
							  </div> 
							  <div class="form-group">
							    <label for="textarea">Description</label> 
							    <textarea id="textarea" name="user_description" cols="40" rows="5" class="form-control">{{ Auth::user()->user_description }}</textarea>
							  </div> 
							  <div class="form-group">
							    <button name="submit" type="submit" class="btn btn-primary float-right">Submit</button>
							  </div>
							</form>

                          </div>
                          <div class="tab-pane fade" id="profile4" role="tabpanel" aria-labelledby="profile-tab4">
							
							<form method="post" action="{{ route('update_email_member_admin', [ "id" => Auth::user()->user_id ]) }}">
								{{ csrf_field() }}
							  <div class="form-group">
							    <label for="text">E-Mail</label>
							    <input id="text" name="email" type="text" value="{{ Auth::user()->email }}" class="form-control here">
							  </div>
							  <div class="form-group">
							    <button name="submit" type="submit" class="btn btn-primary float-right">Submit</button>
							  </div>
							</form>
                          
                          </div>
                          <div class="tab-pane fade" id="contact4" role="tabpanel" aria-labelledby="contact-tab4">
							
							<form method="post" action="{{ route('update_password_member_admin', [ "id" => Auth::user()->user_id ]) }}">
								{{ csrf_field() }}
							  <div class="form-group">
							    <label for="text">New Password</label>
							    <input id="text" name="password" type="password" class="form-control here">
							  </div>
							  <div class="form-group">
							    <label for="text">Confirm New Password</label>
							    <input id="text" name="password_confirmation" type="password" class="form-control here">
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

	</div>

</section>
@endsection