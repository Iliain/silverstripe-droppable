window.ss = window.ss || {};

!(function () {
    "use strict";

    jQuery(function(){
        jQuery.noConflict();

        jQuery.entwine('ss', ($) => {
            $(`.drag-button`).entwine({
                onmatch() {
                    const textArea = this.closest('.field').find('textarea');

                    // On button click
                    this.on('click', function(e) {
                        e.preventDefault();

                        // If the option is blank, don't do anything
                        if (!this.dataset.value) {
                            return;
                        }

                        const cursorPos = textArea.prop('selectionStart');

                        const v = textArea.val();
                        const textBefore = v.substring(0, cursorPos);
                        const textAfter  = v.substring(cursorPos, v.length);
                        
                        textArea.val(textBefore + this.dataset.value + textAfter);

                        // Reselect the textarea and put cursor back at the previous position
                        textArea.focus();
                        textArea.prop('selectionStart', cursorPos + this.dataset.value.length);
                        textArea.prop('selectionEnd', cursorPos + this.dataset.value.length);
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
