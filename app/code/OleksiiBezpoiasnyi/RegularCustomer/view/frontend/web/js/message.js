define([
    'jquery',
    'jquery/ui'
], function ($) {
    'use strict';

    $.widget('oleksiib.regularCustomerMessage', {
        /**
         * Constructor
         * @private
         */
        _create: function () {
            $(document).on('oleksiib_regular_customers_show_message', this.showMessage.bind(this));
        },

        /**
         * Generate event to show message
         */
        showMessage: function () {
            $(this.element).css('display', 'inline-block');
        }
    });

    return $.oleksiib.regularCustomerMessage;
});
