define(function (require) {
    loadCss('/media/styles/admin/panel.css');
    require(['riotjs'], function(Riot, template) {
        riot = Riot;

        $('body').prepend('<script src="/media/scripts/admin/templates/panel.html" type="riot/tag"></script>');
        $('body').prepend('<panel id="admin_panel"></panel>');

        riot.mount('panel', {title: 'GRASS'});

        $.cookie('grass_panel', 1, { expires : 30 });
    });
});
