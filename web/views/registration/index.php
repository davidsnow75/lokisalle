<div class="main-content">
  <div class="blc">
    <div class="lgn">

      <h1>Inscription</h1>

<?php if ( !is_null($data['erreur']) ): ?>
      <p style="color: red;"><?php echo $data['erreur']; ?></p>
<?php endif; ?>

<?php if ( Session::get('registration_post') ): ?>
      <form action="/registration/register" method="post" class="display-table">
        <div class="ligne"><label>Nom d'utilisateur : </label><input type="text" name="pseudo" value="<?php echo Session::get('registration_post/pseudo'); ?>"></div>
        <div class="ligne"><label>Mot de passe :</label><input type="password" name="mdp"></div>
        <div class="ligne"><label>Confirmez votre mot de passe :</label><input type="password" name="mdp_bis"></div>
        <div class="ligne"><label>Prénom &amp; Nom :</label><input type="text" name="nom" value="<?php echo Session::get('registration_post/nom'); ?>"></div>
        <div class="ligne"><label>E-mail :</label><input type="text" name="email" value="<?php echo Session::get('registration_post/email'); ?>"></div>
        <div class="ligne"><label>Homme :</label><input type="radio" name="sexe" value="m"></div>
        <div class="ligne"><label>Femme :</label><input type="radio" name="sexe" value="f"></div>
        <div class="ligne"><label>Ville :</label><input type="text" name="ville" value="<?php echo Session::get('registration_post/ville'); ?>"></div>
        <div class="ligne"><label>Code postal :</label><input type="text" name="cp" value="<?php echo Session::get('registration_post/cp'); ?>"></div>
        <div class="ligne"><label>Adresse :</label><input type="text" name="adresse" value="<?php echo Session::get('registration_post/adresse'); ?>"></div>
        <input type="submit">
      </form>
<?php else: ?>
      <form action="/registration/register" method="post" class="display-table">
        <div class="ligne"><label>Nom d'utilisateur :</label><input type="text" name="pseudo"></div>
        <div class="ligne"><label>Mot de passe :</label><input type="password" name="mdp"></div>
        <div class="ligne"><label>Confirmez votre mot de passe :</label><input type="password" name="mdp_bis"></div>
        <div class="ligne"><label>Prénom &amp; Nom :</label><input type="text" name="nom"></div>
        <div class="ligne"><label>E-mail :</label><input type="text" name="email"></div>
        <div class="ligne"><label>Homme :</label><input type="radio" name="sexe" value="m"></div>
        <div class="ligne"><label>Femme :</label><input type="radio" name="sexe" value="f"></div>
        <div class="ligne"><label>Ville :</label><input type="text" name="ville"></div>
        <div class="ligne"><label>Code postal :</label><input type="text" name="cp"></div>
        <div class="ligne"><label>Adresse :</label><input type="text" name="adresse"></div>
        <input type="submit">
      </form>
<?php endif; ?>

    </div>
  </div>
</div>
