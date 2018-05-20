<?php

// URL Shortener widget
class Url_shortener_widget extends WP_Widget {

	// Register widget
	function __construct() {
		parent::__construct(
			'url_shortener_widget',
			esc_html__( 'URL Shortener', 'url-shortener' ),
			array( 'description' => esc_html__( 'Show list of links as a widget in your website', 'url-shortener' ), )
		);
	}

	// List of widget fields
	private $widget_fields = array(
		array(
			'label' => 'Number of Links',
			'id' => 'number_of_links',
			'default' => '5',
			'type' => 'number',
		),
		array(
			'label' => 'Show Hits',
			'id' => 'show_hits',
			'default' => '1',
			'type' => 'checkbox',
		),
	);

	// Front-end of the widget
	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
        // todo: cache request, use try cactch
        $api_url = get_option('url_shortener_api_url');
        $data = wp_remote_get( trim($api_url, '/') . '/index');
        $urls = $data['body'];
        $urls = json_decode($urls, true);
        $printed_count = 0;
        echo '<ul>';
        foreach ($urls as $url) {
            $printed_count++;
            $link = '<li></li><a href="%short_link%">%short_link%%hits%</a></li>';
            $short_link = $url['short_link'];
            $hits = $instance['show_hits']? ' (' . $url['hits'] . ')' : '';
            echo str_replace(['%short_link%', '%hits%'], [$short_link, $hits], $link);
        }
        echo '</ul>';
		echo $args['after_widget'];
	}

	// Back-end widget fields
	public function field_generator( $instance ) {
		$output = '';
		foreach ( $this->widget_fields as $widget_field ) {
			$widget_value = ! empty( $instance[$widget_field['id']] ) ? $instance[$widget_field['id']] : esc_html__( $widget_field['default'], 'url-shortener' );
			switch ( $widget_field['type'] ) {
				case 'checkbox':
					$output .= '<p>';
					$output .= '<input class="checkbox" type="checkbox" '.checked( $widget_value, true, false ).' id="'.esc_attr( $this->get_field_id( $widget_field['id'] ) ).'" name="'.esc_attr( $this->get_field_id( $widget_field['id'] ) ).'" value="1">';
					$output .= '<label for="'.esc_attr( $this->get_field_id( $widget_field['id'] ) ).'">'.esc_attr( $widget_field['label'], 'url-shortener' ).'</label>';
					$output .= '</p>';
					break;
				default:
					$output .= '<p>';
					$output .= '<label for="'.esc_attr( $this->get_field_id( $widget_field['id'] ) ).'">'.esc_attr( $widget_field['label'], 'url-shortener' ).':</label> ';
					$output .= '<input class="widefat" id="'.esc_attr( $this->get_field_id( $widget_field['id'] ) ).'" name="'.esc_attr( $this->get_field_name( $widget_field['id'] ) ).'" type="'.$widget_field['type'].'" value="'.esc_attr( $widget_value ).'">';
					$output .= '</p>';
			}
		}
		echo $output;
	}

	// Outputs the options form on admin
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( '', 'url-shortener' );
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'url-shortener' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php
		$this->field_generator( $instance );
	}

	// Sanitize and save
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		foreach ( $this->widget_fields as $widget_field ) {
			switch ( $widget_field['type'] ) {
				case 'checkbox':
					$instance[$widget_field['id']] = $_POST[$this->get_field_id( $widget_field['id'] )];
					break;
				default:
					$instance[$widget_field['id']] = ( ! empty( $new_instance[$widget_field['id']] ) ) ? strip_tags( $new_instance[$widget_field['id']] ) : '';
			}
		}
		return $instance;
	}
}