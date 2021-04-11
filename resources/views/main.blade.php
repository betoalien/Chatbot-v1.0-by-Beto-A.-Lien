<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Chatbot v.10 by Beto A. Lien</title>

    <!-- Scripts -->
<!--<script src="{{ asset('js/app.js') }}" defer></script>-->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/menufull.css') }}" rel="stylesheet">
    <script src="http://www.geriatree.site/kchat/box/assets/js/kchat.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>-->
    <link href="{{ asset('css/bot.css') }}" rel="stylesheet">
    <link href="{{ asset('css/chatstyle.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-icons/3.0.1/iconfont/material-icons.min.css">

<!-- 1. Addchat css
    <link href="<?php echo asset('assets/addchat/css/addchat.min.css') ?>" rel="stylesheet">-->

    <style>
        .buttoneffect {
            padding: 15px 25px;
            font-size: 20px;
            text-align: center;
            cursor: pointer;
            outline: none;
            color: #fff;
            background-color: #ff0000;
            border: none;
            border-radius: 15px;
            box-shadow: 0 9px #999;
        }

        .buttoneffect:hover {background-color: #ff0000}

        .buttoneffect:active {
            background-color: #ff0000;
            box-shadow: 0 5px #fff000;
            transform: translateY(4px);
        }
    </style>

</head>
<body>


<div id="app">
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h4>Chatbot v1.0 by Beto A. Lien</h4>
                </div>
                <div class="col-md-4">
                    <h4 class="text-white">Buenos días</h4>
                </div>
                <div class="col-md-4">

                        <a href="{{url('/administrador')}}"><h4><i class="fa fa-home fa-2x"></i>  Inicio</h4></a>



                        <a href="{{url('/pacientes')}}"><h5><i class="fa fa-home fa-2x"></i>  Inicio</h5></a>
                    <!-- <a href="{{url('/chat')}}"><h5><i class="fa fa-comment fa-2x"></i>  Chat</h5></a>-->


                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        <h4><i class="fa fa-door-open fa-2x"></i>  Cerrar Sesión</h4>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>>
            </div>
        </div>
    </div>
    <span style="font-size:30px;cursor:pointer" class="text-white" onclick="openNav()">   &#9776; Menú</span>
    <main class="py-4">
        @yield('content')
    </main>
    <section>
        <button class="chat-btn">
            <i class="material-icons"> comment </i>
        </button>

        <div class="chat-popup">
            <div class="wrapper">
                <div class="title">Chatbot v1.0 by Beto A. Lien
                </div>
                <div class="form">
                    <div class="bot-inbox inbox">
                        <div class="icon">
                            <i class="fa fa-user"></i>
                        </div>
                        <div class="msg-header">
                            <p>Hi!, How can I help you? Type the number of Question to receive an answer<br/>
                                @foreach($Chatbots as $Chatbot)
                                    @if($Chatbot->number == 0)
                                    <h5>{{$Chatbot->completquest}}</h5>
                                     @endif
                                      @if($Chatbot->number <> 0)
                                            <h5>{{$Chatbot->number}}}.-{{$Chatbot->completquest}}</h5>
                                      @endif
                                @endforeach
                        </div>
                    </div>
                </div>
                <div class="typing-field">
                    <div class="input-data">
                        {{ csrf_field() }}
                        <input id="data" type="text" placeholder="Write your message.." required>
                        <button id="send-btn">Enviar</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="//code.jquery.com/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.7.6/handlebars.min.js"></script>

<script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "100%";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }
</script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function(){
        $("#send-btn").on("click", function(){
            $value = $("#data").val();
            $msg = '<div class="user-inbox inbox"><div class="msg-header"><p>'+ $value +'</p></div></div>';
            $(".form").append($msg);
            $("#data").val('');

            // start ajax code
            $.ajax({
                type: 'POST',
                url: "{{route('Chatbots.messagebot')}}",
                data: 'text='+$value,
                success: function(result){
                    $replay = '<div class="bot-inbox inbox"><div class="icon"><i class="fas fa-user"></i></div><div class="msg-header"><p>'+ result +'</p></div></div>';
                    $(".form").append($replay);
                    // when chat goes down the scroll bar automatically comes to the bottom
                    $(".form").scrollTop($(".form")[0].scrollHeight);
                }
            });
        });
    });
</script>


<script src="https://cdn.jsdelivr.net/npm/@joeattardi/emoji-button@3.1.1/dist/index.min.js"></script>
<script src="{{ asset('js/main.js') }}" defer></script>

</body>
</html>

