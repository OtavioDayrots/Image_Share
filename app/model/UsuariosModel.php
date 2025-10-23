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
     *   ['nome', 'email', 'img_perfil_id', 'senha']
     * @return void
     */

    public function salvar($usuario) {
        $query = "INSERT INTO $this->tabelaname (nome, email, img_perfil_id, senha)
            Values (:nome, :email, :img_perfil_id, :senha)";

            $stmt = $this->pdo->prepare($query);

            $stmt->execute([
                ':nome' => $usuario['nome'],
                ':email' => $usuario['email'],
                ':img_perfil_id' => $usuario['img_perfil_id'],
                ':senha' => password_hash($usuario['senha'], PASSWORD_DEFAULT)
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
    public function login($email, $senha): array|false {
        $query = "
            Select
            u.*,
            i.caminho as img_perfil_caminho
            from usuarios u
            left join imagens i on i.id = u.img_perfil_id
            WHERE u.email = :email
        ";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            ':email' => $email
        ]);

        $usuario = $stmt->fetch();
        
        // Verifica se o usuário existe e se a senha está correta
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            // Remove a senha do array antes de retornar (por segurança)
            unset($usuario['senha']);
            return $usuario;
        }
        
        return false;
    }

}