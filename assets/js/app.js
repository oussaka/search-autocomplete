import "bootstrap";

$(function () {
    $(".search").change(function (event) {

        let query = $(this).val();
        let $this = this;
        $.ajax({
            url: Routing.generate('search_accounts'),
            type: 'GET',
            data: {
                search: query,
            },
            success: function(data) {

                console.log(data)
            }
        })
    })

})
