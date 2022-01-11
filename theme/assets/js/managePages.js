/**
 * variáveis declaradas no arquivo demo.js
 * @var URL 
 * @var locationUrl
 */
//página atual
const pageName = locationUrl[4];
//lista 
const listItem = document.querySelector('.list-item');
//message
const messageResult = document.querySelector('.result-message');
let pageItem = 1;
// array de recursos marcados
let arrayChecked = [];

let arrayCreate = [];
let arrayUpdate = [];
let arrayDelete = [];
//contantes para controle da tabela
const colView = document.querySelector('.col-view');
const colTable = document.querySelector('.col-table');
const listResource = document.querySelector('.list-resource');
const titleResource = document.querySelector('.title-resource');
//constantes para editar sala
const salaNome = document.querySelector('.sala-nome');
//sessão para edição de dados da sala
let dataRoom = JSON.parse(localStorage.getItem('session-room'));
//cancelamento da reserva
const reservaCancelada = document.querySelector('.reserva-cancelada');
const buttonConfirme = document.getElementById('buttonConfirme');
//lista reservas
const listReservation = document.querySelector('.list-reservation');
//title lista
const typeList = document.querySelector('.title-type-list');

/**
 * @lacy_
 * ######### INICÍA AS FUNÇÕES #########
 */
window.addEventListener('load', function () {
    currentPage();
});

/**
 * @lacy_
 * renderiza as funções da página atual
 */
function currentPage() {
    switch (pageName) {
        case 'new-room':
        case 'edit-room':
        case 'manage-resources':
            resourceList();
            break;

        case 'manage-rooms':
            roomList();
            break;

        case 'my-reservations':
            userReservationList();
            break;

        case 'home':
            listAllOpenRooms();
            break;

        case 'new-reservation':
            const salaId = document.querySelector('.usuario_sala_sala_id');
            const usuarioId = document.querySelector('.usuario_sala_usuario_id');

            //seta id da sala no formulário de reserva
            salaId.setAttribute('value', dataRoom.sala_id);
            //seta id do usuário no formulário de reserva
            usuarioId.setAttribute('value', dataUser.usuario_id);
            break;
    }

}

/**---------------------------------------------------------- */
/**----------- Start: GERENCIAMENTO DE RECURSOS ----------------- */
/**---------------------------------------------------------- */

/**
 * @lacy_ 
 * busca rede por palavra chave
 * flag -> apresenta o valor 1, se houver um valor
 * a caixa 1 (1) está sendo utilizada, caso contrário a caixa 2 (2)
 */
function searchForKeyWord(flag = null) {
    console.log('aqui');
    //recupera o testo de busca
    var textKey;
    var pathSearch;
    var dataSubmit;

    if (flag == 1) {
        textKey = $("input[name='text_search']").val();
    } else {
        textKey = $("input[name='text_search_2']").val();
    }

    switch (pageName) {
        case 'manage-resources':
            pathSearch = URL + '/searchResourceBbyKeyword';
            dataSubmit = {
                recurso_nome: '%' + textKey + '%',
            };
            break;

        case 'manage-rooms':
            pathSearch = URL + '/searchRoomByKeyword';
            dataSubmit = {
                sala_nome: '%' + textKey + '%',
            };
            break;

        case 'my-reservations':
            pathSearch = URL + '/searchReservationByKeyword';
            dataSubmit = {
                sala_nome: '%' + textKey + '%',
                usuario_id: dataUser.usuario_id
            };
            break;

        case 'home':
            pathSearch = URL + '/searchRoomsForReservation';
            dataSubmit = {
                sala_nome: '%' + textKey + '%',
            };
            break;
    }

    $.ajax({
        url: pathSearch,
        type: 'POST',
        data: dataSubmit,
        dataType: 'json',
        success: function (response) {
            // console.log(response);
            answersIndicatorContainer.classList.add('hidden');
            listItem.innerHTML = '';
            messageResult.classList.add('hidden');
            if (response.length > 0) {
                answersIndicatorContainer.classList.remove('hidden');

                switch (pageName) {
                    case 'manage-resources':
                        showResources(response);
                        break;

                    case 'manage-rooms':
                        showRooms(response);
                        break;

                    case 'my-reservations':
                        showReservations(response);
                        break;

                    case 'home':
                        showRoomsReservation(response);
                        break;
                }

            } else {
                answersIndicatorContainer.classList.add('hidden');
                messageResult.classList.remove('hidden');
            }
        }
    });

    return false
}



/**
 * @lacy_
 * requisição da lista recursos
 */
function resourceList() {
    $.ajax({
        url: URL + '/listResources',
        type: 'POST',
        dataType: 'json',
        success: function (response) {
            answersIndicatorContainer.classList.add('hidden');
            listItem.innerHTML = '';
            messageResult.classList.add('hidden');
            if (response.length > 0) {
                answersIndicatorContainer.classList.remove('hidden');

                switch (pageName) {
                    case 'new-room':
                        showResourcesToAdd(response);
                        break;

                    case 'manage-resources':
                        showResources(response);
                        break;

                    case 'edit-room':
                        showResourcesToAdd(response);
                        setInfoToEditRoom();
                        break;
                }
            } else {
                answersIndicatorContainer.classList.add('hidden');
                messageResult.classList.remove('hidden');
            }
        }
    });

    return false
}

/**
 * @lacy_
 * exibe a lista de recursos
 * $data -> array de recursos
 */
