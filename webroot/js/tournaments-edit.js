$(document).on("click", "a.delete", function(e) {
    var confirmation = confirm("Are you sure?");
    if(!confirmation) {
        e.preventDefault();
    }
});
