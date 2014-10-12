<div class="main-content blc">
  <div class="ctn">

    <h1>Gestion des produits</h1>

<?php if ( $data['msg'] ): ?>
    <p class="msg-retour"><?= $data['msg'] ?></p>
<?php endif; ?>

    <ul>
      <li><a href="/gestionproduits">Afficher tous les produits</a></li>
      <li><a href="#ajouter-produit" class="js-toggle">Ajouter un produit</a></li>
    </ul>

    <form action="/gestionproduits/ajouter" method="post" class="form" id="ajouter-produit">
      <fieldset>

        <legend>Ajout d'un produit</legend>

        <label>Salle concernée&nbsp;:</label>
        <select name="salle">
          <option value=""></option>
        </select>

        <label>Date d'arrivée&nbsp;:</label>
        <input type="text" name="date_arrivee">

        <label>Date de départ&nbsp;:</label>
        <input type="text" name="date_depart">

        <label>Prix&nbsp;:</label>
        <input type="number" name="prix">

        <label>Promotion&nbsp;:</label>
        <select name="promo">
          <option value=""></option>
        </select>

        <input type="submit">
      </fieldset>
    </form>

  </div>
</div>
