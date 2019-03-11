@extends('layouts.mst')
@section('title', 'Halaman Admin: Tabel Perihal Surat | '.env('APP_NAME').' - Aplikasi Pengarsipan Surat dan Disposisi | Dinas Pertanian dan Ketahanan Pangan Kota Madiun')
@section('content')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Perihal Surat
                            <small>Table</small>
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link" data-toggle="tooltip" title="Minimize" data-placement="left">
                                    <i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="btn_create" data-toggle="tooltip" title="Create" data-placement="right">
                                    <i class="fa fa-plus"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Perihal</th>
                                <th>Created at</th>
                                <th>Last Update</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @php $no = 1; @endphp
                            @foreach($perihal_surats as $perihal_surat)
                                <tr>
                                    <td style="vertical-align: middle" align="center">{{$no++}}</td>
                                    <td style="vertical-align: middle" align="center">
                                        <strong>{{$perihal_surat->kode}}</strong></td>
                                    <td style="vertical-align: middle"><strong>{{$perihal_surat->perihal}}</strong></td>
                                    <td style="vertical-align: middle">{{\Carbon\Carbon::parse($perihal_surat->created_at)->format('j F Y')}}</td>
                                    <td style="vertical-align: middle">{{$perihal_surat->updated_at->diffForHumans()}}</td>
                                    <td style="vertical-align: middle" align="center">
                                        <a onclick='editPerihalSurat("{{$perihal_surat->id}}",
                                                "{{$perihal_surat->kode}}","{{$perihal_surat->perihal}}")'
                                           class="btn btn-warning btn-sm" style="font-size: 16px" data-toggle="tooltip"
                                           title="Edit" data-placement="left"><i class="fa fa-edit"></i></a>
                                        <a href="{{route('delete.perihal-surat',['id'=>encrypt($perihal_surat->id)])}}"
                                           class="btn btn-danger btn-sm delete-data" style="font-size: 16px"
                                           data-toggle="tooltip"
                                           title="Delete" data-placement="right"><i class="fa fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="createModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" style="width: 50%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Create Form</h4>
                </div>
                <form method="post" action="{{route('create.perihal-surat')}}" id="form-perihal">
                    {{csrf_field()}}
                    <input id="method" type="hidden" name="_method">
                    <div class="modal-body">
                        <div class="row form-group">
                            <div class="col-lg-12">
                                <label for="kode">Perihal <span class="required">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-thumbtack"></i></span>
                                    <input id="kode" type="text" class="form-control" maxlength="3" name="kode"
                                           placeholder="Kode perihal" style="width: 25%" required>
                                    <input id="perihal" type="text" class="form-control" maxlength="191" name="perihal"
                                           placeholder="Perihal surat" style="width: 75%" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push("scripts")
    <script>
        $(".btn_create, #createModal .modal-footer button[type=reset]").on("click", function () {
            $("#createModal .modal-title").html('Buat Perihal Surat');
            $("#form-perihal").prop("action", "{{route('create.perihal-surat')}}");
            $("#method, #kode, #perihal").val('');
            $("#createModal .modal-footer button[type=submit]").text('Submit');
            $("#createModal").modal('show');
        });

        function editPerihalSurat(id, kode, perihal) {
            $("#createModal .modal-title").html('Edit Perihal Surat #<strong>' + kode + '</strong>');
            $("#form-perihal").prop("action", "{{url('admin/tables/web_contents/perihal_surat')}}/" + id + "/update");
            $("#method").val('PUT');
            $("#kode").val(kode);
            $("#perihal").val(perihal);
            $("#createModal .modal-footer button[type=submit]").text('Simpan Perubahan');
            $("#createModal").modal('show');
        }

        $("#kode").inputmask({mask: "999", placeholder: "___"});
    </script>
@endpush