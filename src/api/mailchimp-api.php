<?php
/**
 * Simple MailChimp API v2
 *
 * Uses curl if available, falls back to file_get_contents and HTTP stream.
 * This probably has more comments than code.
 *
 * Contributors:
 * Michael Minor <me@pixelbacon.com>
 * Lorna Jane Mitchell, github.com/lornajane
 *
 * @author Drew McLellan <drew.mclellan@gmail.com>
 * @version 1.1.1
 *
 * @package Cherry_Mailchimp
 */

/**
 * Class MailChimp api .
 *
 * @since 1.1.2
 */
class MailChimp
{
	/**
	 * ApiKey of MailChimp account
	 *
	 * @since 1.0.0
	 * @var string
	 */
	private $api_key;

	/**
	 * EndPoint of MailChimp account
	 *
	 * @since 1.0.0
	 * @var string
	 */
	private $api_endpoint = 'https://<dc>.api.mailchimp.com/2.0';

	/**
	 * Verify ssl
	 *
	 * @since 1.0.0
	 * @var bool
	 */
	private $verify_ssl = false;

	/**
	 * Create a new instance
	 *
	 * @param type $api_key string ApiKey.
	 * @return void
	 */
	public function __construct( $api_key ) {
		$this->api_key = $api_key;
		$datacentre = explode( '-', $this->api_key );
		if ( ! empty( $datacentre[1] ) ) {
			$this->api_endpoint = str_replace( '<dc>', $datacentre[1], $this->api_endpoint );
		}
	}

	/**
	 * Validates MailChimp API Key
	 */
	public function validate_api_key() {
		$request = $this->call( 'helper/ping' );
		return ! empty( $request );
	}

	/**
	 * Call an API method. Every request needs the API key, so that is added automatically -- you don't need to pass it in.
	 *
	 * @return array          Associative array of json decoded API response.
	 */
	public function call( $method, $args = array(), $timeout = 10 ) {
		return $this->make_request( $method, $args, $timeout );
	}

	/**
	 * Performs the underlying HTTP request. Not very exciting
	 *
	 * @return array
	 */
	private function make_request( $method, $args = array(), $timeout = 10 ) {

		$args['apikey'] = $this->api_key;

		$url = $this->api_endpoint . '/' . $method . '.json';

		$json_data = json_encode( $args );

		if ( function_exists( 'curl_init' ) && function_exists( 'curl_setopt' ) ) {
			$ch = curl_init();
			curl_setopt( $ch, CURLOPT_URL, $url );
			curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json' ) );
			curl_setopt( $ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0' );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );
			curl_setopt( $ch, CURLOPT_POST, true );
			curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, $this->verify_ssl );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data );
			curl_setopt( $ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0 );
			curl_setopt( $ch, CURLOPT_ENCODING, '' );
			$result = curl_exec( $ch );
			curl_close( $ch );
		} else {
			$result = file_get_contents($url, null, stream_context_create(array(
				'http' => array(
					'protocol_version' => 1.1,
					'user_agent'       => 'PHP-MCAPI/2.0',
					'method'           => 'POST',
					'header'           => "Content-type: application/json\r\nConnection: close\r\nContent-length: " . strlen( $json_data ) . "\r\n",
					'content'          => $json_data,
				),
			)));
		}
		return $result ? json_decode( $result, true ) : false;
	}
}
