define([
    'jquery',
    'jquery/ui',
    'mage/translate'
], function ($) {
    'use strict';

    $.widget('oleksiib.regularCustomerButton', {
        /**
         * Constructor
         * @private
         */
        _create: function () {
            $(this.element).click(this.openRegistrationForm.bind(this));
            $(document).on('oleksiib_regular_customers_hide_button', this.hideButton.bind(this));
        },

        /**
         * Generate event to open the form
         */
        openRegistrationForm: function () {
            $(document).trigger('oleksiib_regular_customers_form_open');
        },

        /**
         * Hide button when product has already been requested
         */
        hideButton: function () {
            $(this.element).hide();
        }
    });

    return $.oleksiib.regularCustomerButton;
});
