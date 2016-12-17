modalWindow = {
     showModal:function(hmml, x, y) {
        $('.modal-bg').css({
            'width': '100%',
            'height': '100%',
            'display':'block'
        });

        $('.modal-window').css({
            'position': 'fixed',
            'width': 'auto',
            'height': 'auto',
            'border': '2px',
            'border-style': 'solid',
            'border-color': '#EB0C44',
            'background': '#FFFFFF',
            'margin-left': x + 'px',
            'margin-top': y +'px',
            'display': 'block',
        });
        $('.modal-window').html(hmml);
    },

     modalBgClick: function(){
         $('.modal-bg').css({'width': 0, 'height': 0});
         $('.modal-window').css({'width': 0, 'height': 0, 'border': 'none', 'padding': '0px'});
         $('.modal-window').html('');
     }
}
