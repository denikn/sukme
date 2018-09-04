@extends('layouts.demo')
@section('content')
  <form method="post" action="{{ URL::to('activity') }}">
    {{ csrf_field() }}
    <div class="form-group">
      <label for="sip_ref_activities_name">Nama Kegiatan</label>
      <input type="text" class="form-control" name="sip_ref_activities_name" id="sip_ref_activities_name" placeholder="Nama">
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
  </form>

  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <td>ID</td>
          <td>Name</td>
        </tr>
      </thead>
      <tbody>
        @foreach($activities as $data)
        <tr>
          <td>{{ $data->sip_ref_activities_id }}</td>
          <td>{{ $data->sip_ref_activities_name}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection
