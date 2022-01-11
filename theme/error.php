<!-- ERROR - TEMPLATE -->
<?php $v->layout("_theme"); ?>

<div class="error">
    <h2>Ooops erro <?= $error; ?>!</h2>
</div>



<?php $v->start("sidebar"); ?>
<a title="" href="<?= url() ?>">Voltar</a>
<?php $v->end("sidebar"); ?>