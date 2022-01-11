<?php

use Source\Models\RedeIot;
?>
<div id="modal-validation" class="modal modal-edu-general default-popup-PrimaryModal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header header-color-modal bg-color-1">
                <h4 class="modal-title title-welcome"> <i class="fla-2x flaticon-man-user"></i> Validar Usuário </h4>
                <div class="modal-close-area modal-close-df">
                    <a class="close" onclick="modalClose('modal-validation')"><i class="fla flaticon-close"></i></a>
                </div>
            </div>

            <div class="modal-body">
                <p class="message-account">Entre com sua senha</p>

                <div class="ui search focus mt-15">
                    <div class="ui left icon input swdh95">
                        <input class="prompt srch_explore" type="password" name="senha" maxlength="64" minlength="8" maxlength="10" placeholder="********" />
                        <i class="fla flaticon-key icon icon2"></i>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-secondary" onclick="modalClose('modal-validation')" href="#">Cancelar</a>
                <a class="btn btn-primary" id="buttonConfirme" onclick="removeResource()"><span class='state-remove'>Confirmar</span></a>
            </div>
        </div>
    </div>
</div>