function showResources(data) {

    let count = 0;
    pageItem = 1;

    const thead = document.createElement('thead');
    const trHeader = document.createElement('tr');
    const thTitle = document.createElement('th');
    const thDate = document.createElement('th');
    const thOption = document.createElement('th');
    const tbody = document.createElement('tbody');

    //start: header table
    //Start: Título
    thTitle.setAttribute('scope', 'col');
    thTitle.innerHTML = 'Nome';
    //End: Título
    //Start: data criação
    thDate.setAttribute('scope', 'col');
    thDate.className = 'text-center';
    thDate.innerHTML = 'Data Criação';
    //End: data criação
    //Start: Opção
    thOption.setAttribute('scope', 'col');
    thOption.className = 'text-center';
    thOption.innerHTML = 'Opção';
    //End: Opção
    trHeader.append(thTitle, thDate, thOption);
    thead.className = 'thead-s';
    thead.append(trHeader);
    //end: header table

    //start: tbody
    for (var i = 0; i < data.length; i++) {
        /**
         * determina a quantidade de itens por página,
         * os itens que serão exibidos em uma página, recebem a class .page${pageItem}, sendo ${pageItem}
         * o índice da página
         */
        if (count == 8) {
            pageItem += 1;
            count = 0;
        }

        count += 1;

        const tr = document.createElement('tr');
        const tdTitle = document.createElement('td');
        const tdDate = document.createElement('td');
        const tdOption = document.createElement('td');
        const ul = document.createElement('ul');
        const li = document.createElement('li');
        const linkEdit = document.createElement('a');

        tdTitle.innerHTML = data[i].recurso_nome;
        tdDate.innerHTML = data[i].data_criacao;
        tdDate.className = 'text-center';
        linkEdit.className = 'tw';
        linkEdit.title = 'Editar';
        linkEdit.innerHTML = '<i class="fla-1x flaticon-edit"></i>';
        linkEdit.setAttribute('onclick', `showModalEditResource(${JSON.stringify(data[i])})`);
        li.append(linkEdit);
        ul.className = 'button-zoom';
        ul.append(li);
        tdOption.className = 'text-center';
        tdOption.append(ul);
        tr.append(tdTitle, tdDate, tdOption);
        tr.className = `page${pageItem} page`;
        tbody.append(tr);
    }
    //end: tbody

    listItem.append(thead, tbody);
    //exibe a primeira página
    showPage(0);
    answersIndicator();
}

/**
 * @lacy_
 * exibe a lista de recursos para adicionar em uma sala
 * $data -> array de recursos
 */
function showResourcesToAdd(data) {

    let count = 0;
    pageItem = 1;

    const thead = document.createElement('thead');
    const trHeader = document.createElement('tr');
    const thSwitch = document.createElement('th');
    const thTitle = document.createElement('th');
    const thQtd = document.createElement('th');
    const tbody = document.createElement('tbody');

    //start: header table
    //Start: título selecionar
    thSwitch.className = 'cell-ta';
    thSwitch.innerHTML = 'Selecionar';
    //End: título selecionar
    //Start: Título
    thTitle.setAttribute('scope', 'col');
    thTitle.innerHTML = 'Nome';
    //End: Título
    //Start: quantidade
    thQtd.setAttribute('scope', 'col');
    thQtd.className = 'text-center';
    thQtd.innerHTML = 'Quantidade';
    thQtd.setAttribute('width', '35');
    //End: quantidade
    trHeader.append(thSwitch, thTitle, thQtd);
    thead.className = 'thead-s';
    thead.append(trHeader);
    //end: header table

    //start: tbody
    for (var i = 0; i < data.length; i++) {
        /**
         * determina a quantidade de itens por página,
         * os itens que serão exibidos em uma página, recebem a class .page${pageItem}, sendo ${pageItem}
         * o índice da página
         */
        if (count == 6) {
            pageItem += 1;
            count = 0;
        }

        count += 1;

        const tr = document.createElement('tr');
        const tdSwitch = document.createElement('td');
        const labelSwitch = document.createElement('label');
        const inputCheckbox = document.createElement('input');
        const spanSlider = document.createElement('span');

        const tdTitle = document.createElement('td');
        const tdQtd = document.createElement('td');
        const inputQtd = document.createElement('input');
        const divQtd = document.createElement('div');
        const divFocus = document.createElement('div');
        const divColFocus = document.createElement('div');

        // Start: switch checkbox
        inputCheckbox.type = 'checkbox';
        inputCheckbox.className = `input-switch input-switch-${data[i].recurso_id}`;
        inputCheckbox.setAttribute('data-index', data[i].recurso_id);
        spanSlider.className = 'slider round';
        labelSwitch.className = 'switch';
        labelSwitch.append(inputCheckbox, spanSlider);
        // End: switch checkbox
        tdSwitch.append(labelSwitch);

        //Start: título
        tdTitle.className = 'cell-ta';
        tdTitle.innerHTML = data[i].recurso_nome;

        //Start: input quantidade
        inputQtd.type = 'number';
        inputQtd.className = `prompt srch_explore input-qtd-${data[i].recurso_id}`;
        inputQtd.id = data[i].recurso_id;
        inputQtd.setAttribute('value', '1');
        inputQtd.min = '1';
        inputQtd.max = '500';
        divQtd.className = 'ui left icon input swdh19';
        divQtd.append(inputQtd);
        divFocus.className = 'ui search focus lbel25';
        divFocus.append(divQtd);
        divColFocus.className = 'col-md-12';
        divColFocus.append(divFocus);
        tdQtd.className = 'cell-ta';
        tdQtd.append(divColFocus);
        //End: input quantidade

        tr.append(tdSwitch, tdTitle, tdQtd);
        tr.className = `page${pageItem} page`;
        tbody.append(tr);
    }
    //end: tbody

    listItem.append(thead, tbody);
    //exibe a primeira página
    showPage(0);
    answersIndicator();
}

/**
 * @lacy_
 * exibe o modal para editar recurso
 * @param data -> array de informações do recurso
 */
function showModalEditResource(data) {
    const recurso_id = document.querySelector('.recurso_id_edit');
    const recurso_nome = document.querySelector('.recurso_nome_edit');

    recurso_id.setAttribute('value', data.recurso_id);
    recurso_nome.setAttribute('value', data.recurso_nome);
    $('#modal-edit-resource').modal('show');
}

/**
 * @lacy_
 * editar recurso
 */
function updateResource() {
    var state = document.querySelector('.edit-state');
    var button = document.getElementById('editResource');
    var form = $('#formEdit').serializeArray();

    state.innerHTML = `<img class="spiner" src="${URL}/theme/assets/images/loader.svg"/> Aguarde`;
    button.setAttribute('disabled', '');
    button.classList.add('hover');

    $.ajax({
        url: URL + '/updateResource',
        data: form,
        type: 'POST',
        dataType: 'json',
        success: function (response) {
            // texto do botão
            state.innerHTML = 'Salvar';
            //desabilita o botão
            button.removeAttribute('disabled');
            if (response.success) {
                // fecha modal de edição
                modalClose('modal-edit-resource');

                notificationSuccess(response.message);
                //chamada para atualizar a lista de recursos
                resourceList()
            } else {
                notificationWarning(response.message);
            }
        },
        complete: function () {

        }
    });
}

/**
 * @lacy_
 * editar recurso
 */
