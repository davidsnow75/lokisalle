function toggleCollapse() {

    var button  = document.getElementsByClassName( 'toggle-collapse' )[0];
    var element = document.getElementsByClassName( 'menu-collapse' )[0];

    button.onclick = function () {
        if ( element.style.display === 'block' ) {
            element.style.display = 'none';
        } else {
            element.style.display = 'block';
        }
    }
}

window.onload = toggleCollapse;
