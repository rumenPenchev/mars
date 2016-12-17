map = {
    zoomIn: function ()
    {
        var scale = parseInt(document.getElementById("g_id").getAttribute("transform").replace(/\D/g,''));
        if (scale <6) {
            document.getElementById("g_id").setAttribute("transform", "scale("+(scale+1)+")");
        }
    },

    zoomOut: function()
    {
        var scale = parseInt(document.getElementById("g_id").getAttribute("transform").replace(/\D/g,''));
        if (scale >1) {
            document.getElementById("g_id").setAttribute("transform", "scale("+(scale-1)+")");
        }
    },

    toLeft: function()
    {
        var map = document.getElementById('map');
        var x = parseInt(map.getAttribute('x'));
        map.setAttribute("x", (x-10));
        var colonies = document.getElementsByTagName("circle");
        var cx;
        for(let i = 0, len = colonies.length; i < len; i += 1)
        {
            cx = parseInt(colonies[i].getAttribute('cx'));
            colonies[i].setAttribute("cx", (cx-10));
        }
    },

    toRight: function()
    {
        var map = document.getElementById('map');
        var x = parseInt(map.getAttribute('x'));
        map.setAttribute("x", (x+10));
        var colonies = document.getElementsByTagName("circle");
        var cx;
        for(let i = 0, len = colonies.length; i < len; i += 1)
        {
            cx = parseInt(colonies[i].getAttribute('cx'));
            colonies[i].setAttribute("cx", (cx+10));
        }
    },

    toUp: function()
    {
        var map = document.getElementById('map');
        var y = parseInt(map.getAttribute('y'));
        map.setAttribute("y", (y-10))
        var colonies = document.getElementsByTagName("circle");
        var cy;
        for(let i = 0, len = colonies.length; i < len; i += 1)
        {
            cy = parseInt(colonies[i].getAttribute('cy'));
            colonies[i].setAttribute("cy", (cy-10));
        }
    },

    toDown: function()
    {
        var map = document.getElementById('map');
        var y = parseInt(map.getAttribute('y'));
        map.setAttribute("y", (y + 10))
        var colonies = document.getElementsByTagName("circle");
        var cy;
        for (let i = 0, len = colonies.length; i < len; i += 1) {
            cy = parseInt(colonies[i].getAttribute('cy'));
            colonies[i].setAttribute("cy", (cy + 10));
        }
    },

    setEnemy: function(id)
    {
        var  html = 'ENEMY '+id;
        document.getElementById('enemy').innerHTML = html;
        $(document).trigger('enemy');
    }
};