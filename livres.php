<!-- Démarrage d'un buffer -->
<?php ob_start() ?>

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
    <tr>
      <td class="align-middle"><img src="public/images/algo.png" alt="algo" width="60px;"></td>
      <td class="align-middle">Algorithmique selon H2PROG</td>
      <td class="align-middle">300</td>
      <td class="align-middle"><a href=""class="btn btn-warning">Modifier</a></td>
      <td class="align-middle"><a href=""class="btn btn-danger">Supprimer</a></td>
    </tr>
    <tr>
      <td class="align-middle"><img src="public/images/virus.png" alt="virus" width="60px;"></td>
      <td class="align-middle">Le virus Asiatique</td>
      <td class="align-middle">200</td>
      <td class="align-middle"><a href=""class="btn btn-warning">Modifier</a></td>
      <td class="align-middle"><a href=""class="btn btn-danger">Supprimer</a></td>
    </tr>
  </tbody>
</table>
<a href=""class="btn btn-success d-block">Ajouter</a>


<?php
$titre = "Les livres de la bibliothèque";
// on déverse dans le buffer tout le contenu du buffer démarré ligne 2
$content = ob_get_clean();
require "template.php";
?>