<?php

namespace Source\Models;

use Labex\BasicPdo\Dao;
use Labex\BasicPdo\Functions;

class Sala extends Dao implements Functions {
    // constantes
    const ENTIDADE = 'sala';

    const ID = self::ENTIDADE . '_id';
    const NOME = self::ENTIDADE . '_nome';
    //Status pode ser F (Fechada) ou A (Aberta)
    const STATUS = self::ENTIDADE . '_status';
    const DATA_CRIACAO = 'data_criacao';

    const SALA_A_K_N_N = array(Sala::NOME);

    //lista todas as salas
    const LIST_ALL_ROOMS = "SELECT sala.sala_id, sala.sala_nome, sala.data_criacao,
    ( CASE 
    WHEN sala.sala_status = 'F' THEN  'Fechada'
    ELSE 'Aberta'
    END) sala_status
    FROM sala
    ORDER BY sala.data_criacao DESC";

    //lista todas as salas abertas
    const LIST_ALL_OPEN_ROOMS = "SELECT sala.sala_id, sala.sala_nome, sala.data_criacao,
    ( CASE 
    WHEN sala.sala_status = 'F' THEN  'Fechada'
    ELSE 'Aberta'
    END) sala_status
    FROM sala
    WHERE sala.sala_status = 'A'
    ORDER BY sala.data_criacao DESC";

    // busca por salas abertas
    const SEARCH_OPEN_ROOMS = "SELECT sala.sala_id, sala.sala_nome, sala.data_criacao,
    ( CASE 
    WHEN sala.sala_status = 'F' THEN  'Fechada'
    ELSE 'Aberta'
    END) sala_status
    FROM sala
    WHERE sala.sala_status = 'A' AND sala.sala_nome LIKE :sala_nome
    ORDER BY sala.data_criacao DESC";

    //buscar sala por palavra chave
    const SEARCH_ROOM_BY_KEYWORD = "SELECT sala.sala_id, sala.sala_nome, sala.data_criacao,
    ( CASE 
    WHEN sala.sala_status = 'F' THEN  'Fechada'
    ELSE 'Aberta'
    END) sala_status
    FROM sala
    WHERE sala.sala_nome LIKE :sala_nome
    ORDER BY sala.data_criacao DESC";

    // atributos 
    private $sala_id;
    private $sala_nome;
    private $sala_status;
    private $data_criacao;


    // getters and setters
    public function getSala_id() {
        return $this->sala_id;
    }

    public function setSala_id($sala_id) {
        $this->sala_id = $sala_id;
    }

    public function getSala_nome() {
        return $this->sala_nome;
    }

    public function setSala_nome($sala_nome) {
        $this->sala_nome = $sala_nome;
    }

    public function getSala_status() {
        return $this->sala_status;
    }

    public function setSala_status($sala_status) {
        $this->sala_status = $sala_status;
    }

    public function getData_criacao() {
        return $this->data_criacao;
    }

    public function setData_criacao($data_criacao) {
        $this->data_criacao = $data_criacao;
    }

    // functions of class
    public function transform_array_to_object(array $data) {
        $obj = new Sala();
        isset($data[self::ID]) ? $obj->setSala_id($data[self::ID]) : null;
        isset($data[self::NOME]) ? $obj->setSala_nome($data[self::NOME]) : null;
        isset($data[self::STATUS]) ? $obj->setSala_status($data[self::STATUS]) : null;
        isset($data[self::DATA_CRIACAO]) ? $obj->setData_criacao($data[self::DATA_CRIACAO]) : null;

        // retorna null para o a atributo result
        $obj->setResult();
        return $obj;
    }

    /**
     * @lacy_
     * Cria novo registro de sala
     */
    public function create_new_room(array $data)
    {
        $sala = new Sala();
        $obj = $sala->transform_array_to_object($data);
        $sala->create(Sala::ENTIDADE, $obj);
        $db_result = $this->database_result($sala);
        if($db_result == TAG_SUCCESS){
            return $sala->getResult();
        }else{
            return TAG_ERROR;
        }
    }

    /**
     * @lacy_
     * atualiza sala
     */
    public function update_room(array $data)
    {
        $sala = new Sala();
        $obj = $sala->transform_array_to_object($data);
        $sala->update(self::ENTIDADE, $obj);
        $db_result = $this->database_result($sala);
        return $db_result;
    }

