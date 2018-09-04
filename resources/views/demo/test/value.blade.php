@extends('layouts.demo')
@section('content')
  <ol class="breadcrumb">
    <li><a href="#">Home</a></li>
    <li><a href="{{ URL::to('test/value') }}">Test Simpan Value</a></li>
  </ol>
  <div class="panel panel-default">
    <div class="panel-body" id="print-table">

      <div class="table-responsive" id="table-here">

      </div>

    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-body" id="form-table">
      <h3>Input</h3>
      <div class="table-responsive" id="form-table-here">
        
      </div>

    </div>
  </div>
@endsection

@section('scripts')
  <script type="text/javascript">

    function sendData(){
      var frm = $("#post-data");
        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize(),
            success: function (data) {
                console.log('Submission was successful.');
                console.log(data);
            },
            error: function (data) {
                console.log('An error occurred.');
                console.log(data);
            },
        });
    }

    $(document).ready(function(){

      //get params
      $.get("{{ URL::to('api/v1/activities/1/forms/1/params') }}", function(data, status){
          
          var html = ''; 
          var input = '<form method="post" id="post-data" action="{{ URL::to('api/v1/activities/1/forms') }}"';

          for(var i=0; i < data.length;i++){

            html+='<h3>'+data[i].sip_ref_sub_forms_title+'</h3>';
            input+='<h3>'+data[i].sip_ref_sub_forms_title+'</h3>';

            for(var a=0; a < data[i].tables.length;a++){
              
              var group = data[i].tables[a];

              html+='<table class="table table-striped">';
              html+='<thead><tr><td></td>';

              input+='<table class="table table-striped">';
              input+='<thead><tr><td></td>';

              //columns  
              for(var c=0; c < group.groupcolumns.length;c++){
                var grcolumns = group.groupcolumns[c];
                html+='<td class="text-right">'+grcolumns.sip_ref_columns_title+'</td>';
                input+='<td class="text-right">'+grcolumns.sip_ref_columns_title+'</td>';
              }
              html+='</tr></thead>';
              input+='</tr></thead>';

              html+='<tbody>';
              input+='<tbody>';

              //rows
              for(var r=0; r < group.grouprows.length;r++){
                var grrows = group.grouprows[r];
                
                html+='<tr>';
                input+='<tr>';

                var colspace = grrows.children.length ? 'colspan="2"' : '';
                html+='<td '+colspace+'>'+(r+1)+'.'+grrows.sip_ref_rows_title+'</td>';
                input+='<td '+colspace+'>'+(r+1)+'.'+grrows.sip_ref_rows_title+'</td>';

                if(!grrows.children.length){
                  for(var codes=0;codes < grrows.codes.length;codes++){
                    html+='<td class="text-right">{'+grrows.codes[codes].sip_trx_row_values_code+'}</td>';
                    input+='<td><input type="text" class="form-control" name="'+grrows.codes[codes].sip_trx_row_values_code+'" placeholder="Input '+group.groupcolumns[codes].sip_ref_columns_title+' Here" required></td>';
                  }                  
                }

                //childs
                for(var children=0; children < grrows.children.length;children++){
                  var child = grrows.children[children];
                  html+='<tr>';
                  input+='<tr>';

                  html+='<td>-'+child.sip_ref_rows_title+'</td>';
                  input+='<td>-'+child.sip_ref_rows_title+'</td>';

                  for(var codes=0;codes < child.codes.length;codes++){
                    html+='<td class="text-right">{'+child.codes[codes].sip_trx_row_values_code+'}</td>';
                    input+='<td><input type="text" class="form-control" name="'+child.codes[codes].sip_trx_row_values_code+'" placeholder="Input '+group.groupcolumns[codes].sip_ref_columns_title+' Here" required></td>';
                  }

                  html+='</tr>';
                  input+='</tr>';
                }

                html+='</tr>';
                input+='</tr>';
              }

              html+='<tbody></table>';

              input+='<tbody>';
              input+='</table>';
            }

          }

          input+='<button type="button" class="btn btn-default pull-right" onClick="sendData()" id="send-post-data">Submit</button></form>';

          $('#table-here').html(html);
          $('#form-table-here').html(input);

      });
      
    });
  </script>
@endsection
