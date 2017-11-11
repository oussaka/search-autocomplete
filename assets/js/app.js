import "bootstrap";
import "select2";

$(function () {

    $(".card").hide();

    $(".search").select2({
        theme: 'classic',
        placeholder: 'Type to search',
        ajax: {
            url: Routing.generate('search_accounts'),
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term
                }
            },
            processResults: function (data, params) {
                return {
                    results: data.suggestions
                }
            }
        },
        cache: true,
        minimumInputLength: 1
    });

    $(".search").on('select2:select', function (e) {
        $(".selected").html(e.params.data.username + ' ' + e.params.data.givenname)
        $(".email-selected").html(e.params.data.email)
        $(".card").show();
    });

})
