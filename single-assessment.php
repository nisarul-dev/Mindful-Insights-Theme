<?php
/**
 * Single Assessment Template
 *
 * Three states:
 *  1. result_token in GET → retrieve transient, show result card
 *  2. form_errors in GET  → retrieve transient, show errors + pre-filled form
 *  3. Clean visit          → show empty form
 *
 * @package mindful-insights-theme
 */

// ── Resolve page state ──────────────────────────────────────────────────────
$result_data     = null;
$form_error_data = null;

if ( ! empty( $_GET['result_token'] ) ) {
	$token       = sanitize_text_field( wp_unslash( $_GET['result_token'] ) );
	$result_data = get_transient( 'mit_result_' . $token );
	if ( $result_data ) {
		delete_transient( 'mit_result_' . $token ); // One-time use.
	}
}

if ( ! $result_data && ! empty( $_GET['form_errors'] ) ) {
	$error_token     = sanitize_text_field( wp_unslash( $_GET['form_errors'] ) );
	$form_error_data = get_transient( 'mit_form_errors_' . $error_token );
	if ( $form_error_data ) {
		delete_transient( 'mit_form_errors_' . $error_token ); // One-time use.
	}
}

// ── Old field values (pre-fill on error ────────────────────────────────────
$old = $form_error_data['old_data'] ?? array();
$errors_list = $form_error_data['errors'] ?? array();

// ── Template start ──────────────────────────────────────────────────────────
get_header();

if ( ! have_posts() ) {
	get_footer();
	exit;
}

the_post();
$assessment_id   = get_the_ID();
$description     = get_carbon_field( 'mit_assessment_description' );
$banner_image_id = get_carbon_field( 'mit_assessment_banner_image' );
$questions       = carbon_get_the_post_meta( 'mit_assessment_questions' );
?>

<!-- Assessment Hero / Banner -->
<section class="assessment-hero bg-theme-light-gray py-[60px] max-md:py-[40px]">
    <div class="container mx-auto px-5 lg:px-2">
        <!-- Breadcrumb -->
        <div class="breadcrumb text-font-gray text-sm mb-6">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-theme-blue">Home</a>
            <span class="mx-2">/</span>
            <a href="<?php echo esc_url( get_post_type_archive_link( 'assessment' ) ); ?>" class="hover:text-theme-blue">Assessments</a>
            <span class="mx-2">/</span>
            <span class="text-black"><?php the_title(); ?></span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h1 class="text-black text-balance text-2xl md:text-4xl xl:text-5xl font-semibold mb-6">
                    <?php the_title(); ?>
                </h1>
                <?php if ( $description ) : ?>
                <div class="assessment-description text-font-gray text-lg leading-relaxed">
                    <?php echo wp_kses_post( $description ); ?>
                </div>
                <?php endif; ?>
                <?php if ( is_array( $questions ) && count( $questions ) > 0 ) : ?>
                <div class="flex items-center gap-3 mt-6 text-font-gray">
                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
                    </div>
                    <span><?php echo esc_html( count( $questions ) ); ?> টি প্রশ্ন</span>
                </div>
                <?php endif; ?>
            </div>
            <?php if ( $banner_image_id ) : ?>
            <div class="assessment-hero-img rounded-[20px] overflow-hidden">
                <?php echo wp_get_attachment_image( $banner_image_id, 'large', false, array( 'class' => 'w-full h-[350px] object-cover' ) ); ?>
            </div>
            <?php elseif ( has_post_thumbnail() ) : ?>
            <div class="assessment-hero-img rounded-[20px] overflow-hidden">
                <?php the_post_thumbnail( 'large', array( 'class' => 'w-full h-[350px] object-cover' ) ); ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Main Content Section -->
<section class="assessment-form-section py-[78px] max-md:py-[40px]">
    <div class="container mx-auto px-5 lg:px-2">
        <div class="max-w-3xl mx-auto">

