<?php
/**
 * Template Name: Contact Page
 */

get_header()
?>

<?php get_template_part( 'template-parts/banner-1' ); ?>

<!-- Contact Page Section Starts -->
<section class="py-20 bg-white">
  <div class="max-w-7xl mx-auto px-6">
    
    <!-- Heading -->
    <div class="text-center mb-14">
        <h2 class="text-2xl md:text-4xl font-[600] mb-6">
            Get Your Consultation
        </h2>

        <p class="text-font-gray-light text-balance text-lg max-lg:text-[16px] leading-[32px] max-lg:leading-[1.7em] mb-11">
            Don't wait. The sooner you call, the sooner we can start fighting for the compensation you deserve. All consultations are affordable, professional, and confidential.
        </p>

    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
      
      <!-- Form Card -->
      <div class="lg:col-span-2 border border-[#A8A8A8] rounded-2xl px-14 max-lg:px-8 py-12">
        <?php echo do_shortcode('[contact-form-7 id="6e45351" title="Contact form"]'); ?>
      </div>

      <!-- Sidebar -->
      <div class="space-y-8">
        
        <!-- Help Card -->
        <div class="border border-[#A8A8A8] rounded-2xl px-8 py-12">
          <h3 class="text-2xl font-[500] mb-8">Need Help Right Now?</h3>

          <div class="space-y-5">
            <div class="flex items-start gap-3 mb-6">
              <span>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M11.9998 8C13.9665 8 15.904 8.39583 17.8123 9.1875C19.7206 9.97917 21.4165 11.1667 22.8998 12.75C23.0998 12.95 23.1998 13.1833 23.1998 13.45C23.1998 13.7167 23.0998 13.95 22.8998 14.15L20.5998 16.4C20.4165 16.5833 20.204 16.6833 19.9623 16.7C19.7206 16.7167 19.4998 16.65 19.2998 16.5L16.3998 14.3C16.2665 14.2 16.1665 14.0833 16.0998 13.95C16.0331 13.8167 15.9998 13.6667 15.9998 13.5V10.65C15.3665 10.45 14.7165 10.2917 14.0498 10.175C13.3831 10.0583 12.6998 10 11.9998 10C11.2998 10 10.6165 10.0583 9.94981 10.175C9.28314 10.2917 8.63314 10.45 7.9998 10.65V13.5C7.9998 13.6667 7.96647 13.8167 7.8998 13.95C7.83314 14.0833 7.73314 14.2 7.5998 14.3L4.6998 16.5C4.4998 16.65 4.27897 16.7167 4.0373 16.7C3.79564 16.6833 3.58314 16.5833 3.3998 16.4L1.0998 14.15C0.899805 13.95 0.799805 13.7167 0.799805 13.45C0.799805 13.1833 0.899805 12.95 1.0998 12.75C2.56647 11.1667 4.25814 9.97917 6.1748 9.1875C8.09147 8.39583 10.0331 8 11.9998 8Z" fill="#24417C"/>
                </svg>
              </span>
              <div>
                <p class="font-medium">+(880) 1774-848960</p>
                <p class="text-sm font-[300] text-[#808080]">Call for immediate assistance</p>
              </div>
            </div>
            <div class="flex items-start gap-3 mb-6">
              <span>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M4 20C3.45 20 2.975 19.8083 2.575 19.425C2.19167 19.025 2 18.55 2 18L2 6C2 5.45 2.19167 4.98333 2.575 4.6C2.975 4.2 3.45 4 4 4L20 4C20.55 4 21.0167 4.2 21.4 4.6C21.8 4.98333 22 5.45 22 6V18C22 18.55 21.8 19.025 21.4 19.425C21.0167 19.8083 20.55 20 20 20H4ZM12 13L20 8V6L12 11L4 6V8L12 13Z" fill="#24417C"/>
                </svg>
              </span>
              <div>
                <p class="font-medium">mindfulinsightsbd@gmail.com</p>
                <p class="text-sm font-[300] text-[#808080]">Email us anytime</p>
              </div>
            </div>
            <div class="flex items-start gap-3 mb-6">
              <span>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M10.7401 20C10.2193 20 9.69843 20 9.1776 20C9.13871 19.9861 9.10121 19.9666 9.06093 19.9583C8.52482 19.8611 7.97621 19.8055 7.45121 19.6653C2.33593 18.3027 -0.818234 13.2611 0.185932 8.07497C1.2151 2.75692 6.37204 -0.78614 11.7193 0.149971C15.9595 0.893027 19.2748 4.29719 19.8901 8.54164C19.9234 8.76803 19.9623 8.99303 19.9998 9.21942C19.9998 9.74025 19.9998 10.2611 19.9998 10.7819C19.9873 10.8152 19.9665 10.8472 19.9623 10.8805C19.9109 11.2277 19.8748 11.5764 19.8095 11.9208C19.0248 16.0472 15.622 19.2903 11.4582 19.8903C11.2179 19.925 10.979 19.9639 10.7401 20ZM9.99427 1.24997C5.17204 1.25414 1.24427 5.1833 1.24704 10.0027C1.24982 14.8236 5.18316 18.7528 10.0012 18.7486C14.8234 18.7444 18.7526 14.8139 18.7484 9.99581C18.7457 5.17358 14.8151 1.24719 9.99427 1.24997Z" fill="#24417C"/>
                    <path d="M9.99429 1.25C14.8151 1.24584 18.7457 5.17223 18.7499 9.99584C18.754 14.8139 14.8249 18.7458 10.0026 18.7486C5.18318 18.7528 1.24985 14.825 1.24707 10.0042C1.24429 5.18473 5.17207 1.25417 9.99429 1.25ZM9.38179 3.75417C9.37763 3.79028 9.37485 3.80973 9.37485 3.82778C9.37485 5.93056 9.37346 8.03334 9.37902 10.1361C9.37902 10.2125 9.43041 10.3069 9.48735 10.3639C10.7262 11.6097 11.9707 12.8528 13.2137 14.0958C13.2443 14.1264 13.2749 14.1542 13.2846 14.1639C13.586 13.8625 13.8749 13.575 14.1665 13.2819C13.0374 12.1528 11.8971 11.0111 10.7512 9.87223C10.6554 9.77639 10.6207 9.68195 10.6207 9.55C10.6249 7.68889 10.6235 5.82639 10.6235 3.96528C10.6235 3.89584 10.6235 3.82778 10.6235 3.75417C10.1999 3.75417 9.79707 3.75417 9.38179 3.75417Z" fill="#24417C"/>
                    <path d="M9.38124 3.75391C9.79791 3.75391 10.1993 3.75391 10.6229 3.75391C10.6229 3.82752 10.6229 3.89557 10.6229 3.96502C10.6229 5.82613 10.6243 7.68863 10.6201 9.54974C10.6201 9.68307 10.6535 9.77613 10.7507 9.87196C11.8965 11.0095 13.0368 12.1525 14.166 13.2817C13.8743 13.5734 13.5854 13.8622 13.284 14.1636C13.2743 14.1539 13.2424 14.1247 13.2132 14.0956C11.9701 12.8525 10.7271 11.6109 9.4868 10.3636C9.42985 10.3067 9.37846 10.2122 9.37846 10.1359C9.37291 8.03307 9.3743 5.9303 9.3743 3.82752C9.37291 3.80946 9.37707 3.79141 9.38124 3.75391Z" fill="white"/>
                </svg>
              </span>
              <div>
                <p class="font-medium">Available 24/7</p>
                <p class="text-sm font-[300] text-[#808080]">Emergency consultations</p>
              </div>
            </div>
          </div>

          <a href="tel:+8801774848960"
            class="block text-sm sm:text-base text-center mt-11 w-full bg-theme-blue hover:bg-theme-blue-hover text-white py-3 px-1 rounded-full transition">
            Call Now For Consultation
          </a>

          <a href="https://wa.me/8801774848960?text=Hello,%20I%20would%20like%20to%20book%20an%20appointment."
            class="block text-sm sm:text-base text-center mt-4 w-full bg-[#128C7E] hover:bg-green-800 text-white py-3 px-1 rounded-full transition"
            target="_blank"
          >
            <div class="flex gap-2 justify-center">
                <img src="<?php echo get_template_directory_uri() . '/assets/images/whatsapp-icon.png'; ?>" height="25" width="25" alt="Whatsapp icon">
                Message Us on WhatsApp
            </div>
          </a>

          <a href="http://m.me/mindfulinsightsbd"
            class="block text-sm sm:text-base text-center mt-4 w-full bg-[#40b0ff] hover:bg-blue-800 text-white py-3 px-1 rounded-full transition"
            target="_blank"
          >
            <div class="flex gap-2 justify-center">
                <img src="<?php echo get_template_directory_uri() . '/assets/images/messenger-icon.ico'; ?>" height="25" width="25" alt="Whatsapp icon">
                Message Us on Messenger
            </div>
          </a>

        </div>

        <!-- Why Choose Us -->
        <div class="bg-[#F2FAFF] rounded-2xl px-8 py-12">
          <h3 class="text-2xl font-[500] mb-10">Why Choose Us?</h3>

          <ul class="space-y-4">
            <!-- 24/7 Emergency -->
            <li class="flex items-start gap-3">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mt-[2px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <span>Available 24/7 for Emergencies</span>
            </li>

            <!-- Online Counseling -->
            <li class="flex items-start gap-3">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mt-[2px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M4 6h11a1 1 0 011 1v10a1 1 0 01-1 1H4a1 1 0 01-1-1V7a1 1 0 011-1z" />
              </svg>
              <span>Online counseling via WhatsApp &amp; Google Meet</span>
            </li>

            <!-- Ethical & Confidential -->
            <li class="flex items-start gap-3">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mt-[2px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3l8 4v5c0 5-3.5 8-8 9-4.5-1-8-4-8-9V7l8-4z" />
              </svg>
              <span>Ethical &amp; Confidential Care</span>
            </li>

          </ul>

        </div>

      </div>
    </div>
  </div>
</section>
<!-- Contact Page Section Ends -->

<?php get_template_part( 'template-parts/need-assistance' ); ?>

<?php get_template_part( 'template-parts/faq' ); ?>

<?php get_footer(); ?>