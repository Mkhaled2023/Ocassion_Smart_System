<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />

        <script>
        jQuery(document).ready(function($){
            $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
            });
        })
        </script>
        <style>
            body {
        overflow-x: hidden;
        }

        #sidebar-wrapper {
        min-height: 100vh;
        margin-left: -15rem;
        -webkit-transition: margin .25s ease-out;
        -moz-transition: margin .25s ease-out;
        -o-transition: margin .25s ease-out;
        transition: margin .25s ease-out;
        }

        #sidebar-wrapper .sidebar-heading {
        padding: 0.875rem 1.25rem;
        font-size: 1.2rem;
        }

        #sidebar-wrapper .list-group {
        width: 15rem;
        }

        #page-content-wrapper {
        min-width: 100vw;
        }

        #wrapper.toggled #sidebar-wrapper {
        margin-left: 0;
        }

        @media (min-width: 768px) {
        #sidebar-wrapper {
            margin-left: 0;
        }

        #page-content-wrapper {
            min-width: 0;
            width: 100%;
        }

        #wrapper.toggled #sidebar-wrapper {
            margin-left: -15rem;
        }
        }
        /*=====================================================
  Card Colors
  =====================================================*/

#color-1 {
    background: #ffea00;
    color: #000000;
}
#color-2 {
    background: orange;
    color: #000000;
}
#color-3 {
    background: #ff0047;
    color: #000000;
}
#color-4 {
    background: #6A2C70;
    color: #DC59E8;
}

/*=====================================================
  Card Group
  =====================================================*/
  
/* Hover Effect */
.hvr {
  display: inline-block;
  vertical-align: middle;
  -webkit-transform: translateZ(0);
  transform: translateZ(0);
  box-shadow: 0 0 1px rgba(0, 0, 0, 0);
  -webkit-backface-visibility: hidden;
  backface-visibility: hidden;
  -moz-osx-font-smoothing: grayscale;
  position: relative;
  overflow: hidden;
}
.hvr:before {
  content: "";
  position: absolute;
  z-index: -1;
  left: 50%;
  right: 50%;
  top: 0;
  background: #ffff;
  height: 4px;
  -webkit-transition-property: left, right;
  transition-property: left, right;
  -webkit-transition-duration: 0.3s;
  transition-duration: 0.3s;
  -webkit-transition-timing-function: ease-out;
  transition-timing-function: ease-out;
}
.hvr:hover:before, .hvr-overline-from-center:focus:before, .hvr-overline-from-center:active:before {
  left: 0;
  right: 0;
}
#color-1.hvr:before {
  background: #000;
}
#color-2.hvr:before {
  background: #BE3A00;
}
#color-3.hvr:before {
  background: #FD81A4;
}
#color-4.hvr:before {
  background: #DC59E8;
}
/*   
  
.card {
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;
  
  -webkit-flex-direction: column;
      -ms-flex-direction: column;
          flex-direction: column;
          
  border: 0px solid #E0E0E0;
  border-radius: 4px;
  overflow: hidden;
} */

.card__description {
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;

  -webkit-flex-direction: column;
      -ms-flex-direction: column;
          flex-direction: column;
          
  -webkit-align-items: center;
       -ms-flex-align: center;
          align-items: center;

  -webkit-justify-content: center;
            -ms-flex-pack: center;
          justify-content: center;

  padding: 15px 0;
  height: 120px;
}


.card__color {
  text-align: center;
  color: #57727C;
  font-size: 15px;
  letter-spacing: 1px;
  padding: 5px 15px;
  background-color: #FEFEFE;
}

.card__color span {
    display: block;
    padding: 5px 0;
}

.card--fixedWidth {
  max-width: 120px;
}


.cardGroup {
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;

  border-radius: 4px;
  overflow: hidden;
}

.cardGroup__card {
  -webkit-flex: 1 1 0%;
      -ms-flex: 1 1 0%;
          flex: 1 1 0%;

  border: none;
  border-radius: 0;
}

.cardGroup__card + .cardGroup__card {
}

.cardGroup__cardDescription {
  -webkit-flex: 1 1 auto;
      -ms-flex: 1 1 auto;
      height: 227px;
    margin: 29px;
          flex: 1 1 auto;
}

/*=====================================================
  Demo
  ==============================    =======================*/
.container {
    padding: 50px;

    overflow-x: auto;
}

#demo {
    margin: 100px;
}

h1 {
    font-size: 40px;
    font-weight: 700;
    color: #000;
    text-align: center;
}

p {
    text-align: center;
}

        </style>    
    </head>
    <body>
    
    <div class="d-flex" id="wrapper">


    @include('par.sidebar')
    <div id="page-content-wrapper">

    @include('par.nav')

    @if (Session::has('success'))
    <div class="alert alert-success">
        <ul>
            <li>{{ Session::get('success') }}</li>
        </ul>
    </div>
@endif      
            @yield('content')
            </div>
        </div>

  </body>
</html>






