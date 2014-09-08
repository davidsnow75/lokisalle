<div class="main-content">
  <div class="blc">
    <div class="lgn">

      <h1>Connexion</h1>

      <?php if ( !is_null($data) ): ?>
      <p style="color: red;"><?php echo $data; ?></p>
      <?php endif; ?>

      <form action="/login/dologin" method="post">
        <input type="text" name="username" placeholder="Nom d'utilisateur ?"><br>
        <input type="password" name="password" placeholder="Mot de passe ?"><br>
        <input type="submit">
      </form>

    </div>
  </div>
</div>