function createNewResource() {
    var state = document.querySelector('.create-state');
    var button = document.getElementById('createResource');
    var form = $('#formCreate').serializeArray();

    state.innerHTML = `<img class="spiner" src="${URL}/theme/assets/images/loader.svg"/> Aguarde`;
    button.setAttribute('disabled', '');
    button.classList.add('hover');

    $.ajax({
        url: URL + '/createNewResource',
        data: form,
        type: 'POST',
        dataType: 'json',
        success: function (response) {
            // texto do botão
            state.innerHTML = 'Salvar';
            //desabilita o botão
            button.removeAttribute('disabled');
            if (response.success) {
                // fecha modal de edição
                modalClose('modal-create-resource');

                notificationSuccess(response.message);
                //chamada para atualizar a lista de recursos
                resourceList()
            } else {
                notificationWarning(response.message);
            }
        },
        complete: function () {

        }
    });
}
/**---------------------------------------------------------- */
/**----------- End: GERENCIAMENTO DE RECURSOS --------------- */
/**---------------------------------------------------------- */

/**---------------------------------------------------------- */
/**----------- Start: GERENCIAMENTO DE SALAS --------------- */
/**---------------------------------------------------------- */

/**
 * @lacy_
 * cria nova sala
 */
function createRoom() {
    arrayChecked = [];
    var sala_nome = $("input[name='sala_nome']").val();
    //recupera todos os toggle switch marcados
    document.querySelectorAll(`.input-switch`).forEach(item => item.checked ? arrayChecked.push({
        'sala_recurso_recurso_id': JSON.parse(item.getAttribute('data-index'))
    }) : '');


    if (arrayChecked.length > 0 && sala_nome != '') {
        var state = document.querySelector('.state');
        var button = document.getElementById('addRoom');

        for (var i = 0; i < arrayChecked.length; i++) {
            //recupera todo o obj ligado a esta classe
            var inputSwitch = document.querySelector(`.input-qtd-${arrayChecked[i].sala_recurso_recurso_id}`);
            arrayChecked[i].sala_recurso_recurso_id = inputSwitch.id;
            arrayChecked[i].qtd_recurso = inputSwitch.value;
        }

        state.innerHTML = `<img class="spiner" src="${URL}/theme/assets/images/loader.svg"/> Aguarde`;
        button.setAttribute('disabled', '');
        button.classList.add('hover');

        $.ajax({
            url: URL + '/createNewRoom',
            data: {
                'sala_nome': sala_nome,
                'data_recurso': arrayChecked
            },
            type: 'POST',
            dataType: 'json',
            success: function (response) {
                console.log(response);
                // texto do botão
                state.innerHTML = 'Salvar';
                //desabilita o botão
                button.removeAttribute('disabled');
                if (response.success) {
                    notificationSuccess(response.message);
                    setInterval(() => {
                        window.location.href = response.redirect;
                    }, 500);
                    //chamada para atualizar a lista de recursos
                    resourceList()
                } else {
                    notificationWarning(response.message);
                }
            },
            complete: function () {

            }
        });
    } else {
        if (arrayChecked.length == 0 && sala_nome == '') {
            notificationWarning('Preencha o nome da sala e adicione os recursos!');
        } else if (arrayChecked.length == 0) {
            notificationWarning('Adicione pelo menos um recurso!');
        } else {
            notificationWarning('Preencha o nome da sala!');
        }
    }
}

/**
 * @lacy_
 * requisição da lista de salas
 */
function roomList() {
    $.ajax({
        url: URL + '/manageRooms',
        type: 'POST',
        dataType: 'json',
        success: function (response) {

            answersIndicatorContainer.classList.add('hidden');
            listItem.innerHTML = '';
            messageResult.classList.add('hidden');
            if (response.length > 0) {
                answersIndicatorContainer.classList.remove('hidden');
                showRooms(response);
            } else {
                answersIndicatorContainer.classList.add('hidden');
                messageResult.classList.remove('hidden');
            }
        }
    });

    return false
}

/**
 * @lacy_
 * lista as salas abertas para reserva
 */
function listAllOpenRooms() {
    $.ajax({
        url: URL + '/manageRoomReservations',
        type: 'POST',
        dataType: 'json',
        success: function (response) {
            answersIndicatorContainer.classList.add('hidden');
            listItem.innerHTML = '';
            messageResult.classList.add('hidden');
            if (response.length > 0) {
                answersIndicatorContainer.classList.remove('hidden');
                showRoomsReservation(response);
                // console.log(response);
            } else {
                answersIndicatorContainer.classList.add('hidden');
                messageResult.classList.remove('hidden');
            }
        }
    });

    return false
}

/**
 * @lacy_
 * exibe a lista de salas
 * $data -> array de recursos
 */
