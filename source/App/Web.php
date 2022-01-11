<?php

namespace Source\App;

use League\Plates\Engine;
use Source\Models\Usuario;
use Source\App\Email;
use Source\Models\Recurso;
use Source\Models\Sala;
use Source\Models\SalaRecurso;
use Source\Models\UsuarioSala;

session_start();

class Web {

    /** @var Engine */
    private $view;

    public function __construct($router){
        $this->view = Engine::create(__DIR__ . "/../../theme", "php");
        $this->view->addData(["router" => $router]);
    }

    /***
     * @lacy
     * =================================================================
     * ================= FUNÇÕES DE ROTA : TIPO GET ====================
     * =================================================================
     */

    public function login(): void {
        if(!isset($_SESSION['logged'])){
            echo $this->view->render("login", [
                "logged" => false,
                "title" => "Login | " . SITE,
            ]);
        }
    }

    public function signup(): void {
        if(!isset($_SESSION['logged'])){
            echo $this->view->render("signup", [
                "logged" => false,
                "title" => "Registro | " . SITE,
            ]);
        }
    }

    /**
     * @lacy_
     * rota para logout
     */
    public function logout() : void{
        if(isset($_SESSION['logged'])){
            session_destroy();
            redirect('/');
        }
    }

    public function requestRecover(): void {
        if(!isset($_SESSION['logged'])){
            echo $this->view->render("request-recover", [
                "logged" => false,
                "title" => "Recuperar senha | " . SITE,
            ]);
        }
    }

    /**
     * Executa procedimento para redefinição da senha de acesso do usuário
     */
    public function redefinePassword(array $data) {
        if(!isset($_SESSION['logged'])){
            echo $this->view->render("redefine-password", [
                "logged" => false,
                'email' => $data[Usuario::EMAIL],
                'key' => $data['key'],
                "title" => "Redefinir Senha | " . SITE,
            ]);
        }
    }
    

    public function home(): void {
        if(isset($_SESSION['logged'])){
            echo $this->view->render("home", [
                "logged" => true,
                "title" => "Home | " . SITE,
            ]);
        }else{
            redirect('/');
        }
    }

    public function manageResources(): void {
        if(isset($_SESSION['logged'])){
            echo $this->view->render("manage-resources", [
                "logged" => true,
                "title" => "Recursos | " . SITE,
            ]);
        }else{
            redirect('/');
        }
    }

    public function manageAllRooms(): void {
        if(isset($_SESSION['logged'])){
            echo $this->view->render("manage-rooms", [
                "logged" => true,
                "title" => "Salas | " . SITE,
            ]);
        }else{
            redirect('/');
        }
    }

    public function newRoom(): void {
        if(isset($_SESSION['logged'])){
            echo $this->view->render("new-room", [
                "logged" => true,
                "title" => "Nova Sala | " . SITE,
            ]);
        }else{
            redirect('/');
        }
    }

    public function editRoom(): void {
        if(isset($_SESSION['logged'])){
            echo $this->view->render("edit-room", [
                "logged" => true,
                "title" => "Editar Sala | " . SITE,
            ]);
        }else{
            redirect('/');
        }
    }

    public function myReservations(): void {
        if(isset($_SESSION['logged'])){
            echo $this->view->render("my-reservations", [
                "logged" => true,
                "title" => "Minhas Reservas | " . SITE,
            ]);
        }else{
            redirect('/');
        }
    }

    public function newReservation(): void {
        if(isset($_SESSION['logged'])){
            echo $this->view->render("new-reservation", [
                "logged" => true,
                "title" => "Nova Reserva | " . SITE,
            ]);
        }else{
            redirect('/');
        }
    }

    public function error(array $data): void {

        echo $this->view->render("error", [
            "title" => "Erro | " . SITE,
            "error" => $data["errcode"]
        ]);
    }

