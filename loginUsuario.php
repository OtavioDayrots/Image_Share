<?php 
session_start();
require_once __DIR__ . "/app/model/UsuariosModel.php";

use App\Model\UsuariosModel;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email']) and isset($_POST['senha'])) {
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $usuarioModel = new UsuariosModel();

        try{
            $usuario = $usuarioModel->Login($email, $senha);
            
            if ($usuario) {
                $_SESSION['id'] = $usuario['id'];
                $_SESSION['nome'] = $usuario['nome'];
                $_SESSION['email'] = $usuario['email'];
                $_SESSION['img_perfil_caminho'] = $usuario['img_perfil_caminho'];

                header("Location: index.php");
                exit();
            } else {
                $erro = "Email ou senha incorretos";
            }
        }
        catch(Exception $e){ 
            $erro = "Erro ao fazer login: " . $e->getMessage();
        }
    }
}

?>

<?php require_once __DIR__ . '/componetes/head.php'; ?>  

<body>
    <div class="form-cadastro-container">
        <h1 class="form-cadastro-title">Bem Vindo!</h1>
        <?php if (isset($erro)): ?>
            <div class="error-message" style="color: red; margin-bottom: 15px; text-align: center;">
                <?php echo htmlspecialchars($erro); ?>
            </div>
        <?php endif; ?>
        <form action="loginUsuario.php" method="POST" enctype="multipart/form-data">
            <div class="form-cadastro-group">
                <label class="form-cadastro-label" for="email">Email:</label>
                <input class="form-cadastro-input" type="text" name="email" required placeholder="Digite seu email">
            </div>
            <div class="form-cadastro-group">
                <label class="form-cadastro-label" for="senha">Senha:</label>
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