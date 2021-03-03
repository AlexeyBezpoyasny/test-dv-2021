define([
    'jquery',
    'ko',
    'uiComponent',
    'Magento_Customer/js/customer-data',
    'Magento_Customer/js/model/authentication-popup',
    'Magento_Customer/js/action/login',
    'oleksiibRegularCustomersForm'
], function ($, ko, Component, customerData, authenticationPopup, loginAction) {
    'use strict';

    return Component.extend({
        defaults: {
            allowForGuests: !!customerData.get('loyalty-program')().allowForGuests,
            productId: 0,
            requestAlreadySent: false,
            template: 'OleksiiBezpoiasnyi_RegularCustomer/button',
            loyaltyProgramCustomerData: customerData.get('loyalty-program'),
            listens: {
                loyaltyProgramCustomerData: 'checkRequestedProduct'
            }
        },

        /**
         * @returns {*}
         */
        initialize: function () {
            loginAction.registerLoginCallback(function () {
                customerData.invalidate(['*']);
            });

            this._super();

            this.checkRequestedProduct(this.loyaltyProgramCustomerData());
            this.openRequestFormAfterSectionReload = false;

            return this;
        },

        /**
         * Init observable
         */
        initObservable: function () {
            this._super();
            this.observe(['allowForGuests', 'requestAlreadySent']);

            return this;
        },

        /**
         * Generate event to open the form
         */
        openRegistrationForm: function () {
            if (Object.keys(this.loyaltyProgramCustomerData()).length > 0) {
                if (this.allowForGuests() || this.loyaltyProgramCustomerData().isLoggedIn) {
                    $(document).trigger('oleksiib_regular_customers_form_open');
                } else {
                    authenticationPopup.showModal();
                }
            } else {
                this.openRequestFormAfterSectionReload = true;
                customerData.reload(['loyalty-program']);
            }
        },

        /**
         * Check if the product has already been requested by the customer
         */
        checkRequestedProduct: function (value) {
            if (!!value.productList && value.productList.includes(this.productId)) {
                this.requestAlreadySent(true);
            }

            this.allowForGuests(!!value.allowForGuests);

            if (this.openRequestFormAfterSectionReload) {
                this.openRequestFormAfterSectionReload = false;
                this.openRegistrationForm();
            }

            return value;
        }
    });
});
