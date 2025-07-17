<?php
session_start();

require_once __DIR__ . '/app/model/UsuariosModel.php';
require_once __DIR__ . '/app/model/GaleriaModel.php';

use App\Model\GaleriaModel;
use App\Model\UsuariosModel;

$UsuairosModel = new UsuariosModel();
$GaleriaModel = new GaleriaModel();

if (!isset($_GET['id'])) {
    return header('Location: index.php');
}

$id = $_GET['id'];
$usuario = $UsuairosModel->buscarPorId($id);
$fotos = $GaleriaModel->buscarPorUsuarioId($id) ?? [];

?>

<?php require_once __DIR__ . '/componetes/head.php'; ?>

<body>
    <section>
        <div class="usuario-header">
            <?php if (!empty($usuario['img_perfil_caminho'])): ?>
                <p>
                    <img src="<?= $usuario['img_perfil_caminho'] ?>" alt="foto de perfil">
                </p>
            <?php endif; ?>
            <p>
                Bem vindo a galeria de <strong><?= $usuario['nome'] ?></strong>,
                entre em contado pelo e-mail <span class="usuario-email"><?= $usuario['email'] ?></span>
            </p>
        </div>
        <div class="upload-links">
            <a href="index.php" class="upload-link secondary">Voltar para início</a>
        </div>
    </section>
    <main>
        <div class="container-fotos">
            <h1>Fotos</h1>
            <div class="fotos">
                <?php
                foreach ($fotos as $foto) {
                    echo "
                    <figure class='foto'>
                        <a href='{$foto['imagem_caminho']}' download>
                            <img src='{$foto['imagem_caminho']}' class='card-foto' alt='Foto'>
                        </a>
                        <figcaption>
                            {$foto['imagem_nome_original']}<br>
                            <a class='usuario-link' href='usuarioGaleria.php?id={$foto['usuario_id']}'>
                                Enviado por {$foto['usuario_nome']}<br>
                            </a>
                            <small>
                                 em: {$foto['imagem_data_envio']}
                            </small>

                        </figcaption>
                    </figure>
                    ";
                }
                ?>
            </div>
        </div>
    </main>
</body>

</html>