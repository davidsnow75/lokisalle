<div class="main-content blc">
  <div class="ctn">

    <h1>Gestion des salles</h1>

<?php if ( $data['msg'] ): ?>
    <p class="msg-retour"><?= $data['msg'] ?></p>
<?php endif; ?>

    <p class="tcenter">
      <a href="/gestionsalles" class="displayer">Afficher toutes les salles</a>
      <button type="button" class="displayer" data-toggle="display" data-target="ajout-salle-form">Ajouter une salle</button>
    </p>
    <div id="ajout-salle-form" class="ajout-salle-form <?php echo Session::get('post_data.ajoutersalles') ? 'display' : '' ?>">
      <form action="/gestionsalles/ajouter" method="post">
        <h2 class="tcenter">Ajout d'une salle</h2>
        <div class="form-group"> <label>Pays&nbsp;: </label>         <input type="text" name="pays" value="<?php echo Session::flashget('post_data.ajoutersalles.pays'); ?>"> </div>
        <div class="form-group"> <label>Ville&nbsp;: </label>        <input type="text" name="ville" value="<?php echo Session::flashget('post_data.ajoutersalles.ville'); ?>"> </div>
        <div class="form-group"> <label>Adresse&nbsp;: </label>      <input type="text" name="adresse" value="<?php echo Session::flashget('post_data.ajoutersalles.adresse'); ?>"> </div>
        <div class="form-group"> <label>Code postal&nbsp;: </label>  <input type="text" name="cp" value="<?php echo Session::flashget('post_data.ajoutersalles.cp'); ?>"> </div>
        <div class="form-group"> <label>Titre&nbsp;: </label>        <input type="text" name="titre" value="<?php echo Session::flashget('post_data.ajoutersalles.titre'); ?>"> </div>
        <div class="form-group"> <label>Description&nbsp;: </label>  <textarea name="description" value="<?php echo Session::flashget('post_data.ajoutersalles.description'); ?>"></textarea> </div>
        <div class="form-group"> <label>Capacité&nbsp;: </label>     <input type="number" name="capacite" value="<?php echo Session::flashget('post_data.ajoutersalles.capacite'); ?>"> </div>
        <div class="form-group">
          <label>Catégorie&nbsp;: </label>
          <select name="categorie">
            <option value="réunion" <?php echo (Session::get('post_data.ajoutersalles.categorie') == 'réunion') ? 'selected' : '' ?>>Réunion</option>
            <option value="conférence" <?php echo (Session::flashget('post_data.ajoutersalles.categorie') == 'conférence') ? 'selected' : '' ?>>Conférence</option>
          </select>
        </div>
        <input type="submit">
      </form>
    </div>

<?php if ( $data['salles'] === [] ): ?>

    <p>Aucune salle n'a été trouvée.</p>

<?php else: ?>

    <?php foreach ($data['salles'] as $salle): ?>
    <article class="salles-item">
      <div class="metadata">
        <span class="salle-id"><?= $salle['id'] ?></span>
        <span class="salle-action">
          <a href="/gestionsalles/modifier/<?= $salle['id'] ?>">modification</a> |
          <a href="/gestionsalles/supprimer/<?= $salle['id'] ?>">suppression</a>
        </span>
      </div><!-- /.metadata -->
      <div class="data">
        <h3 class="salle-titre"><?= $salle['titre'] ?></h3>
        <div class="lgn">
          <div class="col sm8">
            <p class="salle-utile">
              <span class="salle-categorie"><?= $salle['categorie'] ?></span><br>
              <span class="salle-capacite"><?= $salle['capacite'] ?></span>
            </p>
            <p class="salle-description"><?= $salle['description'] ?></p>
            <p class="salle-localisation">
              <span class="salle-adresse"><?= $salle['adresse'] ?></span>
              <span class="salle-cp"><?= $salle['cp'] ?></span>
              <span class="salle-ville"><?= $salle['ville'] ?></span>
              <span class="salle-pays"><?= $salle['pays'] ?></span>
            </p>
          </div>
          <div class="col sm4">
            <p class="salle-photo"><img src="<?= $salle['photo'] ?>" alt="Photo de <?= $salle['titre'] ?>"></p>
          </div>
        </div><!-- /.lgn -->
      </div><!-- /.data -->
    </article>
    <?php endforeach; ?>

<?php endif; ?>

  </div>
</div>
