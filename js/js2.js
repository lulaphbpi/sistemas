window.onload = function() {
    var minutesToLogout = 5 * 60 * 1000; // Configure o tempo que achar melhor
    var logoutUrl = 'index.php'; // Configure a URL de logout

    var lastModified = Date.now();
    var html = document.getElementsByTagName('html')[0];
    var setLastModified = function(){lastModified = Date.now();}

    html.onmousemove = setLastModified;
    html.onkeypress = setLastModified;

	alert('js2');

}