// add collection 
$(document).ready(function () {
    $(".container").on('click', '#add-image', function (e) {
        e.preventDefault();
        $("#image-logo-input").click();
    })
    $(".container").on('click', '#save-collection', function (e) {
        e.preventDefault();
        var nameCollection = $("#collection-name").val()
        var file = $("#image-logo-input").prop('files')[0];
        // console.log(file)
    })
});