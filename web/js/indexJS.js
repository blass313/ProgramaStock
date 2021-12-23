$(document).ready(function() {
    $('button[title=Apply]').click(function(e) {
        e.preventDefault();
        $('#tabla').load('index.php');
    });
});