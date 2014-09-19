<div class="main-content blc">
  <div class="ctn">

<?php if ( $data['msg'] ): ?>
    <p style="color: red;"><?= $data['msg'] ?></p>
<?php endif; ?>

<?php if ( $data['salles'] === [] ): ?>
    <p>Aucune salle n'a été créée pour l'instant.</p>
<?php else: ?>
    <p>Voici la liste des salles existantes&nbsp;:</p>
<?php endif; ?>

  </div>
</div>
