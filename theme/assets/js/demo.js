const locationUrl = window.location.href.split('/');
//URL -> http://localhost/iot-network-planning
const URL = locationUrl[0] + '//' + locationUrl[2] + '/' + locationUrl[3];
//nome da página
const page = locationUrl[4] != '' ? locationUrl[4] : 'home';
//sessão de usuário
let dataUser = JSON.parse(localStorage.getItem('session-user'));
//nome do usuário
const nomeUser = document.querySelector('.perfil-name');
const emailUser = document.querySelector('.perfil-email');

type = ['', 'info', 'success', 'warning', 'danger'];

/**
 * @lacy_
 * ######### INICÍA AS FUNÇÕES PRINCIPAIS #########
 */
window.addEventListener('load', function () {
    //seta o nome do usuário logado
    if(nomeUser){
        nomeUser.innerHTML = dataUser.usuario_nome;
        emailUser.innerHTML = dataUser.email;

        if(dataUser.usuario_tipo == 'A'){
            document.querySelectorAll('.menu--admin').forEach(item => item.classList.remove('hidden'));
        }
    }

    if(localStorage.getItem('name-page') == 'null'){
        document.querySelectorAll('.menu--link').forEach(item => item.getAttribute('data-page') == 'home' ? item.classList.add('active') : item.classList.remove('active'));
    }else{
        document.querySelectorAll('.menu--link').forEach(item => item.getAttribute('data-page') == localStorage.getItem('name-page') ? item.classList.add('active') : item.classList.remove('active'));
    }
    //adiciona o evento de click nos items de página do sidebar
    itemPage();
});

/**
 * @lacy_
 * seta o evento de click nas step
 */
function itemPage() { 
    document.querySelectorAll('.menu--link').forEach(item => item.setAttribute('onclick', `markItem(this)`));
}

/**
 * @lacy_
 * seta cative na página com menu--link clicado
 */
function markItem(obj) {
    //remove do cache a o nome da página anterior
    localStorage.removeItem('name-page');
    //adiciona no cache o nome da página selecionada
    localStorage.setItem('name-page', `${obj.getAttribute('data-page')}`);
}