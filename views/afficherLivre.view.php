<!-- Démarrage d'un buffer -->
<?php ob_start() ?>

<div class="row mt-5">
    <div class="col-6">
        <img src="<?= URL ?>public/images/<?= $livre->getImage() ?>" alt="<?= $livre->getTitre() ?>">
    </div>
    <div class="col-6">
        <h2><b>Titre : </b><?= $livre->getImage() ?></h2>
        <p>Nombre de pages : <?= $livre->getNbPages() ?></p>
    </div>
</div>

<?php
$titre = $livre->getTitre();
// on déverse dans le buffer tout le contenu du buffer démarré ligne 2
$content = ob_get_clean();
require "template.php";
?>