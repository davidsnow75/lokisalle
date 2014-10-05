<div class="main-content blc">
  <div class="ctn">

    <h1>Modifier son profil</h1>

<?php if ( $data['msg'] ): ?>
    <p class="msg-retour"><?= $data['msg'] ?></p>
<?php endif; ?>

    <?php $membre = $data['membre'][0]; ?>

    <form action="/espaceperso/modifier" method="post">
      <div class="form-group"> <label>Nom d'utilisateur :</label><input type="text" name="pseudo" value="<?= $membre['pseudo'] ?>"> </div>
      <div class="form-group"> <label>Mot de passe :</label><input type="password" name="mdp"> </div>
      <div class="form-group"> <label>Confirmez votre mot de passe :</label><input type="password" name="mdp_bis"> </div>
      <div class="form-group"> <label>Prénom &amp; Nom :</label><input type="text" name="nom" value="<?= $membre['nom'] ?>"> </div>
      <div class="form-group"> <label>E-mail :</label><input type="text" name="email" value="<?= $membre['email'] ?>"> </div>
      <div class="form-group"> <label>Homme :</label><input type="radio" name="sexe" value="m" <?= $membre['sexe'] == 'm' ? 'checked' : '' ?>> </div>
      <div class="form-group"> <label>Femme :</label><input type="radio" name="sexe" value="f" <?= $membre['sexe'] == 'f' ? 'checked' : '' ?>> </div>
      <div class="form-group"> <label>Ville :</label><input type="text" name="ville" value="<?= $membre['ville'] ?>"> </div>
      <div class="form-group"> <label>Code postal :</label><input type="text" name="cp" value="<?= $membre['cp'] ?>"> </div>
      <div class="form-group"> <label>Adresse :</label><input type="text" name="adresse" value="<?= $membre['adresse'] ?>"> </div>
      <input type="hidden" name="id" value="<?= Session::get('user.id') ?>">
      <input type="submit">
    </form>

  </div>
</div>
