@include('layouts.header')

<body id="app-layout">
    
@include('layouts.navi')

<div class="container">
    @include('layouts.statusmsg')
    @yield('content')
</div>

@include('layouts.footer')