    /***
     * @lacy
     * =================================================================
     * ========== FUNÇÕES DE MANIPULAÇÃO DE DADOS: TIPO POST ===========
     * =================================================================
     */

    /**
     * Executa operação de LOGIN na plataforma
     * 
     * input: array(email => value, senha => value)
     */
    public function executeLogin(?array $data) {
        
        $user = new Usuario();

        $email = filter_var($data['email'], FILTER_VALIDATE_EMAIL);
        $pass = filter_var($data['senha'], FILTER_SANITIZE_STRING);

        if($email){
            $result_email = $user->verify_email(array(Usuario::EMAIL => $data[Usuario::EMAIL]));
            
            if($result_email == TAG_ERROR){
                $callback[TAG_ERROR] = true;
                $callback[TAG_MESSAGE] = 'Usuário não registrado!<br>Por favor, realize seu cadastro.';
                echo json_encode($callback);
                exit;
            }

            if(strlen($pass) > 0){
                $user = (new Usuario())->login_user($data);

                if($user == TAG_ERROR){
                    $callback[TAG_ERROR] = true;
                    $callback[TAG_MESSAGE] = 'Senha incorreta!';
                    echo json_encode($callback);
                    exit;
                }

                $callback[TAG_SUCCESS] = true;
                $callback['data'] = $user;
                $callback['redirect'] = url('/home');
                $_SESSION['logged'] = $user;

                echo json_encode($callback);
                return;

            } else{
                $callback[TAG_ERROR] = true;
                $callback[TAG_MESSAGE] = 'Senha indefinida';
                echo json_encode($callback);
                exit;
            }

        } else{
            $callback[TAG_ERROR] = true;
            $callback[TAG_MESSAGE] = 'Por favor, preencha os campos vazios.';
            echo json_encode($callback);
            exit;
        }
         
    }


    /**
     * Executa cadastro de um novo usuário na plataforma
     */
    public function registerUser(array $data) {

        $result_email = (new Usuario())->verify_email(array(Usuario::EMAIL => $data[Usuario::EMAIL]));

        if($result_email == TAG_ERROR){

            if(strlen($data[Usuario::SENHA]) >= 8 && strlen($data['conf_senha']) >= 8){

                if($data[Usuario::SENHA] == $data['conf_senha']){
                    
                    $return_type = (new Usuario())->create_new_account_of_user($data);
                    
                    if(!empty($return_type)){
                        $response[TAG_SUCCESS] = true;
                        $response['redirect'] = url('/home');
                        $_SESSION['logged'] = $return_type;  
                        $response['data'] = $return_type;            
                    } else{
                        $response[TAG_ERROR] = true;
        
                        $return_type = explode("&", $return_type);
                        $fields = explode('|', $return_type[1]);
        
                        if(count($fields) > 1){
                            $response[TAG_MESSAGE] = 'Há campos obrigatórios não preenchidos!';
                        } else{
                            $response[TAG_MESSAGE] = 'Um campo obrigatório não foi preenchido!';
                        }
                    }
                } else{
                    $response[TAG_ERROR] = true;
                    $response[TAG_MESSAGE] = "As senhas não coincidem!";
                }
            } else{
                $response[TAG_ERROR] = true;
                $response[TAG_MESSAGE] = "Senha deve conter 8 ou mais caracteres!";
            }

        } else {
            $response[TAG_ERROR] = true;
            $response[TAG_MESSAGE] = "O endereço de email já está cadastrado na base de dados!";
        }
        
        echo json_encode($response);
        exit;
    }

