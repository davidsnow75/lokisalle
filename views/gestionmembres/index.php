<div class="main-content blc">
  <div class="ctn">

    <h1>Gestion des membres</h1>

<?php if ( $data['msg'] ): ?>
    <p class="msg-retour"><?= $data['msg'] ?></p>
<?php endif; ?>

    <table class="table table--membres">
      <thead>
        <tr>
          <th>ID</th>
          <th>Pseudo</th>
          <th>Nom</th>
          <th>E-mail</th>
          <th>Sexe</th>
          <th>Ville</th>
          <th>Code postal</th>
          <th>Adresse</th>
          <th>Statut</th>
        </tr>
      <tbody>
        <?php foreach($data['membres'] as $membre): ?>

          <?php $affichage_ok = array_walk( $membre, function (&$valeur) { $valeur = htmlentities( $valeur, ENT_QUOTES, "utf-8" ); } ); ?>

          <?php if ( $affichage_ok ): ?>
            <tr>
              <td><?= $membre['id'] ?></td>
              <td><?= $membre['pseudo'] ?></td>
              <td><?= $membre['nom'] ?></td>
              <td><?= $membre['email'] ?></td>
              <td><?= $membre['sexe'] === 'm' ? 'homme' : 'femme' ?></td>
              <td><?= $membre['ville'] ?></td>
              <td><?= $membre['cp'] ?></td>
              <td><?= $membre['adresse'] ?></td>
              <td><?= $membre['statut'] == '1' ? 'admin' : 'membre' ?></td>
            </tr>
          <?php endif; ?>

        <?php endforeach; ?>
      </tbody>
    </table>

  </div>
</div>
