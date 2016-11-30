<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= NOMBRE_WEB ?> | 404 <?= $this->lang->line('pagina_no_encontrada'); ?></title>

        <link href="<?= site_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

        <style>
            body{
                font-family: 'Open Sans', sans-seriff;
                font-size: 14px;
                color: #2c83c3;
                background: url('<?= site_url("assets/img/fondo-ruido.png") ?>');
                background-repeat: repeat;   
            }

            .container{
                margin-top: 100px;
            }


            h1,h2,h3,h4,h5,h6{
                font-family: 'Open Sans', sans-seriff;
                font-weight: 700;
            }

            h1{
                font-size: 200px;
                margin-top: 0px;
                margin-bottom: 0px;
            }

            h2{
                font-size: 40px;
            }

            h3{
                font-size: 34px;
            }

            .center{
                text-align: center;
            }

            .capital{
                text-transform: uppercase;
            }

            .form{
                margin-top: 20px;
            }

            .btn-default{
                padding-top: 10px;
                font-weight: bold;
                text-align: center;
                height: 42px;
                border: 1px solid #135688;
                background-color: #2c83c3;
                color: #fff;
                text-transform: uppercase;
                transition: all .2s linear;
                -moz-transition: all .2s linear;
                -webkit-transition : all .2s linear;
                -o-transition: all .2s linear;
            }


            .btn-default:active,
            .btn-default.active,
            .btn-default:focus,
            .btn-default.focus,
            .btn-default:hover{
                color: white;
                background-color: #135688;
            }

            .btn-default:active:hover,
            .btn-default.active:hover,
            .btn-default:active:focus,
            .btn-default.active:focus,
            .btn-default:active.focus,
            .btn-default.active.focus {
                color: white;
                background-color: #063252;
            }
        </style>

        <!-- HTML5 shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

    </head>
    <body>
        <section>
            <div class="container">
                <div class="row row1">
                    <div class="col-md-12">
                        <h2 class="center capital">Error</h2>
                        <h1 id="error" class="center">0</h1>
                        <h3 class="center capital">¡<?= $this->lang->line('pagina_no_encontrada'); ?>!</h3>
                    </div>
                </div>               

                <div class="row">
                    <div class="col-md-12">     
                        <div class="col-md-6 col-md-offset-3 form">
                            <a href="<?= site_url('/') ?>" class="btn btn-default col-md-offset-2 col-md-8 col-xs-12" role="button"><?= $this->lang->line('inicio'); ?></a>
                        </div>
                    </div>
                </div>               
            </div>
        </section>

        <script src="<?= site_url('assets/plugins/jQuery/jquery.min.js') ?>" type="text/javascript"></script>
        <script src="<?= site_url('assets/plugins/countUp/countUp.min.js') ?>" type="text/javascript"></script>

        <!--Initiating the CountUp Script-->
        <script type="text/javascript">
            "use strict";
            var count = new CountUp("error", 0, 404, 0, 3);

            window.onload = function () {
                count.start();

            }
        </script>

    </body>
</html>
