<?php

namespace Woo\Faq\Admin;

defined('ABSPATH') or die('Nice Try!');

class AiEngine
{
    public function __construct()
    {
        add_action('wp_ajax_woo_faq_test_ai_connection', [$this, 'testAiConnection']);
        add_action('wp_ajax_woo_faq_generate_ai_faqs', [$this, 'generateAiFaqs']);
    }

    /**
     * Test connection to the selected AI provider
     */
    public function testAiConnection()
    {
        check_ajax_referer('faq_nonce', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error(['message' => __('Permission denied.', 'product-faq-for-woocommerce')]);
        }

        $provider = sanitize_text_field($_POST['provider'] ?? 'gemini');
        $api_key = sanitize_text_field($_POST['api_key'] ?? '');

        if (empty($api_key)) {
            $api_key = get_option('woo_faq_ai_api_key', '');
        }

        if (empty($api_key)) {
            wp_send_json_error(['message' => __('Please enter an API key first.', 'product-faq-for-woocommerce')]);
        }

        if ($provider === 'openai') {
            $response = wp_remote_get('https://api.openai.com/v1/models', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $api_key
                ],
                'timeout' => 15
            ]);

            if (is_wp_error($response)) {
                wp_send_json_error(['message' => $response->get_error_message()]);
            }

