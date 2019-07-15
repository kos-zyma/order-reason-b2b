define([
    'jquery',
    'Magento_Ui/js/grid/columns/actions',
    'Space48_OrderReason/js/reason-delete'
], function ($, Actions) {
    'use strict';

    return Actions.extend({
        defaults: {
            bodyTmpl: 'Space48_OrderReason/grid/cells/actions'
        },

        /**
         * Callback after click on element.
         *
         * @public
         */
        applyAction: function () {
            switch (this.type) {
                case 'delete-reason':
                    $(this).reasonDelete(this.options)
                        .trigger('deleteReason');
                    break;
                default:
                    return true;
            }
        }
    });
});
