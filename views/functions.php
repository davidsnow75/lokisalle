<?php

function racine() {
  if ( NO_REWRITE ) {
    return SUBFOLDER . '/index.php';
  } else {
    return SUBFOLDER;
  }
}

function assetdir() {
  return SUBFOLDER;
}

/*---------------------------------------------------------------------------*/
function displayMsg( $data ) {
  if ( empty($data['msg']) ) { return; }

  ob_start(); ?>

  <p class="msg-retour"><?= $data['msg'] ?></p>

<?php return ob_get_clean();
}

/*---------------------------------------------------------------------------*/
function showProduit( $produit ) {
/*
    $produit['produitID']
    $produit['produitDebut']
    $produit['produitFin']
    $produit['produitPrix']
    $produit['produitEtat']
    $produit['salleID']
    $produit['sallePays']
    $produit['salleVille']
    $produit['salleAdresse']
    $produit['salleCP']
    $produit['salleTitre']
    $produit['salleDescription']
    $produit['sallePhoto']
    $produit['salleCapacite']
    $produit['salleCategorie']
*/
?>

<div class="produitSM lgn">
  <div class="col sm3">
    <img class="img-responsive produitSM_img" src="<?= $produit['sallePhoto'] ?>" alt="<?= $produit['salleTitre'] ?>">
  </div>
  <div class="col sm9 produitSM__infos">
    <p>Du <strong><?= strftime( '%e %b %Y', $produit['produitDebut']) ?></strong> au <strong><?= strftime( '%e %b %Y', $produit['produitFin']) ?></strong> - <em><?= $produit['salleVille'] ?></em></p>
    <p><strong><?= $produit['produitPrix'] ?>€</strong> pour <strong><?= $produit['salleCapacite'] ?></strong> personnes</p>
    <p class="produitSM__links">
      <a href="/produit/index/<?= $produit['produitID'] ?>">Voir la fiche détaillée</a> |
      <?php if ( Session::userIsLoggedIn() ): ?>
        <a href="#">Ajouter au panier</a>
      <?php else: ?>
        <a href="/connexion">Connectez-vous pour l'ajouter au panier</a>
      <?php endif; ?>
    </p>
  </div>
</div>

<?php
}

/*---------------------------------------------------------------------------*/
