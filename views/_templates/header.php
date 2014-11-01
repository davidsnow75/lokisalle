<!DOCTYPE html>
<html>
  <head>
    <title>Lokisalle</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel='stylesheet' href='//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Open+Sans+Condensed:300,700'>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= assetdir() ?>/css/lokisalle.min.css">
  </head>
  <body>

<?php if ( DEBUG ): ?>
<div class="debug cf">
  <span class="debug__displayer js-toggle <?= DEBUG_AGGRESSIF ? 'active' : '' ?>" data-target="#debug__content">Informations de débogage <i class="fa fa-cogs"></i></span>
  <div id="debug__content" class="debug__content <?= DEBUG_AGGRESSIF ? 'active' : '' ?>">
    <?php $log = Session::flashget('debug'); ?>

    <?php foreach($log as $log_item_key => $log_item): ?>

      <?php
      switch ($log_item_key):
        case 'url'        : $item = 'URL traitée'; break;
        case 'controller' : $item = 'Contrôleur'; break;
        case 'action'     : $item = 'Action'; break;
        case 'parameters' : $item = 'Paramètres'; break;
        case 'get'        : $item = '$_GET'; break;
        case 'post'       : $item = '$_POST'; break;
        default           : $item = $log_item_key;
      endswitch;
      ?>

      <div class="debug__log-item">
        <span class="debug__key"><?= $item ?></span>
        <?= $log_item ?>
      </div>

    <?php endforeach; ?>

      <div class="debug__log-item">
        <span data-target="#session-dump" class="debug__key js-toggle">$_SESSION</span>
        <span class="debug__log debug__log--compound" id="session-dump"><?php var_dump($_SESSION); ?></span>
      </div>

  </div>
</div>
<?php endif; ?>

<header class="main-header blc">
  <div class="ctn">
<?php if ( Session::userIsLoggedIn() ): ?>
    <div class="quick-access">
      Bonjour <em><?php echo Session::get('user.nom'); ?></em> !
    </div>
<?php endif; ?>
    <div class="quick-access">
<?php if ( Session::userIsLoggedIn() ): ?>
      <a href="<?= racine() ?>/deconnexion">Déconnexion</a> |
<?php else: ?>
      <a href="<?= racine() ?>/connexion">Connexion</a> |
      <a href="<?= racine() ?>/inscription">Inscription</a> |
<?php endif; ?>
      <a href="<?= racine() ?>/contact">Contact</a>
    </div>
    <div class="logo">
      <div class="majeur"><a href="<?= racine() ?>/">Lokisalle</a></div>
      <div class="mineur">La solution flexible à vos besoins de location de salles</div>
    </div>
  </div>
</header>

<nav class="main-menu blc">
  <div class="ctn">
    <ul>
      <li class="menu-item current-menu-item"><i class="fa fa-home"></i>&nbsp; <a href="<?= racine() ?>/">Accueil</a></li>
      <li class="menu-item"><i class="fa fa-book"></i>&nbsp; <a href="<?= racine() ?>/reservation">Réservation</a></li>
      <li class="menu-item"><i class="fa fa-search"></i>&nbsp; <a href="<?= racine() ?>/recherche">Recherche</a></li>
      <?php if ( Session::userIsLoggedIn() && Session::get('panier.produits')): ?>
      <li class="menu-item"><i class="fa fa-shopping-cart"></i>&nbsp; <a href="<?= racine() ?>/panier">Panier</a></li>
    <?php endif; ?>
      <li class="menu-item"><i class="fa fa-user"></i>&nbsp; <a href="<?= racine() ?>/connexion">Espace personnel</a></li>
      <li class="menu-item"><i class="fa fa-lightbulb-o"></i>&nbsp; <a href="<?= racine() ?>/mentions">À propos</a></li>
    </ul>
<?php if ( Session::userIsLoggedIn() && Session::userIsAdmin() ): ?>
    <div class="sub-menu">
      <span data-target="#menu-administration" class="displayer js-toggle">Administration</span>
      <ul id="menu-administration" class="admin-menu">
        <li class="menu-item"><a href="<?= racine() ?>/gestionsalles">Gestion des salles</a></li>
        <li class="menu-item"><a href="<?= racine() ?>/gestionproduits">Gestion des produits</a></li>
        <li class="menu-item"><a href="<?= racine() ?>/gestionmembres">Gestion des membres</a></li>
        <li class="menu-item"><a href="<?= racine() ?>/gestioncommandes">Gestion des commandes</a></li>
        <li class="menu-item"><a href="<?= racine() ?>/gestionavis">Gestion des avis</a></li>
        <li class="menu-item"><a href="<?= racine() ?>/gestionpromotions">Gestion des codes promo</a></li>
        <!-- <li class="menu-item"><a href="<?= racine() ?>/gestionstats">Statistiques</a></li> -->
        <li class="menu-item"><a href="<?= racine() ?>/gestionnewsletter">Newsletters</a></li>
      </ul>
    </div>
<?php endif; ?>
  </div>
</nav>
