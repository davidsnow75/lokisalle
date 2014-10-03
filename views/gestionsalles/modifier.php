<div class="main-content blc">
  <div class="ctn">

    <h1>Modifier une salle</h1>

<?php if ( $data['msg'] ): ?>
    <p class="msg-retour"><?= $data['msg'] ?></p>
<?php endif; ?>

    <p><a href="/gestionsalles">Cliquez ici pour retourner à l'affichage des salles.</a></p>

    <?php $salle = $data['salle'][0]; ?>

    <div class="ajout-salle-form display">
      <form action="/gestionsalles/modifier/<?= $salle['id'] ?>" method="post">
        <h2 class="tcenter">Référence de la salle&nbsp;: <?= $salle['id'] ?></h2>
        <div class="form-group"> <label>Pays&nbsp;: </label>         <input type="text" name="pays" value="<?= $salle['pays'] ?>"> </div>
        <div class="form-group"> <label>Ville&nbsp;: </label>        <input type="text" name="ville" value="<?= $salle['ville'] ?>"> </div>
        <div class="form-group"> <label>Adresse&nbsp;: </label>      <input type="text" name="adresse" value="<?= $salle['adresse'] ?>"> </div>
        <div class="form-group"> <label>Code postal&nbsp;: </label>  <input type="text" name="cp" value="<?= $salle['cp'] ?>"> </div>
        <div class="form-group"> <label>Titre&nbsp;: </label>        <input type="text" name="titre" value="<?= $salle['titre'] ?>"> </div>
        <div class="form-group"> <label>Description&nbsp;: </label>  <textarea name="description"><?= $salle['description'] ?></textarea> </div>
        <div class="form-group"> <label>Capacité&nbsp;: </label>     <input type="number" name="capacite" value="<?= $salle['capacite'] ?>"> </div>
        <div class="form-group">
          <label>Catégorie&nbsp;: </label>
          <select name="categorie">
            <option value="réunion" <?= $salle['categorie'] == 'réunion' ? 'selected' : '' ?>>Réunion</option>
            <option value="conférence" <?= $salle['categorie']  == 'conférence' ? 'selected' : '' ?>>Conférence</option>
          </select>
        </div>
        <input type="hidden" name="id" value="<?= $salle['id'] ?>">
        <input type="submit">
      </form>
    </div>

  </div>
</div>
