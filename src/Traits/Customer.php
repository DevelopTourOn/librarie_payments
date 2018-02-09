<?php namespace TourChannel\Payments\Traits;
use Carbon\Carbon;
use Exception;

/**
 * Trait Customer
 * @package TourChannel\Payments\Traits
 */
trait Customer
{
    /**
     * Genero aceitos
     * @var array
     */
    protected $genre = ['M' => 'male', 'F' => 'female'];

    /**
     * Nome do cliente
     * @param string $name
     * @return $this
     */
    public function setCustomerName(string $name)
    {
        $this->payload['customer']['name'] = $name;

        return $this;
    }

    /**
     * Email do cliente
     * @param string $email
     * @return $this
     */
    public function setCustomerEmail(string $email)
    {
        $this->payload['customer']['email'] = $email;

        return $this;
    }

    /**
     * Documento do cliente
     * @param $document
     * @return $this
     */
    public function setCustomerDocument($document)
    {
        $this->payload['customer']['document'] = preg_replace("/[^0-9]/", "", $document);
        $this->payload['customer']['type_document'] = "CPF";

        return $this;
    }

    /**
     * Genero do cliente somente M ou F
     * @param string $gender
     * @return $this
     * @throws Exception
     */
    public function setCustomerGender(string $gender)
    {
        $gender = strtoupper($gender);

        if(isset($this->genre[$gender])) {

            $this->payload['customer']['gender'] = $this->genre[$gender];

            return $this;
        }

        throw new Exception('Genero não especificado, somente '. implode(" ou ", array_keys($this->genre)));
    }

    /**
     * Data de nascimento cliente
     * @param string $birthdate
     * @param string $format
     * @return $this
     */
    public function setCustomerBirthDate(string $birthdate, $format = 'd/m/Y')
    {
        $birthdate = Carbon::createFromFormat($format, $birthdate);

        $this->payload['customer']['birthdate'] = $birthdate->format('Y-m-d');

        return $this;
    }

    /**
     * Configura os telefones do cliente devem conter DDD
     * @param array $phones
     * @return $this
     */
    public function setCustomerPhones(array $phones)
    {
        $mobile_phone = preg_replace("/[^0-9]/", "", $phones[0]);
        $home_phone = (! isset($phones[1]) || $phones[1] == "") ? $mobile_phone : preg_replace("/[^0-9]/", "", $phones[1]);

        $this->payload['customer']['phones'] = [
            'mobile_phone' => [
                'country_code' => '55',
                'number' => substr($mobile_phone, 2),
                'area_code' => $mobile_phone[0] . $mobile_phone[1]
            ],
            'home_phone' => [
                'country_code' => '55',
                'number' => substr($home_phone, 2),
                'area_code' => $home_phone[0] . $home_phone[1]
            ]
        ];

        return $this;
    }

    /**
     * Endereco do cliente
     * @param string $street
     * @return $this
     */
    public function setCustomerStreet(string $street)
    {
        $this->payload['customer']['address']['street'] = $street;

        return $this;
    }

    /**
     * Número do endereço do cliente
     * @param $number
     * @return $this
     */
    public function setCustomerAddressNumber($number)
    {
        $this->payload['customer']['address']['number'] = $number;

        return $this;
    }

    /**
     * CEP do cliente
     * @param $zip_code
     * @return $this
     */
    public function setCustomerZipCode($zip_code)
    {
        $this->payload['customer']['address']['zip_code'] = preg_replace("/[^0-9]/", "", $zip_code);

        return $this;
    }

    /**
     * Nome do bairro onde o cliente mora
     * @param $neighborhood
     * @return $this
     */
    public function setCustomerNeighborhood($neighborhood)
    {
        $this->payload['customer']['address']['neighborhood'] = $neighborhood;

        return $this;
    }

    /**
     * Nome da cidade onde o cliente mora
     * @param string $city
     * @return $this
     */
    public function setCustomerCity(string $city)
    {
        $this->payload['customer']['address']['city'] = $city;

        return $this;
    }

    /**
     * Nome do estado onde o cliente mora
     * @param string $state
     * @return $this
     */
    public function setCustomerState(string $state)
    {
        $this->payload['customer']['address']['state'] = $state;

        return $this;
    }

    /**
     * Pais do cliente já está padrão como BR
     * @param string $country
     * @return $this
     */
    public function setCustomerCountry(string $country = 'BR')
    {
        $this->payload['customer']['address']['country'] = $country;

        return $this;
    }

    /**
     * IP do cliente
     * @param $ip
     * @return $this
     */
    public function setCustomerIp($ip)
    {
        $this->payload['ip'] = $ip;

        return $this;
    }

    /**
     * Plataforma de compra do cliente
     * @param string $platform
     * @return $this
     */
    public function setCustomerPlatform(string $platform)
    {
        $this->payload['device']['platform'] = $platform;

        return $this;
    }
}