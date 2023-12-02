<?= Dashboard\Resource\Messages::get('add') ?>
<?= Dashboard\Resource\Messages::get('edit') ?>
<?= Dashboard\Resource\Messages::get('delete') ?>

<div class="card-title justify-content-end">
    <a href="<?= Dashboard\Template\Template::route("create"); ?>" class="btn btn-outline-success rounded-pill">
        <i class="bi bi-plus-lg"> Add New</i>
    </a>
</div>

<table class="table">
    <thead>
        <?= $table_tr ?>
    </thead>
    <tbody>
        <?= $table_results ?>
    </tbody>
</table>