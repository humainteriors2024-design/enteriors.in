<?php
/* =====================================================================
   ENTERIORS — SHARED SITE ENGINE
   One include that loads everything a page, a blog post or the lead
   handler needs. Pages never include these files one by one; they just
   require head.php (pages), post-start.php (blog posts) or this file (api).

     config.php      site facts: name, URL, contact, social, tracking IDs, forms, switches
     functions.php   small HTML helpers (cards, links, breadcrumbs, facts)
     images.php      per-page media folders; alt text from the file name
     leads.php       form security key + validation shared by forms and api/lead.php
     tracking.php    GA4, GTM, Google Ads, Meta Pixel, Search Console tags
     nav.php         pillars and their cluster pages (menus, footer, pillar cards)
     posts-data.php  the blog post list
     schema.php      structured data
     designers.php   interior designer listings (data: includes/data/designers.php)
   ===================================================================== */
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/images.php';
require_once __DIR__ . '/leads.php';
require_once __DIR__ . '/tracking.php';
require_once __DIR__ . '/nav.php';
require_once __DIR__ . '/posts-data.php';
require_once __DIR__ . '/schema.php';
require_once __DIR__ . '/designers.php';
