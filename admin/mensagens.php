
<?php
$conn = mysqli_connect('localhost', 'root', 'password', 'pizza_dev');
// mysqli_set_charset($conn, 'utf-8');
if(mysqli_connect_errno()){
    die('Não foi possível se conectar com o banco de dados: ' . mysqli_connect_error());
}

$msg = array();

$sql_busca = "SELECT * FROM mensagens";

try 
{
    if ($_GET && isset($_GET['excluir'])){

        $id = filter_var($_GET['excluir'], FILTER_VALIDATE_INT);

        if($id === false){
            throw new Exception("ID inválido para exclusão");
        }

        $sql = "DELETE FROM mensagens WHERE mensagem_id = $id";
        $resultado = mysqli_query($conn, $sql);

        if ($resultado === false || mysqli_errno($conn)) {
            throw new Exception('Erro ao realizar a exclusão no banco de dados: ' . mysqli_error($conn));
        }

        $msg = array(
            'classe' => 'msg-sucesso',
            'mensagem' => 'Mensagem excluída com sucesso!'
        );
    }
    
}
catch(Exception $ex)
{
    $msg = array(
        'classe' => 'msg-erro',
        'mensagem' => $ex->getMessage()
    );
}
finally {
    $resultado = mysqli_query($conn, $sql_busca);
    if ($resultado) {
        $lista_mensagens = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensagens | Administração | Pizza DEV</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <link rel="stylesheet" href="../assets/css/admin.css" />
    <script src="../assets/js/admin.js" defer></script>
</head>
<body>
    <header class="topo flex container-padding">
        <img src="../assets/images/pizza-dev.png" alt="Pizza DEV" />
        <nav class="menu">
            <a href="index.php">Pizzas</a>
            <a href="mensagens.php" class="active">Mensagens</a>
            <a href="usuarios.php">Usuários</a>
            <a href="login.php">Sair</a>
        </nav>
    </header>
    <div class="pagina container">
        <div class="cabecalho flex">
            <br />
        </div>
        <div class="tabela-responsiva">
            <table>
                <thead>
                    <tr>
                        <th>Nome completo</th>
                        <th>E-mail</th>
                        <th>Assunto</th>
                        <th>Mensagem</th>
                        <th width="95"></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($lista_mensagens as $mensagem) : ?>
                    <tr>
                        <td>
                            <?= $mensagem['nome_completo'] ?>
                        </td>
                        <td>
                            <?= $mensagem['email'] ?>
                        </td>
                        <td>
                            <?= $mensagem['assunto'] ?>
                        </td>
                        <td>
                            <?= $mensagem['mensagem'] ?>
                        </td>
                        <td>
                            <a href="mensagens.php?excluir=<?= $mensagem['mensagem_id'] ?>" class="btn-excluir">
                                <i class="fa-regular fa-trash-can"></i> Excluir
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>