$(function(){

    if($.cookie('grass_panel')){
        require(['panel']);
    }

   $('#admin_link').on('click', function(e){
       e.preventDefault();
       require(['panel']);
   });

});

require.config({
    baseUrl: 'media/scripts',
    paths: {
        'doT': 'vendor/dot',
        'riotjs': 'vendor/riot+compiler',
        'panel': 'admin/panel',
        'text': 'vendor/text'
    },
    shim: {
        riotjs: {
            exports: 'riot'
        }
    }
});

var riot;

function loadCss(url) {
    var link = document.createElement("link");
    link.type = "text/css";
    link.rel = "stylesheet";
    link.href = url;
    document.getElementsByTagName("head")[0].appendChild(link);
}