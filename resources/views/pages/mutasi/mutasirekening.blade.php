@extends('layouts.main')

@section('content')

<div class="layout-px-spacing">

    <div class="row layout-top-spacing">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <!-- Button trigger modal -->
                    <div class="row">
                        <div class="col-lg-6 d-flex justify-content-start">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modelId">
                                Unggah data mutasi
                            </button>
                            <form action="/hapussemuamutasi" class="ml-3" method="post">
                                @csrf
                                <input type="hidden" id="trts" name="mutasiid">

                                <button type="submit" class="btn btn-danger btn-sm">Hapus semua</button>
                            </form>
                        </div>
                    </div>


                    <!-- Modal -->
                    <div class="modal fade" data-backdrop="static" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Unggah mutasi rekening</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="/mutasi-rekening" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="row mb-1">
                                                <div class="col-lg-12">
                                                    <label for="">Import file</label>
                                                    <input type="file" class="form-control" accept=".xlsx, .xls" name="import_file">
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-lg-12">
                                                    <b>Ketentuan import file mutasi rekening</b>
                                                    <li>Klik untuk unduh template mutasi rekening <a target="_blank" download href="{{asset('template_mutasi_rekening.xlsx')}}">Unduh template mutasi</a></li>
                                                    <li>Pastikan file excel dengan extensi .xlxs</li>
                                                    <li>Pastikan file excel hanya ada 1 sheet</li>
                                                    <li>Pastikan pengisian excel dimulai pada baris <b>A2</b> tidak pada baris yang lain</li>
                                                    <li>Apabila nomor rekening berawal dengan angka 0 maka diwajibkan untuk menambah petik (') sebelum angka 0</li>
                                                    <li>Pada kolom <b>DEBIT, KREDIT DAN SALDO</b> harus format angka tanpa ada label string Rp dll</li>
                                                    <li>Pada kolom <b>KETERANGAN</b>apabila keterangan kosong maka wajib diisi dengan ('-') </li>
                                                    <li>Pada kolom <b>TANGGAL</b>pastikan menggunakan format tanggal contoh (11/1/2023) </li>
                                                    <li>Pastikan tidak menggunakan rumus excel pada kolom yang sudah ditentukan </li>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- End modal -->
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-hover" style="width:100%" id="nonpaginate">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">
                                                <div class="form-check">
                                                    <input value="0" class="form-check-input" onchange="checkall()" type="checkbox" value="s" id="flexCheckDefault">
                                                </div>

                                            </th>

                                            <th rowspan="2">Nasabah</th>
                                            <th rowspan="2">Tanggal</th>
                                            <th colspan="2" class="text-center">Mutasi</th>
                                            <th rowspan="2">Saldo</th>
                                        </tr>
                                        <tr>
                                            <th>Debit [DB]</th>
                                            <th>Credit [CR]</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($mutasi as $key => $value)
                                        <tr>
                                            <td width="1%">
                                                <div class="form-check">
                                                    <input onchange="checksesama('{{$key + 1}}')" data-check="false" class="form-check-input" type="checkbox" value="{{$value->uuid}}" id="flexCheckDefaults{{$key+1}}">
                                                    <!-- <label class="form-check-label" for="flexCheckDefault"></label> -->
                                                </div>
                                            </td>
                                            <td>{{$value->nama}}[ {{$value->norek}} ]</td>
                                            <td>{{ \Carbon\Carbon::parse($value->tanggal)->format('Y-m-d') }}</td>
                                            <td>Rp. {{number_format($value->debit)}}</td>
                                            <td>Rp. {{number_format($value->kredit)}}</td>
                                            <td>Rp. {{number_format($value->saldo)}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="row mt-3">
                                    <div class="col-lg-12">
                                        {!! $mutasi->links('pagination::bootstrap-5') !!}
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div id="tranb" hidden>{{ $datamutasi}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection