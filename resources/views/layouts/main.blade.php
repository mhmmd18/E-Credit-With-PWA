<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link href="/css/styles.css" rel="stylesheet" />
    {{-- Ajax --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    {{-- Datatables --}}
    <link href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css" rel="stylesheet">
    <link href="/img/logo.png" rel="shortcut icon">
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="#">E-Credit</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0 ms-auto" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>

    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <h6 class="px-3 py-3 text-black" style="background-color: rgb(255, 115, 0)">
                            Welcome, {{ Auth::user()->username }}
                        </h6>
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link {{ Request::is('dashboard*') ? 'active' : '' }}" href="/dashboard">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Master Data</div>
                        @if (Auth::user()->role_id == 1)
                            <a class="nav-link {{ Request::is('users*') ? 'active' : '' }}" href="/users">
                                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                Users
                            </a>
                        @else
                            <a class="nav-link {{ Request::is('customers*') ? 'active' : '' }} collapsed" href="#"
                                data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false"
                                aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Nasabah
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                                data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="/customers/list/Harian">Harian</a>
                                    <a class="nav-link" href="/customers/list/Mingguan">Mingguan</a>
                                    <a class="nav-link" href="/customers/list/Bulanan">Bulanan</a>
                                </nav>
                            </div>
                            <a class="nav-link {{ Request::is('logs*') ? 'active' : '' }}" href="/logs">
                                <div class="sb-nav-link-icon"><i class="fas fa-clock-rotate-left"></i></div>
                                Catatan
                            </a>
                        @endif
                        <a class="nav-link" href="/logout">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-power-off"></i></div>
                            Logout
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    @yield('content')
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; E-Credit 2024</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="/js/scripts.js"></script>
    {{-- Datatables --}}
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

    {{-- EXTENSION --}}
    {{-- Button --}}
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- <script>
        $(document).ready(function() {
            $('.select-multiple').select2();
        });
    </script> -->
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                "sScrollY": ($(window).height() - 430),
                responsive: true,
                lengthChange: false,
                language: {
                    emptyTable: "Data tidak tersedia",
                    info: "_START_ sampai _END_ dari _TOTAL_ total data",
                    search: "Cari:",
                    loadingRecords: "Tunggu sebentar...",
                    processing: "Memproses...",
                    paginate: {
                        "first": "First",
                        "last": "Last",
                        "next": ">",
                        "previous": "<"
                    },
                }
            });
        });
    </script>
    <script>
        const idFormated = ['credit', 'debt'];
        // Function to format number with thousand separators
        function formatNumberWithCommas(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
        // Function to remove non-numeric characters
        function cleanNonNumericChars(value) {
            return value.replace(/[^\d]/g, '');
        }
        // Function to update input value with formatted number
        function updateFormattedValue(input) {
            var cleanedValue = cleanNonNumericChars(input.value);
            var formattedValue = formatNumberWithCommas(cleanedValue);
            input.value = formattedValue;
        }

        // Event delegation
        document.addEventListener('input', function(event) {
            if (idFormated.includes(event.target.id)) {
                updateFormattedValue(event.target);
            }
        });
    </script>
</body>

</html>
