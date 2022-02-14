<?php
$dompdf->loadHtml('
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <style type="text/css">
            <!-- .style1 {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 25px;
        }
        
        .style3 {
            font-family: "Courier New", Courier, mono;
            font-size: 18px;
        }
        
        .style4 {
            color: #FF9900
        }
        
        .style5 {
            font-size: 28px
        }
        
        .style6 {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 28px;
            -->
    </style>
</head>

<body>
    <div align="center">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <!--DWLayoutTable-->
            <tr>
                <td width="100" valign="top">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <!--DWLayoutTable-->
                        <tr>
                            <td width="100%" valign="top">
                                <div align="center"><img src="MODELO_RECISOES/img_recisao/logo-digitalintelligentia.png" width="100%"></div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td valign="top" class="style2">
                    <blockquote>
                        <p>&nbsp;</p>
                        <blockquote>
                            <p class="style1 style5">&nbsp;</p>
                            <p class="style6">Prezado Agente,</p>
                        </blockquote>
                        <p align="justify" class="style6"> &Eacute; a presente para, mediante permiss&atilde;o legal do contrato ' . $atuacaoAgente . ' INTELLIGENTIA LEGALE assinado por vossa senhoria com esta empresa da qual eu sou Diretor Superintendente, formalizar por carta a rescis&atilde;o do
                            contrato referendado, por motivo de ' . $motivo . ' conforme j&aacute; &eacute; de conhecimento das partes.</p>
                        <p class="style6">Profissional ' . $atuacaoAgente2 . ':</p>
                        <p class="style6">' . $nome . '</p>
                        <p>&nbsp;</p>
                        <p class="style6">Cordialmente,</p>
                        <p class="style6">Curitiba, ' . $data . '</p>
                        <p class="style1"><img src="MODELO_RECISOES/img_recisao/assinatura-digitalintelligentia.png" width="40%"></p>
                    </blockquote>
                </td>
            </tr>
            <tr>
                <td valign="top">
                    <blockquote>
                        <p align="justify"><span class="style3"><strong><span class="style4"> &reg; Direitos Reservados no
                    INPI/Funda&ccedil;&atilde;o Biblioteca Nacional.</span>                              <strong>Registro na FBN-RJ, sob o n. 227.955 e sequenciais. Proibida a reprodu&ccedil;&atilde;o xerogr&aacute;fica e outra, total ou parcial, bem como o pl&aacute;gio, <em>ex vi </em> da Lei n. 9.610/98, exceto com permiss&atilde;o expressa e por escrito do titular da INTELLIGENTIA LEGALE e LANDHILL GOTTES DIENER. </strong><strong>A viola&ccedil;&atilde;o aos direitos autorais ensejar&aacute; puni&ccedil;&atilde;o &eacute;tico-profissional, civil e criminal (Artigo 184 do C&oacute;digo Penal. Direito autoral resguardado no valor de 7 (sete) milh&otilde;es de reais. </strong> </strong></span>
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
                                <div align="left"><img src="MODELO_RECISOES/img_recisao/rodape-digitalintelligentia.png" width="100%"></div>
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
$cct2 = 'luisfelipe@intelligenttia.com';