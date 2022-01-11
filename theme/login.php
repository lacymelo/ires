<?php $v->layout("_theme"); ?>

	<!-- Signup Start -->
	<div class="sign_in_up_bg">
		<div class="container">
			<div class="row justify-content-lg-center justify-content-md-center">
				<div class="col-lg-12">
					<div class="main_logo25" id="logo">
                    <a href="<?= url('/home') ?>"><img src="<?= url('/theme/assets/images/logo-ires-preta.svg') ?>" alt="logo-ires"></a>
                <a href="<?= url('/home') ?>"><img src="<?= url('/theme/assets/images/logo-ires-clara.svg') ?>" class="logo-inverse"  alt="logo-ires"></a>        
					</div>
				</div>
			
				<div class="col-lg-6 col-md-8">
					<div class="sign_form">
						<h2>Bem vindo de volta</h2>
						<p>Faça login na sua conta!</p>
						<form id="formLogin" method="POST">
							<div class="ui search focus mt-15">
								<div class="ui left icon input swdh95">
									<input class="prompt srch_explore" type="email" name="email" id="email" maxlength="64" placeholder="exemplo@email.com" title="Por favor, informe seu e-mail"/>															
									<i class="fla flaticon-email icon icon2"></i>
								</div>
							</div>
							<div class="ui search focus mt-15">
								<div class="ui left icon input swdh95">
									<input class="prompt srch_explore" type="password" name="senha" id="senha" maxlength="10" title="Por favor, informe sua senha" placeholder="******"/>
									<i class="fla flaticon-key icon icon2"></i>
								</div>
							</div>
							<button class="login-btn" type="submit" id="login"><span class='state'>Logar</span></button>
						</form>
                        <p class="sgntrm145"><a href="<?= url('/request-recover') ?>">Esqueceu a senha?</a></p>                
						<p class="mb-0 mt-30 hvsng145">Não tem conta? <a href="signup"> Registre-se</a></p>
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
    $('#login').on('click', function(e) {
        e.preventDefault();
        console.log('aqui');
        var state = document.querySelector('.state');
        var button = document.getElementById('login');
        var form = $('#formLogin').serializeArray();

        state.innerHTML = `<img class="spiner" src="${URL}/theme/assets/images/loader.svg"/> Aguarde`;
        button.setAttribute('disabled', '');
        button.classList.add('hover');

        $.ajax({
            url: URL + '/executeLogin',
            data: form,
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                // texto do botão
                state.innerHTML = 'Logar';
                //desabilita o botão
                button.removeAttribute('disabled');
                if(response.success){
                    //remove do cache a o nome da página anterior
                    localStorage.removeItem('name-page');
                    //adiciona no cache o nome da página selecionada
                    localStorage.setItem('name-page', `home`);

                    //remove do cache a o nome da página anterior
                    localStorage.removeItem('session-user');
                    //adiciona no cache o nome da página selecionada
                    localStorage.setItem('session-user', `${JSON.stringify(response.data)}`);
                    window.location.href = response.redirect;
                }else{
                    notificationError(response.message);
                }
            },
            complete: function() {

            }
        });
    });
</script>
<?php $v->end(); ?>