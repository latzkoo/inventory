$(window).bind("load", function () {

    $(".numeric").numeric();

    $(".button-delete").on("click", function() {
        let href = $(this).data("href");
        $("#link-delete").attr("href", href);

        $("#deleteModal").modal({
            show: true,
            keyboard: false
        });
    });

    $('form').on("submit", function() {
        $("button[type=submit]", $(this)).attr("disabled", "disabled");
    });

});
