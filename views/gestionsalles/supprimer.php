<div class="main-content blc">
  <div class="ctn">

    <h1>Supprimer une salle</h1>

    <p><a href="<?= racine() ?>/gestionsalles">Cliquez ici pour retourner à l'affichage des salles.</a></p>

    <?php $id_salle = $data; ?>

    <form action="<?= racine() ?>/gestionsalles/supprimer/<?= $id_salle ?>" method="post">
      <input type="hidden" name="id" value="<?= $id_salle ?>">
      <p>Vous êtes sur le point de supprimer une salle. <strong>Cette action est irréversible</strong>.</p>
      <p>Souhaitez-vous confirmer votre action ? <input type="submit" value="Je confirme !"></p>
    </form>

  </div>
</div>
