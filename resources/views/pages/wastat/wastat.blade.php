@extends('layouts.main')

@section('content')

<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12" style="min-height: 953px;">
                            <div class="row m-3">
                                <div class="col-lg-8 row">
                                    <div class="col-12">
                                        <h5>Whatsapp Status</h5>
                                        <span>
                                            Status: 
                                            <span class="erdbg badge badge-danger bx-flashing" style="display: none;">Server Can't be Reached</span>
                                            <span class="nrdbg badge badge-warning bx-flashing" style="display: none;">Not Ready</span>
                                            <span class="lddbg badge badge-secondary bx-flashing" style="display: none;"><i class="bx bx-spin bx-loader"></i></span>
                                            <span class="ardbg badge badge-success" style="display: none;">Ready</span>
                                        </span>
                                        <br>
                                        <span>
                                            Last Checked: 
                                            <span id="lastchecked"></span>
                                        </span>
                                        <dir id="qrdisplay"></dir>
                                        <div class="col-12">
                                            <h6 id="wapushname"></h6>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <h5>Service Status</h5>
                                        <button type="button" class="btn btn-sm btn-info text-white checkWaJsStat" onclick="checkwasrvstat(0)">STATUS</button>
                                        <button type="button" class="btn btn-sm btn-success text-white checkWaJsStat" onclick="checkwasrvstat(1)">START</button>
                                        <button type="button" class="btn btn-sm btn-warning text-white checkWaJsStat" onclick="checkwasrvstat(2)">RESTART</button>
                                        <button type="button" class="btn btn-sm btn-danger text-white checkWaJsStat" onclick="checkwasrvstat(3)">STOP</button>
                                        <br>
                                        <div class="w-100" id="wasrvstctr">
                    
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4" id="testmessagecontainer" style="display: none;">
                                    <h5>Send Test Message</h5>
                                    <div class="form-group">
                                        <label>Nomor</label>
                                        <input placeholder="628xxxxxxxxx" type="text" id="txtNumTest" oninput="numonlynum()" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Message</label>
                                        <textarea id="txaMsgTest" cols="30" rows="10" class="form-control"></textarea>
                                    </div>
                                    <div class="d-grid">
                                        <button type="button" class="btn btn-block btn-primary" onclick="sendtestmessage()">Send Test Message</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/admin/plugins/qrjs/qrcode.js"></script>
<script>
    var qract = null;
    $(document).ready(function () {
        try {
            getstat();
        } catch (e) {
            console.log(e);
        }
    });
    function getstat() {
            $.ajax({
                type: "GET",
                url: "http://localhost:3333/statcheck",
                xhr: function(){
                    var xhr = new window.XMLHttpRequest();
                    xhr.addEventListener("error", function(evt){
                        console.log("an error occured");
                        $('.ardbg').hide();
                        $('.lddbg').hide();
                        $('.nrdbg').hide();
                        $('.erdbg').show();
                        $('#qrdisplay').html('');
                        setTimeout(() => {
                            getstat();
                        }, 1300);
                    }, false);
                    xhr.addEventListener("abort", function(){
                        console.log("cancelled");
                    }, false);

                    return xhr;
                },
                success: function (response) {
                    var rd = response.ready;
                    var qr = response.qr;
                    var ct = response.client;
                    if (rd==1) {
                        $('.ardbg').show();
                        $('.lddbg').hide();
                        $('.nrdbg').hide();
                        $('.erdbg').hide();
                        
                        $('#qrdisplay').html('');
                        $('#testmessagecontainer').show();
                    } else if (rd==9) {
                        $('.ardbg').hide();
                        $('.lddbg').show();
                        $('.nrdbg').hide();
                        $('.erdbg').hide();
                        $('#testmessagecontainer').hide();
                    } else {
                        $('.ardbg').hide();
                        $('.lddbg').hide();
                        $('.nrdbg').show();
                        $('.erdbg').hide();
                        $('#testmessagecontainer').hide();
                    }
                    if (rd==0 && qr==null) {
                        $('#qrdisplay').html('Generating QR...');                            
                    } else if (rd == 9) {
                        $('#qrdisplay').html('Syncing ...');
                    }
                    if (qr && rd==0) {
                        if (qr != qract) {
                            $('#qrdisplay').html('');
                            qract = qr;
                            var qrcode = new QRCode(document.getElementById("qrdisplay"), {
                                text: qr,
                                width: 256,
                                height: 256,
                                colorDark : "#000000",
                                colorLight : "#ffffff",
                                correctLevel : QRCode.CorrectLevel.H
                            });
                        }
                    }
                    var wa = '';
                    if (ct) {
                        wa = ''+(ct.pushname?('('+ct.pushname+')'):'')+'+'+ct.wid.user;
                    }
                    $('#wapushname').html(wa);
                    $('#lastchecked').html(new Date().toLocaleString('id-ID'))
                    setTimeout(() => {
                        getstat();
                    }, 1300);
                }
            })
    }

    function sendtestmessage() {
        var n = $('#txtNumTest').val();
        var m = $('#txaMsgTest').val();
        if (!n || !m) {
            alert('Semua kolom harus diisi');
        } else {
            if (n[0]==0) {
                alert('Format Nomor: 62xxxxxxx');
            } else {
                $.ajax({
                    type: "GET",
                    url: "http://localhost:3333/sendmsg",
                    data: {
                        number: n,
                        message: m,
                    },
                    success: function (response) {
                        alert(response);
                    }
                });
            }
        }
    }

    function checkwasrvstat(t) {
        $('#wasrvstctr').html('Loading....');
        $.ajax({
            type: "get",
            url: "/wasrvstat?type="+t,
            success: function (response) {
                $('#wasrvstctr').html(response);
            }
        });
    }

    function numonlynum() {
        $('#txtNumTest').val($('#txtNumTest').val().replace(/\D/g,''));
    }
</script>
@endsection