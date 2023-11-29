@extends('layouts.main')

@section('content')

<div class="layout-px-spacing">
    <div id="load_screen" hidden>
        <div class="loader">
            <div class="loader-content text-center">
                <div class="spinner-grow align-self-center mb-3"></div>
                <h3>Mohon ditunggu email sedang dikirim</h3>
            </div>
        </div>
    </div>
    <div class="row layout-top-spacing">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <!-- Button trigger modal -->
                    <button type="button" onclick="showmodal()" class="btn btn-primary btn-sm">
                        Tambah
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Register Nasabah</h5>
                                    <button onclick="closemodal()" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <label for="form-control">Type Nasabah</label>
                                            <select class="form-control" id="typ">
                                                <option value="">Pilih salah satu</option>
                                                <option value="0">Lama</option>
                                                <option value="1">Baru</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="form-control">Jenis Tabungan</label>
                                            <select class="form-control" id="tb"></select>
                                            <input type="hidden" id="uuid">
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="form-control">No. Rekening</label>
                                            <input oninput="numberonly()" type="text" class="form-control" id="nrk" placeholder="Masukan nomor rekening">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-lg-4">
                                            <label for="form-control">Nama</label>
                                            <input type="text" class="form-control" id="nm" placeholder="Masukan nama">
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="form-control">Email</label>
                                            <input type="email" class="form-control" id="em" placeholder="Masukan email aktif">
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="form-control">No. Handphone</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">+62</span>
                                                </div>
                                                <input oninput="numberphone()" type="text" class="form-control" id="hp" placeholder="8123xxxxx">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-lg-6">
                                            <label for="form-control">Alamat</label>
                                            <textarea class="form-control" id="alm" cols="30" rows="10" placeholder="Alamat sesuai KTP"></textarea>
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="form-control">Alamat Domisili</label>
                                            <textarea class="form-control" id="almdom" cols="30" rows="10" placeholder="Alamat domisili"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" onclick="closemodal()" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                    <button type="button" onclick="simpandata()" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End modal -->
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="default-ordering" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No. Rekening</th>
                                    <th>Tabungan</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>No. Handphone</th>
                                    <th>Aktivasi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($nasabah as $key => $value)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$value->norek}}</td>
                                    <td>{{$value->tabungan}}</td>
                                    <td>{{$value->nama}}</td>
                                    <td>{{$value->email}}</td>
                                    <td>(+62){{$value->no_hp}}</td>
                                    <td>
                                        @if($value->aktivasi == 0)
                                        <span class="badge badge-info bx-tada-hover text-uppercase">Belum aktivasi akun</span>
                                        @else
                                        <span class="badge badge-success bx-tada-hover text-uppercase">Sudah aktivasi akun</span>
                                        @endif
                                    </td>
                                    <td width="15%">
                                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Aksi
                                        </button>
                                        <div class="dropdown-menu">
                                            <a onclick="editdata('{{$value->uuid}}')" class="dropdown-item">Edit</a>
                                            @if($value->aktivasi == 0)
                                            <a onclick="kirimemail('{{$value->uuid}}')" class="dropdown-item">Kirim email aktivasi</a>
                                            @endif
                                            <a class="dropdown-item" title="Untuk merubah status akun menjadi ditangguhkan atau pemblokiran">Report akun</a>
                                            <a class="dropdown-item" onclick="showdetail('{{$value->uuid}}')">Alamat nasabah</a>
                                            <form action="{{ route('register-nasabah.destroy', $value->uuid) }}" method="post">
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


                    <!-- Modal -->
                    <div class="modal fade" id="modaldetail" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Detail Alamat Nasabah</h5>
                                    <button onclick="closemodaldetail()" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label for="form-control">Alamat Sesuai KTP</label>
                                            <textarea class="form-control" id="ktpalm" cols="30" rows="10" readonly></textarea>
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="form-control">Alamat Domisili</label>
                                            <textarea class="form-control" id="domsl" cols="30" rows="10" readonly></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button onclick="closemodaldetail()" type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // $("#load_screen").hide();

    })

    function showmodal() {
        $("#modelId").modal({
            backdrop: "static",
            keyboard: true,
            show: true,
        });
        $('#tb').select2({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            ajax: {
                url: "/getjenistabungan",
                dataType: 'json',
                method: 'get',
                delay: 250,
                data: function(params) {
                    console.log(params)
                    var query = {
                        search: params.term,
                        type: 'public'
                    }

                    // Query parameters will be ?search=[term]&type=public
                    return query;
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(country) {
                            return {
                                id: country.uuid,
                                text: country.nama
                            }
                        })
                    };
                },

                cache: true
            },
            placeholder: 'Pilih jenis tabungan',
            allowClear: false,
            tags: false,
            dropdownParent: $("#modelId")
        })
    }

    function closemodal() {
        $("#modelId").modal("hide");
        $('#almdom').val('');
        $('#typ').val('');
        $('#tb').val('');
        $('#nrk').val('');
        $('#nm').val('');
        $('#em').val('');
        $('#hp').val('');
        $('#alm').val('');
        $('#uuid').val('');
        $('#almdom').removeClass("is-invalid");
        $('#typ').removeClass("is-invalid");
        $('#tb').removeClass("is-invalid");
        $('#nrk').removeClass("is-invalid");
        $('#nm').removeClass("is-invalid");
        $('#em').removeClass("is-invalid");
        $('#hp').removeClass("is-invalid");
        $('#alm').removeClass("is-invalid");
    }

    function numberphone() {
        var nominal = $('#hp').val().replace(/\D/g, "");
        if (nominal[0]=='0') {
            nominal = nominal.substring(1);
        }
        $('#hp').val(nominal);
    }

    function numberonly() {
        var nominal = $('#nrk').val().replace(/\D/g, "");
        $('#nrk').val(nominal)
    }


    function simpandata() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery.ajax({
            url: '/register-nasabah',
            method: 'post',
            data: {
                uuid: $('#uuid').val(),
                type_nasabah: $('#typ').val(),
                jenis_tabungan: $('#tb').val(),
                nomor_rekening: $('#nrk').val(),
                nama: $('#nm').val(),
                email: $('#em').val(),
                nomor_handphone: $('#hp').val(),
                alamat_ktp: $('#alm').val(),
                alamat_domisili: $('#almdom').val(),
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
                    $('#almdom').addClass("is-invalid");
                    $('#typ').addClass("is-invalid");
                    $('#tb').addClass("is-invalid");
                    $('#nrk').addClass("is-invalid");
                    $('#nm').addClass("is-invalid");
                    $('#em').addClass("is-invalid");
                    $('#hp').addClass("is-invalid");
                    $('#alm').addClass("is-invalid");
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

    function editdata(uuid) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery.ajax({
            url: '/register-nasabah/' + uuid,
            method: 'get',

            success: function(result) {
                showmodal()
                $('#almdom').val(result.alamat_domisili);
                $('#typ').val(result.type_nasabah);
                $('#nrk').val(result.norek);
                $('#nm').val(result.nama);
                $('#em').val(result.email);
                $('#hp').val(result.no_hp);
                $('#alm').val(result.alamat_ktp);
                $('#uuid').val(result.uuid);


                var datapelanggan = {
                    id: result.tabungan_id,
                    text: result.tabungan
                };

                var newOption = new Option(datapelanggan.text, datapelanggan.id, false, false);
                $('#tb').append(newOption).trigger('change');
            },

        })
    }

    function showdetail(uuid) {
        $("#modaldetail").modal({
            backdrop: "static",
            keyboard: true,
            show: true,
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery.ajax({
            url: '/register-nasabah/' + uuid,
            method: 'get',

            success: function(result) {
                $('#domsl').val(result.alamat_domisili)
                $('#ktpalm').val(result.alamat_ktp)
            },

        })
    }

    function closemodaldetail() {
        $("#modaldetail").modal("hide");
        $('#domsl').val('')
        $('#ktpalm').val('')
    }

    function kirimemail(uuid) {
        var percent = 0;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery.ajax({
            url: '/sendemail/' + uuid,
            method: 'get',
            beforeSend: function() {
                $('#load_screen').removeAttr('hidden');
                $("#load_screen").show();
            },
            success: function(result) {
                $("#load_screen").attr("hidden", true);
                $("#load_screen").hide();
                Swal.fire({
                    title: "Success",
                    text: result.msg,
                    icon: "success"
                });
            },
            error: function(jqXhr, json, errorThrown) {
                $("#load_screen").attr("hidden", true);
                var errors = jqXhr.responseJSON;
                Swal.fire({
                    text: errors['message'],
                    icon: "info"
                });
            }

        })
    }
</script>
@endsection