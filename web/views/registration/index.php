<div class="main-content blc">
  <div class="ctn">

    <h1>Inscription</h1>

<?php if ( !is_null($data['erreur']) ): ?>
    <p style="color: red;"><?php echo $data['erreur']; ?></p>
<?php endif; ?>

<?php if ( Session::get('post_data.register') ): ?>
    <form action="/registration/register" method="post">
      <div class="form-group"> <label>Nom d'utilisateur : </label><input type="text" name="pseudo" value="<?php echo Session::flashget('post_data.register.pseudo'); ?>"> </div>
      <div class="form-group"> <label>Mot de passe :</label><input type="password" name="mdp"> </div>
      <div class="form-group"> <label>Confirmez votre mot de passe :</label><input type="password" name="mdp_bis"> </div>
      <div class="form-group"> <label>Prénom &amp; Nom :</label><input type="text" name="nom" value="<?php echo Session::flashget('post_data.register.nom'); ?>"> </div>
      <div class="form-group"> <label>E-mail :</label><input type="text" name="email" value="<?php echo Session::flashget('post_data.register.email'); ?>"> </div>
      <div class="form-group"> <label>Homme :</label><input type="radio" name="sexe" value="m" <?php if (Session::get('post_data.register.sexe') == 'm') { echo 'checked'; } ?>> </div>
      <div class="form-group"> <label>Femme :</label><input type="radio" name="sexe" value="f" <?php if (Session::flashget('post_data.register.sexe') == 'f') { echo 'checked'; } ?>> </div>
      <div class="form-group"> <label>Ville :</label><input type="text" name="ville" value="<?php echo Session::flashget('post_data.register.ville'); ?>"> </div>
      <div class="form-group"> <label>Code postal :</label><input type="text" name="cp" value="<?php echo Session::flashget('post_data.register.cp'); ?>"> </div>
      <div class="form-group"> <label>Adresse :</label><input type="text" name="adresse" value="<?php echo Session::flashget('post_data.register.adresse'); ?>"> </div>
      <input type="submit">
    </form>
<?php else: ?>
    <form action="/registration/register" method="post">
      <div class="form-group"> <label>Nom d'utilisateur :</label><input type="text" name="pseudo"> </div>
      <div class="form-group"> <label>Mot de passe :</label><input type="password" name="mdp"> </div>
      <div class="form-group"> <label>Confirmez votre mot de passe :</label><input type="password" name="mdp_bis"> </div>
      <div class="form-group"> <label>Prénom &amp; Nom :</label><input type="text" name="nom"> </div>
      <div class="form-group"> <label>E-mail :</label><input type="text" name="email"> </div>
      <div class="form-group"> <label>Homme :</label><input type="radio" name="sexe" value="m"> </div>
      <div class="form-group"> <label>Femme :</label><input type="radio" name="sexe" value="f"> </div>
      <div class="form-group"> <label>Ville :</label><input type="text" name="ville"> </div>
      <div class="form-group"> <label>Code postal :</label><input type="text" name="cp"> </div>
      <div class="form-group"> <label>Adresse :</label><input type="text" name="adresse"> </div>
      <input type="submit">
    </form>
<?php endif; ?>

  </div>
</div>
