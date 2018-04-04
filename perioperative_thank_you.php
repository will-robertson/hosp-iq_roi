<?php get_header(); ?>

<?php /* Template Name: MERGED Perioperative Results */ ?>

<?php

  session_start();

	$orgNameUnclean = $_POST["org-name"];
  $badCharacters  = ["(", ")", ":", "*", "<", ">", ";", "$", "{", "}", "[", "]", "|", ","];

  // Sanitize the organization name for the PDF link
  $orgNameSpaceless  = str_replace(" ", "-", $orgNameUnclean);
  $orgNameSingleless = str_replace("\'", "", $orgNameSpaceless);
  $orgNameSlashless  = stripcslashes($orgNameSingleless);
  $orgNameLink       = str_replace($badCharacters, "", $orgNameSlashless);

  if (!($orgNameLink)) {
    $orgNameLink = 'Tests-Final';
  }

  // Sanitize the organization name for inline text
  $orgNameCharacterless = str_replace([":", "*", "<", ">", ";", "$", "{", "}", "[", "]", "|", ","], "", $orgNameUnclean);
  $orgNameSingleQuote   = str_replace("\'", "", $orgNameCharacterless);
  $orgName              = htmlentities($orgNameSingleQuote);

  // Create a variable that can be passed through to the thank you page
  $pdfLink     = "/wp-content/themes/HospitalIQ2017/ROI-PDF/" . $orgNameLink . "-Perioperative-ROI.pdf";
  $organization = $orgName;
  $linkAnchor = "<a href='http://www.hospiq.com{$pdfLink}'>{$organization} Perioperative ROI PDF</a>";

  $sysNameUnclean = $_POST['health-system-name'];
  $sysName        = htmlentities($sysNameUnclean);

  // These are numbers, no sanitization needed
  $staffedORs = $_POST["staffed-ors"]; 
  $primeTime  = $_POST["prime-time-utilization"];
  $procedures = $_POST["procedures"];
  $orCosts    = $_POST["or-costs"];

  // US Dollar
  setlocale(LC_MONETARY, 'en_US.UTF-8');

  // if the or cost is unknown, replace it with a default value.
  if ($orgName == '' || $orgName == null) {
  
    $orgName = 'Your Medical Organization';

  } 

  if ($orCosts == '' || $orCosts < 1 || $orCosts == null) {

    $orCosts = 600000;

  }

  if ($sysName == '' || $sysName < 1 || $sysName == null) {

    $sysName = 'N/A';

  }

  // The ROI Math
  $moneySaved              = (( $orCosts * 0.75 ) * 0.03) + ($orCosts * 0.03);
  
  // Formats money saved as a number (default is 123,456)
  $formatted_moneySaved    = number_format($moneySaved);
  $formatted_orCosts       = number_format($orCosts);
  $formatted_procedures    = number_format($procedures);

  // INCLUDE THE phpToPDF.php FILE
  require("phpToPDF/phpToPDF.php"); 

  // Email HTML goes here, note the backslashes
  $my_html="<html lang=\"en\">
    <head>
      <meta charset=\"UTF-8\">
      <title>Hospital IQ for Perioperative | " . $orgName . "</title>
      <style>

        * {
          margin: 0;
          padding: 0;
        }

        body {
          background-color: #fff;
          font-size: 10pt;
          font-family: sans-serif;
          margin: 0;
          padding: 0;
        }

        div {
          display: block;
        }

        .container {
          margin: 0;
          padding: 0.6in 0.6in 0;
          float: none !important;
          width: 7.3in;
          height: 10in;
          background-color: #fff;
          background: #fff url(https://www.hospiq.com/wp-content/uploads/2017/11/banner_pdf.jpg) no-repeat 0 0;
          background-size: contain;
        }

        h2 {
          color: #2bacde;
          font-size: 12pt;
          text-transform: uppercase;
          padding-bottom: 15px
        }

        h3 {
          text-transform: uppercase;
        }

        h4 {
          font-size: 17px;
          font-weight: normal;
          letter-spacing: 0.8px;
        }

        ul {
          padding: 8px 0;
        }

        li {
          background: url(https://www.hospiq.com/wp-content/uploads/2017/11/arrow.png) no-repeat;
          padding: 2px 0 2px 20px;
          line-height: 17px;
          background-size: 10px 10px;
          background-position: 0px 5px;
          list-style-type: none;
        }

        .user-input {
          color: #eb538a;
        }

        .emphasis {
          font-weight: bolder;
          font-size: 10.5pt;
        }

        .top {
          height: 2in;
          width: 100%;
        }

        .intro {
          width: 3in;
          margin: 0 0 0 2.45in;
        }

        .intro p {
          font-size: 13.5pt;
          font-weight: lighter;
        }

        .intro p .user-input {
          font-size: 14pt;
          font-weight: bold;
        }

        .sidebar,
        .main {
          display: inline-block;
          margin-top: 15px;
        }

        .sidebar p,
        .main p {
          line-height: 16px
          font-weight: 300;
        }

        .sidebar {
          width: 2in;
          float: left;
        }

        .contact {
          border-top: 1px solid #aaa;
          margin-top: 15px;
          padding-top: 15px;
          text-align: center;
        }

        .main {
          width: 4.8in;
          height: 6.7in;
          float: right;
          border-left: 1px solid #aaa;
          padding: 0 0 0 0.25in;
        }

        .explanation p {
          font-size: 9.5pt;
        }

        .explanation p.emphasis {
          font-size: 10pt;
          padding-top: 15px;
        }

        .details {
          padding: 25px 25px 0;
          background-color: #dbeef9;
          position: relative;
          margin-top: 15px;
          min-height: 250px;
        }

        .about-user {
          margin-top: 5px;
        }

        .arrow-image {
          position: absolute;
          right: -30px;
          height: 150px;
          top: 25px;
        }

        .bottom {
          position: relative;
          bottom: -5px;
        }

        .outcome {
          padding: 10px 30px;
          background-color: #1f5b7c;
          color: #fff;
          line-height: 22px;
          margin: 10px 0;
        }

        .outcome .emphasis {
          font-size: 11.5pt;
        }

        .footer {
          text-align: right;
        }

      </style>
    </head>
    <body>
      <div class=\"container\">
        <div class=\"top\">
          <div class=\"intro\">
            <p>Greater OR efficiencies at<br>
            <span class=\"user-input\">" . $orgName . "</span><br>
            could mean an annual savings of<br>
            <span class=\"user-input saved-money\">$" . $formatted_moneySaved . " in operational margin</span><br>
            Imagine what that could mean<br>
            for your patients.
            </p>
          </div><!-- /intro -->
        </div><!-- /top -->
        <div class=\"sidebar\">
          <div class=\"info\">
            <h2>What is Hospital IQ?</h2>
            <p>Hospital IQ is a <span class=\"emphasis\">cloud-based healthcare operations planning and management software platform</span> that leverages the data from existing hospital IT systems and combines it with hospital policies, national benchmarks and regional real-time data sources to deliver the actionable insights, recommendations and change management support necessary for hospitals and health systems to achieve the finacial stability and growth required to support their mission. With robust analytics and reporting, what-if simulation modeling tools, automated workflows, and intelligent staffing structure capabilities, hospial leaders can holistically optimize resources and staff within OR, ED, and floor units or across the entire health system based on data-driven decisions that result in improved patient access, clinical outcomes, strategic growth, and financial performance.</p>
          </div><!-- /intro -->
          <div class=\"contact\">
            <p>To learn more about what<br>
            <span class=\"emphasis\">Hospital IQ</span>
            can do for you contact us at<br>
            <span class=\"emphasis\">617-960-8600</span><br>
            visit us at<br>
            <span class=\"emphasis\"><a href=\"https://hospiq.com\">hospiq.com</a></span></p>
          </div><!-- /contact -->
        </div><!-- /sidebar -->
        <div class=\"main\">
          <div class=\"explanation\">
            <h2>What is hospital IQ for Perioperative?</h2>
            <p>Hospital IQ for Perioperative enables hospitals and health systems to implement block schedules that optimize every hour of OR time, staff, and surgical bed.</p>
            <p class=\"emphasis\">OR Performance Management</p>
            <p>Create a framework of acountability by analyzing key OR performance and utilization metrics through many different perspectives.</p>
            <p class=\"emphasis\">Block Schedule Management</p>
            <p>Manage your block schedule electronically across surgeons, service line leaders, and leadership teams.</p>
            <p class=\"emphasis\">Staff Structure Optimization</p>
            <p>Identify opportunities to restructure OR staffing to reduce labor costs and improve job satisfaction based on exptected demand.</p>
            <p class=\"emphasis\">What if Analysis</p>
            <p>Analyze scenarios and find the optimal route on adjustments to your OR process.</p>
          </div>
          <div class=\"details\">
            <img src=\"https://www.hospiq.com/wp-content/uploads/2017/11/arrow.png\" class=\"arrow-image\">
            <h3>What hospital IQ could mean for</p>
            <h3 class=\"user-input\">" . $orgName . "</h3>
            <p class=\"about-user\">About <span class=\"user-input\">" . $orgName . "</span></p>
            <ul>
              <li>Number of ORs: <span class=\"user-input\">" . $staffedORs . "</span></li>
              <li>Estimated OR labor costs / year: <span class=\"user-input\">$" . $formatted_orCosts . "</span></li>
              <li>Estimated number of procedures / year: <span class=\"user-input\">" . $formatted_procedures . "</span></li>
              <li>Estimated primetime utilization rate: <span class=\"user-input\">" . $primeTime . "%</span></li>
            </ul>
            <p>Opportunities for <span class=\"user-input\">" . $orgName . "<span class=\"user-input\"></p>
            <ul>
              <li>Improve perioperative utilization</li>
              <li>Optimize perioperative staff structure to align to surgical demand and improve staff satisfaction</li>
            </ul>
          </div>
          <div class=\"bottom\">
            <div class=\"outcome\">
              <h4>An estimated <span class=\"emphasis\">savings</span> of <span class=\"emphasis\">$" . $formatted_moneySaved . "</span><br>
              annually with <span class=\"emphasis\">uptime</span> in <span class=\"emphasis\">less than 30 days.</span></h4>
            </div>
            <div class=\"footer\">
              <p><a href=\"https://www.hospiq.com\">www.hospiq.com</a> | <a href=\"mailto:info@hospiq.com\">info@hospiq.com</a> | 617.960.8600</p>
            </div>
          </div>
        </div><!-- /main -->
      </div><!-- /content -->
    </body>
  </html>";

  // Set PDF Options, http://phptopdf.com/documentation/
  $pdf_options = array(
    "source_type" => 'html',
    "source" => $my_html,
    "action" => 'save',
    "margin" => array(
       "right" => "0",
        "left" => "0",
         "top" => "0",
      "bottom" => "0"
    ),
    "save_directory" => '/home4/hospiqco/public_html/wp-content/themes/HospitalIQ2017/ROI-PDF',
    "file_name" => $orgNameLink . '-Perioperative-ROI.pdf');

  // puts your options through the machine
  phptopdf($pdf_options);

  // Basic User Information, not sanitized.
  $firstName     = $_POST["first-name"];
  $lastName      = $_POST["last-name"];
  $sendTo        = $_POST["email-address"];
  $phone         = $_POST["phone-number"];
  $jobTitle      = $_POST["job-title"];
  $orUtilization = $_POST["prime-time-utilization"];

  // Set to yes if the user checks off the "contact me..." See below
  $schedule;
  // If the user comes from the site, 
  $source;
  $medium;
  $term;
  $content;

  // If the user wants to be contacted or not
  if (isset($_POST["schedule-analysis"])) {
  
    $reminder = "<p>You also requested a brief phone call to discuss this ROI in more detail and to learn more about Hospital IQ for Perioperative. One of our team members will reach out to your shortly at " . $phone . " to schedule this call.</p><p>We look forward to learning more about <strong>" . $organization . "</strong> and to share with you how Hospital IQ could add thousands &#8211; even millions &#8211; of dollars to your bottom line.</p>";

    $schedule = 'Yes';

  } else {

    $reminder = "<p>We have worked with a number of leading institutions, including Boston Medical Center, Highland Hospital, and Catholic Health System to systematically increase surgical volume, OR and block utilization, as well as labor productivity.</p><p>We would love the opportunity to learn more about <strong>" . $organization . "</strong> and to share with you how Hospital IQ could add thousands, even million, of dollars to your bottom line. One of our team members will reach out to your shortly at " . $phone . " to schedule a follow up call, or simply reply to this email with a date/time that works best for you.</p>";

    $schedule = 'No';

  }

  // Check the referer
  $refer = $_SESSION['referer'];

if (strpos($refer, 'utm_source') > 0) {

    // Create a substring from refer that cuts the url into parts based on the 
    function get_string_between($string, $start, $end) {
      $string = ' ' . $string;
      $ini = strpos($string, $start);
      if ($ini == 0) return '';
      $ini += strlen($start);
      $len = strpos($string, $end, $ini) - $ini;
      return substr($string, $ini, $len);
    }

    // Cut the string into distinct sections based on start/finish pairs
    $source_parsed = get_string_between($refer, 'utm_source=', '&utm_medium=');
    $medium_parsed = get_string_between($refer, '&utm_medium=', '&utm_campaign=');
    $term_parsed   = get_string_between($refer, '&utm_term=',   '&utm_content=');

    // Parts which can not be extracted via the above function
    $refer_first = parse_url($refer, PHP_URL_HOST);
    $refer_last  = explode('&utm_content=', $refer);

    // The Results of the above functions, ready to be passed to Mailchimp
    $source  = $source_parsed;
    $medium  = $medium_parsed;
    $term    = $term_parsed;
    $content = $refer_last[1];

  } else {

    // If the refer string lacks the parts needed, use these default values instead
    $source  = 'Marketing';
    $medium  = 'Website';
    $term    = '70150000001EIL9';
    $content = 'Periop ROI Calculator';

  }

  /* Sends 2 emails when the email submit button is pressed, one to the Admin, one to the User
     Note the number addition to the variable names for each email */
  if(isset($_POST["email-submit"])) {

    // User Message
    $From      = "Hospital IQ";
    $to        = $sendTo;
    $subject   = "Hospital IQ for Perioperative ROI Calculator Lead";
    $message   = "
      <html>
        <head>
          <title>Hospital IQ for Perioperative ROI Summary PDF</title>
          <style>
            h1 {font-size: 20px}
            .signature {margin: 4px 0; padding: 0;}
          </style>
        </head>
        <body>
          <h1>Hello " . $firstName . ",</h1>
          <p>Thank you for your recent interest in Hospital IQ for Perioperative. Here is a link to your one-page, PDF summary outlining the potential additional margin that could be achieved by <strong>" . $organization . "</strong> with just a small improvement in OR utilization and/or labor productivity. PDF Link: " . $linkAnchor . "</p>
          " . $reminder . "
          <p>Sincerely,</p>
          <p class=\"signature\"><strong>Hospital IQ Team</strong></p>
          <p class=\"signature\">55 Chapel Street</p>
          <p class=\"signature\">Suite 102</p>
          <p class=\"signature\">Newton, MA 02485</p>
          <p class=\"signature\">(617) 960-8600</p>
          <p class=\"signature\"><a href=\"https://www.hospiq.com/\" target=\"_blank\">HospIQ.com</a></p>
        </body>
      </html>
      ";

    // Essential details for the email to be sent properly
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=iso-8859-1';
    $headers[] = 'From: ROI@hospiq.com';
    $headers[] = 'Reply-To: ROI@hospiq.com';
    $headers[] = 'X-Mailer: PHP/' . phpversion();

    // Sends the first email
    mail($to, $subject, $message, implode("\r\n", $headers));

    // Admin Message - Note the '_2' added to each email specific variable 
    $From       = "ROI@hospiq.com";
    $to_2       = "cheryle@patientroute.com, wrobertson@exnihilo.com";
    $subject_2  = "Hospital IQ Entry";
    $message_2  = "
      <html>
        <head>
          <title>ROI Summary</title>
          <style>
            h1 {font-size: 20px;}
          </style>
        </head>
        <body>
          <h1>New Perioperative Form Entry</h1>
          <p>Someone has entered their information into the Perioperative ROI forms: </p>
          <ul>
            <li>Name: " . $firstName . " " . $lastName . "</li>
            <li>Organization: " . $organization . "</li>
            <li>System Name: " . $sysName . "</li>
            <li>Email: " . $sendTo . "</li>
            <li>Phone: " . $phone . "</li>
            <li>Staffed ORs: " . $staffedORs . "</li>
            <li>Prime Time %: " . $primeTime . "</li>
            <li># of Procedures: " . $procedures . "</li>
            <li>OR Costs: " . $orCosts . "</li>
            <li>Money Saved: " . $moneySaved . "</li>
            <li>Link to PDF: <a href=\"http://www.hospiq.com" . $pdfLink . "\">PDF</a></li>
          </ul>
        </body>
      </html> 
    ";

    // Essential details for the email to be sent properly
    $headers_2[] = 'MIME-Version: 1.0';
    $headers_2[] = 'Content-type: text/html; charset=iso-8859-1';
    $headers_2[] = 'From: ROI@hospiq.com';
    $headers_2[] = 'Reply-To: ROI@hospiq.com';
    $headers_2[] = 'X-Mailer: PHP/' . phpversion();

    // Sends the second email
    mail($to_2, $subject_2, $message_2, implode("\r\n", $headers_2));

  }

  //MAILCHIMP INTEGRATION
  // Send a HTTP POST request with curl
  if(isset($_POST['email-submit'])){

    // Check if the email field is
    if(!empty($sendTo) && !filter_var($sendTo, FILTER_VALIDATE_EMAIL) === false){

      // HIQ Mailchimp credentials
      $apiKey = '5eca9ef6443891f7f2f35ec5a211e083-us8';
      $listID = '85d19f35f3';

      // MailChimp API URL
      $memberID = md5(strtolower($sendTo));
      $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
      $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listID . '/members/' . $memberID;

      // member information
      $json = json_encode([
        'email_address' => $sendTo,
        'status'        => 'subscribed',
        'merge_fields'  => [
            'FNAME'       => $firstName,
            'LNAME'       => $lastName,
            'PHONE'       => $phone,
            'COMPANY'     => $orgName,
            'ORSYSTEM'    => $sysName,
            'NUMOFORS'    => $staffedORs,
            'ORLABORC'    => $orCosts,
            'PROCYEAR'    => $procedures,
            'ORUTILRATE'  => $orUtilization,
            'JOBTITLE'    => $jobTitle,
            'SOURCE'      => $source,
            'MEDIUM'      => $medium,
            'TERM'        => $term,
            'CONTENT'     => $content,
            'REQANALYSI'  => $schedule
            // 'REFERRER'    => $refer_first
          ]
      ]);

      // Curl workspace
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
      curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_TIMEOUT, 10);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
      // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_SSL_VERIFYSSL, false);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
      $result = curl_exec($ch);
      $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      curl_close($ch);

      // Store the status message based on response code
      if ($httpCode == 200) {

        $_SESSION['msg'] = '<p style="color: #34A853">You have successfully subscribed to Mailchimp.</p>';

      } else {

        switch ($httpCode) {

          case 214:
            $msg = 'You are already subscribed.';
            break;

          default:
            $msg = 'Some problem occurred, please try again.';
            break;

        }

        $_SESSION['msg'] = '<p style="color: #EA4335">'.$msg.'</p>';

      }

    } else {

      $_SESSION['msg'] = '<p style="color: #EA4335">Please enter valid email address.</p>';

    }

  }

?>

<div id="primary" class="content-area">
  <main id="main" class="site-main perioperative-form-output" role="main">

    <h3>With a small improvement in OR utilization,<br>
        and labor productivity,<h3>

    <h1 class="organization-name"><?php echo $orgName;?></span></h1>

    <h3>could achieve an estimated ROI of</h3>
    <h3 class="money-saved"><span><?php echo money_format('%.0n', $moneySaved);?></span> annually</h3>
    <h3>with uptime in less than 30 days!</h3>
    <p>Our comprehensive operational planning and management platform is designed to not only help you clearly understand your historical performance, but to give you the insights you need to make adjustments that can demonstrate immediate return as well as the tools you need to plan for future growth.</p>
    <p>The results are a strong, rapid return on your investment while improving the access and level of care for your paitents and the satisfaction of your staff.</p>
    <h4>Download your results in a free, one-page pdf summary document.</h4>
    <p class="perioperative-pdf-sample-image"><img class="alignnone size-full wp-image-2255" src="https://www.hospiq.com/wp-content/uploads/2017/11/perioperative-pdf-sample.png" alt="" id="perioperative-pdf-sample"/></p>

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
<?php get_footer(); ?>

<?php
  // Clear all session data 
  session_unset();
  session_destroy();
?>
