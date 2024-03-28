<?= Dashboard\Resource\Messages::get('add') ?>
<?= Dashboard\Resource\Messages::get('edit') ?>
<?= Dashboard\Resource\Messages::get('delete') ?>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">
            <a href="<?= Dashboard\Template\Template::route("create"); ?>" class="btn btn-outline-success rounded-pill">
                <i class="bi bi-plus-lg"> Add New</i>
            </a>
        </h5>
        <table class="table">
            <thead>
                <?= $table_tr ?>
            </thead>
            <tbody>
                <?= $table_results ?>
            </tbody>
        </table>
    </div>
</div>