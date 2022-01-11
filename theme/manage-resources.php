<!-- HOME - TEMPLATE -->
<?php $v->layout("_theme"); ?>

<div class="wrapper">
    <div class="sa4d25">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="card_dash1">
                        <div class="card_dash_left1">
                            <img src="<?= url('/theme/assets/images/resource.svg') ?>" alt="">
                            <h1>Gerenciar Recursos</h1>
                        </div>
                        <div class="card_dash_right1">
                            <button class="create_btn_dash" onclick="showModalCreateResource()">Novo Recurso</button>
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
                    <div class="table-responsive mt-30">
                        <table class="table ucp-table list-item">
                            <thead class="thead-s">
                                <tr>
                                    <th class="text-center" scope="col">Item No.</th>
                                    <th>Title</th>
                                    <th class="text-center" scope="col">Publish Date</th>
                                    <th class="text-center" scope="col">Sales</th>
                                    <th class="text-center" scope="col">Parts</th>
                                    <th class="text-center" scope="col">Category</th>
                                    <th class="text-center" scope="col">Status</th>
                                    <th class="text-center" scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">IT-001</td>
                                    <td>Course Title Here</td>
                                    <td class="text-center">06 April 2020 | 08:31</td>
                                    <td class="text-center">15</td>
                                    <td class="text-center">5</td>
                                    <td class="text-center"><a href="#">Web Development</a></td>
                                    <td class="text-center"><b class="course_active">Active</b></td>
                                    <td class="text-center">
                                        <a href="#" title="Edit" class="gray-s"><i class="fla flaticon-edit"></i></a>
                                        <a href="#" title="Delete" class="gray-s"><i class="fla flaticon-trash-can"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
<?= $v->insert(".\\fragment\\modal-edit-resource.php"); ?>

<?= $v->insert(".\\fragment\\modal-create-resource.php"); ?>

<?php $v->start("scripts") ?>

<script src="<?= url('/theme/assets/js/managePages.js'); ?>"></script>

<?php $v->end("scripts") ?>