
/**
 * @api
 */
define([
    'jquery',
    'Magento_Ui/js/modal/alert',
    'Magento_Ui/js/modal/prompt',
    'uiRegistry',
    'collapsable'
], function ($, alert, prompt, rg) {
    'use strict';

    return function (optionConfig) {
        var activePanelClass = 'selected-type-options',
            etmEntityAttributes = {
                frontendInput: $('#frontend_input'),
                backendType: $('#backend_type'),
                frontendClass: $('#frontend_class'),
                isRequired: $('#is_required'),
                isUnique: $('#is_unique'),
                defaultValueText: $('#default_value_text'),
                defaultValueTextarea: $('#default_value_textarea'),
                defaultValueDate: $('#default_value_date'),
                defaultValueYesno: $('#default_value_yesno'),
                isGlobal: $('#is_global'),
                isVisibleOnFront: $('#is_visible_on_front'),
                selectFields: ['boolean', 'select', 'multiselect'],

                toggleApplyVisibility: function (select) {
                    if ($(select).val() === 1) {
                        $(select).next('select').removeClass('no-display');
                        $(select).next('select').removeClass('ignore-validate');
                    } else {
                        $(select).next('select').addClass('no-display');
                        $(select).next('select').addClass('ignore-validate');
                        $(select).next('select option:selected').each(function () {
                            this.selected = false;
                        });
                    }
                },

                checkOptionsPanelVisibility: function () {
                    var selectOptionsPanel = $('#manage-options-panel');

                    this._hidePanel(selectOptionsPanel);

                    switch (this.frontendInput.val()) {
                        case 'select':
                        case 'multiselect':
                            this._showPanel(selectOptionsPanel);
                            break;
                    }
                },

                bindAttributeInputType: function () {
                    this.checkOptionsPanelVisibility();
                    this.switchDefaultValueField();

                    switch (this.frontendInput.val()) {
                        case 'textarea':
                            this.frontendClass.val('');
                            this._disable(this.frontendClass);
                            break;

                        case 'text':
                            this._enable(this.frontendClass);
                            break;

                        case 'select':
                        case 'multiselect':
                            this.frontendClass.val('');
                            this._disable(this.frontendClass);
                            break;
                        default:
                            this.frontendClass.val('');
                            this._disable(this.frontendClass);
                    }
                },

                switchDefaultValueField: function () {
                    var currentValue = this.frontendInput.val(),
                        defaultValueTextVisibility = false,
                        defaultValueTextareaVisibility = false,
                        defaultValueDateVisibility = false,
                        defaultValueYesnoVisibility = false,
                        scopeVisibility = true,
                        optionDefaultInputType = '',
                        thing = this;

                    if (!this.frontendInput.length) {
                        return;
                    }

                    switch (currentValue) {
                        case 'select':
                            optionDefaultInputType = 'radio';
                            break;

                        case 'multiselect':
                            optionDefaultInputType = 'checkbox';
                            break;

                        case 'date':
                            defaultValueDateVisibility = true;
                            break;

                        case 'boolean':
                            defaultValueYesnoVisibility = true;
                            break;

                        case 'textarea':
                        case 'texteditor':
                            defaultValueTextareaVisibility = true;
                            break;

                        default:
                            defaultValueTextVisibility = true;
                            break;
                    }

                    if (optionConfig.hiddenFields.hasOwnProperty(currentValue)) {
                        $.each(optionConfig.hiddenFields[currentValue], function (key, option) {
                            switch (option) {
                                case '_default_value':
                                    defaultValueTextVisibility = false;
                                    defaultValueTextareaVisibility = false;
                                    defaultValueDateVisibility = false;
                                    defaultValueYesnoVisibility = false;
                                    break;

                                case '_scope':
                                    scopeVisibility = false;
                                    break;
                                default:
                                    thing.setRowVisibility($('#' + option), false);
                            }
                        });

                    } else {
                        this.showDefaultRows();
                    }

                    this.setRowVisibility(this.defaultValueText, defaultValueTextVisibility);
                    this.setRowVisibility(this.defaultValueTextarea, defaultValueTextareaVisibility);
                    this.setRowVisibility(this.defaultValueDate, defaultValueDateVisibility);
                    this.setRowVisibility(this.defaultValueYesno, defaultValueYesnoVisibility);
                    this.setRowVisibility(this.isGlobal, scopeVisibility);

                    $('input[name=\'default[]\']').each(function () {
                        $(this).attr('type', optionDefaultInputType);
                    });
                },

                showDefaultRows: function () {
                    this.setRowVisibility(this.isRequired, true);
                    this.setRowVisibility(this.isUnique, true);
                    this.setRowVisibility(this.frontendClass, true);
                },

                setRowVisibility: function (el, isVisible) {
                    if (isVisible) {
                        el.show();
                        el.closest('.field').show();
                    } else {
                        el.hide();
                        el.closest('.field').hide();
                    }
                },

                /**
                 * @param {Object} el
                 */
                _disable: function (el) {
                    el.attr('disabled', 'disabled');
                },

                /**
                 * @param {Object} el
                 */
                _enable: function (el) {
                    if (!el.attr('readonly')) {
                        el.removeAttr('disabled');
                    }
                },

                /**
                 * @param {Object} el
                 */
                _showPanel: function (el) {
                    el.closest('.fieldset').show();
                    el.addClass(activePanelClass);
                    this._render(el.attr('id'));
                },

                /**
                 * @param {Object} el
                 */
                _hidePanel: function (el) {
                    el.closest('.fieldset').hide();
                    el.removeClass(activePanelClass);
                },

                /**
                 * @param {String} id
                 */
                _render: function (id) {
                    rg.get(id, function () {
                        $('#' + id).trigger('render');
                    });
                },
            };

        $(function () {
            $('#frontend_input').bind('change', function () {
                etmEntityAttributes.bindAttributeInputType();
            });

            etmEntityAttributes.bindAttributeInputType();

            $('.attribute-popup .collapse, [data-role="advanced_fieldset-content"]')
                .collapsable()
                .collapse('hide');
        });

        window.toggleApplyVisibility = etmEntityAttributes.toggleApplyVisibility;
    };
});
