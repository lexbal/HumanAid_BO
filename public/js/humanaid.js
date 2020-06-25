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