$(document).ready(function() {
    $("#filter").keyup(function() {
        var filter = $(this).val(),
            count = 0;

        $(".liveSearchBar .card").each(function() {

            if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                $(this).closest(`.search-item`).fadeOut();
            } else {
                $(this).closest(`.search-item`).show();
                count++;
            }
        });
    });
});