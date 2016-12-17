function makeArmyField(){
    $.ajax({
        type: 'GET',
        url: army_field_path,
        data_type: 'html',
        success: function (html) {
            $('#army-field').html(html);
        }
    });
}

function prepArmyRes(path,army_id) {
    if(army_id != 0){
        path = path + '/'+army_id;
    }
    $.ajax({
        type: 'GET',
        url: path,
        data_type: 'html',
        success: function (html) {
            modalWindow.showModal(html, 100, 100);
        }
    });
}

function makeNewArmy() {
   $.ajax({
         type: 'POST',
         data: $('.new-army-res input[type=\'text\'], .new-army-res input[type=\'hidden\']') ,
         url: new_army_path,
         data_type: 'json',
         success: function(json) {
             makeArmyField();

         }
     });
    modalWindow.modalBgClick();
}


function disbandingArmy(path,army_id) {
    $.ajax({
        type: 'GET',
        url: path + '/' +army_id ,
        data_type: 'json',
        success: function(json) {
            makeArmyField();
        }
    });
}

function setArmyTarget(path,army_id) {
    $.ajax({
        type: 'POST',
        url: path ,
        data:{
            army_id: army_id,
            target: $('#army-enemy').text()
        },
        data_type: 'json',
        success: function(json) {
            makeArmyField();
        }
    });
}

//new on map
$(document).on( 'enemy', function() {
    $('#army-enemy').text('Set ' +$('#enemy').text()+ ' As Target');
});

function startWar(path, army_id) {
    $.ajax({
        type: 'POST',
        data:
            {
                army_id: army_id,
            },
        url: path,
        data_type: 'json',
        success: function(json) {
            console.log(json);
            makeArmyField();
        }
    });
}

$( document ).ready(function() {
    setInterval(function()
    {
        $.ajax({
            type: 'GET',
            url: war_path,
            data_type: 'json',
            success: function (json) {
                if(json.danger){
                    $('#main-h').text(json.danger);
                } else {
                    $('#main-h').text('MISSION COMMAND CENTER');
                }

                makeArmyField();
            }
        });
    }, 10000);
});