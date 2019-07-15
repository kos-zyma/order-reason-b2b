define([
    'jquery',
    'Magento_Ui/js/modal/confirm',
    'mage/translate'
], function ($, confirm) {
    'use strict';

    $.widget('mage.reasonDelete', {
        options: {
            deleteUrl: ''
        },

        /**
         * Create Widget
         * @private
         */
        _create: function () {
            this._bind();
        },

        /**
         * Bind listeners on elements
         * @private
         */
        _bind: function () {
            this._on({
                'deleteReason': '_deleteReason'
            });
        },

        /**
         * Set Pop Up for Delete
         *
         * @private
         */
        _deleteReason: function (e) {
            var self = this,
                options;

            e.preventDefault();

            options = {
                modalClass: 'modal-slide popup-tree',
                buttons: [{
                    text: $.mage.__('Cancel'),
                    'class': 'action secondary cancel',

                    /** @inheritdoc */
                    click: function (event) {
                        this.closeModal(event);
                    }
                },
                {
                    text: $.mage.__('Delete'),
                    'class': 'action primary delete',

                    /** @inheritdoc */
                    click: function (event) {
                        this.closeModal(event);
                        location.href = self.options.deleteUrl;
                    }
                }],
                title: $.mage.__('Delete This Order Reason?'),
                content: $.mage.__('This action cannot be undone. Are you sure you want to delete this order reason')
            };
            confirm(options);
        }
    });
    return $.mage.reasonDelete;
});
