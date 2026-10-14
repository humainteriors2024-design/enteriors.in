<?php
/* The COMPANY LOGIN block removed from includes/config.php on 14 Oct 2026.
   To restore the feature: paste this block back into config.php (section 14). */
/* ---------- 14. COMPANY LOGIN (/company/) — firms sign in with a one-time code sent to their email ----------
   Profiles are saved in the private folder one level above public_html (leads/companies/).
   A firm whose email is already in includes/data/pros.php ('email' + 'verified' => true) can sign in and edit at once.
   Any other email can register or claim a listing; you approve it once at /admin/companies.php. */
const COMPANY = [
  'url'            => '/company/',
  'otp_minutes'    => 10,
  'otp_attempts'   => 5,
  'resend_seconds' => 45,
  'per_email_hour' => 4,
  'per_ip_hour'    => 10,
  'session_days'   => 14,      // stay signed in for this long on the same browser
  'notify_admin'   => true,    // email LEADS['notify_email'] when a firm registers, claims a listing or saves changes
];