function showRooms(data) {

    let count = 0;
    pageItem = 1;

    const thead = document.createElement('thead');
    const trHeader = document.createElement('tr');
    const thTitle = document.createElement('th');
    const thStatus = document.createElement('th');
    const thDate = document.createElement('th');
    const thOption = document.createElement('th');
    const tbody = document.createElement('tbody');

    //start: header table
    //Start: Título
    thTitle.setAttribute('scope', 'col');
    thTitle.innerHTML = 'Nome';
    //End: Título
    //Start: Status
    thStatus.setAttribute('scope', 'col');
    thStatus.innerHTML = 'Status';
    //End: Status
    //Start: data criação
    thDate.setAttribute('scope', 'col');
    thDate.className = 'text-center';
    thDate.innerHTML = 'Data Criação';
    //End: data criação
    //Start: Opção
    thOption.setAttribute('scope', 'col');
    thOption.className = 'text-center';
    thOption.innerHTML = 'Opção';
    //End: Opção
    trHeader.append(thTitle, thStatus, thDate, thOption);
    thead.className = 'thead-s';
    thead.append(trHeader);
    //end: header table

    //start: tbody
    for (var i = 0; i < data.length; i++) {
        /**
         * determina a quantidade de itens por página,
         * os itens que serão exibidos em uma página, recebem a class .page${pageItem}, sendo ${pageItem}
         * o índice da página
         */
        if (count == 8) {
            pageItem += 1;
            count = 0;
        }

        count += 1;

        const tr = document.createElement('tr');
        const tdTitle = document.createElement('td');
        const tdStatus = document.createElement('td');
        const tdDate = document.createElement('td');
        const tdButton = document.createElement('td');
        //somente contantes de botões
        const ulOptions = document.createElement('ul');
        const liView = document.createElement('li');
        const aView = document.createElement('a');
        const liEdit = document.createElement('li');
        const aEdit = document.createElement('a');
        const liStatus = document.createElement('li');
        const aStatus = document.createElement('a');

        // Start: Nome da sala
        tdTitle.innerHTML = data[i].sala_nome;
        // End: Nome da sala
        // Start: Status
        tdStatus.innerHTML = data[i].sala_status;
        // End: Status

        tdDate.innerHTML = data[i].data_criacao;
        tdDate.className = 'text-center';

        //botões de opções
        ulOptions.className = 'button-zoom text-center';
        // botão view
        aView.className = 'st';
        aView.title = 'Ver Sala'
        aView.setAttribute('onclick', `roomDetails(${JSON.stringify(data[i])})`);
        aView.innerHTML = '<i class="fla-1x flaticon-eye icon-12pt"></i>';
        liView.append(aView);
        // botão edit
        aEdit.className = 'fb';
        aEdit.title = 'Editar';
        aEdit.setAttribute('onclick', `redirectToEditRoom(${JSON.stringify(data[i])})`);
        aEdit.innerHTML = '<i class="fla-1x flaticon-edit icon-12pt"></i>';
        liEdit.append(aEdit);
        //botão status


        if (data[i].sala_status == 'Aberta') {
            aStatus.className = 'yu';
            aStatus.title = 'Fechar';
            aStatus.innerHTML = '<i class="fla-1x flaticon-ban icon-12pt"></i>';
        } else {
            aStatus.className = 'wz';
            aStatus.title = 'Abrir';
            aStatus.innerHTML = '<i class="fla-1x flaticon-draw-check-mark icon-12pt"></i>';
        }

        aStatus.setAttribute('onclick', `changeRoomStatus(${JSON.stringify(data[i])})`);
        liStatus.append(aStatus);

        ulOptions.append(liView, liEdit, liStatus);
        tdButton.append(ulOptions);

        tr.append(tdTitle, tdStatus, tdDate, tdButton);
        tr.className = `page${pageItem} page`;
        tbody.append(tr);
    }
    //end: tbody

    listItem.append(thead, tbody);
    //exibe a primeira página
    showPage(0);
    answersIndicator();
}

/**
 * @lacy_
 * exibe a lista de salas
 * $data -> array de recursos
 */
function showRoomsReservation(data) {

    let count = 0;
    pageItem = 1;

    const thead = document.createElement('thead');
    const trHeader = document.createElement('tr');
    const thTitle = document.createElement('th');
    const thStatus = document.createElement('th');
    const thDate = document.createElement('th');
    const thOption = document.createElement('th');
    const tbody = document.createElement('tbody');

    //start: header table
    //Start: Título
    thTitle.setAttribute('scope', 'col');
    thTitle.innerHTML = 'Nome';
    //End: Título
    //Start: Status
    thStatus.setAttribute('scope', 'col');
    thStatus.innerHTML = 'Status';
    //End: Status
    //Start: data criação
    thDate.setAttribute('scope', 'col');
    thDate.className = 'text-center';
    thDate.innerHTML = 'Data Criação';
    //End: data criação
    //Start: Opção
    thOption.setAttribute('scope', 'col');
    thOption.className = 'text-center';
    thOption.innerHTML = 'Opção';
    //End: Opção
    trHeader.append(thTitle, thStatus, thDate, thOption);
    thead.className = 'thead-s';
    thead.append(trHeader);
    //end: header table

    //start: tbody
    for (var i = 0; i < data.length; i++) {
        /**
         * determina a quantidade de itens por página,
         * os itens que serão exibidos em uma página, recebem a class .page${pageItem}, sendo ${pageItem}
         * o índice da página
         */
        if (count == 8) {
            pageItem += 1;
            count = 0;
        }

        count += 1;

        const tr = document.createElement('tr');
        const tdTitle = document.createElement('td');
        const tdStatus = document.createElement('td');
        const tdDate = document.createElement('td');
        const tdButton = document.createElement('td');
        //somente contantes de botões
        const ulOptions = document.createElement('ul');
        const liView = document.createElement('li');
        const aView = document.createElement('a');
        const liResources = document.createElement('li');
        const aResources = document.createElement('a');
        const liAdd = document.createElement('li');
        const aAdd = document.createElement('a');

        // Start: Nome da sala
        tdTitle.innerHTML = data[i].sala_nome;
        // End: Nome da sala
        // Start: Status
        tdStatus.innerHTML = data[i].sala_status;
        // End: Status

        tdDate.innerHTML = data[i].data_criacao;
        tdDate.className = 'text-center';

        //botões de opções
        ulOptions.className = 'button-zoom text-center';
        // botão view
        aView.className = 'st';
        aView.title = 'Ver reservas'
        aView.setAttribute('onclick', `detailReservations(${JSON.stringify(data[i])})`);
        aView.innerHTML = '<i class="fla-1x flaticon-eye icon-12pt"></i>';
        liView.append(aView);
        // botão resources
        aResources.className = 'fb';
        aResources.title = 'Consultar recursos';
        aResources.setAttribute('onclick', `showsReserveResources(${JSON.stringify(data[i])})`);
        aResources.innerHTML = '<i class="fla-1x flaticon-box-1 icon-12pt"></i>';
        liResources.append(aResources);
        // botão adicionar reserva
        aAdd.className = 'tw';
        aAdd.title = 'Nova Reserva';
        aAdd.setAttribute('onclick', `formCreateReservation(${JSON.stringify(data[i])})`);
        aAdd.innerHTML = '<i class="fla-1x flaticon-plus icon-12pt"></i>';
        liAdd.append(aAdd);

        ulOptions.append(liView, liResources, liAdd);
        tdButton.append(ulOptions);

        tr.append(tdTitle, tdStatus, tdDate, tdButton);
        tr.className = `page${pageItem} page`;
        tbody.append(tr);
    }
    //end: tbody

    listItem.append(thead, tbody);
    //exibe a primeira página
    showPage(0);
    answersIndicator();
}

/**
 * @lacy_
 * categoria de detalhes
 * obj -> objeto com detalhes da sala
 */
function roomDetails(obj) {
    var data = obj.resource_list;

    colTable.classList.remove('col-lg-12');
    colTable.classList.add('col-lg-7');
    colView.classList.remove('hidden');

    //título recurso

    titleResource.innerHTML = obj.sala_nome;
    titleResource.setAttribute('index-room', obj.sala_id);

    reloadRoomResources(data);
}

/**
 * @lacy_
 * atualiza a lista de recursos
 * data -> array de recursos
 */
