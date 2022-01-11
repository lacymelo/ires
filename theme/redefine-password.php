<?php $v->layout("_theme"); ?>

<!-- Signup Start -->
<div class="sign_in_up_bg">
    <div class="container">
        <div class="row justify-content-lg-center justify-content-md-center">
            <div class="col-lg-12">
                <div class="main_logo25" id="logo">
                    <a href="<?= url('/') ?>"><img src="<?= url('/theme/assets/images/logo-ires-preta.svg') ?>" alt="logo-ires"></a>
                    <a href="<?= url('/') ?>"><img src="<?= url('/theme/assets/images/logo-ires-clara.svg') ?>" class="logo-inverse" alt="logo-ires"></a>
                </div>
            </div>

            <div class="col-lg-6 col-md-8">
                <div class="sign_form">
                    <h2>REDEFINIR SENHA</h2>
                    <p>Por favor, preencha os campos solicitados!</p>
                    <form id="formRedefine" method="POST">
                        <input type="hidden" name="email" value="<?= $email ?>" />
                        <input type="hidden" name="key" value="<?= $key ?>" />

                        <div class="ui search focus mt-30 lbel25">
                            <label>Nova Senha*</label>
                            <div class="ui left icon input swdh19">
                                <input class="prompt srch_explore" type="password" name="senha" maxlength="10" title="Por favor, informe sua senha" placeholder="******">
                                <i class="fla flaticon-key icon icon2"></i>
                            </div>
                        </div>

                        <div class="ui search focus mt-30 lbel25">
                            <label>Confirmar Senha*</label>
                            <div class="ui left icon input swdh19">
                                <input class="prompt srch_explore" type="password" name="conf_senha" maxlength="10" title="Por favor, informe sua senha" placeholder="******">
                                <i class="fla flaticon-key icon icon2"></i>
                            </div>
                        </div>

                        <button class="login-btn" type="button" onclick="redefinePassword()"><span class='state'>Continue</span></button>
                    </form>
                    <p class="sgntrm145"><a href="<?= url('/request-recover') ?>">Esqueceu a senha?</a></p>
                    <p class="mb-0 mt-30 hvsng145">Não tem conta? <a href="signup"> Registre-se</a></p>
                </div>
                <div class="sign_footer">
                    <img src="" alt="">
                    &copy; <?= date('Y') ?> <strong>iRes</strong>. Developed by <a href=""> Equipe Home Office</a>.
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Signup End -->


<?php $v->start("scripts"); ?>
<script>
    /**
     * @lacy_
     * recupera senha
     */
    function redefinePassword() {
        const state = document.querySelector('.state');
        const button = document.querySelector('.login-btn');
        var form = $('#formRedefine').serializeArray();

        state.innerHTML = `<img class="spiner" src="${URL}/theme/assets/images/loader.svg"/>`;
        button.setAttribute('disabled', '');
        button.classList.add('hover');

        $.ajax({
            url: URL + '/resetUserPassword',
            data: form,
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                state.innerHTML = 'Continue';
                button.removeAttribute('disabled');
                if (response.success) {
                    //remove do cache a o nome da página anterior
                    localStorage.removeItem('name-page');
                    //adiciona no cache o nome da página selecionada
                    localStorage.setItem('name-page', `home`);

                    //remove do cache a o nome da página anterior
                    localStorage.removeItem('session-user');
                    //adiciona no cache o nome da página selecionada
                    localStorage.setItem('session-user', `${JSON.stringify(response.data)}`);

                    notificationSuccess(response.message);
                    setInterval(() => {
                        window.location.href = response.redirect;
                    }, 1000);
                } else {
                    notificationError(response.message);
                }
            },
            complete: function() {

            }
        });

        return false;
    }
</script>
<?php $v->end(); ?>