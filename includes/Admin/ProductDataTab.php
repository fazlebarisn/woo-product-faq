<?php

namespace Woo\Faq\Admin;

class ProductDataTab{

    public function __construct()
    {
        add_filter( 'woocommerce_product_data_tabs' , [ $this , 'faq_product_edit_tab'] );
        add_filter( 'woocommerce_product_data_panels' , [ $this , 'faq_product_tab_options'] );
        add_action( 'faq_woocommerce_product_options' , [ $this , 'sfaq_add_field_in_panel'] );
        add_action( 'woocommerce_process_product_meta' , [ $this , 'sfaq_save_field_data'] );
    }

    /**
     * add new tab in product page
     * we will save data with this
     */
    public function faq_product_edit_tab( $product_data_tab ){

        $faq_tab['frequently_asked_questions'] = array(
          'label' => __('FAQ','pfaq'),
          'target'   => 'frequently_asked_questions', //This is targetted div's id
          'class'     => array( 'hide_if_downloadable','hide_if_grouped' ), //'hide_if_grouped',
          );
      
          $position = 3; // Change this for desire position 
          $tabs = array_slice( $product_data_tab, 0, $position, true ); // First part of original tabs 
          $tabs = array_merge( $tabs, $faq_tab ); // Add new 
          $tabs = array_merge( $tabs, array_slice( $product_data_tab, $position, null, true ) );
      
          return $tabs;
      
    }

    // add function for input field
    public function faq_product_tab_options(){
        ?>
            <div  id="frequently_asked_questions" class="panel woocommerce_options_panel">
                <div class="options_group">
                    <?php do_action( 'faq_woocommerce_product_options' ); ?>
                </div>
            </div>
        <?php 
    }

    // add input box for faq
    function sfaq_add_field_in_panel(){

        $args = array();
        $args[] = array(
            'id'        => 'faq_1',
            'name'      => 'faq_1',
            'label'     =>  'Question 1',
            'class'     =>  'sfaq_input',
            'type'      =>  'text',
            'desc_tip'  =>  true,
            'description'=> 'Add 1st question',
            'data_type' => 'text'
        );
    
        $args[] = array(
            'id'        => 'faq_ans_1',
            'name'      => 'faq_ans_1',
            'label'     =>  'Answer 1',
            'class'     =>  'sfaq_input',
            'type'      =>  'text',
            'desc_tip'  =>  true,
            'description'=> 'Add 1st Answer',
            'data_type' => 'text'
        );
    
        foreach($args as $arg){
        woocommerce_wp_text_input($arg);
        }
    
    }

    // save data
    function sfaq_save_field_data( $post_id ){

        $_faq_1 = isset( $_POST['faq_1'] ) ? $_POST['faq_1'] : false;
        $_faq_ans_1 = isset( $_POST['faq_ans_1'] ) ? $_POST['faq_ans_1'] : false;
    
        // Updating here 
        update_post_meta( $post_id,'faq_1', esc_attr( $_faq_1 ) ); 
        update_post_meta( $post_id,'faq_ans_1', esc_attr( $_faq_ans_1 ) ); 
    
    }

}