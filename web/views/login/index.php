<div class="main-content blc">
  <div class="ctn">

    <h1>Connexion</h1>

<?php if ( !is_null($data) ): ?>
    <p style="color: red;"><?php echo $data; ?></p>
<?php endif; ?>

    <form action="/login/dologin" method="post">
      <div class="form-group">
        <label>Nom d'utilisateur&nbsp;:</label><input type="text" name="username">
      </div>
      <div class="form-group">
      <label>Mot de passe&nbsp;:</label><input type="password" name="password">
      </div>
      <input type="submit">
    </form>

    <p>Pas encore inscrit ? <a href="/registration">Cliquez ici pour corriger cela !</a></p>

  </div>
</div>
