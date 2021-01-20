define([
    'jquery',
    'jquery/ui',
    'mage/translate',
    'Magento_Ui/js/modal/alert'
], function ($, alert) {
    'use strict';

    $.widget('oleksiib.regularCustomerButton', {
        options: {
            url: '',
            productId: ''
        },

        /**
         * Constructor
         * @private
         */
        _create: function () {
            $(this.element).click(this.ajaxRequest.bind(this));
        },

        /**
         * Generate event to open the form
         */
        openRegistrationForm: function () {
            $(document).trigger('oleksiib_regular_customers_form_open');
        },

        /**
         * Generate event to displayed message
         */
        showAlreadyRegisteredMessage: function () {
            $(document).trigger('oleksiib_regular_customers_show_message');
            $(this.element).css('display', 'none');
        },

        /**
         * Submit request via AJAX. Add product id to the post data.
         */
        ajaxRequest: function () {
            $.ajax({
                url: this.options.url,
                data: {
                    'isAjax': 1,
                    'productId': this.options.productId
                },
                type: 'get',
                dataType: 'json',
                context: this,

                /** @inheritdoc */
                success: function (response) {
                    if (response.result === false) {
                        this.openRegistrationForm();
                    } else {
                        this.showAlreadyRegisteredMessage();
                    }
                },

                /** @inheritdoc */
                error: function () {
                    alert({
                        title: $.mage.__('Error'),
                        content: $.mage.__('Your request can\'t be sent. Please, contact us if you see this message.')
                    });
                }
            });
        }
    });

    return $.oleksiib.regularCustomerButton;
});
