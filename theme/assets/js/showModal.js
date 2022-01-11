//exibe o create
function showModalCreate(){
    $('#modal-document-create').modal('show');
}

//exibe o update
function showModalUpdate(){
    $('#modal-document-update').modal('show');
}

//exibe o alert
function showAlert(){
    $('#modal-alert').modal('show');
}

//exibe o modal-confirmation-user
function showConfirmation(){
    $('#modal-confirmation-user').modal('show');
}

//exibe o modal-recover-password
function showRecoverPassword(){
    $('#modal-recover-password').modal('show');
}

//fecha o modal
function modalClose(ele){
    $('#' + ele).modal("toggle");
}

/**
 * @lacy_
 * exibe o modal para criar recurso
 */
 function showModalCreateResource(){
    $('#modal-create-resource').modal('show');
}