    /**
     * @lacy_
     * lista todas as salas
     */
    public function list_all_rooms(){
        $sala = new Sala();
        $sala->simple_custom_query(self::LIST_ALL_ROOMS);
        $result = $sala->getResult();
        return $result;
    }

    /**
     * @lacy_
     * lista todas as salas abertas
     */
    public function list_all_open_rooms(){
        $sala = new Sala();
        $sala->simple_custom_query(self::LIST_ALL_OPEN_ROOMS);
        $result = $sala->getResult();
        return $result;
    }

    /**
     * @lacy_
     * buscar todas as salas abertas
     * $data -> array formado pelo parâmetro sala_nome
     */
    public function search_open_rooms($data){
        $sala = new Sala();
        $sala->custom_query(self::SEARCH_OPEN_ROOMS, $data);
        $result = $sala->getResult();
        return $result;
    }

    /**
     * @lacy_
     * buscar sala por palavra chave
     * $data -> array formado pelo parâmetro sala_nome
     */
    public function search_room_by_keyword($data){
        $sala = new Sala();
        $sala->custom_query(self::SEARCH_ROOM_BY_KEYWORD, $data);
        $result = $sala->getResult();
        return $result;
    }

    /**
     * @lacy_
     * lista salas para gerenciamento do admin
     */
    public function manage_rooms(){
        $room_list = $this->list_all_rooms();

        if(!empty($room_list)){
            $room_list = $this->resource_integration($room_list);
        }

        return $room_list;
    }

    /**
     * @lacy_
     * busca salas para gerenciamento
     * $data -> array formado pelo parâmetro sala_nome
     */
    public function search_room_for_management($data){
        $room_list = $this->search_room_by_keyword($data);

        if(!empty($room_list)){
            $room_list = $this->resource_integration($room_list);
        }

        return $room_list;
    }

    /**
     * @lacy_
     * integra a lista recursos a sala pertencentes
     * $room_list -> array com a lista de salas
     */
    public function resource_integration($room_list){

        if(!empty($room_list)){
            for($i = 0; $i < count($room_list); $i++){
                $recurso = new Recurso();
                //lista de recursos

                $room_list[$i]['resource_list'] =  $recurso->resource_list(array(self::ID => $room_list[$i][self::ID]));

                //refatoração da data criação
                $room_list[$i][self::DATA_CRIACAO] = date_of_post($room_list[$i][self::DATA_CRIACAO]);
            }
        }

        return $room_list;
    }

    /**
     * @lacy_
     * gerenciar reservas de sala
     */
    public function manage_room_reservations(){
        $room_list = $this->list_all_open_rooms();

        if(!empty($room_list)){
            for($i = 0; $i < count($room_list); $i++){
                $usuario_sala = new UsuarioSala();
                $recurso = new Recurso();
                //lista de recursos
                $room_list[$i]['resource_list'] =  $recurso->resource_list(array(self::ID => $room_list[$i][self::ID]));

                //lista de reservas
                $room_list[$i]['reservation_list'] =  $usuario_sala->list_all_room_reservations(array(self::ID => $room_list[$i][self::ID]));

                //refatoração da data criação
                $room_list[$i][self::DATA_CRIACAO] = date_of_post($room_list[$i][self::DATA_CRIACAO]);
            }
        }

        return $room_list;
    }

    /**
     * @lacy_
     * busca salas para reserva
     * $data -> array formado pelo parâmetro sala_nome
     */
    public function search_rooms_for_reservation($data){
        $room_list = $this->search_open_rooms($data);

        if(!empty($room_list)){
            for($i = 0; $i < count($room_list); $i++){
                $usuario_sala = new UsuarioSala();
                $recurso = new Recurso();
                //lista de recursos
                $room_list[$i]['resource_list'] =  $recurso->resource_list(array(self::ID => $room_list[$i][self::ID]));

                //lista de reservas
                $room_list[$i]['reservation_list'] =  $usuario_sala->list_all_room_reservations(array(self::ID => $room_list[$i][self::ID]));

                //refatoração da data criação
                $room_list[$i][self::DATA_CRIACAO] = date_of_post($room_list[$i][self::DATA_CRIACAO]);
            }
        }

        return $room_list;
    }
}