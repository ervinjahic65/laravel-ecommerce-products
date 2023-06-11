<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mobile Shop - Početna</title>


    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="stylesheet" type="text/css" href="{{ url('assets/style.css') }}">
    <link rel="stylesheet" type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css">
    <link href="https://www.jqueryscript.net/demo/Highly-Customizable-Range-Slider-Plugin-For-Bootstrap-Bootstrap-Slider/dist/css/bootstrap-slider.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.css">

    <style>

        .hero-img-main {
            width: 35%;
            height: auto;
        }

        .hero-img {
            width: 50px;
        }
        #slider5a .slider-track-high, #slider5c .slider-track-high {
            background: green;
        }

        #slider5b .slider-track-low, #slider5c .slider-track-low {
            background: red;
        }

        #slider5c .slider-selection {
            background: yellow;
        }

        #min_value, #max_value {
            padding-left: 40px;
        }

        @media screen and (max-width: 840px) {
            .main-section {
                display: flex;
                flex-direction: column;
            }

            #sidebar {
                margin-left: calc(20%);
            }

            .max-min-values {
                display: flex;
                flex-direction: column;
            }

            #min_value {
                padding-left: 40px;
                padding-right: 20px;
            }

            .pick-color {
                margin-left: -20px !important;
            }
        }

        @media screen and (max-width: 780px) {
            .nav-item {
                text-align: center;
            }
        }
        </style>

</head>
<body>

    <nav class="navbar navbar-expand-md navbar-light bg-white border-bottom">
        <a class="navbar-brand ml-2 font-weight-bold" href="#">
            <img class="hero-img" src="{{ url('images/mobile-shop.jpg') }}"/>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                @if(session('userid'))
                <li class="nav-item rounded bg-light search-nav-item">
                    <input type="text" id="search" class="bg-light searchProd form-control" placeholder="Pretraži proizvode ...">
                </li>
                @endif
                @if(session('userid'))
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span id="burgundy"></span><span id="blue">
                                {{ strtoupper(session('username')) }}
                                <i class="fa fa-user" aria-hidden="true"></i>
                            </span>
                        </a>
                    </li>

                    @php
                        $is_admin = session('is_admin');
                    @endphp

                    @if($is_admin == 1)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('add-product')}}">
                                <span id="burgundy"></span><span id="blue">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                </span>
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/cart-products')}}">
                            <span id="burgundy"></span><span id="blue">
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                ( <span id="cart_count"> </span>  )
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('logout')}}">
                            <span id="burgundy"></span><span id="blue">
                                <i class="fa fa-sign-out" aria-hidden="true"></i>
                            </span>
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('login')}}">
                            <span id="burgundy"></span><span id="blue">Uloguj se</span>
                            <i class="fa fa-sign-in" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('signup')}}">
                            <span id="burgundy"></span><span id="blue">Registruj se</span>
                            <i class="fa fa-book" aria-hidden="true"></i>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </nav>

    @if(!session('userid'))
    <div class="before-login" style="text-align: center;">
        <img class="hero-img-main" src="{{ url('images/mobile-shop.jpg') }}"/>
    </div>
    @endif

    @if(session('userid'))
    <div class="main-container">
        <section id="sidebar">

            <p> Početna | <b>Proizvodi</b></p>

            <div class="border-bottom pb-2 ml-2">
                <h4 id="burgundy">Filteri
                    <i class="fa fa-filter" aria-hidden="true"></i>
                </h4>
                {{-- <div class="filter">
                    <a href=""><button class="">Clear</button> </a>
                </div> --}}
            </div>

            <div class="py-2 border-bottom ml-3 max-min-values">
                <h5 id="burgundy">Po cijeni</h5>
                <b id="min_value">KM: {{ $price['min'] }}</b> <input id="ex2" type="text" class="span2" value="" data-slider-min="{{ $price['min'] }}" data-slider-max="{{ $price['max'] }}" data-slider-step="5" data-slider-value="[{{ $price['min']}},{{ $price['max']}}]"/> <b id="max_value">KM: {{$price['max']}}</b>
            </div>

            <div class="py-2 ml-3 pick-color">
                <h5 id="burgundy">Po boji</h5>
                @foreach($colors as  $r)
                    <div class="form-group"> <input class="color_check" type="checkbox" value="{{$r->color }}" id="25off"> <label for="25">{{ ucfirst($r->color) }}</label> </div>
                @endforeach
            </div>

            </section>

            @if(session('status'))
            <strong style="color:green"><center>{{session('status')}}</center></strong>
            @endif

            <section id="products">

            <div class="container">
                <div class="d-flex flex-row">
                    <div class="ml-auto mr-lg-4">
                    </div>
                </div>

                <div id="ajax_result">

                </div>

            </div>

        </section>
    </div>
    @endif
        


    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://www.jqueryscript.net/demo/Highly-Customizable-Range-Slider-Plugin-For-Bootstrap-Bootstrap-Slider/dist/bootstrap-slider.js"></script>

    <script>
        $("#ex2").slider({});
    </script>

    <script>

        var config = {

            products: function(){
                var key = $('#search').val();
                var colors = [];
                $('.color_check:checked').each(function(){
                    colors.push($(this).val());
                });
                //price
                var p = [];
                var price = $('#ex2').val();
                p = price.split(',');
                var min = p[0];
                var max = p[1];
                $('#min_value').text("KM: "+min);
                $('#max_value').text("KM: "+max);
                //end

                var dataString = 'key=' + key + '&colors=' + colors + '&price=' + price;

                $.ajax({
                    url: "{{ url('get-products-ajax') }}",
                    type: "get",
                    data: dataString,
                    success:function(data){
                        if(data != ""){

                            $("#ajax_result").html(data);
                        } else {
                            $("#ajax_result").html("<p>Nema podataka</p>");
                        }
                    }
                });

            },
            cart_count: function(){
                $.ajax({
                    url: "{{ url('get-cart-count') }}",
                    type: "get",
                    success:function(data){
                        if(data){
                            $("#cart_count").text(data.cart_count);
                        }
                    }
                });
            }

        };
    </script>
    <script>
        $(document).ready(function(){

            config.products();
            config.cart_count();

            $(".searchProd").keyup(function(){
                config.products();
            });
            $('.color_check').on('click', function(){
                config.products();
            });
            $('#ex2').change(function(){
                config.products();
            });

        });

    </script>

</html>
