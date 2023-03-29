define([
    "jquery",
    "Magento_Ui/js/modal/confirm",
    "Magento_Ui/js/modal/alert",
    "mage/calendar",
    "jquery/ui",
    'mage/translate',
    "mage/template",
    "mage/mage",
], function ($, confirmation, alertBox) {
    'use strict';
    $.widget('rmamarketplace.allRma', {
        options: {},
        _create: function () {
            var self = this;
            var type = self.options.type;
            var filterUrl = self.options.filterUrl;
            var sortingUrl = self.options.sortingUrl;
            $(".dots-date-filter-box input").calendar({
                dateFormat:'Y-mm-dd',
            });

            $(document).keypress(function (event) {
                if (event.keyCode == 13) {
                    applyFilter();
                }
            });

            $(document).ready(function () {
                $("body").on("click", ".dots-apply-filter-btn", function () {
                    applyFilter();
                });
                $("body").on("click", ".dots-sorting-col", function () {
                    var col = $(this).attr("data-col");
                    if ($(this).parent().parent().hasClass("dots-desc-order")) {
                        $(this).parent().parent().removeClass("dots-desc-order");
                        $(this).parent().parent().addClass("dots-asc-order");
                        var sortOrder = "asc";
                    } else {
                        $(this).parent().parent().removeClass("dots-asc-order");
                        $(this).parent().parent().addClass("dots-desc-order");
                        var sortOrder = "desc";
                    }

                    $(this).parent().parent().removeClass("dots-filtered-order-ref");
                    $(this).parent().parent().removeClass("dots-filtered-date");
                    $(this).parent().parent().removeClass("dots-filtered-rma-id");
                    $(this).parent().parent().removeClass("dots-filtered-rma-customer");
                    if (col == "dots_order_ref") {
                        $(this).parent().parent().addClass("dots-filtered-order-ref");
                    } else if (col == "dots_date") {
                        $(this).parent().parent().addClass("dots-filtered-date");
                    } else if (col == "dots_customer") {
                        $(this).parent().parent().addClass("dots-filtered-rma-customer");
                    } else {
                        $(this).parent().parent().addClass("dots-filtered-rma-id");
                    }
                    applySorting(col, sortOrder);
                });
            });

            function applyFilter()
            {
                var rmaId = $("#dots-filter-rma-id").val();
                var orderRef = $("#dots-filter-order-ref").val();
                var status = $("#dots-filter-rma-status").val();
                var dateFrom = $("#dots-filter-date-from").val();
                var dateTo = $("#dots-filter-date-to").val();
                var customer = $("#dots-filter-customer").val();

                showLoader();
                $.ajax({
                    type: 'post',
                    url: filterUrl,
                    async: true,
                    dataType: 'json',
                    data : {
                                rma_id : rmaId,
                                order_ref : orderRef,
                                status : status,
                                from : dateFrom,
                                to : dateTo,
                                customer : customer,
                                type : type
                            },
                    success:function (data) {
                        location.reload();
                        hideLoader();
                    }
                });
            }

            function applySorting(col, sortOrder)
            {
                showLoader();
                $.ajax({
                    type: 'post',
                    url: sortingUrl,
                    async: true,
                    dataType: 'json',
                    data : {
                                sort_order : sortOrder,
                                sort_col : col,
                                type : type
                            },
                    success:function (data) {
                        location.reload();
                        hideLoader();
                    }
                });
            }

            function showLoader()
            {
                $(".dots-loading-mask").removeClass("dots-display-none");
            }

            function hideLoader()
            {
                $(".dots-loading-mask").addClass("dots-display-none");
            }
        }
    });
    return $.rmamarketplace.allRma;
});
