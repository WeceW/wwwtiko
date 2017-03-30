<nav class="navbar navbar-inverse navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                www&tiko
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                <li><a href="{{ url('/home') }}">Etusivu</a></li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ url('/login') }}">Kirjaudu</a></li>
                    <li><a href="{{ url('/register') }}">Rekisteröidy</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/my-account') }}"><i class=""></i>Omat tiedot</a></li>

                            @can('manage-tasks')
                                <li><a href="{{ url('/tasks') }}"><i class=""></i>Hallitse tehtäviä</a></li>
                            @endcan

                            @can('manage-users')
                                <li><a href="{{ url('/users') }}"><i class=""></i>Hallitse käyttäjiä</a></li>
                            @endcan
                            
                            <hr>

                            <!-- TIKO-KURSSIN HARJOITUSTYÖHÖN LIITTYVÄT RAPORTIT VIELÄ TYÖN ALLA 
                            @can('manage-tasks')
                                <li><a href="{{ url('/reports') }}"><i class=""></i>Raportit</a></li>
                                <hr>
                            @endcan 
                            -->
                            
                            <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Kirjaudu ulos</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>