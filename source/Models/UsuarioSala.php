<?php

namespace Source\Models;

use Labex\BasicPdo\Dao;
use Labex\BasicPdo\Functions;

class UsuarioSala extends Dao implements Functions {
    // constantes
    const ENTIDADE = 'usuario_sala';

    const ID = self::ENTIDADE . '_id';
    //Status pode ser R (Reservada) ou C (Cancelada)
    const STATUS = self::ENTIDADE . '_status';
    const DATA_CRIACAO = 'data_criacao';
    const INICIO = 'reserva_inicia';
    const FIM = 'reserva_fim';
    const USUARIO_ID = self::ENTIDADE . '_usuario_id';
    const SALA_ID = self::ENTIDADE . '_sala_id';


    //busca reservas de um usuário
    const USER_RESERVATIONS_LIST = "SELECT sala.sala_nome, sala.sala_id, usuario_sala.*, usuario.usuario_nome,
    ( CASE 
    WHEN usuario_sala.usuario_sala_status = 'R' THEN  'Reservada'
    ELSE 'Cancelada'
    END) status_escrito

    FROM usuario_sala
    INNER JOIN sala
    INNER JOIN usuario
    ON usuario_sala.usuario_sala_sala_id = sala.sala_id
    AND usuario.usuario_id = usuario_sala.usuario_sala_usuario_id
    WHERE usuario.usuario_id = :usuario_id
    ORDER BY usuario_sala.data_criacao DESC";

    //busca reserva de usuário
    const SEARCH_USER_RESERVATION = "SELECT sala.sala_nome, sala.sala_id, usuario_sala.*, usuario.usuario_nome,
    ( CASE 
    WHEN usuario_sala.usuario_sala_status = 'R' THEN  'Reservada'
    ELSE 'Cancelada'
    END) status_escrito

    FROM usuario_sala
    INNER JOIN sala
    INNER JOIN usuario
    ON usuario_sala.usuario_sala_sala_id = sala.sala_id
    AND usuario.usuario_id = usuario_sala.usuario_sala_usuario_id
    WHERE usuario.usuario_id = :usuario_id AND sala.sala_nome LIKE :sala_nome
    ORDER BY usuario_sala.data_criacao DESC";

    //lista as reservas de uma sala
    const LIST_MOST_RECENT_ROOM_RESERVATIONS = "SELECT sala.sala_id, sala.data_criacao, usuario_sala.usuario_sala_status, usuario_sala.reserva_inicia, usuario_sala.reserva_fim, usuario.usuario_nome,
    ( CASE 
    WHEN usuario_sala.usuario_sala_status = 'R' THEN  'Reservada'
    ELSE 'Cancelada'
    END) status_escrito

    FROM usuario_sala
    INNER JOIN sala
    INNER JOIN usuario
    ON usuario_sala.usuario_sala_sala_id = sala.sala_id
    AND usuario.usuario_id = usuario_sala.usuario_sala_usuario_id
    WHERE sala.sala_id = :sala_id AND MONTH(usuario_sala.data_criacao) >= MONTH(CURRENT_DATE())
    ORDER BY usuario_sala.data_criacao DESC";

    //lista reservas recentes
    const RECENT_RESERVATIONS_LIST = "SELECT sala.sala_nome, sala.sala_id, usuario_sala.*, usuario.usuario_nome
    FROM usuario_sala
    INNER JOIN sala
    INNER JOIN usuario
    ON usuario_sala.usuario_sala_sala_id = sala.sala_id
    AND usuario.usuario_id = usuario_sala.usuario_sala_usuario_id
    WHERE usuario_sala.usuario_sala_status <> 'C' AND MONTH(usuario_sala.data_criacao) >= MONTH(CURRENT_DATE())
    ORDER BY usuario_sala.data_criacao DESC";

    const USUARIO_SALA_A_K_N_N = array(UsuarioSala::INICIO, UsuarioSala::FIM, UsuarioSala::USUARIO_ID, UsuarioSala::SALA_ID);

