$(document).ready(function() {
    globalgetactivemenu()

    App.init();
    $('.show_confirm').click(function(event) {
        var form = $(this).closest("form");
        event.preventDefault();
        swal.fire({
                title: 'Apakah anda yakin ingin?',
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            })
            .then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                    Swal.fire(
                        'Dihapus!',
                        'Data Anda telah dihapus.',
                        'success'
                    )

                }
            });
    });
    $('.show_restore').click(function(event) {
        var form = $(this).closest("form");
        event.preventDefault();
        swal.fire({
                title: 'Apakah anda yakin ingin restore pegawai tersebut?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, restore!'
            })
            .then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                    Swal.fire(
                        'restore!',
                        'Data Anda telah restore.',
                        'success'
                    )

                }
            });
    });

	$('#default-ordering').DataTable( {
        "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
    "<'table-responsive'tr>" +
    "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
        "oLanguage": {
            "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
            "sInfo": "Showing page _PAGE_ of _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Search...",
           "sLengthMenu": "Results :  _MENU_",
        },
        "order": [[ 0, "asc" ]],
        "stripeClasses": [],
        "lengthMenu": [10, 20, 30, 50],
        "pageLength": 10,
        drawCallback: function () { $('.dataTables_paginate > .pagination').addClass(' pagination-style-13 pagination-bordered'); }
    } );

    var ss = $(".basic").select2({
        tags: true,
    });

    $("#slcjab").select2({
        placeholder: "Pilih salah satu",
        allowClear: true
    });
    
})




function globalgetactivemenu() {
    //deactivate menu
    $('a').attr('data-active', 'false');
    $('a').attr('aria-expanded', 'false');
    //get path now
    var pathNow = window.location.pathname;
    //activate menu based on path
    $('a[href="' + pathNow + '"]').attr('data-active', 'true');
    $('a[href="' + pathNow + '"]').attr('aria-expanded', 'true');
    $('a[href="' + pathNow + '"]').parent('li').parent('ul').siblings('.dropdown-toggle').attr('data-active', 'true');
    $('a[href="' + pathNow + '"]').parent('li').parent('ul').siblings('.dropdown-toggle').attr('aria-expanded', 'true');
    $('a[href="' + pathNow + '"]').parent('li').parent('ul').addClass('show');
}

function simpankeperluan() {
    
    var keperluan = $("#keperluan").val()
    var uuid = $("#uuid").val()
    if (uuid == '') {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    
        jQuery.ajax({
            url: "/master-keperluan",
            method: 'post',
            data: {
                keperluan: keperluan,
                uuid:''
            },
            success: function(result) {
                $("#keperluan").val('')
                $("#modelId").modal("hide");
                Swal.fire({
                    icon: 'success',
                    title:  result.msg,
                    showConfirmButton: true,
                    timer: 1500
                  }).then(function(){
                    location.reload();
                })
            },
            error: function(jqXhr, json, errorThrown) { // this are default for ajax errors 
                var errors = jqXhr.responseJSON;
                $.each(errors['errors'], function(index, value) {
                    $("#keperluan").addClass( "is-invalid" );
                    $("#erkeperluan").text( value );
                });
    
            }
        })
    }else{
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    
        jQuery.ajax({
            url: "/master-keperluan/" + uuid,
            method: 'put',
            data: {
                keperluan: keperluan,
                uuid:uuid
            },
            success: function(result) {
                $("#keperluan").val('')
                $("#modelId").modal("hide");
                Swal.fire({
                    icon: 'success',
                    title:  result.msg,
                    showConfirmButton: true,
                    timer: 1500
                  }).then(function(){
                    location.reload();
                })
            },
            error: function(jqXhr, json, errorThrown) { // this are default for ajax errors 
                var errors = jqXhr.responseJSON;
                $.each(errors['errors'], function(index, value) {
                    $("#keperluan").addClass( "is-invalid" );
                    $("#erkeperluan").text( value );
                });
    
            }
        })

    }
}
function showmodalprofile(uuid, public_id) {
    $("#pegawai_id").val(uuid)
    $("#public_id").val(public_id)
    $("#uploadprofile").modal("show");
    $("#profile").change(function(){
        alert("File berhasil dipilih");
    });
    
}
function simpanprofile() {
    var pegawai_id = $("#pegawai_id").val()
    var public_id = $("#public_id").val()
    // var profile = $("#profile").val();
    var myFile = $('#profile').prop('files');
    console.log(myFile[0])
    var formData = new FormData();
    
    formData.append("profile", myFile[0]);
    formData.append("pegawai_id", pegawai_id);
    formData.append("public_id", public_id);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    jQuery.ajax({
        url: "/upload-profile",
        method: 'post',
        processData: false,
        contentType: false,
        cache: false,
        data: formData,
        enctype: 'multipart/form-data',
        success: function(result) {
            console.log(result)
            $("#pegawai_id").val('')
            $("#public_id").val('')
            $("#uploadprofile").modal("hide");
            $("#profile").val(null);
            $("#profile").removeClass( "is-invalid" );
            $("#eruploadprofile").text( '' );
            Swal.fire({
                icon: 'success',
                title:  result.msg,
                showConfirmButton: true,
                timer: 1500
              }).then(function(){
                location.reload();
            })
        },
        error: function(jqXhr, json, errorThrown) { // this are default for ajax errors 
            var errors = jqXhr.responseJSON;
            $.each(errors['errors'], function(index, value) {
                $("#profile").addClass( "is-invalid" );
                $("#eruploadprofile").text( value );
            });

        }
    })
}
function closemodaluploadprofile() {
    $("#pegawai_id").val('')
    $("#public_id").val('')
    $("#uploadprofile").modal("hide");
    $("#profile").val(null);
    $("#profile").removeClass( "is-invalid" );
    $("#eruploadprofile").text( '' );
}


function currencygol() {
    $("#crgl").text(new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0
    })
    .format($('#tjgl').val())
    .trim())

    $("#crjbt").text(new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0
    })
    .format($('#gpkjbt').val())
    .trim())
    
    $("#crtj").text(new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0
    })
    .format($('#tjjb').val())
    .trim())
    
    $("#crpd").text(new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0
    })
    .format($('#tjpd').val())
    .trim())
}