<div class="main-content blc">
  <div class="ctn">

    <h1>Gestion des produits</h1>

    <?php if ( $data['msg'] ): ?>
    <p class="msg-retour"><?= $data['msg'] ?></p>
    <?php endif; ?>

    <ul>
      <li><a href="<?= racine() ?>/gestionproduits">Afficher tous les produits</a></li>
      <li><a href="#ajouter-produit" class="js-toggle <?= Session::get('post_data.ajouter-produit') ? 'active' : '' ?>">Ajouter un produit</a></li>
    </ul>

    <form action="<?= racine() ?>/gestionproduits/ajouter" method="post" class="form <?= Session::get('post_data.ajouter-produit') ? 'active' : '' ?>" id="ajouter-produit">
      <fieldset>
        <legend>Ajout d'un produit</legend>

        <label>Salle concernée&nbsp;:</label>
        <select name="salle_id">
          <option value="">Choisissez la salle</option>
          <?php foreach ($data['salles'] as $salle): ?>
          <option value="<?= $salle['id'] ?>" <?= Session::get('post_data.ajouter-produit.salle_id') == $salle['id'] ? 'selected' : '' ?>><?= $salle['titre'] ?> (<?= $salle['id'] ?>) - <?= $salle['ville'] ?></option>
          <?php endforeach; ?>
        </select>

        <label>Date d'arrivée&nbsp;:</label>
        <input type="text" name="date_arrivee" value="<?= Session::get('post_data.ajouter-produit.date_arrivee') ?>">

        <label>Date de départ&nbsp;:</label>
        <input type="text" name="date_depart" value="<?= Session::get('post_data.ajouter-produit.date_depart') ?>">

        <label>Prix&nbsp;:</label>
        <input type="number" name="prix" value="<?= Session::get('post_data.ajouter-produit.prix') ?>">

        <?php if ( !empty($data['promotions']) ): ?>
        <label>Promotion&nbsp;:</label>
        <select name="promo_id">
          <option value="">Pas de promo</option>
          <?php foreach ($data['promotions'] as $promo): ?>
          <option value="<?= $promo['promoId'] ?>" <?php Session::get('post_data.ajouter-produit.promo_id') == $promo['promoId'] ? 'selected' : '' ?>><?= $promo['promoCode'] ?> (<?= $promo['promoReduction'] ?> €)</option>
          <?php endforeach; ?>
        </select>
        <?php endif; ?>

        <input type="submit">
      </fieldset>

      <?php Session::delete('post_data.ajouter-produit'); ?>

    </form>

    <?php if ( empty($data['produits']) ): ?>

      <p>Aucun produit n'a été trouvé.</p>

    <?php else: ?>

      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Date d'arrivée</th>
            <th>Date de départ</th>
            <th>Prix</th>
            <th>État</th>
            <th>Salle</th>
            <th>Promotions</th>
            <th style="font-style: italic;">Action</th>
          </tr>
        <tbody>
          <?php $affichage_ok = array_walk_recursive( $data['produits'], function (&$valeur) { $valeur = htmlentities( $valeur, ENT_QUOTES, "utf-8" ); } ); ?>

          <?php foreach($data['produits'] as $produit): ?>
            <tr>
              <td><?= $produit['produitID'] ?></td>
              <td><?= date('d/m/Y', $produit['produitDebut'] ) ?></td>
              <td><?= date('d/m/Y', $produit['produitFin'] )?></td>
              <td><?= $produit['produitPrix'] ?> €</td>
              <td><?= $produit['produitEtat'] === '1' ? 'Réservé' : 'Disponible' ?></td>
              <td><a href="<?= racine() ?>/gestionsalles/index/<?= $produit['salleID'] ?>"><?= $produit['salleID'] ?></a></td>
              <td><a href="<?= racine() ?>/gestionpromotions/index/<?= $produit['promoId'] ?>"><?= $produit['promoId'] ?></a></td>
              <td>
                <a href="<?= racine() ?>/gestionproduits/modifier/<?= $produit['produitID'] ?>">modifier</a> |
                <a href="<?= racine() ?>/gestionproduits/supprimer/<?= $produit['produitID'] ?>">supprimer</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

    <?php endif; ?>

  </div>
</div>
