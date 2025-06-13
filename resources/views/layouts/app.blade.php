<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title') SIMPELDIK</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <!-- Pignose Calender -->
    <link href="{{ asset('plugins/pg-calendar/css/pignose.calendar.min.css') }}" rel="stylesheet">
    <!-- Chartist -->
    <link rel="stylesheet" href="{{ asset('plugins/chartist/css/chartist.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css') }}">
    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Toastr CSS -->
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" /> --}}

    <!-- SweetAlert2 CSS (optional, default-nya udah oke) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">    

    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    {{-- allert --}}
    <!-- SweetAlert2 CSS & JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>

<body>
    @stack('scripts')


    <!--*******************
        Preloader start
    ********************-->
    {{-- <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3"
                    stroke-miterlimit="10" />
            </svg>
        </div>
    </div> --}}
    <!--*******************
        Preloader end
    ********************-->


    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        @include('layouts.partials.navbar')

        <!--**********************************
            Sidebar start
        ***********************************-->
        @include('layouts.partials.sidebar')
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">



            @yield('content')
            <!-- #/ container -->
        </div>
        <!--**********************************
            Content body end
        ***********************************-->


        <!--**********************************
            Footer start
        ***********************************-->
        @include('layouts.partials.footer')
        <!--**********************************
            Footer end
        ***********************************-->
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: "{{ session('error') }}",
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            @if (session('warning'))
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan!',
                    text: "{{ session('warning') }}",
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            @if (session('info'))
                Swal.fire({
                    icon: 'info',
                    title: 'Info',
                    text: "{{ session('info') }}",
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif
        });

        // Konfirmasi hapus global untuk semua form dengan class .form-delete
        document.addEventListener('DOMContentLoaded', function() {
            const deleteForms = document.querySelectorAll('.form-delete');

            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault(); // cegah submit langsung

                    Swal.fire({
                        title: 'Apakah kamu yakin?',
                        text: "Data yang dihapus tidak bisa dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e3342f',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // submit form kalau user yakin
                        }
                    });
                });
            });
        });
    </script>

    <!-- jQuery (wajib untuk toastr) -->
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script> --}}

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('plugins/common/common.min.js') }}"></script>
    <script src="{{ asset('js/custom.min.js') }}"></script>
    <script src="{{ asset('js/settings.js') }}"></script>
    <script src="{{ asset('js/gleek.js') }}"></script>
    <script src="{{ asset('js/styleSwitcher.js') }}"></script>

    <!-- Chartjs -->
    <script src="{{ asset('plugins/chart.js/Chart.bundle.min.js') }}"></script>
    <!-- Circle progress -->
    <script src="{{ asset('plugins/circle-progress/circle-progress.min.js') }}"></script>
    <!-- Datamap -->
    <script src="{{ asset('plugins/d3v3/index.js') }}"></script>
    <script src="{{ asset('plugins/topojson/topojson.min.js') }}"></script>
    <script src="{{ asset('plugins/datamaps/datamaps.world.min.js') }}"></script>
    <!-- Morrisjs -->
    <script src="{{ asset('plugins/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('plugins/morris/morris.min.js') }}"></script>
    <!-- Pignose Calender -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/pg-calendar/js/pignose.calendar.min.js') }}"></script>
    <!-- ChartistJS -->
    <script src="{{ asset('plugins/chartist/js/chartist.min.js') }}"></script>
    <script src="{{ asset('plugins/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js') }}"></script>

    <!-- Toastr -->
    {{-- <script src="{{ asset('plugins/toastr/js/toastr.min.js') }}"></script>
    <script src="{{ asset('plugins/toastr/js/toastr.init.js') }}"></script> --}}



    <script src="{{ asset('js/dashboard/dashboard-1.js') }}"></script>


</body>

</html>
