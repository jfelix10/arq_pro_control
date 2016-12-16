<?php 

    /*
    * Recuperando e formatando array de sistemas para verificar quais sistemas o usuário tem acesso no menu
    */

    // array que vai receber os sistemas e seus respectivos níveis de permissão
    $aSistemas = [];

    // compondo o array com seus sistemas na chave e suas permissões nos valores
    if (isset(Session::all()['usuario']['sistema'])) 
    {
        foreach (Session::all()['usuario']['sistema'] as $key => $value) 
        {
            $aSistemas[key($value)] = $value[key($value)];
        }
    }

    // armazenando url para verificar se menu deve aparecer
    $sUrl = Route::getCurrentRoute()->getPath();
    
    // dd(isset($aSistemas[0]));

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>RGM</title>


    <!-- Bootstrap Core CSS -->
    {{ Html::style('vendor/bootstrap/css/bootstrap.css') }}

    <!-- Custom Fonts -->
    {{ Html::style('vendor/font-awesome/css/font-awesome.css') }}

    <!-- Plugin CSS -->
    {{ Html::style('vendor/magnific-popup/magnific-popup.css') }}

    <!-- Theme CSS -->
    {{ Html::style('css/creative.css') }}
    {{ Html::style('css/docsupport/prism.css') }}
    {{ Html::style('css/chosen.css') }}


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.js"></script>
    <![endif]-->

    <style>
        #btnSair
        {
            padding: 10px 10px 5px 5px;
            font-size: 25px;
        }
    </style>

</head>

<body id="page-top">

    <nav id="mainNav" class="navbar navbar-inverse navbar-fixed-top" >
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <!-- <label> -->
                    <a href="{{ URL::to('sistema/home') }}" class="navbar-brand" style="padding-top: 2px">
                        <div class="form-group">
                            {{ Html::image('img/logo/logo_bar.png', 'alt', ['width' => '60em', 'height' => '60em']) }}
                            <small style="letter-spacing: 2px; font-weight: 100;"> arqproControl</small>
                        </div>
                    </a>
                <!-- </label> -->
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                @if(!str_contains($sUrl, 'login') && $sUrl != '/')
                <ul class="nav navbar-nav navbar-right">
                    @if(isset($aSistemas[10]) && $aSistemas[10] == 1)
                        <li>
                            <a class="page-scroll" href="{{ URL::route('novoprojeto') }}">projetos</a>
                        </li>
                    @endif

                    @if(isset($aSistemas[12]) && $aSistemas[12] == 1)
                    <li>
                        <a class="page-scroll" href="{{ URL::route('etapasprojeto') }}">etapas dos projetos</a>
                    </li>
                    @endif

                    @if(isset($aSistemas[11]) && $aSistemas[11] == 1)
                    <li>
                        <a class="page-scroll" href="{{ URL::route('areasprojeto') }}">informações dos projetos</a>
                    </li>
                    @endif

                    @if(isset($aSistemas[2]) && $aSistemas[2] == 1)
                    <li>
                        <a class="page-scroll" href="#">financeiro</a>
                    </li>
                    @endif
                    <a class="glyphicon glyphicon-off" data-toggle="tooltip" data-placement="bottom" title="sair..." href="{{ URL::route('login') }}" id="btnSair"></a>
                </ul>
                @endif

            </div>
        </div>
        <!-- /.container-fluid -->
    </nav>

    <div class="col-col-sm-12 col-md-12" style="position: relative; top: 0px; width: 100%; height: 72px;">
        
    </div>
    
    <div class="container-fluid" style='position: relative;'>
        @yield('content')
    </div>

        @yield('grid')

    <!-- jQuery -->
    {{ Html::script('vendor/jquery/jquery.js') }}

    <!-- Bootstrap Core JavaScript -->
    {{ Html::script('vendor/bootstrap/js/bootstrap.js') }}

    <!-- Plugin JavaScript -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    {{ Html::script('vendor/scrollreveal/scrollreveal.js') }}
    {{ Html::script('vendor/magnific-popup/jquery.magnific-popup.js') }}

    <!-- Theme JavaScript -->
    {{ Html::script('js/creative.js') }}
    
    <!-- PLUGINS -->
    {{ Html::script('js/jquery.mask.min.js') }}
    {{ Html::script('js/chosen.jquery.js') }}
    {{ Html::script('js/docsupport/prism.js') }}

    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip(); 
        });
    </script>
    @yield('script')

    
</body>

</html>
