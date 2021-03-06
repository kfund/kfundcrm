/*
 * Field Repeater plugin
 *
 * Data attributes:
 * - data-control="fieldrepeater" - enables the plugin on an element
 * - data-option="value" - an option with a value
 *
 * JavaScript API:
 * $('a#someElement').fieldRepeater({...})
 */

+function ($) { "use strict";

    var Base = $.oc.foundation.base,
        BaseProto = Base.prototype

    // FIELD REPEATER CLASS DEFINITION
    // ============================

    var Repeater = function(element, options) {
        this.options = options;
        this.$el = $(element);
        this.$sortable = $(options.sortableContainer, this.$el);
        this.itemCount = 0;

        $.oc.foundation.controlUtils.markDisposable(element);
        Base.call(this);
        this.init();
    }

    Repeater.prototype = Object.create(BaseProto);
    Repeater.prototype.constructor = Repeater;

    Repeater.DEFAULTS = {
        sortableHandle: '.repeater-item-handle',
        sortableContainer: 'ul.field-repeater-items',
        titleFrom: null,
        minItems: null,
        maxItems: null,
        style: 'default'
    }

    Repeater.prototype.init = function() {
        this.bindSorting();

        this.$el.on('ajaxDone', '> .field-repeater-items > .field-repeater-item > .repeater-item-remove > [data-repeater-remove]', this.proxy(this.onRemoveItemSuccess));
        this.$el.on('ajaxDone', '> .field-repeater-add-item > [data-repeater-add]', this.proxy(this.onAddItemSuccess));
        this.$el.on('click', '> ul > li > .repeater-item-collapse .repeater-item-collapse-one', this.proxy(this.toggleCollapse));
        this.$el.on('click', '> .field-repeater-add-item > [data-repeater-add-group]', this.proxy(this.clickAddGroupButton));

        this.$el.one('dispose-control', this.proxy(this.dispose));

        this.countItems();
        this.togglePrompt();
        this.applyStyle();
    }

    Repeater.prototype.dispose = function() {
        this.$sortable.sortable('destroy');

        this.$el.off('ajaxDone', '> .field-repeater-items > .field-repeater-item > .repeater-item-remove > [data-repeater-remove]', this.proxy(this.onRemoveItemSuccess));
        this.$el.off('ajaxDone', '> .field-repeater-add-item > [data-repeater-add]', this.proxy(this.onAddItemSuccess));
        this.$el.off('click', '> .field-repeater-items > .field-repeater-item > .repeater-item-collapse .repeater-item-collapse-one', this.proxy(this.toggleCollapse));
        this.$el.off('click', '> .field-repeater-add-item > [data-repeater-add-group]', this.proxy(this.clickAddGroupButton));

        this.$el.off('dispose-control', this.proxy(this.dispose));
        this.$el.removeData('oc.repeater');

        this.$el = null;
        this.$sortable = null;
        this.options = null;

        BaseProto.dispose.call(this);
    }

    // Deprecated
    Repeater.prototype.unbind = function() {
        this.dispose();
    }

    Repeater.prototype.bindSorting = function() {
        var sortableOptions = {
            handle: this.options.sortableHandle,
            nested: false
        }

        this.$sortable.sortable(sortableOptions);
    }

    Repeater.prototype.clickAddGroupButton = function(ev) {
        var self = this,
            templateHtml = $('> [data-group-palette-template]', this.$el).html(),
            $target = $(ev.target),
            $form = this.$el.closest('form'),
            $loadContainer = $target.closest('.loading-indicator-container');

        $target.ocPopover({
            content: templateHtml
        });

        var $container = $target.data('oc.popover').$container;

        // Initialize the scrollpad control in the popup
        $container.trigger('render');

        $container
            .on('click', 'a', function (ev) {
                setTimeout(function() { $(ev.target).trigger('close.oc.popover') }, 1)
            })
            .on('ajaxPromise', '[data-repeater-add]', function(ev, context) {
                $loadContainer.loadIndicator()

                $form.one('ajaxComplete', function() {
                    $loadContainer.loadIndicator('hide');
                    self.togglePrompt();
                })
            });

        $('[data-repeater-add]', $container).data('request-form', $form);
    }

    Repeater.prototype.onRemoveItemSuccess = function(ev) {
        var $item = $(ev.target).closest('.field-repeater-item');
        this.diposeItem($item);
        $item.remove();

        this.countItems();
        this.togglePrompt();
        this.triggerChange();
    }

    Repeater.prototype.onAddItemSuccess = function(ev) {
        this.itemCount++;
        this.togglePrompt();
        this.triggerChange();
    }

    /*
     * Trigger change event (Compatibility with october.form.js)
     */
    Repeater.prototype.triggerChange = function() {
        this.$el.closest('[data-field-name]').trigger('change.oc.formwidget');
    }

    Repeater.prototype.togglePrompt = function () {
        if (this.options.minItems && this.options.minItems > 0) {
            var $btn = this.$el.find('> .field-repeater-items > .field-repeater-item > .repeater-item-remove');
            $btn.toggleClass('disabled', !(this.itemCount > this.options.minItems));
        }

        if (this.options.maxItems && this.options.maxItems > 0) {
            var $btn = this.$el.find('> .field-repeater-add-item');
            $btn.toggle(this.itemCount < this.options.maxItems);
        }
    }

    Repeater.prototype.toggleCollapse = function(ev) {
        var $item = $(ev.target).closest('.field-repeater-item'),
            isCollapsed = $item.hasClass('collapsed');

        ev.preventDefault();

        if (this.getStyle() === 'accordion') {
            if (isCollapsed) {
                this.expand($item);
            }
            return;
        }

        if (ev.ctrlKey || ev.metaKey) {
            isCollapsed ? this.expandAll() : this.collapseAll();
        }
        else {
            isCollapsed ? this.expand($item) : this.collapse($item);
        }
    }

    Repeater.prototype.collapseAll = function() {
        var self = this,
            items = $(this.$el).children('.field-repeater-items').children('.field-repeater-item');

        $.each(items, function(key, item){
            self.collapse($(item));
        });
    }

    Repeater.prototype.expandAll = function() {
        var self = this,
            items = $(this.$el).children('.field-repeater-items').children('.field-repeater-item');

        $.each(items, function(key, item){
            self.expand($(item));
        });
    }

    Repeater.prototype.collapse = function($item) {
        $item.addClass('collapsed')
        $('.repeater-item-collapsed-title', $item).text(this.getCollapseTitle($item));
    }

    Repeater.prototype.expand = function($item) {
        if (this.getStyle() === 'accordion') {
            this.collapseAll();
        }
        $item.removeClass('collapsed');
    }

    Repeater.prototype.getCollapseTitle = function($item) {
        var $target,
            defaultText = '',
            explicitText = $item.data('collapse-title');

        if (explicitText) {
            return explicitText;
        }

        if (this.options.titleFrom) {
            $target = $('[data-field-name="'+this.options.titleFrom+'"]', $item);
            if (!$target.length) {
                $target = $item;
            }
        }
        else {
            $target = $item;
        }

        var $textInput = $('input[type=text]:first, select:first', $target).first();
        if ($textInput.length) {
            switch($textInput.prop("tagName")) {
                case 'SELECT':
                    return $textInput.find('option:selected').text();
                default:
                    return $textInput.val();
            }
        } else {
            var $disabledTextInput = $('.text-field:first > .form-control', $target);
            if ($disabledTextInput.length) {
                return $disabledTextInput.text();
            }
        }

        return defaultText;
    }

    Repeater.prototype.getStyle = function() {
        var style = 'default';

        // Validate style
        if (this.options.style && ['collapsed', 'accordion'].indexOf(this.options.style) !== -1) {
            style = this.options.style;
        }

        return style;
    }

    Repeater.prototype.applyStyle = function() {
        var style = this.getStyle(),
            items = $(this.$el).children('.field-repeater-items').children('.field-repeater-item'),
            self = this;

        $.each(items, function(key, item) {
            switch (style) {
                case 'collapsed':
                    self.collapse($(item));
                    break;
                case 'accordion':
                    if (key !== 0) {
                        self.collapse($(item));
                    }
                    break;
            }
        });
    }

    Repeater.prototype.diposeItem = function($item) {
        $item.find('[data-disposable]').each(function () {
            var $el = $(this),
                control = $el.data('control'),
                widget = $el.data('oc.' + control);

            if (widget && typeof widget['dispose'] === 'function') {
                widget.dispose();
            }
        });
    }

    Repeater.prototype.countItems = function() {
        this.itemCount = this.$el.find('> .field-repeater-items > .field-repeater-item').length;
    }

    // FIELD REPEATER PLUGIN DEFINITION
    // ============================

    var old = $.fn.fieldRepeater;

    $.fn.fieldRepeater = function (option) {
        var args = Array.prototype.slice.call(arguments, 1), result
        this.each(function () {
            var $this   = $(this)
            var data    = $this.data('oc.repeater')
            var options = $.extend({}, Repeater.DEFAULTS, $this.data(), typeof option == 'object' && option)
            if (!data) $this.data('oc.repeater', (data = new Repeater(this, options)))
            if (typeof option == 'string') result = data[option].apply(data, args)
            if (typeof result != 'undefined') return false
        });

        return result ? result : this;
    }

    $.fn.fieldRepeater.Constructor = Repeater;

    // FIELD REPEATER NO CONFLICT
    // =================

    $.fn.fieldRepeater.noConflict = function () {
        $.fn.fieldRepeater = old;
        return this;
    }

    // FIELD REPEATER DATA-API
    // ===============

    $(document).render(function() {
        $('[data-control="fieldrepeater"]').fieldRepeater();
    });

}(window.jQuery);
