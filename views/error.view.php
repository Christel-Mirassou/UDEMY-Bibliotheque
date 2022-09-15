<!-- Démarrage d'un buffer -->
<?php ob_start() ?>

<!--affichge du message d'erreur du catch provenant du routeur -->
<?= $messageErreur; ?>


<?php
// on déverse dans le buffer tout le contenu du buffer démarré ligne 2
$content = ob_get_clean();
$titre = "Page 404";
require "template.php";
?>