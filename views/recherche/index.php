<div class="main-content blc">
  <div class="ctn">

    <h1>Recherche d'un produit Lokisalle</h1>

    <form action="<?= racine() ?>/recherche/resultat" method="post" class="form">
      <fieldset>
        <legend>Recherche d'un produit disponible</legend>

        <p>Tous les champs sont facultatifs et se combinent entre eux.</p>

        <label>Au mois de&nbsp;:</label>
        <select name="mois">
          <?php $mois = [ 'Indifférent', 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre' ]; ?>
          <?php foreach ($mois as $key => $mois): ?>
          <option value="<?= $key ?>"><?= $mois ?></option>
          <?php endforeach; ?>
        </select>

        <label>À l'année&nbsp;:</label>
        <select name="annee">
          <option value="0">Indifférent</option>
          <?php for ( $i = 2014; $i < 2021; $i++ ): ?>
          <option value="<?= $i ?>"><?= $i ?></option>
          <?php endfor; ?>
        </select>

        <label>Dont la description de salle comprend&nbsp;:</label>
        <small><em>Note: séparez les éventuels mots-clés (4 maximum) par le caractère suivant&nbsp;:</em></small> | <sub>(AltGr + 6)</sub>
        <input type="text" name="keywords">

        <input type="submit">
      </fieldset>
    </form>

    <?php if ( isset($data['produits']) ): ?>

    <h2>Résultat de votre recherche</h2>

      <?php
        $recherche = $data['recherche'];

        if ( empty($recherche['mois']) && empty($recherche['annee']) && empty($recherche['keywords']) ) {
          $output = 'Vous n\'avez spécifié aucun critère, voici donc tous les produits disponibles.';

        } else {

          $output = 'Vous recherchez un produit';

          if ( $recherche['mois'] ) {
            $output .= ' commençant au mois de <strong>' . $recherche['mois'] . '</strong>';
          }

          if ( $recherche['annee'] ) {
            $output .= ' de l\'année <strong>' . $recherche['annee'] . '</strong>';
          }

          if ( $recherche['keywords'] ) {
            $output .= ' dont la salle a une description qui comporte le(s) mot(s)-clé(s) suivant(s) : <strong>' . implode('</strong>, <strong>', $recherche['keywords']) . '</strong>';
          }

          $output .= '.';
        }
      ?>

      <p><?= $output ?></p>

      <?php if ( empty($data['produits']) ): ?>

        <p>Aucun produit disponible et correspondant à vos éventuels critères de recherche n'a été trouvé.</p>

      <?php else: ?>

        <?php $count = count($data['produits']); ?>

        <?php if ( $count == 1 ): ?>
          <p>Un produit a été trouvé avec vos critères de recherche !</p>
        <?php else: ?>
          <p><?= $count ?> produits ont été trouvés avec vos critères de recherche !</p>
        <?php endif; ?>

        <div class="lgn">
        <?php foreach($data['produits'] as $produit): ?>
          <div class="col sm6"><?php showProduit($produit); ?></div>
        <?php endforeach; ?>
        </div>

      <?php endif; ?>

    <?php endif; ?>

    <p><a href="<?= racine() ?>/">Retour à l'accueil</a></p>

  </div>
</div>
