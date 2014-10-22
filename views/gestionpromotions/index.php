<div class="main-content blc">
  <div class="ctn">

    <h1>Gestion des promotions</h1>

    <?= displayMsg($data) ?>

    <ul>
      <li><a href="/gestionpromotions">Afficher toutes les promotions</a></li>
      <li><a href="#ajouter-promo" class="js-toggle <?= Session::get('post_data.ajouter-promo') ? 'active' : '' ?>">Ajouter une promotion</a></li>
    </ul>

    <form action="/gestionpromotions/ajouter" method="post" class="form toggle-display <?= Session::get('post_data.ajouter-promo') ? 'active' : '' ?>" id="ajouter-promo">
      <fieldset>
        <legend>Ajout d'une promotion</legend>

        <label>Code de la promotion&nbsp;:</label>
        <input type="text" name="code_promo" value="<?= Session::get('post_data.ajouter-promo.code_promo') ?>">

        <label>Montant de la réduction&nbsp;:</label>
        <input type="number" name="reduction" value="<?= Session::get('post_data.ajouter-promo.reduction') ?>">

        <input type="submit">
      </fieldset>
    </form>

    <?php if ( empty($data['promotions']) ): ?>

      <p>Aucune promotion n'a été trouvée.</p>

    <?php else: ?>

      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Code</th>
            <th>Réduction</th>
            <th style="font-style: italic;">Action</th>
          </tr>
        <tbody>
          <?php $affichage_ok = array_walk_recursive( $data['promotions'], function (&$valeur) { $valeur = htmlentities( $valeur, ENT_QUOTES, "utf-8" ); } ); ?>

          <?php foreach($data['promotions'] as $promotion): ?>
            <tr>
              <td><?= $promotion['promoId'] ?></td>
              <td><?= $promotion['promoCode'] ?></td>
              <td><?= $promotion['promoReduction'] ?> €</td>
              <td>
                <a href="/gestionpromotions/modifier/<?= $promotion['promoId'] ?>">modifier</a> |
                <a href="/gestionpromotions/supprimer/<?= $promotion['promoId'] ?>">supprimer</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

    <?php endif; ?>

  </div>
</div>
