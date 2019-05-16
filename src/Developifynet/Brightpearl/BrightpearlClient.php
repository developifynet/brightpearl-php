<?php

namespace Developifynet\Brightpearl;

use Illuminate\Support\Traits\Macroable;
use GuzzleHttp\Client;

class BrightpearlClient
{
    use Macroable;

    /**
     * Brightpearl App Reference
     *
     * @var string
     */
    private $_app_reference = null;


    /**
     * Brightpearl App Token
     *
     * @var string
     */
    private $_account_token = null;

    /**
     * Brightpearl Account Name
     *
     * @var string
     */
    private $_account_code = null;

    /**
     *  Brightpearl Endpoint where request will be sent
     *
     * @var string
     */
    private $_brightpearl_url = 'https://ws-eu1.brightpearl.com';

    /**
     * Brightpearl constructor.
     */
    public function __construct(array $settings = [])
    {
        if(isset($settings['app_reference']) && $settings['app_reference']) {
            $this->_app_reference = $settings['app_reference'];
        }

        if(isset($settings['account_token']) && $settings['account_token']) {
            $this->_account_token = $settings['account_token'];
        }

        if(isset($settings['account_code']) && $settings['account_code']) {
            $this->_account_code = $settings['account_code'];
        }

        if(isset($settings['api_domain']) && $settings['api_domain']) {
            $this->_brightpearl_url = $settings['api_domain'];
        }
    }

    /**
     * Get App Reference
     *
     * @return string
     */
    public function getAppReference() {

        if(!$this->_app_reference) {
            throw new BrightpearlException('App Reference is not set');
        }

        return $this->_app_reference;
    }

    /**
     * Get Account Code
     *
     * @return string
     */
    public function getAccountCode() {

        if(!$this->_account_code) {
            throw new BrightpearlException('App Reference is not set');
        }

        return $this->_account_code;
    }

    /**
     * Get Account Token
     *
     * @return string | BrightpearlException $e
     */
    public function getAccountToken() {

        if(!$this->_account_token) {
            throw new BrightpearlException('App Reference is not set');
        }

        return $this->_account_token;
    }

    /**
     * Get Brightpearl URL
     *
     * @return string | BrightpearlException $e
     */
    public function getURL() {

        if(!$this->_brightpearl_url) {
            throw new BrightpearlException('Brightpearl Endpoint URL is not set');
        }

        return $this->_brightpearl_url;
    }


    /*
     * Get Order Types
     *
     * @param: void
     * @return: array|mixed
     */
    public function getOrderType() {
        return $this->sendRequest('GET', '/order-service/order-type/');
    }


    /*
     * Get Contacts
     *
     * @param: void
     * @return: array|mixed
     */
    public function getContact($ids = '') {
        return $this->sendRequest('GET', '/contact-service/contact/' . $ids);
    }


    /*
     * Get Product Price
     *
     * @param: void
     * @return: array|mixed
     */
    public function getProductPrice($ids = '') {
        return $this->sendRequest('GET', '/product-service/product-price/' . $ids);
    }


    /*
     * Get Order
     *
     * @param: void
     * @return: array|mixed
     */
    public function getOrder($ids = '') {
        return $this->sendRequest('GET', '/order-service/order/' . $ids);
    }


    /*
     * Get Price Lists
     *
     * @param: void
     * @return: array|mixed
     */
    public function getPriceList() {
        return $this->sendRequest('GET', '/product-service/price-list/');
    }


    /*
     * Option Product Prices for bulk data
     *
     * @param: string $ids
     * @return: array|mixed
     */
    public function optionsProductPrice($ids = '') {
        return $this->sendRequest('OPTIONS', '/product-service/product-price/' . $ids);
    }


    /*
     * Option Contacts for bulk data
     *
     * @param: string $ids
     * @return: array|mixed
     */
    public function optionsContact($ids = '') {
        return $this->sendRequest('OPTIONS', '/contact-service/contact/' . $ids);
    }


    /*
     * Option Order for bulk data
     *
     * @param: string $ids
     * @return: array|mixed
     */
    public function optionsOrder($ids = '') {
        return $this->sendRequest('OPTIONS', '/order-service/order/' . $ids);
    }


    /*
     * Get Order Status
     *
     * @param: void
     * @return: array|mixed
     */
    public function getOrderStatus() {
        return $this->sendRequest('GET', '/order-service/order-status/');
    }


    /*
     * Get Warehouses
     *
     * @param: void
     * @return: array|mixed
     */
    public function getWarehouse() {
        return $this->sendRequest('GET', '/warehouse-service/warehouse/');
    }


    /*
     * Get Channel
     *
     * @param: void
     * @return: array|mixed
     */
    public function getChannel() {
        return $this->sendRequest('GET', '/product-service/channel/');
    }

    /*
     * Get Order Stock Status
     *
     * @param: void
     * @return: array|mixed
     */
    public function getOrderStockStatus() {
        return $this->sendRequest('GET', '/order-service/order-stock-status/');
    }

    /*
     * Get Order Shipping Status
     *
     * @param: void
     * @return: array|mixed
     */
    public function getOrderShippingStatus() {
        return $this->sendRequest('GET', '/order-service/order-shipping-status/');
    }

    /**
     * Process incoming request parameters and get response
     *
     * @param $request_type
     * @param $resource
     * @param $form_params
     * @return mixed
     */
    private function sendRequest($request_type = 'GET', $resource, array $form_params = []) {
        try {

            $client = new Client();
            $response = $client->request($request_type, $this->getURL(). '/public-api/' . $this->getAccountCode() . $resource, [
                'headers' => [
                    'brightpearl-app-ref'       => $this->getAppReference(),
                    'brightpearl-account-token' => $this->getAccountToken()
                ],
                'form_params' => $form_params
            ]);

            if($response->getStatusCode() == '200') {
                return array(
                    'status' => true,
                    'data' => json_decode($response->getBody(), true),
                    'error' => '',
                );
            } else {
                return array(
                    'status' => true,
                    'data' => [],
                    'error' => '',
                );
            }
        } catch (BrightpearlException $exception) {
            return array(
                'status' => false,
                'data' => [],
                'error' => $exception->getMessage(),
            );
        }
    }

    /*
     * Lead Brightpearl Credentials
     *
     * @param: array|mixed
     * @return: array|mixed
     */
    public function settings($settings) {

        if(!isset($settings['app_reference']) || !$settings['app_reference']) {
            throw new BrightpearlException('App Reference is required');
        } else {
            $this->_app_reference = $settings['app_reference'];
        }

        if(!isset($settings['account_token']) || !$settings['account_token']) {
            throw new BrightpearlException('Account Token is required');
        } else {
            $this->_account_token = $settings['account_token'];
        }

        if(!isset($settings['account_code']) || !$settings['account_code']) {
            throw new BrightpearlException('Account Code is required');
        } else {
            $this->_account_code = $settings['account_code'];
        }

        if(isset($settings['api_domain']) && $settings['api_domain']) {
            $this->_brightpearl_url = $settings['api_domain'];
        }

        return $this;
    }
}

