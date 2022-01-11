<?php

use Source\Models\RedeIot;
?>
<div id="modal-create-resource" class="modal modal-edu-general default-popup-PrimaryModal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header header-color-modal bg-color-1">
                <h4 class="modal-title title-welcome"> <i class="fla-2x flaticon-box"></i> Criar Recurso</h4>
                <div class="modal-close-area modal-close-df">
                    <a class="close" onclick="modalClose('modal-create-resource')"><i class="fla flaticon-close"></i></a>
                </div>
            </div>
            <div class="modal-body">
                <p class="message-account">Informe o nome do recurso</p>

                <form id="formCreate" method="POST">
                    <div class="ui search focus mt-15">
                        <div class="ui left icon input swdh95">
                            <input class="prompt srch_explore" type="text" name="recurso_nome" maxlength="64" placeholder="por favor, entre com o nome" title="recurso" />
                            <i class="fla flaticon-box icon icon2"></i>
                        </div>
                    </div>
                    <button class="login-btn" type="button" id="createResource" onclick="createNewResource()"><span class='create-state'>Salvar</span></button>
                </form>
            </div>
        </div>
    </div>
</div>