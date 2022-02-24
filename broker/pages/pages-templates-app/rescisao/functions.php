<?php
require('vendor/autoload.php');

// referenciando o namespace do dompdf
use Dompdf\Dompdf;

function enviaContratoBancos($nome, $email, $data, $motivo, $empresa, $atuacaoAgente, $atuacaoAgente2)
{
    $dompdf = new Dompdf();
    $dompdf->set_option('isRemoteEnabled', TRUE);
    $dompdf->loadHtml('
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
    <html>

    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <style type="text/css">
            <!-- .style6 {
            font-family: Arial,
            Helvetica,
            sans-serif;
            font-size: 16px;
            }

            .style7 {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 16px;
            }

            .style3 {
                font-family: "Courier New", Courier, mono;
                font-size: 11px;
            }

            .style4 {
                color: #FF9900
            }
            -->
        </style>
    </head>

    <body>
        <div align="center">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <!--DWLayoutTable-->
                <tr>
                    <td width="100%" valign="top">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <!--DWLayoutTable-->
                            <tr>
                                <td width="100%" valign="top"><img src="https://cdn.digitalintelligentia.com/img_recisao/logo-bancos.png" width="100%"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td valign="top">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <!--DWLayoutTable-->
                            <tr>
                                <td width="100%" valign="top">
                                    <blockquote>
                                        <blockquote>
                                            <p class="style1 style5 style6">Prezado Agente,</p>
                                        </blockquote>
                                        <p align="justify" class="style7"> &Eacute; a presente para, mediante permiss&atilde;o legal do contrato de CFFE assinado por Vossa Senhoria com esta empresa da qual eu sou Diretor Superintendente, formalizar por carta a rescis&atilde;o do contrato referendado,
                                            por motivo de ' . $motivo . ', conforme j&aacute; &eacute; de conhecimento das partes.</p>
                                        <p class="style7">Profissional ' . $atuacaoAgente2 . ':</p>
                                        <p class="style7">' . $nome . '</p>
                                        <p class="style7">Cordialmente,</p>
                                        <p class="style7">Curitiba, ' . $data . '</p>
                                        <p class="style7"><img src="https://cdn.digitalintelligentia.com/img_recisao/assinatura-bancos.png" width="40%"></p>
                                    </blockquote>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td valign="top">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <!--DWLayoutTable-->
                            <tr>
                                <td width="100%" valign="top">
                                    <blockquote>
                                        <p align="justify"><span class="style3"> <strong><span class="style4"><strong>&reg; </strong>Direitos Reservados no INPI/Funda&ccedil;&atilde;o Biblioteca Nacional.</span> Registro na FBN-RJ, sob o n. 227.955 e sequenciais. Proibida a reprodução xerográfica e outra, total ou parcial, bem como o plágio, ex vi da Lei n. 9.610/98, exceto com permissão expressa e por escrito do titular da INTELLIGENZ, e LAVVŌR. A violação aos direitos autorais ensejará punição ético-profissional, civil e criminal (Artigo 184 do Código Penal).Direito autoral resguardado no valor de 7 (sete) milhões de reais. </strong> </span>
                                        </p>
                                    </blockquote>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td valign="top">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <!--DWLayoutTable-->
                            <tr>
                                <td width="100%" valign="top"><img src="https://cdn.digitalintelligentia.com/img_recisao/rodape-bancos.png" width="100%"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>

    </html>
    ');

    // Definindo o papel e a orientação
    $dompdf->setPaper('A4', 'portrait');

    // Renderizando o HTML como PDF
    $dompdf->render();

    // Enviando o PDF para o browser
    $output = $dompdf->output();
    file_put_contents('rescisoes_geradas/rescisao-bancos-' . $nome . '-' . date('Ymd') . '.pdf', $dompdf->output());

    //$dompdf->stream('recisao-bancos-' . $nome . '-' . date('Ymd') . '.pdf');

    // Envia o PDF por e-mail
    $msg = '
        <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
        <html>
        <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <style type="text/css">
        <!--
        .style1 {font-family: Arial, Helvetica, sans-serif}
        a:link {
            color: #0033FF;
            text-decoration: none;
        }
        a:visited {
            text-decoration: none;
            color: #0099FF;
        }
        a:hover {
            text-decoration: none;
            color: #FFFF00;
        }
        a:active {
            text-decoration: none;
            color: #0099FF;
        }
        .style2 {
            color: #0033FF;
            font-weight: bold;
        }
        .style3 {font-size: 12px}
        -->
        </style>
        </head>

        <body>
        <div align="center">
        <p class="style1">&nbsp;</p>
        <p class="style1">&nbsp;</p>
        <p class="style1">&nbsp;</p>
        <p class="style1">Prezado Agente!
        </p>
        </div>
        <p align="center" class="style1">Segue em anexo as cartas de rescis&atilde;o dos contratos <strong>BANCO LAVVOR, BANCO INTELLIGENZ, BANCO CONSTELLATER, DIGITAL ALLOCATE E DIGITAL INTELLIGENTIA</strong> assinados pela Vossa Senhoria, conforme j&aacute; &eacute; de conhecimento das partes.</p>
        <p align="center" class="style1">&nbsp;</p>
        <p align="center" class="style1">Atenciosamente.</p>
        <p align="center" class="style1"><img src="https://digitalintelligentia.com/app/assets/img/digital-intelligentia-logo.png" width="15%"></p>
        </body>
        </html>
    ';

    $caminhoCompleto = 'rescisoes_geradas/rescisao-bancos-' . $nome . '-' . date('Ymd') . '.pdf';

    $smtp = '200.195.183.75';
    $logine = 'cadastro@digitalintelligentia.com';
    $passwd = 'ASZu?PfX54Z8';
    $aut = 'TRUE';
    $retorn = 'cadastro@digitalintelligentia.com';
    $porta = '587';
    $nome = 'Cadastro | Digital Intelligentia';
    $assunto = 'RESCISÃO CONTRATUAL - BANCO LAVVOR, INTELLIGENZ & CONSTELLATER';
    //$cct = $email;
    $cct = 'cadastro@digitalintelligentia.com';
    $cct2 = 'luisfelipe@intelligenttia.com';

    // Chama phpMailer
    require_once('PHPMailer/class.phpmailer.php');
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Host = $smtp;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = '';
    $mail->Port = $porta;
    $mail->Username = $logine;
    $mail->Password = $passwd;
    $mail->From = $logine;
    $mail->Sender = $logine;
    $mail->FromName = $nome;
    $mail->AddAddress($cct);
    $mail->AddAddress($cct2);
    $mail->IsHTML(true);
    $mail->CharSet = 'utf-8';
    $mail->Subject = $assunto;
    $mail->Body = utf8_decode($msg);
    $mail->AddAttachment($caminhoCompleto);
    $enviado = $mail->Send();
    $mail->ClearAllRecipients();
    $mail->ClearAttachments();

    unlink($caminhoCompleto);
    return;
}

function enviaContratoIntelligentia($nome, $email, $data, $motivo, $empresa, $atuacaoAgente, $atuacaoAgente2)
{
    // instanciando o dompdf

    $dompdf = new Dompdf();
    $dompdf->set_option('isRemoteEnabled', TRUE);
    $dompdf->loadHtml('
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
    <html>
    
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <style type="text/css">
                <!-- .style1 {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 18px;
            }
            
            .style3 {
                font-family: "Courier New", Courier, mono;
                font-size: 10px;
            }
            
            .style4 {
                color: #FF9900
            }
            
            .style5 {
                font-size: 19px
            }
            
            .style6 {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 19px;
    .style7 {font-family: Arial, Helvetica, sans-serif}
    .style7 {font-family: Arial, Helvetica, sans-serif}
                -->
        </style>
    </head>
    
    <body>
        <div align="center">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <!--DWLayoutTable-->
                <tr>
                    <td width="100%" valign="top">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <!--DWLayoutTable-->
                            <tr>
                                <td width="100%" valign="top">
                                    <div align="center"><img src="https://cdn.digitalintelligentia.com/img_recisao/logo-digitalintelligentia.png" width="100%"></div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="style2">
                        <blockquote>
                            <blockquote>
                            <p class="style1 style5">Prezado Agente,</p>
                            </blockquote>
                            <p align="justify" class="style6"> &Eacute; a presente para, mediante permiss&atilde;o legal do contrato ' . $atuacaoAgente . ' INTELLIGENTIA LEGALE assinado por Vossa Senhoria com esta empresa da qual eu sou Diretor Superintendente, formalizar por carta a rescis&atilde;o do
                                contrato referendado, por motivo de ' . $motivo . ' conforme j&aacute; &eacute; de conhecimento das partes.</p>
                            <p class="style6">Profissional ' . $atuacaoAgente2 . ':</p>
                            <p class="style6">' . $nome . '</p>
                            <p class="style5 style7">Cordialmente,</p>
                            <p class="style6">Curitiba, ' . $data . '</p>
                            <p class="style1"><img src="https://cdn.digitalintelligentia.com/img_recisao/assinatura-digitalintelligentia.png" width="35%"></p>
                        </blockquote>
                    </td>
                </tr>
                <tr>
                    <td valign="top">
                        <blockquote>
                            <p align="justify"><span class="style3"><strong><span class="style4"> &reg; Direitos Reservados no INPI/Funda&ccedil;&atilde;o Biblioteca Nacional.</span> Registro na FBN-RJ, sob o n. 227.955 e sequenciais. Proibida a reprodução xerográfica e outra, total ou parcial, bem como o plágio, ex vi da Lei n. 9.610/98, exceto com permissão expressa e por escrito do titular da INTELLIGENTIA LEGALE e LANDHILL GOTTES DIENER. A violação aos direitos autorais ensejará punição ético-profissional, civil e criminal (Artigo 184 do Código Penal. Direito autoral resguardado no valor de 7 (sete) milhões de reais. </strong></span>
                            </p>
                        </blockquote>
                    </td>
                </tr>
                <tr>
                    <td valign="top">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <!--DWLayoutTable-->
                            <tr>
                                <td width="100%" valign="top">
                                    <div align="left"><img src="https://cdn.digitalintelligentia.com/img_recisao/rodape-digitalintelligentia.png" width="100%"></div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>
    
    </html>
    ');

    // Definindo o papel e a orientação
    $dompdf->setPaper('A4', 'portrait');

    // Renderizando o HTML como PDF
    $dompdf->render();

    // Enviando o PDF para o browser
    $output = $dompdf->output();
    file_put_contents('rescisoes_geradas/rescisao-digitalintelligentia-' . $nome . '-' . date('Ymd') . '.pdf', $dompdf->output());

    //$dompdf->stream('recisao-digitalintelligentia-' . $nome . '-' . date('Ymd') . '.pdf');

    // Envia o PDF por e-mail
    $msg = '
       <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
       "http://www.w3.org/TR/html4/loose.dtd">
       <html>
       <head>
       <title></title>
       <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
       <style type="text/css">
       <!--
       .style1 {font-family: Arial, Helvetica, sans-serif}
       a:link {
           color: #0033FF;
           text-decoration: none;
       }
       a:visited {
           text-decoration: none;
           color: #0099FF;
       }
       a:hover {
           text-decoration: none;
           color: #FFFF00;
       }
       a:active {
           text-decoration: none;
           color: #0099FF;
       }
       .style2 {
           color: #0033FF;
           font-weight: bold;
       }
       .style3 {font-size: 12px}
       -->
       </style>
       </head>

       <body>
       <div align="center">
       <p class="style1">&nbsp;</p>
       <p class="style1">&nbsp;</p>
       <p class="style1">&nbsp;</p>
       <p class="style1">Prezado Agente!
       </p>
       </div>
       <p align="center" class="style1">Segue em anexo as cartas de rescis&atilde;o dos contratos <strong>BANCO LAVVOR, BANCO INTELLIGENZ, BANCO CONSTELLATER, DIGITAL ALLOCATE E DIGITAL INTELLIGENTIA</strong> assinados pela Vossa Senhoria, conforme j&aacute; &eacute; de conhecimento das partes.</p>
       <p align="center" class="style1">&nbsp;</p>
       <p align="center" class="style1">Atenciosamente.</p>
       <p align="center" class="style1"><img src="https://digitalintelligentia.com/app/assets/img/digital-intelligentia-logo.png" width="15%"></p>
       </body>
       </html>
   ';

    $caminhoCompleto = 'rescisoes_geradas/rescisao-digitalintelligentia-' . $nome . '-' . date('Ymd') . '.pdf';

    $smtp = '200.195.183.75';
    $logine = 'cadastro@digitalintelligentia.com';
    $passwd = 'ASZu?PfX54Z8';
    $aut = 'TRUE';
    $retorn = 'cadastro@digitalintelligentia.com';
    $porta = '587';
    $nome = 'Cadastro | Digital Intelligentia';
    $assunto = 'RESCISÃO CONTRATUAL - DIGITAL INTELLIGENTIA';
    //$cct = $email;
    $cct = 'cadastro@digitalintelligentia.com';
    $cct2 = 'luisfelipe@intelligenttia.com';

    // Chama phpMailer
    require_once('PHPMailer/class.phpmailer.php');
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Host = $smtp;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = '';
    $mail->Port = $porta;
    $mail->Username = $logine;
    $mail->Password = $passwd;
    $mail->From = $logine;
    $mail->Sender = $logine;
    $mail->FromName = $nome;
    $mail->AddAddress($cct);
    $mail->AddAddress($cct2);
    $mail->IsHTML(true);
    $mail->CharSet = 'utf-8';
    $mail->Subject = $assunto;
    $mail->Body = utf8_decode($msg);
    $mail->AddAttachment($caminhoCompleto);
    $enviado = $mail->Send();
    $mail->ClearAllRecipients();
    $mail->ClearAttachments();

    unlink($caminhoCompleto);
    return;
}

function enviaContratoAllocate($nome, $email, $data, $motivo, $empresa, $atuacaoAgente, $atuacaoAgente2)
{

    $dompdf = new Dompdf();
    $dompdf->set_option('isRemoteEnabled', TRUE);
    $dompdf->loadHtml('
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
    <html>

    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <style type="text/css">
            <!-- .style7 {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 16px;
            }
            
            .style8 {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 16px;
            }
            
            .style3 {
                font-family: "Courier New", Courier, mono;
                font-size: 11px;
            }
            
            .style4 {
                color: #FF9900
            }
            
            -->
        </style>
    </head>

    <body>
        <div align="center">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <!--DWLayoutTable-->
                <tr>
                    <td width="100%" valign="top">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <!--DWLayoutTable-->
                            <tr>
                                <td width="100%" valign="top"><img src="https://cdn.digitalintelligentia.com/img_recisao/logo-digitalallocate.png" width="100%"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td valign="top">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <!--DWLayoutTable-->
                            <tr>
                                <td width="100%" valign="top">
                                    <blockquote>
                                        <blockquote>
                                            <p class="style1 style5 style6 style7">&nbsp;</p>
                                            <p class="style1 style5 style6 style7">Prezado Agente,</p>
                                        </blockquote>
                                        <p align="justify" class="style8"> &Eacute; a presente para, mediante permiss&atilde;o legal do contrato de ' . $atuacaoAgente . ' DIGITALALLOCATE assinado por Vossa Senhoria com esta empresa da qual eu sou Diretor Superintendente, formalizar por carta a rescis&atilde;o
                                            do contrato referendado, por motivo de ' . $motivo . ' conforme j&aacute; &eacute; de conhecimento das partes.</p>
                                        <p align="justify" class="style8">&nbsp;</p>
                                        <p class="style8">Profissional ' . $atuacaoAgente2 . ':</p>
                                        <p class="style8">' . $nome . '</p>
                                        <p class="style8">&nbsp;</p>
                                        <p class="style8">Cordialmente,</p>
                                        <p class="style8">Curitiba, ' . $data . '</p>
                                        <p class="style8"><img src="https://cdn.digitalintelligentia.com/img_recisao/assinatura-digitalallocate.png" width="40%"></p>
                                    </blockquote>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td valign="top">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <!--DWLayoutTable-->
                            <tr>
                                <td width="100%" valign="top">
                                    <blockquote>
                                        <p align="justify" class="style3"><strong><span class="style4"><strong>&reg; </strong>
                                            <strong>Direitos Reservados no INPI/Funda&ccedil;&atilde;o Biblioteca Nacional.</strong></span><strong>Registro na FBN-RJ, sob o n. 227.955 e sequenciais. Proibida a reprodução xerográfica e outra, total ou parcial, bem como o plágio, ex vi da Lei n. 9.610/98, exceto com permissão expressa e por escrito do titular da RURALFLUUX, ADVOCATOOLS, ALLOCATOOLS, PERSSONALLE, RURALPERSSONALLE, FAACILE e AGROFAACILE. A violação aos direitos autorais ensejará punição ético-profissional, civil e criminal (Artigo 184 do Código Penal). Direito autoral resguardado no valor de 7 (sete) milhões de reais. </strong>
                                            </strong>
                                        </p>
                                    </blockquote>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td valign="top">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <!--DWLayoutTable-->
                            <tr>
                                <td width="100%" valign="top"><img src="https://cdn.digitalintelligentia.com/img_recisao/rodape-digitalallocate.png" width="100%"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>

    </html>
    ');

    // Definindo o papel e a orientação
    $dompdf->setPaper('A4', 'portrait');

    // Renderizando o HTML como PDF
    $dompdf->render();

    // Enviando o PDF para o browser
    $output = $dompdf->output();
    file_put_contents('rescisoes_geradas/rescisao-allocate-' . $nome . '-' . date('Ymd') . '.pdf', $dompdf->output());

    //$dompdf->stream('recisao-digitalallocate-' . $nome . '-' . date('Ymd') . '.pdf');

    // Envia o PDF por e-mail
    $msg = '
        <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
        <html>
        <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <style type="text/css">
        <!--
        .style1 {font-family: Arial, Helvetica, sans-serif}
        a:link {
            color: #0033FF;
            text-decoration: none;
        }
        a:visited {
            text-decoration: none;
            color: #0099FF;
        }
        a:hover {
            text-decoration: none;
            color: #FFFF00;
        }
        a:active {
            text-decoration: none;
            color: #0099FF;
        }
        .style2 {
            color: #0033FF;
            font-weight: bold;
        }
        .style3 {font-size: 12px}
        -->
        </style>
        </head>

        <body>
        <div align="center">
        <p class="style1">&nbsp;</p>
        <p class="style1">&nbsp;</p>
        <p class="style1">&nbsp;</p>
        <p class="style1">Prezado Agente!
        </p>
        </div>
        <p align="center" class="style1">Segue em anexo as cartas de rescis&atilde;o dos contratos <strong>BANCO LAVVOR, BANCO INTELLIGENZ, BANCO CONSTELLATER, DIGITAL ALLOCATE E DIGITAL INTELLIGENTIA</strong> assinados pela Vossa Senhoria, conforme j&aacute; &eacute; de conhecimento das partes.</p>
        <p align="center" class="style1">&nbsp;</p>
        <p align="center" class="style1">Atenciosamente.</p>
        <p align="center" class="style1"><img src="https://digitalintelligentia.com/app/assets/img/digital-intelligentia-logo.png" width="15%"></p>
        </body>
        </html>
    ';

    $caminhoCompleto = 'rescisoes_geradas/rescisao-allocate-' . $nome . '-' . date('Ymd') . '.pdf';

    $smtp = '200.195.183.75';
    $logine = 'cadastro@digitalintelligentia.com';
    $passwd = 'ASZu?PfX54Z8';
    $aut = 'TRUE';
    $retorn = 'cadastro@digitalintelligentia.com';
    $porta = '587';
    $nome = 'Cadastro | Digital Intelligentia';
    $assunto = 'RESCISÃO CONTRATUAL - DIGITALALLOCATE';
    //$cct = $email;
    $cct = 'cadastro@digitalintelligentia.com';
    $cct2 = 'luisfelipe@intelligenttia.com';

    // Chama phpMailer
    require_once('PHPMailer/class.phpmailer.php');
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Host = $smtp;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = '';
    $mail->Port = $porta;
    $mail->Username = $logine;
    $mail->Password = $passwd;
    $mail->From = $logine;
    $mail->Sender = $logine;
    $mail->FromName = $nome;
    $mail->AddAddress($cct);
    $mail->AddBCC($cct2);
    $mail->IsHTML(true);
    $mail->CharSet = 'utf-8';
    $mail->Subject = $assunto;
    $mail->Body = utf8_decode($msg);
    $mail->AddAttachment($caminhoCompleto);
    $enviado = $mail->Send();
    $mail->ClearAllRecipients();
    $mail->ClearAttachments();

    unlink($caminhoCompleto);

    return;
}



function enviaDeclaracaoIntelligentia($nome, $email, $data, $motivo, $clausulas, $mes)
{

    // instanciando o dompdf

    $dompdf = new Dompdf();
    $dompdf->set_option('isRemoteEnabled', TRUE);
    $dompdf->loadHtml('
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
    <html>
    
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <style type="text/css">
                <!-- .style1 {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 18px;
            }
            
            .style3 {
                font-family: "Courier New", Courier, mono;
                font-size: 10px;
            }
            
            .style4 {
                color: #FF9900
            }
            
            .style5 {
                font-size: 19px
            }
            
            .style6 {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 19px;
    .style7 {font-family: Arial, Helvetica, sans-serif}
    .style7 {font-family: Arial, Helvetica, sans-serif}
.style8 {font-size: 18px}
                -->
        </style>
    </head>
    
    <body>
        <div align="center">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <!--DWLayoutTable-->
                <tr>
                    <td width="100%" valign="top">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <!--DWLayoutTable-->
                            <tr>
                                <td width="100%" valign="top">
                                    <div align="center"><img src="https://cdn.digitalintelligentia.com/img_recisao/logo-digitalintelligentia.png" width="100%"></div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="style2">
                        <blockquote>
                          <blockquote>
                            <p align="center" class="style7 style8"><strong>DECIS&Atilde;O COLEGIADA PARA RESCIS&Atilde;O DE CONTRATO DE AUT&Ocirc;NOMO POR JUSTO MOTIVO<br>
                            </strong></p>
                          </blockquote>
                            <p align="justify" class="style6"> Em colegiado, os abaixo qualificados, decidiram por rescindir o contrato de aut&ocirc;nomo com o agente ' . $nome . ' pelos seguintes motivos: <br>
                              <br>
                            ' . $motivo . ', que d&atilde;o ensejo &agrave; rescis&atilde;o contratual, conforme cl&aacute;usula ' . $clausulas . ' do contrato rescindendo.<br>
                          Segue em anexo relat&oacute;rio de per&iacute;cias realizadas at&eacute; a data de hoje. </p>
                            <p class="style5 style7">&nbsp;</p>
                            <p align="center" class="style5 style7">Curitiba, ' . date('d') . ' de ' . $mes . ' de ' . date('Y') . '. </p>
                            <p align="center" class="style1"><img src="https://cdn.digitalintelligentia.com/img_recisao/assinatura_declaracao.png" width="35%"></p>
                        </blockquote>
                    </td>
                </tr>
                <tr>
                    <td valign="top">
                        <blockquote>
                            <p align="justify"><span class="style3"><strong><span class="style4"> </span></strong></span>
                            </p>
                        </blockquote>
                    </td>
                </tr>
                <tr>
                    <td valign="top">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <!--DWLayoutTable-->
                            <tr>
                                <td width="100%" valign="top">
                                    <div align="left"><img src="https://cdn.digitalintelligentia.com/img_recisao/rodape-digitalintelligentia.png" width="100%"></div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>
    
    </html>
    ');

    // Definindo o papel e a orientação
    $dompdf->setPaper('A4', 'portrait');

    // Renderizando o HTML como PDF
    $dompdf->render();

    // Enviando o PDF para o browser
    $output = $dompdf->output();
    file_put_contents('rescisoes_geradas/declaracao-digitalintelligentia-' . $nome . '-' . date('Ymd') . '.pdf', $dompdf->output());

    //$dompdf->stream('recisao-digitalintelligentia-' . $nome . '-' . date('Ymd') . '.pdf');

    // Envia o PDF por e-mail
    $msg = '
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
    <html>
    <head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <style type="text/css">
    <!--
    .style1 {font-family: Arial, Helvetica, sans-serif}
    a:link {
        color: #0033FF;
        text-decoration: none;
    }
    a:visited {
        text-decoration: none;
        color: #0099FF;
    }
    a:hover {
        text-decoration: none;
        color: #FFFF00;
    }
    a:active {
        text-decoration: none;
        color: #0099FF;
    }
    .style2 {
        color: #0033FF;
        font-weight: bold;
    }
    .style3 {font-size: 12px}
    -->
    </style>
    </head>

    <body>
    <div align="center">
    <p class="style1">&nbsp;</p>
    <p class="style1">&nbsp;</p>
    <p class="style1">&nbsp;</p>
    <p class="style1">Prezado Agente!
    </p>
    </div>
    <p align="center" class="style1">Segue em anexo as cartas de rescis&atilde;o dos contratos assinados pela Vossa Senhoria, conforme j&aacute; &eacute; de conhecimento das partes.</p>
    <p align="center" class="style1">&nbsp;</p>
    <p align="center" class="style1">Cl&aacute;sulas contratuais:</p>
    <p align="center" class="style1"><img src="https://cdn.digitalintelligentia.com/img_recisao/clusulas-contrato.jpeg" width="749" height="652"> </p>
    <p align="center" class="style1">&nbsp;</p>
    <p align="center" class="style1">Atenciosamente.</p>
    <p align="center" class="style1"><img src="https://digitalintelligentia.com/app/assets/img/digital-intelligentia-logo.png" width="15%"></p>
    </body>
    </html>
   ';

    $caminhoCompleto = 'rescisoes_geradas/declaracao-digitalintelligentia-' . $nome . '-' . date('Ymd') . '.pdf';

    $smtp = '200.195.183.75';
    $logine = 'cadastro@digitalintelligentia.com';
    $passwd = 'ASZu?PfX54Z8';
    $aut = 'TRUE';
    $retorn = 'cadastro@digitalintelligentia.com';
    $porta = '587';
    $nome = 'Cadastro | Digital Intelligentia';
    $assunto = 'DECLARAÇÃO DE RESCISÃO CONTRATUAL - DIGITAL INTELLIGENTIA';
    //$cct = $email;
    $cct = 'cadastro@digitalintelligentia.com';
    $cct2 = 'luisfelipe@intelligenttia.com';

    // Chama phpMailer
    require_once('PHPMailer/class.phpmailer.php');
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Host = $smtp;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = '';
    $mail->Port = $porta;
    $mail->Username = $logine;
    $mail->Password = $passwd;
    $mail->From = $logine;
    $mail->Sender = $logine;
    $mail->FromName = $nome;
    $mail->AddAddress($cct);
    $mail->AddAddress($cct2);
    $mail->IsHTML(true);
    $mail->CharSet = 'utf-8';
    $mail->Subject = $assunto;
    $mail->Body = utf8_decode($msg);
    $mail->AddAttachment($caminhoCompleto);
    $enviado = $mail->Send();
    $mail->ClearAllRecipients();
    $mail->ClearAttachments();

    unlink($caminhoCompleto);
    return;
}
