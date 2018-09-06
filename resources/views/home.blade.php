
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <title>Todo app</title>

    <!-- CSS  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/css/materialize.min.css">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
<nav class="light-blue lighten-1" role="navigation">
    <div class="nav-wrapper container"><a id="logo-container" href="/public" class="brand-logo">
            @if (Route::has('login'))
                @auth
        <ul class="right hide-on-med-and-down">
            <li><a href="{{ url('/index') }}">Account</a></li>
        </ul>
        <ul class="right hide-on-med-and-down">
            <li><a href="{{ route('register') }}">Login</a></li>
        </ul>

            @else
                <ul class="right hide-on-med-and-down">
                    <li><a href="{{ route('login') }}">Login</a></li>
                </ul>
                <ul class="right hide-on-med-and-down">
                    <li><a href="{{ route('register') }}">Register</a></li>
                </ul>
                @endauth
            @endif


        <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
    </div>
</nav>
<div class="section no-pad-bot" id="index-banner">
    <div class="container">
        <br><br>
        <h1 class="header center orange-text">Make your todo list</h1>
        <div class="row center">
            <img src="{{ asset('img/rocket.png') }}" alt="">        </div>
        <div class="row center">
            <a href="{{ route('register') }}" id="download-button" class="btn-large waves-effect waves-light orange">Get Started</a>
        </div>
        <br><br>

    </div>
</div>




<footer class="page-footer orange">

</footer>


<!--  Scripts-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/js/materialize.min.js"></script>

<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>

</body>
</html>
