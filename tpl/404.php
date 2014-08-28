<?php $titre = 'Erreur 404: ressource inexistante'; ?>

<?php ob_start(); ?>

    <h1><?php echo $titre; ?></h1>
	
    <p>Désolé, la ressource <em><?php echo htmlentities($_SERVER['REQUEST_URI'], ENT_QUOTES, "utf-8"); ?></em> n'existe pas.</p>

<?php $contenu = ob_get_clean(); ?>

<?php require 'layout.php'; ?>