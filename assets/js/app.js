require('../css/app.css');

const $ = require('jquery');

$(document).ready(function () {

    $.fn.rowCount = function() {
        return $('tr', $(this).find('tbody')).length;
    };

    for(let i=1; i <= 6; i++){

        let tableId = '#sixRowsTable'+i;
        let rowCount = $(tableId).rowCount();
        let str = ' tbody';
        if(rowCount === 0){
            $(tableId + str).append
            ('' +
                '<tr>' +
                    '<td>Brak danych</td>' +
                    '<td>Brak danych</td>' +
                    '<td>Brak danych</td>' +
                    '<td>Brak danych</td>' +
                    '<td>Brak danych</td>' +
                    '<td>Brak danych</td>' +
                '</tr>'
            );
        }
    }

    let rowCountUps = $('#upsTable').rowCount();
    if(rowCountUps === 0){
        $('#upsTable tbody').append
        ('' +
            '<tr>' +
            '<td>Brak danych</td>' +
            '<td>Brak danych</td>' +
            '<td>Brak danych</td>' +
            '<td>Brak danych</td>' +
            '<td>Brak danych</td>' +
            '<td>Brak danych</td>' +
            '<td>Brak danych</td>' +
            '<td>Brak danych</td>' +
            '</tr>'
        );
    }

    let rowCountProbit = $('#probitUsersTable').rowCount();

    if(rowCountProbit === 0){
        $('#probitUsersTable tbody').append
        ('' +
            '<tr>' +
            '<td>Brak danych</td>' +
            '<td>Brak danych</td>' +
            '<td>Brak danych</td>' +
            '<td>Brak danych</td>' +
            '</tr>'
        );
    }


    $(".alert-modal").modal('show');

    setTimeout(function(){
        $('.alert-modal').modal('hide')
    }, 1000);


    // ===== Scroll to Top ====
    $(window).scroll(function() {
        if ($(this).scrollTop() >= 200) {
            $('#return-to-top').fadeIn(200);
        } else {
            $('#return-to-top').fadeOut(200);
        }
    });
    $('#return-to-top').click(function() {
        $('body,html').animate({
            scrollTop : 0
        }, 500);
    });


});




