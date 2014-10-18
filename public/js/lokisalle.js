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
