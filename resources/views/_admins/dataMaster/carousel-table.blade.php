@extends('layouts.mst')
@section('title', 'Halaman Admin: Tabel Carousel | '.env('APP_NAME').' - Aplikasi Pengarsipan Surat dan Disposisi | Dinas Pertanian dan Ketahanan Pangan Kota Madiun')
@section('content')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Carousels
                            <small>Table</small>
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link" data-toggle="tooltip" title="Minimize" data-placement="left">
                                    <i class="fa fa-chevron-up"></i></a></li>
                            <li><a onclick="createCarousel()" data-toggle="tooltip" title="Create"
                                   data-placement="right">
                                    <i class="fa fa-plus"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Details</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @php $no = 1; @endphp
                            @foreach($carousels as $carousel)
                                <tr>
                                    <td style="vertical-align: middle" align="center">{{$no++}}</td>
                                    <td style="vertical-align: middle">
                                        <img class="img-responsive" alt="{{$carousel->image}}"
                                             src="{{asset('images/carousels/'.$carousel->image)}}"
                                             style="width: 100px;float: left;margin-right: .5em;margin-bottom: .5em">
                                        <table style="margin: 0">
                                            <tr data-toggle="tooltip" data-placement="left" title="Caption">
                                                <td><i class="fa fa-quote-left"></i>&nbsp;</td>
                                                <td><strong>{{$carousel->captions}}</strong></td>
                                            </tr>
                                            <tr data-toggle="tooltip" data-placement="left" title="Created at">
                                                <td><i class="fa fa-calendar-alt"></i>&nbsp;</td>
                                                <td>{{\Carbon\Carbon::parse($carousel->created_at)->format('j F Y')}}</td>
                                            </tr>
                                            <tr data-toggle="tooltip" data-placement="left" title="Last update">
                                                <td><i class="fa fa-clock"></i>&nbsp;</td>
                                                <td>{{$carousel->updated_at->diffForHumans()}}</td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="vertical-align: middle" align="center">
                                        <a onclick='editCarousel("{{$carousel->id}}","{{$carousel->image}}",
                                                "{{$carousel->captions}}")'
                                           class="btn btn-warning btn-sm" style="font-size: 16px" data-toggle="tooltip"
                                           title="Edit" data-placement="left">
                                            <i class="fa fa-edit"></i></a>
                                        <a href="{{route('delete.carousels',['id'=>encrypt($carousel->id)])}}"
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Create Form</h4>
                </div>
                <form method="post" action="{{route('create.carousels')}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input type="hidden" name="admin_id" value="{{Auth::guard('admin')->user()->id}}">
                    <div class="modal-body">
                        <div class="row form-group">
                            <div class="col-lg-12">
                                <label for="image">Image <span class="required">*</span></label>
                                <input type="file" name="image" style="display: none;" accept="image/*" id="image"
                                       required>
                                <div class="input-group">
                                    <input type="text" id="txt_image"
                                           class="browse_files form-control"
                                           placeholder="Upload file here..."
                                           readonly style="cursor: pointer" data-toggle="tooltip" data-placement="top"
                                           title="Ekstensi file yang boleh diunggah: jpg, jpeg, gif, png. Ukuran file maksimal: < 1 MB">
                                    <span class="input-group-btn">
                                        <button class="browse_files btn btn-info" type="button">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-12 has-feedback">
                                <label for="captions">Captions <span class="required">*</span></label>
                                <input id="captions" type="text" class="form-control" maxlength="191" name="captions"
                                       placeholder="Carousel captions" required>
                                <span class="fa fa-text-height form-control-feedback right" aria-hidden="true"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="editModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Edit Form</h4>
                </div>
                <div id="editModalContent"></div>
            </div>
        </div>
    </div>
@endsection
@push("scripts")
    <script>
        function createCarousel() {
            $("#createModal").modal('show');
        }

        function editCarousel(id, image, captions) {
            $('#editModalContent').html(
                '<form method="post" id="' + id + '" enctype="multipart/form-data" ' +
                'action="{{url('admin/tables/web_contents/carousels')}}/' + id + '/update">' +
                '{{csrf_field()}} {{method_field('PUT')}}' +
                '<div class="modal-body">' +
                '<div class="row form-group">' +
                '<div class="col-lg-12 has-feedback">' +
                '<img style="margin: 0 auto;width: 50%;cursor:pointer" class="img-responsive" id="btn_img' + id + '" ' +
                'src="{{asset('images/carousels/')}}/' + image + '" data-toggle="tooltip" data-placement="bottom" ' +
                'title="Ekstensi file yang boleh diunggah: jpg, jpeg, gif, png. Ukuran file maksimal: < 2 MB">' +
                '<label for="image' + id + '">Image <span class="required">*</span></label>' +
                '<input type="file" name="image" style="display: none;" accept="image/*" id="image' + id + '">' +
                '<div class="input-group">' +
                '<input type="text" id="txt_image' + id + '" class="browse_files form-control" value="' + image + '" ' +
                'readonly style="cursor: pointer" data-toggle="tooltip" data-placement="top" ' +
                'title="Ekstensi file yang boleh diunggah: jpg, jpeg, gif, png. Ukuran file maksimal: < 2 MB">' +
                '<span class="input-group-btn">' +
                '<button class="browse_files btn btn-info" type="button"><i class="fa fa-search"></i></button>' +
                '</span></div></div></div>' +
                '<div class="row form-group">' +
                '<div class="col-lg-12 has-feedback">' +
                '<label for="captions' + id + '">Captions <span class="required">*</span></label>' +
                '<input id="captions' + id + '" type="text" class="form-control" maxlength="191" name="captions"' +
                'value="' + captions + '" required>' +
                '<span class="fa fa-text-height form-control-feedback right" aria-hidden="true"></span>' +
                '</div></div></div>' +
                '<div class="modal-footer">' +
                '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>' +
                '<button type="submit" class="btn btn-primary">Save changes</button></div></form>'
            );
            $("#editModal").modal('show');
            $(".browse_files").on('click', function () {
                $("#image" + id).trigger('click');
            });
            $("#btn_img" + id).on('click', function () {
                $("#image" + id).trigger('click');
            });

            $("#image" + id).on('change', function () {
                var files = $(this).prop("files");
                var names = $.map(files, function (val) {
                    return val.name;
                });
                var txt = $("#txt_image" + id);
                txt.val(names);
                $("#txt_image" + id + "[data-toggle=tooltip]").attr('data-original-title', names).tooltip('show');
            });
        }

        $(".browse_files").on('click', function () {
            $("#image").trigger('click');
        });

        $("#image").on('change', function () {
            var files = $(this).prop("files");
            var names = $.map(files, function (val) {
                return val.name;
            });
            var txt = $("#txt_image");
            txt.val(names);
            $("#txt_image[data-toggle=tooltip]").attr('data-original-title', names).tooltip('show');
        });
    </script>
@endpush