@extends('layouts.main')

@section('content')

<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <button onclick="showmodal()" class="btn btn-primary btn-sm">Tambah</button>

                    <!-- Modal -->
                    <div class="modal fade" id="saldoChangeModal" tabindex="-1" role="dialog" aria-labelledby="saldoChangeModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="saldoChangeModalLabel">Saldo</h5>
                                    <button type="button" class="close" onclick="closemodal()">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="uuid" id="hdnUuid">
                                    <input type="hidden" name="norek" id="hdnNorek">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="txtSaldo">Saldo</label>
                                                <input type="text" class="form-control" name="saldo" id="txtSaldo" oninput="numonlyrp()">
                                            </div>
                                            <small id="rpdSaldo"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" onclick="closemodal()">Close</button>
                                    <button type="button" class="btn btn-primary">Save</button>
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
                                <th>Rekening</th>
                                <th>Saldo</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($saldo as $k => $v)
                            <tr uuid="{{$v->uuid}}" norek="{{$v->norek}}" saldo="{{$v->saldo}}" nama="{{$v->nama}}">
                                <td>{{$k+1}}</td>
                                <td>{{$v->norek}}</td>
                                <td>{{$v->saldo}}</td>
                                <td>{{$v->nama}}</td>
                                <td>{{$v->alamat_ktp}}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Aksi
                                    </button>
                                    <div class="dropdown-menu">
                                        <a onclick="edit('{{$v->uuid}}')" class="dropdown-item">Edit</a>
                                        {{-- <form action="{{ route('saldo.destroy', $v->uuid) }}" method="post">
                                            @method('DELETE')
                                            @csrf
                                            <a class="dropdown-item show_confirm" type="submit">Hapus</a>
                                        </form> --}}
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
        $('#saldoChangeModal').modal('show');
    }
    function closemodal() {
        $('#saldoChangeModal').modal('hide');
    }
    function numonlyrp() {
        var n = $('#txtSaldo').val().replace(/\D/g, "");
        $('#txtSaldo').val(n);
        $('#rpdSaldo').html(Number(n).toLocaleString('id-ID',{style:'currency',currency:'IDR'}));
    }
    $(document).ready(function () {
        
    });
</script>
@endsection