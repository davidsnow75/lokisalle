<div class="main-content blc">
  <div class="ctn">

    <h1>Modifier une salle</h1>

<?php if ( $data['msg'] ): ?>
    <p class="msg-retour"><?= $data['msg'] ?></p>
<?php endif; ?>

    <p><a href="<?= racine() ?>/gestionsalles">Cliquez ici pour retourner à l'affichage des salles.</a></p>

    <?php $salle = $data['salle'][0]; ?>

    <form action="<?= racine() ?>/gestionsalles/modifier/<?= $salle['id'] ?>" method="post" class="form">
      <fieldset>
        <legend>Modification de la salle <?= $salle['id'] ?></legend>

        <label>Pays&nbsp;: </label>
        <input type="text" name="pays" value="<?= $salle['pays'] ?>">

        <label>Ville&nbsp;: </label>
        <input type="text" name="ville" value="<?= $salle['ville'] ?>">

        <label>Adresse&nbsp;: </label>
        <input type="text" name="adresse" value="<?= $salle['adresse'] ?>">

        <label>Code postal&nbsp;: </label>
        <input type="text" name="cp" value="<?= $salle['cp'] ?>">

        <label>Titre&nbsp;: </label>
        <input type="text" name="titre" value="<?= $salle['titre'] ?>">

        <label>Description&nbsp;: </label>
        <textarea name="description"><?= $salle['description'] ?></textarea>

        <label>Url de la photo&nbsp;:</label>
        <input type="text" name="photo" value="<?= $salle['photo'] ?>">

        <label>Capacité&nbsp;: </label>
        <input type="number" name="capacite" value="<?= $salle['capacite'] ?>">

        <label>Catégorie&nbsp;: </label>
        <select name="categorie">
          <option value="réunion" <?= $salle['categorie'] == 'réunion' ? 'selected' : '' ?>>Réunion</option>
          <option value="conférence" <?= $salle['categorie']  == 'conférence' ? 'selected' : '' ?>>Conférence</option>
        </select>

        <input type="hidden" name="id" value="<?= $salle['id'] ?>">
        <input type="submit">
      </fieldset>
    </form>

  </div>
</div>
