<div class="main-content blc">
  <div class="ctn">

    <h1>Gestion des commandes</h1>

    <?= displayMsg($data) ?>

    <?php if ( empty($data['commandes']) ): ?>

      <p>Aucune commande n'a été enregistrée pour l'instant.</p>

    <?php else: ?>

<?php /*

['commandeId']
['commandeMontant']
['commandeDate']
['membreId']
['membrePseudo']
['produits']
  ['produitId']
  ['produitArrivee']
  ['produitDepart']
  ['produitPrix']
  ['produitEtat']
  ['salleId']
  ['sallePays']
  ['salleVille']
  ['salleAdresse']
  ['salleCp']
  ['salleTitre']
  ['salleDescription']
  ['sallePhoto']
  ['salleCapacite']
  ['salleCategorie']

*/ ?>

      <table class="table">
        <thead>
          <tr>
            <th>N° Commande</th>
            <th>Client</th>
            <th>Montant</th>
            <th>Date</th>
            <th>Détails</th>
          </tr>
        <tbody>
          <?php foreach($data['commandes'] as $c): ?>
          <tr>
            <td><?= $c['commandeId'] ?></td>
            <td><a href="<?= racine() ?>/gestionmembres/index/<?= $c['membreId'] ?>"><?= $c['membrePseudo'] ?> (<?= $c['membreId'] ?>)</a></td>
            <td><?= $c['commandeMontant'] ?> €</td>
            <td><?= niceDate($c['commandeDate']) ?></td>
            <td><span class="pseudolink gestioncommandes js-toggle" data-target="#details<?= $c['commandeId'] ?>">Afficher</span></td>
          </tr>
          <tr class="toggle-display" id="details<?= $c['commandeId'] ?>">
            <td colspan="5">

              <?php $produits = []; ?>
              <?php foreach ( $c['produits'] as $p): ?>
                <?php $produits[] = empty($p['produitId']) ? '<em>supprimé</em>' : '<a href="' . racine() . '/gestionproduits/index/' . $p['produitId'] . '">' . $p['produitId'] . '</a>'; ?>
              <?php endforeach; ?>

              Produit(s) concerné(s)&nbsp;: <?= implode(', ', $produits) ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

    <?php endif; ?>

  </div>
</div>
