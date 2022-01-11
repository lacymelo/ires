<div id="modal" class="modal modal-edu-general default-popup-PrimaryModal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header header-color-modal bg-color-1">
                <h4 class="modal-title" id="title_modal_message"><p> <i class="fla-2x flaticon-settings"></i> CONFIGURAÇÕES</p></h4>
                <div class="modal-close-area modal-close-df">
                    <a class="close" data-dismiss="modal" href="#"><i class="fla flaticon-close"></i></a>
                </div>
            </div>
            <div class="modal-body">
                <i class="educate-icon educate-checked modal-check-pro"></i>
                <h2 id="text_modal_message">Informe os parâmetros</h2>
                <div class="card-content">
                    <div class="row">

                        <div class="col-md-7">
                            <!-- DEFINE O MODELO DE PROPAGAÇÃO -->
                            <div class="form-group label-floating">
                                Floating Intercept
                                <label for="model_propagation" class="switch">
                                    <input type="checkbox" id="model_propagation" name="model_propagation" class="optionsCheckboxes" onchange="checkTypeAntenna()">
                                    <span class="slider round"></span>
                                </label>
                                Close In
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group label-floating">
                                <label class="control-label">Valor de SF</label>
                                <select class="form-control" id="model_sf">
                                    <option value="-" selected> -- selecionar opção -- </option>
                                    <option value="7">7</option>
                                    <option value="9">9</option>
                                    <option value="12">12</option>
                                </select>
                                <span class="material-input"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group label-floating">
                                <label class="control-label">Tipo de limar</label>
                                <select class="form-control" id="limiar">
                                    <option value="-" selected> -- selecionar opção --</option>
                                    <option value="min">Estático</option>
                                    <option value="25">Móvel</option>
                                </select>
                                <span class="material-input"></span>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group label-floating">
                                <label class="control-label">Potência de transmissão</label>
                                <input type="text" class="form-control" name="pt">
                                <span class="material-input"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-default" data-dismiss="modal" href="#">Cancelar</a>
                <a class="btn btn-primary" id="config" href="#">Confirmar</a>
            </div>
        </div>
    </div>
</div>