    /**
     * Executa requisição para recuperação de senha da plataforma
     */
    public function requestRecoverLogin($data) {
        $result = (new Usuario())->make_access_key_to_recover_login($data['email']);

        if($result != TAG_ERROR){
			list ($usuario_nome, $usuario_email, $chaveAcesso) = explode('|', $result);

            $message = $usuario_nome . '<br><br>Recebemos seu pedido de redefinição de senha, para isso' .
            ' disponibilizamos o seguinte link:  <a href="'.URL_BASE.'/redefine-password/'.$usuario_email.'/'.$chaveAcesso.'">' .
            'RECUPERAR SENHA</a><br><br>Atenciosamente, equipe ' . PROJECT_NAME . '!';

            $email = new Email();
            $email->add(
                "Recuperação de conta",
                $message,
                $usuario_nome,
                $usuario_email
            )->send();

            if(!$email->error()){
                $response[TAG_SUCCESS] = true;
                $response['redirect'] = url('/');
				$response[TAG_MESSAGE] = 'Um email de redefinição foi enviado, verifique sua caixa de entrada ou spam!';
            } else{
                $response[TAG_ERROR] = true;
				$response[TAG_MESSAGE] = 'Disparo de email não efetuado!';
            }
        }else{
            $response[TAG_ERROR] = true;
            $response[TAG_MESSAGE] = 'Este email não consta na base de dados!';
        }

        echo json_encode($response);
        exit;
    }

    /**
     * Executa requisição de redefinição de senha da plataforma
     */
    public function resetUserPassword($data) {
        $result = (new Usuario())->reset_user_password($data);

        if ($result == "message1") {
            $response[TAG_ERROR] = true;
            $response[TAG_MESSAGE] = 'Chave de acesso já utilizada!';
        } elseif ($result == "message2") {
            $response[TAG_ERROR] = true;
            $response[TAG_MESSAGE] = 'As senhas não são idênticas!';
        } elseif (!($result == TAG_ERROR)) {
            $response[TAG_SUCCESS] = true;
            $response[TAG_MESSAGE] = 'Senha redefinida';
            $response['redirect'] = url('/home');
            $_SESSION['logged'] = $result;  
        } else {
            $response[TAG_ERROR] = true;
            $response[TAG_MESSAGE] = 'Erro de conexão com banco de dados!<br>Contate a equipe de desenvolvimento.";';
        }

        echo json_encode($response);
        exit;
    }

    /**
     * @lacy_
     * cria novo recurso
     */
    public function createNewResource($data) {
        $result = (new Recurso())->create_new_resource($data);

        if ($result == TAG_ERROR) {
            $response[TAG_ERROR] = true;
            $response[TAG_MESSAGE] = 'Erro de conexão com banco de dados!<br>Contate a equipe de desenvolvimento.';
        } else if($result == TAG_SUCCESS) {
            $response[TAG_SUCCESS] = true;
            $response[TAG_MESSAGE] = 'Recurso criado!';
        }else{
            $response[TAG_ERROR] = true;
            $response[TAG_MESSAGE] = 'Preencha o nome do recurso!';
        }

        echo json_encode($response);
        exit;
    }

    /**
     * @lacy_
     * atualiza recurso
     */
    public function updateResource($data) {
        $result = (new Recurso())->update_resource($data);

        if (!($result == TAG_ERROR)) {
            $response[TAG_SUCCESS] = true;
            $response[TAG_MESSAGE] = 'Dados atualizados!';
        } else {
            $response[TAG_ERROR] = true;
            $response[TAG_MESSAGE] = 'Erro de conexão com banco de dados!<br>Contate a equipe de desenvolvimento.';
        }

        echo json_encode($response);
        exit;
    }

    /**
     * @lacy_
     * criar sala
     */
    public function createNewRoom($data) {
        $result = (new Sala())->create_new_room($data);

        if (!($result == TAG_ERROR)) {

            //id da sala criada
            $sala_id = intval($result);

            $lista_recurso = $data['data_recurso'];
            foreach($lista_recurso as $count => $value){
                //refatoração da data criação
                $lista_recurso[$count][SalaRecurso::SALA_ID] = $sala_id;
            }

            $result = (new SalaRecurso())->add_room_resources($lista_recurso);

            if (!($result == TAG_ERROR)) {
                $response[TAG_SUCCESS] = true;
                $response['redirect'] = url('/manage-rooms');
                $response[TAG_MESSAGE] = 'Sala criada.';
            } else {
                $response[TAG_ERROR] = true;
                $response[TAG_MESSAGE] = 'Erro de conexão com banco de dados!<br>Contate a equipe de desenvolvimento.';
            }
        }else{
            $response[TAG_ERROR] = true;
            $response[TAG_MESSAGE] = 'Erro de conexão com banco de dados!<br>Contate a equipe de desenvolvimento.';
        }

        echo json_encode($response);
        exit;
    }

