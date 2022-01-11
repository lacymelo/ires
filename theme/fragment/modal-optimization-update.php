<?php

use Source\Models\RedeIot;
?>
<div id="modal-optimization-update" class="modal modal-edu-general default-popup-PrimaryModal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header header-color-modal bg-color-1">
                <h4 class="modal-title" id="title_modal_message">
                    <p> <i class="fla-2x flaticon-settings"></i> ATUALIZAR CONFIGURAÇÕES</p>
                </h4>
                <div class="modal-close-area modal-close-df">
                    <a class="close" data-dismiss="modal" href="#"><i class="fla flaticon-close"></i></a>
                </div>
            </div>
            <div class="modal-body">
                <i class="educate-icon educate-checked modal-check-pro"></i>
                <h2 id="text_modal_message">Entre com o parâmetro</h2>
                <div class="card-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group label-floating is-focused">
                                <label class="control-label">Nome da Rede</label>
                                <input type="text" class="form-control rede_iot_nome" name="<?= RedeIot::NOME ?>">
                                <span class="material-input"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-default" data-dismiss="modal" href="#">Cancelar</a>
                <a class="btn btn-primary" onclick="updateNetwork()">Confirmar</a>
            </div>
        </div>
    </div>
</div>