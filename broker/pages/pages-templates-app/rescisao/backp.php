


//var_dump($empresa);
die();
ob_start();

require('vendor/autoload.php');

// referenciando o namespace do dompdf
use Dompdf\Dompdf;

// instanciando o dompdf
//$dompdf = new Dompdf();
$dompdf = new Dompdf();
$dompdf->set_option('isRemoteEnabled', TRUE);

// TEMPLATE DIGITAL INTELLIGENTIA
if ($cadastro['empresa'] == '3') {
    //lendo o arquivo HTML correspondente
    //$html = file_get_contents('template_rescisao_bancos.php');
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
                        <p align="justify" class="style6"> &Eacute; a presente para, mediante permiss&atilde;o legal do contrato ' . $atuacaoAgente . ' INTELLIGENTIA LEGALE assinado por vossa senhoria com esta empresa da qual eu sou Diretor Operacional, formalizar por carta a rescis&atilde;o do
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
                        <p align="justify"><span class="style3"><strong><span class="style4"> &reg; Direitos Reservados no
                    INPI/Funda&ccedil;&atilde;o Biblioteca Nacional.</span> Registro na FBN-RJ, sob o n. 227.955 e sequenciais. Proibida a reprodu&ccedil;&atilde;o xerogr&aacute;fica e outra, total ou parcial, bem como o pl&aacute;gio, <em>ex vi </em>                            da Lei n. 9.610/98, exceto com permiss&atilde;o expressa e por escrito do titular da CALCULISTTER, CALCMAGISTTER e CONNSIER. </strong><strong>A
                    viola&ccedil;&atilde;o aos direitos autorais ensejar&aacute; puni&ccedil;&atilde;o
                    &eacute;tico-profissional, civil e criminal (Artigo 184 do C&oacute;digo Penal. Direito autoral
                    resguardado no valor de 700 (setecentos) mil de reais. </strong></span>
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
    file_put_contents('rescisoes_geradas/recisao-digitalintelligentia-' . $nome . '-' . date('Ymd') . '.pdf', $dompdf->output());

    $dompdf->stream('recisao-digitalintelligentia-' . $nome . '-' . date('Ymd') . '.pdf');

    // Envia o PDF por e-mail
    $msg = '
TESTE DE EMAIL
';

    $caminhoCompleto = 'rescisoes_geradas/recisao-digitalintelligentia-' . $nome . '-' . date('Ymd') . '.pdf';

    $logine = 'cadastro@digitalintelligentia.com';
    $passwd = 'zxcvbnm@2021';
    $aut = 'TRUE';
    $retorn = 'cadastro@digitalintelligentia.com';
    $porta = '587';
    $nome = 'Cadastro | Digital Intelligentia';
    $assunto = 'RESCISÃO CONTRATUAL - DIGITAL INTELLIGENTIA';
    $cct = $email;
    //$cct2 = '';

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
    $mail->AddAddress($cct, $ass);
    //$mail->AddBCC($cct2, $ass);
    $mail->IsHTML(true);
    $mail->CharSet = 'utf-8';
    $mail->Subject = $assunto;
    $mail->Body = utf8_decode($msg);
    $mail->AddAttachment($caminhoCompleto);
    $enviado = $mail->Send();
    $mail->ClearAllRecipients();
    $mail->ClearAttachments();

    unlink($caminhoCompleto);
}

// TEMPLATE DIGITAL ALLOCATE
if ($cadastro['empresa'] == '4') {
    //lendo o arquivo HTML correspondente
    //$html = file_get_contents('template_rescisao_bancos.php');
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
                                    <p align="justify" class="style8"> &Eacute; a presente para, mediante permiss&atilde;o legal do contrato de ' . $atuacaoAgente . ' DIGITALALLOCATE assinado por vossa senhoria com esta empresa da qual eu sou Diretor Operacional, formalizar por carta a rescis&atilde;o
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
                                        <strong>Direitos Reservados no INPI/Funda&ccedil;&atilde;o Biblioteca Nacional.
                        </strong></span><strong>Registro na FBN-RJ, sob o n. 227.955 e sequenciais. Proibida a
                        reprodu&ccedil;&atilde;o xerogr&aacute;fica e outra, total ou parcial, bem como o pl&aacute;gio,
                        <em>ex vi </em> da Lei n. 9.610/98, exceto com permiss&atilde;o expressa e por escrito do
                        titular da RURALFLUUX, ADVOCATOOLS, ALLOCATOOLS, PERSSONALLE, RURALPERSSONALLE, FAACILE e
                        AGROFAACILE. A viola&ccedil;&atilde;o aos direitos autorais ensejar&aacute;
                        puni&ccedil;&atilde;o &eacute;tico-profissional, civil e criminal (Artigo 184 do C&oacute;digo
                        Penal). Direito autoral resguardado no valor de 700 (setecentos) mil de reais. </strong>
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
    file_put_contents('rescisoes_geradas/recisao-digitalallocate-' . $nome . '-' . date('Ymd') . '.pdf', $dompdf->output());

    $dompdf->stream('recisao-digitalallocate-' . $nome . '-' . date('Ymd') . '.pdf');

    // Envia o PDF por e-mail
    $msg = '
TESTE DE EMAIL
';

    $caminhoCompleto = 'rescisoes_geradas/recisao-digitalallocate-' . $nome . '-' . date('Ymd') . '.pdf';

    $logine = 'cadastro@digitalintelligentia.com';
    $passwd = 'zxcvbnm@2021';
    $aut = 'TRUE';
    $retorn = 'cadastro@digitalintelligentia.com';
    $porta = '587';
    $nome = 'Cadastro | Digital Intelligentia';
    $assunto = 'RESCISÃO CONTRATUAL - DIGITAL ALLOCATE';
    $cct = $email;
    //$cct2 = '';

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
    $mail->AddAddress($cct, $ass);
    //$mail->AddBCC($cct2, $ass);
    $mail->IsHTML(true);
    $mail->CharSet = 'utf-8';
    $mail->Subject = $assunto;
    $mail->Body = utf8_decode($msg);
    $mail->AddAttachment($caminhoCompleto);
    $enviado = $mail->Send();
    $mail->ClearAllRecipients();
    $mail->ClearAttachments();

    unlink($caminhoCompleto);
}

// TEMPLATE BANCOS
if ($cadastro['empresa'] == '6' || $cadastro['empresa'] == '7' || $cadastro['empresa'] == '8') {
    //lendo o arquivo HTML correspondente
    //$html = file_get_contents('template_rescisao_bancos.php');
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
                                    <p align="justify" class="style7"> &Eacute; a presente para, mediante permiss&atilde;o legal do contrato de CFFE assinado por vossa senhoria com esta empresa da qual eu sou Diretor Operacional, formalizar por carta a rescis&atilde;o do contrato referendado,
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
                                    <p align="justify"><span class="style3"> <strong><span class="style4"><strong>&reg; </strong>Direitos
                                                    Reservados no INPI/Funda&ccedil;&atilde;o Biblioteca Nacional.</span> Registro na FBN-RJ, sob o n. 227.955 e sequenciais. Proibida a reprodu&ccedil;&atilde;o xerogr&aacute;fica e outra, total ou parcial, bem como o pl&aacute;gio,
                                                <em>ex vi </em> da Lei n. 9.610/98, exceto com permiss&atilde;o expressa e por escrito do titular da INTELLIGENZ, e LAVVOR. </strong><strong>A
                                                viola&ccedil;&atilde;o aos direitos autorais ensejar&aacute; puni&ccedil;&atilde;o
                                                &eacute;tico-profissional, civil e criminal (Artigo 184 do C&oacute;digo Penal).Direito autoral
                                                resguardado no valor de 700 (setecentos) mil de reais. </strong> </span>
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
    file_put_contents('rescisoes_geradas/recisao-bancos-' . $nome . '-' . date('Ymd') . '.pdf', $dompdf->output());

    $dompdf->stream('recisao-bancos-' . $nome . '-' . date('Ymd') . '.pdf');

    // Envia o PDF por e-mail
    $msg = '
TESTE DE EMAIL
';

    $caminhoCompleto = 'rescisoes_geradas/recisao-bancos-' . $nome . '-' . date('Ymd') . '.pdf';

    $smtp = '200.195.183.75';
    $logine = 'cadastro@digitalintelligentia.com';
    $passwd = 'zxcvbnm@2021';
    $aut = 'TRUE';
    $retorn = 'cadastro@digitalintelligentia.com';
    $porta = '587';
    $nome = 'Cadastro | Digital Intelligentia';
    $assunto = 'RESCISÃO CONTRATUAL - BANCO LAVVOR, INTELLIGENZ & CONSTELLATER';
    $cct = $email;
    //$cct2 = '';

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
    $mail->AddAddress($cct, $ass);
    //$mail->AddBCC($cct2, $ass);
    $mail->IsHTML(true);
    $mail->CharSet = 'utf-8';
    $mail->Subject = $assunto;
    $mail->Body = utf8_decode($msg);
    $mail->AddAttachment($caminhoCompleto);
    $enviado = $mail->Send();
    $mail->ClearAllRecipients();
    $mail->ClearAttachments();

    unlink($caminhoCompleto);
}