    /**
     * @lacy_
     * atualiza sala
     */
    public function updateRoom($data) {
        $result = (new Sala())->update_room($data);

        if (!($result == TAG_ERROR)) {

            //atualiza os dados de recursos de uma sala
            if(!empty($data['data_update'])){
                $result = (new SalaRecurso())->update_room_resources($data['data_update']);
            }

            //cria novos recursos em uma sala
            if(!empty($data['data_create'])){
                $result = (new SalaRecurso())->add_room_resources($data['data_create']);
            }

            //apaga recursos de uma sala
            if(!empty($data['data_delete'])){
                $result = (new SalaRecurso())->remove_room_resources($data['data_delete']);
            }

            if (!($result == TAG_ERROR)) {
                $response[TAG_SUCCESS] = true;
                $response['redirect'] = url('/manage-rooms');
                $response[TAG_MESSAGE] = 'Dados Atualizados.';
            } else {
                $response[TAG_ERROR] = true;
                $response[TAG_MESSAGE] = 'Erro de conexão com banco de dados!<br>Contate a equipe de desenvolvimento.';
            }
        } else {
            $response[TAG_ERROR] = true;
            $response[TAG_MESSAGE] = 'Erro de conexão com banco de dados!<br>Contate a equipe de desenvolvimento.';
        }
        
        echo json_encode($response);
        exit;
    }

    /**
     * @lacy_
     * lista salas para gerenciamento do admin
     */
    public function manageRooms() {
        $result = (new Sala())->manage_rooms();

        echo json_encode($result);
        exit;
    }

    /**
     * @lacy_
     * lista salas para gerenciamento do admin
     */
    public function searchRoomByKeyword(array $data) {
        $result = (new Sala())->search_room_for_management($data);

        echo json_encode($result);
        exit;
    }

    /**
     * @lacy_
     * remove recursos de uma sala
     */
    public function removeRoomResources($data) {
        $result = (new SalaRecurso())->remove_room_resources($data['arrayChecked']);

        if ($result == TAG_SUCCESS) {
            $response[TAG_SUCCESS] = true;
            $response[TAG_MESSAGE] = 'Solicitação realizada!';
        } else {
            $response[TAG_ERROR] = true;
            $response[TAG_MESSAGE] = 'Algumas operações não foram realizadas! Contate a equipe de desenvolvimento.';
        }

        echo json_encode($response);
        exit;
    }

    /**
     * @lacy_
     * cria nova reserva
     */
    public function createRoomReservation($data) {
        //refatoração de data início
        $data_inicio = explode('T', $data[UsuarioSala::INICIO]);
        $data[UsuarioSala::INICIO] = $data_inicio[0] . ' ' . $data_inicio[1];

        //refatoração de data término
        $data_fim = explode('T', $data[UsuarioSala::FIM]);
        $data[UsuarioSala::FIM] = $data_fim[0] . ' ' . $data_fim[1];

        $result = (new UsuarioSala())->create_room_reservation($data);

        if ($result == "message1") {
            $response[TAG_ERROR] = true;
            $response[TAG_MESSAGE] = 'Error ao reservar sala!';
        } elseif ($result == TAG_SUCCESS) {
            $response[TAG_SUCCESS] = true;
            $response[TAG_MESSAGE] = 'Reserva criada!';
            $response['redirect'] = url('/home');
        } elseif ($result == TAG_ERROR) {
            $response[TAG_ERROR] = true;
            $response[TAG_MESSAGE] = 'Algumas operações não foram realizadas! Contate a equipe de desenvolvimento.';
        }else{
            $response[TAG_ERROR] = true;
            $response[TAG_MESSAGE] = $result;
        }

        echo json_encode($response);
        exit;
    }

