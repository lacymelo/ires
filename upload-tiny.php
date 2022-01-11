<?php
namespace Source\Config;
require __DIR__ . "/vendor/autoload.php";

if(isset($_FILES['file'])){
    $r['location'] = upload_file(array('file' => $_FILES['file']));
    echo json_encode ($r);
}else{
    $r['location'] = null;
    echo json_encode ($r);
}