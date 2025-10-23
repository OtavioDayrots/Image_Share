<?php 
session_start();
require_once __DIR__ ."/app/model/GaleriaModel.php";

use App\Model\GaleriaModel;

$usuarioId = null;
if (isset($_SESSION['id'])){
    $usuarioId = $_SESSION['id'];
}

?>

<?php require_once __DIR__ . '/componetes/head.php'; ?>  

<body>
    <header>
        <nav>
            <?php if(!$usuarioId): ?>
                <a href="upUsuario.php">Cadastro</a>
                <a href="loginUsuario.php">Login</a>
            <?php else: ?>
                <a href="logoff.php"><span class="material-symbols-outlined">logout</span></a>
            <?php endif;?>
        </nav> 
    </header>
    <main>
        <div class="container-upload">
            <h1>Upload de Fotos</h1>
            <?php if($usuarioId): ?>
                <form action="upload.php" method="POST" enctype="multipart/form-data">
                    <div>
                        <input type="number" name="usuarioId" value="<?= $usuarioId?>" hidden>
                        <label for="foto">Foto</label>
                        <input type="file" name="foto" id="upload" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn">Enviar</button>
                </form> 
            <?php endif;?>
        </div>
        <div class="container-fotos">
            <h1>Fotos</h1>
            <div class="fotos">
                <?php
                $GaleriaModel = new GaleriaModel();
                $fotos = $GaleriaModel->buscarTodas() ?? [];
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
