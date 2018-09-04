@extends('layouts.demo')
@section('content')
  <ol class="breadcrumb">
    <li><a href="#">Home</a></li>
    <li><a href="{{ URL::to('form') }}">Form</a></li>
    <li class="active">{{ $form->sip_ref_forms_title }}</li>
  </ol>
  <div class="panel panel-default">
    <div class="panel-body">

      <h3>Sub Forms {{ $form->sip_ref_forms_title }}</h3>

      <form method="post" action="{{ URL::to('form/'.$form->sip_ref_forms_id.'/sub') }}">
        {{ csrf_field() }}
        <div class="form-group">
          <label for="sip_ref_sub_forms_title">Nama Sub Form</label>
          <input type="text" class="form-control" name="sip_ref_sub_forms_title" id="sip_ref_sub_forms_title" placeholder="Nama">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>

        <table class="table table-striped">
          <thead>
            <tr>
              <td>ID</td>
              <td>Name</td>
              <td>Options</td>
            </tr>
          </thead>
          <tbody>
            @foreach($form->subs as $data)
            <tr>
              <td>{{ $data->sip_ref_sub_forms_id }}</td>
              <td>{{ $data->sip_ref_sub_forms_title }}</td>
              <td>
                <!-- Single button -->
                <div class="btn-group">
                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu">
                    <li><a href="{{ URL::to('form/'.$form->sip_ref_forms_id.'/sub/'.$data->sip_ref_sub_forms_id) }}">Kelola Tabel</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="#">Hapus</a></li>
                  </ul>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>

    </div>
  </div>

@endsection