<?php if ( $result_data ) : ?>
            <!-- ═══════════════════════════════════════════════════
                 RESULT CARD — shown after successful submission
            ═══════════════════════════════════════════════════ -->
            <div id="assessment-result" class="assessment-result-card bg-white rounded-[24px] shadow-lg p-8 border-2 border-theme-blue/20 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-theme-blue/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                <div class="absolute bottom-0 left-0 w-20 h-20 bg-theme-blue/5 rounded-full translate-y-1/2 -translate-x-1/2"></div>
                <div class="relative z-10">
                    <!-- Score Badge -->
                    <div class="flex items-center gap-4 mb-6">
                        <div class="score-badge w-20 h-20 rounded-full bg-theme-blue text-white flex flex-col items-center justify-center flex-shrink-0 shadow-lg">
                            <span class="text-2xl font-bold"><?php echo intval( $result_data['total_score'] ); ?></span>
                            <span class="text-xs opacity-80">স্কোর</span>
                        </div>
                        <div>
                            <p class="text-font-gray text-sm mb-1">আপনার মূল্যায়নের ফলাফল</p>
                            <h2 class="text-black text-2xl font-bold"><?php echo esc_html( $result_data['result_title'] ); ?></h2>
                        </div>
                    </div>
                    <hr class="border-gray-100 mb-6">
                    <div class="text-font-gray text-base leading-relaxed prose max-w-none">
                        <?php echo wp_kses_post( $result_data['result_desc'] ); ?>
                    </div>
                    <?php if ( ! empty( $result_data['visitor_name'] ) ) : ?>
                    <p class="mt-4 text-font-gray text-sm">
                        প্রিয় <strong><?php echo esc_html( $result_data['visitor_name'] ); ?></strong>, আপনার মূল্যায়ন সম্পন্ন হয়েছে।
                    </p>
                    <?php endif; ?>
                    <div class="mt-8 p-4 bg-theme-light-gray rounded-[14px] text-font-gray text-sm">
                        <strong class="text-black">দ্রষ্টব্য:</strong> এই মূল্যায়নের ফলাফল কোনো চিকিৎসা পরামর্শের বিকল্প নয়।
                    </div>
                    <div class="mt-6 flex flex-wrap gap-4">
                        <a href="<?php echo esc_url( get_permalink() ); ?>"
                           class="inline-flex items-center gap-2 border-2 border-theme-blue text-theme-blue text-sm font-medium px-6 py-3 rounded-full hover:bg-theme-blue hover:text-white transition-all duration-300">
                            আবার চেষ্টা করুন
                        </a>
                        <a href="<?php echo esc_url( get_post_type_archive_link( 'assessment' ) ); ?>"
                           class="inline-flex items-center gap-2 bg-theme-blue text-white text-sm font-medium px-6 py-3 rounded-full hover:bg-theme-blue-hover transition-colors duration-300">
                            অন্য মূল্যায়ন দেখুন
                        </a>
                    </div>
                </div>
            </div>

