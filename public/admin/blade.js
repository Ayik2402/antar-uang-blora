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

	$('#datatf').DataTable( {
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
        "order": [],
        "stripeClasses": [],
        "lengthMenu": [10, 20, 30, 50],
        "pageLength": 10,
        drawCallback: function () { $('.dataTables_paginate > .pagination').addClass(' pagination-style-13 pagination-bordered'); }
    } );

	$('#nonpaginate').DataTable( {
        "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
    "<'table-responsive'tr>" ,
    // "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
    //     "oLanguage": {
    //         "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
    //         "sInfo": "Showing page _PAGE_ of _PAGES_",
    //         "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
    //         "sSearchPlaceholder": "Search...",
    //        "sLengthMenu": "Results :  _MENU_",
    //     },
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

var datatransaksimanual = [];
function checkall() {
    // console.log($('#flexCheckDefault').val())
    var mutasirekening = JSON.parse($('#tranb').text())
    var valueuncheck = $('#flexCheckDefault').val();
    console.log(mutasirekening)
    var valuecheck = 0;

    var datatransaksi = [];
    if (valueuncheck == 0) {
        $('#flexCheckDefault').prop('checked', true).val(1);
        valuecheck = $('#flexCheckDefault').val();
        var nourutmutasirekening = 0;
        for (let i = 0; i < mutasirekening.length; i++) {
            const elm = mutasirekening[i];
            nourutmutasirekening += 1;
            datatransaksi.push(elm.uuid);
            $('#flexCheckDefaults' + nourutmutasirekening).prop('checked', true);
        }

        $('#trts').val(datatransaksi)
    } else {
        $('#flexCheckDefault').prop('checked', false).val(0);
        var nourutmutasirekening = 0;
        for (let i = 0; i < mutasirekening.length; i++) {
            const elm = mutasirekening[i];
            nourutmutasirekening += 1;
            $('#flexCheckDefaults' + nourutmutasirekening).prop('checked', false);
        }

        $('#trts').val('')
    }
}

function checksesama(no) {
    var falsecheck = '';
        var truecheck = $('#flexCheckDefaults' + no).data('check');
        if (truecheck == false) {
            var ab = $('#flexCheckDefaults' + no).data('check', true);
            falsecheck = ab.data('check')
            $('#flexCheckDefaults' + no).prop('checked', true);
            var valuesesama = $('#flexCheckDefaults' + no).val();
            // var datatransaksi = [];
            datatransaksimanual.push(valuesesama);
            $('#trts').val(datatransaksimanual)
        } else {
            var ab = $('#flexCheckDefaults' + no).data('check', false);
            truecheck = ab.data('check')
            $('#flexCheckDefaults' + no).prop('checked', false);
            var valuesesama = $('#flexCheckDefaults' + no).val();

            // datatransaksi.push(valuesesama);
            $('#trts').val('')
        }
}
