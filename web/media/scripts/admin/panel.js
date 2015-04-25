define(function (require) {
    loadCss('/media/styles/admin/panel.css');
    require(['riotjs'], function(Riot, template) {
        riot = Riot;
// include basic html
        var $body = $('body');
        $body.prepend('<script src="/media/scripts/admin/templates/panel.html" type="riot/tag"></script>');
        $body.prepend('<panel id="admin_panel"></panel>');

// init
        var panel = new Panel();
        var modules = {
            'settings': {'title': 'Настройки'},
            'users': {'title': 'Пользователи'}
        };


        riot.mount('panel', {panel: panel});

        function Panel(){

            riot.observable(this);
            var self = this;
            this.on('update', function(){
                $.get('/admin')
                    .success(function(items) {
                        self.items = items;
                        self.trigger('redraw');
                        $('#admin_panel').slideDown();
                    });

            });

            this.on('updateTitle', function(title){
                this.title = 'GRASS';
                if(title){
                    this.title += ': ' + title;
                }
                self.trigger('redraw');
            });

            this.on('redraw', function(){

            });

        }

// routing
        riot.route.exec(router);

        riot.route(router);

        function router(module, controller, action) {

            panel.trigger('updateTitle', modules[module] ? modules[module]['title'] : '');
            console.log(module);
            console.log(controller);
            console.log(action);
        }

// save panel state
        $.cookie('grass_panel', 1, { expires : 30 });
    });
});
