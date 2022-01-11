<?php $v->layout("_theme"); ?>

    <!-- Signup Start -->
    <div class="sign_in_up_bg">
        <div class="container">
            <div class="row justify-content-lg-center justify-content-md-center">
                <div class="col-lg-12">
                    <div class="main_logo25" id="logo">
                        <a href="<?= url('/') ?>"><img src="<?= url('/theme/assets/images/logo-ires-preta.svg') ?>" alt="logo-ires"></a>
                        <a href="<?= url('/') ?>"><img src="<?= url('/theme/assets/images/logo-ires-clara.svg') ?>" class="logo-inverse"  alt="logo-ires"></a>        
                    </div>
                </div>
            
                <div class="col-lg-6 col-md-8">
                    <div class="sign_form">
                        <h2>Esqueceu sua senha?</h2>
                        <p>Por favor, informe seu endereço de email!</p>
                        <form id="formRecover" method="POST">
                            <div class="ui search focus mt-15">
                                <div class="ui left icon input swdh95">
                                    <input class="prompt srch_explore" type="email" name="email" id="email" maxlength="64" placeholder="exemplo@email.com" title="Por favor, informe seu e-mail"/>															
                                    <i class="fla flaticon-email icon icon2"></i>
                                </div>
                            </div>
                            <button type="button"  id="credential" class="login-btn btn-credential" onclick="recoverPassword()"><span class='state'>Ok</span></button>
                        </form>
                    </div>
                    <div class="sign_footer">
                        <img src="" alt="">
                        &copy; <?= date('Y') ?> <strong>iRes</strong>. Developed by <a href=""> Equipe Home Office</a>.</div>
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
    function recoverPassword() {
        const state = document.querySelector('.state');
        var button = document.getElementById('credential');
        var form = $('#formRecover').serializeArray();


        if (form[0].value != '') {
            state.innerHTML = `<img class="spiner" src="${URL}/theme/assets/images/loader.svg"/> Aguarde`;
            button.setAttribute('disabled', '');
            button.classList.add('hover');

            $.ajax({
                url: URL + '/requestRecoverLogin',
                data: form,
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.success) {
                        state.innerHTML = 'Continue';
                        button.removeAttribute('disabled');
                        notificationSuccess(response.message);
                        console.log(response.redirect);
                        setInterval(() => {
                            window.location.href = response.redirect;
                        }, 500);
                    } else {
                        state.innerHTML = 'Continue';
                        button.removeAttribute('disabled');
                        notificationError(response.message);
                    }
                },
                complete: function() {

                }
            });

            return false;
        }else{
            notificationWarning('Informe o seu email');
        }
    }
</script>
<?php $v->end(); ?>