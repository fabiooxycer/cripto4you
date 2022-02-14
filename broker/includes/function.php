<?php
include_once("conexao.php");

function retorna($nome_requerente, $conn){
	$result_nome = "SELECT * FROM tbl_cadastros WHERE nome LIKE '%".$nome_requerente."%' ORDER BY nome ASC LIMIT 7";
	$resultado_nome = mysqli_query($conn, $result_nome);
	if($resultado_nome->num_rows){
		$row_nome = mysqli_fetch_assoc($resultado_nome);
		$valores['id'] = $row_nome['id'];
		//$valores['rg'] = $row_aluno['rg'];
	}else{
		$valores['id'] = 'ID não encontrado';
	}
	return json_encode($valores);
}

if(isset($_GET['nome_requerente'])){
	echo retorna($_GET['nome_requerente'], $conn);
}
?>