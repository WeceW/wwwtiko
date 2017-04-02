<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>wwwtiko</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    

<style>
html {
    height: 100%;
}
body {
    font-family: 'Lato';

    height: 100%;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background: #222; /* For browsers that do not support gradients */
    background: -webkit-linear-gradient(#333, #000) fixed; /* For Safari 5.1 to 6.0 */
    background: -o-linear-gradient(#333, #000) fixed; /* For Opera 11.1 to 12.0 */
    background: -moz-linear-gradient(#333, #000) fixed; /* For Firefox 3.6 to 15 */
    background: linear-gradient(#333, #000) fixed; /* Standard syntax */
}

div .panel {
    border-radius: 0px 0px 20px 20px;
    border: none;
}

.nav-tabs a {
    color: white;
}

.nav-tabs a:hover {
    color: black;
}

.fa-btn {
    margin-right: 6px;
}

</style>

</head>