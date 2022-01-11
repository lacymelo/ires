// notificação de aviso
function notificationSuccess(msg){
    Lobibox.notify('success', {
        title: 'Sucesso',
        msg: msg
    });
}

// notificação de aviso
function notificationWarning(msg){
    Lobibox.notify('warning', {
        title: 'Alerta',
        msg: msg
    });
}

// notificação de erro
function notificationError(msg){
    Lobibox.notify('error', {
        title: 'Erro',
        msg: msg
    });
}

//notificação de informação
function notificationInfo(msg){
    Lobibox.notify('info', {
        title: 'Informação',
        msg: msg
    });
}

function notificationWarningLange(msg){
    Lobibox.notify('warning', {
        title: 'Você deixou de preencher!',
        size: 'large',
        height: 200,
        msg: msg
    });
}