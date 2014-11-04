<div class="main-content blc">
  <div class="ctn">

    <h1>Réservation d'un produit</h1>

    <?php if (empty($data['produits'])): ?>

    <p>Aucun produit disponible pour l'instant.</p>

    <?php else: ?>

      <?php
        $total = count($data['produits']);
        $count = 0;
      ?>

    <?php foreach($data['produits'] as $produit): ?>

      <?php if ( $count % 2 === 0 ): ?> <div class="lgn"> <?php endif; ?>

        <div class="col sm6"><?php showProduit($produit); ?></div>

      <?php if ( $count % 2 !== 0 ): ?> </div> <?php endif; ?>

      <?php $count++; ?>

    <?php endforeach; ?>

      <?php if ( $total % 2 !== 0 ): ?></div><?php endif; ?>

    <?php endif; ?>

    <p><a href="<?= racine() ?>/">Retour à l'accueil</a></p>

  </div>
</div>
