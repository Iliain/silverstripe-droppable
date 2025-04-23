window.ss = window.ss || {};

!(function () {
    "use strict";

    jQuery(function(){
        jQuery.noConflict();

        jQuery.entwine('ss', ($) => {
            $(`.drag-button`).entwine({
                onmatch() {
                    const form = this.closest('form');
                    const linkedField = $(this).data().field;

                    // find by name
                    const field = form.find(`[name="${linkedField}"]`);

                    // On button click
                    this.on('click', function(e) {
                        e.preventDefault();

                        if (!this.dataset.value) {
                            return;
                        }
                    
                        const input = field.get(0);
                        input.focus();
                    
                        const selectionStart = input.selectionStart;
                        const selectionEnd = input.selectionEnd;
                    
                        if (this.dataset.wrap) {
                            const wrapElement = this.dataset.wrap;
                            const selectedText = input.value.substring(selectionStart, selectionEnd);
                    
                            const wrapText = wrapElement
                                .replace(/\$1/g, selectedText || '')
                                .replace(/\$2/g, this.dataset.value);
                    
                            input.setRangeText(wrapText, selectionStart, selectionEnd, 'end');
                        } else {
                            input.setRangeText(this.dataset.value, selectionStart, selectionStart, 'end');
                        }
                    
                        // Trigger an input event so the browser tracks it in undo stack
                        input.dispatchEvent(new InputEvent('input', { bubbles: true }));
                    });

                    // On button drag
                    this.on('dragstart', function(e) {
                        e.originalEvent.dataTransfer.setData('text/plain', this.dataset.value);
                    });
                },
            });

            $(`.draggable-dropdown`).entwine({
                onmatch() {
                    const buttonID = this.data('button');
                    const button = $(`#${buttonID}`);

                    // On dropdown change
                    this.on('change', function(e) {
                        e.preventDefault();

                        // Get the value of the selected option
                        const dropdownValue = $(this).find('option:selected').data('value');

                        $(button).attr('data-value', dropdownValue);
                    });
                },
            });
        });
    });
})();
