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
        global $post;
        $value = get_post_meta($post->ID,'fazle',true);
        // var_dump($value);
        $value = is_array( $value ) ? $value : [
            'question' => [
                '',
            ],
            
            'answer' => [
                '',
            ]

        ];

        $args = array();

        foreach( $value['question'] as $key => $val ){
            $args[] = array(
                'id'        => 'faq_'. $key,
                'name'      => 'fazle[question][' . $key . ']',
                'label'     =>  'Question ' . $key,
                'class'     =>  'sfaq_input',
                'type'      =>  'text',
                'desc_tip'  =>  true,
                // 'description'=> 'Add 1st question',
                'data_type' => 'text',
                'value'     => $value['question'][$key] ?? '',
            );
            $args[] = array(
                'id'        => 'faq_ans_'. $key,
                'name'      => 'fazle[answer][' . $key . ']',
                'label'     =>  'Answer ' . $key,
                'class'     =>  'sfaq_input',
                'type'      =>  'text',
                'desc_tip'  =>  true,
                'description'=> 'Add 1st Answer',
                'data_type' => 'text',
                'value'     => $value['answer'][$key] ?? '',
            );
        }

        // $args[] = array(
        //     'id'        => 'faq_1',
        //     'name'      => 'fazle[question][1]',
        //     'label'     =>  'Question 1',
        //     'class'     =>  'sfaq_input',
        //     'type'      =>  'text',
        //     'desc_tip'  =>  true,
        //     'description'=> 'Add 1st question',
        //     'data_type' => 'text',
        //     'value'     => $value['question'][1] ?? '',
        // );
    
        // $args[] = array(
        //     'id'        => 'faq_ans_1',
        //     'name'      => 'fazle[answer][1]',
        //     'label'     =>  'Answer 1',
        //     'class'     =>  'sfaq_input',
        //     'type'      =>  'text',
        //     'desc_tip'  =>  true,
        //     'description'=> 'Add 1st Answer',
        //     'data_type' => 'text',
        //     'value'     => $value['answer'][1] ?? '',
        // );
        // $args[] = array(
        //     'id'        => 'faq_2',
        //     'name'      => 'faq_2',
        //     'label'     =>  'Question 2',
        //     'class'     =>  'sfaq_input',
        //     'type'      =>  'text',
        //     'desc_tip'  =>  true,
        //     'description'=> 'Add 2nd question',
        //     'data_type' => 'text'
        // );
    
        // $args[] = array(
        //     'id'        => 'faq_ans_2',
        //     'name'      => 'faq_ans_2',
        //     'label'     =>  'Answer 2',
        //     'class'     =>  'sfaq_input',
        //     'type'      =>  'text',
        //     'desc_tip'  =>  true,
        //     'description'=> 'Add 2nd Answer',
        //     'data_type' => 'text'
        // );

        // $args[] = array(
        //     'id'        => 'faq_3',
        //     'name'      => 'faq_3',
        //     'label'     =>  'Question 3',
        //     'class'     =>  'sfaq_input',
        //     'type'      =>  'text',
        //     'desc_tip'  =>  true,
        //     'description'=> 'Add 3rd question',
        //     'data_type' => 'text'
        // );
    
        // $args[] = array(
        //     'id'        => 'faq_ans_3',
        //     'name'      => 'faq_ans_3',
        //     'label'     =>  'Answer 3',
        //     'class'     =>  'sfaq_input',
        //     'type'      =>  'text',
        //     'desc_tip'  =>  true,
        //     'description'=> 'Add 3rd Answer',
        //     'data_type' => 'text'
        // );

        $args = apply_filters('sfaq_field_args' , $args);

        foreach($args as $arg){
        woocommerce_wp_text_input($arg);
        }
    
    }

    // save data
    function sfaq_save_field_data( $post_id ){

        $_data = $_POST['fazle'] ?? [];
        var_dump($_POST['fazle']);
        update_post_meta( $post_id,'fazle', $_data); 
        // die();

        // $_faq_1 = isset( $_POST['faq_1'] ) ? $_POST['faq_1'] : false;
        // $_faq_ans_1 = isset( $_POST['faq_ans_1'] ) ? $_POST['faq_ans_1'] : false;

        // $_faq_2 = isset( $_POST['faq_2'] ) ? $_POST['faq_2'] : false;
        // $_faq_ans_2 = isset( $_POST['faq_ans_2'] ) ? $_POST['faq_ans_2'] : false;

        // $_faq_3 = isset( $_POST['faq_3'] ) ? $_POST['faq_3'] : false;
        // $_faq_ans_3 = isset( $_POST['faq_ans_3'] ) ? $_POST['faq_ans_3'] : false;
    
        // // Updating here 
        // update_post_meta( $post_id,'faq_1', esc_attr( $_faq_1 ) ); 
        // update_post_meta( $post_id,'faq_ans_1', esc_attr( $_faq_ans_1 ) );

        // update_post_meta( $post_id,'faq_2', esc_attr( $_faq_2 ) ); 
        // update_post_meta( $post_id,'faq_ans_2', esc_attr( $_faq_ans_2 ) ); 

        // update_post_meta( $post_id,'faq_3', esc_attr( $_faq_3 ) ); 
        // update_post_meta( $post_id,'faq_ans_3', esc_attr( $_faq_ans_3 ) ); 
    
    }

}