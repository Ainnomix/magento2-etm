
define([
    'Magento_Ui/js/form/element/abstract'
], function (Abstract) {
    return Abstract.extend({
        defaults: {
            elementTmpl: 'Ainnomix_EtmAdminUi/form/entity/attribute/labels'
        },

        initialize: function () {
            this._super();
        },

        genInputName: function (store) {
            return this.inputName + '[' + store.value + ']';
        },

        genInputId: function (store) {
            return this.uid + '-' + store.value;
        },

        getValue: function (id) {
            return this.value()[id];
        }
    });
});
