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
                            <h1>Nova Sala</h1>
                        </div>
                        <div class="card_dash_right1">
                            <button class="create_btn_dash btn-secondary" onclick="window.location.href=`<?= url('/manage-rooms') ?>`">Voltar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 search-secundary">
                    <div class="section3125">
                        <div class="explore_search">
                            <div class="ui search focus">
                                <div class="ui left icon input swdh11">
                                    <input class="prompt srch_explore text_search" type="text" name="text_search_2" id="text_search_2" onkeyup="searchForKeyWord()" placeholder="O que você procura?">
                                    <i class="fla flaticon-search icon icon2"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section3125 result-message hidden">
                <div class="result_dt">
                    <i class="fla flaticon-astronaut wrong_ans"></i> Desculpe, sem dados para exibição.
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
                                            <div class="ui search focus mt-30 lbel25">
                                                <label>Nome Sala*</label>
                                                <div class="ui left icon input swdh19">
                                                    <input class="prompt srch_explore sala-nome" type="text" placeholder="entre com o nome" name="sala_nome">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="lecture_title">
                                                <h4>Adicionar Recursos</h4>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-md-12">
                                            <div class="table-responsive mt-50 mb-0">
                                                <table class="table ucp-table list-item">
                                                    <thead class="thead-s">
                                                        <tr>
                                                            <th class="text-center" scope="col">Selecionar</th>
                                                            <th class="cell-ta">Nome</th>
                                                            <th class="text-center" width="40">Quantidade</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-center">
                                                                <label class="switch">
                                                                    <input type="checkbox" class="">
                                                                    <span class="slider round"></span>
                                                                </label>
                                                            </td>
                                                            <td class="cell-ta">Computador</td>

                                                            <td class="cell-ta">
                                                                <div class="col-md-12">
                                                                    <div class="ui search focus lbel25">
                                                                        <div class="ui left icon input swdh19">
                                                                            <input class="prompt srch_explore input-qtd" type="number" value="1" min="1" max="500" placeholder="0">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-md-12">
                                            <!-- Pagination -->
                                            <div class="answers-indicator hidden">

                                            </div>

                                            <div class="save_content">
                                                <button class="save_content_btn" type="button" id="editRoom" onclick="updateRoom()"><span class='state'>Salvar</span></button>
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

<?php $v->end("scripts") ?>