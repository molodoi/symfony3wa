$( document ).ready(function() {
    var clickOffConfirmed = false;

    $('#isActive').on('click', '.my-active', function(event) {
        event.preventDefault();

        activeComment = $(this);
        activeCommentHref = activeComment.attr('href');

        var currentSpan = activeComment.children('span');
        var currentClass = currentSpan.attr('class');

        if(currentClass === 'label label-success'){
            currentSpan.removeClass('label label-success');
            currentSpan.addClass('label label-warning');
            currentSpan.text('Désactiver');
        }else{
            currentSpan.removeClass('label label-warning');
            currentSpan.addClass('label label-success');
            currentSpan.text('Activer');
        }

        $.ajax({
            type: 'GET',
            url: activeCommentHref,
            success: function (data) {

            },
            error: function () {
                alert('La requête n\'a pas abouti');
            }
        });
    });

    $('#product-detail').on('click', '.btn-danger', function(event) {
        event.preventDefault();
        if (confirm("Etes-vous sure?")) {
            currentLink = $(this);
            currentLinkHref = currentLink.attr('href');
            currentLink.closest('tr').fadeOut(600,function(){
                $(this).remove();
            });


            $.ajax({
                type:"GET",
                url: currentLinkHref
            }).done(function(){
                currentLink.parents('tr').fadeOut(600,function(){
                    $(this).remove();
                });
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