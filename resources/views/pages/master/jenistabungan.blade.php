@extends('layouts.main')

@section('content')

<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <button onclick="showmodal()" class="btn btn-primary btn-sm">Tambah</button>

                    <!-- Modal -->
                    <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Jenis tabungan</h5>
                                    <button onclick="closemodal()" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label for="form-control">Jenis tabungan</label>
                                            <input type="text" class="form-control" id="tb" placeholder="Masukan jenis tabungan">
                                            <input type="hidden" id="uuid">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button onclick="closemodal()" type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                    <button onclick="simpandata()" type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end modal -->
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="default-ordering" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Jenis tabungan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tab as $key => $value)
                                <tr>
                                    <td width="1%">{{$key + 1}}</td>
                                    <td>{{$value->nama}}</td>
                                    <td>
                                        @if($value->status == 0)
                                        <span class="badge badge-danger">Tidak aktif</span>
                                        @else
                                        <span class="badge badge-info">Aktif</span>
                                        @endif
                                    </td>
                                    <td width="15%">
                                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Aksi
                                        </button>
                                        <div class="dropdown-menu">
                                            <a onclick="editbank('{{$value}}')" class="dropdown-item">Edit</a>
                                            @if($value->status == 1)
                                            <a onclick="nonactive('{{$value->uuid}}', 0)" class="dropdown-item">Non aktifkan</a>
                                            @else
                                            <a onclick="nonactive('{{$value->uuid}}', 1)" class="dropdown-item">Aktifkan</a>
                                            @endif
                                            <form action="{{ route('jenis-tabungan.destroy', $value->uuid) }}" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <a class="dropdown-item show_confirm" type="submit">Hapus</a>
                                            </form>
                                        </div>
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
</div>

<script>
    function showmodal() {
        $("#modelId").modal({
            backdrop: "static",
            keyboard: true,
            show: true,
        });
    }

    function closemodal() {
        $("#modelId").modal("hide");
        $('#tb').val('');
        $('#uuid').val('');
        $('#tb').removeClass("is-invalid");
    }

    function simpandata() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery.ajax({
            url: '/jenis-tabungan',
            method: 'post',
            data: {
                tabungan: $('#tb').val(),
                uuid: $('#uuid').val(),
            },
            success: function(result) {
                closemodal()
                Swal.fire({
                    icon: 'success',
                    title: result.msg,
                    showConfirmButton: true,
                    timer: 1500
                }).then(function() {
                    location.reload();
                })
            },
            error: function(jqXhr, json, errorThrown) { // this are default for ajax errors 
                var errors = jqXhr.responseJSON;
                var litag = '';
                $.each(errors['errors'], function(index, value) {
                    $('#tb').addClass("is-invalid");
                    litag += '<li>' + value + '</li>';
                });
                Swal.fire({
                    icon: 'info',
                    html: litag,
                    showCloseButton: true,
                    showCancelButton: true,
                    focusConfirm: false,
                    confirmButtonAriaLabel: 'Confirm',
                })
            }
        })
    }

    function editbank(value) {
        var item = JSON.parse(value);
        $('#tb').val(item.nama);
        $('#uuid').val(item.uuid);
        showmodal()
    }

    function nonactive(uuid, status) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery.ajax({
            url: '/jenis-tabungan/' + uuid,
            method: 'PUT',
            data: {
                status: status,
            },
            success: function(result) {
                Swal.fire({
                    icon: 'success',
                    title: result.msg,
                    showConfirmButton: true,
                    timer: 1500
                }).then(function() {
                    location.reload();
                })
            },
        })
    }
</script>
@endsection