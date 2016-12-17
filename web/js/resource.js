function resPlaning(path) {
    if ($('#enemy').text().length > 3){
        path  += '/' + $('#enemy').text()
    }
    console.log(path)
    $.ajax({
        type: 'GET',
        url: path,
        data_type: 'html',
        success: function (html) {
            modalWindow.showModal(html, 100, 100);
        }
    });
}

function newOrder(descr_id) {
    $.ajax({
         type: 'POST',
         data:
          {
              in_production: $('#in_production').val(),
              descr_id: descr_id
         },
         url: order_path,
         data_type: 'json',
         success: function(json) {
            console.log(json);
         }
     });
    modalWindow.modalBgClick();
}

function newLevel(descr_id) {
    $.ajax({
        type: 'POST',
        data:
            {
                descr_id: descr_id,
                in_production: 1
            },
        url: level_path,
        data_type: 'json',
        success: function(json) {
            console.log(json);
        }
    });
    modalWindow.modalBgClick();
}

function send(descr_id) {
    $.ajax({
        type: 'POST',
        data:
            {
                descr_id: descr_id,
                qtty: $('#qtty-to-send').val(),
                to_id :$('#to_id').val()
            },
        url: send_path,
        data_type: 'json',
        success: function(json) {
            console.log(json);
        }
    });
    modalWindow.modalBgClick();
}