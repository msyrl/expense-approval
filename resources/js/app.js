require('./bootstrap');
require('admin-lte/dist/js/adminlte')

$(window)
    .on('load', function () {
        $('#page-loader').hide();
        $('[tooltip]').tooltip();
    })
    .on('beforeunload', function () {
       $('#page-loader').show();
    });
