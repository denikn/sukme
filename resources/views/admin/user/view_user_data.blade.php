@extends('layouts.admin')

@section('content')
        <section class="section">
          <h1 class="section-header">
            <div>User List</div>
          </h1>
          <nav aria-label="breadcrumb">
          	<ol class="breadcrumb">
          		<li class="breadcrumb-item"><a href="{{ route('dashboard_admin') }}">Home</a></li>
          		<li class="breadcrumb-item active" aria-current="page">User List</li>
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
                  	<button type="button" class="btn btn-info" data-toggle="modal" data-target="#new">New</button>
                    <div class="float-right">

                      <form>
                        <div class="input-group">
                          <input type="text" class="form-control" name="q" value="{{ $request->input('q') }}" placeholder="Search">
                          <div class="input-group-btn">
                            <button class="btn btn-secondary"><i class="ion ion-search"></i></button>
                          </div>
                          @if(!trim($request->input('q')) == '')
                      		&nbsp;&nbsp;<a href="{{ route('list_member_admin') }}"><u>reset</u></a>
                      	  @endif
                        </div>
                      </form>
                    </div>
                    <h4>User Table</h4>
                  </div>
                  <div class="card-body">

                    <div class="table-responsive" style="min-height: 50vh;">
                      <table class="table table-striped">
                        <tr>
                          <th class="text-center">
                            <div class="custom-checkbox custom-control">
                              <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" id="checkbox-all">
                              <label for="checkbox-all" class="custom-control-label"></label>
                            </div>
                          </th>
                          <th>User Name</th>
                          <th>Email</th>
                          <th>Phone</th>
                          <th>Address</th>
                          <th>Type</th>
                          <th>Status</th>
                          <th>Created At</th>
                          <th>Action</th>
                        </tr>
                        @foreach($users as $user)
                        <tr>
                          <td width="40">
                            <div class="custom-checkbox custom-control">
                              <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-1">
                              <label for="checkbox-1" class="custom-control-label"></label>
                            </div>
                          </td>
                          <td>{{ $user->user_name }}</td>
                          <td>
                            {{ $user->email }}
                          </td>
                          <td>
                            {{ $user->user_phone }}
                          </td>
                          <td>
                            {{ $user->user_address }}
                          </td>
                          <td>
                            {{ $user->user_type }}
                          </td>
                          <td>                          	
                          	<div class="badge badge-{{ $user->statusClass($user->user_status) }}">{{ $user->user_status }}</div>
                          </td>
                          <td>                          	
                          	{{ $user->created_at }}
                          </td>
                          <td>
							<div class="dropdown">
							  <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $user->user_id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							    Options
							  </button>
							  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $user->user_id }}">
							    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit-{{ $user->user_id }}">Edit</a>
							    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#email-{{ $user->user_id }}">Edit E-Mail</a>
							    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#password-{{ $user->user_id }}">Edit Password</a>
							    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#permission-{{ $user->user_id }}">Kelola Akses</a>
							    <div class="dropdown-divider"></div>
							    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete-{{ $user->user_id }}">Hapus</a>
							  </div>
							</div>
                          </td>
                        </tr>
                        @endforeach
                      </table>
                    </div>
                  </div>
                  <div class="card-footer text-right">
                  	{{ $users->links('vendor.pagination.bootstrap-4') }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

		<!-- Modal -->
		<div class="modal fade" id="new" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		    <form method="post" action="{{ route('add_member_admin') }}">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">New User</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
					
					@if ($errors->any())
					    <div class="alert alert-danger">
					        <ul>
					            @foreach ($errors->all() as $error)
					                <li>{{ $error }}</li>
					            @endforeach
					        </ul>
					    </div>
					@endif
					{{ csrf_field() }}
				  <div class="form-group">
				    <label for="exampleInputEmail1">Username</label>
				    <input type="text" class="form-control" value="{{ old('user_name') }}" name="user_name" aria-describedby="emailHelp" placeholder="Enter Username">
				  </div>
				  <div class="form-group">
				    <label for="exampleInputEmail1">Email address</label>
				    <input type="email" class="form-control" value="{{ old('email') }}" name="email" aria-describedby="emailHelp" placeholder="Enter email">
				  </div>
				  <div class="form-group">
				    <label for="exampleInputPassword1">Password</label>
				    <input type="password" class="form-control" name="password" placeholder="Password">
				  </div>

				  <div class="form-group">
				    <label for="exampleInputPassword1">Confirm Password</label>
				    <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
				  </div>
		      </div>
		      <div class="modal-footer">
		      	<button type="button" class="btn btn-secondary btn-sm float-left" data-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-primary btn-sm float-right">Submit</button>
		      </div>
		     </form>
		    </div>
		  </div>
		</div>

		@foreach($users as $user)

			<!-- Modal -->
			<div class="modal fade" id="edit-{{ $user->user_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			    <form method="post" action="{{ route('update_member_admin',['id'=>$user->user_id]) }}">
			      <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLabel">Edit {{ $user->user_name }}</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
						
						@if ($errors->any())
						    <div class="alert alert-danger">
						        <ul>
						            @foreach ($errors->all() as $error)
						                <li>{{ $error }}</li>
						            @endforeach
						        </ul>
						    </div>
						@endif
						{{ csrf_field() }}
						<div class="form-group">
							<label for="exampleInputEmail1">Username</label>
							<input type="text" class="form-control" value="{{ $user->user_name }}" name="user_name" aria-describedby="emailHelp" placeholder="Enter Username">
						</div>
						<div class="form-group">
							<label for="exampleFormControlSelect1">Status</label>
							<select name="user_status" class="form-control">
							  <option value="active" {{ $user->user_status == 'active' ? 'selected' : '' }}>Active</option>
							  <option value="inactive" {{ $user->user_status == 'inactive' ? 'selected' : '' }}>Inactive</option>
							  <option value="banned" {{ $user->user_status == 'banned' ? 'selected' : '' }}>Banned</option>
							</select>
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">Phone</label>
							<input type="text" class="form-control" value="{{ $user->user_phone }}" name="user_phone" aria-describedby="emailHelp" placeholder="Enter Phone">
						</div>
						<div class="form-group">
							<label for="exampleFormControlTextarea1">Address</label>
							<textarea class="form-control" name="user_address" rows="3">{{ $user->user_address }}</textarea>
						</div>
						<div class="form-group">
							<label for="exampleFormControlTextarea1">Deskripsi</label>
							<textarea class="form-control" name="user_description" rows="3">{{ $user->user_description }}</textarea>
						</div>

			      </div>
			      <div class="modal-footer">
			      	<button type="button" class="btn btn-secondary btn-sm float-left" data-dismiss="modal">Close</button>
			        <button type="submit" class="btn btn-primary btn-sm float-right">Submit</button>
			      </div>
			     </form>
			    </div>
			  </div>
			</div>

			<!-- Modal -->
			<div class="modal fade" id="email-{{ $user->user_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			    <form method="post" action="{{ route('update_password_member_admin',['id'=>$user->user_id]) }}">
			      <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLabel">Edit {{ $user->user_name }}</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
						
					@if ($errors->any())
						<div class="alert alert-danger">
						    <ul>
						        @foreach ($errors->all() as $error)
						            <li>{{ $error }}</li>
						        @endforeach
						    </ul>
						</div>
					@endif
					{{ csrf_field() }}
					<div class="form-group">
						<label for="exampleInputEmail1">Email address</label>
						<input type="email" class="form-control" value="{{ $user->email }}" name="email" aria-describedby="emailHelp" placeholder="Enter email">
					</div>
			      </div>
			      <div class="modal-footer">
			      	<button type="button" class="btn btn-secondary btn-sm float-left" data-dismiss="modal">Close</button>
			        <button type="submit" class="btn btn-primary btn-sm float-right">Submit</button>
			      </div>
			     </form>
			    </div>
			  </div>
			</div>

			<!-- Modal -->
			<div class="modal fade" id="permission-{{ $user->user_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			    
			      <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLabel">Permission {{ $user->user_name }}</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
						
					@if ($errors->any())
						<div class="alert alert-danger">
						    <ul>
						        @foreach ($errors->all() as $error)
						            <li>{{ $error }}</li>
						        @endforeach
						    </ul>
						</div>
					@endif
		            <div class="row">
		              <div class="col-12 col-md-12 col-lg-12">
						<form method="post" action="{{ route('add_permission_member_admin',['id'=>$user->user_id]) }}">
							{{ csrf_field() }}
							<div class="form-group">
								<label for="exampleFormControlSelect1">Permission</label>
								<select name="sip_trx_user_permissions_permission_id" class="form-control">
								  @foreach($permissions as $permission)
								  	<option value="{{ $permission->sip_ref_permissions_id }}">{{ $permission->sip_ref_permissions_name }}</option>
								  @endforeach
								</select>
							</div>
							<button type="submit" class="btn btn-primary btn-sm float-right">Submit</button>
						</form>
		              </div>
		            </div>

		            <div class="row">
		              <div class="col-12 col-md-12 col-lg-12">
		                <div class="card">
		                  <div class="card-header">
		                    <h4>Permissions</h4>
		                  </div>
		                  <div class="card-body">
		                    <div class="table-responsive">
		                      <table class="table table-bordered">
		                        <tr>
		                          <th>#</th>
		                          <th>Name</th>
		                          <th>Action</th>
		                        </tr>
		                        @foreach($user->permissions as $permission)
		                        <tr>
		                          <td>1</td>
		                          <td>{{ $permission->permission->sip_ref_permissions_name }}</td>
		                          <td><a href="{{ route('delete_permission_member_admin',['id'=>$user->user_id,'permission'=>$permission->sip_trx_user_permissions_id]) }}" class="btn btn-action btn-secondary">Remove</a></td>
		                        </tr>
		                        @endforeach
		                      </table>
		                    </div>
		                  </div>
		                </div>
		              </div>
		            </div>

			      </div>
			     
			    </div>
			  </div>
			</div>

			<!-- Modal -->
			<div class="modal fade" id="password-{{ $user->user_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			    <form method="post" action="{{ route('update_password_member_admin',['id'=>$user->user_id]) }}">
			      <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLabel">Edit {{ $user->user_name }}</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
						
						@if ($errors->any())
							<div class="alert alert-danger">
							    <ul>
							        @foreach ($errors->all() as $error)
							            <li>{{ $error }}</li>
							        @endforeach
							    </ul>
							</div>
						@endif
	
						{{ csrf_field() }}
	
						<div class="form-group">
							<label for="exampleInputPassword1">New Password</label>
							<input type="password" class="form-control" name="password" placeholder="Password">
						</div>

						<div class="form-group">
							<label for="exampleInputPassword1">Confirm New Password</label>
							<input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
						</div>

			      </div>
			      <div class="modal-footer">
			      	<button type="button" class="btn btn-secondary btn-sm float-left" data-dismiss="modal">Close</button>
			        <button type="submit" class="btn btn-primary btn-sm float-right">Submit</button>
			      </div>
			     </form>
			    </div>
			  </div>
			</div>

			<!-- Modal -->
			<div class="modal fade" id="delete-{{ $user->user_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLabel">Delete {{ $user->user_name }}</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-footer">
			      	<button type="button" class="btn btn-secondary btn-sm float-left" data-dismiss="modal">Cancel</button>
			        <a href="{{ route('delete_member_admin',['id' => $user->user_id ]) }}" class="btn btn-warning btn-sm float-right">Delete</a>
			      </div>
			    </div>
			  </div>
			</div>

		@endforeach

@endsection

@section('footer')
	@if(session()->has('type') && session()->get('type') == 'addUser')
	<script type="text/javascript">
		$('#new').modal('toggle');
	</script>
	@endif
	@if(session()->has('type') && session()->get('type') == 'updateUser')
	<script type="text/javascript">
		$('#edit-{{ session()->get('id') }}').modal('toggle');
	</script>
	@endif
@endsection