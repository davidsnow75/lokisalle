<div class="main-content blc">
  <div class="ctn">

    <h1>Modifier une promotion</h1>

    <?= displayMsg($data) ?>

    <?php $promotion = $data['promotions'][0]; ?>

    <ul>
      <li><a href="<?= racine() ?>/gestionpromotions">Afficher toutes les promotions</a></li>
    </ul>

    <form action="<?= racine() ?>/gestionpromotions/modifier/<?= $promotion['promoId'] ?>" method="post" class="form">
      <fieldset>
        <legend>Modification de la promotion <?= $promotion['promoId'] ?></legend>

        <label>Code de la promotion&nbsp;:</label>
        <input type="text" name="code_promo" value="<?= $promotion['promoCode'] ?>">

        <label>Montant de la réduction&nbsp;:</label>
        <input type="number" name="reduction" value="<?= $promotion['promoReduction'] ?>">

        <input type="hidden" name="id" value="<?= $promotion['promoId'] ?>">
        <input type="submit">
      </fieldset>
    </form>

  </div>
</div>
