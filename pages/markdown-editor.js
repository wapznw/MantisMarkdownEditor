$(function () {
    var notes = [
        'td.bugnote-note',
        'td.bug-description',
        'td.bug-steps-to-reproduce',
        'td.bug-additional-information',
	'td[colspan="3"]'
    ];

    var editors = [
        '#description',
        '#steps_to_reproduce',
        '#additional_info',
        '#additional_information',
        '#bugnote_text',
        '[name="bugnote_text"]'
    ];

    var $form = $('form');

    editors.forEach(function (selector) {
        var $textarea = $(selector);
        if ($textarea && $textarea.length && $textarea.prop('tagName') === 'TEXTAREA' && !$textarea.data('Simditor')) {
            $textarea.data('Simditor', true);
            $textarea.val(marked($textarea.val(), {
                gfm: true
            }));
            var editor = new Simditor({
                textarea: $textarea,
                toolbar: ['bold', 'italic', 'underline', 'strikethrough', '|', 'ol', 'ul', 'blockquote', 'code', '|', 'link', 'image', '|', 'indent', 'outdent', 'markdown'],
                defaultImage: 'images/mantis_logo_notext.png',
                pasteImage: true,
                upload: {
                    url: 'plugin.php?page=MarkdownEditor/upload_file.php'
                }
            });

            var $tdCenter = $textarea.closest('td.center');
            if ($tdCenter.length) {
                $tdCenter.removeClass('center');
            }

            editor.on('valuechanged', function () {
                $textarea.val(toMarkdown(editor.getValue(), {
                    gfm: true
                }));
            });

            $form.on('submit', function () {
                $textarea.val(toMarkdown(editor.getValue(), {
                    gfm: true
                }));
            });
        }
    });

    $(notes.join(',')).each(function () {
        var $this = $(this);
        if (!$this.hasClass('editor-style')) {
            this.innerHTML = marked(this.innerText);
            $(this).addClass('editor-style');
        }
    })
});
