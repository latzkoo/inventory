$(window).bind("load", function () {

    $(".button-delete").on("click", function() {
        let href = $(this).data("href");
        $("#link-delete").attr("href", href);

        $("#deleteModal").modal({
            show: true,
            keyboard: false
        });
    });

});
