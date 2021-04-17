<?php

  class UpFrontExcerptsPBlock extends UpFrontBlockAPI
  {

    public $id = 'excerpts-plus';
    public $name = 'Excerpts+ Block';
    public $options_class = 'UpFrontExcerptsPBlockOptions';

    // ExcerptsPlus vars
    public $is_eplus = true;
    public $skip_offset = 0;

    // Use for top loading stuff like scripts,CSS, JS etc.
    static function enqueue_action($block_id, $block, $original_block = null)
    {
      EPFunctions::php_debug('Block: ' . $block_id . ' : Enqueue Action');
      if (method_exists('UpFrontBlocksData', 'get_legacy_id')) {
        $block[ 'id' ] = UpFrontBlocksData::get_legacy_id($block);
      }

      $settings = UpFrontExcerptsPBlockOptions::get_settings($block);

      $pz_uses_quickread              = false;
      $settings[ 'meta' ]             = (!isset($settings[ 'meta' ]) ? '' : $settings[ 'meta' ]);
      $settings[ 'meta-right' ]       = (!isset($settings[ 'meta-right' ]) ? '' : $settings[ 'meta-right' ]);
      $settings[ 'meta-below' ]       = (!isset($settings[ 'meta-below' ]) ? '' : $settings[ 'meta-below' ]);
      $settings[ 'meta-below-right' ] = (!isset($settings[ 'meta-below-right' ]) ? '' : $settings[ 'meta-below-right' ]);
      $settings[ 'meta-three-left' ]  = (!isset($settings[ 'meta-three-left' ]) ? '' : $settings[ 'meta-three-left' ]);
      $settings[ 'meta-three-right' ] = (!isset($settings[ 'meta-three-right' ]) ? '' : $settings[ 'meta-three-right' ]);

      $pz_meta1 = (strpos(($settings[ 'meta' ] . $settings[ 'meta-right' ]), 'quickread') > 0);
      $pz_meta2 = (strpos(($settings[ 'meta-below' ] . $settings[ 'meta-below-right' ]), 'quickread') > 0);
      $pz_meta3 = (strpos(($settings[ 'meta-three-left' ] . $settings[ 'meta-three-right' ]), 'quickread') > 0);

      $pz_cellrows = array('ep-cellrow1', 'ep-cellrow2', 'ep-cellrow3', 'ep-cellrow4', 'ep-cellrow5', 'ep-cell-footer');
      foreach ($pz_cellrows as $pz_cellrow) {
        if (isset($settings[ $pz_cellrow ]) && !$pz_uses_quickread && strpos($settings[ $pz_cellrow ], 'meta') > 0) {

          switch ($settings[ $pz_cellrow ]) {
            case'%meta1%' :
              if ($pz_meta1) {
                $pz_uses_quickread = true;
              }
              break;
            case'%meta2%' :
              if ($pz_meta2) {
                $pz_uses_quickread = true;
              }
              break;
            case'%meta3%' :
              if ($pz_meta3) {
                $pz_uses_quickread = true;
              }
              break;
          }
        }
        if ($pz_uses_quickread) {
          break;
        }
      }

      /* Quick Read scripts */
      if ($pz_uses_quickread || $pz_meta1 || $pz_meta2 || $pz_meta3) {
        if (!is_admin()) {
          wp_enqueue_script('jquery-ui-core', false, array('jquery'), '', true);
          wp_enqueue_script('jquery-ui-dialog', false, array('jquery'), '', true);
          wp_enqueue_style('jquery-ui-custom-css-ep', EP_BLOCK_URL . 'css/jquery-ui.custom.css');
          wp_enqueue_script('jquery-quickread', EP_BLOCK_URL . 'js/quickread.js');          
        }
      }

      /* Ellipses script */
      if (isset($settings [ 'ep_use_dotdotdot' ]) && $settings[ 'ep_use_dotdotdot' ]) {
        wp_enqueue_script('jquery-dotdotdot', EP_BLOCK_URL . 'js/jquery.dotdotdot-1.5.6.js', array('jquery'), '', true);
      }

      /* Slide scripts */
      if (isset($settings[ 'ep-slide-content' ]) && $settings[ 'ep-slide-content' ]) {
        wp_enqueue_script('ep-slide-content', EP_BLOCK_URL . 'js/slide-content.js', array('jquery'), '', true);
      }

      /* Flowtype scripts */
//		wp_enqueue_script('jquery-flowtype', EP_BLOCK_URL . '/js/FlowType.JS/flowtype.js', array('jquery'), '', true);

      /* EPlus scripts */
//		wp_enqueue_script('jquery-pzep', EP_BLOCK_URL . '/js/pzep.js', array('jquery'), '', true);

      /* Cycle scripts */
      if (isset($settings[ 'use-slider' ]) && $settings[ 'use-slider' ]) {
        wp_deregister_script('jquery_cycle1', false, array('jquery'));
        wp_enqueue_script('jquery-cycle1', EP_BLOCK_URL . 'js/jquery.cycle/jquery.cycle.all.mod.js', array('jquery'), '', true);
      }

      wp_enqueue_style('UpFront-excerpts-plus-css', EP_BLOCK_URL . 'css/excerpts_plus2.css');
      //jQuery Tools
      //  wp_enqueue_script('jquerytools-js', EP_BLOCK_URL.'/js/jquery.tools.mod.min.js', array('jquery'));
    }

    static function init_action($block_id, $block, $original_block = null)
    {
      EPFunctions::php_debug('Block: ' . $block_id . ' : Init Action');
      if (method_exists('UpFrontBlocksData', 'get_legacy_id')) {
        $block[ 'id' ] = UpFrontBlocksData::get_legacy_id($block);
      }
      // If WPML in use, load its API
      if (defined('ICL_PLUGIN_PATH')) {
        require_once ICL_PLUGIN_PATH . '/lib/icl_api.php';
      }
      add_action('upfront_visual_editor_styles', 'ep_extra_ve_css');

      // Intialize hooks
      add_action('ep_top_of_block', 'ep_add_hook', 10, 1);
      add_action('ep_before_loop_start', 'ep_add_hook', 10, 1);
      add_action('ep_before_title', 'ep_add_hook', 10, 1);
      add_action('ep_after_title', 'ep_add_hook', 10, 1);
      add_action('ep_before_meta1', 'ep_add_hook', 10, 1);
      add_action('ep_after_meta1', 'ep_add_hook', 10, 1);
      add_action('ep_before_meta2', 'ep_add_hook', 10, 1);
      add_action('ep_after_meta2', 'ep_add_hook', 10, 1);
      add_action('ep_before_meta3', 'ep_add_hook', 10, 1);
      add_action('ep_after_meta3', 'ep_add_hook', 10, 1);
      add_action('ep_before_image', 'ep_add_hook', 10, 1);
      add_action('ep_after_image', 'ep_add_hook', 10, 1);
      add_action('ep_before_content', 'ep_add_hook', 10, 1);
      add_action('ep_after_content', 'ep_add_hook', 10, 1);
      add_action('ep_before_cellrow1', 'ep_add_hook', 10, 1);
      add_action('ep_after_cellrow1', 'ep_add_hook', 10, 1);
      add_action('ep_after_cellrow2', 'ep_add_hook', 10, 1);
      add_action('ep_after_cellrow3', 'ep_add_hook', 10, 1);
      add_action('ep_after_cellrow4', 'ep_add_hook', 10, 1);
      add_action('ep_after_cellrow5', 'ep_add_hook', 10, 1);
      add_action('ep_after_cell-footer', 'ep_add_hook', 10, 1);
      add_action('ep_bottom_of_block', 'ep_add_hook', 10, 1);
    }

    static function js_content($block_id, $block, $original_block = null)
    {
      EPFunctions::php_debug('Block: ' . $block_id . ' : JS Content');
      if (method_exists('UpFrontBlocksData', 'get_legacy_id')) {
        $block[ 'id' ] = UpFrontBlocksData::get_legacy_id($block);
      }

      $return   = '';
      $settings = UpFrontExcerptsPBlockOptions::get_settings($block);
      if ($settings[ 'ep_use_dotdotdot' ]) {
        if ($settings[ 'excerpt-or-content' ] == 'excerpt') {
          if ($settings[ 'trunc-char' ] == 'arrows') {
            $truncchar = 'String.fromCharCode(0187)';
          } elseif ($settings[ 'trunc-char' ] == 'ellipses' || !$settings[ 'trunc-char' ]) {
            $truncchar = 'String.fromCharCode(8230)';
          } else {
            $truncchar = '';
          }
        }

        $return .= "
				jQuery(document).ready(function() {
				var tc = " . $truncchar . ";
					jQuery('#block-" . $block[ 'id' ] . " .excerpt-content').dotdotdot({ellipsis: tc ,after:'a.excerpt-read-more'});
				});
				";
      }
      if (!($settings[ 'use-slider' ])) {

      } else {
        $transition_time = $settings[ 'transition-time' ] * 1000;
        $slide_time      = $settings[ 'slide-time' ] * 1000;

        $pager_type  = 'pagerAnchorBuilder: null,';
        $show_pager1 = ".after('<div class=\"slider-nav-" . $block[ 'id' ] . " slider-" . $settings[ 'pager-type' ] . " slider-nav-defaults slider-bg" . $settings[ 'background-type' ] . "\">')";
        $show_pager2 = "pager: '.slider-nav-" . $block[ 'id' ] . "',";
        if ($settings[ 'pager-type' ] == 'bullets') {
          $pager_type = "pagerAnchorBuilder: function(idx, slide) { return '<a href=\"#\">&bull;</a>';},";
        } else {
          if ($settings[ 'pager-type' ] == 'none') {
            $show_pager1 = null;
            $show_pager2 = "page: null,";
          }
        }

        $slider_height = ($settings[ 'image-location' ] == 'behind') ? $settings[ 'image-height' ] : UpFrontBlocksData::get_block_height($block[ 'id' ]);


        $return .= "
		jQuery(document).ready(function() {
			if(typeof jQuery != 'function' || typeof jQuery().cycle1 != 'function') return false;
		    jQuery('#slider-" . $block[ 'id' ] . "')" . $show_pager1 . ".cycle1({
				timeout: " . $slide_time . ",
				pause: 0, // tried with it on but had jumpy problems
				fastOnEvent: true,
				height: " . $slider_height . ",
				speed: " . $transition_time . ","
            . $show_pager2
            . $pager_type . "

				fx: '" . $settings[ 'transition-type' ] . "' // choose your transition type, ex: fade, scrollUp, shuffle, etc...

			});
		});
		";
      }

      return $return;
    }

    function setup_elements()
    {
      EPFunctions::php_debug('Setup Elements');

//		$this->register_block_element( array(
//				'id' => 'excerpts-plus-excerpt',
//				'name' => 'Cells Wrapper',
//				'selector' => '.excerpts-plus-excerpt',
//				'properties' => array( 'background', 'borders', 'corners', 'box-shadow','padding' ),
//				'inherit-location' => 'text'
//			) );

      $this->register_block_element(
          array(
              'id'               => 'excerpts-plus-excerpt',
              'name'             => 'Cells Wrapper',
              'selector'         => '.excerpts-plus-excerpt',
              'properties'       => array('background', 'borders', 'corners', 'box-shadow', 'padding', 'margins'),
              'inherit-location' => 'text'
          ));

      $this->register_block_element(
          array(
              'id'               => 'ep-cell',
              'name'             => 'Cell',
              'selector'         => '.ep-cell',
              'properties'       => array('background', 'borders', 'corners', 'box-shadow', 'padding', 'margins'),
              'states'           => array(
                  'Hover' => '.ep-cell:hover'
              ),
              'inherit-location' => 'text'
          ));

      $this->register_block_element(
          array(
              'id'               => 'ep-cell-footer',
              'name'             => 'Cell footer',
              'selector'         => '.ep-cell-footer',
              'properties'       => array('background', 'borders', 'corners', 'box-shadow', 'padding', 'margins'),
              'states'           => array(
                  'Hover' => '.ep-cell:hover'
              ),
              'inherit-location' => 'text'
          ));
      $this->register_block_element(
          array(
              'id'               => 'ep-block-title',
              'name'             => 'Block Title (E+)',
              'selector'         => '.ep-block-title',
              'properties'       => array('fonts',
                                          'text-shadow',
                                          'background',
                                          'borders',
                                          'corners',
                                          'box-shadow',
                                          'padding',
                                          'margins'),
              'states'           => array(
                  'Hover' => '.ep-block-title:hover'
              ),
              'inherit-location' => 'text'
          ));
      $this->register_block_element(
          array(
              'id'               => 'ep-block-title-link',
              'name'             => 'Block Title Hyperlink (E+)',
              'selector'         => '.ep-block-title a',
              'properties'       => array('fonts', 'text-shadow', 'background', 'padding', 'margins'),
              'states'           => array(
                  'Hover'   => '.ep-block-title a:hover',
                  'Visited' => '.ep-block-title a:visited'
              ),
              'inherit-location' => 'text'
          ));

      $this->register_block_element(
          array(
              'id'               => 'excerpt-title',
              'name'             => 'Entry Title',
              'selector'         => '.excerpt-title h2.entry-title,.excerpt-title h2.entry-title a',
              'properties'       => array('fonts', 'text-shadow', 'background', 'padding', 'margins'),
              'states'           => array(
                  'Hover'   => '.excerpt-title h2.entry-title:hover, .excerpt-title h2.entry-title a:hover',
                  'Visited' => '.excerpt-title h2.entry-title a:visited'
              ),
              'inherit-location' => 'heading'
          ));

      $this->register_block_element(
          array(
              'id'               => 'excerpt-meta',
              'name'             => 'Meta',
              'selector'         => '.ep-meta.entry-meta',
              'properties'       => array('fonts', 'text-shadow', 'background', 'padding', 'margins'),
              'states'           => array(
                  'Hover' => '.ep-meta.entry-meta:hover',
              ),
              'inherit-location' => 'text'
          ));

      $this->register_block_element(
          array(
              'id'               => 'excerpt-meta-link',
              'name'             => 'Meta Hyperlink',
              'selector'         => '.ep-meta.entry-meta a',
              'properties'       => array('fonts', 'text-shadow', 'background', 'padding', 'margins'),
              'states'           => array(
                  'Hover'   => '.ep-meta.entry-meta a:hover',
                  'Clicked' => '.ep-meta.entry-meta a:active',
                  'Visited' => '.ep-meta.entry-meta a:visited'
              ),
              'inherit-location' => 'text'
          ));

      $this->register_block_element(
          array(
              'id'               => 'quicklink-button',
              'name'             => 'Quick Read button',
              'selector'         => '.ep-meta.entry-meta a.ep_quickread',
              'properties'       => array('fonts',
                                          'text-shadow',
                                          'background',
                                          'borders',
                                          'corners',
                                          'box-shadow',
                                          'padding',
                                          'margins'),
              'states'           => array(
                  'Hover'   => '.ep-meta.entry-meta a:hover.ep_quickread',
                  'Clicked' => '.ep-meta.entry-meta a:active.ep_quickread',
                  'Visited' => '.ep-meta.entry-meta a:visited.ep_quickread'
              ),
              'inherit-location' => 'text'
          ));

      $this->register_block_element(
          array(
              'id'               => 'excerpt-content',
              'name'             => 'Body Text',
              'selector'         => '.excerpt-content',
              'properties'       => array('fonts', 'text-shadow', 'background', 'padding', 'margins'),
              'states'           => array(
                  'Hover' => '.excerpt-content:hover'
              ),
              'inherit-location' => 'text'
          ));

      $this->register_block_element(
          array(
              'id'               => 'excerpt-content-hyperlink',
              'name'             => 'Body Hyperlink',
              'selector'         => '.excerpt-content a',
              'properties'       => array('fonts', 'text-shadow', 'background', 'padding', 'margins'),
              'states'           => array(
                  'Hover'   => '.excerpt-content a:hover',
                  'Visited' => '.excerpt-content a:visited'
              ),
              'inherit-location' => 'text'
          ));
      $this->register_block_element(
          array(
              'id'               => 'excerpt-image-border',
              'name'             => 'Image',
              'selector'         => 'img.pzep_image',
              'properties'       => array('borders', 'padding', 'background', 'box-shadow', 'margins', 'corners'),
              'inherit-location' => 'text'
          ));
      $this->register_block_element(
          array(
              'id'               => 'ep-image-caption',
              'name'             => 'Image Caption',
              'selector'         => '.ep-image-caption',
              'properties'       => array('fonts',
                                          'text-shadow',
                                          'borders',
                                          'padding',
                                          'background',
                                          'box-shadow',
                                          'margins'),
              'inherit-location' => 'text'
          ));

      $this->register_block_element(
          array(
              'id'               => 'excerpt-read-more',
              'name'             => 'Read More',
              'selector'         => 'a.excerpt-read-more, a.excerpt-linkto',
              'properties'       => array('fonts', 'text-shadow', 'background', 'padding', 'margins'),
              'states'           => array(
                  'Hover'   => 'a.excerpt-read-more:hover,  a.excerpt-linkto:hover',
                  'Visited' => 'a.excerpt-read-more:visited,  a.excerpt-linkto:visited'
              ),
              'inherit-location' => 'text'
          ));

      $this->register_block_element(
          array(
              'id'               => 'ep-page-nav',
              'name'             => 'Page navigation',
              'selector'         => '.ep-nav',
              'properties'       => array('fonts',
                                          'text-shadow',
                                          'background',
                                          'borders',
                                          'corners',
                                          'box-shadow',
                                          'padding',
                                          'margins'),
              'states'           => array(
                  'Hover' => '.ep-nav:hover'
              ),
              'inherit-location' => 'text'
          ));
      $this->register_block_element(
          array(
              'id'               => 'ep-page-nav-link',
              'name'             => 'Page navigation link',
              'selector'         => '.ep-nav a',
              'properties'       => array('fonts',
                                          'text-shadow',
                                          'background',
                                          'borders',
                                          'corners',
                                          'box-shadow',
                                          'padding',
                                          'margins'),
              'states'           => array(
                  'Hover'   => '.ep-nav a:hover',
                  'Visited' => '.ep-nav a:visited'
              ),
              'inherit-location' => 'text'
          ));
      $this->register_block_element(
          array(
              'id'               => 'ep-custom-field-content',
              'name'             => 'Custom fields content',
              'selector'         => '.ep_custom_field',
              'properties'       => array('fonts',
                                          'text-shadow',
                                          'background',
                                          'borders',
                                          'corners',
                                          'box-shadow',
                                          'padding',
                                          'nudging',
                                          'margins'),
              'inherit-location' => 'text'
          ));
      $this->register_block_element(
          array(
              'id'               => 'ep-custom-field-paragraphs',
              'name'             => 'Custom fields paragraphs',
              'selector'         => '.ep_custom_field p',
              'properties'       => array('fonts',
                                          'text-shadow',
                                          'background',
                                          'borders',
                                          'corners',
                                          'box-shadow',
                                          'padding',
                                          'margins',
                                          'nudging'),
              'inherit-location' => 'text'
          ));
      $this->register_block_element(
          array(
              'id'               => 'ep-custom-field-links',
              'name'             => 'Custom fields link',
              'selector'         => '.ep_custom_field a',
              'properties'       => array('fonts',
                                          'text-shadow',
                                          'background',
                                          'borders',
                                          'corners',
                                          'box-shadow',
                                          'padding',
                                          'nudging',
                                          'margins'),
              'inherit-location' => 'text',
              'states'           => array(
                  'Hover'   => '.ep_custom_field a:hover',
                  'Visited' => '.ep_custom_field a:visited'
              ),
          ));

      $this->register_block_element(
          array(
              'id'               => 'ep-custom-field-prefix-text',
              'name'             => 'Custom fields Prefix text',
              'selector'         => '.ep_custom_field_prefix_text',
              'properties'       => array('fonts',
                                          'text-shadow',
                                          'background',
                                          'borders',
                                          'corners',
                                          'box-shadow',
                                          'padding',
                                          'nudging',
                                          'margins'),
              'inherit-location' => 'text'
          ));
      $this->register_block_element(
          array(
              'id'               => 'ep-custom-field-prefix-images',
              'name'             => 'Custom fields Prefix images',
              'selector'         => '.ep_custom_field_prefix_image',
              'properties'       => array('background',
                                          'borders',
                                          'corners',
                                          'box-shadow',
                                          'padding',
                                          'nudging',
                                          'margins'),
              'inherit-location' => 'text'
          ));
      $this->register_block_element(
          array(
              'id'               => 'ep-custom-field-suffix-text',
              'name'             => 'Custom fields Suffix text',
              'selector'         => '.ep_custom_field_suffix_text',
              'properties'       => array('fonts',
                                          'text-shadow',
                                          'background',
                                          'borders',
                                          'corners',
                                          'box-shadow',
                                          'padding',
                                          'nudging',
                                          'margins'),
              'inherit-location' => 'text'
          ));
      $this->register_block_element(
          array(
              'id'               => 'ep-custom-field-suffix-images',
              'name'             => 'Custom fields Suffix images',
              'selector'         => '.ep_custom_field_suffix_image',
              'properties'       => array('background',
                                          'borders',
                                          'corners',
                                          'box-shadow',
                                          'padding',
                                          'nudging',
                                          'margins'),
              'inherit-location' => 'text'
          ));

      if (function_exists('wp_pagenavi')) {

        $this->register_block_element(
            array(
                'id'               => 'ep-wp-pagenavi',
                'name'             => 'WP-Pagenavi',
                'selector'         => '.wp-pagenavi',
                'properties'       => array('fonts', 'text-shadow', 'borders', 'padding', 'background', 'box-shadow'),
                'inherit-location' => 'text'
            ));
        $this->register_block_element(
            array(
                'id'               => 'ep-wp-pagenavi-pages',
                'name'             => 'WP-Pagenavi pages detail',
                'selector'         => '.wp-pagenavi span.pages',
                'properties'       => array('fonts', 'text-shadow', 'borders', 'padding', 'background', 'box-shadow'),
                'inherit-location' => 'text'
            ));
        $this->register_block_element(
            array(
                'id'               => 'ep-wp-pagenavi-current',
                'name'             => 'WP-Pagenavi current page number',
                'selector'         => '.wp-pagenavi span.current',
                'properties'       => array('fonts', 'text-shadow', 'borders', 'padding', 'background', 'box-shadow'),
                'inherit-location' => 'text'
            ));
        $this->register_block_element(
            array(
                'id'               => 'ep-wp-pagenavi-pageno',
                'name'             => 'WP-Pagenavi page numbers',
                'selector'         => '.wp-pagenavi a.page',
                'properties'       => array('fonts', 'text-shadow', 'borders', 'padding', 'background', 'box-shadow'),
                'inherit-location' => 'text',
                'states'           => array(
                    'Hover' => '.wp-pagenavi a.page:hover'
                )
            ));
        $this->register_block_element(
            array(
                'id'               => 'ep-wp-pagenavi-next-prev',
                'name'             => 'WP-Pagenavi next and previous',
                'selector'         => '.wp-pagenavi a.nextpostslink, .wp-pagenavi a.previouspostslink',
                'properties'       => array('fonts', 'text-shadow', 'borders', 'padding', 'background', 'box-shadow'),
                'inherit-location' => 'text',
                'states'           => array(
                    'Hover' => '.wp-pagenavi a.nextpostslink:hover, .wp-pagenavi a.previouspostslink:hover'
                )
            ));
      }

      // $this->register_block_element(array(
      // 'id' => 'ep-cell-content-underlay',
      // 'name' => 'Underlay',
      // 'selector' => 'ep-cell-content-underlay',
      // 'properties' => array('background'),
      // 'inherit-location' => 'text'
      // ));
    }

    function content($block)
    {
      if (method_exists('UpFrontBlocksData', 'get_legacy_id')) {
        $block[ 'id' ] = UpFrontBlocksData::get_legacy_id($block);
      }

      EPFunctions::php_debug('Block: ' . $block[ 'id' ] . ' : Content start');
      $settings = UpFrontExcerptsPBlockOptions::get_settings($block);
      // Intialize
//		$settings[ 'offset' ] = $settings[ 'offset' ];

      // Show block title if set
      if ($settings[ 'ep-block-title' ]) {
        echo '<div class="ep-block-title" style="' . $settings[ 'ep-style-block-title' ] . '">';
        // Add link if set
        if ($settings[ 'ep-block-title-link' ]) {
          echo '<a href="' . $settings[ 'ep-block-title-link' ] . '" class="ep-block-title-link" title="Go to: ' . $settings[ 'ep-block-title' ] . '">';
          echo(!empty($settings[ 'ep-block-title-image' ]) ? '<img src="' . $settings[ 'ep-block-title-image' ] . '" class="pzep-block-title-image"/>' : null);
          echo(empty($settings[ 'ep-block-title-hide-text' ]) ? $settings[ 'ep-block-title' ] : null);
          echo '</a>';
        } else {
          echo(!empty($settings[ 'ep-block-title-image' ]) ? '<img src="' . $settings[ 'ep-block-title-image' ] . '" class="pzep-block-title-image"/>' : null);
          echo(empty($settings[ 'ep-block-title-hide-text' ]) ? $settings[ 'ep-block-title' ] : null);
        }
        echo '</div>';
      }

      // Create the block content
      self::ep_block_content($block, $settings);
    }

    /*	 * ************************************
      function ep_block_content( $block )
     * ************************************* */

    function ep_block_content($block, $settings)
    {
      if (is_admin()) {
        return;
      }
      // This is for debugging to see when the block is being loaded.
//		trigger_error('Block: ' . $block[ 'id' ] . ' trying to load. Is admin? ' . (is_admin() ? 'true' : 'false'));
      // Load global variables. PAGINATION RELATED
      global $paged;
      global $wp_query;
      global $authordata;
      global $post;
      global $pzep_shortcode_atts;

      // First off, let's see if it's called from a shortcode, and update required fields if it is

      if (!empty($pzep_shortcode_atts[ 'conditions' ])) {
//		echo "Hello! You called me from a shortcode";
//		pzdebug($pzep_shortcode_atts);
//		pzdebug($settings);
        $pzep_custom_conditions = json_decode(html_entity_decode($pzep_shortcode_atts[ 'conditions' ]));
//		pzdebug($pzep_custom_conditions);
        foreach ($pzep_custom_conditions as $pzep_custom_condition) {
          if ($pzep_custom_condition->type == 'multiselect') {
            $settings[ $pzep_custom_condition->field ] = array_merge($settings[ $pzep_custom_condition->field ], array(esc_attr($pzep_custom_condition->value)));
          } else {
            $settings[ $pzep_custom_condition->field ] = esc_attr($pzep_custom_condition->value);
          }
        }
      }

      // As of v3.11 this uses both numeric and associative key values to maintain compatibility with existing older installs that may not have updated.
      // This method is inherently risky as there's always a one in a million chance of keys clashing.
      $all_post_types         = array();
      $all_post_types         = array('post' => 'Posts', 'page' => 'Pages');
      $all_post_types_numeric = array('post', 'page');
      $args                   = array(
          'public'   => true,
          '_builtin' => false
      );

      $output     = 'objects'; // names or objects
      $operator   = 'and'; // 'and' or 'or'
      $post_types = get_post_types($args, $output, $operator);
      // If no selected post types, default to posts

      foreach ($post_types as $post_type) {
        $all_post_types[ $post_type->name ] = $post_type->name;
        $all_post_types_numeric[]           = $post_type->name;
      }
//		ep_options_update($block,$all_post_types_numeric);
      // Load up the $settings array with all the block's settings'
      //	$settings = UpFrontExcerptsPBlockOptions::get_settings($block);

      //		pzdebug( $settings[ 'post-type' ] );
      //
      if (isset($settings[ 'logged-in-only' ]) && !is_user_logged_in()) {
        return false;
      }

      // Naughty way of doing this!
      if (($settings[ 'ep-content-in-post' ]) && is_single()) {
        $settings[ 'number-show' ]        = 1;
        $settings[ 'number-across' ]      = 1;
        $settings[ 'excerpt-or-content' ] = 'content';
        $settings[ 'post-ids' ]           = get_the_ID();
      }

// Setup primary variables. Using an array for easier debugging
      $epv[ 'visual_editor_open' ]      = upfront_get('ve-iframe');
      $epv[ 'cont_width' ]              = UpFrontBlocksData::get_block_width($block) - $settings[ 'ep-box-adjustment' ];
      $settings[ 'image-borders' ]      = ($settings[ 'image-location' ] == 'behind') ? false : $settings[ 'image-borders' ];
      $epv[ 'number_across' ]           = (!$settings[ 'number-across' ] || $settings[ 'number-across' ] <= 0) ? '1' : $settings[ 'number-across' ];
      $epv[ 'number_to_show' ]          = $settings[ 'number-show' ];
      $epv[ 'excerpt_first_then_list' ] = ($settings[ 'excerpt-first' ] && $epv[ 'number_across' ] == 1);
// Why did Iever do this??
//$settings['borders']            = ( $epv['excerpt_first_then_list'] ) ? true : $settings['borders'];
      $epv[ 'right_margin' ]  = $settings[ 'ep-cell-vgap' ];
//      $epv[ 'border_widths' ] = UpFrontElementsData::get_property('block-excerpts-plus-excerpts-plus-excerpt', 'border-left-width') + UpFrontElementsData::get_property('block-excerpts-plus-excerpts-plus-excerpt', 'border-right-width');
      $epv['border_widths']=0;
      // this causes a problem when there's padding!
//      $epv[ 'box_shadow' ]                = max(UpFrontElementsData::get_property('block-excerpts-plus-excerpts-plus-excerpt', 'box-shadow-blur'), UpFrontElementsData::get_property('block-excerpts-plus-excerpts-plus-excerpt', 'box-shadow-vertical-offset'));
      $epv['box_shadow']=0;
      $epv[ 'ep-excerpt-height' ]         = ($settings[ 'ep-excerpt-height' ] > 0) ? 'height:' . $settings[ 'ep-excerpt-height' ] . 'px;' : null;
      $epv[ 'ep-excerpt-content-height' ] = ($settings[ 'ep-excerpt-content-height' ] > 0) ? 'height:' . $settings[ 'ep-excerpt-content-height' ] . 'px;' : null;

      // This relies on box-sizing
      $epv[ 'excerpt_width' ]        = floor(
          (($epv[ 'cont_width' ] - $epv[ 'box_shadow' ]) / $epv[ 'number_across' ]) - $settings[ 'ep-cell-vgap' ] + floor($settings[ 'ep-cell-vgap' ] / $epv[ 'number_across' ]) // Add back the right hand cell's margin
      );
      $epv[ 'excerpt_width_css' ]    = 'width:' . $epv[ 'excerpt_width' ] . 'px;';
      $epv[ 'excerpt_cell_padding' ] = 'padding:' . (!empty($settings[ 'ep-cell-padding' ]) ? $settings[ 'ep-cell-padding' ] : 0) . 'px;';

////// Need to improve box shadow handling when padding is on. :/ prob use margin on right of padding-shadow)
      $pzep_total_width = ($epv[ 'excerpt_width' ] * $epv[ 'number_across' ]) + ($epv[ 'right_margin' ] * ($epv[ 'number_across' ] - 1));

      $epv[ 'percent_excerpt_width' ]     = intval(1000000 * $epv[ 'excerpt_width' ] / $pzep_total_width) / 10000;
      $epv[ 'percent_right_margin' ]      = intval(1000000 * $epv[ 'right_margin' ] / $pzep_total_width) / 10000;
      $epv[ 'percent_excerpt_width_css' ] = 'width:' . $epv[ 'percent_excerpt_width' ] . '%;';


      $epv[ 'orig_number_across' ]     = $epv[ 'number_across' ];
      $epv[ 'orig_excerpt_width' ]     = $epv[ 'excerpt_width' ];
      $epv[ 'orig_excerpt_width_css' ] = $epv[ 'excerpt_width_css' ];
      $epv[ 'orig_right_margin' ]      = $epv[ 'right_margin' ];

      $epv[ 'orig_percent_excerpt_width' ]     = $epv[ 'percent_excerpt_width' ];
      $epv[ 'orig_percent_excerpt_width_css' ] = $epv[ 'percent_excerpt_width_css' ];
      $epv[ 'orig_percent_right_margin' ]      = $epv[ 'percent_right_margin' ];


      // Determine image width to use
      // Use configured value
      // If they leave it blank, make it square. This is to cover hang over from ep1
      $epv[ 'ep_image_width' ] = (!$settings[ 'image-width' ] && ($settings[ 'image-location' ] == 'left' || $settings[ 'image-location' ] == 'right')) ? $settings[ 'image-height' ] : $settings[ 'image-width' ];

      $epv[ 'images_correctly_configured' ] = (
          ($settings[ 'image-height' ] > 0 && ($settings[ 'image-location' ] == 'none' || $settings[ 'image-location' ] == 'behind')) || (($settings[ 'image-height' ] > 0 && $epv[ 'ep_image_width' ] > 0) && ($settings[ 'image-location' ] == 'content' || $settings[ 'image-location' ] == 'title'))
      );

      $epv[ 'image_position' ] = $settings[ 'image-position' ];

      // Calculate what 100% value is
      if ($settings[ 'image-location' ] == 'behind' || $settings[ 'image-location' ] == 'none') {
        if ($epv[ 'number_across' ] == 1) {
          // need to consider border
          $epv[ 'ep_image_width' ] = ($settings[ 'image-borders' ]) ? $epv[ 'cont_width' ] - 6 : $epv[ 'cont_width' ];
        } else {
          $epv[ 'ep_image_width' ] = ($settings[ 'image-borders' ]) ? $epv[ 'excerpt_width' ] - 6 : $epv[ 'excerpt_width' ];
        }
      }

      if ($settings[ 'force-image-width' ]) {
        $epv[ 'ep_image_width' ] = $settings[ 'image-width' ];
      }

      $epv[ 'bottom_border_class' ] = ($settings[ 'borders' ] == false) ? ' excerpts-plus-row-no-border' : null;
      $epv[ 'row_bottom_margin' ]   = 'margin-bottom:' . $settings[ 'ep-row-hgap' ] . 'px;';

      // Determine post ids to show
      $post_ids = ($settings[ 'post-ids' ] != '') ? explode(',', $settings[ 'post-ids' ]) : null;

      $original_wp_query = $wp_query;

      // if it's a single page and we don't want to process as such then do all the processing
//		var_dump(is_single(),is_page(),is_home(),is_front_page(),is_singular());
      // THIS IS SUCH A MESSSSSS!!!!
      // var_dump(
      // 	isset($settings['ep-content-in-post']),
      // 	!empty($settings['ep-content-in-post']),
      // 	$settings['ep-content-in-post'],UpFrontBlockAPI::get_setting($block,$block['settings']['ep-content-in-post'])
      // );
      //
      // What do we want to do if no content type chosen?
      // Select all or just posts?
      // Me thinks jsut posts. so need post-type to posts
      // UGH! Can't check for not set coz can't identify existing blocks compared to new blocks.
      // Will have to throw a message.
      if (((is_singular() && $settings[ 'ep-content-in-post' ] && !is_front_page()) || (is_front_page() && !empty($settings[ 'ep-force-front-page' ])))) {
        // skip the procesing
        // but anything else, we process
        // OPEN THE EXCERPTSPLUS DIV
//			pzdebug($wp_query->query_vars);
        echo '<div class="block-type-content excerpts-plus" style="' . $settings[ 'ep-style-block' ] . '">';
        echo '<!-- ExcerptsPlus v' . EPVERSION . ' -->';
        do_action('ep_top_of_block', $settings[ 'ep-top-of-block' ]);
      } else {
        if ($settings[ 'show-children' ]) {
          $pageids = '';
          $mypages = get_pages('child_of=' . $settings[ 'post-ids' ] . '&sort_column=post_name&sort_order=asc');
          foreach ($mypages as $page) {
            $pageids .= $page->ID . ',';
          }
          $post_ids = explode(',', $pageids);
        }
        $pzep_category_override = (isset($_GET[ 'catid' ]) ? $_GET[ 'catid' ] : null);

        $epv[ 'ep_categories' ] = ($settings[ 'post-type' ] === 'page' || $settings[ 'post-type' ] === '1' || $settings[ 'categories' ] === 'all' || $settings[ 'categories' ] === array('all')
        ) ? '' : $settings[ 'categories' ];
        // Override category if passed thru query var
        $epv[ 'ep_categories' ] = (!empty($_GET[ 'catid' ]) ? esc_html($_GET[ 'catid' ]) : $epv[ 'ep_categories' ]);

        $epv[ 'ep_excategories' ] = ($settings[ 'post-type' ] === 'page' || $settings[ 'post-type' ] === 1
        ) ? '' : $settings[ 'exclude-categories' ];

        $epv[ 'content_border' ] = 'border-bottom:#ddd solid 1px;padding-bottom:10px;';
        $epv[ 'use_pagination' ] = ($settings[ 'use-pagination' ]) ? true : false;

        $epv[ 'align_with_title' ] = ($settings[ 'align-excerpt' ] && $settings[ 'image-location' ] == 'title');

        // Check if is a catgeory list page and get id
        if (is_category() && ($settings[ 'ep-use-default-behaviour' ]) && empty($_GET[ 'catid' ])) {
          $epv[ 'ep_categories' ] = '';
          $categories_arr         = EPFunctions::get_category_list();
          $category_name          = single_cat_title("", false);
          $ep_category_names      = $category_name;

          $epv[ 'ep_categories' ]   = array_search($category_name, $categories_arr);
          $epv[ 'ep_excategories' ] = '';

          if ($settings[ 'show-cat-kids' ]) {
            $ep_cat_kids = get_categories(array('child_of' => $epv[ 'ep_categories' ]));

            foreach ($ep_cat_kids as $kid) {
              $epv[ 'ep_categories' ] .= ',' . $kid->cat_ID;
              $ep_category_names .= ', ' . $kid->cat_name;
            }
            $epv[ 'ep_categories' ] = explode(',', $epv[ 'ep_categories' ]);
          }
          if ($epv[ 'ep_categories' ] === false) {
            $epv[ 'ep_categories' ] = 'No results for this category';
          }
        }

        if (is_array($settings[ 'author' ])) {
          $ep_author = implode(',', $settings[ 'author' ]);
          //TODO: If it's 0 needs to be converted to all

        } else {
          $ep_author = $settings[ 'author' ];

        }
        // Check if is an author list page
        if (is_author()) {
          // Stupid little bit of code to get the author since there's no WP author functions that work outside the loop
          if (have_posts()) {
            the_post();
            $ep_author      = $authordata->ID;
            $ep_author_name = $authordata->display_name;
            rewind_posts();
          }
        }

        $selected_post_types = (!$settings[ 'post-type' ]) ? 'post' : $settings[ 'post-type' ];
        $selected_post_types = ($settings[ 'post-type' ] == 'post' || $settings[ 'post-type' ] === 0 || $settings[ 'post-type' ] === '0') ? 'post' : $selected_post_types;
        $selected_post_types = ($settings[ 'post-type' ] == 'page' || $settings[ 'post-type' ] === 1 || $settings[ 'post-type' ] === '1') ? 'page' : $selected_post_types;
        $selected_post_types = (is_array($selected_post_types) ? $selected_post_types : array($selected_post_types));
        foreach ($selected_post_types as $selected_post_type) {
// this caused soooo much grief at 3.1.1
//				$ep_post_types[] = $all_post_types[$selected_post_type];
          // Maybe if I hadda done this!!
          if (is_numeric($selected_post_type)) {
            $ep_post_types[] = $all_post_types_numeric[ $selected_post_type ];

          } else {
            $ep_post_types[] = $selected_post_type;
          }
        }
        $use_slider = (!$settings[ 'use-slider' ]) ? 'noslider' : 'slider';
        if ($settings[ 'ep-use-default-behaviour' ]) {
          $query_options              = $wp_query->query_vars;
          $query_options[ 'order' ]   = ($settings[ 'order-az' ] == 'Descending' || $settings[ 'order-az' ] == 'DESC' ? 'DESC' : 'ASC');
          $query_options[ 'orderby' ] = $settings[ 'order-by' ];
          if (!empty($epv[ 'ep_excategories' ])) {
            $query_options[ 'category__not_in' ] = $epv[ 'ep_excategories' ]; // Added in 3.4.10
          }

          // nudge the query. Keep an eye on this that it doesn't bugger other things!
          $wp_query->query($query_options);

        } else {
          // setup query
          $query_options = array(
              'offset'           => $settings[ 'offset' ],
              'category__not_in' => $epv[ 'ep_excategories' ],
              'author'           => $ep_author,
              'post_type'        => $ep_post_types,
              'order'            => ($settings[ 'order-az' ] == 'Descending' || $settings[ 'order-az' ] == 'DESC' ? 'DESC' : 'ASC'),
              'orderby'          => $settings[ 'order-by' ],
              'post_status'      => ((!empty($settings[ 'post-inc-scheduled' ]) && $settings[ 'post-inc-scheduled' ]=='1') ? array('publish',
                                                                                                                              'private',
                                                                                                                              'future') : null)
          );
          $ep_tax_list   = $settings[ 'ep-taxonomies' ];
          // Add custom taxonomies to query
          if ($ep_tax_list) {
            foreach ($ep_tax_list as $ep_tax) {
              $ep_tax          = explode(':', $ep_tax);
              $ep_tax_filter[] = array(
                  'taxonomy' => $ep_tax[ 0 ],
                  'field'    => 'slug',
                  'terms'    => array($ep_tax[ 1 ]),
              );
            }
            $query_options[ 'tax_query' ] = array('relation' => $settings[ 'ep-taxonomies-operator' ]);
            foreach ($ep_tax_filter as $ep_tax_filt) {
              $query_options[ 'tax_query' ][] = $ep_tax_filt;
            };
          }
          if (!empty($settings[ 'ep-taxonomies-operator' ])) {
            $query_options[ 'tax_query' ] = array('relation' => $settings[ 'ep-taxonomies-operator' ]);

          }
          // add tags to query
          if (!empty($settings[ 'ep-tags' ])) {
            $query_options[ 'tag__in' ] = $settings[ 'ep-tags' ];
          }
          if (!empty($settings[ 'exclude-tags' ])) {
            $query_options[ 'tag__not_in' ] = $settings[ 'exclude-tags' ];
          }

          // Stickies don't seem to work in WordPRess
          // Seethis: http://wordpress.org/support/topic/category_in-ampamp-sticky
          // HAve activated but will force to all categories
          if ($settings[ 'include-stickies' ]) {
            $query_options[ 'ignore_sticky_posts' ] = 0;
          } else {
            $query_options[ 'ignore_sticky_posts' ] = 1;
          }

          // Use "all" categories or not
          if ($settings[ 'all-include-categories' ]) {
            $query_options[ 'category__and' ] = $epv[ 'ep_categories' ];
            // Without this, WP will show stickies regardless of query
            //  $query_options['ignore_sticky_posts'] = 1;
          } else {
            /// Don't do categories if stickies on coz it screws up
            if (!$settings[ 'include-stickies' ]) {
              $query_options[ 'category__in' ] = $epv[ 'ep_categories' ];
            }
            // Just in case WP fixes the stickies prob and default stickies to shown
            //  $query_options['ignore_sticky_posts'] = 1;
          }

          // Exclude IDs or not
          if ($settings[ 'exclude-ids' ] && !$settings[ 'show-children' ]) {
            $query_options[ 'post__not_in' ] = $post_ids;
          } else {
            $query_options[ 'post__in' ] = $post_ids;
          }
          // Just in case WP fixes the stickies prob and default stickies to shown
          //  $query_options['ignore_sticky_posts'] = 1;
        }

        // Add a identifier to the query that this is an eplus query
        $this->is_eplus = $block[ 'id' ];

        // OPEN THE EXCERPTSPLUS DIV
        echo '<div class="block-type-content excerpts-plus" style="' . $settings[ 'ep-style-block' ] . '">';
        echo '<!-- ExcerptsPlus v' . EPVERSION . ' -->';
        do_action('ep_top_of_block', $settings[ 'ep-top-of-block' ]);


        if (is_category() && $settings[ 'cat-archive' ] && ($settings[ 'ep-use-default-behaviour' ])) {
          echo '<h2 class="entry-title ep-cats-shown">';
          $cats_pretext = str_replace('%categories%', '%showcats%', $settings[ 'cat-archive' ]);
          if (sizeof($epv[ 'ep_categories' ]) > 1) {
            $cats_pretext = str_replace('category', 'categories', $cats_pretext);
          } else {
            $cats_pretext = str_replace('categories', 'category', $cats_pretext);
          }

          echo str_replace('%showcats%', $ep_category_names, $cats_pretext);
          echo '</h2>';
        }

        if (is_author() && $settings[ 'author-archive' ]) {
          echo '<h2 class="entry-title ep-author-shown">';
          echo str_replace('%author%', $ep_author_name, $settings[ 'author-archive' ]);
          echo '</h2>';
        }

        if (is_archive() && !is_category() && !is_author()) {
          $queried_object = get_queried_object();
          echo '<h2 class="entry-title ep-archive-shown">';
          if (is_date()) {
            switch (true) {
              case  (get_query_var('day') == 0) :
                // need to remove %day% and -
                echo str_replace(array('%month%', '%year%'), array(get_query_var('monthnum'),
                                                                   get_query_var('year')), $settings[ 'date-archive' ]);
                break;
              case  (get_query_var('monthnum') == 0) :
                // need to remove %day% and - and month% and -
                echo str_replace('%year%', get_query_var('year'), $settings[ 'date-archive' ]);
                break;
              default:
                echo str_replace(array('%day%', '%month%', '%year%'), array(get_query_var('day'),
                                                                            get_query_var('monthnum'),
                                                                            get_query_var('year')), $settings[ 'date-archive' ]);
                break;
            }
          } else {
            echo ucwords(str_replace('_', ' ',!empty($queried_object->taxonomy)?$queried_object->taxonomy:'')) . ': ' . ucfirst(!empty($queried_object->name)?$queried_object->name:'');
          }
          echo '</h2>';
        }
        //		var_dump( $settings[ 'debug' ], $_REQUEST[ 'pzepdebug' ] );
        if (!empty($settings[ 'debug' ]) || !empty($_REQUEST[ 'pzepdebug' ])) :
          echo '<strong>Variables</strong><br/>';
          EPFunctions::debug($epv);
          echo '<strong>Block</strong><br/>';
          EPFunctions::debug($block);
          echo '<strong>Settings</strong><br/>';
          EPFunctions::debug($settings);
          echo '<strong>Query options</strong><br/>';
          EPFunctions::debug($query_options);
          //			}
        endif;

        // PAGINATION RELATED
        // Offset does not work with pagination.
        // Offset does not work with pagination.
        // Offset does not work with pagination.
        // Offset does not work with pagination.
        // Offset does not work with pagination.
        // Offset does not work with pagination.
        // Offset does not work with pagination.
        // Offset does not work with pagination.
        // A work around is provided at http://weblogtoolscollection.com/archives/2008/06/19/how-to-offsets-and-paging/

        $original_wp_query = $wp_query;

        if ($settings[ 'ep-use-default-behaviour' ]) {
          // load up all post types.
          $wp_query->set('posts_per_page', $epv[ 'number_to_show' ]);
          // WP likes to use its own defaults on results pages
          if (is_search()) {
            $epv[ 'number_to_show' ] = 10;
          }
          // Removed 27-9-2013 coz making it show automatically on category pages. LEave it up to the user. But no, leave as was
          $epv[ 'use_pagination' ] = true;

          // Only do this for archive pages - search results don't like it
          if (is_archive()) {
            $wp_query->set('post_type', (($settings[ 'post-type' ]) ? $ep_post_types : 'any'));
            $wp_query->get_posts();
          }
        } else {
          $query_options[ 'posts_per_page' ] = $epv[ 'number_to_show' ];
          if ($epv[ 'use_pagination' ]) {
            $query_options[ 'paged' ] = $paged;
          } else {
            $query_options[ 'offset' ] = $settings[ 'offset' ];
          }

          // WP doesn't like it when offset is 0. Breaks pagination 6-Jan-16
          // WP 4.4 https://core.trac.wordpress.org/ticket/34060
          if (isset($query_options[ 'offset' ]) && $query_options[ 'offset' ] == 0 && $epv[ 'use_pagination' ]) {
            unset($query_options[ 'offset' ]);
          }

//pzdebug($query_options);

          global $ep_where_vars;
          if (isset($settings[ 'ep-days-to-show' ]) && $settings[ 'ep-days-to-show' ] >= 0 && 'all' != strtolower($settings[ 'ep-days-to-show' ])) {
            if (version_compare(get_bloginfo('version'), '3.7.0', 'lt')) {
              $ep_where_vars = array('days'         => $settings[ 'ep-days-to-show' ],
                                     'end_date'     => $settings[ 'ep-date-to-end' ],
                                     'use_timezone' => $settings[ 'ep-use-timezone' ]);
              add_filter('posts_where', 'ep_set_date_range');
            } else {
              $ep_timezone = get_option('timezone_string');
              //  how do we tell the user the timezone is empty??? Only works if a valid timezone name is used, not offset
              if (!empty($settings[ 'ep-use-timezone' ]) & !empty($ep_timezone)) {
                $ep_the_date = new DateTime($settings[ 'ep-date-to-end' ], new DateTimeZone($ep_timezone));
              } else {
                $ep_the_date = new DateTime($settings[ 'ep-date-to-end' ]);
              }
              $ep_first_date                 = $ep_the_date->format('Y-m-d');
              $ep_last_date                  = $ep_the_date->add(new DateInterval('P' . $settings[ 'ep-days-to-show' ] . 'D'))->format('Y-m-d');
              $query_options[ 'date_query' ] = array(
                  array(
                      'after'     => $ep_first_date,
                      'before'    => $ep_last_date,
                      'inclusive' => true, // Changed this in v3.4.9. Might have repurcussions tho
                  )
              );

            }
          }

          /** Custom fields filter */
          if (isset($settings[ 'ep-use-custom-filter' ]) && $settings[ 'ep-use-custom-filter' ]) {
            $ep_filter_value = $settings[ 'ep-custom-filter-value' ];
            switch ($settings[ 'ep-custom-filter-value-type' ]) {
              case 'numeric' :
                break;
              case 'binary':
                break;
              case 'string':
                break;
              case 'date':
                if ($settings[ 'ep-custom-filter-value' ] == 'today') {
                  $ep_filter_value = date('Y-m-d', time());
                } else {
                  $ep_filter_value = date('Y-m-d', strtotime($settings[ 'ep-custom-filter-value' ]));
                }

                break;
              case 'datetime':
                break;
              case 'time':
                break;
              case 'timestamp':
                $ep_filter_value = strtotime($settings[ 'ep-custom-filter-value' ]);
                break;
            }

            $query_options[ 'meta_query' ] = array(
                array(
                    'key'     => $settings[ 'ep-custom-filter-key' ],
                    'value'   => $ep_filter_value,
                    'type'    => $settings[ 'ep-custom-filter-type' ],
                    'compare' => $settings[ 'ep-custom-filter-compare' ]
                )
            );
          }
          if (!empty($settings[ 'ep-custom-where-sql' ])) {
            $ep_where_vars = array('custom' => $settings[ 'ep-custom-where-sql' ]);
            add_filter('posts_join', 'ep_post_meta_join');
            add_filter('posts_where', 'ep_custom_where');
          }


          // Need to include the key in a join when sorting
          // http://wordpress.mcdspot.com/2010/05/30/filters-to-modify-a-query/
          // http://wordpress.org/support/topic/sorting-by-custom-fieds-with-the-posts_orderby-filter

          /** Custom fields sort */
          if (isset($settings[ 'ep-use-custom-sort' ]) && $settings[ 'ep-use-custom-sort' ]) {
            global $ep_custom_sort_vals;
            $ep_custom_sort_vals[ 'key' ]   = $settings[ 'ep-custom-filter-sort-key' ];
            $ep_custom_sort_vals[ 'order' ] = $settings[ 'ep-custom-filter-sort-key-order' ];

            add_filter('posts_orderby', 'ep_edit_posts_orderby');
            if (!$settings[ 'ep-use-custom-filter' ]) {
              add_filter('posts_join', 'ep_edit_posts_join');
            }
          }

//          var_dump($query_options);
//          // What a surprise! This didn't work either for making pagination work on the front page
////          /** THIS COULD CREATE HAVOC! 10-7-14 */
//          if (is_front_page() && !empty($epv[ 'use_pagination' ])) {
//            if (get_query_var('paged')) {
//              $paged = get_query_var('paged');
//            } elseif (get_query_var('page')) {
//              $paged = get_query_var('page');
//            } else {
//              $paged = 1;
//            }
//
//            $query_options[ 'paged]' ] = $paged;
//          }

          // Run the query
          // Must be inside this side of the if clause else will override the defaults
//          var_dump($wp_query);
//          ksort($wp_query->query_vars);
//          var_Dump($wp_query->query_vars);
          $wp_query = new WP_Query($query_options);
//          var_dump($wp_query);
//          ksort($wp_query->query_vars);
//          var_Dump($wp_query->query_vars,$query_options,$wp_query->request);
//				pzdebug( $wp_query->request );
          // Remove any filters
          remove_filter('posts_where', 'ep_set_date_range');
          remove_filter('posts_where', 'ep_custom_where');
        }
      }
      $excerpt_row    = 0;
      $excerpt_count  = 0;
      $content_count  = 0;
      $cell_no        = 0;
      $across_counter = 0;

      $ep_error[ 'cache' ]         = '';
      $ep_error[ 'nextgen' ]       = '';
      $ep_error[ 'dimensions' ]    = '';
      $ep_error[ 'publish-again' ] = '';

//		pzdebug( $query_options );
//		pzdebug( ( array ) $wp_query );
      if ($settings[ 'ep-show-custom-request' ]) {
        pzdebug($wp_query->request);
      }
//		pzdebug( $wp_query->found_posts );

      /*************************************************************************************************************************
       *************************************************************************************************************************
       *
       *
       * MAIN LOOP STARTS HERE
       *
       *
       *************************************************************************************************************************
       *************************************************************************************************************************/
      if ($wp_query->have_posts()) {
        do_action('ep_before_loop_start', $settings[ 'ep-before-loop-start' ]);


        // Wrap in slider div if slider
        if ($settings[ 'use-slider' ]) {
          $use_slider = (!$settings[ 'use-slider' ]) ? 'noslider' : 'slider';
          echo '<div id="' . $use_slider . '-' . $block[ 'id' ] . '" class="' . $use_slider . ' ep-slider-wrapper">';
        }

        while ($wp_query->have_posts()) {

          $wp_query->the_post();


          // ------------------------------------------------------------------------------------------------------
          // SETUP LOOP VARIABLES
          // ------------------------------------------------------------------------------------------------------
          // ------------------------------------------------------------------------------------------------------
          // SETUP THE EXCERPT
          // ------------------------------------------------------------------------------------------------------

          $image      = null;
          $hide_trunc = false;
          switch (true) {
            case $settings[ 'excerpt-or-content' ]==='content'  && !ep_is_scheduled():
              $content             = apply_filters('the_content', get_the_content());
              $content             = str_replace(']]>', ']]&gt;', $content);
              $the_excerpt_to_show = strip_shortcodes($content);
              break;
            case $settings[ 'excerpt-or-content' ]==='styled-excerpt':
              $the_excerpt_to_show = nl2br(get_the_excerpt()) . '%readmorestr%';
              break;
            case $settings[ 'excerpt-or-content' ]==='excerpt'  || ep_is_scheduled():
              // Changed this to get_the_content in v2.9.16
              // Changed to get_the_excerpt if available, in 2.9.19

              if (has_excerpt()) {
                $the_excerpt_to_show = get_the_excerpt();
              } else {
                $the_excerpt         = get_the_content();
                $the_excerpt_to_show = $the_excerpt;
                //					if ( strpos( $the_excerpt, 'function()' ) > 0 ) { $the_excerpt = get_the_content();}
                $the_excerpt = strip_shortcodes($the_excerpt);
                // If has a more symbol, trim to it first.
                $is_more_tag = strpos($the_excerpt, '<span id="more-');
                $the_excerpt = ($is_more_tag !== false ? substr($the_excerpt, 0, $is_more_tag) : $the_excerpt);
                $the_excerpt = EPFunctions::strip_html_tags($the_excerpt);
                if (ep_is_scheduled() || !$settings[ 'chars-or-words' ] || $settings[ 'chars-or-words' ] == 'characters' && $settings[ 'ep-trim-excerpts' ]) {
                  $the_excerpt_to_show = strip_tags(substr($the_excerpt, 0, $settings[ 'excerpt-length' ]));
                } else {
                  $the_excerpt_to_show = strip_tags($the_excerpt);
                }
              }
              // Hack to make work with Sharebar
              $the_excerpt_to_show = str_replace("TweetSharebar Tweet", "", $the_excerpt_to_show);
              $the_excerpt_to_show = str_replace("Sharebar", "", $the_excerpt_to_show);

              // Trim it down
              $hide_trunc = has_excerpt();
              if ($settings[ 'ep-trim-excerpts' ]) {
                if (!$settings[ 'chars-or-words' ] || $settings[ 'chars-or-words' ] == 'characters') {
                  if (strlen($the_excerpt_to_show) > $settings[ 'excerpt-length' ]) {
                    /// Should rewrite using wp_trim_excerpt, wp_trim_words one day - except it don't support cvharacters!
                    $the_excerpt_to_show = substr($the_excerpt_to_show, 0, $settings[ 'excerpt-length' ]);
                    $hide_trunc          = false;
                  }
                } elseif (!$settings[ 'chars-or-words' ] || $settings[ 'chars-or-words' ] == 'words') {
                  $text  = $the_excerpt_to_show;
                  $words = str_word_count($text, 2);
                  $pos   = array_keys($words);
                  if (count($words) > $settings[ 'excerpt-length' ]) {
                    $the_excerpt_to_show = substr($text, 0, $pos[ $settings[ 'excerpt-length' ] ]);
                    $hide_trunc          = false;
                  }
                  $the_excerpt_to_show = wp_trim_words($the_excerpt_to_show, $settings[ 'excerpt-length' ], '');
                }
              }
              $the_excerpt_to_show = $the_excerpt_to_show . '%readmorestr%';


              break;
          }

          $content_count++;
//				var_dump($content_count,$settings['content-count'],$content_count<=$settings['content-count']);
          if ($content_count <= $settings[ 'content-count' ]) {
            if (empty($settings[ 'ep-full-width-excerpt' ])) {
              // Wha?!! Should tis work?
              $content             = apply_filters('the_content', get_the_content());
              $content             = str_replace(']]>', ']]&gt;', $content);
              $the_excerpt_to_show = strip_shortcodes($content);
              $is_excerpt          = false;
            }
//					if ( $settings['content-count'] != $epv['number_across'] || $settings['content-count'] == 1 ) {
            // need to change number_across etc temporarily to 1
            $epv[ 'number_across' ] = 1;
//						$epv['excerpt_width_css'] = 'width:'.( $settings['cont_width']-$settings['ep-box-adjustment']-2*$settings['ep-cell-padding'] ).'px;';
//					$epv[ 'excerpt_width_css' ]	 = (($epv[ 'cont_width' ] - $epv[ 'box_shadow' ] ) / $epv[ 'number_across' ] ) - $settings[ 'ep-cell-vgap' ] + floor( $settings[ 'ep-cell-vgap' ] / $epv[ 'number_across' ] ) - $settings[ 'ep-box-adjustment' ] . 'px;';
            $epv[ 'percent_excerpt_width_css' ] = 'width:100%;';
//					$epv[ 'excerpt_width_css' ]	 = 'width: ' . $epv[ 'excerpt_width_css' ];
            $epv[ 'right_margin' ] = 0;
            $cell_no               = 0;
//						pzdebug($epv['excerpt_width_css']);
            //}
          } else {
            // Reset to correct values

            $epv[ 'number_across' ]     = $epv[ 'orig_number_across' ];
            $epv[ 'excerpt_width' ]     = $epv[ 'orig_excerpt_width' ];
            $epv[ 'excerpt_width_css' ] = $epv[ 'orig_excerpt_width_css' ];
            $epv[ 'right_margin' ]      = $epv[ 'orig_right_margin' ];

            $epv[ 'percent_excerpt_width' ]     = $epv[ 'orig_percent_excerpt_width' ];
            $epv[ 'percent_excerpt_width_css' ] = $epv[ 'orig_percent_excerpt_width_css' ];
            $epv[ 'percent_right_margin' ]      = $epv[ 'orig_percent_right_margin' ];

            $excerpt_row++;
            $excerpt_count++;
            $is_excerpt = ($settings[ 'excerpt-or-content' ] == 'excerpt') ? true : false;
//					$is_excerpt = ( $settings['excerpt-or-content'] == 'content' ) ? false : true;
            $epv[ 'content_border' ] = '';
            $cell_no++;
          }

          $truncchar = '<span class="ep-more-indicator"> </span>';
          if ($settings[ 'excerpt-or-content' ] == 'excerpt' && !$hide_trunc) {
            if ($settings[ 'trunc-char' ] == 'arrows') {
              $truncchar = '<span class="ep-more-indicator">&raquo; </span>';
            } elseif ($settings[ 'trunc-char' ] == 'ellipses' || !$settings[ 'trunc-char' ]) {
              $truncchar = '<span class="ep-more-indicator">&#8230; </span>';
            }
          }
//				$read_more = (($is_excerpt) ? $truncchar : null) . ( ( $settings['read-more'] != '' && $is_excerpt ) ? '<a  class="excerpt-read-more" style="' . $settings['ep-style-read-more'] . '" href="' . get_permalink() . '">' . str_replace('%title%', get_the_title(), $settings['read-more']) . '</a>' : '' );
          $read_more = (($is_excerpt) ? $truncchar : null) . ((($settings[ 'read-more' ] != '' && $is_excerpt) || !empty($settings[ 'ep-always-show-read-more' ])) ? ' <a  class="excerpt-read-more" style="' . $settings[ 'ep-style-read-more' ] . '" href="' . get_permalink() . '">' . str_replace('%title%', get_the_title(), $settings[ 'read-more' ]) . '</a>' : '');
          $read_more = (!$settings[ 'ep-dont-link' ] && !ep_is_scheduled()) ? $read_more : '';

          $ep_content_class = (!$is_excerpt) ? 'entry-content' : 'entry-content excerpt-content';

          // ------------------------------------------------------------------------------------------------------
          // SETUP META
          // ------------------------------------------------------------------------------------------------------
          /*
            $meta = stripslashes(EPFunctions::parse_meta($block, $settings['meta']));
            $meta_below = stripslashes(EPFunctions::parse_meta($block, $settings['meta-below']));
           */
          $meta             = '';
          $meta_right       = '';
          $meta_below       = '';
          $meta_below_right = '';
          $meta_three_left  = '';
          $meta_three_right = '';
          if (!empty($settings[ 'meta' ])) {
            $meta = stripslashes(EPFunctions::parse_meta($block, $settings, $settings[ 'meta' ]));
            $meta = EPFunctions::meta_php($meta);
          }
          if (!empty($settings[ 'meta-right' ])) {
            $meta_right = stripslashes(EPFunctions::parse_meta($block, $settings, $settings[ 'meta-right' ]));
            $meta_right = EPFunctions::meta_php($meta_right);
          }
          if (!empty($settings[ 'meta-below' ])) {
            $meta_below = stripslashes(EPFunctions::parse_meta($block, $settings, $settings[ 'meta-below' ]));
            $meta_below = EPFunctions::meta_php($meta_below);
          }
          if (!empty($settings[ 'meta-below-right' ])) {
            $meta_below_right = stripslashes(EPFunctions::parse_meta($block, $settings, $settings[ 'meta-below-right' ]));
            $meta_below_right = EPFunctions::meta_php($meta_below_right);
          }
          if (!empty($settings[ 'meta-three-left' ])) {
            $meta_three_left = stripslashes(EPFunctions::parse_meta($block, $settings, $settings[ 'meta-three-left' ]));
            $meta_three_left = EPFunctions::meta_php($meta_three_left);
          }
          if (!empty($settings[ 'meta-three-right' ])) {
            $meta_three_right = stripslashes(EPFunctions::parse_meta($block, $settings, $settings[ 'meta-three-right' ]));
            $meta_three_right = EPFunctions::meta_php($meta_three_right);
          }

          // why isn't this using $epv['number_across'] in both???
          //     $excerpt_right_margin = ($excerpt_row<$settings['number-across'] && $epv['number_across'] > 1) ? $epv['right_margin'] : null;
          $excerpt_right_margin = ($excerpt_row < $epv[ 'number_across' ] && $epv[ 'number_across' ] > 1) ? 'margin-right:' . $epv[ 'percent_right_margin' ] . '%;' : 'margin-right:' . $epv[ 'box_shadow' ] . 'px;';
          $excerpt_margin_class = ($excerpt_right_margin) ? 'inner-right' : 'outer-right';
          // if type is page and across = counter, right = ''

          $across_counter++;
          if ($across_counter == $epv[ 'number_across' ] && $settings[ 'content-count' ] == $across_counter) {
            $excerpt_right_margin = 'margin-right:' . $epv[ 'box_shadow' ] . 'px;';
            $excerpt_margin_class = 'outer-right';
            $across_counter       = 0;
          }

          $image_border_class = ($settings[ 'image-borders' ] == true) ? ' ep-show-border-' . $settings[ 'image-location' ] : null;


          // We need to do something when using WPML to check if parent post has the thumbnail
          // if (class_exists('WPML_Translation_Management') {
          // check if post has thumbnail.
          // if not, check if parent has thumbnail
          // sounds so easy!
//        pzdebug(get_post_meta(get_the_id()));
//        global $post;
//        var_dump($post->post_type, $post->ID);
          // icl_object_id(ID, type, return_original_if_missing, language_code)
          $ep_wpml_parent_id         = null;
          $image_info                = null;
          $has_post_thumbnail_parent = null;
          if (defined('ICL_PLUGIN_PATH')) {
            global $post, $sitepress;
            $ep_wpml_parent_id         = icl_object_id($post->ID, $post->post_type, true, $sitepress->get_default_language());
            $has_post_thumbnail        = has_post_thumbnail();
            $has_post_thumbnail_parent = has_post_thumbnail($ep_wpml_parent_id);
          } else {
            $has_post_thumbnail = has_post_thumbnail();
          }
//        var_dump( icl_object_id($post->ID,$post->post_type,true));
          $image_src = '';

          $is_image_attached = false;
          $attachments       = array();
          if (!$has_post_thumbnail && $settings[ 'ep-use-attached-images' ]) {
// THis may fail for imported WP sites.
// Also, once an image is attached, it is hard to unattach. WP doesn't provide an identifier of iamges attached to posts that aren't actually active to be displayed.	
            $args              = array('post_type'   => 'attachment',
                                       'numberposts' => -1,
                                       'post_status' => null,
                                       'post_parent' => $post->ID);
            $attachments       = get_posts($args);
            $is_image_attached = (!empty($attachments[ 0 ]) ? wp_attachment_is_image($attachments[ 0 ]->ID) : false);
          }
          //---------------------------------------------------------------------------------------------------------------------
          // Process if Image available
          //---------------------------------------------------------------------------------------------------------------------
          $has_usable_image = false;


          if (CHDEBUGNOIMAGES == 'false' && ($has_post_thumbnail || $is_image_attached) && $epv[ 'images_correctly_configured' ]) {
            $has_usable_image         = true;
            $pzep_focal_point         = '';
            $pzep_respect_focal_point = (isset($settings[ 'ep-focal-point-align' ])) ? $settings[ 'ep-focal-point-align' ] : false;

            if ($has_post_thumbnail || $has_post_thumbnail_parent) {
              // Changed to use get_the_post_thumbnail instead of wp_get_attachment_image_src coz nextgen didn't use it
              if ($has_post_thumbnail) {
                $image_info  = EPFunctions::getlinks(get_the_post_thumbnail(get_the_ID(), 'full'));
                $ep_image_id = get_post_thumbnail_id(get_the_ID());
              } elseif ($has_post_thumbnail_parent) {
                $image_info  = EPFunctions::getlinks(get_the_post_thumbnail($ep_wpml_parent_id, 'full'));
                $ep_image_id = get_post_thumbnail_id($ep_wpml_parent_id);
              }
              if ($pzep_respect_focal_point) {
                $pzep_focal_point = get_post_meta(get_post_thumbnail_id(), 'pzgp_focal_point', true);
              }
              $image = $image_info[ 0 ];
            } elseif ($is_image_attached) {
              foreach ($attachments as $attachment) {
                // This will get the first attached image but won't work for NextGen. One day we'll work out why.
                // Probably gotta use a NextGen call
                $image_info = wp_get_attachment_image_src($attachment->ID, 'full', false);
                if ($pzep_respect_focal_point) {
                  $pzep_focal_point = get_post_meta($attachment->ID, 'pzgp_focal_point', true);
                }
                if ($image_info) {
                  $image = $image_info[ 0 ];
//var_dump($image_info);
                  break;
                }
              }
            }
//var_dump($image_info);
            $ep_image_caption = '';
            // oops! This just grabs the last or first image's caption. Need specific on being shown'
            // UGH! WP still links images to their original post!! farg!

            // Why do we need to do all this crap? Can't we just grapb the thumb or attachment id?
            if ($settings[ 'ep-image-captions' ]) {
//						$temp_args        = array('post_type' => 'attachment', 'orderby' => 'menu_order', 'order' => 'ASC','post_mime_type'=>'image', 'post_status' => null, 'numberposts' => -1, 'post_parent' => $post->ID);
//						$temp_attachments = get_posts($temp_args);
//						$temp_alt         = get_post_meta($temp_attachments[ 0 ]->ID, '_wp_attachment_image_alt', true);
//
//						pzdebug($temp_attachments);
//var_dump($temp_attachments,$temp_alt,$temp_args);
//
//						foreach ($temp_attachments as $temp_attachment)
//						{
//							var_dump($image,$temp_attachment->guid,$ep_image_caption);
//							pzdebug(get_post_mime_type($temp_attachment->guid));
//							if ($image == $temp_attachment->guid)
//							{
//								$ep_image_caption = $temp_attachment->post_excerpt;
//								break;
//							}
//							var_dump($image,$temp_attachment->guid,$ep_image_caption);
//						}
              if (!empty($ep_image_id)) {
                $temp_args        = array('post_type'      => 'attachment',
                                          'post_mime_type' => 'image',
                                          'post_status'    => null,
                                          'numberposts'    => -1,
                                          'include'        => $ep_image_id);
                $temp_attachments = get_posts($temp_args);
//							pzdebug($temp_attachments);
                $ep_image_caption = $temp_attachments[ 0 ]->post_excerpt;
              }
            }
            //---------------------------------------------------------------------------------------------------------------------
            // New image processing routine
            //---------------------------------------------------------------------------------------------------------------------
            // We don't need to do this if outside VE unless the image can't be found

            $try_to_create_again = false;


            $ext_types = '.jpg .jpeg .png .gif';

            // verify extension is acceptable
            preg_match("/.*(?=\\?)/ui", $image, $results);
            $image     = (!empty($results[ 0 ]) ? $results[ 0 ] : $image);
            $extension = strtolower(strrchr($image, '.'));

            //var_dump($image,$extension);
            if ($image && strpos($ext_types, $extension) !== false) {


              // This line accomodates nextgen too, making sure it uses the full image
              $image_url = str_replace('thumbs/thumbs_', '', $image);

              // Not all servers support looking for URL, so we need the path.
//              $image_shortname = str_replace((home_url() . '/wp-content'), '', $image_url);
              // Changed 3.4.9
              $image_shortname = str_replace((site_url() . '/wp-content'), '', $image_url);
              $image_home_path = WP_CONTENT_DIR;
              $image_path      = $image_home_path . $image_shortname;

              $new_image_url  = EP_CACHE_URL_PREFIX . 'block-' . $block[ 'id' ] . '-post-' . get_the_ID() . 'WIDTH' . $extension;
              $new_image_path = EP_CACHE_PATH_PREFIX . 'block-' . $block[ 'id' ] . '-post-' . get_the_ID() . 'WIDTH' . $extension;

              // Needed this to check properly if the fiel exists. It won't always succeed, but will for most crop otions.
              // So sometimes image will be recreated unnecessarily. Need to try to fully solve, but this will speed up most
              $new_image_url_check  = EP_CACHE_URL_PREFIX . 'block-' . $block[ 'id' ] . '-post-' . get_the_ID() . '-width' . $settings[ 'image-width' ] . 'px' . $extension;
              $new_image_path_check = EP_CACHE_PATH_PREFIX . 'block-' . $block[ 'id' ] . '-post-' . get_the_ID() . '-width' . $settings[ 'image-width' ] . 'px' . $extension;

              if (!$epv[ 'visual_editor_open' ]) {

                $image_src = '<img class="pzep_image" src="' . $new_image_url_check . '" alt="' . get_the_title() . '"/>';
                if (!file_exists($new_image_path_check) && !file_exists($new_image_url_check)) {
                  // Image creation error
                  $ep_error_test       = '<div class="ep-errors"><strong>Image cache problem:</strong>.Image ' . $new_image_url . ' not created. <span class="ep_rtfm">First, reload this page. If that doesn\'t help re-publish in the Visual Editor</span> and/or check UpFront cache folder permissions if that doesn\'t resolve it.</div>';
                  $try_to_create_again = true;
                }
              }

              //---------------------------------------------------------------------------------------------------------------------
              //
              // Create images if required
              //
              //---------------------------------------------------------------------------------------------------------------------

              if (($epv[ 'visual_editor_open' ] && !$settings[ 'ep-recreate-images' ]) || $try_to_create_again) {

                if ($image && $epv[ 'ep_image_width' ] > 0 && $settings[ 'image-height' ] > 0) {

                  $pzep_err_level = error_reporting();
                  // the error_reproting(0) is said to be much faster than prefixing with an @
                  if (function_exists('exif_imagetype')) {
                    error_reporting(0);
                    $image_exists = exif_imagetype($image_path);
                    error_reporting($pzep_err_level);
                  } else {
                    error_reporting(0);
                    $image_exists = getimagesize($image_path);
                    error_reporting($pzep_err_level);
                  }
                  $useloc = 'path';
                  if (!$image_exists) {
                    $useloc = 'url';
                    if (function_exists('exif_imagetype')) {
                      error_reporting(0);
                      $image_exists = exif_imagetype($image_url);
                      error_reporting($pzep_err_level);
                    } else {
                      error_reporting(0);
                      $image_exists = getimagesize($image_url);
                      error_reporting($pzep_err_level);
                    }
                    if (!$image_exists) {
                      $useloc = 'noimage';
                    }
                  }

                  if ($image_exists === false) {
                    // this will cause a broken image link to appear. Prob the best option for getting the user's attention.
                    // $image_src = '<img src="'.$image_url.'" alt="'.get_the_title().'">';
                    $image_src = 'Cannot find or access the specified image ' . $image_url . '. Please check you have set a featured image, or post has an image. Otherwise check the file permissions on your images folders';
                  } else {

                    //---------------------------------------------------------------------------------------------------------------------
                    // Run the image processing from Oberto
                    //---------------------------------------------------------------------------------------------------------------------
                    if (extension_loaded('gd') && function_exists('gd_info')) {
                      if ($settings[ 'ep-sizing-type' ] == 'none') {
                        // Use the original image
                        // So simply copy it as a new image.
                        $new_image_url  = EP_CACHE_URL_PREFIX . 'block-' . $block[ 'id' ] . '-post-' . get_the_ID() . '-width-original' . $extension;
                        $new_image_path = EP_CACHE_PATH_PREFIX . 'block-' . $block[ 'id' ] . '-post-' . get_the_ID() . '-width-original' . $extension;
                        $image_src      = '<img class="pzep_image" src="' . $new_image_url . '" alt="' . get_the_title() . '"/>';
                        copy($image_path, $new_image_path);

                      } else {
                        if ($useloc == 'url') {
                          $resizeObj = new jo_resize($image_url);
                        } else {
                          $resizeObj = new jo_resize($image_path);
                        }
                        if (!$resizeObj->width) {
                          $image_src = 'Cannot find or access the specified image ' . $image_url . '. Please check you have set a featured image, or post has an image. Otherwise check the file permissions on your images folders';

                        } else {
                          //resizeImage($newWidth,$newHeight, $option="auto", $vcrop_align="center", $hcrop_align="center", $img_bg_color="FFFFFF", $centre_image=true)
                          $settings[ 'ep-sizing-type' ] = (!$settings[ 'ep-sizing-type' ]) ? 'crop' : $settings[ 'ep-sizing-type' ];

                          $img_bg_colour = (isset($settings[ 'ep-image-fill' ][ 'hex' ]) ? $settings[ 'ep-image-fill' ][ 'hex' ] : $settings[ 'ep-image-fill' ]);
                          $resizeObj->resizeImage($epv[ 'ep_image_width' ], $settings[ 'image-height' ], $settings[ 'ep-sizing-type' ], $settings[ 'ep-vertical-crop-align' ], $settings[ 'ep-horizontal-crop-align' ], $img_bg_colour, true, $settings[ 'max-image-dim' ], $pzep_focal_point
                          );
                          if ($settings[ 'ep-sizing-type' ] == 'scaletoheight') {
                            $ep_new_image_width = ($resizeObj->width * $settings[ 'image-height' ] / $resizeObj->height);
                          } else {
                            $ep_new_image_width = $settings[ 'image-width' ];
                          }
                          if ($settings[ 'image-width' ] > $resizeObj->width) {
                            $ep_new_image_width = $resizeObj->width;
                          }
                          // if (!is_dir(UpFrontCACHE.'/images')) {
                          // mkdir(UpFrontCACHE.'/images');
                          // }
                          //       $new_image_url = UpFrontURL.'/media'.'/'.UpFrontCACHEDIR.'/images/eplus-post-'.get_the_ID().'-block-'.$block['id'].$extension;
                          //       $new_image_path = UpFrontCACHE.'/images/eplus-post-'.get_the_ID().'-block-'.$block['id'].$extension;


                          /* Files should alsways exist... so only really need to be created when in Visual Editor... */
                          if ($epv[ 'visual_editor_open' ] || !file_exists($new_image_path) || $try_to_create_again) {
                            // Need to delete all cached images that match the block id
                            if ($epv[ 'visual_editor_open' ]) {
                              // This might be the cause of the broken images!
                              //ep_clear_image_cache(EP_CACHE_PATH,'-block-'.$block['id']);
                            }
                            if (!empty($settings[ 'ep-custom-fields-colourise-image' ])) {
                              $resizeObj->colourize($settings[ 'ep-custom-fields-colourise-image' ]);
                            }
                            $ep_quality     = (!$settings[ 'ep-quality' ]) ? 70 : (int)$settings[ 'ep-quality' ];
                            $new_image_path = str_replace('WIDTH', ('-width' . $ep_new_image_width . 'px'), $new_image_path);
                            $resizeObj->saveImage($new_image_path, $ep_quality);
                          }

                          if (!file_exists($new_image_path) && !file_exists($new_image_url)) {
                            // Image creation error
                            $ep_error[ 'cache' ] .= '<div class="ep-errors"><strong>Image cache problem:</strong>.Image ' . $new_image_url . ' not created. <span class="ep_rtfm">First, reload this page. If that doesn\'t help re-publish in the Visual Editor</span> and/or check UpFront cache folder permissions if that doesn\'t resolve it.</div>';
                            //        $ep_error['cache'] .= '<div class="ep-errors"><strong>Image cache problem:</strong>.Image '.$new_image_url.' not created. Please check UpFront cache folder permissions.</div>';
                          }
                          $image_src = '<img class="pzep_image" src="' . str_replace('WIDTH', ('-width' . $ep_new_image_width . 'px'), $new_image_url) . '" alt="' . get_the_title() . '"/>';
                        }
                      }
                    } else {
                      $image_src = '<img src="http://dummyimage.com/150x50/777777/ffffff&text=Missing+GD+Library">';
                    }
                  }
                } elseif (!($epv[ 'ep_image_width' ] > 0 && $settings[ 'image-height' ] > 0)) {
                  // Publish again
                  $ep_error[ 'publish-again' ] = '<div class="ep-errors"><strong>Block creation problem:</strong> <strong>Block ID ' . $block[ 'id' ] . '</strong> not fully created. <span class="ep_rtfm">First, reload this page. If that doesn\'t help, then re-publish it in the Visual Editor.</span> If that fails, contact UpFront support.</div>';
                } elseif (!$image) {
                  // NextGen error
                  $ep_error[ 'nextgen' ] .= '<div class="ep-errors"><strong>Featured Image problem:</strong> WordPress indicates the post <strong><em>' . get_the_title() . '</em></strong> has an issue with its Featured Image. This could happen if you were using an alternative image plugin to supply your Featured Image, and have since deactivated that plugin.</div>';
                }
              }
            }
            if (($has_post_thumbnail || $attachments) && !$epv[ 'images_correctly_configured' ]) {
              // Image dimensions error
              $ep_error[ 'dimensions' ] = '<div class="ep-errors"><strong>Image dimensions problem:</strong> You have not correctly entered the image height and/or width for this block, <strong>ID ' . $block[ 'id' ] . '</strong>.</div>';
            }
          }


          // Set parameters if image in title
          $titleheight               = '';
          $imagewidth                = '0';
          $excerpt_title_extra_class = null;
          $excerpt_margin            = null;
          $title_width               = null;
          $excerpt_margin_value      = $settings[ 'image-height' ] + 15;
          if ($has_usable_image && $settings[ 'image-location' ] == 'title') {
            $title_width               = ';width:' . (($epv[ 'cont_width' ] * $epv[ 'excerpt_width' ] / 100) - $epv[ 'ep_image_width' ] - (10 * ($epv[ 'number_across' ] - 1))) . 'px;';
            $titleheight               = ';min-height:' . $settings[ 'image-height' ] . 'px;';
            $imagewidth                = $epv[ 'ep_image_width' ];
            $excerpt_title_extra_class = ' excerpt-title-image-' . $epv[ 'image_position' ];
            $excerpt_margin            = ($settings[ 'align-excerpt' ]) ? ';margin-' . $epv[ 'image_position' ] . ':' . $excerpt_margin_value . 'px;' : null;
          }

          $ep_valign = ($settings[ 'image-location' ] == 'behind') ? $settings[ 'ep-content-align-behind' ] : 'default';


          // ((cw-2p1-2p2(na-1))/na-im-2p3
          // (($epv['cont_width']-2*10-2*5*($epv['number_across']-1))/$epv['number_across']-$epv['ep_image_width']-2*2

          $ep_col1_width = (!empty($epv[ 'align_with_title' ]) && $epv[ 'image_position' ] == 'left' && $has_usable_image) ? $epv[ 'ep_image_width' ] + 10 : 0;
          $ep_col3_width = (!empty($epv[ 'align_with_title' ]) && $epv[ 'image_position' ] == 'right' && $has_usable_image) ? $epv[ 'ep_image_width' ] + 10 : 0;

          // This needs to be 100%, not the px width, coz it needs 100% if displaying full content
          // Resize for content showing
          // OOPS!
          //     $ep_col2_width = ($epv['align_with_title'] && $has_usable_image && $content_count <= $settings['content-count']) ? (($epv['cont_width']/$epv['number_across'])-$epv['ep_image_width']-50).'px': $ep_col2_width;

          $ep_col2_width = '100%';
          if (!empty($epv[ 'align_with_title' ]) && $has_usable_image) {
            if ($content_count <= $settings[ 'content-count' ]) {
              // If in content, we want wide less col1 or 3
              $ep_col2_width = ($epv[ 'cont_width' ] / $epv[ 'number_across' ] - $ep_col1_width - $ep_col3_width - (10 * $epv[ 'number_across' ]) - 10) . 'px'; // 1,3 or both will always be zero
            } elseif ($content_count > $settings[ 'content-count' ]) {
              // If in excerpts, narrow less col1 or 3
              $ep_col2_width = ((($epv[ 'cont_width' ] / $epv[ 'number_across' ]) - $epv[ 'ep_image_width' ] - (10 * $epv[ 'number_across' ])) - 10) . 'px'; // 1,3 or both will always be zero // Added the minus 10 for when 1 column
            }

            // Otherwise we leave it the way it was
          }

          $ep_title_width = 'width:100%';
          if ($settings[ 'image-location' ] == 'title' && $has_usable_image && !$epv[ 'align_with_title' ]) {
            if ($content_count <= $settings[ 'content-count' ] && $epv[ 'number_across' ] == 1 && $settings[ 'image-position' ] != 'center') {
              $ep_title_width = 'width:' . ($epv[ 'cont_width' ] / $epv[ 'number_across' ] - $epv[ 'ep_image_width' ] - 10 - 5) . 'px;';
            } elseif ($settings[ 'image-position' ] == 'center') {
              $ep_title_width = 'width:100%;float:none!important;text-align:center!important;';
            } else {
              $ep_title_width = 'width:' . ($epv[ 'excerpt_width' ] - $epv[ 'ep_image_width' ] - (10 * $epv[ 'number_across' ])) . 'px;';
            }
          } elseif ($settings[ 'image-location' ] == 'behind') {
//					$ep_title_width	 = 'width:' . ( $epv[ 'excerpt_width' ] - 20 ) . 'px;';
//					$show_excerpt		 = 'width:' . ( $epv[ 'excerpt_width' ] - 20 ) . 'px;';
            $ep_title_width = 'width:98%;';
            $show_excerpt   = 'width:98%;';
          }

          if (!$settings[ 'ep-dont-link' ] && !ep_is_scheduled()) {
            $ep_permalink          = get_permalink();
            $title_attribute       = the_title_attribute(array('echo' => false));
            $ep_title_image_left   = (!empty($epv[ 'align_with_title' ]) && $epv[ 'image_position' ] == 'left') ? '<div class="excerpt-image' . $image_border_class . ' excerpt-title-image-' . $epv[ 'image_position' ] . '" style="height:100%;float:' . $epv[ 'image_position' ] . ';"><a href="' . $ep_permalink . '" rel="' . $settings[ 'permalink-rel' ] . '" class="' . $settings[ 'permalink-class' ] . '" title="' . $settings[ 'ep-goto-text' ] . $title_attribute . '">' . $image_src . '</a></div><!-- end image in title div -->' : '';
            $ep_title_image_right  = (!empty($epv[ 'align_with_title' ]) && $epv[ 'image_position' ] == 'right') ? '<div class="excerpt-image' . $image_border_class . ' excerpt-title-image-' . $epv[ 'image_position' ] . '" style="height:100%;float:' . $epv[ 'image_position' ] . ';"><a href="' . $ep_permalink . '" rel="' . $settings[ 'permalink-rel' ] . '" class="' . $settings[ 'permalink-class' ] . '" title="' . $settings[ 'ep-goto-text' ] . $title_attribute . '">' . $image_src . '</a></div><!-- end image in title div -->' : '';
            $ep_title_image_centre = (!empty($epv[ 'align_with_title' ]) && $epv[ 'image_position' ] == 'centre') ? '<div class="excerpt-image' . $image_border_class . ' excerpt-title-image-' . $epv[ 'image_position' ] . '" style="height:100%;float:left;"><a href="' . $ep_permalink . '" rel="' . $settings[ 'permalink-rel' ] . '" class="' . $settings[ 'permalink-class' ] . '" title="' . $settings[ 'ep-goto-text' ] . $title_attribute . '">' . $image_src . '</a></div><!-- end image in title div -->' : '';
          } else {
            $ep_permalink          = '';
            $title_attribute       = '';
            $ep_title_image_left   = ($epv[ 'align_with_title' ] && $epv[ 'image_position' ] == 'left') ? '<div class="excerpt-image' . $image_border_class . ' excerpt-title-image-' . $epv[ 'image_position' ] . '" style="height:100%;float:' . $epv[ 'image_position' ] . ';">' . $image_src . '</div><!-- end image in title div -->' : '';
            $ep_title_image_right  = ($epv[ 'align_with_title' ] && $epv[ 'image_position' ] == 'right') ? '<div class="excerpt-image' . $image_border_class . ' excerpt-title-image-' . $epv[ 'image_position' ] . '" style="height:100%;float:' . $epv[ 'image_position' ] . ';">' . $image_src . '</div><!-- end image in title div -->' : '';
            $ep_title_image_centre = ($epv[ 'align_with_title' ] && $epv[ 'image_position' ] == 'centre') ? '<div class="excerpt-image' . $image_border_class . ' excerpt-title-image-' . $epv[ 'image_position' ] . '" style="height:100%;float:left;">' . $image_src . '</div><!-- end image in title div -->' : '';
          }


          // Setup cell container css
          $ep_behind_no_image = '';
          $ep_tintval         = '';
          $ep_tint            = '';
          if ($settings[ 'image-location' ] == 'behind') {
            $ep_behind_no_image = ($has_usable_image) ? '' : ' no-image';
            // $ep_tintval = ($has_usable_image) ? $settings['ep-tint'] : 'tint-00';
            //     $ep_tint_opacity = substr('80'.$settings['ep-tint'],-2);
            $ep_tint_colour         = (!$settings[ 'ep-title-tint-colour' ]) ? '#000000' : (is_array($settings[ 'ep-title-tint-colour' ]) ? '#' . $settings[ 'ep-title-tint-colour' ][ 'hex' ] : $settings[ 'ep-title-tint-colour' ]);
            $ep_behind_title_colour = (!$settings[ 'ep-title-text-colour' ]);

            //    $ep_bgcolour = ep_HexToRGB($ep_tint_colour);
            //    $ep_tint = 'background:rgba('.$ep_bgcolour['r'].','.$ep_bgcolour['g'].','.$ep_bgcolour['b'].','.$ep_tint_opacity/100.');';
            $ep_tint = 'background:' . $ep_tint_colour . ';opacity:' . ($settings[ 'ep-tint' ] / 100) . ';filter:alpha(opacity=' . $settings[ 'ep-tint' ] . ');';
          }

          // Setup CSS if post is sticky and stickies are at the top
          $ep_sticky_css = ($settings[ 'include-stickies' ] && is_sticky(get_the_ID())) ? ' ep-sticky-post' : null;
          $ep_sticky_css .= (is_sticky(get_the_ID())) ? ' ep-any-sticky-post' : null;

          if ($epv[ 'excerpt_first_then_list' ] && $excerpt_count > $settings[ 'excerpt-first-count' ]) {
            // reset all to none except one
            $settings[ 'ep-cellrow1' ]    = '%title%';
            $settings[ 'ep-cellrow2' ]    = '';
            $settings[ 'ep-cellrow3' ]    = '';
            $settings[ 'ep-cellrow4' ]    = '';
            $settings[ 'ep-cellrow5' ]    = '';
            $settings[ 'ep-cell-footer' ] = '';
            $settings[ 'title-bullet' ]   = $ep_bullet_was;
            $settings[ 'image-location' ] = 'none';
            $has_usable_image             = false;
            $ep_title_image_left          = '';
            $ep_col1_width                = 0;
            $ep_title_image_right         = '';
            $ep_col3_width                = 0;
            $ep_col2_width                = $epv[ 'cont_width' ];
            $ep_title_class               = 'excerpt-first-now-list';
          } elseif ($epv[ 'excerpt_first_then_list' ] && $excerpt_count <= $settings[ 'excerpt-first-count' ]) {
            $ep_bullet_was              = $settings[ 'title-bullet' ];
            $settings[ 'title-bullet' ] = '';
            $ep_title_class             = 'excerpt-first-title';
          } else {
            $ep_title_class = 'stock-title';
          }

          /*********************************************************
           * SETUP custom fields values
           *********************************************************/
          $ep_cellrows_array      = array($settings[ 'ep-cellrow1' ],
                                          $settings[ 'ep-cellrow2' ],
                                          $settings[ 'ep-cellrow3' ],
                                          $settings[ 'ep-cellrow4' ],
                                          $settings[ 'ep-cellrow5' ],
                                          $settings[ 'ep-cell-footer' ]);
          $ep_custom_fields_array = array('%custom1%', '%custom2%', '%custom3%');
          $display_custom_fields  = array_intersect($ep_cellrows_array, $ep_custom_fields_array);
          if (!empty($display_custom_fields)) {
//					 echo '<div class="ep-custom-field ep-custom-field-'.$x.'">' . $ep_array['custom1'] . '</div>';
            foreach ($display_custom_fields as $ep_custom_field_group) {

              switch ($ep_custom_field_group) {
                case '%custom1%' :
                  $ep_custom1 = ep_build_custom_fields($settings, 1);
                  break;
                case '%custom2%' :
                  $ep_custom2 = ep_build_custom_fields($settings, 2);
                  break;
                case '%custom3%' :
                  $ep_custom3 = ep_build_custom_fields($settings, 3);
                  break;
              }

            }
          }
          // ------------------------------------------------------------------------------------------------------
          // END LOOP VARIABLES SETUP
          // ------------------------------------------------------------------------------------------------------


          ob_start();
          // ===================================================================================================================
          // ===================================================================================================================
          // MAIN LAYOUT STARTS HERE
          // ===================================================================================================================
          // ===================================================================================================================
          if ($excerpt_row === 1) {
            $use_slider = (!$settings[ 'use-slider' ]) ? 'noslider' : 'slider';
            echo '<div class="excerpts-plus-row' . $epv[ 'bottom_border_class' ] . ' ' . $use_slider . '-slide" style="' . $epv[ 'row_bottom_margin' ] . '">';
          }

          $pzep_image_behind = '';
          if ($settings[ 'image-location' ] == 'behind') {
            //Make the entire excerpt the height of the image.
            $excerpt_height                     = 'height:' . $settings[ 'image-height' ] . 'px;';
            $epv[ 'excerpt_width_css' ]         = ($epv[ 'number_across' ] == 1) ? 'width:' . ($epv[ 'ep_image_width' ]) . 'px;' : 'width:' . ($epv[ 'excerpt_width' ]) . 'px;';
            $epv[ 'percent_excerpt_width_css' ] = ($epv[ 'number_across' ] == 1) ? 'width:100%;' : 'width:' . ($epv[ 'percent_excerpt_width' ]) . '%;';

            echo '<div class="excerpts-plus-excerpt excerpts-plus-excerpt-behind' . $image_border_class . $ep_sticky_css
                . ' '
                . $excerpt_margin_class . '"
						style="' . $excerpt_height . $epv[ 'percent_excerpt_width_css' ]
                . $excerpt_right_margin
                . $settings[ 'ep-style-cell-wrapper' ]
                . ';'
//							.$epv['excerpt_cell_padding']
                . '">';

            //Get image behind. Will show later
            if (!$settings[ 'ep-dont-link' ] && !ep_is_scheduled()) {
              $pzep_image_behind = '<a href="' . $ep_permalink . '" rel="' . $settings[ 'permalink-rel' ] . '" class="ep-the-image is-behind ' . $settings[ 'permalink-class' ] . '" title="' . $settings[ 'ep-goto-text' ] . $title_attribute . '">' . str_replace('img class="pzep_image" src', 'img class="pzep_image excerpts-plus-image-behind" src', $image_src) . '</a>';
            } else {
              $pzep_image_behind = str_replace('img class="pzep_image" src', 'img class="pzep_image excerpts-plus-image-behind" src', $image_src);
            }
          } else {
            echo '<div class="excerpts-plus-excerpt' . $ep_sticky_css . ' ' . $excerpt_margin_class . '" style="' . $epv[ 'percent_excerpt_width_css' ] . $excerpt_right_margin . ';'
//					.$epv['excerpt_cell_padding']
                . $settings[ 'ep-style-cell-wrapper' ]
                . ';' . (!empty($epv[ 'content_border' ]) ? $epv[ 'content_border' ] : '') . ';' . (($is_excerpt) ? $epv[ 'ep-excerpt-height' ] : null) . '">';
          }

          $ep_new_image_width = substr($image_src, strpos($image_src, '-width') + 6);
          $ep_new_image_width = substr($ep_new_image_width, 0, strpos($ep_new_image_width, 'px.'));

          //	var_dump($ep_new_image_width);
          //,strpos($image_src,'W.'));
          $ep_array = array(
              'show-excerpt'        => (!empty($show_excerpt) ? $show_excerpt : ''),
              'the-excerpt-to-show' => str_replace('%readmorestr%', $read_more, $the_excerpt_to_show),
              'content-class'       => $ep_content_class,
              'image-border-class'  => $image_border_class,
              'imagewidth'          => $ep_new_image_width,
              //    				'image-src' => ((!$is_excerpt && $settings['ep-images-hide-on-content']!='on')?null:$image_src),
              'image-src'           => str_replace(array('http:','http:'),'',$image_src),
              'meta1'               => $meta,
              'meta1_right'         => $meta_right,
              'meta2'               => $meta_below,
              'meta2_right'         => $meta_below_right,
              'meta3'               => $meta_three_left,
              'meta3_right'         => $meta_three_right,
              'custom1'             => (isset($ep_custom1) ? $ep_custom1 : null),
              'custom2'             => (isset($ep_custom2) ? $ep_custom2 : null),
              'custom3'             => (isset($ep_custom3) ? $ep_custom3 : null),
              'title-width'         => $ep_title_width,
              'extra-title-class'   => $excerpt_title_extra_class,
              'has-usable-image'    => $has_usable_image,
              'image-position'      => $epv[ 'image_position' ],
              'align-excerpt'       => $settings[ 'align-excerpt' ],
              'permalink'           => $ep_permalink,
              'title-attribute'     => $title_attribute,
              'image-caption'       => (!empty($ep_image_caption) ? $ep_image_caption : ''),
              'is-excerpt'          => $is_excerpt,
              'ep-cell-bg-css'      => '',
              'ep-title-class'      => $ep_title_class
          );


          // Show the excerpt content!
          $fixed_height = ($settings[ 'image-location' ] == 'behind') ? 'height:100%;' : null;

          // CELL
          echo '<div class="ep-cell cell-no-', $cell_no, ' cell-no-', $cell_no, '-block-id-', $block[ 'id' ], ' ', $ep_behind_no_image, ' valign-', $ep_valign, ( ep_is_scheduled()?' ep-scheduled':''),'" style="', $fixed_height . $settings[ 'ep-style-cell' ], '">';
          echo $pzep_image_behind;
          // CELL CONTAINER
          $pzep_slide_content = ($settings[ 'ep-slide-content' ]) ? 'slide-content' : '';
          echo '<div class="ep-cell-container valign-', $ep_valign, ' ', $pzep_slide_content, ' tint-bg" ', (($has_usable_image) ? 'style="' . $ep_tint . '"' : null), '>';

          // if ( $has_usable_image ) {
          // 	echo '<div class="ep-cell-content-underlay" ></div>';
          // }
          // COLUMN 1
          echo '<div class="ep-cellcol1" style="width:', ($ep_col1_width / ($ep_col1_width + $ep_col2_width + $ep_col3_width) * 100), '%">', $ep_title_image_left;
          if ($ep_title_image_left && $settings[ 'ep-image-captions' ] && !$ep_array[ 'is-excerpt' ] && $epv[ 'image_position' ] == 'left') {
            echo '<div class="ep-image-caption">', $ep_array[ 'image-caption' ], '</div>';
          }
          echo '</div><!-- end ep-cellcol1  -->';
          // COLUMN 2
          echo '<div class="ep-cellcol2" style="width:', ($ep_col2_width / ($ep_col1_width + $ep_col2_width + $ep_col3_width) * 100), '%">';
          do_action('ep_before_cellrow1', $settings[ 'ep-before-cellrow1' ]);

          // COL2 - ROW 1
          echo '<div class="ep-cellrow1" style="', $settings[ 'ep-style-cellrow1' ], '">';
          self::ep_show($settings[ 'ep-cellrow1' ], $ep_array, $settings);
          echo '</div><!-- end ep-cellrow1 -->';
          do_action('ep_after_cellrow1', $settings[ 'ep-after-cellrow1' ]);

          // COL2 - ROW 2
          echo '<div class="ep-cellrow2" style="', $settings[ 'ep-style-cellrow2' ], '">';
          self::ep_show($settings[ 'ep-cellrow2' ], $ep_array, $settings);
          echo '</div><!-- end ep-cellrow2 -->';
          do_action('ep_after_cellrow2', $settings[ 'ep-after-cellrow2' ]);

          // COL2 - ROW 3
          echo '<div class="ep-cellrow3" style="', $settings[ 'ep-style-cellrow3' ], '">';
          self::ep_show($settings[ 'ep-cellrow3' ], $ep_array, $settings);
          echo '</div><!-- end ep-cellrow3 -->';
          do_action('ep_after_cellrow3', $settings[ 'ep-after-cellrow3' ]);

          // COL2 - ROW 4
          echo '<div class="ep-cellrow4" style="', $settings[ 'ep-style-cellrow4' ], '">';
          self::ep_show($settings[ 'ep-cellrow4' ], $ep_array, $settings);
          echo '</div><!-- end ep-cellrow4 -->';
          do_action('ep_after_cellrow4', $settings[ 'ep-after-cellrow4' ]);

          // COL2 - ROW 5
          echo '<div class="ep-cellrow5" style="', $settings[ 'ep-style-cellrow5' ], '">';
          self::ep_show($settings[ 'ep-cellrow5' ], $ep_array, $settings);
          echo '</div><!-- end ep-cellrow5 -->';
          do_action('ep_after_cellrow5', $settings[ 'ep-after-cellrow5' ]);

          echo '</div> <!-- end eb-cellcol2 -->';

          // COLUMN 3
          echo '<div class="ep-cellcol3" style="width:', ($ep_col3_width / ($ep_col1_width + $ep_col2_width + $ep_col3_width) * 100), '%">'
          , $ep_title_image_right;
          if ($ep_title_image_right && $settings[ 'ep-image-captions' ] && !$ep_array[ 'is-excerpt' ] && $epv[ 'image_position' ] == 'right') {
            echo '<div class="ep-image-caption">', $ep_array[ 'image-caption' ], '</div>';
          }
          echo '</div><!-- end eb-cellcol3 -->';
          echo '</div> <!-- end ep-cell-container -->';

          echo '</div> <!-- end ep-cell -->';

          if (isset($settings[ 'ep-cell-footer' ]) && $settings[ 'ep-cell-footer' ]) {

            // CELL FOOTER
            echo '<div class="ep-cell-footer" style="', $settings[ 'ep-style-cell-footer' ], '">';
            self::ep_show($settings[ 'ep-cell-footer' ], $ep_array, $settings);
            echo '</div><!-- end ep-cell-footer -->';
            do_action('ep_after_cell-footer', (!empty($settings[ 'ep-after-cell-footer' ]) ? $settings[ 'ep-after-cell-footer' ] : null));
          }

          echo '</div><!-- .excerpts-plus-excerpt -->'; // end div exerpts-plus-excerpt


          $need_div = true; // Used when need an extra close div when not enough excerpts to complete row
          if ($excerpt_row == $epv[ 'number_across' ]) {
            // Need a clear div in here
            // except it did bugger all
            // echo '<div class="pzep-cleardiv"></div>';
            echo '</div><!-- .excerpts-plus-row -->';
            $excerpt_row = 0;
            $need_div    = false;
          }


          //Make sure the loop stops when it's supposed to
          // check this... is it necessary? shouldn't query handle this anyways?
          // check post-limit to set closing div
          if ($excerpt_count == $epv[ 'number_to_show' ]) {
            break;
          }


          // If excerpt count is 1,, and using excerpt first then list, then reset approrpriate varialbes
          // excerpt no
          // bullets yes
          // image no
          // if ($epv['excerpt_first_then_list']) {
          //  $settings['show-title'] = true;
          //  $settings['title-bullet'] = '#8226; ';
          //  $settings['title-size'] = '13';
          //  $settings['show-excerpt'] = false;
          //  $settings['meta'] = '';
          //  $settings['meta-below'] = '';
          //  $settings['image-location'] = 'none';
          //  $epv['bottom_border_class'] = ' excerpts-plus-row-no-border  ep-title-only ';
          //
          // }

          ob_end_flush();
        } // End While


        if (!empty($settings[ 'dont-show-errors' ])) {
          echo $ep_error[ 'cache' ];
          echo $ep_error[ 'nextgen' ];
          echo $ep_error[ 'dimensions' ];
          echo $ep_error[ 'publish-again' ];
        }

        // Add end div for excerpts row when row ends early
        if (($excerpt_row < $epv[ 'number_across' ] && $need_div) && $excerpt_count != 0) {
          echo '</div><!-- .excerpts-plus-row -->';
        }


        if ($settings[ 'use-slider' ]) {
          echo '</div> <!-- end of slider div -->';
        }


        // Display footer link to
        if ($settings[ 'link-to-text' ] != '' && $settings[ 'link-to-link' ] != '') {
          echo '<div class="featured-entry-content"><a href="' . $settings[ 'link-to-link' ] . '" class="more-link  excerpt-linkto">' . $settings[ 'link-to-text' ] . '</a></div><!-- end more link div -->';
        }

        // PAGINATION
        // Disable pagination for now
        //   if ($epv['use_pagination'] && !$settings['use-slider'] && true===false) {
        if (!empty($epv[ 'use_pagination' ]) && !$settings[ 'use-slider' ]) {
          if (function_exists('wp_pagenavi') && !empty($settings[ 'use-pagenavi' ])) {
            echo '<div class="nav-below navigation">';
            wp_pagenavi();
            echo '</div><!-- end nav-below navigation  -->';
          } else {
            //    $next = get_next_posts_link(apply_filters('upfront_older_posts_link', '<span class="meta-nav">&laquo;</span> Previous'));
            //    $previous = get_previous_posts_link(apply_filters('upfront_newer_posts_link', 'Next <span class="meta-nav">&raquo;</span>'));
            $next     = get_next_posts_link(__('<span class="meta-nav">' . $settings[ 'ep-page-prev' ] . '</span>', 'UpFront'));
            $previous = get_previous_posts_link(__('<span class="meta-nav">' . $settings[ 'ep-page-next' ] . '</span>', 'UpFront'));
            echo '<div class="nav-below navigation">';
            if ($next) {
              echo '<div class="nav-previous ep-nav" style="' . $settings[ 'ep-style-nav' ] . '">';
              echo $next;
              echo '</div><!-- end nav-previous -->';
            }
            if ($previous) {
              echo '<div class="nav-next ep-nav" style="' . $settings[ 'ep-style-nav' ] . '">';
              echo $previous;
              echo '</div><!-- end nav-next -->';
            }
            echo '</div><!-- end nav-below navigation  -->';
          }
        }


        //Else If there are no posts display message
      } else {
        echo '<div class="excerpt-content entry-content">';
        switch ($settings[ 'ep-empty-behaviour' ]) {
          case 'hide' :
            //	pzdebug( get_the_date() );
            //		pzdebug( get_the_id() );
            //		pzdebug( get_the_title() );
            //	break;

            echo '<script type="text/javascript">
						jQuery(document).ready(function() {
							jQuery("#block-' . $block[ 'id' ] . '").hide();
						});
						</script>';
            break;

          case 'message':
          default:
            echo '<p>' . stripslashes($settings[ 'no-content' ]) . '</p>';
            break;
        }
        echo '</div>';
      }
      do_action('ep_bottom_of_block', $settings[ 'ep-bottom-of-block' ]);
      echo '</div><!-- .excerpts-plus -->'; // end div excerpts-plus
      // PAGINATION RELATED
      // Reset $wp_query
      // woot! this bugger was causing the member function fatal
      // $wp_query = null;
      $wp_query = $original_wp_query;
      // removed after null prob fixed. may need to be reinstated one day
      // Reinstated after conflict with breadcrumbs and related posts plugin
      wp_reset_postdata();
      //Added 11/8/13 so can display multiple blocks on single post page with single post's content
      rewind_posts();
      EPFunctions::php_debug('Block: ' . $block[ 'id' ] . ' : Content end');
      unset($settings, $epv);
    }

    /**
     *
     * @param type $show_what
     * @param type $ep_array
     * @param type $settings
     */
    static function ep_show($show_what, $ep_array, $settings)
    {

      // Setup styles for when image behind
      $ep_content_style = ($ep_array[ 'has-usable-image' ] && !empty($settings[ 'ep-body-text-colour' ]) && $settings[ 'image-location' ] == 'behind') ? 'color:' . $settings[ 'ep-body-text-colour' ] . '!important' : null;
      $ep_title_style   = ($ep_array[ 'has-usable-image' ] && !empty($settings[ 'ep-title-text-colour' ]) && $settings[ 'image-location' ] == 'behind') ? 'style="color:' . $settings[ 'ep-title-text-colour' ] . '!important"' : null;

      switch ($show_what) {

        // ----------------------
        // TITLE
        // ----------------------
        case '%title%':

          $ep_alternate_title = (!empty($settings[ 'ep-hw-alt-titles' ])) ? UpFrontLayoutOption::get(get_the_id(), 'alternate-title', false, true) : null;
          $ep_post_title      = (isset($ep_alternate_title) && $ep_alternate_title) ? $ep_alternate_title : get_the_title();
          // Display image in title
          if ($settings[ 'image-location' ] == 'title' && !$ep_array[ 'align-excerpt' ]) {
            echo '<div class="excerpt-image' . $ep_array[ 'image-border-class' ] . ' excerpt-title-image-' . $ep_array[ 'image-position' ] . '" style="height:100%;float:' . $ep_array[ 'image-position' ] . ';">';
            if (!$settings[ 'ep-dont-link' ] && !ep_is_scheduled()) {
              echo '<a href="' . $ep_array[ 'permalink' ] . '" rel="' . $settings[ 'permalink-rel' ] . '" class="ep-the-image-in-title ' . $settings[ 'permalink-class' ] . '" title="' . $settings[ 'ep-goto-text' ] . $ep_array[ 'title-attribute' ] . '">' . $ep_array[ 'image-src' ] . '</a>';
            } else {
              echo $ep_array[ 'image-src' ];
            }
            if ($settings[ 'ep-image-captions' ] && !$ep_array[ 'is-excerpt' ]) {
              echo '<div class="ep-image-caption">' . $ep_array[ 'image-caption' ] . '</div>';
            }
            echo '</div><!-- end image in title div -->';

          }
          // Display title
          echo '<div class="excerpt-title" style="' . $ep_array[ 'title-width' ] . ' ' . $ep_array[ 'ep-cell-bg-css' ] . '">';
          do_action('ep_before_title', $settings[ 'ep-before-title' ]);
          switch ($settings[ 'title-bullet' ]) {
            case 'thumb32':
              $bullet = '<span class="excerpt-title-bullet pzep-bullet-type-thumb32 pzep-thumb-square">' . get_the_post_thumbnail(get_the_ID(), array(32,
                                                                                                                                                      32)) . '</span> ';
              break;
            case 'thumb48':
              $bullet = '<span class="excerpt-title-bullet pzep-bullet-type-thumb48 pzep-thumb-square">' . get_the_post_thumbnail(get_the_ID(), array(48,
                                                                                                                                                      64)) . '</span> ';
              break;
            case 'thumb64':
              $bullet = '<span class="excerpt-title-bullet pzep-bullet-type-thumb64 pzep-thumb-square">' . get_the_post_thumbnail(get_the_ID(), array(64,
                                                                                                                                                      64)) . '</span> ';
              break;

            case 'thumb32c':
              $bullet = '<span class="excerpt-title-bullet pzep-bullet-type-thumb32 pzep-thumb-circle">' . get_the_post_thumbnail(get_the_ID(), array(32,
                                                                                                                                                      32)) . '</span> ';
              break;
            case 'thumb48c':
              $bullet = '<span class="excerpt-title-bullet pzep-bullet-type-thumb48 pzep-thumb-circle">' . get_the_post_thumbnail(get_the_ID(), array(48,
                                                                                                                                                      64)) . '</span> ';
              break;
            case 'thumb64c':
              $bullet = '<span class="excerpt-title-bullet pzep-bullet-type-thumb64 pzep-thumb-circle">' . get_the_post_thumbnail(get_the_ID(), array(64,
                                                                                                                                                      64)) . '</span> ';
              break;

            default:
              $bullet = '<span class="excerpt-title-bullet" >' .
                  (($settings[ 'title-bullet' ] == '' || $settings[ 'title-bullet' ] == 'none') ? null : '&' . $settings[ 'title-bullet' ]) . '</span> ';
              break;
          }
          echo '<h2 class="entry-title ' . $ep_array[ 'ep-title-class' ] . '">';
          if (!$settings[ 'ep-dont-link' ] && !ep_is_scheduled()) {
            echo '	<a href="' . $ep_array[ 'permalink' ] . '" rel="' . $settings[ 'permalink-rel' ] . '" class="ep-the-title ' . $settings[ 'permalink-class' ] . '" title="' . $settings[ 'ep-goto-text' ] . $ep_array[ 'title-attribute' ] . '" ' . $ep_title_style . '>';
          } else {
            echo '	<a ' . $ep_title_style . '>';
          }
          echo $bullet . $ep_post_title;
          echo '	</a>';
          echo '</h2>';
          do_action('ep_after_title', $settings[ 'ep-after-title' ]);
          echo '</div><!-- .hentry -->'; // end div hentry

          break;

        // ----------------------
        // META 1
        // ----------------------
        case '%meta1%':
          echo '<div class="ep-meta entry-meta ' . $ep_array[ 'ep-cell-bg-css' ] . '">';
          do_action('ep_before_meta1', $settings[ 'ep-before-meta1' ]);


          if ($ep_array[ 'meta1' ]) {
            echo '<div class="ep_meta1_left">' . $ep_array[ 'meta1' ] . '</div>';
          }
          if ($ep_array[ 'meta1_right' ]) {
            echo '<div class="ep_meta1_right">' . $ep_array[ 'meta1_right' ] . '</div>';
          }

          do_action('ep_after_meta1', $settings[ 'ep-after-meta1' ]);
          echo '</div><!-- end meta1 -->';

          break;

        // ----------------------
        // META 2
        // ----------------------
        case '%meta2%':
          echo '<div class="ep-meta entry-meta ' . $ep_array[ 'ep-cell-bg-css' ] . '">';
          do_action('ep_before_meta2', $settings[ 'ep-before-meta2' ]);

          if ($ep_array[ 'meta2' ]) {
            echo '<div class="ep_meta2_left">' . $ep_array[ 'meta2' ] . '</div>';
          }
          if ($ep_array[ 'meta2_right' ]) {
            echo '<div class="ep_meta2_right">' . $ep_array[ 'meta2_right' ] . '</div>';
          }

          do_action('ep_after_meta2', $settings[ 'ep-after-meta2' ]);
          echo '</div><!-- end meta2 -->';
          break;

        // ----------------------
        // META 3
        // ----------------------
        case '%meta3%':
          echo '<div class="ep-meta entry-meta ' . $ep_array[ 'ep-cell-bg-css' ] . '">';
          do_action('ep_before_meta3', $settings[ 'ep-before-meta3' ]);

          if ($ep_array[ 'meta3' ]) {
            echo '<div class="ep_meta3_left">' . $ep_array[ 'meta3' ] . '</div>';
          }
          if ($ep_array[ 'meta3_right' ]) {
            echo '<div class="ep_meta3_right">' . $ep_array[ 'meta3_right' ] . '</div>';
          }

          do_action('ep_after_meta3', $settings[ 'ep-after-meta3' ]);
          echo '</div><!-- end meta3 -->';
          break;

        // ----------------------
        // CUSTOM FIELD GROUP 1
        // ----------------------
        case '%custom1%':
          echo '<div class="ep-custom-fields-group ep-custom-fields-group1">';
          do_action('ep_before_custom1', (!empty($settings[ 'ep-before-custom1' ]) ? $settings[ 'ep-before-custom1' ] : ''));
          echo $ep_array[ 'custom1' ];
          do_action('ep_after_custom1', (!empty($settings[ 'ep-before-custom1' ]) ? $settings[ 'ep-before-custom1' ] : ''));
          echo '</div><!-- end custom field group 1 -->';
          break;

        // ----------------------
        // CUSTOM FIELD GROUP 2
        // ----------------------
        case '%custom2%':
          echo '<div class="ep-custom-fields-group ep-custom-fields-group2">';
          do_action('ep_before_custom2', (!empty($settings[ 'ep-before-custom2' ]) ? $settings[ 'ep-before-custom2' ] : ''));
          echo $ep_array[ 'custom2' ];
          do_action('ep_after_custom2', (!empty($settings[ 'ep-before-custom2' ]) ? $settings[ 'ep-before-custom2' ] : ''));
          echo '</div><!-- end custom field group 2 -->';
          break;

        // ----------------------
        // CUSTOM FIELD GROUP 3
        // ----------------------
        case '%custom3%':
          echo '<div class="ep-custom-fields-group ep-custom-fields-group3">';
          do_action('ep_before_meta3', (!empty($settings[ 'ep-before-custom3' ]) ? $settings[ 'ep-before-custom3' ] : ''));
          echo $ep_array[ 'custom3' ];
          do_action('ep_after_meta3', (!empty($settings[ 'ep-before-custom3' ]) ? $settings[ 'ep-before-custom3' ] : ''));
          echo '</div><!-- end custom field group 3 -->';
          break;


        // ----------------------
        // IMAGE
        // ----------------------
        case '%image%':
          if ($ep_array[ 'has-usable-image' ] && $settings[ 'image-location' ] != 'behind') {
            echo '<div class="excerpt-big-image' . $ep_array[ 'image-border-class' ] . '" style="height:' . ($settings[ 'image-height' ] + 6) . 'px;">';
            do_action('ep_before_image', $settings[ 'ep-before-image' ]);

            if (!$settings[ 'ep-dont-link' ] && !ep_is_scheduled()) {
              echo '<a href="' . $ep_array[ 'permalink' ] . '" rel="' . $settings[ 'permalink-rel' ] . '" class="ep-the-image ' . $settings[ 'permalink-class' ] . '" title="' . $settings[ 'ep-goto-text' ] . $ep_array[ 'title-attribute' ] . '">' . $ep_array[ 'image-src' ] . '</a>';
            } else {
              echo $ep_array[ 'image-src' ];
            }
            do_action('ep_after_image', $settings[ 'ep-after-image' ]);
            echo '</div><!-- end image -->';
          }
          break;

        // ----------------------
        // CONTENT
        // ----------------------
        case '%content%':
          echo '<div class="hentry excerpt-entry ' . $ep_array[ 'content-class' ] . ' ' . $ep_array[ 'ep-cell-bg-css' ] . '" ' . (($settings[ 'excerpt-or-content' ] == 'excerpt' && $settings[ 'ep-excerpt-content-height' ] > 0 && $settings[ 'ep_use_dotdotdot' ]) ? 'style="height:' . $settings[ 'ep-excerpt-content-height' ] . 'px;"' : null) . '>';
          do_action('ep_before_content', $settings[ 'ep-before-content' ]);

          // Put image in content
          //var_dump(  $ep_array['image-src']);
          if (($settings[ 'image-location' ] == 'content' && $ep_array[ 'is-excerpt' ]) ||
              ($settings[ 'image-location' ] == 'content' && $settings[ 'ep-images-hide-on-content' ] == 'on' && !$ep_array[ 'is-excerpt' ])
          ) {
            if ($ep_array[ 'has-usable-image' ]) {
              echo '<div class="image-display-' . $ep_array[ 'image-position' ] . $ep_array[ 'image-border-class' ] . '" style="float:' . $ep_array[ 'image-position' ] . ';width:' . $ep_array[ 'imagewidth' ] . 'px;">';
              if (!$settings[ 'ep-dont-link' ] && !ep_is_scheduled()) {
                echo '<a href="' . $ep_array[ 'permalink' ] . '" rel="' . $settings[ 'permalink-rel' ] . '" class="ep-the-image-in-content ' . $settings[ 'permalink-class' ] . '" title="' . $settings[ 'ep-goto-text' ] . $ep_array[ 'title-attribute' ] . '">' . $ep_array[ 'image-src' ] . '</a>';
              } else {
                echo $ep_array[ 'image-src' ];
              }
              if ($settings[ 'ep-image-captions' ] && !$ep_array[ 'is-excerpt' ]) {
                echo '<div class="ep-image-caption">' . $ep_array[ 'image-caption' ] . '</div>';
              }

              echo '</div><!-- end content image -->';
            }
          }

          // Display excerpt content
          echo '<div class="excerpt-content" style="' . $ep_array[ 'show-excerpt' ] . $ep_content_style . '">';
          //var_dump($ep_array['the-excerpt-to-show']);
          echo (ep_is_scheduled()?wp_strip_all_tags($ep_array[ 'the-excerpt-to-show' ]):$ep_array[ 'the-excerpt-to-show' ]);
          echo '</div><!-- .excerpt-content -->';

          do_action('ep_after_content', $settings[ 'ep-after-content' ]);

          echo '</div><!-- .hentry -->'; // end div hentry
          break;
      }
    }


  }

