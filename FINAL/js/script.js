$(function () {
    // footer with year
    var date = new Date(); 
    $('#footer-content').html('Copyright © ' + date.getFullYear() + ' Christophe Damas');

    // load list
    $('data-table').load("sites/table.html", function () {
        $.getScript("js/table.js", function () { });
    });

    $('#modal2').modal();
    $('#delModal').modal();

    $('.save').click(function () {
        console.log("save")
        var id = $('#id').val();
        // console.log(id);
        // console.log('click submit');
        $.ajax({
            type: "POST",
            url: "api.php?id=" + id,
            data: {
                name: $('#name').val(),
                kraftstoff: $('#kraftstoff').val(),
                color: $('#color').val(),
                bauart: $('#bauart').val(),
                tank: $('#tank').val()
            },
            dataType: "JSON",
            success: function (response) {
                console.log('post success');
                console.log(response);
                console.log(data);
            }
        })
        M.toast({html: modus + " - Saved", classes: 'green white-text'})
        getData();
    });
    
    $('.cancel').click(function () {
        console.log("cancel")
        M.toast({html: modus + " - Canceled", classes: 'red white-text'})
    })

    

    $('.deleteToast').click(function () {
        console.log("deleted")
        $.ajax({
            type: "DELETE",
            url: "api.php?id=" + id,
            dataType: "JSON",
            success: function (response) {
                console.log("delete success");
                getData();
            }
        });
        M.toast({html: "Successfull Deleted", classes: 'green white-text'})
    })
    
});

var id;
var modus;

function showDelModal(id) {
    this.id = id;
    // console.log(id);
    $('#modal-main').load("sites/delModal.html", function () {
        $('#modal-title').html("Delete");
        $('#elementID').html(" '" + id + "' ");
    });

}

function showModal(id, modus) {
    this.id = id;
    this.modus = modus;
    
    $('#modal-content').load("sites/formular.html", function () {
        $.getScript("js/formular.js")
    });

}