<div class="main-content blc">
  <div class="ctn">

    <h1>Supprimer un produit</h1>

    <p><a href="<?= racine() ?>/gestionproduits">Cliquez ici pour retourner à l'affichage des produits.</a></p>

    <?php $id_produit = $data['produit_id']; ?>

    <form action="<?= racine() ?>/gestionproduits/supprimer/<?= $id_produit ?>" method="post">
      <input type="hidden" name="id" value="<?= $id_produit ?>">
      <p>Vous êtes sur le point de supprimer une produit. <strong>Cette action est irréversible</strong>.</p>
      <p>Souhaitez-vous confirmer votre action ? <input type="submit" value="Je confirme !"></p>
    </form>

  </div>
</div>
