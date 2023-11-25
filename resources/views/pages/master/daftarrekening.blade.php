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
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Daftar rekening</h5>
                                    <button onclick="closemodal()" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <label for="form-control">Bank</label>
                                            <input type="text" class="form-control" id="bnk" placeholder="Masukan nama bank">
                                            <input type="hidden" id="uuid">
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="form-control">No. Rekening</label>
                                            <input type="number" min="0" max="100" class="form-control" id="norek" placeholder="Masukan nomor rekening">
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="form-control">Atas nama</label>
                                            <input type="text" class="form-control" id="ats" placeholder="Masukan atas nama">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button onclick="closemodal()" type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                    <button onclick="simpandata()" type="button" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end modal -->

                </div>
                <div class="card-body">
                    <table class="table table-hover" id="default-ordering" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Bank</th>
                                <th>No. Rekening</th>
                                <th>Atas Nama</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rekening as $key => $value)
                            <tr>
                                <td width="1%">{{$key + 1}}</td>
                                <td>{{$value->bank}}</td>
                                <td>{{$value->norek}}</td>
                                <td>{{$value->atas_nama}}</td>
                                <td>
                                    @if($value->status == 0)
                                    <span class="badge badge-danger">Non Aktif</span>
                                    @else
                                    <span class="badge badge-info">Aktif</span>
                                    @endif
                                </td>
                                <td width="15%">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Aksi
                                    </button>
                                    <div class="dropdown-menu">
                                        <a onclick="editrekening('{{$value}}')" class="dropdown-item">Edit</a>
                                        @if($value->status == 1)
                                        <a onclick="nonactive('{{$value->uuid}}', 0)" class="dropdown-item">Non aktif</a>
                                        @else
                                        <a onclick="nonactive('{{$value->uuid}}', 1)" class="dropdown-item">Aktif</a>
                                        @endif
                                        <form action="{{ route('daftar-rekening.destroy', $value->uuid) }}" method="post">
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
        $('#bnk').val('');
        $('#norek').val('');
        $('#ats').val('');
        $('#uuid').val('');

        $('#bnk').removeClass("is-invalid");
        $('#norek').removeClass("is-invalid");
        $('#ats').removeClass("is-invalid");
    }

    function simpandata() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery.ajax({
            url: '/daftar-rekening',
            method: 'post',
            data: {
                bank: $('#bnk').val(),
                norek: $('#norek').val(),
                atas_nama: $('#ats').val(),
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
                    $('#bnk').addClass("is-invalid");
                    $('#norek').addClass("is-invalid");
                    $('#ats').addClass("is-invalid");
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


    function editrekening(value) {
        var item = JSON.parse(value)
        $('#bnk').val(item.bank);
        $('#norek').val(item.norek);
        $('#ats').val(item.atas_nama);
        $('#uuid').val(item.uuid);
        showmodal();
    }


    function nonactive(uuid, status) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery.ajax({
            url: '/daftar-rekening/' + uuid,
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