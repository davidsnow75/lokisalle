<div class="main-content blc">
  <div class="ctn">

    <h1>Panier</h1>

    <?= displayMsg($data) ?>

    <?php if ( empty($data['panier']['produits']) ): ?>

      <p>Votre panier est vide. Ajoutez des produits en passant par <a href="<?= racine() ?>/reservation">cette page</a> !</p>

    <?php else: ?>

      <?php $panier = $data['panier']; ?>

<?php /*
  ['produitID']
  ['produitDebut']
  ['produitFin']
  ['produitPrix']
  ['produitEtat']
  ['salleID']
  ['sallePays']
  ['salleVille']
  ['salleAdresse']
  ['salleCP']
  ['salleTitre']
  ['salleDescription']
  ['sallePhoto']
  ['salleCapacite']
  ['salleCategorie']
  ['promoId']
  ['promoCode']
  ['promoReduction']
*/ ?>

      <p><a href="<?= racine() ?>/panier/vider">Vider le panier</a></p>

      <table class="table">
        <thead>
          <tr>
            <th>Produit</th>
            <th>Salle</th>
            <th class="js-hautomatic-panier-photo">Photo</th>
            <th>Ville</th>
            <th>Capacité</th>
            <th>Date arrivée</th>
            <th>Date départ</th>
            <th>Prix HT</th>
            <th style="font-style: italic;">Retirer</th>
          </tr>
        <tbody>
          <?php foreach($panier['produits'] as $a): ?>
          <tr>
            <td><a href="<?= racine() ?>/produit/index/<?= $a['produitID'] ?>"><?= $a['produitID'] ?></a></td>
            <td><?= $a['salleTitre'] ?></td>
            <td class="js-hautomatic-panier-photo"><img class="img-responsive" src="<?= assetdir() ?><?= $a['sallePhoto'] ?>"></td>
            <td><?= $a['salleVille'] ?></td>
            <td><?= $a['salleCapacite'] ?></td>
            <td><?= niceDate($a['produitDebut']) ?></td>
            <td><?= niceDate($a['produitFin']) ?></td>
            <td><?= $a['produitPrix'] ?> €</td>
            <td><a href="<?= racine() ?>/panier/supprimer/<?= $a['produitID'] ?>">X</a></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="9">Prix total TTC (TVA = 19.6%) : <?= $panier['total'] + $panier['tva'] ?> €</td>
          </tr>
        </tfoot>
      </table>

      <form method="post" action="<?= racine() ?>/panier/addpromo">
        <p>Utiliser un code promo&nbsp;: <input type="text" name="code_promo"><input type="submit"></p>
      </form>

    <?php endif; ?>

  </div>
</div>
