<?php

/**
 * Class FMControllerCheckpaypal
 */
class FMControllerCheckpaypal {
  /**
   * @var $model
   */
  private $model;
  /**
   * @var $view
   */
  private $view;

  /**
   * FMControllerCheckpaypal constructor.
   */
  public function __construct() {
    // Load FMModelCheckpaypal class.
    require_once WDCFM()->plugin_dir . "/admin/models/Checkpaypal.php";
    $this->model = new FMModelCheckpaypal();
    // Load FMViewCheckpaypal class.
    require_once WDCFM()->plugin_dir . "/admin/views/Checkpaypal.php";
    $this->view = new FMViewCheckpaypal();
  }

  /**
   * Execute.
   */
  public function execute() {
    $this->display();
  }

  /**
   * Display.
   */
  public function display() {
    // Get form by id.
    $form_id = WDW_FMC_Library::get('form_id', 0);
    $form = $this->model->get_form_by_id($form_id);
    // Get form session by group id.
    $group_id = WDW_FMC_Library::get('group_id', 0);
    $form_session = $this->model->get_form_session_by_group_id($group_id);
    // Connect to paypal.
    $post_fields = '';
    if ( isset($_POST) && !empty($_POST) ) {
      foreach ( $_POST as $key => $value ) {
        $post_fields .= $key . '=' . urlencode($value) . '&';
      }
    }
    $post_fields .= 'cmd=_notify-validate';
    $paypal_params = array( 'checkout_mode' => $form->checkout_mode, 'post_fields' => $post_fields );
    $response = $this->model->connect_to_paypal($paypal_params);
    $tax = WDW_FMC_Library::get('tax', 0);
    $total = WDW_FMC_Library::get('mc_gross', 0);
    $shipping = WDW_FMC_Library::get('mc_shipping', 0);
    $payment_status = WDW_FMC_Library::get('payment_status', 0);
    // Update payment status for formmaker_submits table.
    $this->model->update_submission_status($payment_status, $group_id);
    $form_currency = '$';
    $currency_code = array(
      'USD',
      'EUR',
      'GBP',
      'JPY',
      'CAD',
      'MXN',
      'HKD',
      'HUF',
      'NOK',
      'NZD',
      'SGD',
      'SEK',
      'PLN',
      'AUD',
      'DKK',
      'CHF',
      'CZK',
      'ILS',
      'BRL',
      'TWD',
      'MYR',
      'PHP',
      'THB',
    );
    $currency_sign = array(
      '$',
      '&#8364;',
      '&#163;',
      '&#165;',
      'C$',
      'Mex$',
      'HK$',
      'Ft',
      'kr',
      'NZ$',
      'S$',
      'kr',
      'zl',
      'A$',
      'kr',
      'CHF',
      'Kc',
      '&#8362;',
      'R$',
      'NT$',
      'RM',
      '&#8369;',
      '&#xe3f;',
    );
    // Checking payment currency and set new value fo currency.
    $payment_currency = !empty($form->payment_currency) ? $form->payment_currency : $form_currency;
    if ( !empty($payment_currency) ) {
      $form_currency = $currency_sign[array_search($payment_currency, $currency_code)];
    }
    $currency = $payment_currency . $form_currency;
    $email = WDW_FMC_Library::get('payer_email', '');
    $first_name = WDW_FMC_Library::get('first_name', '');
    $last_name = WDW_FMC_Library::get('last_name', '');
    $full_name = (($first_name != '') ? $first_name : '') . (($last_name != '') ? ' ' . $last_name : '');
    $phone_a = WDW_FMC_Library::get('night_phone_a', '');
    $phone_b = WDW_FMC_Library::get('night_phone_b', '');
    $phone_c = WDW_FMC_Library::get('night_phone_c', '');
    $phone = (($phone_a != '') ? $phone_a : '') . (($phone_b != '') ? ' - ' . $phone_b : '') . (($phone_c != '') ? ' - ' . $phone_c : '');
    $address = '';
    $address .= (WDW_FMC_Library::get('address_country', '') != '') ? "Country: " . WDW_FMC_Library::get('address_country', '') : '';
    $address .= (WDW_FMC_Library::get('address_state', '') != '') ? "<br>State: " . WDW_FMC_Library::get('address_state', '') : '';
    $address .= (WDW_FMC_Library::get('address_city', '') != '') ? "<br>City: " . WDW_FMC_Library::get('address_city', '') : '';
    $address .= (WDW_FMC_Library::get('address_street', '') != '') ? "<br>Street: " . WDW_FMC_Library::get('address_street', '') : '';
    $address .= (WDW_FMC_Library::get('address_zip', '') != '') ? "<br>Zip Code: " . WDW_FMC_Library::get('address_zip', '') : '';
    $address .= (WDW_FMC_Library::get('address_status', '') != '') ? "<br>Address Status: " . WDW_FMC_Library::get('address_status', '') : '';
    $address .= (WDW_FMC_Library::get('address_name', '') != '') ? "<br>Name: " . WDW_FMC_Library::get('address_name', '') : '';
    $paypal_info = "";
    $paypal_info .= (WDW_FMC_Library::get('payer_status', '') != '') ? "<br>Payer Status - " . WDW_FMC_Library::get('payer_status', '') : '';
    $paypal_info .= (WDW_FMC_Library::get('payer_email', '') != '') ? "<br>Payer Email - " . WDW_FMC_Library::get('payer_email', '') : '';
    $paypal_info .= (WDW_FMC_Library::get('txn_id', '') != '') ? "<br>Transaction - " . WDW_FMC_Library::get('txn_id', '') : '';
    $paypal_info .= (WDW_FMC_Library::get('payment_type', '') != '') ? "<br>Payment Type - " . WDW_FMC_Library::get('payment_type', '') : '';
    $paypal_info .= (WDW_FMC_Library::get('residence_country', '') != '') ? "<br>Residence Country - " . WDW_FMC_Library::get('residence_country', '') : '';
    $post = array(
      'form_id' => $form_id,
      'group_id' => $group_id,
      'full_name' => $full_name,
      'email' => $email,
      'phone' => $phone,
      'address' => $address,
      'status' => $payment_status,
      'ipn' => $response,
      'currency' => $currency,
      'paypal_info' => $paypal_info,
      'tax' => $tax,
      'total' => $total,
      'shipping' => $shipping,
      'ord_last_modified' => date('Y-m-d H:i:s'),
    );
    if ( !$form_session ) {
      $this->model->add_formmaker_sessions($post);
    }
    else {
      $this->model->update_formmaker_sessions_by_group_id($group_id, $post);
    }
    // Get form session by group id.
    $form_session = $this->model->get_form_session_by_group_id($group_id);
    // Send mail to payer.
    if ( !empty($form_session) ) {
      $recipient = $form->mail ? $form->mail : '';
      if ( $recipient ) {
        $subject = __("Payment information", WDCFM()->prefix);
        // Get template for payment information.
        $template_params = array( 'form_session' => $form_session, 'data' => $post );
        $message = $this->view->payment_information_template($template_params);
        $header_arr = array();
        $header_arr['content_type'] = "text/html";
        $header_arr['charset'] = 'UTF-8';
        WDW_FMC_Library::mail($recipient, $subject, $message, $header_arr);
      }
    }

    return 0;
  }
}
