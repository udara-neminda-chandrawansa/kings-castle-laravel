@include('admin-dashboard.header.head')

<body>
    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">
        @include('admin-dashboard.header.header')


        @yield('content')
        @include('admin-dashboard.footer.footer')
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->
    @include('admin-dashboard.footer.js')
    @stack('page-ajax')
</body>

</html>