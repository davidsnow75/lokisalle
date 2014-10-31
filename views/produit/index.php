<div class="main-content blc">
  <div class="ctn">

    <h1>Détails d'un produit</h1>

    <?php $produit = $data['produit']; ?>

<?php /*
                      $produit['produitID']
                      $produit['produitDebut']
                      $produit['produitFin']
                      $produit['produitPrix']
                      $produit['produitEtat']
                      $produit['salleID']
                      $produit['sallePays']
                      $produit['salleVille']
                      $produit['salleAdresse']
                      $produit['salleCP']
                      $produit['salleTitre']
                      $produit['salleDescription']
                      $produit['sallePhoto']
                      $produit['salleCapacite']
                      $produit['salleCategorie']
*/ ?>

    <h2><?= $produit['salleTitre'] ?>, du <?= niceDate($produit['produitDebut']) . ' au ' . niceDate($produit['produitFin']) ?></h2>

    <p class="tcenter"><img src="<?= $produit['sallePhoto'] ?>" alt="<?= $produit['salleTitre'] ?>"></p>

    <div class="lgn">

      <div class="col sm6 paddingX produit">
        <h3>Informations</h3>
        <ul>
          <li><strong>ID du produit</strong>: <?= $produit['produitID'] ?></li>
          <li><strong>Date de début</strong>: <?= niceDate($produit['produitDebut']) ?></li>
          <li><strong>Date de fin</strong>: <?= niceDate($produit['produitFin']) ?></li>
          <li><strong>Prix</strong>: <?= $produit['produitPrix'] ?> €</li>
          <li><strong>État</strong>: <?= $produit['produitEtat'] ? 'Indisponible' : 'Disponible' ?></li>
        </ul>
        <ul>
          <li><strong>ID de la salle liée</strong>: <?= $produit['salleID'] ?></li>
          <li><strong>Titre</strong>: <?= $produit['salleTitre'] ?></li>
          <li><strong>Adresse</strong>: <?= $produit['salleAdresse'] ?></li>
          <li><strong>Code postal</strong>: <?= $produit['salleCP'] ?></li>
          <li><strong>Ville</strong>: <?= $produit['salleVille'] ?></li>
          <li><strong>Pays</strong>: <?= $produit['sallePays'] ?></li>
          <li><strong>Description</strong>: <div class="tjustify"><?= $produit['salleDescription'] ?></div></li>
          <li><strong>Capacité</strong>: <?= $produit['salleCapacite'] ?> personnes</li>
          <li><strong>Catégorie</strong>: <?= $produit['salleCategorie'] ?></li>
        </ul>
      </div><!-- /.col.sm6.paddingX -->

      <div class="col sm6 paddingX guestbook">
        <h3>Les 3 derniers avis sur la salle</h3>

        <?= displayMsg($data) ?>

        <?php if ( empty($data['avis']) ): ?>

          <p>Aucun avis n'a été laissé sur cette salle pour l'instant.</p>

        <?php else: ?>

          <?php foreach ( $data['avis'] as $avis ): ?>

            <div class="avis">
              <div class="avis__metadata cf">
                <div class="col xs10"><?= $avis['membrePseudo'] ? $avis['membrePseudo'] : 'Anonyme' ?>, le <?= niceDate($avis['avisDate']) ?> à <?= niceHour($avis['avisDate']) ?></div>
                <div class="col xs2 paddingX"><?= $avis['avisNote'] ?>/10</div>
              </div>
              <div class="avis__data">
                <p><em><?= $avis['avisCommentaire'] ?></em></p>
              </div>
            </div>

          <?php endforeach; ?>

        <?php endif; ?>

        <?php if ( Session::userIsLoggedIn() ): ?>

          <form class="form" method="post" action="<?= racine() ?>/produit/commenter">
            <fieldset class="cf">
              <legend>Laisser un avis</legend>

              <label>Avis&nbsp;:</label>
              <textarea name="commentaire"></textarea>

              <label>Note sur 10&nbsp;:</label>
              <select name="note">
                <?php for ($i = 0; $i < 11; $i++): ?>
                  <option value="<?= $i ?>"><?= $i ?></option>
                <?php endfor; ?>
              </select>

              <input type="hidden" name="salles_id" value="<?= $produit['salleID'] ?>">
              <input type="hidden" name="produit_id" value="<?= $produit['produitID'] ?>">

              <input type="submit">

            </fieldset>
          </form>

        <?php else: ?>

          <p><a href="<?= racine() ?>/connexion">Connectez-vous pour ajouter un avis</a></p>

        <?php endif; ?>
      </div><!-- /.col.sm6.paddingX -->

    </div>

    <?php if (!$produit['produitEtat']): ?>
    <p class="tright">
      <?php if ( Session::userIsLoggedIn() ): ?>
        <a href="<?= racine() ?>/panier/ajouter/<?= $produit['produitID'] ?>">Ajouter au panier</a>
      <?php else: ?>
        <a href="<?= racine() ?>/connexion">Connectez-vous pour l'ajouter au panier</a>
      <?php endif; ?>
    </p>
    <?php endif; ?>

    <h3>Produits similaires</h3>

    <?php if ( empty($data['similarProduits']) ): ?>
      <p>Pas de produits similaires à ce produit !</p>
    <?php else: ?>
      <p>Les produits suivants commence durant le même mois et se trouve dans la même ville que le produit dont vous avez demandé le détail.</p>
      <div class="lgn">
      <?php foreach($data['similarProduits'] as $produit): ?>
        <div class="col sm6"><?php showProduit($produit); ?></div>
      <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <p><a href="<?= racine() ?>/">Retour à l'accueil</a></p>

  </div>
</div>
