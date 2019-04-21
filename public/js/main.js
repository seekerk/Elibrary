function displayBibl(button)
{
    var parent = button.parentNode.parentNode;
    bibl = $(parent).children(".d-none").html();
    $('.modal-body').html(bibl);
    $('#bibl').modal('show');
}