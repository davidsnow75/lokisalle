<div class="main-content blc">
  <div class="ctn">

    <h1>Modifier son profil</h1>

<?php if ( $data['msg'] ): ?>
    <p class="msg-retour"><?= $data['msg'] ?></p>
<?php endif; ?>

    <?php $membre = $data['membre'][0]; ?>

    <form action="/espaceperso/modifier" method="post" class="form">
      <fieldset>
        <legend>Modifier son profil</legend>

        <label>Nom d'utilisateur :</label>
        <input type="text" name="pseudo" value="<?= $membre['pseudo'] ?>">

        <label>Mot de passe :</label>
        <input type="password" name="mdp">

        <label>Confirmez votre mot de passe :</label>
        <input type="password" name="mdp_bis">

        <label>Prénom &amp; Nom :</label>
        <input type="text" name="nom" value="<?= $membre['nom'] ?>">

        <label>E-mail :</label>
        <input type="text" name="email" value="<?= $membre['email'] ?>">

        <label>Homme :</label>
        <input type="radio" name="sexe" value="m" <?= $membre['sexe'] == 'm' ? 'checked' : '' ?>>

        <label>Femme :</label>
        <input type="radio" name="sexe" value="f" <?= $membre['sexe'] == 'f' ? 'checked' : '' ?>>

        <label>Ville :</label>
        <input type="text" name="ville" value="<?= $membre['ville'] ?>">

        <label>Code postal :</label>
        <input type="text" name="cp" value="<?= $membre['cp'] ?>">

        <label>Adresse :</label>
        <input type="text" name="adresse" value="<?= $membre['adresse'] ?>">

        <input type="hidden" name="id" value="<?= Session::get('user.id') ?>">

        <input type="submit">
      </fieldset>
    </form>

  </div>
</div>
