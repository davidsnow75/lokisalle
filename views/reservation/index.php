<div class="main-content blc">
  <div class="ctn">

    <h1>Réservation d'un produit</h1>

    <?php if (empty($data['produits'])): ?>

    <p>Aucun produit disponible pour l'instant.</p>

    <?php else: ?>

    <div class="lgn">
    <?php foreach($data['produits'] as $produit): ?>
      <div class="col sm6"><?php showProduit($produit); ?></div>
    <?php endforeach; ?>
    </div>

    <?php endif; ?>

    <p><a href="<?= racine() ?>/">Retour à l'accueil</a></p>

  </div>
</div>