            $code = wp_remote_retrieve_response_code($response);
            if ($code !== 200) {
                $body = json_decode(wp_remote_retrieve_body($response), true);
                $err = $body['error']['message'] ?? __('Invalid OpenAI API Key or unauthorized request.', 'product-faq-for-woocommerce');
                wp_send_json_error(['message' => $err]);
            }
        } else {
            $url = 'https://generativelanguage.googleapis.com/v1beta/models?key=' . urlencode($api_key);
            $response = wp_remote_get($url, [
                'timeout' => 15
            ]);

            if (is_wp_error($response)) {
                wp_send_json_error(['message' => $response->get_error_message()]);
            }

            $code = wp_remote_retrieve_response_code($response);
            if ($code !== 200) {
                $body = json_decode(wp_remote_retrieve_body($response), true);
                $err = $body['error']['message'] ?? __('Invalid Google Gemini API Key or unauthorized request.', 'product-faq-for-woocommerce');
                wp_send_json_error(['message' => $err]);
            }
        }

        wp_send_json_success(['message' => sprintf(__('Connection to %s verified successfully! AI engine is ready.', 'product-faq-for-woocommerce'), $provider === 'openai' ? 'OpenAI' : 'Google Gemini')]);
    }

    /**
     * Generate FAQs using AI based on product context
     */
    public function generateAiFaqs()
    {
        check_ajax_referer('faq_nonce', 'nonce');

        if (!current_user_can('edit_posts')) {
            wp_send_json_error(['message' => __('Permission denied.', 'product-faq-for-woocommerce')]);
        }

        $product_title = sanitize_text_field($_POST['product_title'] ?? '');
        $product_desc = sanitize_textarea_field($_POST['product_desc'] ?? '');
        $count = intval($_POST['count'] ?? 3);
        $count = max(1, min($count, 3)); // Free version capped at 3
        $tone = sanitize_text_field($_POST['tone'] ?? 'sales');

        $provider = get_option('woo_faq_ai_provider', 'gemini');
        $api_key = get_option('woo_faq_ai_api_key', '');

        // If no API key configured, provide contextual smart templates as demo
        if (empty($api_key)) {
            $demo_faqs = $this->generateFallbackFaqs($product_title, $product_desc, $count);
            wp_send_json_success([
                'faqs' => $demo_faqs,
                'is_demo' => true,
                'message' => __('Generated using built-in Smart Assistant. Connect your Gemini or OpenAI API key in Settings -> AI Assistant for live AI.', 'product-faq-for-woocommerce')
            ]);
        }

        $system_instructions = "You are an expert WooCommerce eCommerce conversion copywriter. Create high-converting, realistic customer Frequently Asked Questions (FAQs) and answers for the following product.\n";
        $system_instructions .= "Tone: " . esc_html($tone) . " (address shopper objections such as delivery, returns, sizing/compatibility, quality, usage).\n";
        $system_instructions .= "Return ONLY valid JSON matching this exact structure: {\"faqs\": [{\"question\": \"...\", \"answer\": \"...\"}]}.\n";
        $system_instructions .= "Number of FAQs to generate: " . $count . ".\n\n";

        $product_context = "Product Name: " . $product_title . "\n";
        if (!empty($product_desc)) {
            $product_context .= "Product Description: " . wp_strip_all_tags($product_desc) . "\n";
        }

        $full_prompt = $system_instructions . $product_context;

        if ($provider === 'openai') {
            $response = $this->callOpenAi($api_key, $full_prompt, $count);
        } else {
            $response = $this->callGemini($api_key, $full_prompt, $count);
        }

        if (is_wp_error($response)) {
            wp_send_json_error(['message' => $response->get_error_message()]);
        }

        wp_send_json_success([
            'faqs' => $response,
            'is_demo' => false
        ]);
    }

    /**
     * Call Google Gemini API
     */
    private function callGemini($api_key, $prompt, $count)
    {
        $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=' . urlencode($api_key);

        $body = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ],
            'generationConfig' => [
                'responseMimeType' => 'application/json',
                'temperature' => 0.7
            ]
        ];

        $response = wp_remote_post($url, [
            'headers' => ['Content-Type' => 'application/json'],
            'body'    => wp_json_encode($body),
            'timeout' => 30
        ]);

        if (is_wp_error($response)) {
            return $response;
        }

        $status = wp_remote_retrieve_response_code($response);
        $raw_body = wp_remote_retrieve_body($response);
        $data = json_decode($raw_body, true);

        if ($status !== 200 || !empty($data['error'])) {
            $err = $data['error']['message'] ?? __('Gemini API request failed.', 'product-faq-for-woocommerce');
            return new \WP_Error('gemini_error', $err);
        }

        $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
        $parsed = json_decode($text, true);

        if (isset($parsed['faqs']) && is_array($parsed['faqs'])) {
            return $parsed['faqs'];
        }

        return $this->extractFaqsFromRawText($text, $count);
    }

    /**
     * Call OpenAI API
     */
    private function callOpenAi($api_key, $prompt, $count)
    {
        $url = 'https://api.openai.com/v1/chat/completions';

        $body = [
            'model' => 'gpt-4o-mini',
            'messages' => [
                ['role' => 'system', 'content' => 'You are a professional WooCommerce FAQ copywriter. Return ONLY valid JSON: {"faqs": [{"question": "...", "answer": "..."}]}'],
                ['role' => 'user', 'content' => $prompt]
            ],
            'response_format' => ['type' => 'json_object'],
            'temperature' => 0.7
        ];

        $response = wp_remote_post($url, [
            'headers' => [
                'Content-Type'  => 'application/json',
                'Authorization' => 'Bearer ' . $api_key
            ],
            'body'    => wp_json_encode($body),
            'timeout' => 30
        ]);

        if (is_wp_error($response)) {
            return $response;
        }

        $status = wp_remote_retrieve_response_code($response);
        $raw_body = wp_remote_retrieve_body($response);
        $data = json_decode($raw_body, true);

        if ($status !== 200 || !empty($data['error'])) {
            $err = $data['error']['message'] ?? __('OpenAI API request failed.', 'product-faq-for-woocommerce');
            return new \WP_Error('openai_error', $err);
        }

        $text = $data['choices'][0]['message']['content'] ?? '';
        $parsed = json_decode($text, true);

        if (isset($parsed['faqs']) && is_array($parsed['faqs'])) {
            return $parsed['faqs'];
        }

        return $this->extractFaqsFromRawText($text, $count);
    }

    /**
     * Fallback parser if JSON structure is slightly off
     */
    private function extractFaqsFromRawText($text, $count)
    {
        $clean = preg_replace('/```json|```/', '', $text);
        $decoded = json_decode(trim($clean), true);
        if (is_array($decoded)) {
            if (isset($decoded['faqs'])) {
                return $decoded['faqs'];
            }
            // Check if it's a direct array of Q&As
            if (isset($decoded[0]['question'])) {
                return $decoded;
            }
        }
        return $this->generateFallbackFaqs('Product', '', $count);
    }

    /**
     * Smart fallback generator when no API key is provided
     */
    private function generateFallbackFaqs($title, $desc, $count)
    {
        $pname = !empty($title) ? $title : __('this product', 'product-faq-for-woocommerce');
        
        $presets = [
            [
                'question' => sprintf(__('What is the delivery and shipping timeframe for %s?', 'product-faq-for-woocommerce'), $pname),
                'answer'   => __('Orders are processed within 1-2 business days. Standard delivery typically takes 3-5 business days with full online tracking.', 'product-faq-for-woocommerce')
            ],
            [
                'question' => sprintf(__('What is the return and refund policy for %s?', 'product-faq-for-woocommerce'), $pname),
                'answer'   => __('We offer a 30-day hassle-free return guarantee. If you are not completely satisfied, contact our support team for an exchange or full refund.', 'product-faq-for-woocommerce')
            ],
            [
                'question' => sprintf(__('Is %s covered under warranty?', 'product-faq-for-woocommerce'), $pname),
                'answer'   => __('Yes! All our products come with a 1-year manufacturer warranty covering any defects in materials or craftsmanship.', 'product-faq-for-woocommerce')
            ]
        ];

        return array_slice($presets, 0, $count);
    }
}
