<!DOCTYPE html> 
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?= NOMBRE_WEB ?> | Registro completo</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <style type="text/css">
            body {
                font-family: Helvetica, Arial, sans-serif;
                margin: 0;
                padding: 0;
                -ms-text-size-adjust: 100%;
                -webkit-text-size-adjust: 100%;
            }
            table {
                border-spacing: 0;
            }
            table td {
                border-collapse: collapse;
            }

            table {
                mso-table-lspace: 0pt;
                mso-table-rspace: 0pt;
            }           
            .yshortcuts a {
                border-bottom: none !important;
            }
            @media screen and (max-width: 599px) {
                .force-row,
                .container {
                    width: 100% !important;
                    max-width: 100% !important;
                }
            }
            @media screen and (max-width: 400px) {
                .container-padding {
                    padding-left: 12px !important;
                    padding-right: 12px !important;
                }
            }

            .header {
                font-size:24px;
                padding-bottom:12px;
                color:#2a64ff;
                padding-left:24px;
                padding-right:24px;
            }

            .content {
                padding-left:24px;
                padding-right:24px;
                padding-top:12px;
                padding-bottom:12px;
                background-color:#ffffff;
            }

            .body-text {
                font-size:14px;
                line-height:20px;
                text-align:left;
                color:#333333;
            }

            .footer-text {
                font-size:12px;
                line-height:16px;
                color:#aaaaaa;
                padding-left:24px;
                padding-right:24px;
            }

            .titulo {
                font-size:18px;
                font-weight:600;
                color:#374550;
            }
            a {
                color: #2a64ff;
            }
            a:link,
            a:visited,
            a:active {
                text-decoration: none;
            }      

            a:hover {
                text-decoration: underline;
            }

        </style>
    </head>

    <body style="margin:0; padding:0;" bgcolor="#F0F0F0">

        <!-- 100% background wrapper (fondo gris) -->
        <table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" bgcolor="#F0F0F0">
            <tr>
                <td align="center" valign="top" bgcolor="#F0F0F0" style="background-color: #F0F0F0;">
                    <br>

                    <!-- 600px container (fondo blanco) -->
                    <table border="0" width="600" cellpadding="0" cellspacing="0" class="container" style="width:600px;max-width:600px">
                        <tr>
                            <td class="container-padding header" align="left">
                                <a href="<?= site_url() ?>"><b>TITIS</b></a>
                            </td>
                        </tr>
                        <tr>
                            <td class="container-padding content" align="left">
                                <br>
                                <div class="titulo">Registro completo</div>
                                <br>
                                <div class="body-text">
                                    Su usuario es: <b><?= $usuario ?></b>
                                    <br><br>
                                    Su contraseña es: <b><?= $pass ?></b>
                                    <br><br>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="container-padding footer-text" align="left">
                                <br>
                                <strong>Copyright &copy; <?= AÑOS_COPYRIGHT ?> <a href="<?= site_url() ?>"><?= NOMBRE_WEB ?></a>.</strong> Todos los derechos reservados.
                            </td>
                        </tr>
                    </table>
                    <!--/600px container -->

                </td>
            </tr>
        </table>
        <!--/100% background wrapper-->

    </body>
</html>