function reloadRoomResources(data) {
    listResource.innerHTML = '';
    //start: tbody
    for (var i = 0; i < data.length; i++) {
        //linha 
        const tr = document.createElement('tr');

        //toggle switch
        const tdSwitch = document.createElement('td');
        const labelSwitch = document.createElement('label');
        const inputCheckbox = document.createElement('input');
        const spanSlider = document.createElement('span');
        //nome recurso
        const tdTitle = document.createElement('td');
        //quantidade recursos
        const tdQtd = document.createElement('td');

        // Start: switch checkbox
        inputCheckbox.type = 'checkbox';
        inputCheckbox.className = 'input-switch';
        inputCheckbox.setAttribute('data-obj', `${data[i].sala_recurso_id}`);
        spanSlider.className = 'slider round';
        labelSwitch.className = 'switch';
        labelSwitch.append(inputCheckbox, spanSlider);
        // End: switch checkbox
        tdSwitch.append(labelSwitch);
        //nome recurso
        tdTitle.innerHTML = data[i].recurso_nome;
        //qtd de recursos
        tdQtd.innerHTML = data[i].qtd_recurso;
        tr.append(tdSwitch, tdTitle, tdQtd);
        listResource.append(tr);
    }
    //end: tbody
}

/**
 * @lacy_ 
 * exibe o modal de validação do usuário
 */
function validateUser() {
    arrayChecked = [];
    //recupera todos os toggle switch marcados
    const optionCheckbox = document.querySelectorAll('.input-switch');
    //guarda arrayChecked o objeto ligado ao toggle switch marcado
    optionCheckbox.forEach(item => item.checked ? arrayChecked.push(JSON.parse(item.getAttribute('data-obj'))) : '');

    if (arrayChecked.length > 0) {
        $('#modal-validation').modal('show');
    } else {
        notificationWarning('Primeiro selecione um recurso para remover!');
    }
}

/**
 * @lacy_
 * apaga 1 ou mais registros de rede
 */
function removeResource() {

    var state = document.querySelector('.state-remove');
    var button = document.getElementById('buttonConfirme');

    var senha = $("input[name='senha']").val();
    var md5 = $.md5(senha);

    if (md5 == dataUser.senha) {
        state.innerHTML = `<img class="spiner" src="${URL}/theme/assets/images/loader.svg"/> Aguarde`;
        button.setAttribute('disabled', '');
        button.classList.add('hover');

        arrayChecked = [];
        //recupera todos os toggle switch marcados
        const optionCheckbox = document.querySelectorAll('.input-switch');
        //guarda arrayChecked o objeto ligado ao toggle switch marcado
        optionCheckbox.forEach(item => item.checked ? arrayChecked.push(JSON.parse(item.getAttribute('data-obj'))) : '');

        $.ajax({
            url: URL + '/removeRoomResources',
            type: 'POST',
            data: {
                arrayChecked
            },
            dataType: 'json',
            success: function (response) {
                senha.innerHTML = '';
                // texto do botão
                state.innerHTML = 'Confirmar';
                //desabilita o botão
                button.removeAttribute('disabled');
                if (response.success) {
                    //fecha o modal de validação
                    $('#modal-validation').modal('toggle');
                    notificationSuccess(response.message);
                    //atualiza os recursos da sala
                    searchResourcesRoom();
                    //atualiza as salas
                    roomList();
                } else {
                    notificationError(response.message);
                }
            }
        });
    } else {
        notificationError('Senha inválida!');
    }
}

/**
 * @lacy_
 * requisição para trazer os recursos da sala
 */
function searchResourcesRoom() {
    $.ajax({
        url: URL + '/roomResourcesList',
        type: 'POST',
        data: {
            'sala_id': titleResource.getAttribute('index-room')
        },
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (response.length > 0) {
                reloadRoomResources(response);
            }
        }
    });

    return false
}

/**
 * @lacy_
 * redireciona para página de edição de sala
 * obj -> com informações de uma sala
 */
function redirectToEditRoom(obj) {
    //remove do cache a o nome da página anterior
    localStorage.removeItem('session-room');
    //adiciona no cache o nome da página selecionada
    localStorage.setItem('session-room', `${JSON.stringify(obj)}`);
    window.location.href = URL + '/edit-room';
}

/**
 * @lacy_
 * redireciona para página de edição de sala
 */
function setInfoToEditRoom() {
    //recupera a lista de recursos marcados anteriormente
    var listResource = dataRoom.resource_list;
    //seta o nome da sala
    salaNome.setAttribute('value', dataRoom.sala_nome);

    for (var i = 0; i < listResource.length; i++) {
        //recupera a lista com todos os recursos
        document.querySelectorAll('.input-switch').forEach(item => item.getAttribute('data-index') == listResource[i].recurso_id ? setResourceInfo(item, listResource[i]) : '');
    }
}

/**
 * @lacy_
 * seta a informação individual de um recurso da sala
 * obj -> objeto html de recurso
 * objPosition -> posição do recurso no array de seção
 */
function setResourceInfo(obj, objPosition) {
    const qtdObj = document.querySelector(`.input-qtd-${obj.getAttribute('data-index')}`);
    //checked o recurso escolhido anteriormente
    obj.setAttribute('checked', true);
    //seta a quantidade de recursos
    qtdObj.setAttribute('value', objPosition.qtd_recurso);
}

/**
 * @lacy_
 * 
 */
