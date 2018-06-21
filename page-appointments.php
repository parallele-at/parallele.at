<?php
$context = Timber::get_context();

$post = new TimberPost();
$context['post'] = $post;

$args = array(
  // Get post type project
  'post_type' => 'appointment',
  // Get all posts
  'posts_per_page' => -1,
  // Order by post date
  'orderby' => array(
    'date' => 'ASC',
  ),
);

$context['posts'] = Timber::get_posts( $args );

$today = date('Y-m-d');
$start_time = strtotime($today);

$end_time = strtotime("+1 months", $start_time);

$daynames = [
  'Sonntag',
  'Montag',
  'Dienstag',
  'Mittwoch',
  'Donnerstag',
  'Freitag',
  'Samstag',
];

$monthnames = [
  '',
  'Januar',
  'Februar',
  'März',
  'April',
  'Mai',
  'Juni',
  'Juli',
  'August',
  'September',
  'Oktober',
  'November',
  'Dezember',
];

$years = [];
$year_months = [];
$current_year = -1;
$months = [];
$current_month = -1;
$month_days = [];
$days = [];

for($i = $start_time; $i < $end_time; $i += 86400) {
  $day = date('d', $i);
  $month = date('m', $i);
  $year = date('Y', $i);
  $month_name =  $monthnames[date('n', $i)];
  $day_name = $daynames[date('w', $i)];

  if ($current_year != $year) {
    $years[$year] = [];
    $current_year = $year;
  }

  if ($current_month != $month) {
    $current_month = $month;
    $years[$year][$month_name] = [];
  }

  $curr_day = [];
  $curr_day['month_name'] = $month_name;
  $curr_day['day_name'] = $day_name;
  $curr_day['day'] = $day;
  $curr_day['month'] = $month;

  $years[$year][$month_name][] = $curr_day;
}

$context['days'] = $years;

Timber::render( 'page-appointments.twig', $context );
?>
