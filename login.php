<?php
session_start();

require_once __DIR__ . "/app/model/UsuariosModel.php";

use App\Model\UsuariosModel;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!empty($_POST['email']) && !empty($_POST['senha'])) {
        $email = $_POST["email"];
        $senha = $_POST["senha"];

        $usuarioModel = new UsuariosModel();
        $usuarioValido = $usuariosModel->validaLogin($email, $senha);

        if ($usuarioValido) {
            $_SESSION['id'] = $usuarioValido['id'];
            $_SESSION['nome'] = $usuarioValido['nome'];
            $_SESSION['email'] = $usuarioValido['email'];
            $_SESSION['imagem_perfil_caminho'] = $usuarioValido['imagem_perfil_caminho'];

            return header('Location: index.php');
        }
    }
}

?>

<?php require_once __DIR__ . '/componetes/head.php'; ?>  

<body>
    <div class="form-cadastro-container">
        <h1 class="form-cadastro-title">Login de Usuário</h1>
        <form action="login.php" method="POST">

            <div class="form-cadastro-group">
                <label class="form-cadastro-label" for="email">Email</label>
                <input class="form-cadastro-input" type="text" name="email" required placeholder="Digite seu email">
            </div>
            <div class="form-cadastro-group">
                <label class="form-cadastro-label" for="senha">Senha</label>
                <input class="form-cadastro-input" type="password" name="senha" required placeholder="Digite sua senha">
            </div>

            <div class="upload-links">
                <button type="submit" class="btn">Login</button>
                <a href="index.php" class="upload-link secondary">Voltar para início</a>
            </div>
        </form>
    </div>
</body>
</html>