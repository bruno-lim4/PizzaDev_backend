<?php 
$conn = mysqli_connect('localhost', 'root', 'password', 'pizza_dev');
// mysqli_set_charset($conn, 'utf-8');
if (mysqli_connect_errno()) {
    die('Não foi possível se conectar com o banco de dados: ' . mysqli_connect_error());
}

$msg = array();

try {
    if ($_POST) {
        $nomeCompleto = filter_var($_POST['nomeCompleto'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES) ?: throw new Exception('Por favor, preencha o campo Nome Completo!');
        $usuario = filter_var($_POST['usuario'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES) ?: throw new Exception('Por favor, preencha o campo Usuário!');
        $senha = filter_var($_POST['senha'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES) ?: throw new Exception('Por favor, preencha o campo Senha!');
        $confirmacaoSenha= filter_var($_POST['confirmacaoSenha'], FILTER_SANITIZE_NUMBER_FLOAT) ?: throw new Exception('Por favor, preencha o campo Confirmar Senha!');
        
        $nomeCompleto = mysqli_real_escape_string($conn, $nomeCompleto);
        $usuario = mysqli_real_escape_string($conn, $usuario);
        $senha = mysqli_real_escape_string($conn, $senha);
        $confirmacaoSenha = mysqli_real_escape_string($conn, $confirmacaoSenha);

        $sql = "INSERT INTO usuarios (nome_completo, username, senha) VALUES('$nomeCompleto', '$usuario', '$senha')";

        $resultado = mysqli_query($conn, $sql);

        if ($senha != $confirmacaoSenha) {
            throw new Exception('As senhas não coincidem');
        }

        if ($resultado === false || mysqli_errno($conn)) {
            throw new Exception('Erro ao realizar operação no banco de dados: ' . mysqli_error($conn));
        }

        $msg = array(
            'classe' => 'msg-sucesso',
            'mensagem' => 'Usuário cadastrado com sucesso!'
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

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário | Administração | Pizza DEV</title>
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
            <a href="mensagens.php">Mensagens</a>
            <a href="usuarios.php" class="active">Usuários</a>
            <a href="login.php">Sair</a>
        </nav>
    </header>
    <div class="pagina container">
        <div class="cabecalho flex bordered">
            <h1>Cadastrar Usuário</h1>
            <a href="usuarios.php" class="botao">
                Voltar
            </a>
        </div>

        <?php if ($msg) : ?>
            <div class="<?= $msg['classe'] ?>">
                <?= $msg['mensagem']; ?>
            </div>
        <?php endif; ?>

        <form action="" method="post">
            <input type="text" name="nomeCompleto" id="nomeCompleto" class="input-field" placeholder="* Nome completo" />
            <input type="text" name="usuario" id="usuario" class="input-field" placeholder="* Usuário" />
            <input type="password" name="senha" id="senha" class="input-field" placeholder="* Senha" />
            <input type="password" name="confirmacaoSenha" id="confirmacaoSenha" class="input-field" placeholder="* Confirmar senha" />
            <button type="submit" class="botao">
                Cadastrar
            </button>
        </form>
    </div>
</body>
</html>