    // atributos 
    private $usuario_sala_id;
    private $usuario_sala_status;
    private $data_criacao;
    private $reserva_inicia;
    private $reserva_fim;
    private $usuario_sala_usuario_id;
    private $usuario_sala_sala_id;

    // getters and setters
    public function getUsuario_sala_id() {
        return $this->usuario_sala_id;
    }

    public function setUsuario_sala_id($usuario_sala_id) {
        $this->usuario_sala_id = $usuario_sala_id;
    }

    public function getUsuario_sala_status() {
        return $this->usuario_sala_status;
    }

    public function setUsuario_sala_status($usuario_sala_status) {
        $this->usuario_sala_status = $usuario_sala_status;
    }

    public function getData_criacao() {
        return $this->data_criacao;
    }

    public function setData_criacao($data_criacao) {
        $this->data_criacao = $data_criacao;
    }

    public function getReserva_inicia() {
        return $this->reserva_inicia;
    }

    public function setReserva_inicia($reserva_inicia) {
        $this->reserva_inicia = $reserva_inicia;
    }

    public function getReserva_fim() {
        return $this->reserva_fim;
    }

    public function setReserva_fim($reserva_fim) {
        $this->reserva_fim = $reserva_fim;
    }

    public function getUsuario_sala_usuario_id() {
        return $this->usuario_sala_usuario_id;
    }

    public function setUsuario_sala_usuario_id($usuario_sala_usuario_id) {
        $this->usuario_sala_usuario_id = $usuario_sala_usuario_id;
    }

    public function getUsuario_sala_sala_id() {
        return $this->usuario_sala_sala_id;
    }

    public function setUsuario_sala_sala_id($usuario_sala_sala_id) {
        $this->usuario_sala_sala_id = $usuario_sala_sala_id;
    }

    // functions of class
    public function transform_array_to_object(array $data) {
        $obj = new UsuarioSala();
        isset($data[self::ID]) ? $obj->setUsuario_sala_id($data[self::ID]) : null;
        isset($data[self::STATUS]) ? $obj->setUsuario_sala_status($data[self::STATUS]) : null;
        isset($data[self::DATA_CRIACAO]) ? $obj->setData_criacao($data[self::DATA_CRIACAO]) : null;
        isset($data[self::INICIO]) ? $obj->setReserva_inicia($data[self::INICIO]) : null;
        isset($data[self::FIM]) ? $obj->setReserva_fim($data[self::FIM]) : null;
        isset($data[self::USUARIO_ID]) ? $obj->setUsuario_sala_usuario_id($data[self::USUARIO_ID]) : null;
        isset($data[self::SALA_ID]) ? $obj->setUsuario_sala_sala_id($data[self::SALA_ID]) : null;

        // retorna null para o a atributo result
        $obj->setResult();
        return $obj;
    }

    /**
     * @lacy_
     * Cria reserva de sala
     */
    public function create_room_reservation(array $data)
    {
        $result = $this->check_fields(UsuarioSala::USUARIO_SALA_A_K_N_N, $data);
        if (count($result) == 0) {
            $usuario_sala = new UsuarioSala();
            $obj = $usuario_sala->transform_array_to_object($data);
            $usuario_sala->create(self::ENTIDADE, $obj);
            $db_result = $this->database_result($usuario_sala);

            return $db_result;
        } else {
            $fields = $this->return_fields($result);
            return TAG_MESSAGE . "&" . $fields;
        }
    }

    /**
     * @lacy_
     * update reserva sala
     */
    public function update_room_reservation(array $data)
    {
        $usuario_sala = new UsuarioSala();
        $obj = $usuario_sala->transform_array_to_object($data);
        $usuario_sala->update(self::ENTIDADE, $obj);
        $db_result = $this->database_result($usuario_sala);
        return $db_result;
    }

    /**
     * @lacy_
     * lista as reservas de um usuário
     * $data -> array com o parâmetro: sala_id
     */
    public function user_reservations_list($data){
        $usuario_sala = new UsuarioSala();
        $usuario_sala->custom_query(self::USER_RESERVATIONS_LIST, $data);
        $result = $usuario_sala->getResult();
        return $result;
    }

