<!DOCTYPE html>
<html>
  <head>
    <title>Lokisalle</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel='stylesheet' href='//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Open+Sans+Condensed:300,700'>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/stylesheet/lokisalle.min.css">
  </head>
  <body>

<header class="main-header blc">
  <div class="ctn">
<?php if ( Session::userIsLoggedIn() ): ?>
    <div class="quick-access">
      Bonjour <em><?php echo Session::get('user.nom'); ?></em> !
    </div>
<?php endif; ?>
    <div class="quick-access">
<?php if ( Session::userIsLoggedIn() ): ?>
      <a href="/login/dologout">Déconnexion</a> |
<?php else: ?>
      <a href="/login">Connexion</a> |
      <a href="/registration">Inscription</a> |
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
      <li class="menu-item"><i class="fa fa-book"></i>&nbsp; <a href="#">Réservation</a></li>
      <li class="menu-item"><i class="fa fa-search"></i>&nbsp; <a href="">Recherche</a></li>
      <li class="menu-item"><i class="fa fa-user"></i>&nbsp; <a href="/login">Espace personnel</a></li>
      <li class="menu-item"><i class="fa fa-lightbulb-o"></i>&nbsp; <a href="#">À propos</a></li>
    </ul>
<?php if ( Session::userIsLoggedIn() && Session::userIsAdmin() ): ?>
    <div class="sub-menu">
      <button type="button" class="toggle-collapse">Administration</button>
      <ul class="menu-collapse">
        <li class="menu-item"><a href="/gestionsalles">Gestion des salles</a></li>
        <li class="menu-item"><a href="#">Gestion des produits</a></li>
        <li class="menu-item"><a href="#">Gestion des membres</a></li>
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
