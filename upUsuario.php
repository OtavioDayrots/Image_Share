<?php 
session_start();
require_once __DIR__ ."/app/service/imagesUploadService.php";
require_once __DIR__ . "/app/model/UsuariosModel.php";

use App\Service\ImagesUploadService;
use App\Model\UsuariosModel;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nome']) && isset($_POST['email'])) {

        // faz upload da imagem de perfil se existir
        $imagemSalva = null;
        if (!empty($_FILES['foto']['tmp_name'])) {
            $uploadService = new ImagesUploadService($_FILES['foto']);
            $imagemSalva = $uploadService->upload();
        }

        $usuario = [
            'nome' => $_POST['nome'],
            'email' => $_POST['email'],
            'senha' => $_POST['senha'],
            'img_perfil_id' => $imagemSalva['id'] ?? null
        ];

        $usuarioModel = new UsuariosModel();
        $usuarioModel->salvar($usuario);
    }
}

?>

<?php require_once __DIR__ . '/componetes/head.php'; ?>  

<body>
    <div class="form-cadastro-container">
        <h1 class="form-cadastro-title">Cadastro de Usuário</h1>
        <form action="upUsuario.php" method="POST" enctype="multipart/form-data">
            <div class="form-cadastro-group">
                <label class="form-cadastro-label" for="nome">Nome:</label>
                <input class="form-cadastro-input" type="text" name="nome" required placeholder="Digite seu nome">
            </div>
            <div class="form-cadastro-group">
                <label class="form-cadastro-label" for="email">Email:</label>
                <input class="form-cadastro-input" type="text" name="email" required placeholder="Digite seu email">
            </div>
            <div class="form-cadastro-group">
                <label class="form-cadastro-label" for="senha">Senha:</label>
                <input class="form-cadastro-input" type="password" name="senha" required placeholder="Digite sua senha">
            </div>
            <div class="form-cadastro-group">
                <label for="foto">Foto</label>
                <input type="file" name="foto" id="upload" accept="image/*">
            </div>    
            <div class="upload-links">
                <button type="submit" class="btn">Cadastrar</button>
                <a href="index.php" class="upload-link secondary">Voltar para início</a>
            </div>
        </form>
    </div>
</body>
</html>