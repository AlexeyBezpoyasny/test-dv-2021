define([
    'jquery',
    'ko',
    'uiComponent',
    'Magento_Customer/js/customer-data',
    'oleksiibRegularCustomersForm'
], function ($, ko, Component, customerData) {
    'use strict';

    return Component.extend({
        defaults: {
            productId: 0,
            requestAlreadySent: false,
            template: 'OleksiiBezpoiasnyi_RegularCustomer/button',
            loyaltyProgramCustomerData: customerData.get('loyalty-program'),
            listens: {
                loyaltyProgramCustomerData: 'checkRequestedProduct'
            }
        },

        /**
         * Init observable
         */
        initObservable: function () {
            this._super();
            this.observe('requestAlreadySent');

            return this;
        },

        /**
         * Init Links
         */
        initLinks: function () {
            this._super();

            this.checkRequestedProduct(this.loyaltyProgramCustomerData());

            return this;
        },

        /**
         * Generate event to open the form
         */
        openRegistrationForm: function () {
            $(document).trigger('oleksiib_regular_customers_form_open');
        },

        /**
         * Check if the product has already been requested by the customer
         */
        checkRequestedProduct: function (value) {
            if (!!value.productList && value.productList.includes(this.productId)) {
                this.requestAlreadySent(true);
            }
        }
    });
});
