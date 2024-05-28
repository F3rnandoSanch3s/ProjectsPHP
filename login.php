<?php 
session_start();

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $senha = isset($_POST['senha']) ? trim($_POST['senha']) : '';

    // Basic validation
    if (empty($email) || empty($senha)) {
        $_SESSION['erros'] = ['E-mail e senha são obrigatórios.'];
    } else {
        // Define user data
        $usuarios = [
            [
                "nome" => "fernando",
                "email" => "seinao@gmail.com",
                "senha" => "1234567",
            ],
            [
                "nome" => "Sanches",
                "email" => "seinao2.0@gmail.com",
                "senha" => "7654321",
            ],
        ];

        // Validate user credentials
        $usuarioValido = false;
        foreach($usuarios as $usuario) {
            $emailValido = $email === $usuario['email'];
            $senhaValida = $senha === $usuario['senha']; // In production, compare hashed password.

            if($emailValido && $senhaValida) {
                $_SESSION['erros'] = null;
                $_SESSION['usuario'] = $usuario['nome'];
                $exp = time() + 60 * 60 * 24 * 30;
                setcookie('usuario', $usuario['nome'], $exp);
                header('Location: index.php');
                exit(); // Important to prevent further code execution
            }
        }

        // If no valid user found, set error
        if (!isset($_SESSION['usuario'])) {
            $_SESSION['erros'] = ['Usuário ou Senha inválido!'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css?family=Oswald:200,300,400,500,600,700" rel="stylesheet">
    <link rel="stylesheet" href="recursos/css/estilo.css">
    <link rel="stylesheet" href="recursos/css/login.css">
    <title>Projetos PHP</title>
</head>
<body class="login">
    <header class="cabecalho">
        <h1>Projetos PHP</h1>
        <h2>Seja Bem Vindo</h2>
    </header>
        <div class="conteudo">
            <h3>Identifique-se</h3>
            <?php if (isset($_SESSION['erros']) && $_SESSION['erros']): ?>
                <div class="erros">
                    <?php foreach ($_SESSION['erros'] as $erro): ?>
                        <p><?= htmlspecialchars($erro) ?></p>
                    <?php endforeach ?>
                </div>
            <?php endif ?>
            <form action="#" method="post">
                <div>
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" placeholder="email"required>
                </div>
                <div>
                    <label for="senha">Senha</label>
                    <input type="password" name="senha" id="senha" placeholder="senha"required>
                </div>
                <button type="submit">Entrar</button>
            </form>
        </div>
</body>
</html>