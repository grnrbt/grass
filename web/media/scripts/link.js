$(function(){

    function openPanel(){
        require(['panel']);
        $('#admin_link').hide();
    }

    if($.cookie('grass_panel')){
        openPanel();
    }

   $('#admin_link').on('click', function(e){
       e.preventDefault();
       openPanel();
   });

});

require.config({
    baseUrl: 'media/scripts',
    paths: {
    //    'doT': 'vendor/dot',
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