<?php else : ?>
            <!-- ═══════════════════════════════════════════════════
                 ASSESSMENT FORM — shown on fresh visit or error
            ═══════════════════════════════════════════════════ -->

            <?php if ( ! empty( $errors_list ) ) : ?>
            <!-- Validation Errors Banner -->
            <div class="mb-6 p-5 bg-red-50 border-2 border-red-200 rounded-[16px]">
                <p class="font-semibold text-red-700 mb-2">অনুগ্রহ করে নিচের ত্রুটিগুলো ঠিক করুন:</p>
                <ul class="list-disc list-inside space-y-1 text-red-600 text-sm">
                    <?php foreach ( $errors_list as $err ) : ?>
                    <li><?php echo esc_html( $err ); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

            <form id="assessment-form" method="POST" action="<?php echo esc_url( get_permalink() ); ?>" novalidate>
                <?php wp_nonce_field( 'mit_assessment_submit', 'mit_assessment_nonce' ); ?>
                <input type="hidden" name="assessment_id"       value="<?php echo esc_attr( $assessment_id ); ?>">
                <input type="hidden" name="mit_submit_assessment" value="1">

                <!-- Honeypot: hidden from real users, bots auto-fill it → immediately rejected by server -->
                <div class="mit-hp-wrap" aria-hidden="true">
                    <label for="mit_hp_field">Leave this field empty</label>
                    <input type="text" id="mit_hp_field" name="mit_hp_field"
                           value="" tabindex="-1" autocomplete="off">
                </div>


                <!-- ══ VISITOR INFO ══ -->
                <div class="assessment-card bg-white rounded-[24px] shadow-sm p-8 mb-8">
                    <h2 class="text-black text-xl font-semibold mb-6 flex items-center gap-3">
                        <span class="w-8 h-8 rounded-full bg-theme-blue text-white text-sm flex items-center justify-center font-bold flex-shrink-0">✎</span>
                        আপনার তথ্য
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                        <!-- নাম -->
                        <div class="form-group">
                            <label class="form-label" for="visitor_name">নাম <span class="text-red-500">*</span></label>
                            <input type="text" id="visitor_name" name="visitor_name" class="form-input"
                                   placeholder="আপনার নাম লিখুন" required
                                   value="<?php echo esc_attr( $old['visitor_name'] ?? '' ); ?>">
                        </div>
                        <!-- বয়স -->
                        <div class="form-group">
                            <label class="form-label" for="visitor_age">বয়স <span class="text-red-500">*</span></label>
                            <input type="number" id="visitor_age" name="visitor_age" class="form-input"
                                   placeholder="আপনার বয়স" min="5" max="120" required
                                   value="<?php echo esc_attr( $old['visitor_age'] ?? '' ); ?>">
                        </div>
                        <!-- পেশা -->
                        <div class="form-group">
                            <label class="form-label" for="visitor_job">পেশা <span class="text-red-500">*</span></label>
                            <input type="text" id="visitor_job" name="visitor_job" class="form-input"
                                   placeholder="আপনার পেশা" required
                                   value="<?php echo esc_attr( $old['visitor_job'] ?? '' ); ?>">
                        </div>
                        <!-- ফোন নম্বর -->
                        <div class="form-group">
                            <label class="form-label" for="visitor_phone">ফোন নম্বর <span class="text-red-500">*</span></label>
                            <input type="tel" id="visitor_phone" name="visitor_phone" class="form-input"
                                   placeholder="০১XXXXXXXXX" required
                                   value="<?php echo esc_attr( $old['visitor_phone'] ?? '' ); ?>">
                        </div>
                        <!-- ইমেইল -->
                        <div class="form-group md:col-span-2">
                            <label class="form-label" for="visitor_email">
                                ইমেইল
                                <span class="text-font-gray text-xs font-normal ml-1">(ঐচ্ছিক — ফলাফল ইমেইলে পাঠানো হবে)</span>
                            </label>
                            <input type="email" id="visitor_email" name="visitor_email" class="form-input"
                                   placeholder="example@email.com"
                                   value="<?php echo esc_attr( $old['visitor_email'] ?? '' ); ?>">
                        </div>
                    </div>
                </div>

                <!-- ══ QUESTIONS ══ -->
                <?php if ( is_array( $questions ) && ! empty( $questions ) ) : ?>
                    <?php foreach ( $questions as $q_index => $question ) :
                        $q_text  = $question['question_text'] ?? '';
                        $options = is_array( $question['options'] ) ? $question['options'] : array();
                    ?>
                    <div class="assessment-question-card assessment-card bg-white rounded-[24px] shadow-sm p-8 mb-6"
                         data-question="<?php echo esc_attr( $q_index ); ?>">
                        <div class="flex gap-4 mb-6">
                            <span class="question-number w-9 h-9 rounded-full flex items-center justify-center flex-shrink-0 text-sm font-bold">
                                <?php echo esc_html( $q_index + 1 ); ?>
                            </span>
                            <h3 class="text-black text-lg font-medium leading-relaxed pt-1">
                                <?php echo esc_html( $q_text ); ?>
                            </h3>
                        </div>
                        <div class="options-grid grid grid-cols-1 gap-3">
                            <?php foreach ( $options as $o_index => $option ) :
                                $radio_id = 'q' . $q_index . '_o' . $o_index;
                            ?>
                            <label class="option-label flex items-center gap-4 p-4 rounded-[14px] border-2 border-gray-100 cursor-pointer hover:border-theme-blue transition-all duration-200 select-none"
                                   for="<?php echo esc_attr( $radio_id ); ?>">
                                <input type="radio"
                                       id="<?php echo esc_attr( $radio_id ); ?>"
                                       name="answers[<?php echo esc_attr( $q_index ); ?>]"
                                       value="<?php echo esc_attr( $o_index ); ?>"
                                       class="assessment-radio sr-only"
                                       required>
                                <span class="radio-indicator w-5 h-5 rounded-full border-2 border-gray-300 flex-shrink-0 flex items-center justify-center transition-all duration-200">
                                    <span class="w-2.5 h-2.5 rounded-full bg-theme-blue scale-0 transition-transform duration-200"></span>
                                </span>
                                <span class="option-text text-font-gray text-base"><?php echo esc_html( $option['option_text'] ?? '' ); ?></span>
                            </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>

                    <!-- Submit Button -->
                    <div class="text-center mt-8">
                        <button type="submit" id="assessment-submit-btn"
                                class="inline-flex items-center gap-3 bg-theme-blue text-white text-lg font-semibold px-10 py-4 rounded-full hover:bg-theme-blue-hover transition-colors duration-300">
                            ফলাফল দেখুন
                            <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19.2036 10.2012L12.3286 17.0762C12.0708 17.334 11.7271 17.4629 11.3833 17.4629C10.9966 17.4629 10.6528 17.334 10.395 17.0762C9.83643 16.5605 9.83643 15.6582 10.395 15.1426L14.9067 10.5879H1.7583C0.984863 10.5879 0.383301 9.98633 0.383301 9.21289C0.383301 8.48242 0.984863 7.83789 1.7583 7.83789H14.9067L10.395 3.32617C9.83643 2.81055 9.83643 1.9082 10.395 1.39258C10.9106 0.833984 11.813 0.833984 12.3286 1.39258L19.2036 8.26758C19.7622 8.7832 19.7622 9.68555 19.2036 10.2012Z" fill="white"/>
                            </svg>
                        </button>
                    </div>

                <?php else : ?>
                <div class="assessment-card bg-white rounded-[24px] p-8 text-center text-font-gray">
                    এই মূল্যায়নে এখনো কোনো প্রশ্ন যোগ করা হয়নি।
                </div>
                <?php endif; ?>

            </form>
<?php endif; // End form/result toggle ?>

        </div>
    </div>
</section>

<?php get_footer(); ?>
