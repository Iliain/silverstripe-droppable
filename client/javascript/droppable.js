window.ss = window.ss || {};

!(function () {
    "use strict";

    jQuery(function(){
        jQuery.noConflict();

        jQuery.entwine('ss', ($) => {
            $(`.drag-button`).entwine({
                onmatch() {
                    const textArea = this.closest('.field').find('textarea');

                    this.on('click', function(e) {
                        e.preventDefault();
                        const cursorPos = textArea.prop('selectionStart');

                        const v = textArea.val();
                        const textBefore = v.substring(0,  cursorPos);
                        const textAfter  = v.substring(cursorPos, v.length);

                        if (!this.dataset.value) {
                            return;
                        }
                        
                        textArea.val(textBefore + this.dataset.value + textAfter);
                    });

                    this.on('dragstart', function(e) {
                        e.originalEvent.dataTransfer.setData('text/plain', this.dataset.value);
                    });
                },
            });

            $(`.draggable-dropdown`).entwine({
                onmatch() {
                    const buttonID = this.data('button');
                    const button = $(`#${buttonID}`);

                    this.on('change', function(e) {
                        e.preventDefault();

                        // get the value of the selected option
                        const dropdownValue = $(this).find('option:selected').data('value');

                        $(button).attr('data-value', dropdownValue);
                    });
                },
            });
        });
    });
})();
