<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta and other head content -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Layout</title>

    <!-- Custom CSS for the color scheme -->
    <style>
        /* Sidebar Styling */
        .sidebar {
            background-color: #006400; /* Dark Green */
        }

        .sidebar a, .sidebar .collapse-item {
            color: #FFFFF0 !important; /* Ivory */
        }

        .sidebar .active {
            background-color: #FFD700 !important; /* Yellow */
            color: #006400 !important; /* Dark Green */
        }

        .sidebar a:hover {
            color: #FFD700 !important; /* Yellow */
        }

        /* Main Content Area */
        #content-wrapper {
            background-color: #FFFFF0; /* Ivory */
        }

        /* Footer Styling */
        footer {
            background-color: #FFFFF0; /* Ivory */
            color: #006400; /* Dark Green */
        }
    </style>
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav sidebar accordion" id="accordionSidebar">
            <li class="nav-item active">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Analytics</span>
                </a>
            </li>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                </nav>
                <!-- End of Topbar -->

                <!-- Page Content -->
                <div class="container-fluid">
                    @yield("content")
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; <strong>HORAIZON TECH</strong></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
</body>

</html>
