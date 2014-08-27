<?php $titre = 'Lokisalle, une solution flexible pour vos locations de salle'; ?>

<?php ob_start(); ?>

  <h1><?php echo $titre; ?></h1>

  <p>Bienvenue sur ce site, actuellement en construction.</p>

<?php $contenu = ob_get_clean(); ?>

<?php require 'layout.php'; ?>
