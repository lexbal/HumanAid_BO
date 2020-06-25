function formDataChange(btnModifier, url)
{
    let _form = btnModifier.closest('form');
    let _data = {};

    if (btnModifier.attr('name') === "user[roles]") {
        _data[btnModifier.attr('name')] = [btnModifier.val()];
    } else {
        _data[btnModifier.attr('name')] = btnModifier.val();
    }

    $.ajax(
        {
            url: url,
            type: _form.attr('method'),
            data: _data,
        }
    ).then(
        function (html) {
            $('#div-ajax').replaceWith(
                $(html).find('#div-ajax')
            );
        }
    );
}

$(
    function () {
        let container = $('div#addresses');

        $('body').on(
            'click', '#add_address', function (e) {
                e.preventDefault();
                let address    = $('#addresses .address:last');
                let address_id = address.attr("id");
                let index      = parseInt(address_id.substr(address_id.lastIndexOf('_') + 1)) + 1;
                let prototype  = $(
                    container.attr('data-prototype')
                    .replace(/__name__label__/g, 'Addresse n°' + (index))
                    .replace(/__name__/g, index)
                );

                $(this).before("<div id=\"address_" + index + "\" class=\"address\">" + prototype.html() + "<button type=\"button\" href=\"#\" class=\"btn btn-danger delete_address\">Supprimer</button></div>");

                index++;
            }
        ).on(
            'click', '.delete_address', function (e) {
                e.preventDefault();
                $(this).closest('.address').remove();
            }
        );
    }
);