function updateRoom() {
    arrayChecked = [];
    //array para criar novos recursos
    arrayCreate = [];
    //array para atualizar recursos
    arrayUpdate = [];
    //array para excluir recursos
    arrayDelete = [];

    //recupera a lista de recursos marcados anteriormente
    var arrayResource = dataRoom.resource_list;

    //informações de gif e botão
    var state = document.querySelector('.state');
    var button = document.getElementById('editRoom');

    var sala_id = dataRoom.sala_id;
    var sala_nome = $("input[name='sala_nome']").val();

    //recupera todos os toggle switch marcados
    document.querySelectorAll(`.input-switch`).forEach(item => item.checked ? arrayChecked.push({
        'sala_recurso_recurso_id': JSON.parse(item.getAttribute('data-index'))
    }) : '');

    //acrescenta as informações no array de recursos selecionados
    for (var i = 0; i < arrayChecked.length; i++) {
        //recupera todo o obj ligado a esta classe
        var inputSwitch = document.querySelector(`.input-qtd-${arrayChecked[i].sala_recurso_recurso_id}`);
        arrayChecked[i].sala_recurso_recurso_id = inputSwitch.id;
        arrayChecked[i].qtd_recurso = inputSwitch.value;
    }

    //ordena array de recursos marcados na ordem crescente de sala_recurso_recurso_id
    arrayChecked.sort(function (a, b) {
        return a.sala_recurso_recurso_id < b.sala_recurso_recurso_id ? -1 : a.sala_recurso_recurso_id > b.sala_recurso_recurso_id ? 1 : 0;
    });

    arrayResource.sort(function (a, b) {
        return a.recurso_id < b.recurso_id ? -1 : a.recurso_id > b.recurso_id ? 1 : 0;
    });

    // retorna a diferença
    let difference = arrayChecked.filter(salaRecurso => !arrayResource.filter(recurso => recurso.recurso_id === salaRecurso.sala_recurso_recurso_id).length);
    // retorna a igualdade
    let equality = arrayChecked.filter(salaRecurso => arrayResource.filter(recurso => recurso.recurso_id === salaRecurso.sala_recurso_recurso_id).length);
    // retorna o que deve ser apagado
    let toRemove = arrayResource.filter(recurso => !arrayChecked.filter(salaRecurso => salaRecurso.sala_recurso_recurso_id === recurso.recurso_id).length);

    //array para atualizar recursos
    for (var i = 0; i < equality.length; i++) {
        if (equality[i].qtd_recurso != arrayResource[i].qtd_recurso) {
            arrayUpdate.push({
                'sala_recurso_id': arrayResource[i].sala_recurso_id,
                'qtd_recurso': equality[i].qtd_recurso
            });
        }
    }
    //array para inserir novos recursos
    for (var i = 0; i < difference.length; i++) {
        arrayCreate.push({
            'sala_recurso_sala_id': dataRoom.sala_id,
            'sala_recurso_recurso_id': difference[i].sala_recurso_recurso_id,
            'qtd_recurso': difference[i].qtd_recurso
        });
    }

    //array para apagar recursos
    for (var i = 0; i < toRemove.length; i++) {
        arrayDelete.push(toRemove[i].sala_recurso_id);
    }

    state.innerHTML = `<img class="spiner" src="${URL}/theme/assets/images/loader.svg"/> Aguarde`;
    button.setAttribute('disabled', '');
    button.classList.add('hover');

    $.ajax({
        url: URL + '/updateRoom',
        data: {
            'sala_id': sala_id,
            'sala_nome': sala_nome,
            'data_update': arrayUpdate,
            'data_create': arrayCreate,
            'data_delete': arrayDelete
        },
        type: 'POST',
        dataType: 'json',
        success: function (response) {
            console.log(response);
            // texto do botão
            state.innerHTML = 'Salvar';
            //desabilita o botão
            button.removeAttribute('disabled');
            if (response.success) {
                notificationSuccess(response.message);
                //destroy a sessão de edição da sala
                localStorage.removeItem('session-room');
                setInterval(() => {
                    window.location.href = response.redirect;
                }, 500);
            } else {
                notificationWarning(response.message);
            }
        },
        complete: function () {

        }
    });
}

/**
 * @lacy_
 * altera o status da sala
 * A -> para aberta
 * F -> para fechada
 * @param {*} data -> array com a publicação original e suas traduções 
 */
function changeRoomStatus(data) {
    var status = data.sala_status == 'Aberta' ? 'F' : 'A';

    $.ajax({
        url: URL + '/updateRoom',
        type: "POST",
        data: {
            'sala_id': data.sala_id,
            'sala_status': status
        },
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (response.success) {
                var messageStatus = data.sala_status == 'Aberta' ? 'Fechada!' : 'Aberta!';
                notificationSuccess(`Sala ${messageStatus}`);
                roomList();
            } else {
                notificationError(response.message);
            }
        },
        complete: function () {

        }
    });
}
/**---------------------------------------------------------- */
/**----------- End: GERENCIAMENTO DE SALAS ------------------ */
/**---------------------------------------------------------- */

/**---------------------------------------------------------- */
/**----------- Start: GERENCIAMENTO DE RESERVAS --------------- */
/**---------------------------------------------------------- */
/**
 * @lacy_
 * requisição da lista de reservas de um usuário
 */
function userReservationList() {
    $.ajax({
        url: URL + '/listAllUserReservations',
        type: 'POST',
        data: {
            'usuario_id': dataUser.usuario_id
        },
        dataType: 'json',
        success: function (response) {
            console.log(response);
            answersIndicatorContainer.classList.add('hidden');
            listItem.innerHTML = '';
            messageResult.classList.add('hidden');
            if (response.length > 0) {
                answersIndicatorContainer.classList.remove('hidden');
                showReservations(response);
            } else {
                answersIndicatorContainer.classList.add('hidden');
                messageResult.classList.remove('hidden');
            }
        }
    });

    return false
}

/**
 * @lacy_
 * exibe a lista de reservas
 * $data -> array de reservas
 */
