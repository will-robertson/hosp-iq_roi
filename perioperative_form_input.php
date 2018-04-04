<?php get_header(); ?>
<?php
  
  // Finds how the user got to this page
  session_start();

  $uri = $_SERVER['REQUEST_URI'];
   
  $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
   
  $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

  $_SESSION['referer'] = $url;
  
?>
<?php /* Template Name: MERGED Perioperative Form */ ?>

<div id="primary" class="content-area">
  <main id="main" class="site-main" role="main">
    
    <?php
    // Start the loop.
    while ( have_posts() ) : the_post();

      // Include the page content template.
      get_template_part( 'template-parts/content', 'page' );

      // If comments are open or we have at least one comment, load up the comment template.
      if ( comments_open() || get_comments_number() ) {
        comments_template();
      }

      // End of the loop.
    endwhile;
    ?>

  </main><!-- .site-main -->

  <?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<!-- Default Form Elements -->
<div class="perioperative-form">
  <form class="hospital-iq pdf-download" id="hospiq-perioperative form-block" action="https://www.hospiq.com/perioperative-thank-you/" method="post">

    <!-- Part 1 introduction -->
    <div class="introduction">
      <p class="step-image" id="step-one"><img id="perioperative-step-number-1" class="alignnone size-full wp-image-2245" src="https://www.hospiq.com/wp-content/uploads/2017/11/number_one.png" alt="" width="103" height="103" /></p>
      <h2 class="provide-info">Tell us about your hospital.</h2>
      <p class="provide-info">Provide a few basic data points about your perioperative operations. All fields required.</p>
    </div><!-- \part 1 introduction -->

    <!-- Part 1 form -->
    <div class="input-block">
      <div class="left">
        <p>Name of Your Organization</p>
        <input id="org-name" type="text" name="org-name" required="required">
        <p class="health-system-name-query">Is your site part of a health system?</p>
        <div class="health-system-choice">
          <div class="choices">
            <input class="health-system health-system-option" type="radio" name="health-system" value="no" checked onClick="hideSystem()"> <span>No</span>
            <input class="health-system health-system-option" id="health-system-yes" type="radio" name="health-system" value="yes" onClick="showSystem()"> <span>Yes</span>
          </div><!-- \choices -->
          <input class="health-system" id="health-system-name" name="health-system-name" placeholder="Health System Name" type="text" oninput="this.value = this.value.replace(/([\\\/])/g, '')">
        </div>
        <p># Of Staffed ORs You Currently Have</p>
        <input id="staffed-ors" name="staffed-ors" type="number" min="1"  required="required">
      </div><!-- \left -->
      <div class="right">
        <p>Estimated OR Labor Costs/Year (leave blank for an industry average)</p>
        <span class="shifted-prepend dollar">$</span><input id="or-costs" name="or-costs" type="number" min="0" required="required">
        <p>Estimated # of Procedures Performed Each Year</p>
        <input id="procedures" name="procedures" type="number" min="0" required="required">
        <p>Estimated Prime-Time OR Utilization Rate</p>
        <span class="shifted-prepend percent">%</span><input id="prime-time-utilization" name="prime-time-utilization" type="number" min="1" max="100"  required="required">
      </div><!-- \right -->
    </div><!-- \part 1 form -->

    <!-- Part 2 introduction -->
    <div class="introduction">
      <p class="step-image" id="step-two"><img class="alignnone size-full wp-image-2254" src="https://www.hospiq.com/wp-content/uploads/2017/11/number_two.png" alt="" width="103" height="103" id="perioperative-step-number-2"/></p>
      <h2 class="provide-info">Tell us about you.</h2>
      <p class="provide-info">Provide your contact information and receive your free, one-page ROI summary PDF. All fields required.</p>
    </div>

    <!-- Part 2 form -->
    <div class="input-block">
      <div class="left">
        <p>First Name</p>
        <input id="first-name" name="first-name" type="text" required="required">
        <p>Last Name</p>
        <input id="last-name" name="last-name" type="text" required="required">
        <p>Job Title</p>
        <input id="job-title" name="job-title" type="text" required="required">
      </div><!-- \left -->
      <div class="right">
        <p>Email Address to recieve PDF</p>
        <input id="email" name="email-address" type="email" required="required">
        <p>Phone Number</p>
        <input id="phone" name="phone-number" type="tel" required="required">
        <input id="schedule" name="schedule-analysis" type="checkbox"><span>Please schedule a call to walk through a more detailed ROI analysis.</span>
      </div><!-- \right -->
    </div>

    <input class="next-page" type="submit" name="email-submit" value="Send Now" onclick="ga('send', 'event', 'Get PDF', 'Submit', 'ROI Calculate');"><span class="warning"></span>

  </form>
</div>
<script>

  // Toggle the Health System input box
  function showSystem() {
  
    document.getElementById("health-system-name").style.display="inline";
  
  }
  
  function hideSystem() {
  
    document.getElementById("health-system-name").style.display="none";
    
  }

</script>