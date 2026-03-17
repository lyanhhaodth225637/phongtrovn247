<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>{{ config('app.name') }} - Quản Trị </title>
    <!-- Custom fonts for this template-->
    <link href="{{ asset('sbadmin2/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Custom styles for this template-->
    <link href="{{ asset('sbadmin2/css/sb-admin-2.min.css')}}" rel="stylesheet">
    <link href="{{ asset('sbadmin2/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <!-- fas pro     -->
    <link rel="stylesheet" href="{{ asset('font-awesome/css/all.min.css') }}">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <!-- Tom Select -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('layouts.admin.sidebar')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('layouts.admin.navbar')
                <!-- End of Topbar -->
                <!-- content -->
                <!-- alert thông báo push notification -->
                @include('components.alert')
                <!-- content -->
                @yield('content')


            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            @include('layouts.admin.footer')

            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Xác Nhận Đăng Xuất</h5>

                    <button class="close" type="button" data-dismiss="modal">
                        <span>×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Bạn có muốn đăng xuất?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">
                        Hủy
                    </button>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-primary">
                            Đăng xuất
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('sbadmin2/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('sbadmin2/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('sbadmin2/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- SB Admin -->
    <script src="{{ asset('sbadmin2/js/sb-admin-2.min.js')}}"></script>

    <!-- DataTables -->
    <script src="{{ asset('sbadmin2/vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('sbadmin2/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
        crossorigin="anonymous"></script>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>



    @stack('scripts')


</body>

</html>