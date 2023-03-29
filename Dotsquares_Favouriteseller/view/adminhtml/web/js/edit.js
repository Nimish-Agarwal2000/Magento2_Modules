define([
    "jquery"
], function ($) {
    'use strict';
    $.widget('rmamarketplace.edit', {
        options: {},
        _create: function () {
            $(document).ready(function () {
                $('#save').on('click',function(){
                    if($('#edit_form').valid()){
                        $('body').trigger('processStart');
                    }
                    
                });
            });
        }
    });
    return $.rmamarketplace.edit;
});
