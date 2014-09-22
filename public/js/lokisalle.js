var setDisplayer = function () {

    var displayers = document.querySelectorAll('[data-toggle="display"]');
    var i = 0;
    var displayersNumber = displayers.length;

    for (i; i < displayersNumber; i++) {
        displayers[i].onclick = function () {
            document.getElementById( this.getAttribute('data-target') ).classList.toggle('display');
            this.classList.toggle('active');
        };
    }
}

window.onload = setDisplayer;
