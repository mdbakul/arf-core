<?php

namespace TPCore\Widgets;
use Elementor\Controls_Manager;

#theme builder trait

trait tpTraitBuilder {
    // builder button/links
    protected function tp_builder_button_links($control_id = null, $control_name = 'box', $condition_id ="tp_header_right_switch", $control_condition = 'yes'){
        $this->start_controls_section(
            'tp_'.$control_id,
                [
                  'label' => esc_html__( ''.$control_name.'', 'tpcore' ),
                  'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                  'condition' => [
                    $condition_id => $control_condition 
                  ],
                ]
           );
           $this->add_control(
               'tp_'.$control_id.'_switcher',
               [
                   'label' => esc_html__( 'Add '.$control_name.' link', 'tpcore' ),
                   'type' => \Elementor\Controls_Manager::SWITCHER,
                   'label_on' => esc_html__( 'Yes', 'tpcore' ),
                   'label_off' => esc_html__( 'No', 'tpcore' ),
                   'return_value' => 'yes',
                   'default' => 'yes',
                   'separator' => 'before',
               ]
           );
           $this->add_control(
               'tp_'.$control_id.'_text',
               [
                   'label' => esc_html__('Button Text', 'tpcore'),
                   'type' => Controls_Manager::TEXT,
                   'default' => esc_html__('Button Text', 'tpcore'),
                   'title' => esc_html__('Enter button text', 'tpcore'),
                   'label_block' => true,
                   'condition' => [
                       'tp_'.$control_id.'_switcher' => 'yes'
                   ],
               ]
           );
           $this->add_control(
               'tp_'.$control_id.'_link_type',
               [
                   'label' => esc_html__( ''.$control_name.' Link Type', 'tpcore' ),
                   'type' => \Elementor\Controls_Manager::SELECT,
                   'options' => [
                       '1' => 'Custom Link',
                       '2' => 'Internal Page',
                   ],
                   'default' => '1',
                   'condition' => [
                       'tp_'.$control_id.'_switcher' => 'yes'
                   ]
               ]
           );
           $this->add_control(
               'tp_'.$control_id.'_link',
               [
                   'label' => esc_html__( ''.$control_name.' Link link', 'tpcore' ),
                   'type' => \Elementor\Controls_Manager::URL,
                   'dynamic' => [
                       'active' => true,
                   ],
                   'placeholder' => esc_html__( 'https://your-link.com', 'tpcore' ),
                   'show_external' => true,
                   'default' => [
                       'url' => '#',
                       'is_external' => false,
                       'nofollow' => false,
                   ],
                   'condition' => [
                       'tp_'.$control_id.'_link_type' => '1',
                       'tp_'.$control_id.'_switcher' => 'yes',
                   ]
               ]
           );
           $this->add_control(
               'tp_'.$control_id.'_page_link',
               [
                   'label' => esc_html__( 'Select '.$control_name.' Link Page', 'tpcore' ),
                   'type' => \Elementor\Controls_Manager::SELECT2,
                   'label_block' => true,
                   'options' => tp_get_all_pages(),
                   'condition' => [
                       'tp_'.$control_id.'_link_type' => '2',
                       'tp_'.$control_id.'_switcher' => 'yes',
                   ]
               ]
           );
   
           $this->end_controls_section();
    }

    // builder button/links 2
    protected function tp_builder_button_links2($control_id = null, $control_name = 'box'){
        $this->start_controls_section(
            'tp_'.$control_id,
                [
                  'label' => esc_html__( ''.$control_name.'', 'tpcore' ),
                  'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
           );
           $this->add_control(
               'tp_'.$control_id.'_switcher',
               [
                   'label' => esc_html__( 'Add '.$control_name.' link', 'tpcore' ),
                   'type' => \Elementor\Controls_Manager::SWITCHER,
                   'label_on' => esc_html__( 'Yes', 'tpcore' ),
                   'label_off' => esc_html__( 'No', 'tpcore' ),
                   'return_value' => 'yes',
                   'default' => 'yes',
                   'separator' => 'before',
               ]
           );
           $this->add_control(
               'tp_'.$control_id.'_text',
               [
                   'label' => esc_html__('Button Text', 'tpcore'),
                   'type' => Controls_Manager::TEXT,
                   'default' => esc_html__('Button Text', 'tpcore'),
                   'title' => esc_html__('Enter button text', 'tpcore'),
                   'label_block' => true,
                   'condition' => [
                       'tp_'.$control_id.'_switcher' => 'yes'
                   ],
               ]
           );
           $this->add_control(
               'tp_'.$control_id.'_link_type',
               [
                   'label' => esc_html__( ''.$control_name.' Link Type', 'tpcore' ),
                   'type' => \Elementor\Controls_Manager::SELECT,
                   'options' => [
                       '1' => 'Custom Link',
                       '2' => 'Internal Page',
                   ],
                   'default' => '1',
                   'condition' => [
                       'tp_'.$control_id.'_switcher' => 'yes'
                   ]
               ]
           );
           $this->add_control(
               'tp_'.$control_id.'_link',
               [
                   'label' => esc_html__( ''.$control_name.' Link link', 'tpcore' ),
                   'type' => \Elementor\Controls_Manager::URL,
                   'dynamic' => [
                       'active' => true,
                   ],
                   'placeholder' => esc_html__( 'https://your-link.com', 'tpcore' ),
                   'show_external' => true,
                   'default' => [
                       'url' => '#',
                       'is_external' => false,
                       'nofollow' => false,
                   ],
                   'condition' => [
                       'tp_'.$control_id.'_link_type' => '1',
                       'tp_'.$control_id.'_switcher' => 'yes',
                   ]
               ]
           );
           $this->add_control(
               'tp_'.$control_id.'_page_link',
               [
                   'label' => esc_html__( 'Select '.$control_name.' Link Page', 'tpcore' ),
                   'type' => \Elementor\Controls_Manager::SELECT2,
                   'label_block' => true,
                   'options' => tp_get_all_pages(),
                   'condition' => [
                       'tp_'.$control_id.'_link_type' => '2',
                       'tp_'.$control_id.'_switcher' => 'yes',
                   ]
               ]
           );
   
           $this->end_controls_section();
    }
}