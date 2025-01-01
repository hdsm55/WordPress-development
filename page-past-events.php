<?php

get_header(); ?>

<div class="page-banner">
  <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg') ?>);"></div>
  <div class="page-banner__content container container--narrow">
    <h1 class="page-banner__title">Past Events</h1>
    <div class="page-banner__intro">
      <p>See Our Past Events.</p>
    </div>
  </div>
</div>

<div class="container container--narrow page-section">
<?php
$today = date('Ymd');
$pastEvents = new WP_Query(array(
  'post_type' => 'event',
  'meta_key' => 'event_date',
  'orderby' => 'meta_value_num',
  'order' => 'ASC',
  'meta_query' => array(
    array(
      'key' => 'event_date',
      'compare' => '<',
      'value' => $today,
      'type' => 'numeric'
    )
  )
));

if ($pastEvents->have_posts()) :
  while ($pastEvents->have_posts()) : $pastEvents->the_post(); 
    $rawEventDate = get_field('event_date');
    if ($rawEventDate) {
      $event_Date = DateTime::createFromFormat('d/m/Y', $rawEventDate);
      if ($event_Date) {
        ?>
        <div class="event-summary">
          <a class="event-summary__date t-center" href="#">
            <span class="event-summary__month"><?php echo $event_Date->format('M'); ?></span>
            <span class="event-summary__day"><?php echo $event_Date->format('d'); ?></span>
          </a>
          <div class="event-summary__content">
            <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
            <p><?php echo wp_trim_words(get_the_content(), 18); ?> <a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a></p>
          </div>
        </div>
        <?php
      } else {
        echo '<p>Invalid event date format.</p>';
      }
    } else {
      echo '<p>No event date available.</p>';
    }
  endwhile;
  echo paginate_links();
else :
  echo '<p>No past events found.</p>';
endif;

// إعادة ضبط بيانات الاستعلام
wp_reset_postdata();
?>
</div>

<?php get_footer(); ?>
