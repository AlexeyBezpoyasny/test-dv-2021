define([
    'jquery',
    'ko',
    'uiComponent',
    'Magento_Customer/js/customer-data',
    'oleksiibRegularCustomersSubmitForm',
    'Magento_Ui/js/modal/modal'
], function ($, ko, Component, customerData, submitForm) {
    'use strict';

    return Component.extend({
        defaults: {
            action: '',
            customerName: '',
            customerEmail: '',
            isLoggedIn: !!customerData.get('loyalty-program')().isLoggedIn,
            hideIt: '',
            productId: 0,
            template: 'OleksiiBezpoiasnyi_RegularCustomer/form'
        },

        /**
         * init observable
         */
        initObservable: function () {
            this._super();
            this.observe(['customerName', 'customerEmail', 'isLoggedIn', 'hideIt']);

            this.updateCustomerData(customerData.get('loyalty-program')());
            customerData.get('loyalty-program').subscribe(this.updateCustomerData.bind(this));

            return this;
        },

        /**
         * Autocomplete form inputs and hide button
         */
        updateCustomerData: function (value) {
            if (!!value.name) {
                this.customerName(value.name);
            }

            if (!!value.email) {
                this.customerEmail(value.email);
            }

            // @TODO: hide form for loggedIn customers
            this.isLoggedIn(value.isLoggedIn);
        },

        /**
         * Init modal dialog
         */
        initModal: function (element) {
            this.$form = $(element);
            this.$form = this.$form.modal({
                buttons: []
            });

            $(document).on('oleksiib_regular_customers_form_open', this.openModal.bind(this));
        },

        /**
         * Open modal dialog
         */
        openModal: function () {
            this.$form.modal('openModal');
        },

        /**
         * Send form data to the server
         */
        sendRequest: function () {
            if (!this.validateForm()) {
                return;
            }

            this.ajaxSubmit();
        },

        /**
         * Validate request form
         */
        validateForm: function () {
            return this.$form.validation().valid();
        },

        /**
         * Submit request via AJAX. Add form key to the post data.
         */
        ajaxSubmit: function () {
            let payload = {
                name: this.customerName(),
                email: this.customerEmail(),
                productId: this.productId,
                'form_key': $.mage.cookies.get('form_key'),
                isAjax: 1,
                'hide_it': this.hideIt()
            };

            submitForm(payload, this.action).done(function () {
                this.$form.modal('closeModal');
            }.bind(this));
        }
    });
});
