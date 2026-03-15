/**
 * Assessment System JavaScript — UI Only (no AJAX)
 *
 * Handles:
 *  - Option pill selection highlighting on click
 *  - Client-side validation before form submit (UX only; server re-validates)
 *  - Submit button loading state while page navigates
 *
 * @package mindful-insights-theme
 */
(function ($) {
    'use strict';

    /* ============================================================
       OPTION PILL SELECTION HIGHLIGHT
       ============================================================ */
    $(document).on('change', '.assessment-radio', function () {
        var $question = $(this).closest('.assessment-question-card');

        // Remove selected from all siblings.
        $question.find('.option-label').removeClass('selected');
        $question.removeClass('has-error');

        // Highlight chosen option.
        $(this).closest('.option-label').addClass('selected');
    });


    /* ============================================================
       CLIENT-SIDE VALIDATION
       Prevents form submit if required fields are empty.
       Server always re-validates regardless.
       ============================================================ */
    $('#assessment-form').on('submit', function (e) {
        if (!clientValidate()) {
            e.preventDefault();
            return false;
        }

        // Show loading state on button.
        var $btn = $('#assessment-submit-btn');
        $btn.prop('disabled', true)
            .html('<svg class="animate-spin inline w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg> প্রেরণ হচ্ছে...');
    });


    /* ============================================================
       VALIDATION FUNCTION
       ============================================================ */
    function clientValidate() {
        var valid = true;

        // Clear previous error states.
        $('.form-input').removeClass('has-error');
        $('.assessment-question-card').removeClass('has-error');

        // Required text/phone/number fields.
        var required = ['visitor_name', 'visitor_age', 'visitor_job', 'visitor_phone'];
        required.forEach(function (id) {
            var $el = $('#' + id);
            if ($el.val().trim() === '') {
                $el.addClass('has-error');
                valid = false;
            }
        });

        // Email format if provided.
        var $email = $('#visitor_email');
        if ($email.val().trim() !== '' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test($email.val().trim())) {
            $email.addClass('has-error');
            valid = false;
        }

        // All questions must have a selection.
        var firstUnanswered = null;
        $('.assessment-question-card').each(function () {
            if ($(this).find('.assessment-radio:checked').length === 0) {
                $(this).addClass('has-error');
                valid = false;
                if (!firstUnanswered) {
                    firstUnanswered = $(this);
                }
            }
        });

        // Scroll to first error.
        if (!valid) {
            var $first = $('.has-error').first();
            if ($first.length) {
                $('html, body').animate({ scrollTop: $first.offset().top - 80 }, 400);
            }
        }

        return valid;
    }

}(jQuery));
