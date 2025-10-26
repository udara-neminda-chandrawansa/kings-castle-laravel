<!--**********************************
    Scripts
***********************************-->
<!-- Required vendors -->
<script src="{{asset('vendor/global/global.min.js')}}"></script>
<script src="{{asset('vendor/chart-js/chart.bundle.min.js')}}"></script>
<script src="{{asset('vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
<!--<script src="{{asset('vendor/apexchart/apexchart.js')}}"></script>-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Dashboard 1 -->
<script src="{{asset('js/dashboard/dashboard-1.js')}}"></script>
<script src="{{asset('vendor/draggable/draggable.js')}}"></script>
<script src="{{asset('vendor/swiper/js/swiper-bundle.min.js')}}"></script>

<script src="{{asset('vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendor/datatables/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('vendor/datatables/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('vendor/datatables/js/jszip.min.js')}}"></script>
{{-- <script src="{{asset('js/plugins-init/datatables.init.js')}}"></script> --}}

<!-- Apex Chart -->

<script src="{{asset('vendor/bootstrap-datetimepicker/js/moment.js')}}"></script>
<script src="{{asset('vendor/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>


<!-- Vectormap -->
<script src="{{asset('vendor/jqvmap/js/jquery.vmap.min.js')}}"></script>
<script src="{{asset('vendor/jqvmap/js/jquery.vmap.world.js')}}"></script>
<script src="{{asset('vendor/jqvmap/js/jquery.vmap.usa.js')}}"></script>
<script src="{{asset('js/custom.min.js')}}"></script>
<script src="{{asset('js/deznav-init.js')}}"></script>
<script src="{{asset('js/demo.js')}}"></script>
<script>
    jQuery(document).ready(function() {
        setTimeout(function() {
            dzSettingsOptions.version = 'light';
            new dzSettings(dzSettingsOptions);

            setCookie('version', 'light');
        }, 1500)
    });
</script>

<script>
    function handleAjaxError(xhr) {
        closeLoadingModal();
        let message = 'Something went wrong. Please try again.';

        if (xhr.responseJSON && xhr.responseJSON.errors) {
            let errors = xhr.responseJSON.errors;
            message = Object.values(errors).flat().join('\n');
        } else if (xhr.responseJSON && xhr.responseJSON.message) {
            message = xhr.responseJSON.message;
        } else if (xhr.responseText) {
            message = xhr.responseText;
        }

        Swal.fire({
            title: 'Error!',
            text: message,
            icon: 'error',
            confirmButtonText: 'OK'
        });
    }

    function reloadTable(tableId, tableWrapperId, route) {
        // Destroy existing instance first
        if ($.fn.DataTable.isDataTable('#' + tableId)) {
            $('#' + tableId).DataTable().destroy();
        }

        // Load full table HTML from server
        $('#' + tableWrapperId).load(route, function() {
            $('#' + tableId).DataTable({
                dom: "ZBfrltip",
                buttons: [],
                searching: false,
                pageLength: 5,
                select: false,
                lengthChange: false,
                language: {
                    paginate: {
                        next: '<i class="fa-solid fa-angle-right"></i>',
                        previous: '<i class="fa-solid fa-angle-left"></i>',
                    },
                }
            });
        });
    }
</script>