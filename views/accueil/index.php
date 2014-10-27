<div class="main-content blc">
  <div class="ctn">

    <h1>Accueil</h1>

    <div class="lgn">
      <section class="col sm8">

      <?php if (empty($data['produits'])): ?>
        <p>Aucun produit disponible pour l'instant.</p>
      <?php else: ?>
        <p>Nos trois dernières offres&nbsp;:</p>
        <?php foreach($data['produits'] as $produit): ?>
          <?php showProduit( $produit ); ?>
        <?php endforeach; ?>
      <?php endif; ?>

      </section>

      <aside class="col sm4">
        <p>Lokisalle est une entreprise de location de salles pour professionnels exigeants.</p>
        <p>Ce site web vous permettra de consulter et réserver les offres de location proposées par Lokisalle.</p>
      </aside>
    </div>
  </div>
</div>
