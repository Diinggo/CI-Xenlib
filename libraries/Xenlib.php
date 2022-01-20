<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @package     Xenlib | Xendit Library Codeigniter
 * @author      Diinggo Sirojudin
 * @website     https://diinggo.id
 * @copyright   Copyright (c) 2020.
 * @since       Version 1.0.0
 * @filesource
 */

use Xendit\Xendit;
use GuzzleHttp\Client;

class Xenlib
{
    /**
     * summary
     */
    public function __construct()
    {
        Xendit::setApiKey(env('PAYMENT_SECRET'));
        // header('for-user-id: '.env('PAYMENT_USERID').'');
    }

    /* ======================================= BASIC AKUN ======================================= */
    /**
     * CEK SALDO
     *
     * @return     <type>  The saldo.
     */
    public function get_saldo($saldo = 'CASH')
    {
        // CASH | TAX | HOLDING
		$getBalance = \Xendit\Balance::getBalance($saldo);
        $ret = $getBalance;
		return $ret;
        // balance
    }

    /**
     * CHANNEL PEMBAYARAN TERSEDIA
     *
     * @return     <type>  The saldo.
     */
    public function get_channel()
    {
		$client = new GuzzleHttp\Client();
		$res = $client->request('GET', 'https://api.xendit.co/payment_channels', [
		    'auth' => [
		    	env('PAYMENT_SECRET'),
		    	''
		    ]
		]);
		$ret = json_decode($res->getBody()->getContents(), true);
		return $ret;
    }

    /* ======================================= VIRTUAL AKUN ======================================= */
    /**
     * CEK KETERSEDIAAN VIRTUAL AKUN
     */
    public function get_va_banks()
    {
    	$getVABanks = \Xendit\VirtualAccounts::getVABanks();
		return $getVABanks;
    }
    
    /**
     * BUAT VIRTUAL AKUN
     *
     * @param      <type>  $data   The data
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function createVA($data)
    {
        // // Template
        // $params = [
        //     'external_id'       => '',
        //     'bank_code'         => '',
        //     'name'              => '',
        //     'virtual_account_number' => '',
        //     'suggested_amount'  => '',
        //     'is_closed'         => false,
        //     'expected_amount'   => '',
        //     // 'expiration_date'   => '',
        //     'is_single_use'     => false,
        //     // 'description'       => '',
        //     // 'for-user-id'       => ''
        // ];
        
		$createVA = \Xendit\VirtualAccounts::create($data);
		return $createVA;
    }

    /**
     * UPDATE VIRTUAL AKUN
     *
     * @param      <type>  $id     The identifier
     * @param      <type>  $data   The data
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function updateVA($id, $data)
    {
        // // Template
        // $params = [
        //     'external_id'       => '',
        //     'bank_code'         => '',
        //     'name'              => '',
        //     'virtual_account_number' => '',
        //     'suggested_amount'  => '',
        //     'is_closed'         => false,
        //     'expected_amount'   => '',
        //     'expiration_date'   => '',
        //     'is_single_use'     => false,
        //     // 'description'       => '',
        //     // 'for-user-id'       => ''
        // ];
        
    	$updateVA = \Xendit\VirtualAccounts::update($id, $data);
		return $updateVA;
    }
    
    /**
     * DATA VIRTUAL AKUN
     *
     * @param      <type>  $id     The identifier
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function dataVA($id)
    {
    	$getVA = \Xendit\VirtualAccounts::retrieve($id);
		return $getVA;
    }
    
    /**
     * DATA FIXED VIRTUAL AKUN / SUDAH DIBAYAR
     *
     * @param      <type>  $id     The identifier
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function dataFixedVA($id)
    {
    	$paymentID = $id;
		$getFVAPayment = \Xendit\VirtualAccounts::getFVAPayment($paymentID);
		return $getFVAPayment;
    }

    /* ======================================= E-WALLET ======================================= */
    /* TERSEDIA OVO | DANA | LINKAJA */
    /**
     * CREATE OVO
     *
     * @param      <type>  $params  The parameters
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function createOVO($params)
    {
        // // Template OVO
        // $params = [
        //     'external_id'   => '',
        //     'amount'        => '',
        //     'phone'         => ''
        // ];

        $params['ewallet_type'] = 'OVO';
        $createOvo = \Xendit\EWallets::create($params);
        return $createOvo;
    }


    /**
     * CREATE DANA
     *
     * @param      <type>  $params  The parameters
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function createDANA($params)
    {
        // // Template DANA
        // $params = [
        //     'external_id'   => '',
        //     'amount'        => '',
        //     'phone'         => '',
        //     // 'expiration_date' => '', // DEFAULT 24 JAM
        // ];

        // $params['callback_url']  = 'https://my-shop.com/callbacks';
        // $params['redirect_url']     = 'https://my-shop.com/home';
        $params['ewallet_type']     = 'DANA';
        $createDana = \Xendit\EWallets::create($params);
        return $createDana;
    }

    /**
     * CREATE LINKAJA
     *
     * @param      <type>  $params  The parameters
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function createLINKAJA($params)
    {
        // // Template LINKAJA
        // $params = [
        //     'external_id'   => '', // String
        //     'amount'        => 32000, // Integer
        //     'phone'         => '', // String
        //     'items' => [
        //       [
        //         'id'        => '', // String
        //         'name'      => '', // String
        //         'price'     => 100000, // Integer
        //         'quantity'  => 1 // Integer
        //       ]
        //     ],
        // ];
        
        $params['callback_url'] = 'https =>//yourwebsite.com/callback';
        $params['redirect_url'] = 'https =>//yourwebsite.com/order/123';
        $params['ewallet_type'] = 'LINKAJA';
        $createLinkaja = \Xendit\EWallets::create($params);
        return $createLinkaja;
    }

    /**
     * DATA OVO
     *
     * @param      <type>  $external_id  The external identifier
     */
    public function getOVO($external_id)
    {
        $getOvo = \Xendit\EWallets::getPaymentStatus($external_id,
            'OVO');
        return $getOvo;
    }

    /**
     * DATA DANA
     *
     * @param      <type>  $external_id  The external identifier
     */
    public function getDANA($external_id)
    {
        $getDana = \Xendit\EWallets::getPaymentStatus($external_id,
            'DANA');
        return $getDana;
    }

    /**
     * DATA LINKAJA
     *
     * @param      <type>  $external_id  The external identifier
     */
    public function getLINKAJA($external_id)
    {
        $getLinkaja = \Xendit\EWallets::getPaymentStatus($external_id,
            'LINKAJA');
        return $getLinkaja;
    }

    /* ======================================= RETAIL OUTLET ======================================= */
    /* TERSEDIA INDOMARET | ALFAMART */
    /**
     * CREATE RETAIL
     *
     * @param      <type>  $params  The parameters
     * @param      string  $retail  The retail
     */
    public function createRetail($params, $retail)
    {
        $createFPC = \Xendit\Retail::create($params);
        var_dump($createFPC);
    }
    
    /**
     * UPDATE RETAIL
     *
     * @param      <type>  $params  The parameters
     * @param      string  $retail  The retail
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function updateRetail($params, $retail = 'INDOMARET')
    {
        $updateFPC = \Xendit\Retail::update($id, $updateParams);
        return $updateFPC;
    }
    
    /**
     * DATA RETAIL
     *
     * @param      <type>  $id     The identifier
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function dataRetail($id)
    {
        $getFPC = \Xendit\Retail::retrieve($id);
        return $getFPC;
    }
}
