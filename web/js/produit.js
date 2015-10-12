
$( document ).ready(function() {
    var clickOffConfirmed = false;

    $('#product-detail').on('click', '.btn-danger', function(event) {
        event.preventDefault();
        if (confirm("Etes-vous sure?")) {
            currentLink = $(this);
            currentLinkHref = currentLink.attr('href');
            currentLink.closest('tr').fadeOut(600,function(){
                $(this).remove();
            });

            /*
            $.ajax({
                type: 'GET',
                url: currentLinkHref,
                success: function (data) {
                    currentLink.closest('tr').fadeOut(600,function(){
                        $(this).remove();
                    });
                },
                error: function () {
                    alert('La requête n\'a pas abouti');
                }
            });
            */
        }
    });
});