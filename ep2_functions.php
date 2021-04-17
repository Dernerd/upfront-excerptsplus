<?php

// Excerpts+ specific functions and some generics
// using a class container for protection from name collisions

  class EPFunctions
  {

    static function get_category_list()
    {
      $categories_select_query = get_categories();
      $categories_select       = array();
      foreach ($categories_select_query as $category) {
        $categories_select[ $category->cat_ID ] = $category->cat_name;
      }

      return $categories_select;
    }

    static function get_tax_list()
    {
      $ep_tax_list   = array();
      $ep_taxonomies = get_taxonomies();
      if (isset($ep_taxonomies[ 'category' ])) {
        unset($ep_taxonomies[ 'category' ]);
      }
      if (isset($ep_taxonomies[ 'post_tag' ])) {
        unset($ep_taxonomies[ 'post_tag' ]);
      }
      if (isset($ep_taxonomies[ 'nav_menu' ])) {
        unset($ep_taxonomies[ 'nav_menu' ]);
      }
      if (isset($ep_taxonomies[ 'link_category' ])) {
        unset($ep_taxonomies[ 'link_category' ]);
      }
      if (isset($ep_taxonomies[ 'post_format' ])) {
        unset($ep_taxonomies[ 'post_format' ]);
      }
      if (isset($ep_taxonomies[ 'slide_set' ])) {
        unset($ep_taxonomies[ 'slide_set' ]);
      }
      if (isset($ep_taxonomies[ 'events_categories' ])) {
        unset($ep_taxonomies[ 'events_categories' ]);
      }
      if (isset($ep_taxonomies[ 'events_tags' ])) {
        unset($ep_taxonomies[ 'events_tags' ]);
      }
      if (isset($ep_taxonomies[ 'events_feeds' ])) {
        unset($ep_taxonomies[ 'events_feeds' ]);
      }
      foreach ($ep_taxonomies as $key => $ep_tax) {
        // get the terms list for each taxonomy and whack it into a sub array of the taxonomy
        $ep_customtaxs = get_terms($key);
        foreach ($ep_customtaxs as $ep_customtax) {
//				var_dump($ep_taxonomies[$key],$key,$ep_tax,$ep_customtax->term_id,$ep_customtax->name,'<br/>');
          $ep_tax_list[ ($key . ':' . $ep_customtax->slug) ] = $ep_tax . ' : ' . $ep_customtax->name;
        }
      }

      return $ep_tax_list;
    }

    static function get_tag_list()
    {
      $ep_tags = get_terms('post_tag');
      //	var_dump($ep_tags);
      foreach ($ep_tags as $ep_tag) {
        $ep_tag_list[ $ep_tag->term_id ] = $ep_tag->name;
      }

      return $ep_tag_list;
    }

    static function getlinks($str)
    {
      preg_match_all('/(href|src)\=(\"|\')[^\"\'\>]+/i', $str, $media);
      unset($str);
      $str = preg_replace('/(href|src)(\"|\'|\=\"|\=\')(.*)/i', "$3", $media[ 0 ]);

      return $str;
    }

    static function php_debug($string)
    {
      if (class_exists('ChromePHP') && $_SERVER[ 'QUERY_STRING' ] == 'pzepdebug' . date('d')) {
        $pznow = microtime(true);
        $btr   = debug_backtrace();
        $line  = $btr[ 0 ][ 'line' ];
        $file  = basename($btr[ 0 ][ 'file' ]);
        ChromePhp::log($file . ':' . $line . ' ' . $string . ': Time since reload: ' . round(($pznow - esc_attr($_SERVER[ 'REQUEST_TIME' ])), 2) . 's');
      }
    }

    static function debug($value = '')
    {
      $btr  = debug_backtrace();
      $line = $btr[ 0 ][ 'line' ];
      $file = basename($btr[ 0 ][ 'file' ]);
      print"<pre>$file:$line</pre>\n";
      if (is_array($value)) {
        print"<pre>";
        print_r($value);
        print"</pre>\n";
      } elseif (is_object($value)) {
        var_dump($value);
      } else {
        print("<p>&gt;${value}&lt;</p>");
      }
    }

    /**
     * Remove HTML tags, including invisible text such as style and
     * script code, and embedded objects.  Add line breaks around
     * block-level tags to prevent word joining after tag removal.
     */
    static function strip_html_tags($text)
    {
      $text = preg_replace(
          array(
            // Remove invisible content
            '@<head[^>]*?>.*?</head>@siu',
            '@<style[^>]*?>.*?</style>@siu',
            '@<script[^>]*?.*?</script>@siu',
            '@<object[^>]*?.*?</object>@siu',
            '@<embed[^>]*?.*?</embed>@siu',
            '@<applet[^>]*?.*?</applet>@siu',
            '@<noframes[^>]*?.*?</noframes>@siu',
            '@<noscript[^>]*?.*?</noscript>@siu',
            '@<noembed[^>]*?.*?</noembed>@siu',
            // Add line breaks before and after blocks
            '@</?((address)|(blockquote)|(center)|(del))@iu',
            '@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
            '@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
            '@</?((table)|(th)|(td)|(caption))@iu',
            '@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
            '@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
            '@</?((frameset)|(frame)|(iframe))@iu',
          ), array(
              ' ',
              ' ',
              ' ',
              ' ',
              ' ',
              ' ',
              ' ',
              ' ',
              ' ',
              "\n\$0",
              "\n\$0",
              "\n\$0",
              "\n\$0",
              "\n\$0",
              "\n\$0",
              "\n\$0",
              "\n\$0",
          ), $text);

      return strip_tags($text);
    }

    static function HexToRGB($hex)
    {
      $hex   = preg_replace("/#/", "", $hex);
      $color = array();
      if (strlen($hex) == 3) {
        $color[ 'r' ] = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
        $color[ 'g' ] = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
        $color[ 'b' ] = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
      } else {
        if (strlen($hex) == 6) {
          $color[ 'r' ] = hexdec(substr($hex, 0, 2));
          $color[ 'g' ] = hexdec(substr($hex, 2, 2));
          $color[ 'b' ] = hexdec(substr($hex, 4, 2));
        }
      }

      return $color;
    }

    // Pinched this from Clay dude
    static function meta_php($ep_meta)
    {
      $content = stripslashes(base64_decode($ep_meta));

      //Remove bad MailChimp code.
      $content = str_replace('<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script>', '', $ep_meta);

      return upfront_parse_php(do_shortcode($ep_meta));
    }

    static function parse_meta($block, $settings, $meta)
    {
      global $post, $authordata;

      $date             = '';
      $time             = '';
      $comments         = '';
      $comments_no_link = '';
      $respond          = '';
      $author           = '';
      $author_no_link   = '';
      $categories       = '';
      $tags             = '';
      $edit             = '';
      $permalink        = '';
      $title            = '';
      $quickread        = '';


      if (strpos($meta, '%date%') !== false) {
        $postdate = ($settings[ 'date-format' ]) ? get_the_time($settings[ 'date-format' ]) : get_the_date();
        $date     = '<span class="entry-date published">' . $postdate . '</span>';
      }

      if (strpos($meta, '%time%') !== false) {
        $posttime = ($settings[ 'time-format' ]) ? get_the_time($settings[ 'time-format' ]) : get_the_time();
        $time     = '<span class="entry-date published">' . $posttime . '</span>';
      }

      if (strpos($meta, '%comments%') !== false || strpos($meta, '%comments_no_link%') !== false) {
        if ((int)get_comments_number($post->ID) === 0) {
          $comments_format = stripslashes(UpFrontBlockAPI::get_setting($block, 'comment-format-0', $settings[ 'ep-text-comments-nil' ]));
        } elseif ((int)get_comments_number($post->ID) == 1) {
          $comments_format = stripslashes(UpFrontBlockAPI::get_setting($block, 'comment-format-1', $settings[ 'ep-text-comments-single' ]));
        } elseif ((int)get_comments_number($post->ID) > 1) {
          $comments_format = stripslashes(UpFrontBlockAPI::get_setting($block, 'comment-format', $settings[ 'ep-text-comments-multiple' ]));
        }
        $comments = str_replace('%num%', get_comments_number($post->ID), $comments_format);

        if (strpos($meta, '%comments%') !== false) {
          $comments = '<a href="' . get_comments_link() . '" title="' . get_the_title() . ' Comments" class="entry-comments">' . $comments . '</a>';
        }

        if (strpos($meta, '%comments_no_link%') !== false) {
          $comments_no_link = $comments;
        }
      }

      if (strpos($meta, '%respond%') !== false) {
        $respond_format = stripslashes(UpFrontBlockAPI::get_setting($block, 'respond-format', $settings[ 'ep-text-comments-new' ]));
        $respond        = '<a href="' . get_permalink() . '#respond" title="Respond to ' . get_the_title() . '" class="entry-respond">' . $respond_format . '</a>';
      }

      if (strpos($meta, '%author%') !== false || strpos($meta, '%author_no_link%') !== false) {
        $author_avatar = ($settings[ 'show-avatar' ] == true && $settings[ 'image-location' ] != 'behind') ? get_avatar(get_the_author_meta('ID'), $settings[ 'avatar-size' ]) : null;
        if (strpos($meta, '%author%') !== false) {
          $author = '<a class="author-link fn nickname url" href="' . get_author_posts_url($authordata->ID) . '" title="View all posts by ' . $authordata->display_name . '">' . $author_avatar . $authordata->display_name . '</a>';
        }
        if (strpos($meta, '%author_no_link%') !== false) {
          $author_no_link = $author_avatar . $authordata->display_name;
        }
      }

      if (strpos($meta, '%categories%') !== false) {
        $categories = get_the_category_list(', ');
      }

      if (strpos($meta, '%tags%') !== false) {
        $tags = (get_the_tags() != null) ? get_the_tag_list('<span class="tag-links"><span>Tags:</span> ', ', ', '</span>') : '';
      }

      if (strpos($meta, '%edit%') !== false) {
        $edit_format = UpFrontBlockAPI::get_setting($block, 'edit-link-format', ' | %edit_link%');
        $edit_link   = '<span class="edit"><a class="post-edit-link" href="' . get_edit_post_link($post->ID) . '">Edit</a></span>';
        $edit        = current_user_can('edit_post', $post->ID) ? str_replace('%edit_link%', $edit_link, $edit_format) : null;
      }
      if (strpos($meta, '%permalink%') !== false) {
        $permalink = get_permalink();
      }
      if (strpos($meta, '%title%') !== false) {
        $title = get_the_title();
      }
      if (strpos($meta, '%quickread%') !== false) {
        $quickread_text = (!$settings[ 'ep-quick-read-label' ]) ? 'Quick read' : $settings[ 'ep-quick-read-label' ];
        $quickread      = '<a href="' . get_permalink() . '" class="ep_quickread openquickread" alt="' . get_the_title() . '" title="Open &quot;' . get_the_title() . '&quot; in a popup">' . $quickread_text . '</a>';
      }


      // $quickread_text = (!$leaf['options']['ep-quickread-text']) ? 'Quick read' : $leaf['options']['ep-quickread-text'];
      // $quickread = '<a href="'.get_permalink().'" class="ep_quickread openquickread" alt="'.get_the_title().'" title="Open &quot;'.get_the_title().'&quot; in a popup">'.$quickread_text.'</a>';
//var_dump($quickread)
      $meta = str_replace(array(
                              '%date%',
                              '%time%',
                              '%comments%',
                              '%comments_no_link%',
                              '%respond%',
                              '%author%',
                              '%author_no_link%',
                              '%categories%',
                              '%tags%',
                              '%edit%',
                              '%permalink%',
                              '%title%',
                              '%quickread%'
                          ), array(
                              $date,
                              $time,
                              $comments,
                              $comments_no_link,
                              $respond,
                              $author,
                              $author_no_link,
                              $categories,
                              $tags,
                              $edit,
                              $permalink,
                              $title,
                              $quickread
                          ), $meta);

      // And now to process any custom fields...
      // Assume anything left with a % is a custom field
      // Loop until none left
      $ep_cf_names = get_post_custom_keys();
      if (isset($ep_cf_names)) {
        foreach ($ep_cf_names as $ep_cf_name) {
          if (substr($ep_cf_name, 0, 1) != '_') {
            $ep_cf_name = '%' . $ep_cf_name . '%';
            // This line sometimes throws a Catchable fatal error: Object of class stdClass could not be converted to string
            // Probably when invalid parameter or code
            $ep_cf_data = ep_get_custom_field($ep_cf_name);
            if (!is_array($ep_cf_data)) {
              $meta = str_replace($ep_cf_name, $ep_cf_data, $meta);
            }
          }
        }
      }

      return apply_filters('upfront_meta', $meta);
    }

  }

