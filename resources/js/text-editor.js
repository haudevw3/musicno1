const TEXT_EDITOR = (function() {

    var vals = {};
    var controls = {};

    const bindVals = function(values) {
        var self = {...vals, ...values};

        return self;
    }

    const bindControls = function() {
        var self = {};

        self.textEditor = $('#text-editor');
        self.mentionBox = $('#mention-box');

        return self;
    }

    const bindFunctions = function() {
        controls.textEditor.on('keydown', changeContent);
    }

    const changeContent = debounce(function(event) {
        const element = event.target;
        const selection = window.getSelection();
        const range = selection.getRangeAt(0);

        var textContent = selection.anchorNode.textContent;
            textContent = textContent.split(' ');
        var q = '';
        var startOffset = 0;
        var endOffset = 0;
        var focusOffset = selection.focusOffset;
        
        textContent.forEach(function(value, key) {
            if (endOffset < focusOffset) {
                q = value;

                if (key === 0) {
                    endOffset += value.length;
                }
                
                else if (key < textContent.length) {
                    endOffset += value.length + 1;
                }
            }
        });

        q = q.trim();

        if (q.search(/^\@[^\@]+/) == -1) {
            controls.mentionBox.addClass('d-none').removeClass('d-block');
            return;
        }

        apiGet(vals.url + q.substring(1), {}).then(function(response) {
            if (response.data.length === 0) {
                controls.mentionBox.addClass('d-none').removeClass('d-block');
                return;
            }

            var html = '';

            response.data.forEach(function(object) {
                html += 
                `<a class="dropdown-item cursor-pointer" data-id="${object.id}" data-mention="${object.name}" data-image="${object.image}">
                    <i class="fa-regular fa-magnifying-glass"></i>
                    <span class="ml-10">${object.name}</span>
                </a>`;
            });

            controls.mentionBox.html(html);
            controls.mentionBox.addClass('d-block').removeClass('d-none');

            startOffset = endOffset - q.length;
            
            controls.mentionBox.find('.dropdown-item').off('click').on('click', function() {
                var data = {
                    id: $(this).attr('data-id'),
                    image: $(this).attr('data-image'),
                    mention: '@' + $(this).attr('data-mention'),
                }

                insertTagWithinRange(selection, range, startOffset, focusOffset, data);

                controls.mentionBox.addClass('d-none').removeClass('d-block');
            });
        });
    }, 500, 1000);

    const insertTagWithinRange = function(selection, range, startOffset, focusOffset, data = {}) {
        const span = document.createElement('span');

        $(span).addClass('text-blue fw-semibold').attr({
            'data-id': data.id,
            'data-image': data.image,
            'data-mention': data.mention,
        });

        const newRange = document.createRange();
              newRange.selectNodeContents(controls.textEditor[0]);
              newRange.setStart(range.startContainer, startOffset);
              newRange.setEnd(range.endContainer, focusOffset);
              newRange.deleteContents();
              newRange.insertNode(span);
              newRange.setStartAfter(span);
              newRange.setEndAfter(span);
        
        const nbsp = document.createTextNode('\u00A0');
              newRange.insertNode(nbsp);
              newRange.setStartAfter(nbsp);
              newRange.setEndAfter(nbsp);
        
        selection.removeAllRanges();
        selection.addRange(newRange);
    }

    const getMentionData = function() {
        const childNodes = controls.textEditor[0].childNodes;
        
        var array = [];

        childNodes.forEach(function(node) {
            if (node.nodeType === Node.ELEMENT_NODE) {
                array.push({
                    id: node.dataset.id,
                    image: node.dataset.image,
                    name: node.dataset.mention.substring(1),
                });
            }
        });
        
        return array.length > 0 ? array : '';
    }

    function init(values = {}) {
        vals = bindVals(values);
        controls = bindControls();

        bindFunctions();
    }

    return {
        init: init,
        getMentionData: getMentionData,
    }

})();

TEXT_EDITOR.init();