@extends('layouts.main')

@section('content')

<div class="layout-px-spacing">

    <div class="row layout-top-spacing">
        <form action="/data-transfer" method="get">
            @csrf
            <div class="col-lg-5">
                <div class="input-group">
                    <input type="date" class="form-control" name="start" value="{{$start}}">
                    <input type="date" class="form-control" name="end" value="{{$end}}">
                </div>
            </div>
            <div class="col-lg-3">
                <button class="btn btn-primary btn-sm mt-2">Cari</button>
                <a href="/data-transfer" class="btn btn-warning btn-sm mt-2">Reset</a>
            </div>
        </form>
    </div>
    <div class="row layout-top-spacing">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" width="100%" id="default-ordering">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nasabah</th>
                                    <th>Jenis transfer</th>
                                    <th>No. rekening</th>
                                    <th>Tujuan rekening</th>
                                    <th>Nominal</th>
                                    <th>Biaya</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tfsesama as $key => $value)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($value->created_at)->format('Y-m-d H:i:s') }}</td>
                                    <td>{{$value->nasabah}}</td>
                                    <td><span class="badge badge-info text-uppercase">Transfer sesama rekening</span></td>
                                    <td>{{$value->norek}}</td>
                                    <td>{{$value->rekening_tujuan}}</td>
                                    <td>Rp. {{number_format($value->nominal)}}</td>
                                    <td>Rp. 0</td>
                                    <td>Rp. {{number_format($value->nominal)}}</td>
                                    <td>
                                        @if($value->status_transaksi == 1)
                                        <span class="badge badge-warning text-uppercase">pending</span>
                                        @elseif($value->status_transaksi == 2)
                                        <span class="badge badge-success text-uppercase">sukses</span>
                                        @else
                                        <span class="badge badge-danger text-uppercase">batal</span>
                                        @endif
                                    </td>
                                    <td width="15%">
                                        @if($value->status_transaksi == 2 || $value->status_transaksi == 3)
                                        <button disabled class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Aksi
                                        </button>
                                        @else
                                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Aksi
                                        </button>
                                        @endif
                                        <div class="dropdown-menu">
                                            @if($value->status_transaksi == 1)
                                            <a onclick="updatetransaksi('{{$value->uuid}}', 0, 2)" class="dropdown-item">Selesaikan transaksi</a>
                                            <a onclick="updatetransaksi('{{$value->uuid}}', 0, 3)" class="dropdown-item">Batalkan transaksi</a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                @foreach($tfbnk as $key => $value)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($value->created_at)->format('Y-m-d H:i:s') }}</td>
                                    <td>{{$value->nasabah}}</td>
                                    <td><span class="badge badge-primary text-uppercase">Transfer antar bank {{$value->bank}}</span></td>
                                    <td>{{$value->norek}}</td>
                                    <td><b>{{$value->rekening_penerima}}</b> - {{$value->rekening_tujuan}}</td>
                                    <td>Rp. {{number_format($value->nominal)}}</td>
                                    <td>Rp. {{number_format($value->biaya)}}</td>
                                    <td>Rp. {{number_format($value->jumlah)}}</td>
                                    <td>
                                        @if($value->status_transaksi == 1)
                                        <span class="badge badge-warning text-uppercase">pending</span>
                                        @else
                                        <span class="badge badge-success text-uppercase">sukses</span>
                                        @endif
                                    </td>
                                    <td width="15%">
                                        @if($value->status_transaksi == 2 || $value->status_transaksi == 3)
                                        <button disabled class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Aksi
                                        </button>
                                        @else
                                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Aksi
                                        </button>

                                        @endif
                                        <div class="dropdown-menu">
                                            @if($value->status_transaksi == 1)
                                            <a onclick="updatetransaksi('{{$value->uuid}}', 1, 2)" class="dropdown-item">Selesaikan transaksi</a>
                                            <a onclick="updatetransaksi('{{$value->uuid}}', 1, 3)" class="dropdown-item">Batalkan transaksi</a>
                                            @endif
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
    function updatetransaksi(uuid, type, status) {
        swal.fire({
                title: 'Apakah anda yakin ingin?',
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, batalkan transaksi!'
            })
            .then((result) => {
                if (result.isConfirmed) {
                    // form.submit();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    jQuery.ajax({
                        url: '/updatetransaksi',
                        method: 'POST',
                        data: {
                            uuid: uuid,
                            type: type,
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
            });
    }
</script>
@endsection