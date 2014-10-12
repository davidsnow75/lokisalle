<div class="main-content blc">
  <div class="ctn">

    <h1>Connexion</h1>

<?php if ( !is_null($data['msg']) ): ?>
    <p class="msg-retour"><?= $data['msg'] ?></p>
<?php endif; ?>

    <form action="/connexion/connecter" method="post" class="form">
      <fieldset>
        <legend>Connexion</legend>

        <label>Nom d'utilisateur&nbsp;:</label>
        <input type="text" name="username">

        <label>Mot de passe&nbsp;:</label>
        <input type="password" name="password">

        <input type="submit">
      </fieldset>
    </form>

    <p>Pas encore inscrit ? <a href="/inscription">Cliquez ici pour corriger cela !</a></p>

  </div>
</div>