function showReservations(data) {
    let count = 0;
    pageItem = 1;

    const thead = document.createElement('thead');
    const trHeader = document.createElement('tr');
    const thTitle = document.createElement('th');
    const thStatus = document.createElement('th');
    const thDateStart = document.createElement('th');
    const thDateFinal = document.createElement('th');
    const thDate = document.createElement('th');
    const thOption = document.createElement('th');
    const tbody = document.createElement('tbody');

    //start: header table
    //Start: Título
    thTitle.setAttribute('scope', 'col');
    thTitle.innerHTML = 'Sala';
    //End: Título
    //Start: Status
    thStatus.setAttribute('scope', 'col');
    thStatus.innerHTML = 'Status';
    //End: Status
    //Start: data início
    thDateStart.setAttribute('scope', 'col');
    thDateStart.className = 'text-center';
    thDateStart.innerHTML = 'Início';
    //End: data início
    //Start: data término
    thDateFinal.setAttribute('scope', 'col');
    thDateFinal.className = 'text-center';
    thDateFinal.innerHTML = 'Término';
    //End: data término
    thDate.setAttribute('scope', 'col');
    thDate.className = 'text-center';
    thDate.innerHTML = 'Data Criação';
    //End: data criação
    //Start: Opção
    thOption.setAttribute('scope', 'col');
    thOption.className = 'text-center';
    thOption.innerHTML = 'Opção';
    //End: Opção
    trHeader.append(thTitle, thStatus, thDateStart, thDateFinal, thDate, thOption);
    thead.className = 'thead-s';
    thead.append(trHeader);
    //end: header table

    //start: tbody
    for (var i = 0; i < data.length; i++) {
        /**
         * determina a quantidade de itens por página,
         * os itens que serão exibidos em uma página, recebem a class .page${pageItem}, sendo ${pageItem}
         * o índice da página
         */
        if (count == 8) {
            pageItem += 1;
            count = 0;
        }

        count += 1;

        const tr = document.createElement('tr');
        const tdTitle = document.createElement('td');
        const tdStatus = document.createElement('td');
        const tdDateStart = document.createElement('td');
        const tdDateFinal = document.createElement('td');
        const tdDate = document.createElement('td');
        const tdButton = document.createElement('td');
        //somente contantes de botões
        const ulOptions = document.createElement('ul');
        const liView = document.createElement('li');
        const aView = document.createElement('a');
        const liCancel = document.createElement('li');
        const aCancel = document.createElement('a');

        // Start: Nome da sala
        tdTitle.innerHTML = data[i].sala_nome;
        // End: Nome da sala
        // Start: Status
        tdStatus.innerHTML = data[i].status_escrito;
        // End: Status

        //início da reserva
        tdDateStart.innerHTML = data[i].reserva_inicia;
        tdDateStart.className = 'text-center';

        //fim da reserva
        tdDateFinal.innerHTML = data[i].reserva_fim;
        tdDateFinal.className = 'text-center';
        //data crição
        tdDate.innerHTML = data[i].data_criacao;
        tdDate.className = 'text-center';

        //botões de opções
        ulOptions.className = 'button-zoom text-center';
        // botão view
        aView.className = 'st';
        aView.title = 'Ver Sala'
        aView.setAttribute('onclick', `showsReserveResources(${JSON.stringify(data[i])})`);
        aView.innerHTML = '<i class="fla-1x flaticon-eye icon-12pt"></i>';
        liView.append(aView);
        // botão edit
        aCancel.className = 'yu';
        aCancel.title = 'Cancelar Reserva';
        aCancel.setAttribute('onclick', `cancelReservation(${JSON.stringify(data[i])})`);
        aCancel.innerHTML = '<i class="fla-1x flaticon-close icon-12pt"></i>';
        liCancel.append(aCancel);
        //botão status

        //verifica se o usuário ainda pode cancelar a reserva

        if ((data[i].permission_cancel) && data[i].usuario_sala_status == 'R') {
            ulOptions.append(liView, liCancel);
        } else {
            ulOptions.append(liView);
        }

        tdButton.append(ulOptions);
        tr.append(tdTitle, tdStatus, tdDateStart, tdDateFinal, tdDate, tdButton);
        tr.className = `page${pageItem} page`;
        tbody.append(tr);
    }
    //end: tbody

    listItem.append(thead, tbody);
    //exibe a primeira página
    showPage(0);
    answersIndicator();
}

/**
 * @lacy_
 * exibe os recursos de uma sala reservada
 * obj -> objeto com as informações da sala
 */
function showsReserveResources(obj) {

    var data = obj.resource_list;

    colTable.classList.remove('col-lg-12');
    colTable.classList.add('col-lg-7');
    colView.classList.remove('hidden');

    listResource.innerHTML = '';
    //título recurso
    titleResource.innerHTML = obj.sala_nome;
    typeList.innerHTML = 'Lista de Recursos';
    titleResource.setAttribute('index-room', obj.sala_id);

    const thead = document.createElement('thead');
    const trHeader = document.createElement('tr');
    const thTitle = document.createElement('th');
    const thQtd = document.createElement('th');
    const tbody = document.createElement('tbody');

    //start: header table
    //Start: Título
    thTitle.setAttribute('scope', 'col');
    thTitle.innerHTML = 'Sala';
    //End: Título
    //Start: Status
    thQtd.setAttribute('scope', 'col');
    thQtd.innerHTML = 'Quantidade';
    //End: Status
    trHeader.append(thTitle, thQtd);
    thead.className = 'thead-s';
    thead.append(trHeader);
    //end: header table

    //start: tbody
    for (var i = 0; i < data.length; i++) {
        //linha
        const tr = document.createElement('tr');
        //nome recurso
        const tdTitle = document.createElement('td');
        //quantidade recursos
        const tdQtd = document.createElement('td');

        //nome recurso
        tdTitle.innerHTML = data[i].recurso_nome;
        //qtd de recursos
        tdQtd.innerHTML = data[i].qtd_recurso;
        tr.append(tdTitle, tdQtd);
        tbody.append(tr);
    }
    //end: tbody

    listResource.append(thead, tbody);
}

/**
 * @lacy_
 * cancela reserva de um usuário
 * obj -> objeto com as informações da reserva
 */
function cancelReservation(obj) {
    buttonConfirme.setAttribute('onclick', `confirmeCancel(${JSON.stringify(obj)})`);
    $('#modal-validation').modal('show');
}

/**
 * @lacy_
 * confirmação do cancelamento
 * @param {*} obj -> com informações da reserva
 */
function confirmeCancel(obj) {
    console.log(obj);
    var state = document.querySelector('.state-remove');
    var button = document.getElementById('buttonConfirme');

    var senha = $("input[name='senha']").val();
    var md5 = $.md5(senha);

    if (md5 == dataUser.senha) {

        var status = obj.usuario_sala_status == 'R' ? 'C' : 'R';

        state.innerHTML = `<img class="spiner" src="${URL}/theme/assets/images/loader.svg"/> Aguarde`;
        button.setAttribute('disabled', '');
        button.classList.add('hover');


        $.ajax({
            url: URL + '/updateRoomReservation',
            type: 'POST',
            data: {
                'usuario_sala_id': obj.usuario_sala_id,
                'usuario_sala_status': status
            },
            dataType: 'json',
            success: function (response) {
                senha.innerHTML = '';
                // texto do botão
                state.innerHTML = 'Confirmar';
                //desabilita o botão
                button.removeAttribute('disabled');
                if (response.success) {
                    //fecha o modal de validação
                    $('#modal-validation').modal('toggle');
                    notificationSuccess(response.message);
                    //atualiza a lista de reservas
                    userReservationList();
                } else {
                    notificationError(response.message);
                }
            }
        });
    } else {
        notificationError('Senha inválida!');
    }
}

/**
 * @lacy_
 * verifica se a data está disponível
 * field -> data que está sendo verificada, pode ser de inicio (I) ou de reserva (F)
 */
