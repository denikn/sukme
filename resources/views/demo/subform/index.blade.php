@extends('layouts.demo')
@section('content')
  <ol class="breadcrumb">
    <li><a href="#">Home</a></li>
    <li><a href="{{ URL::to('form') }}">Form</a></li>    
    <li><a href="{{ URL::to('form/'.$form->sip_ref_forms_id) }}">{{ $form->sip_ref_forms_title }}</a></li>   
    <li class="active">{{ $sub->sip_ref_sub_forms_title }}</li>
  </ol>

  <div class="panel panel-default">
    <div class="panel-body">

      <h3>Group</h3>

        <form method="post" action="{{ URL::to('form/'.$form->sip_ref_forms_id.'/sub/'.$sub->sip_ref_sub_forms_id.'/group') }}">
          {{ csrf_field() }}
          <div class="form-group">
            <label for="sip_ref_rows_title">Nama Group</label>
            <input type="hidden" name="sip_ref_rows_type_row" value="group">
            <input type="text" class="form-control" name="sip_ref_rows_title" id="sip_ref_rows_title" placeholder="Nama">
          </div>
          <button type="submit" class="btn btn-default">Submit</button>
        </form>

        <table class="table table-striped">
          <thead>
            <tr>
              <td>ID</td>
              <td>Name</td>
            </tr>
          </thead>
          <tbody>
            @foreach($sub->rows()->where('sip_ref_rows_type_row','group')->get() as $data)
            <tr>
              <td>{{ $data->sip_ref_rows_id }}</td>
              <td>{{ $data->sip_ref_rows_title }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>

    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-body">

      <h3>Kolom</h3>

        <form method="post" action="{{ URL::to('form/'.$form->sip_ref_forms_id.'/sub/'.$sub->sip_ref_sub_forms_id.'/col') }}">
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
          <button type="submit" class="btn btn-default">Submit</button>
        </form>

        <table class="table table-striped">
          <thead>
            <tr>
              <td>ID</td>
              <td>Name</td>
              <td>group</td>
            </tr>
          </thead>
          <tbody>
            @foreach($sub->columns as $data)
            <tr>
              <td>{{ $data->sip_ref_columns_id }}</td>
              <td>{{ $data->sip_ref_columns_title }}</td>
              <td>{{ $data->group->sip_ref_rows_title }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>

    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-body">

      <h3>Baris</h3>

        <form method="post" action="{{ URL::to('form/'.$form->sip_ref_forms_id.'/sub/'.$sub->sip_ref_sub_forms_id.'/row') }}">
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
            <input type="text" class="form-control" name="sip_trx_row_values_code[]" id="sip_trx_row_values_code" placeholder="Nama" required>
            <input type="hidden" name="sip_trx_row_values_column_id[]" value="{{ $data->sip_ref_columns_id }}">
          </div>
          @endforeach

          <div class="form-group">
            <label for="sip_ref_rows_title">Pilih Parent</label>
            <select class="form-control" name="sip_ref_rows_parent_id">
              
              <option value="0" SELECTED>Not Selected</option>
              @foreach($sub->rows()->where('sip_ref_rows_type_parent','parent')->get() as $data)
                 <option value="{{ $data->sip_ref_rows_id }}">{{ $data->sip_ref_rows_title }}</option>
              @endforeach

            </select>
          </div>

          <button type="submit" class="btn btn-default">Submit</button>
        </form>

        <table class="table table-striped">
          <thead>
            <tr>
              <td>ID</td>
              <td>Name</td>
              <td>Type</td>
              <td>Parent</td>
              <td>group</td>
              <td>Variable</td>
            </tr>
          </thead>
          <tbody>
            @foreach($sub->rows()->where('sip_ref_rows_type_row','row')->get() as $data)
              <tr>
                <td>{{ $data->sip_ref_rows_id }}</td>
                <td>{{ $data->sip_ref_rows_title }}</td>
                <td>{{ $data->sip_ref_rows_type_parent }}</td>
                <td>{{ $data->sip_ref_rows_parent_id }}</td>
                <td>{{ $data->sip_ref_rows_group_id }}</td>
                <td>
                  @foreach($data->codes as $code)
                    ${{ $code->sip_trx_row_values_code }}
                  @endforeach
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>

    </div>
  </div>

@endsection
