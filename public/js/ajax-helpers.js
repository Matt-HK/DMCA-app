(function() {
    var submitAjaxRequest = function(e) {
        var form = $(this);
        var method = form.find('input[name="_method"]').val() || 'POST';

        $.ajax({
            type: method,
            url: form.prop('action'),
            data: form.serialize(),
            success: function() {
                $.publish('form.submitted', form);
            }
        })

        e.preventDefault();
    };


    // Form marked with the 'data-remote' attribute will but via ajax
    $('form[data-remote]').on('submit', submitAjaxRequest);

    $('*[data-click-submits-form]').on('change', function() {
        $(this).closest('form').submit();
    })
})();