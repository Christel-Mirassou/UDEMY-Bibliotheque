<!-- Démarrage d'un buffer -->
<?php 
require_once "Livre.class.php";
ob_start(); 
$l1 = new Livre(1, "Algorithmique selon H2PROG", 300, "algo.png");
$l2 = new Livre(2, "Le virus Asiatique", 200, "virus.png");
$l3 = new Livre(3, "La France du 19ème siècle", 100, "france.png");
$l4 = new Livre(4, "Le JavaScript Client", 500, "JS.png");

?>

<table class="table text-center">
  <thead>
    <tr class="table-dark">
      <th scope="col">Image</th>
      <th scope="col">Titre</th>
      <th scope="col">Nombre de pages</th>
      <th colspan="2">Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php for ($i=0; $i < count(Livre::$livres); $i++) : ?>
    <tr>
      <td class="align-middle"><img src="public/images/<?= Livre::$livres[$i]->getImage(); ?>" alt="algo" width="60px;"></td>
      <td class="align-middle"><?= Livre::$livres[$i]->getTitre(); ?></td>
      <td class="align-middle"><?= Livre::$livres[$i]->getNbPages(); ?></td>
      <td class="align-middle"><a href=""class="btn btn-warning">Modifier</a></td>
      <td class="align-middle"><a href=""class="btn btn-danger">Supprimer</a></td>
    </tr>
    <?php endfor; ?>

  </tbody>
</table>
<a href=""class="btn btn-success d-block">Ajouter</a>


<?php
$titre = "Les livres de la bibliothèque";
// on déverse dans le buffer tout le contenu du buffer démarré ligne 2
$content = ob_get_clean();
require "template.php";
?>