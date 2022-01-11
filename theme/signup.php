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

            <div class="col-lg-8 col-md-8">
                <div class="sign_form">
                    <h2>Bem vindo de volta</h2>
                    <p>Faça login na sua conta!</p>
                    <form method="POST" id="formRegister">
                        <div class="view_info10">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="ui search focus mt-30 lbel25">
                                        <label>Nome*</label>
                                        <div class="ui left icon input swdh19">
                                            <input class="prompt srch_explore" type="text" name="usuario_nome" placeholder="seu primeiro nome">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="ui search focus mt-30 lbel25">
                                        <label>Sobrenome*</label>
                                        <div class="ui left icon input swdh19">
                                            <input class="prompt srch_explore" type="text" name="usuario_sobrenome" placeholder="seu sobrenome">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="ui search focus mt-30 lbel25">
                                        <label>Escolaridade*</label>
                                        <div class="ui left icon input swdh19">
                                            <input class="prompt srch_explore" type="text" name="escolaridade" placeholder="sua escolaridade">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="ui search focus mt-30 lbel25">
                                        <label>Área de formação*</label>
                                        <div class="ui left icon input swdh19">
                                            <input class="prompt srch_explore" type="text" name="profissao" placeholder="sua profissão">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="ui search focus mt-30 lbel25">
                                        <label>Faculdade*</label>
                                        <div class="ui left icon input swdh19">
                                            <input class="prompt srch_explore" type="text" name="faculdade" placeholder="nome da faculdade">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="ui search focus mt-30 lbel25">
                                        <label>Email*</label>
                                        <div class="ui left icon input swdh19">
                                            <input class="prompt srch_explore" type="text" name="email" placeholder="exemplo@email.com">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="ui search focus mt-30 lbel25">
                                        <label>Senha*</label>
                                        <div class="ui left icon input swdh19">
                                            <input class="prompt srch_explore" type="password" name="senha" placeholder="********" minlength="8" maxlength="10">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="ui search focus mt-30 lbel25">
                                        <label>Confirmar Senha*</label>
                                        <div class="ui left icon input swdh19">
                                            <input class="prompt srch_explore" type="password" name="conf_senha" placeholder="********" minlength="8" maxlength="10">
                                        </div>
                                    </div>
                                </div>

                                <button class="login-btn" type="button" id="userRegister"><span class='state'>Registrar</span></button>
                            </div>
                        </div>
                    </form>
                    <p class="mb-0 mt-30 hvsng145">Já tem conta? <a href="<?= url('/') ?>"> Login</a></p>
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
    $('#userRegister').on('click', function(e) {
        e.preventDefault();

        var button = document.getElementById('userRegister');
        var state = document.querySelector('.state');
        var form = $('#formRegister').serializeArray();

        state.innerHTML = `<img class="spiner" src="${URL}/theme/assets/images/loader.svg"/> Aguarde`;
        button.setAttribute('disabled', '');
        button.classList.add('hover');

        $.ajax({
            url: URL + '/registerUser',
            data: form,
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                // texto do botão
                state.innerHTML = 'Registrar';
                //desabilita o botão
                button.removeAttribute('disabled');
                console.log("🚀 ~ file: login.php ~ line 235 ~ $ ~ response", response.data);
                if (response.success) {
                    //remove do cache a o nome da página anterior
                    localStorage.removeItem('name-page');
                    //adiciona no cache o nome da página selecionada
                    localStorage.setItem('name-page', `home`);

                    //remove do cache a o nome da página anterior
                    localStorage.removeItem('session-user');
                    //adiciona no cache o nome da página selecionada
                    localStorage.setItem('session-user', `${JSON.stringify(response.data)}`);
                    //mensagem
                    notificationSuccess('Seu registro foi realizado');
                    setInterval(() => {
                        window.location.href = response.redirect;
                    }, 500);
                } else {
                    notificationError(response.message);
                }
            }
        });
    });
</script>
<?php $v->end(); ?>