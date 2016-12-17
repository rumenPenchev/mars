$( document ).ready(function() {
    setInterval(function()
    {
        $.ajax({
            type: 'GET',
            url: mes_read_path,
            data_type: 'html',
            success: function (html) {
                $("#mesages-in").html(html);
            }
        });
    }, 5000);
});

function newMessage() {
    $.ajax({
         type: 'POST',
         data:
          {
              m_to: $('#message-to').text(),
              message: $('#message').val()
         },
         url: mes_send_path,
         data_type: 'json',
         success: function(json) {
            console.log(json);
            $('#message').val('');
         }
     });
    modalWindow.modalBgClick();
}

function newFromList(enemy) {
    $('#message-to').text(enemy);
}

//new on map
$(document).on( 'enemy', function() {
    $('#message-to').text($('#enemy').text());
});