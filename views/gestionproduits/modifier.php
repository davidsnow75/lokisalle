<div class="main-content blc">
  <div class="ctn">

    <h1>Modifier un produit</h1>

    <?php if ( $data['msg'] ): ?>
    <p class="msg-retour"><?= $data['msg'] ?></p>
    <?php endif; ?>

    <?php $produit = $data['produit'][0]; ?>

    <ul>
      <li><a href="<?= racine() ?>/gestionproduits">Afficher tous les produits</a></li>
    </ul>

    <form action="<?= racine() ?>/gestionproduits/modifier/<?= $produit['produitID'] ?>" method="post" class="form">
      <fieldset>
        <legend>Modification du produit <?= $produit['produitID'] ?></legend>

        <label>Salle concernée&nbsp;:</label>
        <select name="salle_id">
          <?php foreach ($data['salles'] as $salle): ?>
          <option value="<?= $salle['id'] ?>" <?= $produit['salleID'] == $salle['id'] ? 'selected' : '' ?>><?= $salle['titre'] ?> (<?= $salle['id'] ?>)</option>
          <?php endforeach; ?>
        </select>

        <label>Date d'arrivée&nbsp;:</label>
        <input type="text" name="date_arrivee" value="<?= date('d/m/Y', $produit['produitDebut']) ?>">

        <label>Date de départ&nbsp;:</label>
        <input type="text" name="date_depart" value="<?= date('d/m/Y', $produit['produitFin']) ?>">

        <label>Prix&nbsp;:</label>
        <input type="number" name="prix" value="<?= $produit['produitPrix'] ?>">

        <?php if ( !empty($data['promotions']) ): ?>
        <label>Promotion&nbsp;:</label>
        <select name="promo_id">
          <option value="0">Pas de promo</option>
          <?php foreach ($data['promotions'] as $promo): ?>
          <option value="<?= $promo['promoId'] ?>" <?= $produit['promoId'] == $promo['promoId'] ? 'selected' : '' ?>><?= $promo['promoCode'] ?> (<?= $promo['promoReduction'] ?> €)</option>
          <?php endforeach; ?>
        </select>
        <?php endif; ?>

        <input type="hidden" name="id" value="<?= $produit['produitID'] ?>">
        <input type="submit">
      </fieldset>
    </form>

  </div>
</div>
