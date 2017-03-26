@include('layouts.header')

<body>
    
@include('layouts.navi')

<div class="container" id="app">
    @include('layouts.statusmsg')
    @yield('content')
</div>

@include('layouts.footer')