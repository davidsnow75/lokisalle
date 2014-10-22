<div class="main-content blc">
  <div class="ctn">

    <h1>Supprimer une promotion</h1>

    <p><a href="/gestionpromotions">Cliquez ici pour retourner à l'affichage des promotions.</a></p>

    <?php $id_promotion = $data['promo_id']; ?>

    <form action="/gestionpromotions/supprimer/<?= $id_promotion ?>" method="post">
      <input type="hidden" name="id" value="<?= $id_promotion ?>">
      <p>Vous êtes sur le point de supprimer une promotion. <strong>Cette action est irréversible</strong>.</p>
      <p>Souhaitez-vous confirmer votre action ? <input type="submit" value="Je confirme !"></p>
    </form>

  </div>
</div>
