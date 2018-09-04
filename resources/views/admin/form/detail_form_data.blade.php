@extends('layouts.admin')

@section('content')
        <section class="section">
          <h1 class="section-header">
            <div>Sub Forms {{ $form->sip_ref_forms_title }}</div>
          </h1>
          <nav aria-label="breadcrumb">
          	<ol class="breadcrumb">
          		<li class="breadcrumb-item"><a href="{{ route('dashboard_admin') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('list_form_admin') }}">Form</a></li>
          		<li class="breadcrumb-item active" aria-current="page">{{ $form->sip_ref_forms_title }}</li>
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
                          <input type="text" class="form-control" name="q" value="{{ request('q') }}" placeholder="Search">
                          <div class="input-group-btn">
                            <button class="btn btn-secondary"><i class="ion ion-search"></i></button>
                          </div>
                          @if(!trim(request('q')) == '')
                      		&nbsp;&nbsp;<a href="{{ route('detail_form_admin',['id'=>$form->sip_ref_forms_id]) }}"><u>reset</u></a>
                      	  @endif
                        </div>
                      </form>
                    </div>
                    <h4>Subform Table</h4>
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
                          <th>Name</th>
                          <th>Type Pengiriman Data</th>
                          <th>Type Tampil Data</th>
                          <th>Tampil Report</th>
                          <th>Created At</th>
                          <th>Action</th>
                        </tr>
                        @foreach($form->subs()->paginate(10) as $data)
                        <tr>
                          <td width="40">
                            <div class="custom-checkbox custom-control">
                              <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-1">
                              <label for="checkbox-1" class="custom-control-label"></label>
                            </div>
                          </td>
                          <td>
                            {{ $data->sip_ref_sub_forms_title }}
                          </td>
                          <td>
                            {{ $data->sip_ref_sub_forms_send_type }}
                          </td>
                          <td>
                            {{ $data->sip_ref_sub_forms_show_type }}
                          </td>
                          <td>
                            {{ $data->sip_ref_sub_forms_report_show }}
                          </td>
                          <td>                          	
                          	{{ $data->created_at }}
                          </td>
                          <td>

              							<div class="dropdown">
              							  <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $data->sip_ref_sub_forms_id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              							    Options
              							  </button>
              							  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $data->sip_ref_sub_forms_id }}">
                                <a class="dropdown-item" href="{{ route('list_subform_admin',['id'=>$form->sip_ref_forms_id,'sub' => $data->sip_ref_sub_forms_id]) }}" >Kelola</a>
              							    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit-{{ $data->sip_ref_sub_forms_id }}">Edit</a>
              							    <div class="dropdown-divider"></div>
              							    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete-{{ $data->sip_ref_sub_forms_id }}">Set Not Active</a>
              							  </div>
              							</div>

                          </td>
                        </tr>
                        @endforeach
                      </table>
                    </div>
                  </div>
                  <div class="card-footer text-right">
                  	{{ $form->subs()->paginate(10)->links('vendor.pagination.bootstrap-4') }}
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
		    <form method="post" action="{{ route('add_subform_admin',['id' => $form->sip_ref_forms_id]) }}">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">New Form</h5>
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
  				    <label for="exampleInputEmail1">Nama Subform</label>
  				    <input type="text" class="form-control" value="{{ old('sip_ref_sub_forms_title') }}" name="sip_ref_sub_forms_title" aria-describedby="emailHelp" placeholder="Enter Title">
  				  </div>
            <div class="form-group">
              <label for="sip_ref_rows_title">Type Pengiriman Data</label>
              <select class="form-control" name="sip_ref_sub_forms_send_type">
                
                <option value="bulk">bulk</option>
                <option value="single" SELECTED>single</option>

              </select>
            </div>
            <div class="form-group">
              <label for="sip_ref_rows_title">Type Tampil Data</label>
              <select class="form-control" name="sip_ref_sub_forms_show_type">
                
                <option value="bulk" SELECTED>bulk</option>
                <option value="single">single</option>

              </select>
            </div>
            <div class="form-group">
              <label for="sip_ref_rows_title">Tampil Report</label>
              <select class="form-control" name="sip_ref_sub_forms_report_show">
                
                <option value="1" SELECTED>Yes</option>
                <option value="0">No</option>

              </select>
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

		@foreach($form->subs()->paginate(10) as $data)

    <!-- Modal -->
    <div class="modal fade" id="edit-{{ $data->sip_ref_sub_forms_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
        <form method="post" action="{{ route('update_subform_admin',['id' => $data->sip_ref_sub_forms_id]) }}">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Update {{ $data->sip_ref_sub_forms_title }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          
            @if($errors->any())
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
              <label for="exampleInputEmail1">Nama Subform</label>
              <input type="text" class="form-control" value="{{ $data->sip_ref_sub_forms_title }}" name="sip_ref_sub_forms_title" aria-describedby="emailHelp" placeholder="Enter Title">
            </div>
            <div class="form-group">
              <label for="sip_ref_rows_title">Type Pengiriman Data</label>
              <select class="form-control" name="sip_ref_sub_forms_send_type">
                
                <option value="bulk" {{ $data->sip_ref_sub_forms_send_type == 'bulk' ? 'SELECTED' : '' }}>bulk</option>
                <option value="single" {{ $data->sip_ref_sub_forms_send_type == 'single' ? 'SELECTED' : '' }}>single</option>

              </select>
            </div>
            <div class="form-group">
              <label for="sip_ref_rows_title">Type Tampil Data</label>
              <select class="form-control" name="sip_ref_sub_forms_show_type">
                
                <option value="bulk" {{ $data->sip_ref_sub_forms_show_type == 'bulk' ? 'SELECTED' : '' }}>bulk</option>
                <option value="single" {{ $data->sip_ref_sub_forms_show_type == 'single' ? 'SELECTED' : '' }}>single</option>

              </select>
            </div>
            <div class="form-group">
              <label for="sip_ref_rows_title">Tampil Report</label>
              <select class="form-control" name="sip_ref_sub_forms_report_show">
                
                <option value="1" {{ $data->sip_ref_sub_forms_report_show == 'bulk' ? 'SELECTED' : '' }}>Yes</option>
                <option value="0" {{ $data->sip_ref_sub_forms_report_show == 'single' ? 'SELECTED' : '' }}>No</option>

              </select>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm float-left" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-sm float-right">Update</button>
          </div>
         </form>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="delete-{{ $data->sip_ref_sub_forms_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Are you sure want to set not active {{ $data->sip_ref_sub_forms_title }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-footer">
            <a href="{{ route('delete_subform_admin',['id' => $data->sip_ref_sub_forms_id]) }}" class="btn btn-primary btn-sm float-right">Proses</a>
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