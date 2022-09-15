<!-- Démarrage d'un buffer -->
<?php ob_start() ?>

<form method="POST" action="<?= URL ?>livres/validerModification" enctype="multipart/form-data">
    <div class="form-group">
        <label for="titre">Titre : </label>
        <input type="text" class="form-control" id="titre" name="titre" value="<?= $livre->getTitre() ?>">
    </div>
    <div class="form-group">
        <label for="nbPages">Nombre de pages : </label>
        <input type="number" class="form-control" id="nbPages" name="nbPages" value="<?= $livre->getNbPages() ?>">
    </div>
    <h3>Image : </h3>
    <img src="<?= URL ?>public/images/<?= $livre->getImage() ?>">
    <div class="form-group">
        <label for="image">Image : </label>
        <input type="file" class="form-control-file" id="image" name="image">
    </div>
    <input type="hidden" name="id" value="<?= $livre->getId() ?>">
    <button type="submit" class="btn btn-primary">Valider</button>
</form>

<?php
$titre = "Modification du livre : ". $livre->getTitre();
// on déverse dans le buffer tout le contenu du buffer démarré ligne 2
$content = ob_get_clean();
require "template.php";
?>