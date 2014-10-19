<div class="main-content blc">
  <div class="ctn">

    <h1>Réservation d'un produit</h1>

    <p><a href="/">Retour à l'accueil</a></p>

    <div class="lgn">
    <?php foreach($data['produits'] as $produit): ?>
      <div class="col sm6"><?php showProduit($produit); ?></div>
    <?php endforeach; ?>
    </div>

  </div>
</div>
