<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('title') &mdash; Sarkara</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    @stack('style')

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">

    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>

    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-94034622-3');
    </script>


    <!-- END GA -->
    @vite('resources/css/app.css')

</head>

<body>
    <div id="app">
        <div class="main-wrapper">
            <!-- Header -->
            @include('components.header')

            <!-- Sidebar -->
            @include('components.sidebar')

            <!-- Content -->
            @yield('main')

            <!-- Footer -->
            @include('components.footer')
        </div>
    </div>

    @vite('resources/js/app.js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- General JS Scripts -->
    <script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('library/popper.js/dist/umd/popper.js') }}"></script>
    <script src="{{ asset('library/tooltip.js/dist/umd/tooltip.js') }}"></script>
    <script src="{{ asset('library/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('library/jquery.nicescroll/dist/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('library/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('js/stisla.js') }}"></script>

    @stack('scripts')

    <!-- Template JS File -->
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        Pusher.logToConsole = true;
        var pusher = new Pusher('7d4f854a5399fcdfdf29', {
            cluster: 'ap1',
            encrypted: true
        });

        // var channel = pusher.subscribe('medicines');
        // channel.bind('medicine.stock.event', function(data) {
        //     Swal.fire({
        //         title: 'Stok habis',
        //         icon: 'success',
        //         confirmButtonText: 'OK'
        //     });
        // });
        var channel = pusher.subscribe('medicines');
        channel.bind('medicine.stock.event', function(data) {
            // Tambahkan notifikasi baru ke dalam elemen dropdown-list-content
            var notificationHtml = `
                <a href="#" class="dropdown-item">
                    <div class="dropdown-item-icon bg-danger text-white">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="dropdown-item-desc">
                        ${data.message}
                        <div class="time text-primary">${new Date().toLocaleTimeString()}</div>
                    </div>
                </a>
            `;

            // Masukkan notifikasi baru ke dalam bagian lonceng notifikasi
            $('.dropdown-list-content').prepend(notificationHtml);

            // Jika ingin menambah efek beep pada lonceng
            $('.notification-toggle').addClass('beep');
        });
    </script>
</body>

</html>
