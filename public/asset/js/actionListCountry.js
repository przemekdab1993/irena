
$( document ).ready(() => {

    setTimeout(() => {
        $('.js-set-visited').on('click', (event) => {
            event.preventDefault();

            let $icon = $(event.currentTarget).find('i');

            const countryId = $(event.currentTarget).data('countryId');
            const action = $(event.currentTarget).data('action');
            const $row = $(event.currentTarget).closest('tr');
            const $count = $row.find('.js-count-user-visited');

            $.ajax({
                url: `/set-country-visited/${countryId}/${action}`,
                method: 'GET',

                success: function (data, textStatus, request) {
                    console.log('Submission was successful.');
                    console.log($(this));
                },
                error: function(jqXHR, textStatus, errorMessage) {
                    console.log('An error occurred.');
                    if (jqXHR.responseJSON) {
                    }
                }
            }).then(function(data) {
                if (data.action === 'add') {
                    $count.text(+$count.text() + 1);
                    $(event.currentTarget).addClass('d-none');
                    $row.find('.js-remove-visited').removeClass('d-none');

                } else {
                    $count.text(+$count.text() - 1);
                    $(event.currentTarget).addClass('d-none');
                    $row.find('.js-add-visited').removeClass('d-none');
                }

            });

        });

    },5000);

});