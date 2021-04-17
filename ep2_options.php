<?php

// Setup all block options
  class UpFrontExcerptsPBlockOptions extends UpFrontBlockOptionsAPI
  {

    public $pzep_custom_fields = array();
    public $inputs = array();
    public $tabs = array();
    public $tab_notices = array();
    public $open_js_callbackx = '
//					if ($(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-ep-days-to-show\').val() > 0) {
//						$(\'div#block-\' + blockID + \'-tab div#sub-tab-filters-content #input-ep-date-to-end\').show();
//					} else {
//						$(\'div#block-\' + blockID + \'-tab div#sub-tab-filters-content #input-ep-date-to-end\').hide();
//					}
					if ($(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-ep-block-title\').val() != \'\') {
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-titles-content #input-ep-block-title-link\').show();
					} else {
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-titles-content #input-ep-block-title-link\').hide();
					}
					if ($(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-link-to-text\').val() != \'\') {
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-titles-content #input-link-to-link\').show();
					} else {
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-titles-content #input-link-to-link\').hide();
					}
					if ( $(\'div#block-\' + blockID + \'-tab\').find(\'#input-use-slider span.checkbox-checked\').length == 0 ) {
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-sliders-content #input-slide-time\').hide();
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-sliders-content #input-transition-type\').hide();
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-sliders-content #input-transition-time\').hide();
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-sliders-content #input-pager-type\').hide();
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-sliders-content #input-background-type\').hide();
					} else {
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-sliders-content #input-slide-time\').show();
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-sliders-content #input-transition-type\').show();
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-sliders-content #input-transition-time\').show();
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-sliders-content #input-pager-type\').show();
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-sliders-content #input-background-type\').show();
					}
					var cellrows = $(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-ep-cellrow1\').val() +
												$(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-ep-cellrow2\').val() +
												$(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-ep-cellrow3\').val() +
												$(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-ep-cellrow4\').val() +
												$(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-ep-cellrow5\').val() +
												$(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-ep-cell-footer\').val() ;
					if (cellrows.indexOf(\'meta\') >= 0 ) {
						$(\'div#block-\' + blockID + \'-tab li#sub-tab-meta\').show();
					} else {
						$(\'div#block-\' + blockID + \'-tab li#sub-tab-meta\').hide();
					}
					if ($(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-image-location\').val() == \'behind\') {
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-images-content #input-ep-content-align-behind\').show();
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-images-content #input-ep-image-behind-heading\').show();
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-images-content #input-ep-title-tint-colour\').show();
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-images-content #input-ep-title-text-colour\').show();
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-images-content #input-ep-body-text-colour\').show();
					} else {
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-images-content #input-ep-content-align-behind\').hide();
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-images-content #input-ep-image-behind-heading\').hide();
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-images-content #input-ep-title-tint-colour\').hide();
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-images-content #input-ep-title-text-colour\').hide();
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-images-content #input-ep-body-text-colour\').hide();
					}
					if ($(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-image-location\').val() == \'behind\' ||
							$(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-image-location\').val() == \'none\'
						) {
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-images-content #input-image-position\').hide();
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-images-content #input-ep-image-captions\').hide();
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-images-content #input-align-excerpt\').hide();
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-images-content #input-force-image-width\').show();
					} else {
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-images-content #input-image-position\').show();
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-images-content #input-ep-image-captions\').show();
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-images-content #input-align-excerpt\').show();
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-images-content #input-force-image-width\').hide();
					}
					if (($(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-image-location\').val() == \'behind\' ||
							$(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-image-location\').val() == \'none\') &&
							$(\'div#block-\' + blockID + \'-tab\').find(\'#input-force-image-width  span.checkbox-checked\').length == \'1\' 
						) {
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-images-content #input-image-width\').show();
					}
					if (($(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-image-location\').val() == \'behind\' ||
							$(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-image-location\').val() == \'none\') &&
							$(\'div#block-\' + blockID + \'-tab\').find(\'#input-force-image-width  span.checkbox-checked\').length != \'1\' 
						) {
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-images-content #input-image-width\').hide();
					}

					
				';

    function modify_arguments($args = false)
    {
      /// This is totally unnecessary, but allows for easier future changes if needed.
      $block = $args[ 'block' ];
      global $wpdb;

      //Get custom fields
      $pzep_cf_list = $wpdb->get_results(
          "SELECT meta_key FROM $wpdb->postmeta HAVING (meta_key NOT LIKE '\_blueprints%' AND meta_key NOT LIKE '_panels%' AND meta_key NOT LIKE '_hw%'  AND meta_key NOT LIKE '_wp_%' AND meta_key NOT LIKE '_format%' AND meta_key NOT LIKE '_edit%' AND meta_key NOT LIKE '_content%' AND meta_key NOT LIKE '_attachment%' AND meta_key NOT LIKE '_menu%' AND meta_key NOT LIKE '_oembed%' AND meta_key NOT LIKE '_publicize%' AND meta_key NOT LIKE '_thumbnail%' AND meta_key NOT LIKE 'pz%' AND meta_key NOT LIKE 'field_%') ORDER BY meta_key"
      );

      $ep_wppost_fields = array(
          'ID',
          'post_id',
          'post_author',
          'post_date',
          'post_date_gmt',
          'post_content',
          'post_title',
          'post_excerpt',
          'post_status',
          'comment_status',
          'ping_status',
          'post_password',
          'post_name',
          'to_ping',
          'pinged',
          'post_modified',
          'post_modified_gmt',
          'post_content_filtered',
          'post_parent',
          'guid',
          'menu_order',
          'post_type',
          'post_mime_type',
          'comment_count',
          'meta_id',
          'meta_key',
          'meta_value'
      );

      foreach ($pzep_cf_list as $pzep_cf) {
        if (in_array($pzep_cf->meta_key, $ep_wppost_fields) === false) {
          $pzep_custom_fields[ $pzep_cf->meta_key ] = $pzep_cf->meta_key;
        }
      }
      $this->tabs =
          array(
              'behaviour'     => 'Source',
              'structure'     => 'Layout',
              'titles'        => 'Labels',
              'content'       => 'Excerpts',
              'meta'          => 'Meta',
              'images'        => 'Images',
              'custom_fields' => 'Custom Fields',
              'sliders'       => 'Sliders',
              'developer'     => 'Developer',
              'info'          => 'Help',
          );

      $this->inputs =
          array(
              'info'          => self::ep_opt_info(),
              'structure'     => self::ep_opt_structure(),
              'behaviour'     => self::ep_opt_behaviour($block, 'no'),
              'titles'        => self::ep_opt_titles(),
              'content'       => self::ep_opt_content($block, 'no'),
              'meta'          => self::ep_opt_meta(),
              'custom_fields' => self::ep_opt_custom_fields($pzep_custom_fields),
              'images'        => self::ep_opt_images(),
              'sliders'       => self::ep_opt_sliders(),
              'developer'     => self::ep_opt_developer($pzep_custom_fields),
          );

      $this->tab_notices = array(
          'custom_fields' => 'Selected custom fields must be also available on the selected content type being displayed. Quite obvious, really!',
          'behaviour'     => 'Because a block can be used on multiple pages via mirroring or cascading, the following settings let you override the block\'s own settings when it is on single post page, results page or the front page.',
          'structure'     => 'These settings enable you to control the structure of each Excerpts+ cell. There are five rows and you can choose what appears in each. 
							Thus enabling you to easily control	the order the title, image, meta data and excerpt appear in.<br/>
							<strong>Note:</strong>If you set any cells to display Image, the image width will automatically default to the full width of the cell. 
							However, the cell image location it will be totally ignored unless the Image Location is set to "Use Structure Position".',
          'content'       => 'If you wish to have true Page excerpts, try the <a href="http://wordpress.org/extend/plugins/page-excerpt/" target=_blank>Page Excerpt plugin</a>. 
							If you wish to have styled excerpts, try the <a href="http://wordpress.org/extend/plugins/tinymce-excerpt//" target=_blank>TinyMCE Excerpt plugin</a>.',
          'filters'       => 'Date Filters start date uses the PHP strtotime function, so can take <a href="http://php.net/manual/en/datetime.formats.relative.php" target=_blank>relative dates</a> such as \'Last week\'. If you do use relative dates, do make sure you fully test your date string!',
          'meta'          => 'For help on formatting date and time, visit <a href="http://codex.wordpress.org/Formatting_Date_and_Time" target=_blank>WP date and time formats</a>.<br/><strong>Custom fields</strong> can be displayed in Meta areas using either PHP or in simple form, enclosing the field name in % symbols. e.g. %wpcf-expiry-date%',
          'sliders'       => 'Note: You may have to <strong>save and reload</strong> to see changes to the slider in the Visual Editor and on your page.',
          'developer'     => 'These are settings only developers will find a use for.<br/><strong>Hooks</strong> enable you to insert your own PHP or HTML code at specific points. This must be valid PHP (without the &lt;?php ?&gt;). Therefore, HTML must be echoed<br/><strong>Advanced Styling: </strong>You can style elements in the Design Editor, but if you want to apply advanced styling, such as from a <a href="http://www.colorzilla.com/gradient-editor/" target=_blank>Gradient Editor</a>, you can enter custom css properties for these elements.',
          'info'          => 'Excerpts+ version: ' . EPVERSION . '<br/>
							View <a href="https://s3.amazonaws.com/341public/LATEST/versioninfo/ep-changelog.html" target=_blank>Change Log</a><br/>
							Visit <a href="http://guides.pizazzwp.com/excerptsplus/about-excerpts/" target=_blank>ExcerptsPlus User Guide</a></br/>
							<strong>Support:</strong> Please log support requests to support@pizazzwp.com<br/>
							'
      );
//			'images'	=>	'<strong>Note:</strong> Even after Publishing, you may need to refresh your browser and/or <strong>Refresh the Image Cache</strong> (under WP Tools, Excerpts+ Tools menu) to see changes to image settings.',
// TODO : Add http://wordpress.org/extend/plugins/w3-total-cache/ recommendation if it checks out with G+
    }

    static function ep_opt_structure()
    {
      $cell_rows = array(
          'empty'     => 'Not used',
          '%title%'   => 'Title',
          '%meta1%'   => 'Meta line 1',
          '%meta2%'   => 'Meta line 2',
          '%meta3%'   => 'Meta line 3',
          '%content%' => 'Content/Excerpt',
          '%image%'   => 'Image',
          '%custom1%' => 'Custom fields group 1',
          '%custom2%' => 'Custom fields group 2',
          '%custom3%' => 'Custom fields group 3'
      );
      $settings  = array(
          'ep-structure-heading'      => array(
              'name'  => 'ep-structure-heading',
              'type'  => 'heading',
              'label' => 'Cell Structure'
          ),
          'ep-cellrow1'               => array(
              'type'      => 'select',
              'options'   => $cell_rows,
              'label'     => 'Cell row 1',
              'tooltip'   => 'Choose the content type you want to display from Title, Meta1, Image, Content/Excerpt, Meta2 and Meta3.',
              'default'   => '%title%',
              'name'      => 'ep-cellrow1',
              'callbackx' => '
					var cellrows = $(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-ep-cellrow1\').val() +
												$(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-ep-cellrow2\').val() +
												$(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-ep-cellrow3\').val() +
												$(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-ep-cellrow4\').val() +
												$(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-ep-cellrow5\').val() +
												$(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-ep-cell-footer\').val() ;
					if (cellrows.indexOf(\'content\') >= 0 ) {
						$(\'div#block-\' + blockID + \'-tab li#sub-tab-excerpts\').show();
					} else {
						$(\'div#block-\' + blockID + \'-tab li#sub-tab-excerpts\').hide();
					}
					if (cellrows.indexOf(\'meta\') >= 0 ) {
						$(\'div#block-\' + blockID + \'-tab li#sub-tab-meta\').show();
					} else {
						$(\'div#block-\' + blockID + \'-tab li#sub-tab-meta\').hide();
					}
				'
          ),
          'ep-cellrow2'               => array(
              'type'      => 'select',
              'options'   => $cell_rows,
              'label'     => 'Cell row 2',
              'tooltip'   => 'Choose the content type you want to display from Title, Meta1, Image, Content/Excerpt, Meta2 and Meta3.',
              'default'   => '%meta1%',
              'name'      => 'ep-cellrow2',
              'callbackx' => '
					var cellrows = $(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-ep-cellrow1\').val() +
												$(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-ep-cellrow2\').val() +
												$(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-ep-cellrow3\').val() +
												$(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-ep-cellrow4\').val() +
												$(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-ep-cellrow5\').val() +
												$(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-ep-cell-footer\').val() ;
					if (cellrows.indexOf(\'content\') >= 0 ) {
						$(\'div#block-\' + blockID + \'-tab li#sub-tab-excerpts\').show();
					} else {
						$(\'div#block-\' + blockID + \'-tab li#sub-tab-excerpts\').hide();
					}
					if (cellrows.indexOf(\'meta\') >= 0 ) {
						$(\'div#block-\' + blockID + \'-tab li#sub-tab-meta\').show();
					} else {
						$(\'div#block-\' + blockID + \'-tab li#sub-tab-meta\').hide();
					}
				'
          ),
          'ep-cellrow3'               => array(
              'type'      => 'select',
              'options'   => $cell_rows,
              'label'     => 'Cell row 3',
              'tooltip'   => 'Choose the content type you want to display from Title, Meta1, Image, Content/Excerpt, Meta2 and Meta3.',
              'default'   => '%content%',
              'name'      => 'ep-cellrow3',
              'callbackx' => '
					var cellrows = $(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-ep-cellrow1\').val() +
												$(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-ep-cellrow2\').val() +
												$(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-ep-cellrow3\').val() +
												$(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-ep-cellrow4\').val() +
												$(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-ep-cellrow5\').val() +
												$(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-ep-cell-footer\').val() ;
					if (cellrows.indexOf(\'content\') >= 0 ) {
						$(\'div#block-\' + blockID + \'-tab li#sub-tab-excerpts\').show();
					} else {
						$(\'div#block-\' + blockID + \'-tab li#sub-tab-excerpts\').hide();
					}
					if (cellrows.indexOf(\'meta\') >= 0 ) {
						$(\'div#block-\' + blockID + \'-tab li#sub-tab-meta\').show();
					} else {
						$(\'div#block-\' + blockID + \'-tab li#sub-tab-meta\').hide();
					}
				'
          ),
          'ep-cellrow4'               => array(
              'type'      => 'select',
              'options'   => $cell_rows,
              'label'     => 'Cell row 4',
              'tooltip'   => 'Choose the content type you want to display from Title, Meta1, Image, Content/Excerpt, Meta2 and Meta3.',
              'default'   => '%meta2%',
              'name'      => 'ep-cellrow4',
              'callbackx' => '
					var cellrows = $(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-ep-cellrow1\').val() +
												$(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-ep-cellrow2\').val() +
												$(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-ep-cellrow3\').val() +
												$(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-ep-cellrow4\').val() +
												$(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-ep-cellrow5\').val() +
												$(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-ep-cell-footer\').val() ;
					if (cellrows.indexOf(\'content\') >= 0 ) {
						$(\'div#block-\' + blockID + \'-tab li#sub-tab-excerpts\').show();
					} else {
						$(\'div#block-\' + blockID + \'-tab li#sub-tab-excerpts\').hide();
					}
					if (cellrows.indexOf(\'meta\') >= 0 ) {
						$(\'div#block-\' + blockID + \'-tab li#sub-tab-meta\').show();
					} else {
						$(\'div#block-\' + blockID + \'-tab li#sub-tab-meta\').hide();
					}
				'
          ),
          'ep-cellrow5'               => array(
              'type'      => 'select',
              'options'   => $cell_rows,
              'label'     => 'Cell row 5',
              'tooltip'   => 'Choose the content type you want to display from Title, Meta1, Image, Content/Excerpt, Meta2 and Meta3.',
              'default'   => 'empty',
              'name'      => 'ep-cellrow5',
              'callbackx' => '
					var cellrows = $(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-ep-cellrow1\').val() +
												$(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-ep-cellrow2\').val() +
												$(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-ep-cellrow3\').val() +
												$(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-ep-cellrow4\').val() +
												$(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-ep-cellrow5\').val() +
												$(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-ep-cell-footer\').val() ;
					if (cellrows.indexOf(\'content\') >= 0 ) {
						$(\'div#block-\' + blockID + \'-tab li#sub-tab-excerpts\').show();
					} else {
						$(\'div#block-\' + blockID + \'-tab li#sub-tab-excerpts\').hide();
					}
					if (cellrows.indexOf(\'meta\') >= 0 ) {
						$(\'div#block-\' + blockID + \'-tab li#sub-tab-meta\').show();
					} else {
						$(\'div#block-\' + blockID + \'-tab li#sub-tab-meta\').hide();
					}
				'
          ),
          'ep-cell-footer'            => array(
              'type'      => 'select',
              'options'   => $cell_rows,
              'label'     => 'Cell footer',
              'tooltip'   => 'Choose the content type you want to display from Title, Meta1, Image, Content/Excerpt, Meta2 and Meta3 at the foot of the cell.',
              'default'   => 'empty',
              'name'      => 'ep-cell-footer',
              'callbackx' => '
					var cellrows = $(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-ep-cellrow1\').val() +
												$(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-ep-cellrow2\').val() +
												$(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-ep-cellrow3\').val() +
												$(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-ep-cellrow4\').val() +
												$(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-ep-cellrow5\').val() +
												$(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-ep-cell-footer\').val() ;
					if (cellrows.indexOf(\'content\') >= 0 ) {
						$(\'div#block-\' + blockID + \'-tab li#sub-tab-excerpts\').show();
					} else {
						$(\'div#block-\' + blockID + \'-tab li#sub-tab-excerpts\').hide();
					}
					if (cellrows.indexOf(\'meta\') >= 0 ) {
						$(\'div#block-\' + blockID + \'-tab li#sub-tab-meta\').show();
					} else {
						$(\'div#block-\' + blockID + \'-tab li#sub-tab-meta\').hide();
					}
				'
          ),
          'ep-behaviour-heading'      => array(
              'name'  => 'ep-behaviour-heading',
              'type'  => 'heading',
              'label' => 'Behaviours'
          ),
          'ep-excerpt-or-content'     => array(
              'type'    => 'select',
              'options' => array(
                  'excerpt'        => 'Excerpt only',
                  'styled-excerpt' => 'Styled Excerpt (if available)',
                  'content'        => 'Full Content'
              ),
              'label'   => 'Show full content or excerpt only',
              'tooltip' => 'Choose if you want to show the Excerpt or the full content for all. This does not over-ride the number to show as <strong>full width</strong> content.<br/>The Styled Excerpt option wil not trim to the excerpt length and is useful if you are using a plugin like TinyMCE Excerpt to add styling to your excerpts. However, if you choose Styled Excerpt and the post doesn\'t have any content in the excerpt field, WP will generate a plain excerpt from the post content.',
              'default' => 'excerpt',
              'name'    => 'excerpt-or-content',
          ),
          'ep-images-hide-on-content' => array(
              'type'    => 'checkbox',
              'label'   => 'Show image when full content or styled excerpt',
              'tooltip' => 'Show the featured image thumb when full content or styled excerpt is being displayed. If you use the same image for both the featured image and as an image in the content, you will get both showing, which does look messy.',
              'default' => false,
              'name'    => 'ep-images-hide-on-content'
          ),
          'ep-content-in-post'        => array(
              'type'    => 'checkbox',
              'label'   => 'Enable single post behaviour',
              'tooltip' => 'Check this to display the content of the relevant post when displayed on the single post page. <br/>NOTE: This will always only display one post, its full content and 100% width.',
              'default' => false,
              'name'    => 'ep-content-in-post'
          ),
          'ep-use-default-behaviour'  => array(
              'type'    => 'checkbox',
              'label'   => 'Enable default "results" page behaviour',
              'tooltip' => 'On category, tags archives or search pages, check this to use the page\'s default behaviour.
						E.g. On search page, search results; on category archives, the posts in that category, on tags archives, posts in that tag.',
              'default' => false,
              'name'    => 'ep-use-default-behaviour'
          ),
          'ep-force-front-page'       => array(
              'type'    => 'checkbox',
              'label'   => 'Enable front page content',
              'tooltip' => 'If this block is displayed on the front page and you actually want to display the front page\'s content, check this option.',
              'default' => false,
              'name'    => 'ep-force-front-page'
          ),
          'ep-empty-behaviour'        => array(
              'type'    => 'select',
              'label'   => 'No results behaviour',
              'tooltip' => 'Select what to show when no results are found.',
              'default' => 'message',
              'options' => array(
                  'message' => 'Show the no results message',
                  'hide'    => 'Hide the block'
              ),
              'name'    => 'ep-empty-behaviour'
          ),
          /* 			'ep-override-search-behaviour' => array(
			  'type' 		=> 'checkbox',
			  'label' 	=> 'Override search page behaviour',
			  'tooltip' => 'Check to use block settings instead of search results',
			  'default' => false,
			  'name' 		=> 'ep-override-search-behaviour'
			  ),
			  'ep-override-cat-archive' => array(
			  'type' => 'checkbox',
			  'label' => 'Override category page behaviour',
			  'tooltip' => 'If the E+ block is displayed on a Category Archives page, check this box if you want to use the selected categories instead of the category archive ones',
			  'default' => false,
			  'name' => 'ep-override-cat-archive'
			  ),
			 */
          'ep-layout-heading'         => array(
              'name'  => 'ep-layout-heading',
              'type'  => 'heading',
              'label' => 'Layout'
          ),
          'ep-number-show'            => array(
              'type'    => 'integer',
              'label'   => 'Number To Show',
              'tooltip' => 'Choose how many excerpts to show. If pagination is enabled, this becomes the number per page.',
              'default' => 6,
              'name'    => 'number-show'
          ),
          'ep-number-across'          => array(
              'type'    => 'integer',
              'label'   => 'Number across',
              'tooltip' => 'Choose how many excerpts you would like to display in each row.',
              'default' => 3,
              'name'    => 'number-across'
          ),
          //				'ep-number-across-smartphone'	 => array(
          //						'type'						 => 'slider',
          //						'label'						 => 'Number across (Smartphone)',
          //						'tooltip'					 => 'Choose how many excerpts you would like to display in each row when device is a smartphone. This will apply when the screen width is less than 720px.',
          //						'default'					 => 1,
          //						'slider-min'			 => 1,
          //						'slider-max'			 => 10,
          //						'slider-interval'	 => 1,
          //						'name'						 => 'number-across-smartphone'
          //				),
          'ep-cell-vgap'              => array(
              'type'    => 'integer',
              'label'   => 'Cells gap',
              'tooltip' => 'Set the gap between the left and right sides of each cell.',
              'default' => 10,
              'unit'    => 'px',
              'name'    => 'ep-cell-vgap'
          ),
          'ep-row-hgap'               => array(
              'type'    => 'integer',
              'label'   => 'Rows gap',
              'tooltip' => 'Set the gap between each row.',
              'default' => 10,
              'unit'    => 'px',
              'name'    => 'ep-row-hgap'
          ),
          // 'ep-cell-padding' => array(
          // 	'type' => 'slider',
          // 	'label' => 'Cell padding',
          // 	'tooltip' => 'The padding to be place around each cell',
          // 	'default' => 5,
          // 	'slider-min' => 0,
          // 	'slider-max' => 30,
          // 	'slider-interval' => 1,
          // 	'unit' => 'px',
          // 	'name' => 'ep-cell-padding'
          // ),
          'ep-content-count'          => array(
              'type'    => 'integer',
              'label'   => 'Number to show full content and width',
              'tooltip' => 'Option to choose how many posts to display full content at full width.',
              'default' => 0,
              'name'    => 'content-count'
          ),
          'ep-full-width-excerpt'     => array(
              'type'    => 'checkbox',
              'label'   => 'Full width is excerpt',
              'tooltip' => 'Overrirde the previous setting so full width is excerpts only, not full content.',
              'default' => false,
              'name'    => 'ep-full-width-excerpt'
          ),
          'ep-pagination-heading'     => array(
              'name'  => 'ep-pagination-heading',
              'type'  => 'heading',
              'label' => 'Pagination'
          ),
          'ep-use-pagination'         => array(
              'type'    => 'checkbox',
              'label'   => 'Pagination',
              'tooltip' => 'If enabled, it will display next/previous post enabling your users to page through your posts. <strong>Note: </strong>Never use Excerpts+ and Content blocks both with pagination on the same page. It will confuse your readers greatly. Also, due to a WordPress bug, pagination won\'t work on the home page if it is set to a static page in WP Settings, Reading. For your interest, this also affects the UpFront Content block.',
              'default' => false,
              'name'    => 'use-pagination'
          ),
          'ep-use-pagnavi'            => array(
              'type'    => 'checkbox',
              'label'   => 'Use WP-PageNavi',
              'tooltip' => 'Use WP-PageNavi for pagination navigation if it is installed and active. Also ensure Pagination is enabled.',
              'default' => true,
              'name'    => 'use-pagenavi'
          ),
          'ep-offset'                 => array(
              'type'    => 'integer',
              'label'   => 'Skip n Posts (breaks pagination!)',
              'tooltip' => 'Skips the designated number of posts. Skip and Pagination cannot be used together. This is a WordPress limitation of which the possible hack workarounds have been unsuccessful.',
              'default' => 0,
              'name'    => 'offset'
          ),
          'ep-order-heading'          => array(
              'name'  => 'ep-order-heading',
              'type'  => 'heading',
              'label' => 'Sorting'
          ),
          'ep-order-az'               => array(
              'type'    => 'select',
              'options' => array(
                  'ASC'  => 'Ascending',
                  'DESC' => 'Descending'
              ),
              'label'   => 'Order',
              'tooltip' => 'Order descending or ascending.',
              'default' => 'Descending',
              'name'    => 'order-az'
          ),
          'ep-order-by'               => array(
              'type'    => 'select',
              'options' => array(
                  'date'          => 'Date created',
                  'modified'      => 'Date last modified',
                  'author'        => 'Author',
                  'title'         => 'Title',
                  'comment_count' => 'Comment count',
                  'rand'          => 'Random',
                  'menu_order'    => 'Page Order',
                  //					'specified' => 'As specified'
              ),
              'label'   => 'Order By',
              // Specified is too complex in E+ coz pulling posts direct. Would ahve to build an array of results first.
              //				'tooltip' => 'Choose what order you would like the excerpts to appear.<br/>NOTE: As Specified only applies if you are specifiying the posts to display, and then it will use the order you have entered their IDs',
              'tooltip' => 'Choose what order you would like the excerpts to appear.',
              'default' => 'Date',
              'name'    => 'order-by'
          ),
          'ep-tweaks-heading'         => array(
              'name'  => 'ep-tweakds-heading',
              'type'  => 'heading',
              'label' => 'Tweaks'
          ),
          'ep-borders'                => array(
              'type'    => 'checkbox',
              'label'   => 'Row Border',
              'tooltip' => 'Choose whether to display a border under each row of excerpts.',
              'default' => true,
              'name'    => 'borders'
          ),
          // 'ep-logged-in-only-users' => array(
          // 'type' => 'checkbox',
          // 'label' => 'Only logged in users can view',
          // 'tooltip' => 'If enabled, this block will only be visible to logged in users.',
          // 'default' => false,
          // 'name' => 'logged-in-only'
          // ),
          'ep-box-adjustment'         => array(
              'type'    => 'integer',
              'label'   => 'Adjust box calculation by ',
              'tooltip' => 'If you have adjusted the left and/or right padding or border widths, you may need to add an adjustment factor here to ensure the cells still line up in a row.',
              'default' => 0,
              'name'    => 'ep-box-adjustment',
              'unit'    => 'px'
          ),
          'ep-excerpt-height'         => array(
              'type'    => 'integer',
              'label'   => 'Cell Fixed Height',
              'tooltip' => 'Set this if you need to make the cells all exactly the same height. Useful if you have set a cell background colour. <br/>Use 0 or blank to allow variable height.<br/><br/>Note: This only applies when content is set to display as an Excerpt (not a Styled Excerpt either). Nor does it apply when the image is set to Behind.',
              'default' => 0,
              'name'    => 'ep-excerpt-height',
              'unit'    => 'px'
          ),
      );

      return $settings;
    }

    static function ep_opt_responsive($block_id = 'NN where NN equals the ID of this block')
    {
      $settings = array(
          'pzep-responsive-repeater' => array(
              'type'     => 'repeater',
              'name'     => 'pzep-responsive-repeater',
              'label'    => 'Set responsive behaviours',
              'tooltip'  => 'Set how you want the block tolook on different screen sizes.',
              'default'  => array(
                  array(
                      'pzep-responsive-name'  => 'Smartphone',
                      'pzep-responsive-lower' => '0',
                      'pzep-responsive-upper' => '640',
                      'pzep-responsive-width' => '100%'
                  ),
                  array(
                      'pzep-responsive-name'  => 'Tablet Portrait',
                      'pzep-responsive-lower' => '641',
                      'pzep-responsive-upper' => '960',
                      'pzep-responsive-width' => '100%'
                  ),
                  array(
                      'pzep-responsive-name'  => 'Tablet Landscape',
                      'pzep-responsive-lower' => '961',
                      'pzep-responsive-upper' => '1024',
                      'pzep-responsive-width' => ''
                  ),
                  array(
                      'pzep-responsive-name'  => 'Desktop',
                      'pzep-responsive-lower' => '1025',
                      'pzep-responsive-upper' => '9999',
                      'pzep-responsive-width' => ''
                  )
              ),
              'inputs'   => array(
                  array(
                      'type'    => 'text',
                      'name'    => 'pzep-responsive-name',
                      'label'   => 'Name',
                      'default' => '',
                      'tooltip' => 'A reference name for this responsive layout.'
                  ),
                  array(
                      'type'    => 'integer',
                      'name'    => 'pzep-responsive-lower',
                      'label'   => 'Lower',
                      'default' => '',
                      'tooltip' => ''
                  ),
                  array(
                      'type'    => 'integer',
                      'name'    => 'pzep-responsive-upper',
                      'label'   => 'Upper (px)',
                      'default' => '',
                      'tooltip' => '. '
                  ),
                  array(
                      'type'    => 'text',
                      'name'    => 'pzep-responsive-width',
                      'label'   => 'Width',
                      'default' => '',
                      'tooltip' => 'Set if you want a specific width. Include units - eg. px, %.'
                  ),
                  array(
                      'type'    => 'textarea',
                      'name'    => 'pzep-responsive-custom-css',
                      'label'   => 'CSS',
                      'default' => '',
                      'tooltip' => 'Input any custom css specific to this responsive layout. To target this block specifically, prefix your CSS declarations with #block-' . $block_id
                  ),
              ),
              'sortable' => true
          )
      );

      return $settings;
    }

    static function ep_opt_behaviour($block, $just_defaults = false)
    {
      $all_post_types = array('post' => 'Posts', 'page' => 'Pages');

      if ($just_defaults == 'no') {
        $all_post_types         = array('post' => 'Posts', 'page' => 'Pages');
        $all_post_types_numeric = array('post', 'page');
        $args                   = array(
      //      'public'   => true,
            '_builtin' => false
        );
        $output                 = 'objects'; // names or objects
        $operator               = 'and'; // 'and' or 'or'
        $post_types             = get_post_types($args, $output, $operator);
        foreach ($post_types as $post_type) {
          $all_post_types[ $post_type->name ] = $post_type->label;
          $all_post_types_numeric[ ]          = $post_type->name;
        }
        // Check for update
//			ep_options_update($block,$all_post_types_numeric);
      }
      $settings    = array(
          'ep-content-heading' => array(
              'name'  => 'ep-content-heading',
              'type'  => 'heading',
              'label' => 'Content'
          ),
          'ep-post-type'       => array(
              'type'    => 'multi-select',
              'options' => $all_post_types,
              'label'   => 'Contents type',
              'tooltip' => 'Choose the contents type you want to display: Posts, pages or custom post types (if available).',
              'default' => array('post' => 'post'),
              'name'    => 'post-type',
          ),
          'ep-post-inc-scheduled'       => array(
              'type'    => 'checkbox',
              'label'   => 'Include scheduled posts',
              'tooltip' => 'Include scheduled posts to give readers a teaser of what\'s coming. Note: ExcerptsPlus will never show full content from scheduled posts nor are they linked. They also have a specific class .scheduled so you can style them uniquely with custom CSS.',
              'default' => false,
              'name'    => 'post-inc-scheduled',
          ),
          'ep-post-ids'        => array(
              'type'    => 'text',
              'label'   => 'Specific IDs (optional)',
              'tooltip' => 'Specify IDs of posts or pages or custom post types if you want to limit to specific content.',
              'default' => '',
              'name'    => 'post-ids',
          ),
          'ep-show-children'   => array(
              'type'    => 'checkbox',
              'label'   => 'Show children of specific IDs (Page types only)',
              'tooltip' => 'When displaying pages, you can use a spefic page ID and then check this setting to make it display that page\'s children only.<br/><br>Very useful for displaying a group of pages, e.g. a group of accommodation pages.',
              'default' => false,
              'name'    => 'show-children'
          ),
          'ep-exclude-ids'     => array(
              'type'    => 'checkbox',
              'label'   => 'Exclude Specific IDs',
              'tooltip' => 'If enabled, the specified IDs above will be excluded. Useful for excluding the pages like the 404 page when type is pages.',
              'default' => false,
              'name'    => 'exclude-ids'
          ),
      );
      $categories  = array();
      $ep_tax_list = array();
      $ep_tag_list = array();
      $authors     = array();

      if ($just_defaults == 'no') {
        $categories = self::ep_get_categories();

        $ep_tax_list = EPFunctions::get_tax_list();
        $ep_tax_list = (count($ep_tax_list) == 0) ? array('value' => 'none',
                                                          'text'  => 'No custom taxonomies available') : $ep_tax_list;

        $ep_tag_list = EPFunctions::get_tag_list();
        $ep_tag_list = (count($ep_tag_list) == 0) ? array('value' => 'none',
                                                          'text'  => 'No tags available') : $ep_tag_list;

        // Get authors
        $userslist      = get_users();
        $authors[ '0' ] = 'All';
        foreach ($userslist as $author) {
          if (get_the_author_meta('user_level', $author->ID) >= 2) {
            $authors[ $author->ID ] = $author->display_name;
          }
        }
      }
      $settings += array(
          'ep-categories-heading'     => array(
              'name'  => 'ep-categories-heading',
              'type'  => 'heading',
              'label' => 'Categories',
          ),
          'ep-categories'             => array(
              'type'    => 'multi-select',
              'name'    => 'categories',
              'label'   => 'Include Categories',
              'tooltip' => 'Select categories to display.',
              'default' => 'all',
              'options' => $categories
          ),
          'ep-all-include-categories' => array(
              'type'    => 'checkbox',
              'label'   => 'Must be in ALL included categories',
              'tooltip' => 'If selected, post must be in all the categories selected for inclusion.',
              'default' => false,
              'name'    => 'all-include-categories'
          ),
          'ep-exclude-categories'     => array(
              'type'    => 'multi-select',
              'name'    => 'exclude-categories',
              'label'   => 'Exclude Categories',
              'tooltip' => 'Select categories to exclude.',
              'default' => 'all',
              'options' => $categories
          ),
          'ep-show-cat-kids'          => array(
              'type'    => 'checkbox',
              'label'   => 'Include sub-categories when E+ is displaying on a Category Archive page',
              'tooltip' => 'If the E+ block is displayed on a Category Archives page, do you wish to show the children of the category as well?',
              'default' => false,
              'name'    => 'show-cat-kids'
          ),
          'ep-include-stickies'       => array(
              'type'    => 'checkbox',
              'label'   => 'Show Sticky Posts First',
              'tooltip' => 'Option to show sticky posts before other posts.<p class="hilite"><strong>Note:</strong> Due to a WP limitation, this will force all categories to show</p>',
              'default' => false,
              'name'    => 'include-stickies'
          ),
          'ep-othertax-heading'       => array(
              'name'  => 'ep-othertax-heading',
              'type'  => 'heading',
              'label' => 'Other filters',
          ),
          'ep-authors'                => array(
              'type'    => 'multi-select',
              'label'   => 'Author',
              'tooltip' => 'Choose posts to display for an author or all.',
              'default' => '0',
              'options' => $authors,
              'name'    => 'author'
          ),
          'ep-tags'                   => array(
              'type'    => 'multi-select',
              'name'    => 'ep-tags',
              'label'   => 'Tags',
              'tooltip' => 'Select tags to filter by.',
              'default' => '',
              'options' => $ep_tag_list
          ),
          'ep-exclude-tags'           => array(
              'type'    => 'multi-select',
              'name'    => 'exclude-tags',
              'label'   => 'Exclude Tags',
              'tooltip' => 'Select tags to exclude.',
              'default' => 'all',
              'options' => $ep_tag_list
          ),
          'ep-taxonomies'             => array(
              'type'    => 'multi-select',
              'name'    => 'ep-taxonomies',
              'label'   => 'Custom Taxonomies',
              'tooltip' => 'Select custom taxonomy to filter by.',
              'default' => '',
              'options' => $ep_tax_list
          ),
          'ep-taxonomies-operator'    => array(
              'type'    => 'select',
              'name'    => 'ep-taxonomies-operator',
              'label'   => 'Taxonomies Operator',
              'tooltip' => 'Select whether posts need to be in ALL chosen taxonomies or in ANY of the taxonomies. <br/><br/>Note: This includes any selected categories,tags and custom taxonomies. <br/><br/>It\'s best not to overdo the selection ofcategories, tags and custom taxonomies as it will get so confusing you won\'t even know if it is working for sure or not.',
              'default' => '',
              'options' => array('AND' => 'All', 'OR' => 'Any')
          ),
          'ep-date-filters-heading'   => array(
              'name'  => 'ep-date-filters-heading',
              'type'  => 'heading',
              'label' => 'Date filters',
          ),
          'ep-days-to-show'           => array(
              'type'    => 'text',
              'label'   => 'Days to show',
              'tooltip' => 'Enter number of days to show starting at the End Date and going back. Enter \'all\' to show all. e.g. To just show today\'s posts, enter 1 here, and Today in the end date.',
              'default' => 'all',
              'name'    => 'ep-days-to-show',
          ),
          'ep-date-to-end'            => array(
              'type'    => 'text',
              'label'   => 'End date',
              'tooltip' => 'Enter the end date. Enter Today or Yesterday or a date in any standard format. In fact, this uses the PHP strtotime function, so can take relative dates such as \'Last week\', \'Last day of February 2012\', \'6 months ago\', \'last day of last month\'. Not everything works with relative dates, e.g \'six months ago\' and \'last day of february\' do not work. So if you do use relative dates, do make sure you fully test your date.',
              'default' => 'Today',
              'name'    => 'ep-date-to-end',
          ),
          'ep-use-timezone'           => array(
              'type'    => 'checkbox',
              'label'   => 'Use timezone',
              'tooltip' => 'WordPress often returns posts based on UTC 0 time. If this is happening, this option lets you force it to adjust to the timezone set in the WP Admin, General, Settings.',
              'default' => true,
              'name'    => 'ep-use-timezone',
          ),
      );

      return $settings;
    }

    static function ep_opt_titles()
    {
      $settings = array(
          'ep-titles-text-block-titles' => array(
              'name'  => 'ep-titles-text-block-titles',
              'type'  => 'heading',
              'label' => 'Block Titles (E+)'
          ),
          'ep-block-title'              => array(
              'type'      => 'text',
              'label'     => 'Block Title',
              'tooltip'   => 'Enter a title for this block (optional)',
              'default'   => '',
              'name'      => 'ep-block-title',
              'callbackx' => 'var x = $(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-ep-block-title\');
				if (x.val() != \'\') {
					$(\'div#block-\' + blockID + \'-tab div#sub-tab-titles-content #input-ep-block-title-link\').show();
				} else {
					$(\'div#block-\' + blockID + \'-tab div#sub-tab-titles-content #input-ep-block-title-link\').hide();
				}
				'
          ),
          'ep-block-title-link'         => array(
              'type'    => 'textarea',
              'label'   => 'Block title URL',
              'tooltip' => 'Enter a URL if you want the block title to link to a specific page on your site or the web',
              'default' => '',
              'name'    => 'ep-block-title-link'
          ),
          'ep-block-title-image'        => array(
              'type'    => 'image',
              'label'   => 'Block title image',
              'tooltip' => 'Select an image to appear in the title',
              'default' => '',
              'name'    => 'ep-block-title-image'
          ),
          'ep-block-title-hide-text'    => array(
              'type'    => 'checkbox',
              'label'   => 'Hide block title text',
              'tooltip' => 'The block title text is also used in the link URL. So ifyou have an image but don\'t ant to display the title, check this box',
              'default' => false,
              'name'    => 'ep-block-title-hide-text'
          ),
          'ep-titles-text-entry-titles' => array(
              'name'  => 'ep-titles-text-entry-titles',
              'type'  => 'heading',
              'label' => 'Entry Titles'
          ),
          'ep-title-bullet'             => array(
              'type'    => 'select',
              'options' => array(
                  'none'     => 'None',
                  'raquo; '  => '&raquo;',
                  '#8226; '  => '&#8226;',
                  '#8212; '  => '&#8212;',
                  'thumb32'  => 'Thumbnail : 32px square',
                  'thumb48'  => 'Thumbnail : 48px square',
                  'thumb64'  => 'Thumbnail : 64px square',
                  'thumb32c' => 'Thumbnail : 32px circular',
                  'thumb48c' => 'Thumbnail : 48px circular',
                  'thumb64c' => 'Thumbnail : 64px circular'
              ),
              'label'   => 'Post Title Bullet',
              'tooltip' => 'Select a bullet to preced the post/page title. If you choose a thumbnail, it\'s worth every post having a featured image. And it will only use the featured image for the thumbnail.',
              'default' => '',
              'name'    => 'title-bullet'
          ),
          'ep-dont-link'                => array(
              'type'    => 'checkbox',
              'label'   => 'Don\'t link to post/page',
              'tooltip' => 'Enabled this if you don\'t want the any links to the post/page - e.g. the title link. You might use this when you want the excerpts to be self contained informationals. This will automatically remove the ellipses and the [more] link as well.',
              'default' => false,
              'name'    => 'ep-dont-link'
          ),
          'ep-hw-alt-titles'            => array(
              'type'    => 'checkbox',
              'label'   => 'Use Alternative Titles',
              'tooltip' => 'In the post editor, UpFront adds an option for shorter alternative titles. If you wish to display these when available, enable this setting.',
              'default' => true,
              'name'    => 'ep-hw-alt-titles'
          ),
          'ep-titles-text-text'         => array(
              'name'  => 'ep-titles-text-text',
              'type'  => 'heading',
              'label' => 'Text'
          ),
          'ep-goto-text'                => array(
              'type'    => 'text',
              'label'   => 'Link tooltip prefix text',
              'tooltip' => 'Set the prefix text when you hover over post link.',
              'default' => 'Go to: ',
              'name'    => 'ep-goto-text'
          ),
          'ep-page-next'                => array(
              'type'    => 'text',
              'label'   => 'Next page text',
              'tooltip' => 'Set the text for pagination next page.',
              'default' => 'Newer posts &rarr;',
              'name'    => 'ep-page-next'
          ),
          'ep-page-prev'                => array(
              'type'    => 'text',
              'label'   => 'Previous page text',
              'tooltip' => 'Set the text for pagination previous page.',
              'default' => '&larr; Older posts',
              'name'    => 'ep-page-prev'
          ),
          'ep-link-to-text'             => array(
              'type'      => 'text',
              'label'     => 'Link To Text',
              'tooltip'   => 'You can display an additional link at the foot of your excerpts, for example to take you to all posts in the category of excerpts you\'ve shown. This option lets you set the text for that link. Leave blank for none.',
              'default'   => '',
              'name'      => 'link-to-text',
              'callbackx' => '
					if ($(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-link-to-text\').val() != \'\') {
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-titles-content #input-link-to-link\').show();
					} else {
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-titles-content #input-link-to-link\').hide();
					}
				'
          ),
          'ep-link-to-link'             => array(
              'type'    => 'text',
              'label'   => 'Link To URL',
              'tooltip' => 'URL of additional link in the footer of your excerpts. Leave blank for none.',
              'default' => '',
              'name'    => 'link-to-link'
          ),
          'ep-no-content'               => array(
              'type'    => 'textarea',
              'label'   => 'No Excerpt/Content Message',
              'tooltip' => 'Text to display when no content.',
              'default' => 'There is nothing to display at this time.  Please check back later.',
              'name'    => 'no-content'
          ),
          'ep-read-more'                => array(
              'type'    => 'text',
              'label'   => 'Read More Text',
              'tooltip' => 'Wording to use to indicate to read more. <br/>If you want to include the post title, add %title%.<br/>e.g. [continue reading: %title%]',
              'default' => '[more]',
              'name'    => 'read-more'
          ),
          'ep-always-show-read-more'    => array(
              'type'    => 'checkbox',
              'label'   => 'Always show Read More text',
              'tooltip' => 'Always show the Read more text and link, regardless of truncation. Useful when using Styled Excerpts',
              'default' => false,
              'name'    => 'ep-always-show-read-more'
          ),
          'ep-cat-archive'              => array(
              'type'    => 'textarea',
              'label'   => 'Category Archive title',
              'tooltip' => 'Set a title or not for the Category Archives page. Include %categories% for category names.',
              'default' => 'Showing by category: %categories%',
              'name'    => 'cat-archive'
          ),
          'ep-author-archive'           => array(
              'type'    => 'textarea',
              'label'   => 'Author Archive title',
              'tooltip' => 'Set a title or not for the Author Archives page. Include %author% for author name.',
              'default' => 'Showing by author: %author%',
              'name'    => 'author-archive'
          ),
          'ep-date-archive'             => array(
              'type'    => 'textarea',
              'label'   => 'Date Archive title',
              'tooltip' => 'Set a title or not for the Date Archives page. Include %day%, %month%, %year% for those values.',
              'default' => 'Showing posts for: %day%-%month%-%year%',
              'name'    => 'date-archive'
          ),
          'ep-titles-text-meta-heading' => array(
              'name'  => 'ep-titles-text-meta-heading',
              'type'  => 'heading',
              'label' => 'Meta Text'
          ),
          'ep-quick-read-label'         => array(
              'type'    => 'text',
              'label'   => 'Quick Read button label',
              'tooltip' => 'Text to appear in Quick Read button',
              'default' => 'Quick Read',
              'name'    => 'ep-quick-read-label'
          ),
          'ep-text-comments-nil'        => array(
              'type'    => 'text',
              'label'   => 'No Comments',
              'tooltip' => 'Meta label when no comments. Use %num% to show comment count.',
              'default' => '%num% comments',
              'name'    => 'ep-text-comments-nil'
          ),
          'ep-text-comments-single'     => array(
              'type'    => 'text',
              'label'   => 'Comments single',
              'tooltip' => 'Meta label when single comments. Use %num% to show comment count.',
              'default' => '%num% comment',
              'name'    => 'ep-text-comments-single'
          ),
          'ep-text-comments-multiple'   => array(
              'type'    => 'text',
              'label'   => 'Comments multiple',
              'tooltip' => 'Meta label when multiple comments. Use %num% to show comment count.',
              'default' => '%num% comments',
              'name'    => 'ep-text-comments-multiple'
          ),
          'ep-text-comments-new'        => array(
              'type'    => 'text',
              'label'   => 'Leave comment',
              'tooltip' => 'Meta label to leave a comment',
              'default' => 'Leave a comment!',
              'name'    => 'ep-text-comments-new'
          ),

      );

      return $settings;
    }

    static function ep_opt_content($block, $just_defaults = false)
    {

      $settings = array(
          'ep-excerpts-heading'       => array(
              'name'  => 'ep-excerpts-heading',
              'type'  => 'heading',
              'label' => 'Excerpts'
          ),
          'ep-trim-excerpts'          => array(
              'type'    => 'checkbox',
              'label'   => 'Use custom excerpt length',
              'tooltip' => 'Override the default WordPress excerpt length with your own. This will not apply if styled excerpts is selected.',
              'default' => true,
              'name'    => 'ep-trim-excerpts',
              'toggle'  => array(
                  true  => array(
                      'show' => array(
                          '#input-excerpt-length',
                          '#input-chars-or-words'
                      )
                  ),
                  false => array(
                      'hide' => array(
                          '#input-excerpt-length',
                          '#input-chars-or-words'
                      )
                  )
              ),
          ),
          'ep-excerpt-length'         => array(
              'type'    => 'integer',
              'label'   => 'Excerpt Length',
              'tooltip' => 'Number of characters/words of the excerpt to show. If the number is greater than the excerpt length, it will only show the full excerpt.<br/><strong>Note:</strong> If you use Styled Excerpts or Full Content, truncation will not apply.',
              'default' => 100,
              'name'    => 'excerpt-length'
          ),
          'ep-chars-or-words'         => array(
              'type'    => 'select',
              'options' => array(
                  'characters' => 'Characters',
                  'words'      => 'words'
              ),
              'label'   => 'Trim excerpt by characters or words',
              'tooltip' => 'Choose if the above value for excerpt length should be measured in characters or words',
              'default' => 'characters',
              'name'    => 'chars-or-words'
          ),
          'ep-etrunc-char'            => array(
              'type'    => 'select',
              'options' => array(
                  'ellipses' => 'Ellipses',
                  'arrows'   => 'Arrows',
                  'none'     => 'None'
              ),
              'label'   => 'Truncaction character',
              'tooltip' => 'Choose character to show when the excerpt is truncated',
              'default' => 'ellipses',
              'name'    => 'trunc-char'
          ),
          'ep-excerpt-first'          => array(
              'type'    => 'checkbox',
              'label'   => 'Excerpt first then list',
              'tooltip' => 'Enable this if you only want to show an excerpt for the first <em>n</em> posts, then just a list of titles thereafter. Note: This only works when you have set a layout of ONE ACROSS.',
              'default' => false,
              'name'    => 'excerpt-first'
          ),
          'ep-excerpt-first-count'    => array(
              'type'    => 'integer',
              'label'   => 'Number to show as excerpt',
              'tooltip' => 'Number of posts to show as excerpts before just listing titles.',
              'default' => 1,
              'name'    => 'excerpt-first-count'
          ),
          'ep-excerpt-content-height' => array(
              'type'    => 'integer',
              'label'   => 'Excerpt text Fixed Height',
              'tooltip' => 'Set this if you need to make the excerpt text area all exactly the same height. <br/>Use 0 or blank to allow variable height.<br/><br/>Note: This only applies when content is set to display as an Excerpt (not a Styled Excerpt either). Nor does it apply when the image is set to Behind.',
              'default' => 0,
              'name'    => 'ep-excerpt-content-height',
              'unit'    => 'px'
          ),
          'ep-use-dotdotdot'          => array(
              'type'    => 'checkbox',
              'label'   => 'Automate ellipses',
              'tooltip' => 'If you\'ve set a excerpt text fixed height for the excerpt cell, this will enable the automatic placement of ellipses if your content gets cut off.',
              'default' => false,
              'name'    => 'ep_use_dotdotdot'
          ),
      );

      return $settings;
    }

    static function ep_opt_meta()
    {

      $settings = array(
          'ep-meta-heading'       => array(
              'name'  => 'ep-meta-heading',
              'type'  => 'heading',
              'label' => 'Meta'
          ),
          'ep-meta-one'           => array(
              'type'    => 'textarea',
              'label'   => 'Meta information 1 - Left',
              'tooltip' => 'Define content for the first meta info area left side. This can include text, HTML or even PHP (provided it is enclosed in &lt;?php ?&gt;).<br/><br/> Variables can be %date%, %time%, %categories%, %tags%, %author%, %author_no_link%, %comments%, %comments_no_link%, %respond%, %edit%, %permalink%, %title% and %quickread%.',
              'default' => '%author% - %date%, %time% <br/>%categories%<br/>%quickread%',
              'name'    => 'meta'
          ),
          'ep-meta-one-right'     => array(
              'type'    => 'textarea',
              'label'   => 'Meta information 1 - Right',
              'tooltip' => 'Define content for the first meta info area right side. This can include text, HTML or even PHP (provided it is enclosed in &lt;?php ?&gt;).<br/><br/> Variables can be %date%, %time%, %categories%, %tags%, %author%, %author_no_link%, %comments%, %comments_no_link%, %respond%, %edit%, %permalink%, %title% and %quickread%.',
              'default' => '',
              'name'    => 'meta-right'
          ),
          'ep-meta-two'           => array(
              'type'    => 'textarea',
              'label'   => 'Meta information 2 - Left',
              'tooltip' => 'Define content for the second meta info area left side. This can include text, HTML or even PHP (provided it is enclosed in &lt;?php ?&gt;).<br/><br/> Variables can be %date%, %time%, %categories%, %tags%, %author%, %author_no_link%, %comments%, %comments_no_link%, %respond%, %edit%, %permalink%, %title% and %quickread%.',
              'default' => '%comments%',
              'name'    => 'meta-below'
          ),
          'ep-meta-two-right'     => array(
              'type'    => 'textarea',
              'label'   => 'Meta information 2 - Right',
              'tooltip' => 'Define content for the second meta info area right side. This can include text, HTML or even PHP (provided it is enclosed in &lt;?php ?&gt;).<br/><br/> Variables can be %date%, %time%, %categories%, %tags%, %author%, %author_no_link%, %comments%, %comments_no_link%, %respond%, %edit%, %permalink%, %title% and %quickread%.',
              'default' => '',
              'name'    => 'meta-below-right'
          ),
          'ep-meta-three-left'    => array(
              'type'    => 'textarea',
              'label'   => 'Meta information 3 - Left',
              'tooltip' => 'Define content for the third meta info area left side. This can include text, HTML or even PHP (provided it is enclosed in &lt;?php ?&gt;).<br/><br/> Variables can be %date%, %time%, %categories%, %tags%, %author%, %author_no_link%, %comments%, %comments_no_link%, %respond%, %edit%, %permalink%, %title% and %quickread%.',
              'default' => '',
              'name'    => 'meta-three-left'
          ),
          'ep-meta-three-right'   => array(
              'type'    => 'textarea',
              'label'   => 'Meta information 3 - Right',
              'tooltip' => 'Define content for the third meta info area right side. This can include text, HTML or even PHP (provided it is enclosed in &lt;?php ?&gt;).<br/><br/> Variables can be %date%, %time%, %categories%, %tags%, %author%, %author_no_link%, %comments%, %comments_no_link%, %respond%, %edit%, %permalink%, %title% and %quickread%.',
              'default' => '',
              'name'    => 'meta-three-right'
          ),
          'ep-metacustom-heading' => array(
              'name'  => 'ep-metacustom-heading',
              'type'  => 'heading',
              'label' => 'Customisation'
          ),
          'ep-date-format'        => array(
              'type'    => 'text',
              'label'   => 'Date format',
              'tooltip' => 'Date format to use in meta info. Use %date% in meta content to show the date. Blank to use WordPress default.',
              'default' => 'F j, Y',
              'name'    => 'date-format'
          ),
          'ep-time-format'        => array(
              'type'    => 'text',
              'label'   => 'Time format',
              'tooltip' => 'Time format to use in meta info. Use %time% in meta content to show the time. Blank to use WordPress default.',
              'default' => 'g:i a',
              'name'    => 'time-format'
          ),
          'ep-show-avatar'        => array(
              'type'    => 'checkbox',
              'label'   => 'Show Author Picture',
              'tooltip' => 'Option to show or hide the author of the post\'s picture.',
              'default' => false,
              'name'    => 'show-avatar'
          ),
          'ep-avatar-size'        => array(
              'type'    => 'integer',
              'label'   => 'Author Picture Width',
              'tooltip' => 'Set the width to use for the author\'s picture. This will automatically apply to the height as well.',
              'default' => 16,
              'name'    => 'avatar-size',
              'unit'    => 'px'
          ),

      );

      return $settings;
    }

    /*	 * **********************************
		Custom Fields
	 * ********************************** */

    static function ep_opt_custom_fields($pzep_custom_fields)
    {
      // three groups
      // field name
      // wrapper element
      // Prefix text
      // Suffix text
      // Formatting via design mode
      $pzep_custom_fields = (is_array($pzep_custom_fields)) ? array_merge($pzep_custom_fields, array('none' => 'None')) : '';
      $settings           = array(
//			'ep-custom-fields-group1-heading'			 => array(
//				'type'		 => 'heading',
//				'name'		 => 'ep-custom-fields-group1-heading',
//				'label'		 => 'Use full wrapper width',
//			),
'ep-custom-fields-group1-repeater' => array(
    'type'     => 'repeater',
    'name'     => 'ep-custom-fields-group1-repeater',
    'label'    => 'Group 1 custom fields',
    //				'tooltip'	 => 'Select the custom fields to appear in this group.',
    'default'  => null,
    'inputs'   => array(
        array(
            'type'    => 'select',
            'name'    => 'ep-custom-fields-name',
            'label'   => 'Display field',
            'default' => '',
            'tooltip' => 'Select a custom field you want to display',
            'options' => $pzep_custom_fields
        ),
        array(
            'type'    => 'checkbox',
            'name'    => 'ep-custom-fields-is-image',
            'label'   => 'Is image',
            'default' => false,
            'tooltip' => 'Enable this if this custom field is an image.'
        ),
        array(
            'type'    => 'checkbox',
            'name'    => 'ep-custom-fields-is-date',
            'label'   => 'Is date',
            'default' => false,
            'tooltip' => 'Enable this if this custom field is a date. It will be formatted with your site\'s default date format.'
        ),
        array(
            'type'    => 'select',
            'name'    => 'ep-custom-fields-wrapper',
            'label'   => 'Wrapper element',
            'default' => '<p>',
            'options' => array(
                'p'    => 'p',
                'div'  => 'div',
                'span' => 'span',
                'h1'   => 'h1',
                'h2'   => 'h2',
                'h3'   => 'h3',
                'h4'   => 'h4',
                'h5'   => 'h5',
                'h6'   => 'h6',
                'none' => 'None'),
            'tooltip' => 'Select the wrapper element for this custom field group'
        ),
        array(
            'type'    => 'select',
            'name'    => 'ep-custom-fields-name-url',
            'label'   => 'Link field',
            'default' => 'none',
            'tooltip' => 'Select a custom field you want to use as the link',
            'options' => $pzep_custom_fields
        ),
        array(
            'type'    => 'text',
            'name'    => 'ep-custom-fields-prefix-text',
            'label'   => 'Prefix text',
            'default' => '',
            'tooltip' => 'Enter any text yo display before the custom field.'
        ),
        array(
            'type'    => 'image',
            'name'    => 'ep-custom-fields-prefix-image',
            'label'   => 'Prefix image',
            'default' => '',
            'tooltip' => 'Select image to display before the custom field. E.g. an icon'
        ),
        array(
            'type'    => 'text',
            'name'    => 'ep-custom-fields-suffix-text',
            'label'   => 'Suffix text',
            'default' => '',
            'tooltip' => 'Enter any text to display after the custom field.'
        ),
        array(
            'type'    => 'image',
            'name'    => 'ep-custom-fields-suffix-image',
            'label'   => 'Suffix image',
            'default' => '',
            'tooltip' => 'Select image to display after the custom field. E.g. an icon'
        ),
    ),
    'sortable' => true
),
'ep-custom-fields-group2-repeater' => array(
    'type'     => 'repeater',
    'name'     => 'ep-custom-fields-group2-repeater',
    'label'    => 'Group 2 custom fields',
    //				'tooltip'	 => 'Select the custom fields to appear in this group.',
    'default'  => null,
    'inputs'   => array(
        array(
            'type'    => 'select',
            'name'    => 'ep-custom-fields-name',
            'label'   => 'Display field',
            'default' => 'none',
            'tooltip' => 'Select a custom field you want to display',
            'options' => $pzep_custom_fields
        ),
        array(
            'type'    => 'select',
            'name'    => 'ep-custom-fields-wrapper',
            'label'   => 'Wrapper element',
            'default' => '<p>',
            'options' => array(
                'p'    => 'p',
                'div'  => 'div',
                'span' => 'span',
                'h1'   => 'h1',
                'h2'   => 'h2',
                'h3'   => 'h3',
                'h4'   => 'h4',
                'h5'   => 'h5',
                'h6'   => 'h6',
                'none' => 'None'),
            'tooltip' => 'Select the wrapper element for this custom field group'
        ),
        array(
            'type'    => 'checkbox',
            'name'    => 'ep-custom-fields-is-image',
            'label'   => 'Is image',
            'default' => false,
            'tooltip' => 'Enable this if this custom field is an image.'
        ),
        array(
            'type'    => 'checkbox',
            'name'    => 'ep-custom-fields-is-date',
            'label'   => 'Is date',
            'default' => false,
            'tooltip' => 'Enable this if this custom field is a date. It will be formatted with your site\'s default date format.'
        ),
        array(
            'type'    => 'select',
            'name'    => 'ep-custom-fields-name-url',
            'label'   => 'Link field',
            'default' => 'none',
            'tooltip' => 'Select a custom field you want to use as the link',
            'options' => $pzep_custom_fields
        ),
        array(
            'type'    => 'text',
            'name'    => 'ep-custom-fields-prefix-text',
            'label'   => 'Prefix text',
            'default' => '',
            'tooltip' => 'Enter any text to display before the custom field.'
        ),
        array(
            'type'    => 'image',
            'name'    => 'ep-custom-fields-prefix-image',
            'label'   => 'Prefix image',
            'default' => '',
            'tooltip' => 'Select image to display before the custom field. E.g. an icon'
        ),
        array(
            'type'    => 'text',
            'name'    => 'ep-custom-fields-suffix-text',
            'label'   => 'Suffix text',
            'default' => '',
            'tooltip' => 'Enter any text to display after the custom field.'
        ),
        array(
            'type'    => 'image',
            'name'    => 'ep-custom-fields-suffix-image',
            'label'   => 'Suffix image',
            'default' => '',
            'tooltip' => 'Select image to display after the custom field. E.g. an icon'
        ),
    ),
    'sortable' => true
),
'ep-custom-fields-group3-repeater' => array(
    'type'     => 'repeater',
    'name'     => 'ep-custom-fields-group3-repeater',
    'label'    => 'Group 3 custom fields',
    //				'tooltip'	 => 'Select the custom fields to appear in this group.',
    'default'  => null,
    'inputs'   => array(
        array(
            'type'    => 'select',
            'name'    => 'ep-custom-fields-name',
            'label'   => 'Display field',
            'default' => '',
            'tooltip' => 'Select a custom field you want to display',
            'options' => $pzep_custom_fields
        ),
        array(
            'type'    => 'select',
            'name'    => 'ep-custom-fields-wrapper',
            'label'   => 'Wrapper element',
            'default' => '<p>',
            'options' => array(
                'p'    => 'p',
                'div'  => 'div',
                'span' => 'span',
                'h1'   => 'h1',
                'h2'   => 'h2',
                'h3'   => 'h3',
                'h4'   => 'h4',
                'h5'   => 'h5',
                'h6'   => 'h6',
                'none' => 'None'),
            'tooltip' => 'Select the wrapper element for this custom field group'
        ),
        array(
            'type'    => 'checkbox',
            'name'    => 'ep-custom-fields-is-image',
            'label'   => 'Is image',
            'default' => false,
            'tooltip' => 'Enable this if this custom field is an image.'
        ),
        array(
            'type'    => 'checkbox',
            'name'    => 'ep-custom-fields-is-date',
            'label'   => 'Is date',
            'default' => false,
            'tooltip' => 'Enable this if this custom field is a date. It will be formatted with your site\'s default date format.'
        ),
        array(
            'type'    => 'select',
            'name'    => 'ep-custom-fields-name-url',
            'label'   => 'Link field',
            'default' => 'none',
            'tooltip' => 'Select a custom field you want to use as the link',
            'options' => $pzep_custom_fields
        ),
        array(
            'type'    => 'text',
            'name'    => 'ep-custom-fields-prefix-text',
            'label'   => 'Prefix text',
            'default' => '',
            'tooltip' => 'Enter any text yo display before the custom field.'
        ),
        array(
            'type'    => 'image',
            'name'    => 'ep-custom-fields-prefix-image',
            'label'   => 'Prefix image',
            'default' => '',
            'tooltip' => 'Select image to display before the custom field. E.g. an icon'
        ),
        array(
            'type'    => 'text',
            'name'    => 'ep-custom-fields-suffix-text',
            'label'   => 'Suffix text',
            'default' => '',
            'tooltip' => 'Enter any text to display after the custom field.'
        ),
        array(
            'type'    => 'image',
            'name'    => 'ep-custom-fields-suffix-image',
            'label'   => 'Suffix image',
            'default' => '',
            'tooltip' => 'Select image to display after the custom field. E.g. an icon'
        ),
    ),
    'sortable' => true
)
      );

      return $settings;
    }

    /*	 * **********************************
	IMAGES
 * ********************************** */

    static function ep_opt_images()
    {
      $settings = array(
          'ep-images-heading'        => array(
              'name'  => 'ep-images-heading',
              'type'  => 'heading',
              'label' => 'General Image Settings'
          ),
          'ep-image-location'        => array(
              'type'      => 'select',
              'options'   => array(
                  'title'   => 'Title',
                  'content' => 'Content',
                  'behind'  => 'Behind',
                  'none'    => 'Use Structure position'
              ),
              'label'     => 'Image Location',
              'tooltip'   => 'Choose where to display the image: Next to the <em>title</em>; In the <em>content</em>; <em>Behind</em> the excerpt content; or <em>Use structure position</em> to use the position set in the Structure settings.',
              'default'   => 'content',
              'name'      => 'image-location',
              'callbackx' => '
					if ($(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-image-location\').val() == \'behind\') {
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-images-content #input-ep-content-align-behind\').show();
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-images-content #input-ep-image-behind-heading\').show();
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-images-content #input-ep-title-tint-colour\').show();
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-images-content #input-ep-title-text-colour\').show();
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-images-content #input-ep-body-text-colour\').show();
					} else {
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-images-content #input-ep-content-align-behind\').hide();
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-images-content #input-ep-image-behind-heading\').hide();
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-images-content #input-ep-title-tint-colour\').hide();
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-images-content #input-ep-title-text-colour\').hide();
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-images-content #input-ep-body-text-colour\').hide();
					}
					if ($(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-image-location\').val() == \'behind\' ||
							$(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-image-location\').val() == \'none\'
						) {
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-images-content #input-image-position\').hide();
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-images-content #input-ep-image-captions\').hide();
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-images-content #input-align-excerpt\').hide();
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-images-content #input-image-width\').hide();
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-images-content #input-force-image-width\').show();
					} else {
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-images-content #input-image-position\').show();
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-images-content #input-ep-image-captions\').show();
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-images-content #input-align-excerpt\').show();
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-images-content #input-image-width\').show();
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-images-content #input-force-image-width\').hide();
					}
				'
          ),
          'ep-image-position'        => array(
              'type'    => 'select',
              'options' => array(
                  'left'   => 'Left',
                  'right'  => 'Right',
                  'center' => 'Centre'
              ),
              'label'   => 'Image Alignment',
              'tooltip' => 'Option to position image to the left, right or centre.',
              'default' => 'left',
              'name'    => 'image-position'
          ),
          'ep-use-attached-images'   => array(
              'type'    => 'checkbox',
              'label'   => 'Use attached images',
              'tooltip' => 'If checked, an image attached to the post from the WP Media Library will be shown if no Featured Image is set.<br/><strong>Note:</strong> Once an image is attached to a post, it always is, even if it is not displayed in the content so will show as an attached image to ExcerptsPlus. <em>This is a WP limitation</em>. The only way to unattach it is to delete the iamge from the Media Library. Also, some plugins may provide a method to detach images from posts.<br/><br/>Only WP Media Library images can be used. Directly linked images, whether internal or external to the site, cannot be shown by ExcerptsPlus as a thumbnail.',
              'default' => true,
              'name'    => 'ep-use-attached-images'
          ),
          'ep-image-captions'        => array(
              'type'    => 'checkbox',
              'label'   => 'Image captions',
              'tooltip' => 'If checked, image captions will be shown below the images.',
              'default' => false,
              'name'    => 'ep-image-captions'
          ),
          'ep-align-excerpt'         => array(
              'type'    => 'checkbox',
              'label'   => 'Align title, meta and content/excerpt with the image',
              'tooltip' => 'This will vertically align the all the text information with the image, instead of wrapping around the image.',
              'default' => false,
              'name'    => 'align-excerpt'
          ),
          'ep-image-borders'         => array(
              'type'    => 'checkbox',
              'label'   => 'Image Borders',
              'tooltip' => 'Show border around images.',
              'default' => true,
              'name'    => 'image-borders'
          ),
          'ep-recreate-images'       => array(
              'type'    => 'checkbox',
              'label'   => 'Do not recreate images for this block',
              'tooltip' => 'By default, this block\'s images will be recreated when publishing or refreshing in the Visual Editor. <br/>Once you are happy with the images for this block, then check this so they don\'t get rereated each time. <br/> This has no effect other than saving the time it takes to reload the Visual Editor.',
              'default' => false,
              'name'    => 'ep-recreate-images'
          ),
          'ep-max-image-dim'         => array(
              'type'    => 'text',
              'label'   => 'Maximum image dimensions (Recommended: 1000)',
              'tooltip' => 'This setting will limit source image maximum dimensions. eg. 1000x1000px. <br/>This is a preventative in case the site\'s users upload large dimension images - eg. 3000x2000 - which chew memory and slow down the system. <br/>Increasing this value may cause the site to break on larger images if it runs out of memory. <br/><strong>If an image exceeds this dimension, a grey box will display instead.</strong><br/>Leaving it blank or zero will process the image as normal.',
              'default' => null,
              'name'    => 'max-image-dim',
              'suffix'  => 'px'
          ),
          'ep-image-behind-heading'  => array(
              'name'  => 'ep-image-behind-heading',
              'type'  => 'heading',
              'label' => 'Image Behind'
          ),
          'ep-content-align-behind'  => array(
              'type'    => 'select',
              'options' => array(
                  'bottom' => 'Bottom',
                  'top'    => 'Top'
              ),
              'label'   => 'Vertical alignment when image location is behind',
              'tooltip' => 'Choose if you want the block of cells to align to the top or bottom of the image, when image location is set to Behind.',
              'default' => 'bottom',
              'name'    => 'ep-content-align-behind'
          ),
          'ep-title-tint-colour'     => array(
              'type'    => 'colorpicker',
              'label'   => 'Post title background tint colour (when Image Behind selected)',
              'tooltip' => 'Colour to use for the background tint.',
              'default' => '#000000',
              'name'    => 'ep-title-tint-colour'
          ),
          'ep-tint'                  => array(
              'type'            => 'slider',
              'label'           => 'Post title background tint for when Image Behind selected',
              'tooltip'         => 'The percentage of shading tint to use behind the text info when image location is set to behind.',
              'default'         => 80,
              'name'            => 'ep-tint',
              'slider-min'      => 0,
              'slider-max'      => 100,
              'slider-interval' => 5,
              'unit'            => '%'
          ),
          'ep-title-text-colour'     => array(
              'type'    => 'text',
              'label'   => 'Post title colour when Image Behind selected.',
              'tooltip' => 'Colour to use for the title text when Image Behind. Leave blank for defaults. Use HTML format. E.g. #2a7b9c',
              'default' => '',
              'name'    => 'ep-title-text-colour'
          ),
          'ep-body-text-colour'      => array(
              'type'    => 'text',
              'label'   => 'Post body colour when Image Behind selected.',
              'tooltip' => 'Colour to use for the content text when Image Behind. Leave blank for defaults. Use HTML format. E.g. #2a7b9c',
              'default' => '',
              'name'    => 'ep-body-text-colour'
          ),
          'ep-slide-content'         => array(
              'type'    => 'checkbox',
              'label'   => 'Slide content on hover',
              'tooltip' => 'Enable this to have the content hidden until the user mousues over the image and then it will slide into view. On touch devices this is disabled.',
              'default' => false,
              'name'    => 'ep-slide-content',
          ),
          'ep-image-sizing-heading'  => array(
              'name'  => 'ep-image-sizing-heading',
              'type'  => 'heading',
              'label' => 'Image Sizing'
          ),
          'ep-force-image-width'     => array(
              'type'      => 'checkbox',
              'label'     => 'Force image width',
              'tooltip'   => 'By default, ExcerptsPlus will calculate the image width to use when Image Location is Behind or Use Structure Postion. However, there may be times when you want to over-ride that, such as when you\'ve coded a fixed width for the block in custom css.<br/>This option forces it to use the image width you set above.',
              'default'   => false,
              'name'      => 'force-image-width',
              'toggle'    => array(
                 true  => array(
                      'show' => array(
                          '#input-image-width'
                      )
                  ),
                  false => array(
                      'hide' => array(
                          '#input-image-width'
                      )
                  )
              ),
              'callbackx' => '
					if (($(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-image-location\').val() == \'behind\' ||
							$(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-image-location\').val() == \'none\') &&
							$(\'div#block-\' + blockID + \'-tab\').find(\'#input-force-image-width  span.checkbox-checked\').length == \'1\' 
						) {
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-images-content #input-image-width\').show();
					}
					if (($(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-image-location\').val() == \'behind\' ||
							$(\'div#block-\' + blockID + \'-tab\').find(\'#input-\' + blockID + \'-image-location\').val() == \'none\') &&
							$(\'div#block-\' + blockID + \'-tab\').find(\'#input-force-image-width  span.checkbox-checked\').length != \'1\' 
						) {
						$(\'div#block-\' + blockID + \'-tab div#sub-tab-images-content #input-image-width\').hide();
					}
				'
          ),
          'ep-image-height'          => array(
              'type'    => 'integer',
              'label'   => 'Resize Image to Height',
              'tooltip' => 'Set the height for the displayed image.',
              'default' => 75,
              'name'    => 'image-height',
              'unit'    => 'px'
          ),
          'ep-image-width'           => array(
              'type'    => 'integer',
              'label'   => 'Resize Image to Width',
              'tooltip' => '<strong>Only applies when Force Image Width is enabled.</strong> <br><br>Set the width for the displayed image. <br/><strong>Note:</strong> Only applies when in image is content or title. Full width will be used otherwise.)',
              'default' => 75,
              'name'    => 'image-width',
              'unit'    => 'px'
          ),
          'ep-quality'               => array(
              'type'            => 'slider',
              'label'           => 'Image quality',
              'tooltip'         => 'Lower values will reduce the size of the file but also the clarity of the image. Higher values will make images slower loading.<br/>Value range is 0 to 100. If zero it will default to 70.',
              'default'         => 70,
              'name'            => 'ep-quality',
              'slider-min'      => 0,
              'slider-max'      => 100,
              'slider-interval' => 5,
              'unit'            => '%'
          ),
          'ep-cropping-heading'      => array(
              'name'  => 'ep-cropping-heading',
              'type'  => 'heading',
              'label' => 'Cropping'
          ),
          'ep-focal-point-align'     => array(
              'type'    => 'checkbox',
              'label'   => 'Respect Focal Point',
              'tooltip' => 'If selected and image used is a WordPress or GalleryPlus image, the focal point co-ordinates entered for the original image will determine crop alignment of the display images. Focal point is entered in the WP media page for the image.',
              'default' => true,
              'name'    => 'ep-focal-point-align',
          ),
          'ep-vertical-crop-align'   => array(
              'type'    => 'select',
              'options' => array(
                  'center'        => 'Centre',
                  'top'           => 'Top',
                  'topquarter'    => 'Top quarter',
                  'bottomquarter' => 'Bottom quarter',
                  'bottom'        => 'Bottom'
              ),
              'label'   => 'Vertical Crop Alignment',
              'tooltip' => 'If the resized image is cropped, do you want to crop from the centre out, top down, top quarter down, bottom quarter up, or bottom up? <br/><strong>Note:</strong>Due to the shape of some images, and settings, changes between different vertical cropping settings may not be noticable.',
              'default' => 'centre',
              'name'    => 'ep-vertical-crop-align'
          ),
          'ep-horizontal-crop-align' => array(
              'type'    => 'select',
              'options' => array(
                  'center'       => 'Centre',
                  'left'         => 'Left',
                  'leftquarter'  => 'Left quarter',
                  'rightquarter' => 'Right quarter',
                  'right'        => 'Right'
              ),
              'label'   => 'Horizontal Crop Alignment',
              'tooltip' => 'Choose how you want to horizontally align the main image when it crops',
              'default' => 'center',
              'name'    => 'ep-horizontal-crop-align'
          ),
          'ep-sizing-type'           => array(
              'type'    => 'select',
              'options' => array(
                  'crop'          => 'Crop width and height to fit',
                  'exact'         => 'Stretch to width and height (Warning: Can distort image)',
                  'portrait'      => 'Crop width, match height',
                  'landscape'     => 'Match width, crop height',
                  'auto'          => 'Fit within width and height',
                  'scaletowidth'  => 'Scale to resize width',
                  'scaletoheight' => 'Scale to resize height',
                  'none'          => 'No cropping, use original. (Use with care!)'
              ),
              'label'   => 'Image resizing method',
              'tooltip' => 'Choose how you want the image resized in respect of its width and height to the Image Resize Height and Width. If you choose scaling, images will not scale above their actual size. NOTE: No cropping should be used with care as the full original image is used. If it is large, page load will be slow. Image will still scale responsively to fit the cell.',
              'default' => 'crop',
              'name'    => 'ep-sizing-type'
          ),
          'ep-image-fill'            => array(
              'type'    => 'colorpicker',
              'label'   => 'Image fill colour',
              'tooltip' => 'Choose a fill colour to pad the resized image with when it doesn\'t fully fill the resized frame.',
              'default' => '#ffffff',
              'name'    => 'ep-image-fill'
          ),
      );

      return $settings;
    }

    static function ep_opt_sliders()
    {
      $settings = array(
          'ep-sliders-heading' => array(
              'name'  => 'ep-sliders-heading',
              'type'  => 'heading',
              'label' => 'Sliders'
          ),
          'ep-use-slider'      => array(
              'type'    => 'checkbox',
              'label'   => 'Display as a slider',
              'tooltip' => 'Display excerpts in a slider instead of a grid.',
              'default' => false,
              'name'    => 'use-slider',
              'toggle'  => array(
                  true  => array(
                      'show' => array(
                          '#input-slide-time',
                          '#input-transition-type',
                          '#input-transition-time',
                          '#input-pager-type',
                          '#input-background-type'
                      )
                  ),
                  false => array(
                      'hide' => array(
                          '#input-slide-time',
                          '#input-transition-type',
                          '#input-transition-time',
                          '#input-pager-type',
                          '#input-background-type'
                      )
                  )
              ),

          ),
          'ep-slide-time'      => array(
              'type'    => 'text',
              'label'   => 'Slide time',
              'tooltip' => 'Input (in seconds) how long each slide should be displayed. Enter 0 for click to change slides.',
              'default' => '8',
              'name'    => 'slide-time',
              'suffix'  => 'seconds'
          ),
          'ep-transition-type' => array(
              'type'    => 'select',
              'options' => array(
                  'fade'        => 'Fade',
                  'scrollLeft'  => 'Scroll Left',
                  'scrollRight' => 'Scroll Right',
                  'scrollUp'    => 'Scroll Up',
                  'scrollDown'  => 'Scroll Down',
                  'toss'        => 'Toss',
                  'none'        => 'None'
              ),
              'label'   => 'Slide Transition',
              'tooltip' => 'Select the type of transition you\'d like between slides.',
              'default' => 'fade',
              'name'    => 'transition-type'
          ),
          'ep-transition-time' => array(
              'type'    => 'text',
              'label'   => 'Transition time',
              'tooltip' => 'Input (in seconds) how long the transition should take.',
              'default' => '3.5',
              'name'    => 'transition-time',
              'suffix'  => 'seconds'
          ),
          'ep-pager-type'      => array(
              'type'    => 'select',
              'options' => array(
                  'bullets' => 'Bullets',
                  'numbers' => 'Numbers',
                  'none'    => 'None'
              ),
              'label'   => 'Pager type',
              'tooltip' => 'Select the type of display for the slide pager (i.e. navigation).',
              'default' => 'bullets',
              'name'    => 'pager-type'
          ),
          'ep-background-type' => array(
              'type'    => 'select',
              'options' => array(
                  'light' => 'Light',
                  'dark'  => 'Dark'
              ),
              'label'   => 'Is Block Background Light or Dark?',
              'tooltip' => 'Select whether the colour behind the navigation is a light or dark shade. (This does not change the background of the block, merely the colour of the pager.).',
              'default' => 'light',
              'name'    => 'background-type'
          )
      );

      return $settings;
    }

    static function ep_opt_developer($pzep_custom_fields = array())
    {
      $settings = array(
          'ep-permalinks-heading'           => array(
              'name'  => 'ep-permalinks-heading',
              'type'  => 'heading',
              'label' => 'Permalinks'
          ),
          'ep-permalink-rel'                => array(
              'type'    => 'textarea',
              'label'   => 'Permalink rel',
              'tooltip' => 'Value for the rel attribute of permalinks',
              'default' => 'bookmark',
              'name'    => 'permalink-rel'
          ),
          'ep-permalink-class'              => array(
              'type'    => 'text',
              'label'   => 'Permalink class',
              'tooltip' => 'Value for the class attribute of permalinks',
              'default' => 'ep-permalink',
              'name'    => 'permalink-class',
          ),
          'ep-custom-filter-heading'        => array(
              'name'  => 'ep-custom-filter-heading',
              'type'  => 'heading',
              'label' => 'Custom Field Filters'
          ),
          'ep-use-custom-filter'            => array(
              'type'    => 'checkbox',
              'label'   => 'Use custom field filter',
              'tooltip' => 'Use custom field filter. See WordPress Codex, Class Reference WP_Query, Custom Field Parameters for detailed usage information.',
              'default' => false,
              'name'    => 'ep-use-custom-filter',
          ),
          'ep-custom-filter-key'            => array(
              'type'    => 'select',
              'label'   => 'Custom field key',
              'tooltip' => 'Custom field key name. A WP install can have dozens and dozens of custom fields, so it\'s up to you to know the custom field name you require. <strong>It\'s up to you to ensure the chosen custom field is available to the post type being displayed</strong>. See WordPress Codex, Class Reference WP_Query, Custom Field Parameters for detailed usage information.',
              'default' => '',
              'options' => $pzep_custom_fields,
              'name'    => 'ep-custom-filter-key',
          ),
          'ep-custom-filter-type'           => array(
              'type'    => 'select',
              'label'   => 'Custom field type',
              'tooltip' => 'Custom field type. It\'s up to you to know how the data is stored. For example, the Types plugin stores dates in the numeric Unix timestamp format. Therefore, you would select Numeric here, and Timestamp for the field value format. See WordPress Codex, Class Reference WP_Query, Custom Field Parameters for detailed usage information.',
              'default' => 'CHAR',
              'options' => array(
                  'NUMERIC'  => 'NUMERIC',
                  'BINARY'   => 'BINARY',
                  'CHAR'     => 'CHAR',
                  'DATE'     => 'DATE',
                  'DATETIME' => 'DATETIME',
                  'DECIMAL'  => 'DECIMAL',
                  'SIGNED'   => 'SIGNED',
                  'TIME'     => 'TIME',
                  'UNSIGNED' => 'UNSIGNED'
              ),
              'name'    => 'ep-custom-filter-type',
          ),
          'ep-custom-filter-value'          => array(
              'type'    => 'text',
              'label'   => 'Filter value',
              'tooltip' => 'Filter value. See WordPress Codex, Class Reference WP_Query, Custom Field Parameters for detailed usage information.',
              'default' => '',
              'name'    => 'ep-custom-filter-value',
          ),
          'ep-custom-filter-value-type'     => array(
              'type'    => 'select',
              'label'   => 'Filter value type',
              'tooltip' => 'Filter value type. Set this to ensure correct matching with the field data type. E.g. For Types the plugin date fields set this to Timestamp, which will convert your Filter value to a timestamp value. See WordPress Codex, Class Reference WP_Query, Custom Field Parameters for detailed usage information.',
              'default' => 'string',
              'options' => array(
                  'numeric'   => 'Numeric',
                  'binary'    => 'True/False',
                  'string'    => 'String',
                  'date'      => 'Date',
                  'datetime'  => 'DateTime',
                  'time'      => 'Time',
                  'timestamp' => 'Timestamp'
              ),
              'name'    => 'ep-custom-filter-value-type',
          ),
          'ep-custom-filter-compare'        => array(
              'type'    => 'select',
              'label'   => 'Custom field compare',
              'tooltip' => 'Custom field compare. See WordPress Codex, Class Reference WP_Query, Custom Field Parameters for detailed usage information.',
              'default' => '=',
              'options' => array(
                  '='           => '=',
                  '!='          => '!=',
                  '>'           => '>',
                  '>='          => '>=',
                  '<'           => '<',
                  '<='          => '<=',
                  'LIKE'        => 'LIKE',
                  'NOT LIKE'    => 'NOT LIKE',
                  'IN'          => 'IN',
                  'NOT IN'      => 'NOT IN',
                  'BETWEEN'     => 'BETWEEN',
                  'NOT BETWEEN' => 'NOT BETWEEN',
                  'EXISTS'      => 'EXISTS',
                  'NOT EXISTS'  => 'NOT EXISTS'
              ),
              'name'    => 'ep-custom-filter-compare',
          ),
          //				'ep-custom-filter-sql-heading'		 => array(
          //						'name'	 => 'ep-custom-filter-sql-heading',
          //						'type'	 => 'heading',
          //						'label'	 => 'Custom Field SQL'
          //				),
          //				'ep-custom-where-sql'							 => array(
          //						'type'		 => 'textarea',
          //						'label'		 => 'Custom filter sql',
          //						'tooltip'	 => 'Custom where clause sql. See WordPress Codex, Class Reference WP_Query, Custom Field Parameters for detailed usage information.',
          //						'default'	 => '',
          //						'name'		 => 'ep-custom-where-sql',
          //				),
          'ep-custom-sort'                  => array(
              'name'  => 'ep-custom-sort',
              'type'  => 'heading',
              'label' => 'Custom field sorting'
          ),
          'ep-use-custom-sort'              => array(
              'type'    => 'checkbox',
              'label'   => 'Use custom field sort',
              'tooltip' => 'Use custom field sort. See WordPress Codex, Class Reference WP_Query, Custom Field Parameters for detailed usage information.',
              'default' => false,
              'name'    => 'ep-use-custom-sort',
          ),
          'ep-custom-filter-key-sort'       => array(
              'type'    => 'select',
              'label'   => 'Custom field sort key',
              'tooltip' => 'Custom field sort key name. A WP install can have dozens and dozens of custom fields, so it\'s up to you to know the custom field name you require. The Types plugin prefixes it\'s field names with "wpcf-". See WordPress Codex, Class Reference WP_Query, Custom Field Parameters for detailed usage information.',
              'default' => '',
              'options' => $pzep_custom_fields,
              'name'    => 'ep-custom-filter-sort-key',
          ),
          'ep-custom-filter-key-sort-order' => array(
              'type'    => 'select',
              'label'   => 'Custom field sort key order',
              'tooltip' => 'Custom field sort key order. See WordPress Codex, Class Reference WP_Query, Custom Field Parameters for detailed usage information.',
              'default' => 'ASC',
              'options' => array(
                  'ASC'  => 'Ascending',
                  'DESC' => 'Descending'
              ),
              'name'    => 'ep-custom-filter-sort-key-order',
          ),
          'ep-debug-heading'                => array(
              'name'  => 'ep-debug-heading',
              'type'  => 'heading',
              'label' => 'Debug'
          ),
          'ep-debug'                        => array(
              'type'    => 'checkbox',
              'label'   => 'Show debug info',
              'tooltip' => 'Displays information useful for developer debugging.',
              'default' => false,
              'name'    => 'debug'
          ),
          'ep-show-custom-request'          => array(
              'type'    => 'checkbox',
              'label'   => 'Show custom request',
              'tooltip' => 'For debugging only, you can show the SELECT statement including your cusotm where and/or sort.',
              'default' => false,
              'name'    => 'ep-show-custom-request',
          ),
          'ep-hooks-heading'                => array(
              'name'  => 'ep-hooks-heading',
              'type'  => 'heading',
              'label' => 'Hooks'
          ),
          'ep-top-of-block'                 => array(
              'type'    => 'textarea',
              'label'   => 'Top of block',
              'tooltip' => 'Code entered here will target the hook named ep_top_of_block. Note: It will appear after the block title though, if set.',
              'default' => null,
              'name'    => 'ep-top-of-block'
          ),
          'ep-before-loop-start'            => array(
              'type'    => 'textarea',
              'label'   => 'Before Loop start',
              'tooltip' => 'Code entered here will target the hook named ep_before_loop_start. Note: It will appear before everything except the block title and is inside "The Loop" but not inside the looping - if that makes sense! Useful for things like showing WPPageNavi at the top of the block.',
              'default' => null,
              'name'    => 'ep-before-loop-start'
          ),
          'ep-before-title'                 => array(
              'type'    => 'textarea',
              'label'   => 'Before title',
              'tooltip' => 'Code entered here will target the hook named ep_before_title',
              'default' => null,
              'name'    => 'ep-before-title'
          ),
          'ep-after-title'                  => array(
              'type'    => 'textarea',
              'label'   => 'After title',
              'tooltip' => 'Code entered here will target the hook named ep_after_title',
              'default' => null,
              'name'    => 'ep-after-title'
          ),
          'ep-before-meta1'                 => array(
              'type'    => 'textarea',
              'label'   => 'Before meta1',
              'tooltip' => 'Code entered here will target the hook named ep_before_meta1',
              'default' => null,
              'name'    => 'ep-before-meta1'
          ),
          'ep-after-meta1'                  => array(
              'type'    => 'textarea',
              'label'   => 'After meta1',
              'tooltip' => 'Code entered here will target the hook named ep_after_meta1',
              'default' => null,
              'name'    => 'ep-after-meta1'
          ),
          'ep-before-meta2'                 => array(
              'type'    => 'textarea',
              'label'   => 'Before meta2',
              'tooltip' => 'Code entered here will target the hook named ep_before_meta2',
              'default' => null,
              'name'    => 'ep-before-meta2'
          ),
          'ep-after-meta2'                  => array(
              'type'    => 'textarea',
              'label'   => 'After meta2',
              'tooltip' => 'Code entered here will target the hook named ep_after_meta2',
              'default' => null,
              'name'    => 'ep-after-meta2'
          ),
          'ep-before-image'                 => array(
              'type'    => 'textarea',
              'label'   => 'Before image',
              'tooltip' => 'Code entered here will target the hook named ep_before_image',
              'default' => null,
              'name'    => 'ep-before-image'
          ),
          'ep-after-image'                  => array(
              'type'    => 'textarea',
              'label'   => 'After image',
              'tooltip' => 'Code entered here will target the hook named ep_after_image',
              'default' => null,
              'name'    => 'ep-after-image'
          ),
          'ep-before-content'               => array(
              'type'    => 'textarea',
              'label'   => 'Before content',
              'tooltip' => 'Code entered here will target the hook named ep_before_content',
              'default' => null,
              'name'    => 'ep-before-content'
          ),
          'ep-after-content'                => array(
              'type'    => 'textarea',
              'label'   => 'After content',
              'tooltip' => 'Code entered here will target the hook named ep_after_content',
              'default' => null,
              'name'    => 'ep-after-content'
          ),
          'ep-before-cellrow1'              => array(
              'type'    => 'textarea',
              'label'   => 'Before cell row 1',
              'tooltip' => 'Code entered here will target the hook named ep_before_cellrow1',
              'default' => null,
              'name'    => 'ep-before-cellrow1'
          ),
          'ep-after-cellrow1'               => array(
              'type'    => 'textarea',
              'label'   => 'After cell row 1',
              'tooltip' => 'Code entered here will target the hook named ep_after_cellrow1',
              'default' => null,
              'name'    => 'ep-after-cellrow1'
          ),
          'ep-after-cellrow2'               => array(
              'type'    => 'textarea',
              'label'   => 'After cell row 2',
              'tooltip' => 'Code entered here will target the hook named ep_after_cellrow2',
              'default' => null,
              'name'    => 'ep-after-cellrow2'
          ),
          'ep-after-cellrow3'               => array(
              'type'    => 'textarea',
              'label'   => 'After cell row 3',
              'tooltip' => 'Code entered here will target the hook named ep_after_cellrow3',
              'default' => null,
              'name'    => 'ep-after-cellrow3'
          ),
          'ep-after-cellrow4'               => array(
              'type'    => 'textarea',
              'label'   => 'After cell row 4',
              'tooltip' => 'Code entered here will target the hook named ep_after_cellrow4',
              'default' => null,
              'name'    => 'ep-after-cellrow4'
          ),
          'ep-after-cellrow5'               => array(
              'type'    => 'textarea',
              'label'   => 'After cell row 5',
              'tooltip' => 'Code entered here will target the hook named ep_after_cellrow5',
              'default' => null,
              'name'    => 'ep-after-cellrow5'
          ),
          'ep-bottom-of-block'              => array(
              'type'    => 'textarea',
              'label'   => 'Bottom of block',
              'tooltip' => 'Code entered here will target the hook named ep_bottom_of_block.',
              'default' => null,
              'name'    => 'ep-bottom-of-block'
          ),
          'ep-styling-heading'              => array(
              'name'  => 'ep-styling-heading',
              'type'  => 'heading',
              'label' => 'Advanced Styling'
          ),
          'ep-style-block-title'            => array(
              'type'    => 'textarea',
              'label'   => 'Block Title',
              'tooltip' => 'Input custom CSS to style the block title (if used). Is applied to CSS selector: .ep-block-title',
              'default' => '',
              'name'    => 'ep-style-block-title'
          ),
          'ep-style-block'                  => array(
              'type'    => 'textarea',
              'label'   => 'Block',
              'tooltip' => 'Input custom CSS to style the block. Is applied to CSS selector: .excerpts-plus',
              'default' => '',
              'name'    => 'ep-style-block'
          ),
          'ep-style-cell-wrapper'           => array(
              'type'    => 'textarea',
              'label'   => 'Excerpt+ Cell Wrapper',
              'tooltip' => 'Input custom CSS to style each excerpt+ cell wrapper. This includes the cell footer. Is applied to CSS selector: .excerpts-plus-excerpt',
              'default' => '',
              'name'    => 'ep-style-cell-wrapper'
          ),
          'ep-style-cell'                   => array(
              'type'    => 'textarea',
              'label'   => 'Cell',
              'tooltip' => 'Input custom CSS to style each excerpt+ cell. This excludes the cell footer. Is applied to CSS selector: .ep-cell',
              'default' => '',
              'name'    => 'ep-style-cell'
          ),
          'ep-style-cellrow1'               => array(
              'type'    => 'textarea',
              'label'   => 'Cell Row 1',
              'tooltip' => 'Input custom CSS to style cell row 1. Is applied to CSS selector: .ep-cellrow1',
              'default' => '',
              'name'    => 'ep-style-cellrow1'
          ),
          'ep-style-cellrow2'               => array(
              'type'    => 'textarea',
              'label'   => 'Cell Row 2',
              'tooltip' => 'Input custom CSS to style cell row 2. Is applied to CSS selector: .ep-cellrow2',
              'default' => '',
              'name'    => 'ep-style-cellrow2'
          ),
          'ep-style-cellrow3'               => array(
              'type'    => 'textarea',
              'label'   => 'Cell Row 3',
              'tooltip' => 'Input custom CSS to style cell row 3. Is applied to CSS selector: .ep-cellrow3',
              'default' => '',
              'name'    => 'ep-style-cellrow3'
          ),
          'ep-style-cellrow4'               => array(
              'type'    => 'textarea',
              'label'   => 'Cell Row 4',
              'tooltip' => 'Input custom CSS to style cell row 4. Is applied to CSS selector: .ep-cellrow4',
              'default' => '',
              'name'    => 'ep-style-cellrow4'
          ),
          'ep-style-cellrow5'               => array(
              'type'    => 'textarea',
              'label'   => 'Cell Row 5',
              'tooltip' => 'Input custom CSS to style cell row 5. Is applied to CSS selector: .ep-cellrow5',
              'default' => '',
              'name'    => 'ep-style-cellrow5'
          ),
          'ep-style-cell-footer'            => array(
              'type'    => 'textarea',
              'label'   => 'Cell footer',
              'tooltip' => 'Input custom CSS to style cell footer. Is applied to CSS selector: .ep-cell-footer',
              'default' => '',
              'name'    => 'ep-style-cell-footer'
          ),
          'ep-style-read-more'              => array(
              'type'    => 'textarea',
              'label'   => 'Read more',
              'tooltip' => 'Input custom CSS to style the Read More link. Is applied to CSS selector: .excerpt-read-more',
              'default' => '',
              'name'    => 'ep-style-read-more'
          ),
          'ep-style-page-nav'               => array(
              'type'    => 'textarea',
              'label'   => 'Page Navigation',
              'tooltip' => 'Input custom CSS to style page navigation buttons. Is applied to CSS selector: .ep-nav',
              'default' => '',
              'name'    => 'ep-style-nav'
          ),
      );

      return $settings;
    }

    static function ep_opt_info()
    {
      $settings = array();

      return $settings;
    }

    static function ep_get_categories()
    {
      // Grabs all WP categories to an array, and adds a first option of All
      // You will need to wrangle your own code to make use of the All
      $categories_select_query = get_categories('hide_empty=0');
      $categories_array        = array('all' => 'All');
      foreach ($categories_select_query as $category) {
        $categories_array[ $category->cat_ID ] = $category->cat_name;
      }

      // $ep_custom_tax = get_taxonomies();
      // foreach ($ep_custom_tax as $tax) {
      // 	if ($tax != 'nav_menu' && $tax != 'link_category' && $tax != 'post_format') {
      // 		$tax_name = ($tax=='post_tag') ? 'Tags' : ucwords($tax);
      // 		// $tax_array[$tax] = array();
      // 		// $tax_array[$tax]['all'] = 'All in '.$tax_name;
      // 		$tax_array['tax-'.$tax_name] = 'All in '.$tax_name;
      // 		$terms = get_terms($tax);
      // 		foreach ($terms as $term) {
      // 			$tax_array[$term->term_id] = '&nbsp;&nbsp;'.$term->name;
      // 		}
      // 		$tax_array['end-'.$tax_name] = '--------------';
      // 	}
      // }
      // return $tax_array;

      return $categories_array;
    }

    /**
     * [get_settings description]
     * @param  [type] $block
     * @return [type]
     */
    static function get_settings($block)
    {
      if (is_integer($block)) {
        $block = UpFrontBlocksData::get_block($block);
      }
      $settings = array();
      $options  = array_merge(
          self::ep_opt_structure(),
          self::ep_opt_responsive(),
          self::ep_opt_behaviour($block, 'yes'),
          self::ep_opt_titles(),
          self::ep_opt_content($block, 'yes'),
          self::ep_opt_meta(),
          self::ep_opt_custom_fields(null),
          self::ep_opt_images(),
          self::ep_opt_sliders(),
          self::ep_opt_developer(null),
          self::ep_opt_info()
      );

      foreach ($options as $option) {
        $settings[ $option[ 'name' ] ] = UpFrontBlockAPI::get_setting($block, $option[ 'name' ], (!isset($option[ 'default' ]) ? null : $option[ 'default' ]));
      }

      return $settings;
    }

  }

