define([
    "jquery",
    "Magento_Ui/js/modal/alert",
    "jquery/ui",
], function ($, alert) {
    'use strict';
    $.widget('rmamarketplace.rma', {
        options: {},
        _create: function () {
            var self = this;
            var totalPrice = self.options.totalPrice;
            var totalPriceWithCurrency = self.options.totalPriceWithCurrency;
            var errorMsg = self.options.errorMsg;
            var warningLable = self.options.warningLable;
            $(document).ready(function () {
                $(".dots-refund-amount").html(totalPriceWithCurrency);
                $(".dots-refundable-amount").html(totalPriceWithCurrency);
                $(".dots-refund-block").removeClass("dots-display-none");
                $(".dots-partial-amount").hide();
                $("#payment_type").change(function (e) {
                    var val = $(this).val();
                    if (val == 1) {
                        $(".dots-partial-amount").hide();
                        $("#partial_amount").removeClass("required-entry");
                    } else {
                        $(".dots-partial-amount").show();
                        $("#partial_amount").addClass("required-entry");
                    }
                });
                
                $("#dots_rma_conversation_form").submit(function(e){
                    var form = $("#dots_rma_conversation_form");
                    if($('#dots_rma_conversation_form').valid()){
                        if (form.data('submitted') === true) {
                            e.preventDefault();
                          } else {
                            form.data('submitted', true);
                          }
                        $('body').trigger('processStart');
                    }
                });

                $("#dots_new_rma_form").submit(function(e){
                    if($('#dots_rma_conversation_form').valid()){
                        $('body').trigger('processStart');
                    }
                });
                
                $("#dots-refund-online").click(function() {
                    $(".payment_status").val(0);
                });

                $(".dots-refund").click(function (e) {
                    if ($('#dots_rma_refund_form').valid()) {
                        var price = $("#partial_amount").val();
                        if (price > totalPrice) {
                            alert({
                                title: warningLable,
                                content: "<div class='rmamarketplace-warning-content'>"+errorMsg+"</div>",
                                actions: {
                                    always: function (){}
                                }
                            });
                            return false;
                        }
                    }
                });

            });
        }
    });
    return $.rmamarketplace.rma;
});
