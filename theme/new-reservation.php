<!-- HOME - TEMPLATE -->
<?php $v->layout("_theme"); ?>

<div class="wrapper">
    <div class="sa4d25">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="card_dash1">
                        <div class="card_dash_left1">
                            <i class="fla flaticon-plus"></i>
                            <h1>Nova Reserva</h1>
                        </div>
                        <div class="card_dash_right1">
                            <button class="create_btn_dash btn-secondary" onclick="window.location.href=`<?= url('/home') ?>`">Voltar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="course__form">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="view_info10">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <form method="POST" id="formReservation">
                                                <input type="hidden" class="usuario_sala_sala_id" name="usuario_sala_sala_id" value="2">
                                                <input type="hidden"class="usuario_sala_usuario_id" name="usuario_sala_usuario_id" value="2">

                                                <div class="view_info10">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="ui search focus mt-30 lbel25">
                                                                <label>Data início*</label>
                                                                <div class="ui left icon input swdh19">
                                                                    <input class="prompt srch_explore" type="datetime-local" name="reserva_inicia">
                                                                    <div class="badge_num"  onclick="checkDateAvailability('I')">consultar</div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="ui search focus mt-30 lbel25">
                                                                <label>Data término*</label>
                                                                <div class="ui left icon input swdh19">
                                                                    <input class="prompt srch_explore" type="datetime-local" name="reserva_fim">
                                                                    <div class="badge_num" onclick="checkDateAvailability('F')">consultar</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="col-lg-12 col-md-12">
                                            <div class="save_content">
                                                <button class="save_content_btn" type="button" id="addReservation" onclick="createReservation()"><span class='state'>Salvar</span></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="answers-indicator hidden">

            </div>
        </div>
    </div>
</div>

<!-- Modal fragment -->
<?php $v->start("scripts") ?>

<script src="<?= url('/theme/assets/js/managePages.js'); ?>"></script>

<!-- createReservation -->

<?php $v->end("scripts") ?>