function makeWell() {
    $.ajax({
        type: 'POST',
        url: path,
        data: { user_id: 123456 },
        data_type: 'json',
        success: function(json) {
            console.log(json);
        }
    });
};

$( document ).ready(function() {
    setInterval(function()
    {
        $.ajax({
            type: 'GET',
            url: assets_path,
            data_type: 'html',
            success: function(html) {
                $('#assets').html(html);
            }
        });
    }, 30000);
});