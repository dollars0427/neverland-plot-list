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
  $plots = get_posts(array(
    'category_name' => '剧情',
    'numberposts' => '-1',
  ));

  $sorted_plots = _neverland_plot_list_sort($plots);
  usort($sorted_plots, '_neverland_plot_list_sort_cat');

  foreach($sorted_plots as $version => $cats){
    echo '<h3 class="version-title">' . $version .'剧情</h3>';
    echo '<ul class="version_list">';
    foreach($cats as $cat => $plots){
      echo '<li><h3 class="plot-list-title">' . $cat .'</h3></li>';
      echo '<ul class="plot_list">';
      foreach($plots as $plot){
        echo '<li class="plot">' .
        '<a href="' . $plot->guid . '">' . $plot->post_title . '</a></li>';
      }
      echo '</ul>';
    }
    echo '</ul>';
  }
}

function _neverland_plot_list_sort($plots){
  $sorted_plots = array(
    '2.0' => array(
      '主线' => array(),
      '主线支干' => array(),
      '个人支线' => array(),
      '个人前传' => array(),
    ),
  );
  foreach($plots as $plot){
    $version = get_post_meta($plot->ID, '版本')[0];
    $cat = get_post_meta($plot->ID, '小分类')[0];
    if($version && $cat){
      array_push($sorted_plots[$version][$cat], $plot);
    }
  }
  return $sorted_plots;
}

?>
