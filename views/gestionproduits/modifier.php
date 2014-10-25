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

    <form action="<?= racine() ?>/gestionproduits/modifier/<?= $produit['id'] ?>" method="post" class="form">
      <fieldset>
        <legend>Modification du produit <?= $produit['id'] ?></legend>

        <label>Salle concernée&nbsp;:</label>
        <select name="salle_id">
          <?php foreach ($data['salles'] as $salle): ?>
          <option value="<?= $salle['id'] ?>" <?= $produit['salles_id'] == $salle['id'] ? 'selected' : '' ?>><?= $salle['titre'] ?> (<?= $salle['id'] ?>)</option>
          <?php endforeach; ?>
        </select>

        <label>Date d'arrivée&nbsp;:</label>
        <input type="text" name="date_arrivee" value="<?= date('d/m/Y', $produit['date_arrivee']) ?>">

        <label>Date de départ&nbsp;:</label>
        <input type="text" name="date_depart" value="<?= date('d/m/Y', $produit['date_depart']) ?>">

        <label>Prix&nbsp;:</label>
        <input type="number" name="prix" value="<?= $produit['prix'] ?>">

        <?php if ( !empty($data['promo']) ): ?>
        <label>Promotion&nbsp;:</label>
        <select name="promo">
          <?php foreach ($data['promos'] as $promo): ?>
          <option value="<?= $promo['id'] ?>" <?= $produit['promotions_id'] == $promo['id'] ? 'selected' : '' ?>><?= $promo['code_promo'] ?> (<?= $promo['reduction'] ?>)</option>
          <?php endforeach; ?>
        </select>
        <?php endif; ?>


        <input type="hidden" name="id" value="<?= $produit['id'] ?>">
        <input type="submit">
      </fieldset>
    </form>

  </div>
</div>
