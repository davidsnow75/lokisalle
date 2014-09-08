<div class="main-content">
  <div class="blc">
    <div class="lgn">

      <h1>Inscription</h1>

      <?php if ( !is_null($data) ): ?>
      <p style="color: red;"><?php echo $data; ?></p>
      <?php endif; ?>

      <form action="/registration/register" method="post">
        <input type="text" name="pseudo" placeholder="Nom d'utilisateur"><br>
        <input type="password" name="mdp" placeholder="Mot de passe"><br>
        <input type="password" name="mdp_bis" placeholder="Confirmer votre mot de passe"><br>
        <input type="text" name="email" placeholder="E-mail"><br>
        <input type="radio" name="sexe" value="m">Homme<br>
        <input type="radio" name="sexe" value="f">Femme<br>
        <input type="text" name="adresse" placeholder="Adresse"><br>
        <input type="text" name="cp" placeholder="Code postal"><br>
        <input type="text" name="ville" placeholder="Ville"><br>
        <input type="submit">
      </form>

    </div>
  </div>
</div>