    /**
     * @lacy_
     * cancelamento de reserva
     */
    public function cancelReservation($data) {
        $result = (new Sala())->update_room($data);

        if (!($result == TAG_ERROR)) {
            $response[TAG_SUCCESS] = true;
            $response[TAG_MESSAGE] = 'Reserva cancelada!';
        } else {
            $response[TAG_ERROR] = true;
            $response[TAG_MESSAGE] = 'Erro de conexão com banco de dados!<br>Contate a equipe de desenvolvimento.';
        }
        
        echo json_encode($response);
        exit;
    }

    /**
     * @lacy_
     * lista recursos para gerenciamento do admin
     */
    public function listResources() {
        $result = (new Recurso())->list_all_resources();

        echo json_encode($result);
        exit;
    }

    /**
     * @lacy_
     * lista recursos de uma sala
     */
    public function roomResourcesList($data) {
        $result = (new Recurso())->resource_list($data);

        echo json_encode($result);
        exit;
    }

    /**
     * @lacy_
     * busca recurso por palavra-chave
     */
    public function searchResourceBbyKeyword($data) {
        $result = (new Recurso())->search_resource_by_keyword($data);

        echo json_encode($result);
        exit;
    }

    /**
     * @lacy_
     * lista recursos para gerenciamento do admin
     */
    public function listAllUserReservations($data) {
        $result = (new UsuarioSala())->list_all_user_reservations($data);

        echo json_encode($result);
        exit;
    }

    /**
     * @lacy_
     * atualiza reserva de sala
     */
    public function updateRoomReservation($data) {
        $result = (new UsuarioSala())->update_room_reservation($data);

        if (!($result == TAG_ERROR)) {
            $response[TAG_SUCCESS] = true;
            $response[TAG_MESSAGE] = 'Reserva cancelada!';
        } else {
            $response[TAG_ERROR] = true;
            $response[TAG_MESSAGE] = 'Erro de conexão com banco de dados!<br>Contate a equipe de desenvolvimento.';
        }

        echo json_encode($response);
        exit;
    }

    /**
     * @lacy_
     * busca reserva
     */
    public function searchReservationByKeyword(array $data) {
        $result = (new UsuarioSala())->search_reservation_for_user($data);

        echo json_encode($result);
        exit;
    }

    /**
     * @lacy_
     * verifica se escolhida está disponível
     */
    public function checkDateAvailability($data) {

        $result = (new UsuarioSala())->check_date_availability($data);

        if ($result == "message1") {
            $response[TAG_SUCCESS] = true;
            $response[TAG_MESSAGE] = 'disponivel';
        } elseif ($result == "message2") {
            $response[TAG_ERROR] = true;
            $response[TAG_MESSAGE] = 'indisponivel';
        } elseif ($result == "message3") {
            $response[TAG_SUCCESS] = true;
            $response[TAG_MESSAGE] = 'disponivel';
        }else{
            $response[TAG_ERROR] = true;
            $response[TAG_MESSAGE] = 'inválida';
        }

        echo json_encode($response);
        exit;
        
    }

    /**
     * @lacy_
     * verifica se escolhida está disponível
     */
    public function manageRoomReservations() {

        $result = (new Sala())->manage_room_reservations();

        echo json_encode($result);
        exit;
    }

    /**
     * @lacy_
     * verifica se escolhida está disponível
     */
    public function searchRoomsForReservation(array $data) {

        $result = (new Sala())->search_rooms_for_reservation($data);

        echo json_encode($result);
        exit;
    }
}
