<?php

namespace Elementor;

class Icon_Text_Marquee_Widget extends Widget_Base {

    public function get_name() {
        return 'icon-text-marquee';
    }

    public function get_title() {
        return __( 'Icon Text Marquee', 'icon-text-marquee' );
    }

    public function get_icon() {
        return 'eicon-marquee'; // Choose an appropriate icon
    }

    public function get_categories() {
        return [ 'general' ];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'icon-text-marquee' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'items',
            [
                'label' => __( 'Items', 'icon-text-marquee' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'image',
                        'label' => __( 'Image', 'icon-text-marquee' ),
                        'type' => Controls_Manager::MEDIA,
                    ],
                    [
                        'name' => 'text',
                        'label' => __( 'Text', 'icon-text-marquee' ),
                        'type' => Controls_Manager::TEXT,
                        'default' => __( 'Mine Text', 'icon-text-marquee' ),
                    ],
                ],
                'title_field' => '{{{ text }}}',
            ]
        );

        $this->end_controls_section();

        // New styling section
        $this->start_controls_section(
            'style_section',
            [
                'label' => __( 'Style', 'icon-text-marquee' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        // Typography control for text
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'text_typography',
                'label' => __( 'Typography', 'icon-text-marquee' ),
                'selector' => '{{WRAPPER}} .mr-item span',
            ]
        );

        // Text color control
        $this->add_control(
            'text_color',
            [
                'label' => __( 'Text Color', 'icon-text-marquee' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#000', // Default color
                'selectors' => [
                    '{{WRAPPER}} .mr-item span' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Background color control
        $this->add_control(
            'background_color',
            [
                'label' => __( 'Background Color', 'icon-text-marquee' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#32F9E2', // Default color
                'selectors' => [
                    '{{WRAPPER}} .logos' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'background_type' => 'solid',
                ],
            ]
        );

        // Background gradient control
        $this->add_control(
            'background_gradient',
            [
                'label' => __( 'Gradient Background', 'icon-text-marquee' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => 'Enter gradient CSS (e.g. linear-gradient(to right, #00CBBC, #32F9E2))',
                'label_block' => true,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .logos' => 'background: {{VALUE}};',
                ],
                'condition' => [
                    'background_type' => 'gradient',
                ],
            ]
        );

        // Background type switch
        $this->add_control(
            'background_type',
            [
                'label' => __( 'Background Type', 'icon-text-marquee' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'solid',
                'options' => [
                    'solid' => __( 'Solid Color', 'icon-text-marquee' ),
                    'gradient' => __( 'Gradient', 'icon-text-marquee' ),
                ],
            ]
        );

        // Image width control
        $this->add_control(
            'image_width',
            [
                'label' => __( 'Image Width', 'icon-text-marquee' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 200,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 50, // Default width
                ],
                'selectors' => [
                    '{{WRAPPER}} .logos-slide img' => 'width: {{SIZE}}px;',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $items = $settings['items'];
        $number_of_slides = 4; // Number of slides
    
        // Determine background style
        $background_style = '';
        if (isset($settings['background_type']) && $settings['background_type'] === 'gradient') {
            $background_style = 'background: ' . esc_attr($settings['background_gradient']) . ';';
        } else {
            $background_style = 'background-color: ' . (isset($settings['background_color']) ? esc_attr($settings['background_color']) : '#32F9E2') . ';'; // Default color
        }
    
        ?>
        <div class="logos" style="<?php echo $background_style; ?>">
            <?php for ($i = 0; $i < $number_of_slides; $i++): ?>
                <div class="logos-slide">
                    <?php foreach ($items as $item): ?>
                        <div class="mr-item">
                            <img src="<?php echo esc_url($item['image']['url']); ?>" alt="">
                            <span style="color: <?php echo esc_attr($settings['text_color']); ?>;"><?php echo esc_html($item['text']); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endfor; ?>
        </div>
        <?php
    }
    
}
