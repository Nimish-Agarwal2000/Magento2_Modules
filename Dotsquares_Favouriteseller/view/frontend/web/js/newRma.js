define([
    "jquery",
    'Magento_Ui/js/modal/confirm',
    'Magento_Ui/js/modal/alert',
    "jquery/ui"
], function ($, confirmation, alertBox) {
    'use strict';
    $.widget('rmamarketplace.newRma', {
        options: {},
        _create: function () {
            var self = this;
            var reasons = self.options.reasons;
            var blockHtml = self.options.blockHtml;
            var imgErrorMsg = self.options.imgErrorMsg;
            var consignmentLabel = self.options.consignmentLabel;
            var sellerLabel = self.options.sellerLabel;
            var selectItemLabel = self.options.selectItemLabel;
            var imgSelectLabel = self.options.imgSelectLabel;
            var orderSelectLabel = self.options.orderSelectLabel;
            var sellerSelectLabel = self.options.sellerSelectLabel;
            var resolutionSelectLabel = self.options.resolutionSelectLabel;
            var itemsErrorLabel = self.options.itemsErrorLabel;
            var refundLabel = self.options.refundLabel;
            var replaceLabel = self.options.replaceLabel;
            var cancelLabel = self.options.cancelLabel;
            var deliveredLabel = self.options.deliveredLabel;
            var notDeliveredLabel = self.options.notDeliveredLabel;
            var orderStatusLabelText = self.options.orderStatusLabel;
            var selectQtyLabel = self.options.selectQtyLabel;
            var selectSellerLabel = self.options.selectSellerLabel;
            var warningLabel = self.options.warningLabel;
            var qtyMsg = self.options.qtyMsg;
            var orderData = {};
            var result = [];
            var imgCount = 0;
            var selectedCount = 0;
            var img = "";
            var error = false;
            var isVirtual = 0;
            $(document).ready(function () {
                var skip = [];
                var flag = 1;
                var acceptedImageType = ["png", "jpg", "jpeg", "gif"];
                $("body").on("change", ".ds-showcase-img", function () {
                    var imageName = $(this).val();
                    var result = imageName.split(".");
                    var length = result.length;
                    var currentThis = $(this);
                    var ext = result[length-1];
                    ext = ext.toLowerCase();
                    if (acceptedImageType.indexOf(ext)!=-1) {
                        if (this.files && this.files[0]) {
                            var reader = new FileReader();
                            reader.onload = function (e) {
                                var img = "<img src='"+e.target.result+"'>"
                                currentThis.prev().remove();
                                currentThis.before(img);
                                error = false;
                            }
                            reader.readAsDataURL(this.files[0]);
                            selectedCount++;
                        }
                    } else {
                        alertBox({
                            title: warningLabel,
                            content: "<div class='rmamarketplace-warning-content'>"+imgErrorMsg+"</div>",
                            actions: {
                                always: function (){}
                            }
                        });
                        currentThis.val('');
                    }
                });
               /* $("body").on("click", ".ds-add-showcase-btn", function () {
                    $(".ds-button-set").after(blockHtml);
                    imgCount++;
                }); */
               
                $("body").on("click", ".ds-delete-item", function () {
                    if ($(this).parent().find("img").length) {
                        selectedCount--;
                    }
                    $(this).parent().remove();
                    imgCount--;
                });

                $("body").on("click", ".ds-default-block", function () {
                    $(this).next().trigger("click");
                });

                $("#orders").val("");


                $("body").on('click', '.order_item', function () {
                    var allChecked = true;
                    if ($(this).prop("checked") == true) {
                        $(this).parent().parent().find(".order_qty").addClass("required-entry");
                        $(this).parent().parent().find(".ds-reason").addClass("required-entry");
                    } else {
                        $(this).parent().parent().find(".order_qty").removeClass("required-entry");
                        $(this).parent().parent().find(".order_qty").removeClass("mage-error");
                        $(this).parent().parent().find(".ds-reason").removeClass("required-entry");
                        $(this).parent().parent().find(".ds-reason").removeClass("mage-error");
                    }
                    $(".order_item").each(function () {
                        if ($(this).prop("checked") == false) {
                            allChecked = false;
                        }
                    });
                    if (allChecked) {
                        $(".ds-mass-select").prop("checked", true);
                    } else {
                        $(".ds-mass-select").prop("checked", false);
                    }
                    manageOrderStatus();
                });

                $("#orders").on('change', function () {
                    removeConsignmentBlock();
                    $(".ds-seller-field").remove();
                    $(".ds-resolution-field").remove();
                    $(".ds-order-status-field").remove();
                    $(".ds-mass-select").prop("checked", false);
                    var orderId = $(this).val();
                    if (orderId == "") {
                        resetOrderArea();
                    } else {
                        showLoadingMask();
                        $.ajax({
                            type: 'post',
                            url: self.options.orderUrl,
                            async: true,
                            dataType: 'json',
                            data : { order_id : orderId, is_guest : self.options.isGuest },
                            success:function (data) {
                                if (data.isLoggedIn == 1) {
                                    orderData = data;
                                    $("#order_items").empty();
                                    $(".ds-seller-field").remove();
                                    var orderStatus = data.order_status;
                                    var shipmentStatus = data.shipment_status;
                                    var items = data.items;
                                    if (data.multi_seller == 1) {
                                        displaySellerDropdown(data);
                                        resetSellerArea();
                                    } else {
                                        displayErrorPopUp(orderStatus);
                                        if (data.total_qty > 0) {
                                            $.each(items, function (key, obj) {
                                                displayResolutionDropdown(data, key);
                                            });
                                        } else {
                                            rmaErrorPopUp();
                                        }
                                    }
                                } else {
                                    location.reload();
                                }
                                hideLoadingMask();
                            }
                        });
                    }
                });
                
                $(".ds-save").on('click', function () {
                    var itemSelected = false;
                    if ($('#dots_new_rma_form').valid()) {
                        $('body').trigger('processStart');
                        $(".order_item").each(function () {
                            if ($(this).prop("checked") == true) {
                                itemSelected = true;
                            }
                        });
                        if (!itemSelected) {
                            alertBox({
                                title: warningLabel,
                                content: "<div class='rmamarketplace-warning-content'>"+selectItemLabel+"</div>",
                                actions: {
                                    always: function (){}
                                }
                            });
                            $('body').trigger('processStop');
                            return false;
                        }

                        if (selectedCount != imgCount) {
                            alertBox({
                                title: warningLabel,
                                content: "<div class='rmamarketplace-warning-content'>"+imgSelectLabel+"</div>",
                                actions: {
                                    always: function (){}
                                }
                            });
                            $('body').trigger('processStop');
                            return false;
                        }
                        $("#isChecked").val(selectedCount);
                    }
                    var field = "<input type='hidden' id='is_virtual' name='is_virtual' value='"+isVirtual+"'>";
                    $("#is_virtual").remove();
                    $("#dots_new_rma_form").append(field);
                });

                $('body').on('change', '#order_status', function () {
                    var type = $(this).val();
                    if (type == 1) {
                        addConsignmentBlock();
                    } else {
                        removeConsignmentBlock();
                    }
                });


                $("body").on('change', '.ds-seller', function () {
                    removeConsignmentBlock();
                    $(".ds-resolution-field").remove();
                    $(".ds-order-status-field").remove();
                    $(".ds-mass-select").prop("checked", false);
                    $("#order_items").empty();
                    var val = $(this).val();
                    if (val != "") {
                        resetResolutionArea();
                        displayResolutionDropdown(orderData, val);
                    } else {
                        resetSellerArea();
                    }
                });

                $("body").on('change', '.ds-resolution', function () {
                    removeConsignmentBlock();
                    $(".ds-mass-select").prop("checked", false);
                    $("#order_items").empty();
                    var sellerId = 0;
                    if (orderData.multi_seller == 1) {
                        var sellerId = $(".ds-seller").val();
                    } else {
                        var sellers = orderData.sellers;
                        for (var key in sellers) {
                            if (sellers.hasOwnProperty(key)) {
                                sellerId = key;
                            }
                        }
                    }

                    var val = $(this).val();
                    if (val != "" && sellerId != "") {
                        var items = orderData.items[sellerId][val];
                        var orderStatus = orderData.order_details[sellerId].order_status;
                        var shipmentStatus = orderData.order_details[sellerId].shipment_status;
                        displayItems(items, orderStatus);
                        displayErrorPopUp(orderStatus);
                        setProductStatus(shipmentStatus);
                    } else {
                        $(".ds-order-status-field").remove();
                        resetResolutionArea();
                    }
                    manageOrderStatus();
                });

                $('body').on('change', '.ds-mass-select', function () {
                    if ($(this).prop("checked") == true) {
                        $(".order_item").prop("checked", true);
                        $(".order_qty").addClass("required-entry");
                        $(".ds-reason").addClass("required-entry");
                    } else {
                        $(".order_item").prop("checked", false);
                        $(".order_qty").removeClass("required-entry");
                        $(".order_qty").removeClass("mage-error");
                        $(".ds-reason").removeClass("required-entry");
                        $(".ds-reason").removeClass("mage-error");
                    }
                    manageOrderStatus();
                });
            });

            function resetSellerArea()
            {
                var errorHtml = '<div class="message info"><span>'+sellerSelectLabel+'</span></div>';
                var html = '<tr><td colspan="7">'+errorHtml+'</td></tr>';
                $("#order_items").empty();
                $("#order_items").append(html);
            }
           
            function resetOrderArea()
            {
                var errorHtml = '<div class="message info"><span>'+orderSelectLabel+'</span></div>';
                var html = '<tr><td colspan="7">'+errorHtml+'</td></tr>';
                $("#order_items").empty();
                $("#order_items").append(html);
            }

            function resetResolutionArea()
            {
                var errorHtml = '<div class="message info"><span>'+resolutionSelectLabel+'</span></div>';
                var html = '<tr><td colspan="7">'+errorHtml+'</td></tr>';
                $("#order_items").empty();
                $("#order_items").append(html);
            }

            function setProductStatus(type)
            {
                $(".ds-order-status-field").remove();
                var orderStatusLabel = orderStatusLabelText;
                var orderStatusHtml = $("<select class='ds-order-status required-entry' name='order_status'></select>");

                if (type == 1) {
                    orderStatusHtml.append('<option value="0">'+notDeliveredLabel+'</option>');
                    orderStatusHtml.append('<option value="1">'+deliveredLabel+'</option>');
                } else {
                    orderStatusHtml.append('<option value="0">'+notDeliveredLabel+'</option>');
                }

                var fieldsetHtml = $("<div/>", { class : 'field ds-order-status-field'});
                fieldsetHtml.append($("<label/>", { class : 'label'}).append($("<span/>", { text : orderStatusLabel})));
                fieldsetHtml.append($("<div/>", { class : 'control'}).append(orderStatusHtml));
                $(".ds-actions-toolbar").before(fieldsetHtml);
            }

            function setErrorMessage()
            {
                var errorHtml = '<div class="message error"><span>'+itemsErrorLabel+'</span></div>';
                var html = '<tr><td colspan="7">'+errorHtml+'</td></tr>';
                $("#order_items").empty();
                $("#order_items").append(html);
            }

            $('body').on('change', '.ds-order-status', function () {
                $(".ds-order-cons-field").remove();
                var orderStatus = $('.ds-order-status').val();
                var consignmentLabel = $.mage.__("Consignment Number");
                var orderConsHtml = $("<input class='ds-order-con-no required-entry' name='number'>");
                 
                if (orderStatus==0) {
                    $(".ds-order-cons-field").remove();
                } else {
                var fieldsetHtml = $("<div/>", { class : 'required field ds-order-cons-field'});
                fieldsetHtml.append($("<label/>", { class : 'label'}).append($("<span/>", { text : consignmentLabel})));
                fieldsetHtml.append($("<div/>", { class : 'control'}).append(orderConsHtml));
                $(".ds-actions-toolbar").before(fieldsetHtml);
                }
                
            });

            function getHtml(obj, orderStatus)
            {
                var qty =  obj.qty;
                if (orderStatus == 2) {
                    var qty = 0;
                }
                var html = $('<tr/>');
                if (qty > 0) {
                    html.append($('<td/>', { class : 'col' })
                        .append($('<input/>', { type : 'checkbox', name : 'item_ids[]', class : 'order_item', value : obj.item_id, 'data-id' : obj.id, 'data-virtual' : obj.is_virtual })));
                } else {
                    html.append($('<td/>', { class : 'col' }));
                }
                html.append($('<td/>', { class : 'col' }).append($('<div/>', { class : 'ds-mp-rma-img'}).append($('<img/>', { src : obj.product_image}))).append($('<div/>', { class : 'ds-mp-rma-name'}).append($('<a/>', { href : obj.product_url, text : obj.name})).append(obj.optionHtml)));
                html.append($('<td/>', { class : 'col', text : obj.sku }));
                html.append($('<td/>', { class : 'col', html : obj.price }));
                if (qty > 0) {
                    html.append($('<td/>', { class : 'col' }).append(getDropDownList(obj.qty, obj.item_id)));
                } else {
                    html.append($('<td/>', { class : 'col', text : qtyMsg }));
                }
                html.append($('<td/>', { class : 'col' }).append(getReasonDropDown(obj.item_id)));
                return html;
            }

            function getReasonDropDown(itemId)
            {
                var combo = $("<select class='ds-reason' name='reason_ids["+itemId+"]'></select>");
                for (var key in reasons) {
                    if (reasons.hasOwnProperty(key)) {
                        var val = key;
                        if (val == 0) {
                            val = "";
                        }
                        combo.append("<option value='"+val+"'>"+reasons[key]+"</option>");
                    }
                }
                return combo;
            }

            function getDropDownList(qty, itemId)
            {
                var combo = $("<select name='total_qty["+itemId+"]' class='order_qty'></select>");
                combo.append("<option value=''>"+selectQtyLabel+"</option>");
                var count = 1;
                while (count <= qty) {
                    combo.append("<option value='"+count+"'>" + count + "</option>");
                    count++;
                };
                return combo;
            }

            function showLoadingMask()
            {
                $(".ds-loading-mask").removeClass("ds-display-none");
            }

            function hideLoadingMask()
            {
                $(".ds-loading-mask").addClass("ds-display-none");
            }

            function addConsignmentBlock()
            {
                var input = $('<input/>', { class : 'input-text required-entry', id : 'consignment_number', type : 'text', 'data-validate' :'{required:true}', name:'number' });
                var html = $('<div/>', { class : 'field required' });
                html.append(
                    $('<label class="label" for="consignment_number"></label>')
                    .append($('<span/>', { text : consignmentLabel }))
                );
                html.append($('<div/>', { class : 'control' }).append(input));
                $("#consignment_number").remove();
                $("#order_status").parent().parent().after(html);
            }

            function removeConsignmentBlock()
            {
                $("#consignment_number").parent().parent().remove();
            }

            function getSellerDropdown(data)
            {
                var sellers = data.sellers;
                var combo = $("<select class='ds-seller required-entry' name='seller'></select>");
                combo.append("<option value=''>"+selectSellerLabel+"</option>");
                for (var key in sellers) {
                    if (sellers.hasOwnProperty(key)) {
                        combo.append("<option value='"+key+"'>"+sellers[key]+"</option>");
                    }
                }
                return combo;
            }

            function displaySellerDropdown(data)
            {
                var sellerHtml = getSellerDropdown(data);
                var fieldsetHtml = $("<div/>", { class : 'field ds-seller-field'});
                fieldsetHtml.append($("<label/>", { class : 'label'}).append($("<span/>", { text : sellerLabel})));
                fieldsetHtml.append($("<div/>", { class : 'control'}).append(sellerHtml));
                $(".ds-orders").after(fieldsetHtml);
            }

            function displayResolutionDropdown(data, key)
            {
                var hasResolution = false;
                $(".ds-resolution-field").remove();
                $(".ds-order-status-field").remove();
                var resolutionLabel = $.mage.__('Select Resolution');
                var resolutions = data.resolutions[key];
                var resolutionHtml = $("<select class='ds-resolution required-entry' name='resolution_type'></select>");
                resolutionHtml.append("<option value=''>"+$.mage.__("Select Resolution")+"</option>");
                for (var id in resolutions) {
                    if (resolutions.hasOwnProperty(id)) {
                        hasResolution = true;
                        resolutionHtml.append("<option value='"+id+"'>"+resolutions[id]+"</option>");
                    }
                }

                if (hasResolution) {
                    var fieldsetHtml = $("<div/>", { class : 'required field ds-resolution-field'});
                    fieldsetHtml.append($("<label/>", { class : 'label'}).append($("<span/>", { text : resolutionLabel})));
                    fieldsetHtml.append($("<div/>", { class : 'control'}).append(resolutionHtml));
                    $(".table-wrapper").before(fieldsetHtml);
                } else {
                    rmaErrorPopUp();
                }
            }

            function rmaErrorPopUp()
            {
                alertBox({
                        title: warningLabel,
                        content: "<div class='rmamarketplace-warning-content'>"+itemsErrorLabel+"</div>",
                        actions: {
                            always: function (){}
                        }
                    });
                setErrorMessage();
            }
        
            function displayItems(items, orderStatus)
            {
                $.each(items, function (itemKey, itemObj) {
                    var html = getHtml(itemObj, orderStatus);
                    $("#order_items").append(html);
                });
            }

            function displayErrorPopUp(orderStatus)
            {
                if (orderStatus == 2) {
                    alertBox({
                        title: warningLabel,
                        content: "<div class='rmamarketplace-warning-content'>Seller cancelled the order.</div>",
                        actions: {
                            always: function (){}
                        }
                    });
                }
            }

            function manageOrderStatus()
            {
                var virtualOrder = true;
                $(".order_item").each(function () {
                    if ($(this).attr("data-virtual") == 0) {
                        virtualOrder = false;
                    }
                });
                if (virtualOrder) {
                    isVirtual = 1;
                    $(".ds-order-status-field").addClass("ds-display-none");
                } else {
                    $(".ds-order-status-field").removeClass("ds-display-none");
                    var count = 0;
                    var removeStatusField = true;
                    $(".order_item").each(function () {
                        if ($(this).prop("checked") == true) {
                            count++;
                            if ($(this).attr("data-virtual") == 0) {
                                removeStatusField = false;
                            }
                        }
                    });

                    if (removeStatusField && count > 0) {
                        isVirtual = 1;
                        $(".ds-order-status-field").addClass("ds-display-none");
                    } else {
                        isVirtual = 0;
                        $(".ds-order-status-field").removeClass("ds-display-none");
                    }
                }
            }
        }
    });
    return $.rmamarketplace.newRma;
});
