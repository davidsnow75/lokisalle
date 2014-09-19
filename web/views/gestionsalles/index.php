<div class="main-content blc">
  <div class="ctn">

    <h1>Gestion des salles</h1>

<?php if ( $data['msg'] ): ?>
    <p style="color: red;"><?= $data['msg'] ?></p>
<?php endif; ?>

    <button type="button" data-toggle="modal" data-target="ajout-salle-form">Ajouter une salle</button>
<?php if ( Session::get('post_data.ajoutersalles') ): ?>
    <div id="ajout-salle-form" class="modal active">
      <form action="/gestionsalles/ajouter" method="post">
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
            <option value="réunion" <?php if (Session::get('post_data.ajoutersalles.categorie') == 'réunion') { echo 'selected'; } ?>>Réunion</option>
            <option value="conférence" <?php if (Session::flashget('post_data.ajoutersalles.categorie') == 'conférence') { echo 'selected'; } ?>>Conférence</option>
          </select>
        <input type="submit">
      </form>
    </div>
<?php else: ?>
    <div id="ajout-salle-form" class="modal">
      <form action="/gestionsalles/ajouter" method="post">
        <div class="form-group"> <label>Pays&nbsp;: </label>         <input type="text" name="pays"> </div>
        <div class="form-group"> <label>Ville&nbsp;: </label>        <input type="text" name="ville"> </div>
        <div class="form-group"> <label>Adresse&nbsp;: </label>      <input type="text" name="adresse"> </div>
        <div class="form-group"> <label>Code postal&nbsp;: </label>  <input type="text" name="cp"> </div>
        <div class="form-group"> <label>Titre&nbsp;: </label>        <input type="text" name="titre"> </div>
        <div class="form-group"> <label>Description&nbsp;: </label>  <textarea name="description"></textarea> </div>
        <div class="form-group"> <label>Capacité&nbsp;: </label>     <input type="number" name="capacite"> </div>
        <div class="form-group">
          <label>Catégorie&nbsp;: </label>
          <select name="categorie">
            <option value="réunion">Réunion</option>
            <option value="conférence">Conférence</option>
          </select>
        </div>
        <input type="submit">
      </form>
    </div>
<?php endif; ?>

<?php if ( $data['salles'] === [] ): ?>

    <p>Aucune salle n'a été créée pour l'instant.</p>

<?php else: ?>

    <p>Voici la liste des salles existantes&nbsp;:</p>

    <table>
    <?php foreach ($data['salles'] as $salle): ?>
      <tr>
        <td><?= $salle['titre'] ?></td><td>Modification</td><td>Suppression</td>
      </tr>
    <?php endforeach; ?>
    </table>

    <?= '<pre>' ?>
    <?php var_dump($data['salles']) ?>
    <?= '</pre>' ?>

<?php endif; ?>

  </div>
</div>