function checkDateAvailability(field) {

    var data = field == 'I' ? $("input[name='reserva_inicia']").val() : $("input[name='reserva_fim']").val();

    var string = field == 'I' ? 'Data início': 'Data término';

    var dataUser = data.split('T');

    if (data != '') {
        $.ajax({
            url: URL + '/checkDateAvailability',
            data: {
                'data_user': dataUser[0] + ' ' + dataUser[1]
            },
            type: 'POST',
            dataType: 'json',
            success: function (response) {
                // console.log(response);
                if (response.success) {
                    notificationSuccess(string + ' ' + response.message);
                } else {
                    notificationWarning(string + ' ' + response.message);
                }
            },
            complete: function () {

            }
        });
    }
}

/**
 * @lacy_
 * verifica se a data está disponível retornando o resultado
 * field -> data que está sendo verificada, pode ser de inicio (I) ou de reserva (F)
 */
function checkDateAvailabilityReturn(field) {

    var data = field == 'I' ? $("input[name='reserva_inicia']").val() : $("input[name='reserva_fim']").val();

    var dataUser = data.split('T');

    var message;

    if (data != '') {
        $.ajax({
            url: URL + '/checkDateAvailability',
            data: {
                'data_user': dataUser[0] + ' ' + dataUser[1]
            },
            type: 'POST',
            dataType: 'json',
            async: false,
            success: function (response) {
                message = response;
            },
        });
    }

    return message;
}

/**
 * @lacy_
 * cria reserva de sala
 */
function createReservation(){
    var state = document.querySelector('.state');
    var button = document.getElementById('addReservation');
    var form = $('#formReservation').serializeArray();

    //verifica se a data de inicio e fim foram preenchidas
    if(form[2].value != '' && form[3].value != ''){

        var dip1 = checkDateAvailabilityReturn('I');
        var dip2 = checkDateAvailabilityReturn('F');

        if(dip1.success == true && dip2.success == true){
            state.innerHTML = `<img class="spiner" src="${URL}/theme/assets/images/loader.svg"/> Aguarde`;
            button.setAttribute('disabled', '');
            button.classList.add('hover');
        
            $.ajax({
                url: URL + '/createRoomReservation',
                data: form,
                type: 'POST',
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    // texto do botão
                    state.innerHTML = 'Salvar';
                    //desabilita o botão
                    button.removeAttribute('disabled');
                    if (response.success) {
                        notificationSuccess(response.message);
                        //chamada para atualizar a lista de recursos
                        setInterval(() => {
                            window.location.href = response.redirect;
                        }, 500);
                    } else {
                        notificationWarning(response.message);
                    }
                },
            });
        }else{
            if (!dip1.success && !dip2.success) {
                notificationWarning(`Você tem a data início ${dip1.message} e a data término ${dip2.message}!`);
            } else if (!dip1.success) {
                notificationWarning(`Você tem a data início ${dip1.message}`);
            } else {
                notificationWarning(`Você tem a data início ${dip2.message}`);
            }
        }
    }else{
        if (form[2].value == '' && form[3].value == '') {
            notificationWarning('Preencha os campos data início e data término!');
        } else if (form[2].value == '') {
            notificationWarning('Preencha o campo data início!');
        } else {
            notificationWarning('Preencha o campo data término!');
        }
    }
}

/**
 * @lacy_
 * redireciona para o formulário que cria nova reserva
 * obj -> array com as informações da sala
 */
function formCreateReservation(obj){
    //remove do cache a o nome da página anterior
    localStorage.removeItem('session-room');
    //adiciona no cache o nome da página selecionada
    localStorage.setItem('session-room', `${JSON.stringify(obj)}`);
    window.location.href = URL + '/new-reservation';
}

/**
 * @lacy_
 * exibe os detalhes de reservas
 * obj -> objeto com detalhes da sala
 */
 function detailReservations(obj) {
    var data = obj.reservation_list;

    colTable.classList.remove('col-lg-12');
    colTable.classList.add('col-lg-7');
    colView.classList.remove('hidden');

    //título recurso
    titleResource.innerHTML = obj.sala_nome;
    typeList.innerHTML = 'Lista de Reservas';

    if(data.length > 0){
        renderReserveList(data);
    }else{
        listReservation.innerHTML = `<div class="result_dt"><i class="fla flaticon-astronaut wrong_ans"></i> Esta sala não foi reservada.</div>`;
    }
}

/**
 * @lacy_
 * atualiza a lista de recursos
 * data -> array de recursos
 */
 function renderReserveList(data) {
    listReservation.innerHTML = '';

    const thead = document.createElement('thead');
    const trHeader = document.createElement('tr');
    const thTitle = document.createElement('th');
    const thStatus = document.createElement('th');
    const thDateStart = document.createElement('th');
    const thDateEnd = document.createElement('th');
    const tbody = document.createElement('tbody');

    //start: header table
    //Start: Nomo usuário
    thTitle.setAttribute('scope', 'col');
    thTitle.innerHTML = 'Nome';
    //End: Nome usuário
    //Start: status
    thStatus.setAttribute('scope', 'col');
    thStatus.innerHTML = 'Status';
    //End: status
    //Start: data criação
    thDateStart.setAttribute('scope', 'col');
    thDateStart.className = 'text-center';
    thDateStart.innerHTML = 'Data início';
    //End: data criação
    //Start: data criação
    thDateEnd.setAttribute('scope', 'col');
    thDateEnd.className = 'text-center';
    thDateEnd.innerHTML = 'Data término';
    //End: data criação
    trHeader.append(thTitle, thStatus, thDateStart, thDateEnd);
    thead.className = 'thead-s';
    thead.append(trHeader);
    //end: header table
    //start: tbody
    for (var i = 0; i < data.length; i++) {

        const tr = document.createElement('tr');
        const tdTitle = document.createElement('td');
        const tdStatus = document.createElement('td');
        const tdDateStart = document.createElement('td');
        const tdDateEnd = document.createElement('td');

        tdTitle.innerHTML = data[i].usuario_nome;
        tdStatus.innerHTML = data[i].status_escrito;
        tdDateStart.innerHTML = data[i].reserva_inicia;
        tdDateEnd.innerHTML = data[i].reserva_fim;

        tr.append(tdTitle, tdStatus, tdDateStart, tdDateEnd);
        tbody.append(tr);
    }
    //end: tbody

    listReservation.append(thead, tbody);
}


/**---------------------------------------------------------- */
/**----------- End: GERENCIAMENTO DE RESERVAS --------------- */
/**---------------------------------------------------------- */