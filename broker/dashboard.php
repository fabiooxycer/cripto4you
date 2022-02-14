<?php
if (!isset($_SESSION)) session_start();

$nivel = 1;

if (!isset($_SESSION['UsuarioID']) or ($_SESSION['UsuarioNivel'] > $nivel)) {
    echo "<script>alert('VOCÊ NÃO POSSUI PERMISSÃO PARA EXIBIR ESTÁ TELA!');location.href='entrar';</script>";
    exit;
}

include('includes/header.php');
?>

<div class="container-fluid">
    <section>
        <div align="right">
            <p>Olá <strong>
                    <font><?php echo $_SESSION['UsuarioNome']; ?></font>
                </strong>. Seja bem-vindo(a)!</p>
        </div>
    </section>
    
</div>

<?php include('includes/footer.php'); ?>

<script>

</script>