<div class="main-content blc">
  <div class="ctn">

    <h1>Espace personnel</h1>

    <?= displayMsg( $data ) ?>

    <p><a href="<?= racine() ?>/espaceperso/modifier">Modifier votre profil</a></p>

    <form method="post" action="<?= racine() ?>/espaceperso/abonnement">
      <?php if ( $data['isAbonne'] ): ?>
        <input type="hidden" name="desabonnement">
         <p>Se désabonner de la newsletter: <input type="submit" value="Je me désabonne"></p>
      <?php else: ?>
        <input type="hidden" name="abonnement">
        <p>S'abonner à la newsletter: <input type="submit" value="Je m'abonne"></p>
      <?php endif; ?>
    </form>

    <div class="lgn">

      <?php if (!empty($data['commandes'])): ?>
      <div class="col sm6">
        <h2>Commandes passées</h2>

        <?php
          foreach ($data['commandes'] as $produit) {
            $produitsIds[] = $produit['produits_id'];
          }

          $nbProduits = count($produitsIds);
          $nbValides = 0;

          foreach ( $produitsIds as $key => $produitId ) {
            if (empty($produitId)) {
              unset( $produitsIds[$key] );
            } else {
              $nbValides++;
            }
          }

          $produitsIds = array_values($produitsIds);
          $nbRestant = $nbProduits - $nbValides;
        ?>
        <p>Vous avez commandé <?= $nbProduits ?> <?= $nbProduits > 1 ? 'produits' :  'produit' ?>.</p>
        <?php if ( $nbRestant > 1 ): ?>
        <p><?= $nbRestant ?> de ces produits ont été depuis supprimés du catalogue Lokisalle.</p>
        <?php elseif ( $nbRestant === 1 ): ?>
        <p>Un de ces produit a été depuis supprimé du catalogue Lokisalle.</p>
        <?php endif; ?>
        <p>
          Voici la liste des produits commandés existants encore dans le catalogue Lokisalle :
          <?php foreach ($produitsIds as $key => $produitId): ?>
            <?php if ( $key ) { echo ' | '; } ?>
            <a href="<?php racine() ?>/produit/index/<?= $produitId ?>"><?= $produitId ?></a>
          <?php endforeach; ?>
        </p>
      </div>
      <?php endif; ?>


      <?php if ($data['isAbonne']): ?>
      <div class="col sm6">
        <h2>Dernière newsletter</h2>
        <?php if ( empty($data['lastNewsletter']) ): ?>
          <p>Aucune newsletter n'a été envoyée pour l'instant.</p>
        <?php else: ?>
          <div class="newsletter">
            <p class="newsletter__exp"><strong>De&nbsp;:</strong> <?= $data['lastNewsletter']['expediteur'] ?></p>
            <p class="newsletter__date"><strong>Le&nbsp;:</strong> <?= niceDate($data['lastNewsletter']['date']) ?> à <?= niceHour($data['lastNewsletter']['date']) ?></p>
            <p class="newsletter__sujet"><strong>Sujet&nbsp;:</strong> <?= $data['lastNewsletter']['sujet'] ?></p>
            <p class="newsletter__msg"><strong>Message&nbsp;:</strong><br> <?= $data['lastNewsletter']['message'] ?></p>
          </div>
        <?php endif; ?>
      </div>
      <?php endif; ?>

    </div>

  </div>
</div>
