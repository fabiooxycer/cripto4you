<?php
include('database.php');
$data_saques = date('y-m-d');
$pdo = BancoCadastros::conectar();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'SELECT count(*) as t FROM tbl_usuarios WHERE dt_saque = "' . $data_saques . '" AND status = 1 ';
$sql = $pdo->query($sql);
$sql = $sql->fetch();
$total_saques = $sql['t'];

if ($total_saques > 0) {

    // ENVIA TELEGRAM    
    $apiToken = "5155649072:AAF466dIaOiGvEb9qCGavLXNHVXE06ZRPwo";
    $data2 = [
        "chat_id" => "-1001322495863",
        'parse_mode' => 'HTML',
        'text' => "\n<b>ATENÇÃO</b> \n\nExistem $total_saques pendentes no sistema para o dia de hoje.\n",
    ];

    $response = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" . http_build_query($data2));
}
