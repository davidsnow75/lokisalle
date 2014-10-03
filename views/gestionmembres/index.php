<div class="main-content blc">
  <div class="ctn">

    <h1>Gestion des membres</h1>

<?php if ( $data['msg'] ): ?>
    <p class="msg-retour"><?= $data['msg'] ?></p>
<?php endif; ?>

    <p><a href="/gestionmembres">Afficher tous les membres.</a></p>

<?php if ( $data['membres'] === [] ): ?>

    <p>Aucun membre n'a été trouvé.</p>

<?php else: ?>

    <table class="table">
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
          <th style="font-style: italic;">Action</th>
        </tr>
      <tbody>
        <?php $affichage_ok = array_walk_recursive( $data['membres'], function (&$valeur) { $valeur = htmlentities( $valeur, ENT_QUOTES, "utf-8" ); } ); ?>

        <?php foreach($data['membres'] as $membre): ?>
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
            <td><a href="/gestionmembres/supprimer/<?= $membre['id'] ?>">supprimer</a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>


    <h2>Donner le statut d'administrateur à un membre</h2>

    <form method="post" action="/gestionmembres/setadmin">
      <div class="form-group">
        <label>Sélectionner le membre choisi&nbsp;: </label>
        <select name="id">
          <?php foreach( $data['membres'] as $membre ): ?>
            <option value="<?= $membre['id'] ?>"><?= $membre['pseudo'] ?></option>
          <?php endforeach; ?>
        </select>
        <input type="submit">
      </div>
    </form>

<?php endif; ?>

  </div>
</div>
