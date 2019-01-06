<?php
/*
Plugin Name: Neverland Plot List
Plugin URI:
Description: 顯示Neverland裡所有主線劇情及支線劇情
Author: Mr.Twister(Sardo)
Author URI: https://sardo.work
Version: 0.0.1
*/

add_shortcode('add_plot_list', 'neverland_plot_list_load');

function neverland_plot_list_load(){
  $main_plots = get_posts(array(
    'category_name' => '主线剧情',
    'numberposts' => '-1',
  ));

  $sub_plots = get_posts(array(
    'category_name' => '剧情',
    'category_not_in' => '主线剧情',
    'numberposts' => '-1',
  ));

  echo '<hr />';
  echo '<h2 class="plot-list-title">主线剧情</h2>';
  $sorted_main_plots = _neverland_plot_list_sort($main_plots);
  foreach($sorted_main_plots as $area => $main_plots){
    echo '<h3 class="area">' . $area . '</h3>';
    echo '<ul class="plot_list">';
    foreach($main_plots as $main_plot){
      echo '<li class="plot">' .
      '<a href="' . $main_plot->guid . '">' . $main_plot->post_title . '</a></li>';
    }
    echo '</ul>';
  }

  echo '<hr />';

  echo '<h2 class="plot-list-title">支线剧情</h2>';
  echo '<ul class="plot_list">';
  foreach($sub_plots as $sub_plot){
    echo '<li class="plot">
    <a href="' . $sub_plot->guid . '">' . $sub_plot->post_title . '</a></li>';
  }
  echo '</ul>';
}

function _neverland_plot_list_sort($main_plots){
  $sorted_main_plots = array();
  foreach($main_plots as $main_plot){
    $area = get_post_meta($main_plot->ID, '地区')[0];
    if(!isset($sorted_main_plots[$area])){
      $sorted_main_plots[$area] = array($main_plot);
    }else{
      array_push($sorted_main_plots[$area], $main_plot);
    }
  }
  return $sorted_main_plots;
}
?>
