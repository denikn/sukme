@extends('layouts.admin')

@section('content')
        <section class="section">
          <h1 class="section-header">
            <div>Activity List</div>
          </h1>
          <nav aria-label="breadcrumb">
          	<ol class="breadcrumb">
          		<li class="breadcrumb-item"><a href="{{ route('dashboard_admin') }}">Home</a></li>
          		<li class="breadcrumb-item active" aria-current="page">{{ $form->sip_ref_forms_title }}</li>
          	</ol>
          </nav>

          <div class="section-body">
        
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Filter Data</h5>
                    <form class="form-inline">

                      <div class="form-group mx-sm-3 mb-2">
                        <label for="exampleInputEmail1">Data From &nbsp;</label>
                      <input class="form-control" value="{{ request('from') }}" type="date" name="from">
                      </div>
                      <div class="form-group mx-sm-3 mb-2">
                        <label for="exampleInputEmail1">Data To &nbsp;</label>
                      <input class="form-control" value="{{ request('to') }}" type="date" name="to">
                      </div>
                      <button type="submit" class="btn btn-primary">Generate</button>

                    </form>
                  </div>
                </div>

              </div>

            </div>
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-body">

                    <div class="row">
                      <div class="col-12">
                        <div class="dropdown float-right">
                          <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Download
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{ route('download_excel_activity_member',['id' => $activity->sip_ref_activities_id,'from' => request('from'), 'to' => request('to')]) }}">Excel</a>
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>

              </div>

            </div>

            @foreach($subs as $sub)
              @if($sub->sip_ref_sub_forms_report_show)
              <div class="row">
                <div class="col-12">

                  <div class="card">
                    <div class="card-header">
                      <h4>{{ $sub->sip_ref_sub_forms_title }} Table</h4>
                    </div>
                    <div class="card-body">

                      <div class="table-responsive" style="min-height: 50vh;">
                        <table class="table table-striped">
                          <tr>
                            <th>Params</th>
                            @foreach($sub->rows as $row)
                              <th>{{ $row->sip_ref_rows_title }}</th>
                            @endforeach
                          </tr>
                                                 
                          @foreach($sub->columns as $col)
                          <tr>
                              <th>{{ $col->sip_ref_columns_title }}</th>

                              @foreach($sub->rows as $row)
                              <th>
                                  {{ $row->formvalues($row,$col,$sub)->sum('sip_trx_form_values_value_string') }}
                              </th>
                              @endforeach
                          </tr>
                          @endforeach

                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              @endif
            @endforeach

          </div>
        </section>

@endsection