// End of class

  function ep_get_custom_field($ep_cf_name)
  {
    $return = null;
    // Strip any %s
    $ep_cf_name = str_replace('%', '', $ep_cf_name);
    $return     = get_post_meta(get_the_ID(), $ep_cf_name, true);

    return $return;
  }

// Functions ourside of the class
  function ep_clear_post_image_cache()
  {
    // Clears cache of specified post's images
    global $post_ID;
    ep_clear_image_cache(EP_CACHE_PATH, 'post-' . $post_ID);
  }

  function ep_clear_image_cache($path = false, $match = false)
  {
    $path        = (!$path) ? EP_CACHE_PATH : $path;
    $match       = (!$match) ? 'eplus' : $match;
    $cache_files = scandir($path);
    foreach ($cache_files as $cache_file) {
      if (strpos($cache_file, $match) !== false) {
        unlink($path . '/' . $cache_file);
      }
    }
  }

  function ep_quickread_code()
  {

    echo '
	<div id="quickread" class="block-type-content block-content hentry" style="display:none;">
	<h2 class="qr-title entry-title"></h2>
	<div class="qr-content"></div>
	<div class="qr-meta"></div>
	<div class="qr-code"></div>
	</div>';
  }

  function ep_extra_ve_css()
  {

    wp_enqueue_style('UpFront-ep-ve-css', EP_BLOCK_URL . '/css/ep2_visual_editor.css');
  }

  function ep_add_hook($code)
  {
    if (!$code) {
      return false;
    }
    $lfunction = function(){
      upfront_parse_php($code);
    };
    $lfunction();
  }

  function ep_set_date_range($where)
  {
    global $ep_where_vars, $post, $wpdb;
    // Had to add  a day (86400) as <= => wasn't workign for one day, needed >= < instead

    $ep_timezone = get_option('timezone_string');
//  var_dump($ep_timezone);
//  how do we tell the user the timezone is empty??? Only works if a valid timezone name is used, not offset
    if (!empty($ep_where_vars[ 'use_timezone' ]) & !empty($ep_timezone)) {
      $ep_last_date = new DateTime($ep_where_vars[ 'end_date' ], new DateTimeZone($ep_timezone));
    } else {
      $ep_last_date = new DateTime($ep_where_vars[ 'end_date' ]);
    }

    // Need to subtract one from the days count to ensure it shows as expected. Otherwise, 1 day shows yesterday and today, which is unexpected. Could prob fix this with times...
    $ep_days       = ($ep_where_vars[ 'days' ] == 0) ? $ep_where_vars[ 'days' ] : ($ep_where_vars[ 'days' ] - 1);
    $ep_first_date = $ep_last_date;

    // Need to double check this timezone logic works or is necessary
    if (!empty($ep_where_vars[ 'use_timezone' ])) {
      $where .= " AND ({$wpdb->posts}.post_date_gmt >= '" . $ep_first_date->sub(new DateInterval('P' . $ep_days . 'D'))->format('Y-m-d') . "'" . " AND {$wpdb->posts}.post_date_gmt < '" . $ep_last_date->add(new DateInterval('P1D'))->format('Y-m-d') . "')";
    } else {
      $where .= " AND ({$wpdb->posts}.post_date >= '" . $ep_first_date->sub(new DateInterval('P' . $ep_days . 'D'))->format('Y-m-d') . "'" . " AND {$wpdb->posts}.post_date < '" . $ep_last_date->add(new DateInterval('P1D'))->format('Y-m-d') . "')";
    }

//	var_dump($where);
    return $where;
  }

  function ep_custom_where($where)
  {
    global $ep_where_vars, $wpdb;
    if (!empty($ep_where_vars[ 'custom' ])) {
      $where .= ' AND ' . $ep_where_vars[ 'custom' ];
    }

    return $where;
  }

  function ep_edit_posts_join($join_statement)
  {
    global $wpdb;
    $join_statement .= "  INNER JOIN {$wpdb->postmeta} ON ({$wpdb->posts}.ID = {$wpdb->postmeta}.post_id) ";

    return $join_statement;
  }

  function ep_edit_posts_orderby($orderby_statement)
  {
    global $ep_custom_sort_vals, $wpdb;
    $orderby_statement = " {$wpdb->postmeta}.meta_value " . $ep_custom_sort_vals[ 'order' ] . " ";

    return $orderby_statement;
  }

  function ep_post_meta_join($join)
  {
    global $wpdb;
    $join .= " INNER JOIN {$wpdb->postmeta} ON ({$wpdb->posts}.ID = {$wpdb->postmeta}.post_id)";

    return $join;
  }

  function ep_options_update($block, $all_post_types_numeric)
  {
// UGH!! THIS DIDN'T WORK _ and maynot have been necessary	
    return;
// in the future, run this in wp_activate
    $ep_current_post_types = $block[ 'settings' ][ 'post-type' ];
    pzdebug($ep_current_post_types);
    var_dump($ep_current_post_types[ 0 ], isset($ep_current_post_types[ 0 ]));
    $needs_upgrade = isset($ep_current_post_types[ 0 ]);
    // Post type selections
    if ($needs_upgrade) {
      foreach ($ep_current_post_types as $key => $value) {
        $ep_updated_array[ $all_post_types_numeric[ $value ] ] = $all_post_types_numeric[ $value ];
      }
      $block[ 'settings' ][ 'post-type' ] = $ep_updated_array;
      UpFrontBlocksData::update_block($block[ 'layout' ], $block[ 'id' ], $block);
    }
  }

  function ep_build_custom_fields($settings, $group)
  {
    $ep_custom = '';
    if (isset($settings[ 'ep-custom-fields-group' . $group . '-repeater' ])) {
      foreach ($settings[ 'ep-custom-fields-group' . $group . '-repeater' ] as $settings_cf) {
        $ep_custom_fields_name_val = get_post_meta(get_the_id(), $settings_cf[ 'ep-custom-fields-name' ], true);
        if (!empty($ep_custom_fields_name_val)) {
          if ($settings_cf[ 'ep-custom-fields-wrapper' ] != 'none') {
            $ep_custom .= '<' . $settings_cf[ 'ep-custom-fields-wrapper' ] . ' class="ep_custom_field ep_custom_field_' . ($settings_cf[ 'ep-custom-fields-name' ]) . '">';
          }

          if (!empty($settings_cf[ 'ep-custom-fields-prefix-text' ])) {
            $ep_custom .= '<span class="ep_custom_field_prefix_text">' . ($settings_cf[ 'ep-custom-fields-prefix-text' ]) . '</span>';
          }

          if (!empty($settings_cf[ 'ep-custom-fields-prefix-image' ])) {
            $ep_custom .= '<img class="ep_custom_field_prefix_image" src="' . esc_url($settings_cf[ 'ep-custom-fields-prefix-image' ]) . '"/>';
          }

          if ($settings_cf[ 'ep-custom-fields-name-url' ] != 'none') {
            $ep_custom_fields_name_url = get_post_meta(get_the_id(), $settings_cf[ 'ep-custom-fields-name-url' ], true);
            if (strpos($ep_custom_fields_name_url, '@') > 0 && strpos($ep_custom_fields_name_url, 'mailto:') === false) {
              $ep_custom_fields_name_url = 'mailto:' . $ep_custom_fields_name_url;
            }
            $ep_custom .= '<a href="' . ($ep_custom_fields_name_url) . '">' . ($ep_custom_fields_name_val) . '</a>';
          } else {
            // Add the content
            if (!empty($settings_cf[ 'ep-custom-fields-is-image' ]) && $settings_cf[ 'ep-custom-fields-is-image' ] !='false') {
              $ep_custom .= '<img src="' . $ep_custom_fields_name_val . '" class="ep-cf-image"/>';
            } elseif (!empty($settings_cf[ 'ep-custom-fields-is-date' ]) && $settings_cf[ 'ep-custom-fields-is-date' ] !='false') {
              $ep_custom .= date_i18n(get_option('date_format'), str_replace(',', ' ', strtotime($ep_custom_fields_name_val)));
            } else {
              $ep_custom .= ($ep_custom_fields_name_val);
            }
          }
          if (!empty($settings_cf[ 'ep-custom-fields-suffix-text' ])) {
            $ep_custom .= '<span class="ep_custom_field_suffix_text">' . ($settings_cf[ 'ep-custom-fields-suffix-text' ]) . '</span>';
          }

          if (!empty($settings_cf[ 'ep-custom-fields-suffix-image' ])) {
            $ep_custom .= '<img class="ep_custom_field_suffix_image" src="' . esc_url($settings_cf[ 'ep-custom-fields-suffix-image' ]) . '"/>';
          }

          if ($settings_cf[ 'ep-custom-fields-name' ] != 'none') {
            $ep_custom .= '</' . ($settings_cf[ 'ep-custom-fields-wrapper' ]) . '>';
          }
        }
      }
    }

    return wpautop($ep_custom);
  }

  function ep_display_full_content($days = 7, $paras = 6)
  {
// this is the function begun for chroni. might be useful reference one day - and good backup of original!

   // var_dump($days, $paras, get_the_date());
    $post_timestamp = strtotime(get_the_date());
    $now_timestamp  = current_time('timestamp');

    if (($now_timestamp - $post_timestamp) / 60 / 60 / 24 > $days) {
      $content_to_show = get_the_content();
    } else {
      $the_content_array = explode("\n", strip_tags(get_the_content()));
      $content_to_show   = '';
      $i                 = 1;
      foreach ($the_content_array as $content_line) {
        $stripped = trim($content_line);
        if (empty($stripped)) {
          $content_to_show .= " \n";
        } else {
          $content_to_show .= $content_line;
          //var_dump($i);
          if (++$i > $paras) {
            break;
          }
        }
      }
    }
    // Here's the content, now gotta display the image.
    echo '<div class="hentry excerpt-entry entry-content ">
	<div class="excerpt-content">';
    echo apply_filters('the_content', $content_to_show);
    echo '</div></div>';

  }

  /**
   * Adds a simple WordPress pointer to Settings menu
   */

  function ep_enqueue_pointer_script_style($hook_suffix)
  {

    // Assume pointer shouldn't be shown
    $enqueue_pointer_script_style = false;

    // Get array list of dismissed pointers for current user and convert it to array
    $dismissed_pointers = explode(',', get_user_meta(get_current_user_id(), 'dismissed_wp_pointers', true));

    // Check if our pointer is not among dismissed ones
    if (!in_array('ep_settings_pointer', $dismissed_pointers)) {
      $enqueue_pointer_script_style = true;

      // Add footer scripts using callback function
      add_action('admin_print_footer_scripts', 'ep_pointer_print_scripts');
    }

    // Enqueue pointer CSS and JS files, if needed
    if ($enqueue_pointer_script_style) {
      wp_enqueue_style('wp-pointer');
      wp_enqueue_script('wp-pointer');
    }

  }

//add_action( 'admin_enqueue_scripts', 'ep_enqueue_pointer_script_style' );

  function ep_pointer_print_scripts()
  {

    $pointer_content = "<h3>PizazzWP Support Menu</h3>";
    $pointer_content .= "<p>The PizazzWP menu provides access to other feature. blahdy blah.</p>";
    ?>

    <script type="text/javascript">
      //<![CDATA[
      jQuery( document ).ready( function ( $ )
      {
        $( '#toplevel_page_pizazzwp' ).pointer( {
          content: '<?php echo $pointer_content; ?>',
          position: {
            edge: 'left', // arrow direction
            align: 'center' // vertical alignment
          },
          pointerWidth: 350,
          close: function ()
          {
            $.post( ajaxurl, {
              pointer: 'ep_settings_pointer', // pointer ID
              action: 'dismiss-wp-pointer'
            } );
          }
        } ).pointer( 'open' );
      } );
      //]]>
    </script>

  <?php
  }


  function ep_is_scheduled() {
    // must be used in loop
    return (get_post_status()==='future');
  }