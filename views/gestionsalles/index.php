<div class="main-content blc">
  <div class="ctn">

    <h1>Gestion des salles</h1>

<?php if ( $data['msg'] ): ?>
    <p class="msg-retour"><?= $data['msg'] ?></p>
<?php endif; ?>

    <p class="tcenter">
      <a href="<?= racine() ?>/gestionsalles" class="displayer">Afficher toutes les salles</a>
      <a href="#ajout-salle-form" class="displayer js-toggle">Ajouter une salle</a>
    </p>
    <div id="ajout-salle-form" class="ajout-salle-form <?= Session::get('post_data.add_item_salles') ? 'active' : '' ?>">
      <form action="<?= racine() ?>/gestionsalles/ajouter" method="post" class="form">
        <fieldset>
          <legend>Ajout d'une salle</legend>

          <label>Pays&nbsp;:</label>
          <input type="text" name="pays" value="<?= Session::flashget('post_data.add_item_salles.pays') ?>">

          <label>Ville&nbsp;:</label>
          <input type="text" name="ville" value="<?= Session::flashget('post_data.add_item_salles.ville') ?>">

          <label>Adresse&nbsp;:</label>
          <input type="text" name="adresse" value="<?= Session::flashget('post_data.add_item_salles.adresse') ?>">

          <label>Code postal&nbsp;:</label>
          <input type="text" name="cp" value="<?= Session::flashget('post_data.add_item_salles.cp') ?>">

          <label>Titre&nbsp;:</label>
          <input type="text" name="titre" value="<?= Session::flashget('post_data.add_item_salles.titre') ?>">

          <label>Description&nbsp;:</label>
          <textarea name="description"><?= Session::flashget('post_data.add_item_salles.description') ?></textarea>

          <label>Photo&nbsp;:</label>
          <input type="text" name="photo_salle_url" value="<?= Session::flashget('post_data.add_item_salles.photo_salle_url') ?>">

          <label>Capacité&nbsp;:</label>
          <input type="number" name="capacite" value="<?= Session::flashget('post_data.add_item_salles.capacite') ?>">

          <label>Catégorie&nbsp;: </label>
          <select name="categorie">
            <option value="réunion" <?= Session::get('post_data.add_item_salles.categorie') == 'réunion' ? 'selected' : '' ?>>Réunion</option>
            <option value="conférence" <?= Session::flashget('post_data.add_item_salles.categorie') == 'conférence' ? 'selected' : '' ?>>Conférence</option>
          </select>

          <input type="submit">
        </fieldset>
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
          <a href="<?= racine() ?>/gestionsalles/modifier/<?= $salle['id'] ?>">modification</a> |
          <a href="<?= racine() ?>/gestionsalles/supprimer/<?= $salle['id'] ?>">suppression</a>
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
