<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Products</title>


    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="stylesheet" type="text/css" href="{{ url('assets/style.css') }}">
    <link rel="stylesheet" type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css">
    <link href="https://www.jqueryscript.net/demo/Highly-Customizable-Range-Slider-Plugin-For-Bootstrap-Bootstrap-Slider/dist/css/bootstrap-slider.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.css">

    <style>
        #slider5a .slider-track-high, #slider5c .slider-track-high {
            background: green;
        }

        #slider5b .slider-track-low, #slider5c .slider-track-low {
            background: red;
        }

        #slider5c .slider-selection {
            background: yellow;
        }
        </style>



</head>
<body>


    <nav class="navbar navbar-expand-sm navbar-light bg-white border-bottom">

        <a class="navbar-brand ml-2 font-weight-bold" href="#">
            <span id="burgundy"></span><span id="orange">Products</span>
        </a>

        <div class="collapse navbar-collapse" id="navbarColor">
            <ul class="navbar-nav">
                <li class="nav-item rounded bg-light search-nav-item">
                    <input type="text" id="search" class="bg-light searchProd" placeholder="Search Products">
                </li>
                {{-- <button class="bt btn-primary">Search</button> --}}
            </ul>
        </div>


        @if(session('userid'))

            <a class="" href="">
                <span id="burgundy"></span><span id="blue">
                    {{ strtoupper(session('username')) }}
                    <i class="fa fa-user" aria-hidden="true"></i>
                </span>
            </a>
            &nbsp;

            <a class="" href="{{ url('add-product')}}">
                <span id="burgundy"></span><span id="blue">
                <i class="fa fa-plus" aria-hidden="true"></i>
                </span>
            </a>
            &nbsp;
            <a class="" href="{{ url('/cart-products')}}">
                <span id="burgundy"></span><span id="blue">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                    ( <span id="cart_count"> </span>  )
                </span>
            </a>
            &nbsp;
            <a class="" href="{{ url('logout')}}">
                <span id="burgundy"></span><span id="blue">
                    <i class="fa fa-sign-out" aria-hidden="true"></i>
                </span>
            </a>
            &nbsp;
        @else
            <a class="" href="{{ url('login')}}">
                <span id="burgundy"></span><span id="blue">LOGIN</span>
            </a>
            &nbsp; | &nbsp;
            <a class="" href="{{ url('signup')}}">
                <span id="burgundy"></span><span id="blue">REGISTER</span>
            </a>
            &nbsp; | &nbsp;
        @endif

    </nav>


    <section id="sidebar">

        <p> Home | <b>Products</b></p>

        <div class="border-bottom pb-2 ml-2">
            <h4 id="burgundy">Filters</h4>
            {{-- <div class="filter">
                <a href=""><button class="">Clear</button> </a>
            </div> --}}
        </div>

        <div class="py-2 border-bottom ml-3">
            <h5 id="burgundy">Price</h5>
            <b id="min_value">Rs. {{ $price['min'] }}</b> <input id="ex2" type="text" class="span2" value="" data-slider-min="{{ $price['min'] }}" data-slider-max="{{ $price['max'] }}" data-slider-step="5" data-slider-value="[{{ $price['min']}},{{ $price['max']}}]"/> <b id="max_value">Rs. {{$price['max']}}</b>
        </div>

        <div class="py-2 ml-3">
            <h5 id="burgundy">Colors</h5>
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
                            $("#ajax_result").html("<p>No data Avaliable</p>");
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
