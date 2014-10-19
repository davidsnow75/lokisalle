<div class="main-content blc">
  <div class="ctn">

    <h1>Accueil</h1>

    <div class="lgn">
      <section class="col sm8">
        <p>Nos trois dernières offres&nbsp;:</p>
        <?php foreach($data['produits'] as $produit): ?>
        <div class="produit lgn">
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
          <div class="col sm3">
            <img class="img-responsive" src="<?= $produit['sallePhoto'] ?>" alt="<?= $produit['salleTitre'] ?>">
          </div>
          <div class="col sm9">
            <p>
              Du <?= strftime( '%e %b %Y', $produit['produitDebut']) ?>
              au <?= strftime( '%e %b %Y', $produit['produitFin']) ?>
              - <?= $produit['salleVille'] ?>
            </p>
            <p><?= $produit['produitPrix'] ?>€ pour <?= $produit['salleCapacite'] ?> personnes</p>
          </div>
          <div class="col xs12">
          <p><a href="/produit/index/<?= $produit['produitID'] ?>">Voir la fiche détaillée</a></p>
            <?php if ( Session::userIsLoggedIn() ): ?>
              <p><a href="#">Ajouter au panier</a></p>
            <?php else: ?>
              <p><a href="/connexion">Connectez-vous pour l'ajouter au panier</a></p>
            <?php endif; ?>
          </div>
        </div>
        <?php endforeach; ?>
      </section>

      <aside class="col sm4">
        <p>Lokisalle est une entreprise de location de salles pour professionnels exigeants.</p>
        <p>Ce site web vous permettra de consulter et réserver les offres de location proposées par Lokisalle.</p>
      </aside>
    </div>
  </div>
</div>
