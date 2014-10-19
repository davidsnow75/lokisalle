<!DOCTYPE html>
<html>
  <head>
    <title>Lokisalle</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel='stylesheet' href='//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Open+Sans+Condensed:300,700'>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/lokisalle.min.css">
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
        <a href="#session-dump" class="debug__key js-toggle">$_SESSION</a>
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
      <a href="/deconnexion">Déconnexion</a> |
<?php else: ?>
      <a href="/connexion">Connexion</a> |
      <a href="/inscription">Inscription</a> |
<?php endif; ?>
      <a href="#">Contact</a>
    </div>
    <div class="logo">
      <div class="majeur"><a href="/">Lokisalle</a></div>
      <div class="mineur">La solution flexible à vos besoins de location de salles</div>
    </div>
  </div>
</header>

<nav class="main-menu blc">
  <div class="ctn">
    <ul>
      <li class="menu-item current-menu-item"><i class="fa fa-home"></i>&nbsp; <a href="/">Accueil</a></li>
      <li class="menu-item"><i class="fa fa-book"></i>&nbsp; <a href="/reservation">Réservation</a></li>
      <li class="menu-item"><i class="fa fa-search"></i>&nbsp; <a href="">Recherche</a></li>
      <li class="menu-item"><i class="fa fa-user"></i>&nbsp; <a href="/connexion">Espace personnel</a></li>
      <li class="menu-item"><i class="fa fa-lightbulb-o"></i>&nbsp; <a href="#">À propos</a></li>
    </ul>
<?php if ( Session::userIsLoggedIn() && Session::userIsAdmin() ): ?>
    <div class="sub-menu">
      <a href="#menu-administration" class="displayer js-toggle">Administration</a>
      <ul id="menu-administration" class="admin-menu">
        <li class="menu-item"><a href="/gestionsalles">Gestion des salles</a></li>
        <li class="menu-item"><a href="/gestionproduits">Gestion des produits</a></li>
        <li class="menu-item"><a href="/gestionmembres">Gestion des membres</a></li>
        <li class="menu-item"><a href="#">Gestion des commandes</a></li>
        <li class="menu-item"><a href="#">Gestion des avis</a></li>
        <li class="menu-item"><a href="#">Gestion des codes promo</a></li>
        <li class="menu-item"><a href="#">Statistiques</a></li>
        <li class="menu-item"><a href="#">Newsletters</a></li>
      </ul>
    </div>
<?php endif; ?>
  </div>
</nav>
