/**
 * Assessment System JavaScript — UI + Security
 *
 * Handles:
 *  1. Option pill selection highlighting
 *  2. Client-side validation (UX only — server is authoritative)
 *  3. reCAPTCHA v3 token fetch and injection before form submits
 *  4. Submit button loading state
 *
 * The form submits normally (page reload / PRG) — no AJAX.
 *
 * @package mindful-insights-theme
 */
(function ($) {
    'use strict';

    var recaptchaEnabled = (
        typeof assessmentData !== 'undefined' &&
        assessmentData.recaptchaEnabled === 'yes' &&
        assessmentData.recaptchaSiteKey
    );


    /* ============================================================
       OPTION PILL SELECTION HIGHLIGHT
       ============================================================ */
    $(document).on('change', '.assessment-radio', function () {
        var $question = $(this).closest('.assessment-question-card');
        $question.find('.option-label').removeClass('selected');
        $question.removeClass('has-error');
        $(this).closest('.option-label').addClass('selected');
    });


    /* ============================================================
       FORM SUBMIT — validate → reCAPTCHA token → submit
       ============================================================ */
    $('#assessment-form').on('submit', function (e) {
        e.preventDefault();

        if (!clientValidate()) {
            return false;
        }

        var $form = $(this);
        setLoadingState(true);

        if (recaptchaEnabled && typeof grecaptcha !== 'undefined') {
            // Get fresh reCAPTCHA v3 token, then submit.
            grecaptcha.ready(function () {
                grecaptcha
                    .execute(assessmentData.recaptchaSiteKey, { action: 'assessment_submit' })
                    .then(function (token) {
                        injectToken($form, token);
                        $form[0].submit();
                    })
                    .catch(function (err) {
                        // reCAPTCHA library error — let server-side handle it.
                        console.warn('[reCAPTCHA] execute failed:', err);
                        injectToken($form, '');
                        $form[0].submit();
                    });
            });
        } else {
            // reCAPTCHA not configured — proceed without token.
            $form[0].submit();
        }
    });

    /**
     * Inject the reCAPTCHA token as a hidden field (replace if exists).
     */
    function injectToken($form, token) {
        $form.find('input[name="recaptcha_token"]').remove();
        $('<input>').attr({ type: 'hidden', name: 'recaptcha_token', value: token }).appendTo($form);
    }

    /**
     * Toggle submit button loading state.
     */
    function setLoadingState(loading) {
        var $btn = $('#assessment-submit-btn');
        if (loading) {
            $btn.prop('disabled', true).html(
                '<svg class="animate-spin inline w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">' +
                '<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>' +
                '<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>' +
                '</svg>যাচাই হচ্ছে...'
            );
        } else {
            $btn.prop('disabled', false).text('ফলাফল দেখুন');
        }
    }


    /* ============================================================
       CLIENT-SIDE VALIDATION (UX only — server always re-validates)
       ============================================================ */
    function clientValidate() {
        var valid = true;

        // Clear previous error highlighting.
        $('.form-input').removeClass('has-error');
        $('.assessment-question-card').removeClass('has-error');

        // Required visitor fields.
        ['visitor_name', 'visitor_age', 'visitor_job', 'visitor_phone'].forEach(function (id) {
            var $el = $('#' + id);
            if ($el.val().trim() === '') {
                $el.addClass('has-error');
                valid = false;
            }
        });

        // Email format — only if provided.
        var $email = $('#visitor_email');
        if ($email.val().trim() !== '' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test($email.val().trim())) {
            $email.addClass('has-error');
            valid = false;
        }

        // Every question must have an answer.
        $('.assessment-question-card').each(function () {
            if ($(this).find('.assessment-radio:checked').length === 0) {
                $(this).addClass('has-error');
                valid = false;
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
