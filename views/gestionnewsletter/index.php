<div class="main-content blc">
  <div class="ctn">

    <h1>Gestion de la newsletter</h1>

    <?= displayMsg($data) ?>

    <p>Nombre d'abonné(e)s à la newsletter : <?= $data['nbAbonne'] ?></p>

    <form class="form" method="post" action="<?= racine() ?>/gestionnewsletter/envoyer">
      <fieldset>
        <legend>Envoi d'une newsletter</legend>

        <label>Expéditeur</label>
        <input type="text" name="expediteur">

        <label>Sujet</label>
        <input type="text" name="sujet">

        <label>Message</label>
        <textarea name="message"></textarea>

        <input type="submit" value="Envoyer">
      </fieldset>
    </form>

  </div>
</div>
