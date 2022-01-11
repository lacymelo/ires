<!-- HOME - TEMPLATE -->
<?php $v->layout("_theme"); ?>

<div class="wrapper">
    <div class="sa4d25">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="card_dash1">
                        <div class="card_dash_left1">
                            <i class="fla flaticon-building"></i>
                            <h1>Gerenciar Salas</h1>
                        </div>
                        <div class="card_dash_right1">
                            <button class="create_btn_dash" onclick="window.location.href=`<?= url('/new-room') ?>`">Nova Sala</button>
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
                <div class="col-lg-12 col-table">
                    <div class="table-responsive mt-30 card-fixed">
                        <table class="table ucp-table list-item">
                            <thead class="thead-s">
                                <tr>
                                    <th>Title</th>
                                    <th class="text-center" scope="col">Status</th>
                                    <th class="text-center" scope="col">Data Criação</th>
                                    <th class="text-center" scope="col">Opção</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Course Title Here</td>
                                    <td class="text-center"><b class="course_active">Fechado</b></td>
                                    <td class="text-center">06 April 2020 | 08:31</td>
                                    <td class="text-center">
                                        <ul class="button-zoom text-center">
                                            <li><a class="st" title="Ver Recursos"><i class="fla-1x flaticon-eye"></i></a></li>
                                            <li><a class="fb" title="Editar"><i class="fla-1x flaticon-edit"></i></a></li>
                                            <li><a class="wz" title="Publicar"><i class="fla-1x flaticon-draw-check-mark"></i></a></li>
                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="answers-indicator hidden">

                        </div>
                    </div>
                </div>

                <div class="col-lg-5 col-view hidden">

                    <div class="membership_bg">
                        <div class="membership_title">
                            <div class="membership__left">
                                <h2 class="title-resource">Baby Plan</h2>
                                <div class="memmbership_price">Lista de Recursos</div>
                            </div>
                        </div>

                        <div class="table-responsive mt-30">
                            <table class="table ucp-table">
                                <thead class="thead-s">
                                    <tr>
                                        <th class="text-center" width="20%" scope="col">
                                            <ul class="button-zoom" style="margin-left: -31px">
                                                <li title="Apagar" onclick="validateUser()">
                                                    <a class="gg"><i class="fla-1x flaticon-trash"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </th>
                                        <th class="cell-ta">Nome</th>
                                        <th class="cell-ta">Quantidade</th>
                                    </tr>
                                </thead>
                                <tbody class="list-resource">
                                    <tr>
                                        <td class="text-center">
                                            <label class="switch">
                                                <input type="checkbox" class="input-switch">
                                                <span class="slider round"></span>
                                            </label>
                                        </td>
                                        <td class="cell-ta">Computador</td>
                                        <td class="cell-ta">1</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal fragment -->
<?= $v->insert(".\\fragment\\modal-validation.php"); ?>

<?php $v->start("scripts") ?>

<script src="<?= url('/theme/assets/js/jquery.md5.js'); ?>"></script>
<script src="<?= url('/theme/assets/js/managePages.js'); ?>"></script>

<?php $v->end("scripts") ?>