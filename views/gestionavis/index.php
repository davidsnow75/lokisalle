<div class="main-content blc">
  <div class="ctn">

    <h1>Gestion des avis</h1>

    <?= displayMsg($data) ?>

    <p><a href="<?= racine() ?>/gestionavis">Afficher tous les avis.</a></p>

<?php if ( $data['avis'] === [] ): ?>

    <p>Aucun avis n'a été trouvé.</p>

<?php else: ?>

    <table class="table">
      <thead>
        <tr>
          <th>ID Avis</th>
          <th>Membre</th>
          <th>Salle</th>
          <th>Commentaire</th>
          <th>Note</th>
          <th>Date</th>
          <th style="font-style: italic;">supprimer</th>
        </tr>
      <tbody>
        <?php foreach($data['avis'] as $avis): ?>
          <tr>
            <td><?= $avis['avisId'] ?></td>
            <td>
              <?php if (empty($avis['membrePseudo'])): ?>
                <em>Membre supprimé</em>
              <?php else: ?>
                <?= $avis['membrePseudo'] ?> (<a href="/gestionmembres/index/<?= $avis['membreId'] ?>"><?= $avis['membreId'] ?></a>)</td>
              <?php endif; ?>
            <td><?= $avis['salleTitre'] ?> (<a href="/gestionsalles/index/<?= $avis['salleId'] ?>"><?= $avis['salleId'] ?></a>)</td>
            <td><?= $avis['avisCommentaire'] ?></td>
            <td><?= $avis['avisNote'] ?></td>
            <td><?= niceDate($avis['avisDate']) ?></td>
            <td>
              <form method="post" action="<?= racine() ?>/gestionavis/supprimer">
                <input type="hidden" name="id" value="<?= $avis['avisId'] ?>">
                <input type="submit" value="supprimer">
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

<?php endif; ?>

  </div>
</div>
