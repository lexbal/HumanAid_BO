function formDataChange(btnModifier, url)
{
    let _form = btnModifier.closest('form');
    let _data = {};

    _data[btnModifier.attr('name')] = btnModifier.val();

    $.ajax(
        {
            url : url,
            type: _form.attr('method'),
            data : _data,
        }
    ).then(
        function (html) {
            $('#div-ajax').replaceWith(
                $(html).find('#div-ajax')
            );
        }
    );
}