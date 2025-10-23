<?php
session_start();
require_once __DIR__ . '/app/model/GaleriaModel.php';
require_once __DIR__ . '/app/service/imagesUploadService.php';

use App\Service\ImagesUploadService;
use App\Model\GaleriaModel;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['foto']) && isset($_POST['usuarioId'])) {
        $imagem = $_FILES['foto'];
        $usuarioId = $_POST['usuarioId'];

        try {
            $uploadService = new ImagesUploadService($imagem);
            $resultado = $uploadService->upload();

            $salvou = $resultado['salvou'];
            $caminhoDaImagem = $resultado['caminho'];

            $galeriaModel = new GaleriaModel();
            $galeriaModel->salvar($resultado['id'], $usuarioId);

        } catch (\Exception $e) {
            $salvou = false;
            $erro = $e->getMessage();
        }
    }
}

?>

<?php require_once __DIR__ . '/componetes/head.php'; ?>

<body>
    <div class="upload-container">
        <?php if (isset($salvou) && $salvou): ?>
            <div class="upload-message upload-success">
                <h2>Upload Concluído!</h2>
                <p>Arquivo enviado com sucesso.</p>
                <?php if (file_exists($caminhoDaImagem)): ?>
                    <img src="<?= $caminhoDaImagem ?>" alt="Imagem enviada" class="upload-preview">
                <?php endif; ?>
            </div>
            <div class="upload-links">
                <a href="<?= $caminhoDaImagem ?>" class="upload-link" target="_blank">Ver imagem</a>
                <a href="index.php" class="upload-link secondary">Voltar para início</a>
            </div>
        <?php else: ?>
            <div class="upload-message upload-error">
                <h2>Erro no Upload</h2>
                <p><?= isset($erro) ? $erro : 'Não foi possível enviar o arquivo. Por favor, tente novamente.' ?></p>
            </div>
            <div class="upload-links">
                <a href="index.php" class="upload-link secondary">Voltar para início</a>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>