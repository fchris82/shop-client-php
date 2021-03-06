<?php

namespace Paloma\Shop\Customers;

use Paloma\Shop\BaseClient;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CustomersClient extends BaseClient implements CustomersClientInterface
{
    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * CustomersClient accepts an array of constructor parameters.
     *
     * - session: (opt) a SessionInterface implementation
     *
     * And all parameters of BaseClient.
     *
     * @param string $baseUrl
     * @param array $options
     */
    public function __construct($baseUrl, array $options)
    {
        parent::__construct($baseUrl, $options);

        $this->session = empty($options['session']) ? new Session() : $options['base_url'];
    }

    function register($customer)
    {
        return $this->post($this->channel . '/customers', null, $customer);
    }

    function getCustomer($customerId)
    {
        return $this->get($this->channel . '/customers/' . $customerId);
    }

    function updateCustomer($customerId, $customer)
    {
        return $this->put($this->channel . '/customers/' . $customerId, null, $customer);
    }

    function updateAddress($customerId, $addressType, $address)
    {
        return $this->put($this->channel . '/customers/' . $customerId . '/addresses/' . $addressType, null, $address);
    }

    function confirmEmailAddress($token)
    {
        return $this->post($this->channel . '/customers/email-address/confirm', null, ['token' => $token]);
    }

    function exists($emailAddress)
    {
        return $this->get($this->channel . '/customers/exists', ['emailAddress' => $emailAddress]);
    }

    function authenticateUser($username, $password)
    {
        return $this->post($this->channel . '/users/authenticate', null, ['username' => $username, 'password' => $password]);
    }

    function updateUserPassword($password)
    {
        return $this->put($this->channel . '/users/password', null, $password);
    }

    function startUserPasswordReset($emailAddress, $confirmationBaseUrl)
    {
        return $this->post($this->channel . '/users/password-reset', null, ['emailAddress' => $emailAddress, 'confirmationBaseUrl' => $confirmationBaseUrl]);
    }

    function getUserPasswordResetToken($token)
    {
        return $this->get($this->channel . '/users/password-reset/' . $token);
    }

    function finishUserPasswordReset($token, $password)
    {
        return $this->put($this->channel . '/users/password-reset/' . $token . '/password', null, ['password' => $password]);
    }

    function updateAdvertisingPreferences($customerId, $advertisingPrefs)
    {
        return $this->put($this->channel . '/customers/' . $customerId . '/advertising', null, $advertisingPrefs);
    }

    function createAdvertisingPrefs($advertisingPrefs)
    {
        return $this->post($this->channel . '/advertising', null, $advertisingPrefs);
    }

    function confirmAdvertisingPrefs($token)
    {
        return $this->postFormData($this->channel . '/advertising/confirm', null, ['token' => $token]);
    }


    function getLoyaltyPrograms($customerId)
    {
        return $this->get($this->channel . '/customers/' . $customerId . '/loyalty-programs');
    }

    function updateLoyaltyPrograms($customerId, $program)
    {
        return $this->post($this->channel . '/customers/' . $customerId . '/loyalty-programs', null, $program);
    }

    function getOrders($customerId, $page = null, $size = null, $order = null)
    {
        $query = [];
        if ($page !== null) {
            $query['page'] = $page;
        }
        if ($size !== null) {
            $query['size'] = $size;
        }
        if ($order !== null) {
            $query['order'] = $order;
        }

        return $this->get($this->channel . '/' . $this->locale . '/customers/' . $customerId . '/orders', $query ? $query : null);
    }

    function getOrder($customerId, $orderNr)
    {
        return $this->get($this->channel . '/' . $this->locale . '/customers/' . $customerId . '/orders/' . $orderNr);
    }

    function getOrderReceipt($customerId, $orderNr)
    {
        return $this->get($this->channel . '/' . $this->locale . '/customers/' . $customerId . '/orders/' . $orderNr . '/receipt');
    }

    function getOrderStatus($orderNr)
    {
        return $this->get($this->channel . '/' . $this->locale . '/orders/' . $orderNr . '/status');
    }

    function addressCompleteHouse($country, $zipCode, $street, $house)
    {
        return $this->get($this->channel . '/address/complete/house', [
            'country' => $country,
            'zipCode' => $zipCode,
            'street' => $street,
            'house' => $house,
        ]);
    }

    function addressCompleteStreet($country, $zipCode, $street)
    {
        return $this->get($this->channel . '/address/complete/street', [
            'country' => $country,
            'zipCode' => $zipCode,
            'street' => $street,
        ]);
    }

    function addressCompleteZip($country, $zipCity)
    {
        return $this->get($this->channel . '/address/complete/zip', [
            'country' => $country,
            'zipCity' => $zipCity,
        ]);
    }

    function addressCompleteStreetAndHouse($country, $zipCode, $streetAndHouse)
    {
        return $this->get($this->channel . '/address/complete/street-and-house', [
            'country' => $country,
            'zipCode' => $zipCode,
            'streetAndHouse' => $streetAndHouse,
        ]);
    }

    function addressValidate($address)
    {
        return $this->post($this->channel . '/address/validate', null, $address);
    }
}
