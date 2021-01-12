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
            messageWrap: '#oleksiib-regular-customer-message-wrap'
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
        openRegisterForm: function () {
            $(document).trigger('oleksiib_regular_customers_form_open');
        },

        /**
         * Generate event to displayed message
         */
        displayedMessage: function () {
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
                    'isAjax': 1
                },
                processData: false,
                contentType: false,
                type: 'post',
                dataType: 'json',
                context: this,

                /** @inheritdoc */
                success: function (response) {
                    if (response.result === false) {
                        this.openRegisterForm();
                    } else {
                        this.displayedMessage();
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
