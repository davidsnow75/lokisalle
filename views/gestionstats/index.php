<div class="main-content blc">
  <div class="ctn">

    <h1>Statistiques</h1>

    <div class="tcenter">

      <?php if ( !empty($data['bestSalle']) ): ?>
        <p>La salle la mieux notée est la <strong><?= $data['bestSalle']['salleTitre'] ?></strong>, avec une note de <strong><?= $data['bestSalle']['avisNote'] ?>/10</strong>.</p>
      <?php endif; ?>

      <?php if ( !empty($data['bestRent']) ): ?>
        <p>La salle la plus louée est la <strong><?= $data['bestRent']['salleTitre'] ?></strong>, avec <strong><?= $data['bestRent']['rentCount'] ?></strong> locations.</p>
      <?php endif; ?>

      <?php if ( !empty($data['bestClient']) ): ?>
        <p>Le meilleur client a pour pseudo <strong><?= $data['bestClient']['membrePseudo'] ?></strong>, avec <strong><?= $data['bestClient']['rentCount'] ?></strong> commandes à son actif.</p>
      <?php endif; ?>

      <?php if ( !empty($data['chiffreAffaire']['chiffreAffaire']) ): ?>
        <p>Lokisalle a jusqu'à maintenant enregistré un chiffre d'affaires de <strong><?= $data['chiffreAffaire']['chiffreAffaire'] ?> €</strong>.</p>
      <?php endif; ?>

      <?php if (
        empty($data['bestSalle'])
        && empty($data['bestRent'])
        && empty($data['bestClient'])
        && empty($data['chiffreAffaire']['chiffreAffaire'])
      ): ?>
        <p class="tleft">L'activité du site est pour l'instant insuffisante pour fournir des statistiques valables. Merci de revenir une fois que quelques commandes auront été enregistrées.</p>
      <?php endif; ?>

    </div>

    <p><a href="<?= racine() ?>/">Retour à l'accueil</a></p>

  </div>
</div>