// End class

  /*
  * Function: eplus_shortcode
  * Purpose: Display an eplus block using a shortcode. This takes an id plus any parameters you want to override or extend (if possible)
  */
  function eplus_shortcode($args, $content = null)
  {
    global $pzep_shortcode_atts;
    // we need to make the stuff besides the ID available to the display content part of eplus
    $pzep_shortcode_atts = $args;
    // Need to call a block, but which one?
    // Maybe three parameters to start with with only ID compulsory... id=nnn, tax=xxxx terms=yyyy

    $block = UpFrontBlocksData::get_block($args[ 'id' ]);
    if (method_exists('UpFrontBlocksData', 'get_legacy_id')) {
      $block[ 'id' ] = UpFrontBlocksData::get_legacy_id($block);
    }

    // start capturing output to buffer.
    // coz shortcodes like to return the content to display
    ob_start();

    UpFrontBlocks::display_block(UpFrontBlocksData::get_block($block[ 'id' ]));

    // flush the buffer and save it. Probably could do this straight in the return to save memory.
    $buffer = ob_get_flush();

    return $buffer;

  }


  /*
   * To display the shortcode dynamically on a category page and append the taxonomy
   <?php
      $queried_object = get_queried_object();
      $queried_object->name;
      echo '<h2>Featured Listings for '.$queried_object->name.'</h2>';
      $conditions = htmlentities(json_encode(array('condition1'=>array('field'=>'ep-taxonomies','type'=>'multiselect','value'=> $queried_object->taxonomy.':'.$queried_object->slug))));
      do_shortcode("[excerptsplus id=15 conditions=$conditions]");
      ?>

   */

  add_shortcode('excerptsplus', 'eplus_shortcode');

