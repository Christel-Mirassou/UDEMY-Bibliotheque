<!-- Démarrage d'un buffer -->
<?php ob_start() ?>

<p>Contenu de la page d'accueil</p>


<?php
$titre = "Bibliothèque MGA";
// on déverse dans le buffer tout le contenu du buffer démarré ligne 2
$content = ob_get_clean();
require "template.php";
?>