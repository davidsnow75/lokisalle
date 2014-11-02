<div class="main-content blc">
  <div class="ctn">

    <h1>Panier</h1>

    <?= displayMsg($data) ?>

    <?php if ( empty($data['panier']['produits']) ): ?>

      <p>Votre panier est vide. Ajoutez des produits en passant par <a href="<?= racine() ?>/reservation">cette page</a> !</p>

    <?php else: ?>

      <?php $panier = $data['panier']; ?>

<?php /*
["produits"]
  ['produitID']
    ["produitID"]
    ["produitDebut"]
    ["produitFin"]
    ["produitPrix"]
    ["produitEtat"]
    ["salleID"]
    ["sallePays"]
    ["salleVille"]
    ["salleAdresse"]
    ["salleCP"]
    ["salleTitre"]
    ["salleDescription"]
    ["sallePhoto"]
    ["salleCapacite"]
    ["salleCategorie"]
    ["promoId"]
    ["promoCode"]
    ["promoReduction"]

["promotions"]
  ["promoId"]
    ["promoId"]
    ["promoCode"]
    ["promoReduction"]

['totalHT']
['promo']
['totalHTPromo']
['tva']
*/ ?>

      <p><a href="<?= racine() ?>/panier/vider">Vider le panier</a></p>

      <table class="table panier">
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
          <?php foreach($panier['produits'] as $p): ?>
          <tr>
            <td><a href="<?= racine() ?>/produit/index/<?= $p['produitID'] ?>"><?= $p['produitID'] ?></a></td>
            <td><?= $p['salleTitre'] ?></td>
            <td class="js-hautomatic-panier-photo"><img class="img-responsive" src="<?= assetdir() ?><?= $p['sallePhoto'] ?>"></td>
            <td><?= $p['salleVille'] ?></td>
            <td><?= $p['salleCapacite'] ?></td>
            <td><?= niceDate($p['produitDebut']) ?></td>
            <td><?= niceDate($p['produitFin']) ?></td>
            <td><?= $p['produitPrix'] ?> €</td>
            <td><a href="<?= racine() ?>/panier/supprimer/<?= $p['produitID'] ?>">X</a></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
        <tfoot>
          <?php if ( empty($panier['promo']) ): ?>
            <tr>
              <td colspan="9">Prix HT: <?= $panier['totalHT'] ?> €</td>
            </tr>
          <?php else: ?>
            <tr>
              <td colspan="9">
                Prix HT: <del><?= $panier['totalHT'] ?> €</del> <strong><?= $panier['totalHTPromo'] ?> €</strong> grâce au(x) code(s) promo entré(s),
                soit une réduction de
                <?php
                  $totalreducperc = ( $panier['promo'] * 100 ) / $panier['totalHT'];
                  $totalreducperc = $totalreducperc > 100 ? 100 : $totalreducperc;
                  printf("%6.2f", $totalreducperc);
                ?>
                % !
              </td>
            </tr>
          <?php endif; ?>
          <tr>
            <td colspan="9">Prix TTC: <?= $panier['totalHTPromo'] + $panier['tva'] ?> €  <small><em>(TVA = 19.6%)</em></small></td>
          </tr>
        </tfoot>
      </table>

      <form method="post" action="<?= racine() ?>/panier/addpromo">
        <p>Utiliser un code promo&nbsp;: <input type="text" name="code_promo"><input type="submit"></p>
      </form>


      <form method="post" action="<?= racine() ?>/panier/payer">
        <p class="tright">Je déclare accepter les <a href="<?= racine() ?>/cgv">conditions générales de vente</a> : <input type="checkbox" name="cgv_ok"> <input type="submit" name="payer" value="PAYER"></p>
      </form>

    <?php endif; ?>

  </div>
</div>
