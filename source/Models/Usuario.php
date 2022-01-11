<?php

namespace Source\Models;

use Labex\BasicPdo\Dao;
use Labex\BasicPdo\Functions;

class Usuario extends Dao implements Functions {
    // constantes
    const ENTIDADE = 'usuario';

    const ID = self::ENTIDADE . '_id';
    const NOME = self::ENTIDADE . '_nome';
    const SOBRENOME = self::ENTIDADE . '_sobrenome';
    const TIPO = self::ENTIDADE . '_tipo';
    const FACULDADE = 'faculdade';
    const EMAIL = 'email';
    const SENHA = 'senha';
    const NIVEL = 'escolaridade';
    const PROFISSAO = 'profissao';
    const DATA_CRIACAO = 'data_criacao';
    const SQL_WHERE_EMAIL = 'where email = :email';
    const SQL_VERIFY_EMAIL = 'select * from usuario where email = :email';
    const SQL_LOGIN_CLIENT_GOOGLE = 'select * from usuario where ' . self::ID . ' = :' . self::ID;
    const LOGIN_USER = "where "  . self::EMAIL . " = :email AND " . self::SENHA . " = :senha";

    const USUARIO_A_K_N_N = array(Usuario::NOME, Usuario::EMAIL, Usuario::SENHA);

    // atributos 
    private $usuario_id;
    private $usuario_nome;
    private $usuario_sobrenome;
    private $usuario_tipo;
    private $faculdade;
    private $email;
    private $senha;
    private $escolaridade;
    private $profissao;
    private $data_criacao;

    // getters and setters
    public function getUsuario_id() {
        return $this->usuario_id;
    }

    public function setUsuario_id($usuario_id) {
        $this->usuario_id = $usuario_id;
    }

    public function getUsuario_nome() {
        return $this->usuario_nome;
    }

    public function setUsuario_nome($usuario_nome) {
        $this->usuario_nome = $usuario_nome;
    }

    public function getUsuario_sobrenome() {
        return $this->usuario_sobrenome;
    }

    public function setUsuario_sobrenome($usuario_sobrenome) {
        $this->usuario_sobrenome = $usuario_sobrenome;
    }

    public function getUsuario_tipo() {
        return $this->usuario_tipo;
    }

    public function setUsuario_tipo($usuario_tipo) {
        $this->usuario_tipo = $usuario_tipo;
    }

    public function getFaculdade() {
        return $this->faculdade;
    }

    public function setFaculdade($faculdade) {
        $this->faculdade = $faculdade;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
    }

    public function getEscolaridade() {
        return $this->escolaridade;
    }

    public function setEscolaridade($escolaridade) {
        $this->escolaridade = $escolaridade;
    }

    public function getProfissao() {
        return $this->profissao;
    }

    public function setProfissao($profissao) {
        $this->profissao = $profissao;
    }

    public function getData_criacao() {
        return $this->data_criacao;
    }

    public function setData_criacao($data_criacao) {
        $this->data_criacao = $data_criacao;
    }

    // functions of class
    public function transform_array_to_object(array $data) {
        $obj = new Usuario();
        isset($data[self::ID]) ? $obj->setUsuario_id($data[self::ID]) : null;
        isset($data[self::NOME]) ? $obj->setUsuario_nome($data[self::NOME]) : null;
        isset($data[self::SOBRENOME]) ? $obj->setUsuario_sobrenome($data[self::SOBRENOME]) : null;
        isset($data[self::TIPO]) ? $obj->setUsuario_tipo($data[self::TIPO]) : null;
        isset($data[self::FACULDADE]) ? $obj->setFaculdade($data[self::FACULDADE]) : null;
        isset($data[self::EMAIL]) ? $obj->setEmail($data[self::EMAIL]) : null;
        isset($data[self::SENHA]) ? $obj->setSenha($data[self::SENHA]) : null;
        isset($data[self::NIVEL]) ? $obj->setEscolaridade($data[self::NIVEL]) : null;
        isset($data[self::PROFISSAO]) ? $obj->setProfissao($data[self::PROFISSAO]) : null;
        isset($data[self::DATA_CRIACAO]) ? $obj->setData_criacao($data[self::DATA_CRIACAO]) : null;
        // retorna null para o a atributo result
        $obj->setResult();
        return $obj;
    }

    /**
     * @lacy_
     * Verifica se um email já foi registrado na base de dados
     * 
     * $email -> array('usuario_email' => value)
     * $flag -> SE == 1 ENTÃO retorna dados da tabela SE NÃO retorna tag_success || tag_error
     */
    public function verify_email(array $email, $flag = null) {
        $usuario = new Usuario();
        $usuario->custom_query(Usuario::SQL_VERIFY_EMAIL, $email);
        if($flag == 1){
            return $usuario->getResult()[0];
            exit;
        }
        $db_result = $this->database_result($usuario);
        return $db_result;
    }

