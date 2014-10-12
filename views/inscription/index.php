<div class="main-content blc">
  <div class="ctn">

    <h1>Inscription</h1>

<?php if ( !is_null($data['msg']) ): ?>
    <p class="msg-retour"><?= $data['msg'] ?></p>
<?php endif; ?>

    <form action="/inscription/inscrire" method="post" class="form">
      <fieldset>
        <legend>Inscription</legend>

        <label>Nom d'utilisateur : </label>
        <input type="text" name="pseudo" value="<?= Session::flashget('post_data.add_item_membres.pseudo') ?>">

        <label>Mot de passe :</label>
        <input type="password" name="mdp">

        <label>Confirmez votre mot de passe :</label>
        <input type="password" name="mdp_bis">

        <label>Prénom &amp; Nom :</label>
        <input type="text" name="nom" value="<?= Session::flashget('post_data.add_item_membres.nom') ?>">

        <label>E-mail :</label>
        <input type="text" name="email" value="<?= Session::flashget('post_data.add_item_membres.email') ?>">

        <label>Homme :</label>
        <input type="radio" name="sexe" value="m" <?= Session::get('post_data.add_item_membres.sexe') == 'm' ? 'checked' : '' ?>>

        <label>Femme :</label>
        <input type="radio" name="sexe" value="f" <?= Session::flashget('post_data.add_item_membres.sexe') == 'f' ? 'checked' : '' ?>>

        <label>Ville :</label>
        <input type="text" name="ville" value="<?= Session::flashget('post_data.add_item_membres.ville') ?>">

        <label>Code postal :</label>
        <input type="text" name="cp" value="<?= Session::flashget('post_data.add_item_membres.cp') ?>">

        <label>Adresse :</label>
        <input type="text" name="adresse" value="<?= Session::flashget('post_data.add_item_membres.adresse') ?>">

        <input type="submit">
      </fieldset>
    </form>

  </div>
</div>
