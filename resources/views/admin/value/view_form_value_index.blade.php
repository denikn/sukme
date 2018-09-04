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
