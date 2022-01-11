<?php

namespace Source\Models;

use Labex\BasicPdo\Dao;
use Labex\BasicPdo\Functions;

class Recurso extends Dao implements Functions {
    // constantes
    const ENTIDADE = 'recurso';

    const ID = self::ENTIDADE . '_id';
    const NOME = self::ENTIDADE . '_nome';
    const DATA_CRIACAO = 'data_criacao';

    const RECURSO_A_K_N_N = array(Recurso::NOME);

    //lista os recursos de uma sala
    const RESOURCE_LIST = "SELECT recurso.*, sala.sala_id, sala_recurso.qtd_recurso, sala_recurso.sala_recurso_id
    FROM sala_recurso
    INNER JOIN sala
    INNER JOIN recurso
    ON sala.sala_id = sala_recurso.sala_recurso_sala_id
    AND recurso.recurso_id = sala_recurso.sala_recurso_recurso_id
    WHERE sala.sala_id = :sala_id";

    //lista todos os recursos
    const LIST_ALL_RESOURCES = "SELECT * FROM recurso
    ORDER BY recurso.data_criacao DESC";

    //busca recurso por palavra-chave
    const SEARCH_RESOURCE_BY_KEYWORD = "SELECT * FROM recurso
    WHERE recurso.recurso_nome LIKE :recurso_nome";

    // atributos 
    private $recurso_id;
    private $recurso_nome;
    private $data_criacao;

    // getters and setters
    public function getRecurso_id() {
        return $this->recurso_id;
    }

    public function setRecurso_id($recurso_id) {
        $this->recurso_id = $recurso_id;
    }

    public function getRecurso_nome() {
        return $this->recurso_nome;
    }

    public function setRecurso_nome($recurso_nome) {
        $this->recurso_nome = $recurso_nome;
    }

    public function getData_criacao() {
        return $this->data_criacao;
    }

    public function setData_criacao($data_criacao) {
        $this->data_criacao = $data_criacao;
    }

    // functions of class
    public function transform_array_to_object(array $data) {
        $obj = new Recurso();
        isset($data[self::ID]) ? $obj->setRecurso_id($data[self::ID]) : null;
        isset($data[self::NOME]) ? $obj->setRecurso_nome($data[self::NOME]) : null;
        isset($data[self::DATA_CRIACAO]) ? $obj->setData_criacao($data[self::DATA_CRIACAO]) : null;

        // retorna null para o a atributo result
        $obj->setResult();
        return $obj;
    }

    /**
     * @lacy_
     * Cria novo registro de recurso
     */
    public function create_new_resource(array $data)
    {
        $result = $this->check_fields(Recurso::RECURSO_A_K_N_N, $data);
        if (count($result) == 0) {
            $recurso = new Recurso();
            $obj = $recurso->transform_array_to_object($data);
            $recurso->create(Recurso::ENTIDADE, $obj);
            $db_result = $this->database_result($recurso);
            return $db_result;
        } else {
            $fields = $this->return_fields($result);
            return TAG_MESSAGE . "&" . $fields;
        }
    }

    /**
     * @lacy_
     * lista recursos de uma sala
     * $data -> array com o parâmetro: sala_id
     */
    public function resource_list(array $data){
        $recurso = new Recurso();
        $recurso->custom_query(self::RESOURCE_LIST, $data);
        $result = $recurso->getResult();
        return $result;
    }

    /**
     * @lacy_
     * lista todos os recursos
     */
    public function list_all_resources(){
        $recurso = new Recurso();
        $recurso->simple_custom_query(self::LIST_ALL_RESOURCES);
        $result = $recurso->getResult();

        if(!empty($result)){
            $result = $this->modify_date_pattern($result);
        }
        return $result;
    }

    /**
     * @lacy_
     * buscar recurso por palavra-chave
     * $data -> array com $recurso_nome
     */
    public function search_resource_by_keyword($data){
        $recurso = new Recurso();
        $recurso->custom_query(self::SEARCH_RESOURCE_BY_KEYWORD, $data);
        $result = $recurso->getResult();

        if(!empty($result)){
            $result = $this->modify_date_pattern($result);
        }

        return $result;
    }

    /**
     * @lacy_
     * atualiza recurso 
     */
    public function update_resource(array $data)
    {
        $recurso = new Recurso();
        $obj = $recurso->transform_array_to_object($data);
        $recurso->update(self::ENTIDADE, $obj);
        $db_result = $this->database_result($recurso);
        return $db_result;
    }

    /**
     * @lacy_
     * gerencia recursos
     */
    public function modify_date_pattern(array $resource_list){

        if(!empty($resource_list)){
            for($i = 0; $i < count($resource_list); $i++){
                //refatoração da data criação
                $resource_list[$i][self::DATA_CRIACAO] = date_of_post($resource_list[$i][self::DATA_CRIACAO]);
            }
        }

        return $resource_list;
    }
}