define([
    'jquery',
    'jquery/ui'
], function ($) {
    'use strict';

    $.widget('oleksiib.regularCustomerButton', {
        /**
         * Constructor
         * @private
         */
        _create: function () {
            $(this.element).click(this.openRegisterForm.bind(this));
        },

        /**
         * Generate event to open the form
         */
        openRegisterForm: function () {
            $(document).trigger('oleksiib_regular_customers_form_open');
        }
    });

    return $.oleksiib.regularCustomerButton;
});
