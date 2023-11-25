@extends('layouts.main')

@section('content')

<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    @if(count($biaya) < 0) <button class="btn btn-primary btn-sm" onclick="showmodal()">Tambah</button>
                        @else
                        <button class="btn btn-primary btn-sm" onclick="showmodal()">Tambah</button>
                        @endif
                        <!-- Modal -->
                        <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Biaya transaksi</h5>
                                        <button onclick="closemodal()" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <label for="form-control">Nominal transaksi</label>
                                                <input oninput="nominals()" type="text" class="form-control" id="nom" placeholder="Nominal biaya transfer">
                                                <input type="hidden" id="uuid">
                                                <input type="hidden" id="jmltf">
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
                                    <th>Bank</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($biaya as $key => $value)
                                <tr>
                                    <td width="1%">{{$key + 1}}</td>
                                    <td>Rp. {{number_format($value->nominal)}}</td>

                                    <td width="15%">
                                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Aksi
                                        </button>
                                        <div class="dropdown-menu">
                                            <a onclick="editbank('{{$value}}')" class="dropdown-item">Edit</a>

                                            <form action="{{ route('biaya-transfer.destroy', $value->uuid) }}" method="post">
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
        $('#nom').val('');
        $('#uuid').val('');
        $('#nom').removeClass("is-invalid");
    }

    function nominals() {
        var nominal = $('#nom').val().replace(/\D/g, "");

        var xx = new Intl.NumberFormat('id-ID', {
            style: "currency",
            currency: "IDR",
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(nominal);
        $('#nom').val(xx);
        $('#jmltf').val(nominal);
    }

    function simpandata() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery.ajax({
            url: '/biaya-transfer',
            method: 'post',
            data: {
                nominal: $('#jmltf').val(),
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
                    $('#nom').addClass("is-invalid");
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
        showmodal()
        var item = JSON.parse(value)
        var xx = new Intl.NumberFormat('id-ID', {
            style: "currency",
            currency: "IDR",
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(item.nominal);
        $('#nom').val(xx);
        $('#jmltf').val(item.nominal);
        $('#uuid').val(item.uuid);
    }
</script>
@endsection