    /**
     * @lacy_
     * Cria registro de usuário
     * 
     * $data -> recebe os campos do formulário
     */
    public function create_new_account_of_user(array $data) {

        $result = $this->check_fields(self::USUARIO_A_K_N_N, $data);
        if (count($result) == 0){
            $data[self::EMAIL] = strtolower($data[self::EMAIL]);

            $usuario = new Usuario();
            $data[Usuario::SENHA] = md5($data[Usuario::SENHA]);
            $obj = $usuario->transform_array_to_object($data);
            $usuario->create(Usuario::ENTIDADE, $obj);
            $db_result = $this->database_result($usuario);

            if ($db_result == TAG_SUCCESS) {
                $data[Usuario::ID] = $usuario->getResult()[0];
                $result = $data;
            }else {
                $result = TAG_ERROR;
            }

            return $result;
        } else{
            $fields = $this->return_fields($result);
            return  TAG_MESSAGE . "&" . $fields;
        }
    }

    /** 
     * @lacy_
     * Gera chave de acesso para recuperação de login
     * 
     * $email -> string ('xxxxxxx@email.com')
     * return usuario_nome|email_usuario|md5(usuario_id + senha)
     */
    public function make_access_key_to_recover_login($email) {
        if (!empty($email)) {
            $usuario = new Usuario();
            $usuario->custom_query_on_table(Usuario::ENTIDADE, Usuario::SQL_WHERE_EMAIL, array(Usuario::EMAIL => $email));
            if ($usuario->getResult()) {
                return $usuario->getResult()[0][Usuario::NOME] . "|" . $usuario->getResult()[0][Usuario::EMAIL] . "|" . 
                md5($usuario->getResult()[0][Usuario::ID] . $usuario->getResult()[0][Usuario::SENHA]);
            } else {
                return TAG_ERROR;
            }
        }else{
            return TAG_ERROR;
        }
    }

    /**
     * @lacy_
     * Atualiza o registro do usuário quando solicitado uma recuperação de senha
     */
    public function reset_user_password(array $data) {
        extract($data);
        if (!empty($email) && !empty($senha) && !empty($conf_senha) && !empty($key)) {
            if ($senha == $conf_senha) {
                $result = $this->validate_access_key($email, $key);
                $data = array(Usuario::EMAIL=> $email, Usuario::SENHA => $senha);
                if ($result) {
                    $usuario = new Usuario();
                    $user_update = $usuario->transform_array_to_object($result);
                    $user_update->setSenha(md5($senha));
                    $usuario->update(Usuario::ENTIDADE, $user_update);
                    $db_result = $this->database_result($usuario);
                    if($db_result == "success"){
                        $db_result = $usuario->login_user($data);
                        return $db_result;
                    } else{
                        return $db_result;
                    }
                } else {
                    return TAG_MESSAGE . "1";
                }
            } else {
                return TAG_MESSAGE . "2";
            }
        }
    }

    /**
     * @lacy_
     * Verifica se chave de acesso do usuário é válida e retorna o array com as informações do usuário
     */
    private function validate_access_key($email, $key) {
        $usuario = new Usuario();
        $usuario->custom_query_on_table(Usuario::ENTIDADE, Usuario::SQL_WHERE_EMAIL, array(Usuario::EMAIL => $email));
        if ($usuario->getResult()) {
            $access_key = md5($usuario->getResult()[0][Usuario::ID] . $usuario->getResult()[0][Usuario::SENHA]);
            if ($access_key == $key) {
                return $usuario->getResult()[0];
            } else {
                return FALSE;
            }
        }
    }

    /**
    * @lacy_
    * Cria registro de usuário com informações do google
    * usuario_tipo: A (Administrador), P (Professor), E (Estudante)
    *
    * input: google data
    * output: boolean TAG_ERROR || getResult list_id_insert
    */
    public function create_new_account_of_user_google(array $data) {
        $u = new Usuario();
        $obj = $u->transform_array_to_object($data);
        $u->create(self::ENTIDADE, $obj);
        $db_result = $this->database_result($u);
        if($db_result){
            $id = $u->getResult();
            $u->custom_query(self::SQL_LOGIN_CLIENT_GOOGLE, array(self::ID => $id));
            return $u->getResult()[0];
        } else{
            return TAG_ERROR;
        }
    }

    /**
    * @lacy_
    * Gera o path das imagens de perfil do usuário
    *
    * input: object-Usuario
    * output: string 
    */
    public function path_image($obj) {
        // verifica se o usuário cadastrou uma imagem de perfil
        if($obj->getImagem_url() != null){
            // verifica se a imagem cadastrada está no nosso servidor, caso não, utiliza a url completa cadastrada da API google
            $path_image = count(explode("uploads/", $obj->getImagem_url())) > 1 ? URL_BASE . $obj->getImagem_url() : $obj->getImagem_url();
        } else{
            // carrega imagem padrão caso não tenha referencia de imagem
            $path_image = URL_BASE . 'uploads/image/user.png';
        }
        return $path_image;
    }

    /**
     * @lacy_
     * login
    */
    public function login_user(array $data) {
        $usuario = new Usuario();
        $data[self::SENHA] = md5($data[self::SENHA]);
        $usuario->custom_query_on_table(self::ENTIDADE, self::LOGIN_USER, $data);
        $db_result = $this->database_result($usuario);

        if ($db_result == TAG_SUCCESS) {
            $result = $usuario->getResult()[0];
        }else {
            $result = TAG_ERROR;
        }

        return $result;
    }
}