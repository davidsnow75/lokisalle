<div class="main-content blc">
  <div class="ctn">

    <h1>Supprimer un membre</h1>

    <p><a href="<?= racine() ?>/gestionmembres">Cliquez ici pour retourner à l'affichage des membres.</a></p>

    <?php $id_membre = $data; ?>

    <form action="<?= racine() ?>/gestionmembres/supprimer/<?= $id_membre ?>" method="post">
      <input type="hidden" name="id" value="<?= $id_membre ?>">
      <p>Vous êtes sur le point de supprimer un membre. <strong>Cette action est irréversible</strong>.</p>
      <p>Souhaitez-vous confirmer votre action ? <input type="submit" value="Je confirme !"></p>
    </form>

  </div>
</div>
