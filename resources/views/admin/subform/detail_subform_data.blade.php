@extends('layouts.admin')

@section('content')
        <section class="section">
          <h1 class="section-header">
            <div>{{ $sub->sip_ref_sub_forms_title }} List</div>
          </h1>
          <nav aria-label="breadcrumb">
          	<ol class="breadcrumb">
          		<li class="breadcrumb-item"><a href="{{ route('dashboard_admin') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('list_form_admin') }}">Form</a></li>    
              <li class="breadcrumb-item"><a href="{{ route('detail_form_admin',['id'=>$form->sip_ref_forms_id]) }}">{{ $form->sip_ref_forms_title }}</a></li>   
              <li class="breadcrumb-item active" >{{ $sub->sip_ref_sub_forms_title }}</li>
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
                    <h4>Group Table</h4>
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
                          <th>Title</th>
                          <th>Created At</th>
                          <th>Action</th>
                        </tr>
                        @foreach($sub->rows()->where('sip_ref_rows_type_row','group')->get() as $data)
                        <tr>
                          <td width="40">
                            <div class="custom-checkbox custom-control">
                              <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-1">
                              <label for="checkbox-1" class="custom-control-label"></label>
                            </div>
                          </td>
                          <td>{{ $data->sip_ref_rows_title }}</td>
                          <td>                          	
                          	{{ $data->created_at }}
                          </td>
                          <td>

              							<div class="dropdown">
              							  <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $data->sip_ref_activities_id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              							    Options
              							  </button>
              							  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $data->sip_ref_rows_id }}">
              							    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit-{{ $data->sip_ref_rows_id }}">Edit</a>
              							    <div class="dropdown-divider"></div>
              							    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete-{{ $data->sip_ref_rows_id }}">Hapus</a>
              							  </div>
              							</div>

                          </td>
                        </tr>
                        @endforeach
                      </table>
                    </div>
                  </div>

                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-12">

                <div class="card">
                  <div class="card-header">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#newColumn">New</button>
                    <h4>Column Table</h4>
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
                          <th>Title</th>
                          <th>Data Type</th>
                          <th>Show Title</th>
                          <th>Parent</th>
                          <th>Group</th>
                          <th>Created At</th>
                          <th>Action</th>
                        </tr>
                        @foreach($sub->columns as $data)
                        <tr>
                          <td width="40">
                            <div class="custom-checkbox custom-control">
                              <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-1">
                              <label for="checkbox-1" class="custom-control-label"></label>
                            </div>
                          </td>
                          <td>{{ $data->sip_ref_columns_title }}</td>
                          <td>{{ $data->sip_ref_columns_val_type }}</td>
                          <td>{{ $data->sip_ref_columns_show_title }}</td>
                          <td>{{ is_object($data->parent) ? $data->parent->sip_ref_columns_title : 'Not Set' }}</td>
                          <td>{{ $data->group->sip_ref_rows_title }}</td>
                          <td>                            
                            {{ $data->created_at }}
                          </td>
                          <td>

                            <div class="dropdown">
                              <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $data->sip_ref_activities_id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Options
                              </button>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $data->sip_ref_columns_id }}">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit-{{ $data->sip_ref_columns_id }}">Edit</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete-{{ $data->sip_ref_columns_id }}">Hapus</a>
                              </div>
                            </div>

                          </td>
                        </tr>
                        @endforeach
                      </table>
                    </div>
                  </div>

                </div>
              </div>
            </div>


            <div class="row">
              <div class="col-12">

                <div class="card">
                  <div class="card-header">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#newRow">New</button>
                    <h4>Row Table</h4>
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
                          <th>Show Title</th>
                          <th>Type</th>
                          <th>Parent</th>
                          <th>group</th>
                          <th>Variable</th>
                          <th>Created At</th>
                          <th>Action</th>
                        </tr>
                        @foreach($sub->rows()->where('sip_ref_rows_type_row','row')->get() as $data)
                        <tr>
                          <td width="40">
                            <div class="custom-checkbox custom-control">
                              <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-1">
                              <label for="checkbox-1" class="custom-control-label"></label>
                            </div>
                          </td>
                          <td>{{ $data->sip_ref_rows_title }}</td>
                          <td>{{ $data->sip_ref_rows_show_title }}</td>
                          <td>{{ $data->sip_ref_rows_type_parent }}</td>
                          <td>{{ $data->sip_ref_rows_parent_id }}</td>
                          <td>{{ $data->sip_ref_rows_group_id }}</td>
                          <td>
                            @foreach($data->codes as $code)
                              ${{ $code->sip_trx_row_values_code }}
                            @endforeach
                          </td>
                          <td>                            
                            {{ $data->created_at }}
                          </td>
                          <td>

                            <div class="dropdown">
                              <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $data->sip_ref_rows_id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Options
                              </button>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $data->sip_ref_rows_id }}">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit-{{ $data->sip_ref_rows_id }}">Edit</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete-{{ $data->sip_ref_rows_id }}">Hapus</a>
                              </div>
                            </div>

                          </td>
                        </tr>
                        @endforeach
                      </table>
                    </div>
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
    		    <form method="post" action="{{ route('add_group_admin',['id'=>$form->sip_ref_forms_id,'sub'=>$sub->sip_ref_sub_forms_id]) }}">
    		      <div class="modal-header">
    		        <h5 class="modal-title" id="exampleModalLabel">New Group</h5>
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
    				    <label for="exampleInputEmail1">Nama Group</label>
    				    <input type="text" class="form-control" value="{{ old('sip_ref_rows_title') }}" name="sip_ref_rows_title" aria-describedby="emailHelp" placeholder="Enter Group Name">
    				  </div>
              <input type="hidden" name="sip_ref_rows_type_row" value="group">
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
        <div class="modal fade" id="newColumn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
            <form method="post" action="{{ route('add_column_admin',['id'=>$form->sip_ref_forms_id,'sub'=>$sub->sip_ref_sub_forms_id]) }}">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Column</h5>
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
                  <label for="sip_ref_columns_title">Nama Kolom</label>
                  <input type="text" class="form-control" name="sip_ref_columns_title" id="sip_ref_columns_title" placeholder="Nama">
                </div>
                <div class="form-group">
                  <label for="sip_ref_rows_title">Pilih Group</label>
                  <select class="form-control" name="sip_ref_columns_group_id">
                    
                    @foreach($sub->rows()->where('sip_ref_rows_type_row','group')->get() as $data)
                       <option value="{{ $data->sip_ref_rows_id }}">{{ $data->sip_ref_rows_title }}</option>
                    @endforeach

                  </select>
                </div>
                <div class="form-group">
                  <label for="sip_ref_rows_title">Type Data</label>
                  <select class="form-control" name="sip_ref_columns_val_type">
                    
                    <option value="text">text</option>
                    <option value="number" SELECTED>number</option>

                  </select>
                </div>
                <div class="form-group">
                  <label for="sip_ref_rows_title">Pilih Parent</label>
                  <select class="form-control" name="sip_ref_columns_parent_id">
                    
                    <option value="0" SELECTED>Not Selected</option>
                    @foreach($sub->columns as $data)
                       <option value="{{ $data->sip_ref_columns_id }}">{{ $data->sip_ref_columns_title }}</option>
                    @endforeach

                  </select>
                </div>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" name="sip_ref_columns_show_title" id="sip_ref_columns_show_title" checked>
                  <label class="custom-control-label" for="sip_ref_columns_show_title">Tampilkan Nama</label>
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
        <div class="modal fade" id="newRow" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
            <form method="post" action="{{ route('add_row_admin',['id'=>$form->sip_ref_forms_id,'sub'=>$sub->sip_ref_sub_forms_id]) }}">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Row</h5>
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
                  <label for="sip_ref_rows_title">Pilih Group</label>
                  <select class="form-control" name="sip_ref_rows_group_id">
                    
                    @foreach($sub->rows()->where('sip_ref_rows_type_row','group')->get() as $data)
                       <option value="{{ $data->sip_ref_rows_id }}">{{ $data->sip_ref_rows_title }}</option>
                    @endforeach

                  </select>
                </div>
                
                <div class="form-group">
                  <label for="sip_ref_rows_title">Nama Baris</label>
                  <input type="text" class="form-control" name="sip_ref_rows_title" id="sip_ref_rows_title" placeholder="Nama" required>
                </div>

                @foreach($sub->columns as $data)          
                <div class="form-group">
                  <label for="sip_trx_row_values_code">Variable Utk Kolom {{ $data->sip_ref_columns_title }}</label>
                  <input type="text" class="form-control" name="sip_trx_row_values_code[]" id="sip_trx_row_values_code" placeholder="Nama">
                  <input type="hidden" name="sip_trx_row_values_column_id[]" value="{{ $data->sip_ref_columns_id }}">
                </div>
                @endforeach

                <div class="form-group">
                  <label for="sip_ref_rows_title">Pilih Parent</label>
                  <select class="form-control" name="sip_ref_rows_parent_id">
                    
                    <option value="0" SELECTED>Not Selected</option>
                    @foreach($sub->rows()->where('sip_ref_rows_type_parent','parent')->where('sip_ref_rows_type_row','row')->get() as $data)
                       <option value="{{ $data->sip_ref_rows_id }}">{{ $data->sip_ref_rows_title }}</option>
                    @endforeach

                  </select>
                </div>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" name="sip_ref_rows_show_title" id="sip_ref_rows_show_title" checked>
                  <label class="custom-control-label" for="sip_ref_rows_show_title">Tampilkan Nama</label>
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
@endsection

@section('footer')
	@if(session()->has('type') && session()->get('type') == 'addColumn')
	<script type="text/javascript">
		$('#newColumn').modal('toggle');
	</script>
  @elseif(session()->has('type') && session()->get('type') == 'addRow')
  <script type="text/javascript">
    $('#newRow').modal('toggle');
  </script>
	@endif
	@if(session()->has('type') && session()->get('type') == 'updateUser')
	<script type="text/javascript">
		$('#edit-{{ session()->get('id') }}').modal('toggle');
	</script>
	@endif
@endsection