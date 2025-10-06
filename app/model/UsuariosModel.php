<?php

namespace App\Model;

require_once __DIR__ . "/BaseModel.php";

class UsuariosModel extends BaseModel {
    public function __construct() {
        $this->tabelaname = 'usuarios';
        parent::__construct();
    }

    /**
     * sumary of criar
     * @param array $usuario
     *   ['nome', 'email', 'img_perfil_id']
     * @return void
     */

    public function salvar($usuario) {
        $query = "INSERT INTO $this->tabelaname (nome, email, img_perfil_id)
            Values (:nome, :email, :img_perfil_id)";

            $stmt = $this->pdo->prepare($query);

            $stmt->execute([
                ':nome' => $usuario['nome'],
                ':email' => $usuario['email'],
                ':img_perfil_id' => $usuario['img_perfil_id']
            ]);
    }

   /**
     * Summary of buscarPorId
     * @param array $usuario
     *      ['email', 'senha]
     * @return array
     *      [ 'id', 'nome', 'email',  img_perfil_caminho' ] 
     */
    public function buscarPorId($id): array {
        $query = "
            select
            u.*,
            i.caminho as img_perfil_caminho
            from usuarios u
            left join imagens i on i.id = u.img_perfil_id
            WHERE u.id = :id
        ";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch();
    }
       /**
     * Summary of login
     * @return array
     *      [ 'id', 'nome', 'email',  img_perfil_caminho' ] 
     */
    public function login($email, $senha): array {
        $query = "
            Select
            U.*,
            i.caminho as imagem_perfil_caminho
            from usuarios u
            left join imagens i on i.id = u.img_perfil_id
            WHERE u.mail = :email and u.senha = :senha
        ";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            ':email' => $email,
            ':senha' => $senha
        ]);

        return $stmt->fetch();
    }

}