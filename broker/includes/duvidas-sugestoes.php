<?php

header('Content-type: text/html; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', 1);
$nome     = isset($_POST['nome']) ? $_POST['nome'] : '';
$assunto  = isset($_POST['assunto']) ? $_POST['assunto'] : '';
$mensagem = isset($_POST['mensagem']) ? $_POST['mensagem'] : '';
if (empty($nome) || empty($assunto) || empty($mensagem)) {
    echo "<script>alert('OPS! Não foi possível enviar sua dúvida ou sugestão.');location.href='dashboard';</script>";
    exit;
} else {
    $apiToken = "5155649072:AAF466dIaOiGvEb9qCGavLXNHVXE06ZRPwo";
    $data2 = [
        "chat_id" => "-1001709220235", // ID Canal Contato Site
        'parse_mode' => 'HTML',
        'text' => "\n<b>CONTATO PELO BROKER</b> \n\nNome: $nome\nAssunto: $assunto\nMensagem: $mensagem\n",
    ];

    $response = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" . http_build_query($data2));
    echo "<script>alert('Obrigado! Sua dúvida ou sugestão foi enviada com sucesso.');location.href='dashboard';</script>";
}
