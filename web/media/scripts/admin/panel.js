define(function (require) {
    loadCss('/media/styles/admin/panel.css');
    require(['doT', 'text!admin/templates/panel.html'], function(doT, template) {

        var tempFn = doT.template(template);

        var resultText = tempFn({foo: 'with doT'});
        $('body').prepend(resultText);

        //$.cookie('grass_panel', 1, { expires : 30 });
    });
});
