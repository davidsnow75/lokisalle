<div class="main-content blc">
  <div class="ctn">

    <h1>Détails</h1>

    <p><a href="<?= racine() ?>/">Retour à l'accueil</a></p>

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

    <pre>
      <?php var_dump($data['produit']); ?>
    </pre>

    <h2>Produits similaires</h2>
    <p>Les produits suivants commence au même mois et se trouve dans la même ville que le produit dont vous avez demandé le détail.</p>
    <div class="lgn">
    <?php foreach($data['similarProduits'] as $produit): ?>
      <div class="col sm6"><?php showProduit($produit); ?></div>
    <?php endforeach; ?>
    </div>

    <p><a href="<?= racine() ?>/">Retour à l'accueil</a></p>

  </div>
</div>
