<div class="main-content blc">
  <div class="ctn">

    <h1>Détails d'un produit</h1>

    <?php $produit = $data['produit'][0]; ?>

<?php /*
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
*/ ?>

    <h2><?= $produit['salleTitre'] ?>, du <?= niceDate($produit['produitDebut']) . ' au ' . niceDate($produit['produitFin']) ?></h2>

    <p class="tcenter"><img src="<?= $produit['sallePhoto'] ?>" alt="<?= $produit['salleTitre'] ?>"></p>

    <ul>
      <li><strong>ID du produit</strong>: <?= $produit['produitID'] ?></li>
      <li><strong>Date de début</strong>: <?= niceDate($produit['produitDebut']) ?></li>
      <li><strong>Date de fin</strong>: <?= niceDate($produit['produitFin']) ?></li>
      <li><strong>Prix</strong>: <?= $produit['produitPrix'] ?> €</li>
      <li><strong>État</strong>: <?= $produit['produitEtat'] ? 'Indisponible' : 'Disponible' ?></li>
      <li><strong>ID de la salle liée</strong>: <?= $produit['salleID'] ?></li>
      <li><strong>Titre de cette salle</strong>: <?= $produit['salleTitre'] ?></li>
      <li><strong>Adresse de cette salle</strong>: <?= $produit['salleAdresse'] ?></li>
      <li><strong>Code postal de cette salle</strong>: <?= $produit['salleCP'] ?></li>
      <li><strong>Ville de cette salle</strong>: <?= $produit['salleVille'] ?></li>
      <li><strong>Pays de cette salle</strong>: <?= $produit['sallePays'] ?></li>
      <li><strong>Descriptions de cette salle</strong>: <div><?= $produit['salleDescription'] ?></div></li>
      <li><strong>Capacité de cette salle</strong>: <?= $produit['salleCapacite'] ?> personnes</li>
      <li><strong>Catégorie de cette salle</strong>: <?= $produit['salleCategorie'] ?></li>
    </ul>

    <p class="tright">
      <?php if ( Session::userIsLoggedIn() ): ?>
        <a href="<?= racine() ?>/panier/ajouter/<?= $produit['produitID'] ?>">Ajouter au panier</a>
      <?php else: ?>
        <a href="<?= racine() ?>/connexion">Connectez-vous pour l'ajouter au panier</a>
      <?php endif; ?>
    </p>

    <h3>Produits similaires</h3>

    <?php if ( empty($data['similarProduits']) ): ?>
      <p>Pas de produits similaires à ce produit !</p>
    <?php else: ?>
      <p>Les produits suivants commence durant le même mois et se trouve dans la même ville que le produit dont vous avez demandé le détail.</p>
      <div class="lgn">
      <?php foreach($data['similarProduits'] as $produit): ?>
        <div class="col sm6"><?php showProduit($produit); ?></div>
      <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <p><a href="<?= racine() ?>/">Retour à l'accueil</a></p>

  </div>
</div>
