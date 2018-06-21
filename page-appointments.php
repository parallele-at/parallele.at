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

$posts = Timber::get_posts( $args );

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

  $week_index = date('w', $i);
  $month_index = date('n', $i);

  $month_name =  $monthnames[$month_index];
  $day_name = $daynames[$week_index];

  if ($current_year != $year) {
    $years[$year] = [];
    $current_year = $year;
  }

  if ($current_month != $month) {
    $years[$year][$month_name] = [];
    $current_month = $month;
  }

  $curr_day = [];
  $curr_day['month_name'] = $month_name;
  $curr_day['day_name'] = $day_name;
  $curr_day['day'] = $day;
  $curr_day['month'] = $month;
  $curr_day['year'] = $year;
  $curr_day['id'] = $week_index;

  foreach ($posts as $post) {
    $post_day = date('d', $post->datetime);
    $post_month = date('m', $post->datetime);
    if ($post_day == $day && $post_month == $month) {
      $time = date('H:i', $post->datetime);
      $curr_day['appointments'] = isset($curr_day['appointments']) ? $curr_day['appointments'] : [];
      $curr_day['appointments'][$time] = $post;
    }
  }

  $years[$year][$month_name][] = $curr_day;
}

$context['days'] = $years;

Timber::render( 'page-appointments.twig', $context );
