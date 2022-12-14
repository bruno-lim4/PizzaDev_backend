<?php
$conn = mysqli_connect('localhost', 'root', 'password', 'pizza_dev');
// mysqli_set_charset($conn, 'utf-8');
if(mysqli_connect_errno()){
    die('Não foi possível se conectar com o banco de dados: ' . mysqli_connect_error());
}

$msg = array();

$sql_busca = "SELECT * FROM pizzas";

try 
{
    // Verifica se tem dados via GET e existi o dado excluir
    if ($_GET && isset($_GET['excluir'])){

        // Se usar apenas o $id = $_GET['excluir']; ocasiona falha de SQL Injection
        $id = filter_var($_GET['excluir'], FILTER_VALIDATE_INT);

        if($id === false){
            throw new Exception("ID inválido para exclusão");
        }

        // Exemplo de SQL Injection - $sql = "DELETE FROM clientes WHERE cliente_id = 2 OR 1 = 1";
        // Exemplo de SQL Injection - $sql = "DELETE FROM clientes WHERE cliente_id = 2; DROP TABLE clientes; se for um usuário com permissão de root";
        $sql = "DELETE FROM pizzas WHERE pizza_id = $id";
        $resultado = mysqli_query($conn, $sql);

        if ($resultado === false || mysqli_errno($conn)) {
            throw new Exception('Erro ao realizar a exclusão no banco de dados: ' . mysqli_error($conn));
        }

         // operação de exclusão na base
         $msg = array(
            'classe' => 'msg-sucesso',
            'mensagem' => 'Pizza excluída com sucesso!'
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
        $lista_pizzas = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nossas Pizzas | Administração | Pizza DEV</title>
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
            <a href="index.html" class="active">Pizzas</a>
            <a href="mensagens.html">Mensagens</a>
            <a href="usuarios.html">Usuários</a>
            <a href="login.html">Sair</a>
        </nav>
    </header>
    <div class="pagina container">
        <div class="cabecalho flex">
            <a href="cadastrar-pizza.php" class="botao">
                Nova Pizza
            </a>
        </div>

        <?php if ($msg) : ?>
            <div class="<?= $msg['classe'] ?>">
                <?= $msg['mensagem']; ?>
            </div>
        <?php endif; ?>

        <div class="tabela-responsiva">
            <table>
                <thead>
                    <tr>
                        <th width="85">Foto</th>
                        <th>Pizza</th>
                        <th width="130">Brotinho</th>
                        <th width="130">Média</th>
                        <th width="130">Grande</th>
                        <th width="195" colspan="2"></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($lista_pizzas as $pizza) : ?>
                    <tr>
                        <td>
                            <img src="<?= $pizza['foto'] ?>" alt="" />
                        </td>
                        <td>
                            <h3><?= $pizza['nome'] ?></h3>
                            <p><?= $pizza['ingredientes'] ?></p>
                        </td>
                        <td>
                            <?= $pizza['brotinho'] ?>
                        </td>
                        <td>
                            <?= $pizza['media'] ?>
                        </td>
                        <td>
                            <?= $pizza['grande'] ?>
                        </td>
                        <td>
                            <a href="editar-pizza.php?id=<?= $pizza['pizza_id'] ?>" class="btn-editar">
                                <i class="fa-solid fa-pen-to-square"></i> Editar
                            </a>
                        </td>
                        <td>
                            <a href="index.php?excluir=<?= $pizza['pizza_id'] ?>" class="btn-excluir">
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