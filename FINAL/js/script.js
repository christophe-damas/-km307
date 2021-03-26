$(function () {
    // footer with year
    var date = new Date(); 
    $('#footer-content').html('Copyright © ' + date.getFullYear() + ' Christophe Damas');

    // load list
    $('data-table').load("sites/table.html", function () {
        $.getScript("js/table.js", function () { });
    });

    
});