/**
 * TOGGLERS
 *
 * Version: 1.2
 *
 * Au clic sur tout élément portant la classe 'js-toggle' :
 *     - ajoute/retire la classe 'active' aux classes de cet élément
 *     - ajoute/retire la classe 'active' aux classes des éventuels éléments
 *       identifiées par soit la valeur de l'attribut 'href' de cet élément,
 *       soit la valeur de son attribut 'data-target' (la priorité étant donnée
 *       à la valeur de l'attribut 'href' si les deux sont présents)
 */

/*jslint browser: true */

(function () {
    'use strict';

    var togglers,
        togglersNb,
        toggleActive,
        i;

    togglers = document.querySelectorAll('.js-toggle');
    togglersNb = togglers.length;

    toggleActive = function () {
        var target = this.getAttribute('href') || this.getAttribute('data-target');

        document.querySelector(target).classList.toggle('active');
        this.classList.toggle('active');
    };

    for (i = 0; i < togglersNb; i += 1) {
        togglers[i].addEventListener('click', toggleActive);
    }
}());


/*
 * HAUTOMATIC.JS
 * -------------
 *
 * Version: 2.0
 * Auteur: Erwan Thomas
 * Licence: MIT
 *
 * Synchronise automatiquement au moment de l'instanciation de l'objet la hauteur des éléments portant
 * la classe 'js-hautomatic' (ou le sélecteur CSS que l'on aura précisé en premier argument à la place) sur la hauteur
 * de l'élément le plus grand du lot.
 *
 * Argument 1: peut s'appliquer à un sélecteur CSS personnalisé (argument 'classe')
 * Argument 2: peut être désactivé en dessous d'une certaine largeur du viewport (argument 'breakpoint').
 * Argument 3: peut exécuter une fonction (argument 'callback') après avoir fixé les hauteurs.
 *             NOTE: le callback est une méthode l'objet hautomatic et a donc accès à ses méthodes et attributs.
 *             Cela se révèle particulièrement utile quand on veut récupérer la valeur de la hauteur maximale calculée.
 *
 * Exemple d'utilisation (évidemment à adapter en fonction de son besoin) :
 *      <script src="hautomatic.js"></script>
 *      <script>
 *           new hautomatic();
 *      </script>
 *
 * NOTE: on peut créer autant d'objet hautomatic que l'on veut en leur donnant à chaque fois
 * une classe différente à traiter.
 */

/*jslint browser: true, white: true */

var hautomatic = function (classe, breakpoint, callback) {
    'use strict';

    /* variables 'superglobales' de l'objet */
    var that, i;

    /* Initialisation des propriétés de l'hautomatic */
    this.classe = classe || '.js-hautomatic';
    this.breakpoint = breakpoint || { min: 0, max: 0 };
    this.callback = ( typeof callback === 'function' ) ? callback : false;

    /* On récupère un ensemble d'élément à gérer par instance */
    this.toBeSynced = document.querySelectorAll(this.classe);
    this.toBeSyncedNb = this.toBeSynced.length;

    /* La hauteur finale à appliquer, calculée via la méthode sync() */
    this.max = 0;

    that = this; /* pour rendre accessible l'objet dans ses méthodes */

    /*------------------------------*/
    /* SYNCHRONISATION DES ÉLÉMENTS */
    /*------------------------------*/
    this.sync = function () {

        var viewportWidth, hauteurs;

        /* récupération de la largeur du viewport */
        /* voir: http://stackoverflow.com/questions/1248081/get-the-browser-viewport-dimensions-with-javascript */
        viewportWidth = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);

        /* si on est en deça du breakpoint, s'arrête là */
        if ( viewportWidth < that.breakpoint.min ) {
            return;
        }

        if ( that.breakpoint.max && viewportWidth > that.breakpoint.max ) {
            return;
        }

        /* sinon on continue */
        hauteurs = [];

        for (i = 0; i < that.toBeSyncedNb; i += 1) {
          hauteurs[i] = parseFloat( that.toBeSynced[i].clientHeight );
        }

        that.max = Math.max.apply(Math, hauteurs);

        for (i = 0; i < that.toBeSyncedNb; i += 1) {
            that.toBeSynced[i].style.height = that.max+'px';
        }

        if ( that.callback ) {
            that.callback();
        }
    };

    /*---------------------------*/
    /* SURVEILLANCE DES ÉLÉMENTS */
    /*---------------------------*/
    this.watch = function () {
        for (i = 0; i < that.toBeSyncedNb; i += 1) {
          that.toBeSynced[i].style.height = 'auto';
        }

        that.sync();
    };

    /* activation des gestionnaires d'événements */
    if ( window.addEventListener ) {
        window.addEventListener('load', this.sync);
        window.addEventListener('resize', this.watch);

    } else { // IE
        window.attachEvent('onload', this.sync);
        window.attachEvent('onresize', this.watch);
    }

    /*return this;*/ /* à décommenter en cas de besoin... */
};

(function () {
    var hautomaticPanier = new hautomatic('.js-hautomatic-panier-photo', { min: 0, max: 767 });
}());
