<!-- Page level plugins -->
<script src="{{asset('admin-bootstrap/vendor/chart.js/Chart.min.js')}}"></script>

<!-- Page level custom scripts -->
<!-- <script src="{{asset('admin-bootstrap/js/demo/chart-area-demo.js')}}"></script>
<script src="{{asset('admin-bootstrap/js/demo/chart-pie-demo.js')}}"></script> -->
<script src="{{asset('admin/assets/js/users/account-settings.js')}}"></script>
<script src="{{asset('admin/plugins/dropify/dropify.min.js')}}"></script>
<script src="{{asset('admin/plugins/blockui/jquery.blockUI.min.js')}}"></script>
<script src="{{asset('admin/bootstrap/js/popper.min.js')}}"></script>
<script src="{{asset('admin/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('admin/plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('admin/assets/js/app.js')}}"></script>
<script src="{{asset('admin/plugins/file-upload/file-upload-with-preview.min.js')}}"></script>
<script src="{{asset('admin/plugins/table/datatable/datatables.js')}}"></script>
<script src="https://unpkg.com/boxicons@2.1.2/dist/boxicons.js"></script>
<script src="{{asset('admin/plugins/select2/select2.min.js')}}"></script>
<script src="{{asset('admin/plugins/bootstrap-select/bootstrap-select.min.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('admin/assets/js/custom.js')}}"></script>
<script src="{{asset('admin/blade.js')}}"></script>
<script src="{{asset('admin/plugins/input-mask/jquery.inputmask.bundle.min.js')}}"></script>
<script src="{{asset('admin/assets/js/components/ui-accordions.js')}}"></script>
<!-- <script src="{{asset('admin/plugins/apex/apexcharts.min.js')}}"></script> -->
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
<!-- <script src="{{asset('admin/assets/js/apps/contact.js')}}"></script> -->
<script src="{{asset('admin/plugins/fullcalendar/moment.min.js')}}"></script>
<script src="{{asset('admin/plugins/flatpickr/flatpickr.js')}}"></script>
<script src="{{asset('admin/plugins/fullcalendar/fullcalendar.min.js')}}"></script>
<script src="{{asset('admin/assets/js/authentication/form-1.js')}}"></script>
<!-- <script src="{{asset('admin/assets/js/apps/invoice-preview.js')}}"></script> -->
<!-- <script src="{{asset('admin/plugins/file-upload/file-upload-with-preview.min.js')}}"></script> -->
<!-- <script src="{{asset('admin/plugins/apex/apexcharts.min.js')}}"></script> -->
<script src="{{asset('admin/assets/js/dashboard/dash_1.js')}}"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<!--  BEGIN CUSTOM SCRIPTS FILE  -->


<!-- <script src="{{asset('admin/plugins/select2/custom-select2.js')}}"></script> -->
<!-- <script src="{{asset('admin/plugins/input-mask/input-mask.js')}}"></script> -->
<script>
  $('.show_delete').click(function(event) {
    var form = $(this).closest("form");
    event.preventDefault();
    swal.fire({
        title: 'Apakah anda yakin?',
        text: "Anda tidak akan dapat mengembalikan ini!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya'
      })
      .then((result) => {
        if (result.isConfirmed) {
          form.submit();
        }
      });
  });

  function toRupiah(val, label) {
    $(label).text(new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0
      })
      .format($(val).val())
      .trim())
  }
</script>