    /**
     * @lacy_
     * busca uma ou mais reservas de determinado usuário
     * $data -> array com o parâmetro: sala_nome e usuario_id
     */
    public function search_user_reservation($data){
        $usuario_sala = new UsuarioSala();
        $usuario_sala->custom_query(self::SEARCH_USER_RESERVATION, $data);
        $result = $usuario_sala->getResult();
        return $result;
    }

    /**
     * @lacy_
     * lista reservas recentes
     */
    public function recent_reservations_list(){
        $usuario_sala = new UsuarioSala();
        $usuario_sala->simple_custom_query(self::RECENT_RESERVATIONS_LIST);
        $result = $usuario_sala->getResult();
        return $result;
    }

    /**
     * @lacy_
     * lista reservas de uma sala
     */
    public function list_reservations_for_a_room($data){
        $usuario_sala = new UsuarioSala();
        $usuario_sala->custom_query(self::LIST_MOST_RECENT_ROOM_RESERVATIONS, $data);
        $result = $usuario_sala->getResult();
        return $result;
    }

    /**
     * @lacy_
     * todas as reservas de um usuário
     * $data -> parâmetro com usuario_id
     */
    public function list_all_user_reservations($data){

        $room_list = $this->user_reservations_list($data);

        if(!empty($room_list)){
            $room_list = $this->adapt_booking_information($room_list);
        }

        return $room_list;
    }

    /**
     * @lacy_
     * busca reservas para usuário
     * $data -> array com o parâmetro: sala_nome e usuario_id
     */
    public function search_reservation_for_user($data){

        $room_list = $this->search_user_reservation($data);

        if(!empty($room_list)){
            $room_list = $this->adapt_booking_information($room_list);
        }

        return $room_list;
    }

    /**
     * @lacy_
     * lista todas as reservas recentes de uma sala
     * $data -> array com o parâmetro: sala_id
     */
    public function list_all_room_reservations($data){

        $room_list = $this->list_reservations_for_a_room($data);

        if(!empty($room_list)){
            $room_list = $this->adapt_booking_information($room_list);
        }

        return $room_list;
    }

    /**
     * @lacy_
     * adapta informações de reserva
     * $room_list -> lista de salas
     */
    public function adapt_booking_information($room_list){
        $recurso = new Recurso();

        if(!empty($room_list)){
            for($i = 0; $i < count($room_list); $i++){

                //data final da reserva
                $room_list[$i][self::INICIO] = adjust_datetime($room_list[$i][self::INICIO]);

                if(strtotime(date('Y-m-d H:i:s')) < strtotime($room_list[$i][self::FIM])){
                    $room_list[$i]['permission_cancel'] = 'N';
                }         

                //data final da reserva
                $room_list[$i][self::FIM] = adjust_datetime($room_list[$i][self::FIM]);

                $room_list[$i]['resource_list'] =  $recurso->resource_list(array(SALA::ID => $room_list[$i][SALA::ID]));

                //refatoração da data criação
                $room_list[$i][self::DATA_CRIACAO] = date_of_post($room_list[$i][self::DATA_CRIACAO]);
            }
        }

        return $room_list;
    }

    /**
     * @lacy_
     * verifica se a data escolhida pelo usuário está disponível
     * $data -> data verificada pelo usuário
     */
    public function check_date_availability($data){
        $fromUser = $data['data_user'];
        $reserve_list = $this->recent_reservations_list();

        $dataUser = strtotime($fromUser);
        $dataAtual = strtotime(date('Y-m-d H:i:s'));

        if($dataUser < $dataAtual){
            return TAG_MESSAGE . '4';
        }else{
            if(!empty($reserve_list)){
                foreach($reserve_list as $count => $value){
    
                    $dataStart = strtotime($value[UsuarioSala::INICIO]);
                    $dataEnd = strtotime($value[UsuarioSala::FIM]);
    
                    if( $dataUser >= $dataStart && $dataUser <= $dataEnd)
                    {
                        return TAG_MESSAGE . '2';
                        exit;
                    }else{
                        return TAG_MESSAGE . '3';
                        exit;
                    }
                }
            }else{
                return TAG_MESSAGE . '1';
            }
        }
    }
}