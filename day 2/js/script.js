getData();

function getData(){

    $.ajax({
        type: "get",
        url: "data/dataEXAMPLE.json",
        // data: "data",
        dataType: "JSON",
        success: function (response) {
            // console.log(response);
            var templateExample = $('#templateExample').html();
            // console.log(templateExample);
            var html= Mustache.render(templateExample, response);
            M.toast({ html: 'Daten wurden geladen', classes : 'green black-text'})
            // console.log(html);
            $('tbody').html(html);
    
    
            $('.tanken').click( function (){
                var id = $(this).parent().attr('data-id')
                console.log(id)
                $('#dataIDTnk').text(" '" + id + "' ");
            });
            $('.edit').click( function (){
                var id = $(this).parent().attr('data-id')
                console.log(id)
                $('#dataIDEdi').text(" '" + id + "' ");
            });
            $('.delete').click( function (){
                var id = $(this).parent().attr('data-id')
                console.log(id)
                $('#dataIDDel').text(" '" + id + "' ");
                M.toast({ html: 'Daten wurden geladen', classes : 'red-text'})
                getData();
            });
        }
    });
}
