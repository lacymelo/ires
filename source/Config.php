<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

date_default_timezone_set('America/Sao_Paulo');

define('HOST', 'localhost');
define("URL_BASE", "http://localhost/ires");
// define('URL_BASE', 'https://bit.dev.br/ires');

define("SITE", "iRes");
define("PROJECT_NAME", "iRes");

// DATABASE
define('USER', 'root');
define('DBSA', 'place_reservation');
define('PASS', '');

//HOSPEDAGEM
// define('USER', 'lacy');
// define('PASS', "Sha25UNs_M=av$7K");
// define('DBSA', 'ires');

// TAG'S DE CONTROLE
define('JS_VERSION', '1');
define('TAG_SUCCESS', 'success');
define('TAG_ERROR', 'error');
define('TAG_MESSAGE', 'message');
define('TAG_WARNING', 'warning');

// PHP MAILER
define("MAIL", [
    "host" => "mail.bit.dev.br",
    "port" => 465,
    "user" => "messenger@bit.dev.br",
    "from_email" => "messenger@bit.dev.br",
    "passwd" => "?+jVjB1_jUyGPq91",
    "from_name" => "iRes"
]);

//array mouther
define('mouther', array('jan', 'fev', 'mar', 'abr', 'mai', 'jun', 'jul', 'ago', 'set', 'out', 'nov', 'dez'));


// HELPERS FUNCTIONS
function url(string $uri = null){
    if($uri){
        return URL_BASE . "{$uri}";
    }
    return URL_BASE;
}

/**
 * Redirecionando e saindo.
 * @param string $url
 */
function redirect(string $url): void {
    header("HTTP/1.1 302 Redirect");
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        header("Location: {$url}");
        exit;
    }

    if (filter_input(INPUT_GET, "route", FILTER_DEFAULT) != $url) {
        $location = url($url);
        header("Location: {$location}");
        exit;
    }
}

/**
 * @gnleo
 * Executa o upload de arquivos e mídias
 * Quando executado retorna o path do arquivo criado no servidor
 * 
 * $data é um array associativo de configuração
 * ex: array('file' => $_FILES['file'])
 */
function upload_file(array $data){
    $path = __DIR__;
    $path = explode("source", $path);
    // tipos de arquivos aceitos
    $extensoes = '/^.+(\.csv|\.txt|\.xlsx|\.png|\.jpg)$/';
    
    // verifica se é um arquivo aceito
    $check_result = preg_match($extensoes, $data['file']['name']);

    if($check_result){
        //verifica tipo de arquivo
        $type = explode("/", $data['file']['type']);
        
        //recupera o tipo de extensão do arquivo
        $extensoes = explode('.', $data['file']['name']);
        
        //renomeia arquivo - evita duplicação de arquivo
        $data['file']['name'] = md5($data['file']['name'].date('Y/m/d H:m:s')) . '.' . $extensoes[count($extensoes)- 1];
        
        // verifica e cria diretório de uploads
        if(!file_exists($path[0] . 'uploads')){
            mkdir($path[0] . 'uploads', 0777);
        }

        // verifica tipo de arquivo para upload 
        if($type[0] == 'image'){
            if(!file_exists($path[0] . 'uploads/image/')){
                mkdir($path[0] . 'uploads/image/', 0777);
            }   

            // cria referencia de imagem no servidor
            move_uploaded_file($data['file']['tmp_name'], $path[0] . 'uploads/image/' . $data['file']['name']);
        
            return 'uploads/image/' . $data['file']['name'];
        }
       
        // cria referencia de arquivo no servidor
        move_uploaded_file($data['file']['tmp_name'], $path[0] . 'uploads/' . $data['file']['name']);
        
        return 'uploads/' . $data['file']['name'];

    } else{
        return FALSE;
    }
}

/**
 * @lacy_
 * Fatora uma data para exibição em front-end
 * 
 * Retorna uma string no formato '12 jul 2021'
 */
function date_of_post($date){
    $date_month = '';
    $valor_mes = 0;
    $array_mes = mouther;
    $separador = explode("-", $date);

    for($mes_number = 0; $mes_number < count($array_mes); $mes_number++){
        $valor_mes = $mes_number + 1;

        if($valor_mes == $separador[1]){
            $day_hours = explode(' ', $separador[2]);

            $date_month .= $day_hours[0] . ' ' . $array_mes[$mes_number] . ' ' . $separador[0];
        }  
    }

    return $date_month;
}

/**
 * @lacy_
 * Fatora uma data para exibição em front-end
 * 
 * Retorna uma string no formato '06 April 2020 | 08:31'
 */
function adjust_datetime($date){
    $date_month = '';
    $valor_mes = 0;
    $array_mes = mouther;
    $separador = explode("-", $date);

    for($mes_number = 0; $mes_number < count($array_mes); $mes_number++){
        $valor_mes = $mes_number + 1;

        if($valor_mes == $separador[1]){
            $day_hours = explode(' ', $separador[2]);

            //recupera o horário
            $hour = explode(':', $day_hours[1]);

            $date_month = $day_hours[0] . ' ' . $array_mes[$mes_number] . ' ' . $separador[0] . '|' . $hour[0] . ':' . $hour[1];
        }   
    }

    return $date_month;
}