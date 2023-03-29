define([
    "jquery",
    "Magento_Ui/js/modal/confirm",
    "Magento_Ui/js/modal/alert",
    "jquery/ui",
], function ($, confirmation, alert) {
    'use strict';
    $.widget('rmamarketplace.cancel', {
        options: {},
        _create: function () {
            var self = this;
            var confirmationLabel = self.options.confirmationLabel;
            var cancelRmaLabel = self.options.cancelRmaLabel;
            $(document).ready(function () {
                $(".dots-cancel-rma").click(function (e) {
                    var url = $(this).attr("href");
                    confirmation({
                        title: confirmationLabel,
                        content: "<div class='rmamarketplace-warning-content'>"+cancelRmaLabel+"</div>",
                        actions: {
                            confirm: function () {
                                window.location.href = url;
                            },
                            cancel: function () {
                                return false;
                            },
                            always: function () {
                                return false;
                            }
                        }
                    });
                    return false;
                });
            });
        }
    });
    return $.rmamarketplace.cancel;
});
