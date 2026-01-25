<?php
/**
 * Base47 Theme Widget Areas
 * Competitive widget system like Astra, OceanWP, etc.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register widget areas
 */
function base47_widgets_init() {
    
    // Header Widget Area
    register_sidebar( array(
        'name'          => __( 'Header Widget Area', 'base47-theme' ),
        'id'            => 'header-widget-area',
        'description'   => __( 'Widgets in this area will be shown in the header (contact info, social icons, etc.)', 'base47-theme' ),
        'before_widget' => '<div id="%1$s" class="widget header-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    // Primary Sidebar
    register_sidebar( array(
        'name'          => __( 'Primary Sidebar', 'base47-theme' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'Main sidebar that appears on blog pages and posts', 'base47-theme' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    // Footer Widget Area 1
    register_sidebar( array(
        'name'          => __( 'Footer Widget Area 1', 'base47-theme' ),
        'id'            => 'footer-1',
        'description'   => __( 'First footer widget area', 'base47-theme' ),
        'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ) );

    // Footer Widget Area 2
    register_sidebar( array(
        'name'          => __( 'Footer Widget Area 2', 'base47-theme' ),
        'id'            => 'footer-2',
        'description'   => __( 'Second footer widget area', 'base47-theme' ),
        'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ) );

    // Footer Widget Area 3
    register_sidebar( array(
        'name'          => __( 'Footer Widget Area 3', 'base47-theme' ),
        'id'            => 'footer-3',
        'description'   => __( 'Third footer widget area', 'base47-theme' ),
        'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ) );

    // Footer Widget Area 4
    register_sidebar( array(
        'name'          => __( 'Footer Widget Area 4', 'base47-theme' ),
        'id'            => 'footer-4',
        'description'   => __( 'Fourth footer widget area', 'base47-theme' ),
        'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ) );
}
add_action( 'widgets_init', 'base47_widgets_init' );

/**
 * Custom widgets for Base47 theme
 */

// Social Media Widget
class Base47_Social_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'base47_social_widget',
            __( 'Base47 Social Media', 'base47-theme' ),
            array( 'description' => __( 'Display social media icons', 'base47-theme' ) )
        );
    }

    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }

        echo '<div class="base47-social-icons">';
        
        $social_networks = array(
            'facebook' => 'Facebook',
            'twitter' => 'Twitter', 
            'instagram' => 'Instagram',
            'linkedin' => 'LinkedIn',
            'youtube' => 'YouTube'
        );

        foreach ( $social_networks as $network => $label ) {
            if ( ! empty( $instance[$network] ) ) {
                echo '<a href="' . esc_url( $instance[$network] ) . '" target="_blank" rel="noopener" class="social-' . $network . '">';
                echo '<span class="screen-reader-text">' . $label . '</span>';
                echo '<i class="fab fa-' . $network . '"></i>';
                echo '</a>';
            }
        }
        
        echo '</div>';
        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
        
        $social_networks = array(
            'facebook' => 'Facebook',
            'twitter' => 'Twitter',
            'instagram' => 'Instagram', 
            'linkedin' => 'LinkedIn',
            'youtube' => 'YouTube'
        );
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <?php
        foreach ( $social_networks as $network => $label ) {
            $value = ! empty( $instance[$network] ) ? $instance[$network] : '';
            ?>
            <p>
                <label for="<?php echo $this->get_field_id( $network ); ?>"><?php echo $label; ?> URL:</label>
                <input class="widefat" id="<?php echo $this->get_field_id( $network ); ?>" name="<?php echo $this->get_field_name( $network ); ?>" type="url" value="<?php echo esc_attr( $value ); ?>">
            </p>
            <?php
        }
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
        
        $social_networks = array( 'facebook', 'twitter', 'instagram', 'linkedin', 'youtube' );
        foreach ( $social_networks as $network ) {
            $instance[$network] = ( ! empty( $new_instance[$network] ) ) ? esc_url_raw( $new_instance[$network] ) : '';
        }
        
        return $instance;
    }
}

// Contact Info Widget
class Base47_Contact_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'base47_contact_widget',
            __( 'Base47 Contact Info', 'base47-theme' ),
            array( 'description' => __( 'Display contact information', 'base47-theme' ) )
        );
    }

    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }

        echo '<div class="base47-contact-info">';
        
        if ( ! empty( $instance['phone'] ) ) {
            echo '<div class="contact-item phone">';
            echo '<i class="fas fa-phone"></i>';
            echo '<a href="tel:' . esc_attr( $instance['phone'] ) . '">' . esc_html( $instance['phone'] ) . '</a>';
            echo '</div>';
        }
        
        if ( ! empty( $instance['email'] ) ) {
            echo '<div class="contact-item email">';
            echo '<i class="fas fa-envelope"></i>';
            echo '<a href="mailto:' . esc_attr( $instance['email'] ) . '">' . esc_html( $instance['email'] ) . '</a>';
            echo '</div>';
        }
        
        if ( ! empty( $instance['address'] ) ) {
            echo '<div class="contact-item address">';
            echo '<i class="fas fa-map-marker-alt"></i>';
            echo '<span>' . esc_html( $instance['address'] ) . '</span>';
            echo '</div>';
        }
        
        echo '</div>';
        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $phone = ! empty( $instance['phone'] ) ? $instance['phone'] : '';
        $email = ! empty( $instance['email'] ) ? $instance['email'] : '';
        $address = ! empty( $instance['address'] ) ? $instance['address'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'phone' ); ?>"><?php _e( 'Phone:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'phone' ); ?>" name="<?php echo $this->get_field_name( 'phone' ); ?>" type="text" value="<?php echo esc_attr( $phone ); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'email' ); ?>"><?php _e( 'Email:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'email' ); ?>" name="<?php echo $this->get_field_name( 'email' ); ?>" type="email" value="<?php echo esc_attr( $email ); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'address' ); ?>"><?php _e( 'Address:' ); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id( 'address' ); ?>" name="<?php echo $this->get_field_name( 'address' ); ?>" rows="3"><?php echo esc_textarea( $address ); ?></textarea>
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
        $instance['phone'] = ( ! empty( $new_instance['phone'] ) ) ? sanitize_text_field( $new_instance['phone'] ) : '';
        $instance['email'] = ( ! empty( $new_instance['email'] ) ) ? sanitize_email( $new_instance['email'] ) : '';
        $instance['address'] = ( ! empty( $new_instance['address'] ) ) ? sanitize_textarea_field( $new_instance['address'] ) : '';
        
        return $instance;
    }
}

// Register custom widgets
function base47_register_widgets() {
    register_widget( 'Base47_Social_Widget' );
    register_widget( 'Base47_Contact_Widget' );
}
add_action( 'widgets_init', 'base47_register_widgets' );