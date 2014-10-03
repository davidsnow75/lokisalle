<div class="main-content blc">
  <div class="ctn">

    <h1>Inscription</h1>

<?php if ( !is_null($data['msg']) ): ?>
    <p class="msg-retour"><?= $data['msg'] ?></p>
<?php endif; ?>

    <form action="/inscription/inscrire" method="post">
      <div class="form-group"> <label>Nom d'utilisateur : </label><input type="text" name="pseudo" value="<?= Session::flashget('post_data.add_item_membres.pseudo') ?>"> </div>
      <div class="form-group"> <label>Mot de passe :</label><input type="password" name="mdp"> </div>
      <div class="form-group"> <label>Confirmez votre mot de passe :</label><input type="password" name="mdp_bis"> </div>
      <div class="form-group"> <label>Prénom &amp; Nom :</label><input type="text" name="nom" value="<?= Session::flashget('post_data.add_item_membres.nom') ?>"> </div>
      <div class="form-group"> <label>E-mail :</label><input type="text" name="email" value="<?= Session::flashget('post_data.add_item_membres.email') ?>"> </div>
      <div class="form-group"> <label>Homme :</label><input type="radio" name="sexe" value="m" <?= Session::get('post_data.add_item_membres.sexe') == 'm' ? 'checked' : '' ?>> </div>
      <div class="form-group"> <label>Femme :</label><input type="radio" name="sexe" value="f" <?= Session::flashget('post_data.add_item_membres.sexe') == 'f' ? 'checked' : '' ?>> </div>
      <div class="form-group"> <label>Ville :</label><input type="text" name="ville" value="<?= Session::flashget('post_data.add_item_membres.ville') ?>"> </div>
      <div class="form-group"> <label>Code postal :</label><input type="text" name="cp" value="<?= Session::flashget('post_data.add_item_membres.cp') ?>"> </div>
      <div class="form-group"> <label>Adresse :</label><input type="text" name="adresse" value="<?= Session::flashget('post_data.add_item_membres.adresse') ?>"> </div>
      <input type="submit">
    </form>

  </div>
</div>
