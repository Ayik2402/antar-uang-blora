@extends('layouts.main')

@section('content')

<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <button onclick="$('#txtNasabahId').val(null).trigger('change');showmodal();" type="button" class="btn btn-primary btn-sm">Tambah</button>
                    <button onclick="showmodalimp()" type="button" class="btn btn-success btn-sm">Import</button>

                    <form action="/saldo" method="post">
                        @csrf
                        <!-- Modal -->
                        <div class="modal fade" id="saldoChangeModal" tabindex="-1" role="dialog" aria-labelledby="saldoChangeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
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
                                                    <label for="txtSaldo">Nasabah</label>
                                                    <select class="form-control" name="nasabah_id" id="txtNasabahId" onchange="nsbchngd()" required>
                                                        <option></option>
                                                        @foreach ($nasabah as $v)
                                                            <option value="{{$v->uuid}}" norek="{{$v->norek}}">{{$v->nama}} ({{$v->norek}})</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="txtSaldo">Saldo</label>
                                                    <input type="text" class="form-control" name="saldo" id="txtSaldo" oninput="numonlyrp()" required>
                                                    <small id="rpdSaldo"></small>
                                                </div>
                                                <div class="form-group">
                                                    <label for="txtMengendap">Mengendap</label>
                                                    <input type="text" class="form-control" name="mengendap" id="txtMengendap" oninput="numonlyrpedp()" required>
                                                    <small id="rpdMengendap"></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" onclick="closemodal()">Close</button>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end modal -->
                    </form>

                    <form action="/saldoimport" method="post" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <!-- Modal -->
                        <div class="modal fade" id="saldoImpModal" tabindex="-1" role="dialog" aria-labelledby="saldoImpModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="saldoImpModalLabel">Import</h5>
                                        <button type="button" class="close" onclick="closemodalimp()">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body m-3">
                                        <div class="row mb-1">
                                            <div class="col-lg-12">
                                                <label for="">Import file</label>
                                                <input type="file" class="form-control" name="import_file" id="filImportSaldo" accept=".xls,.xlsx" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-lg-12">
                                                <b>Ketentuan import file saldo</b>
                                                <li id="unduhTempltSaldoImprtLbl">Klik untuk unduh template saldo: <a href="#unduhTempltSaldoImprtLbl" class="badge badge-success" onclick="exporttemplatesaldoexcel()">Unduh template saldo</a></li>
                                                <li>Pastikan file excel dengan extensi .xlsx</li>
                                                <li>Pastikan file excel hanya ada 1 sheet</li>
                                                <li>Pastikan pengisian excel dimulai pada baris <b>A2</b> tidak pada baris yang lain</li>
                                                <li>Apabila nomor rekening berawal dengan angka 0 maka diwajibkan untuk menambah petik (') sebelum angka 0</li>
                                                <li>Pada kolom <b>SALDO DAN MENGENDAP</b> harus format angka tanpa ada label string Rp dll</li>
                                                <li>Pastikan tidak menggunakan rumus excel pada kolom yang sudah ditentukan </li>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" onclick="closemodalimp()">Close</button>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end modal -->
                    </form>

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
                            <tr uuid="{{$v->uuid}}" nasabah_id="{{$v->nasabah_id}}" norek="{{$v->norek}}" saldo="{{$v->saldo}}" mengendap="{{$v->mengendap}}" nama="{{$v->nama}}">
                                <td>{{$k+1}}</td>
                                <td>{{$v->norek}}</td>
                                <td>
                                    <span class="sldToMnStyl">
                                        {{$v->saldo}}
                                    </span>
                                    <br>
                                    <small>
                                        Mengendap: <span class="sldToMnStyl">{{$v->mengendap}}</span>
                                    </small>
                                </td>
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
<div hidden>
    <table id="prtblhdn" data-cols-width="30,30,30">
        <tr>
            <th>REKENING</th>
            <th>SALDO</th>
            <th>MENGENDAP</th>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
</div>
<script src="/tableToExcel.js"></script>
<script>
    function showmodal() {
        $('#saldoChangeModal').modal('show');
    }
    function closemodal() {
        $('#saldoChangeModal').modal('hide');
    }
    function showmodalimp() {
        $('#filImportSaldo').val('')
        $('#saldoImpModal').modal('show');
    }
    function closemodalimp() {
        $('#saldoImpModal').modal('hide');
    }
    function numonlyrp() {
        var n = $('#txtSaldo').val().replace(/\D/g, "");
        $('#txtSaldo').val(n);
        $('#rpdSaldo').html(Number(n).toLocaleString('id-ID',{style:'currency',currency:'IDR'}));
    }
    function numonlyrpedp() {
        var n = $('#txtMengendap').val().replace(/\D/g, "");
        $('#txtMengendap').val(n);
        $('#rpdMengendap').html(Number(n).toLocaleString('id-ID',{style:'currency',currency:'IDR'}));
    }
    function nsbchngd() {
        var n = $('#txtNasabahId').val();
        var o = $('option[value="'+n+'"]').attr('norek');
        $('#hdnNorek').val(o);
    }
    function exporttemplatesaldoexcel() {
        TableToExcel.convert(document.getElementById("prtblhdn"), {
            name: "importsaldo.xlsx"
        });
    }
    function edit(id) {
        var t = $('tr[uuid="'+id+'"]');
        var nasabah_id = t.attr('nasabah_id');
        var norek = t.attr('norek');
        var saldo = t.attr('saldo');
        var nama = t.attr('nama');
        var mengendap = t.attr('mengendap');
        $('#txtNasabahId').val(nasabah_id).trigger('change');
        $('#txtSaldo').val(saldo).trigger('input');
        $('#txtMengendap').val(mengendap).trigger('input');
        showmodal();
    }
    $(document).ready(function () {
        $('.sldToMnStyl').each(function (index, element) {
            // element == this
            var t = $(this);
            t.html(Number(t.html().replace(/\D/g, "")).toLocaleString('id-ID',{style:'currency',currency:'IDR'}));
        });
        $('#txtNasabahId').select2({
			placeholder: "Pilih Nasabah",
			dropdownParent: $("#txtNasabahId").parent()
        });
    });
</script>
@endsection