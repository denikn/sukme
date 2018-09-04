@extends('layouts.demo')
@section('content')
  <form method="post" action="{{ URL::to('form') }}">
    {{ csrf_field() }}
    <div class="form-group">
      <label for="sip_ref_forms_title">Nama Form</label>
      <input type="text" class="form-control" name="sip_ref_forms_title" id="sip_ref_forms_title" placeholder="Nama">
    </div>
    <div class="form-group">
      <label for="sip_ref_forms_activity_id">Jenis Kategori</label>
      <select class="form-control" name="sip_ref_forms_activity_id">
        @foreach($activities as $data)
          <option value="{{ $data->sip_ref_activities_id }}">{{ $data->sip_ref_activities_name }}</option>
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
          <td>Kegiatan</td>
          <td>Options</td>
        </tr>
      </thead>
      <tbody>
        @foreach($forms as $data)
        <tr>
          <td>{{ $data->sip_ref_forms_id }}</td>
          <td>{{ $data->sip_ref_forms_title }}</td>
          <td>{{ $data->activity->sip_ref_activities_name }}</td>
          <td>
            <!-- Single button -->
            <div class="btn-group">
              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Action <span class="caret"></span>
              </button>
              <ul class="dropdown-menu">
                <li><a href="{{ URL::to('form/'.$data->sip_ref_forms_id) }}">Kelola</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="#">Hapus</a></li>
              </ul>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

@endsection
