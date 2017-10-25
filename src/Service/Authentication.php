<?php namespace TourChannel\Payments\Service;

use Cache;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Informações para autenticação
 * Class Authentication
 * @package TourChannel\Payments\Service
 */
class Authentication
{
    /**
     * Usuário de acesso na API
     * @var
     */
    static protected $user;

    /**
     * Senha do Usuário na API
     * @var
     */
    static protected $password;

    /**
     * Nome da chave onde fica o token da API em cache até expirar
     */
    const TOKEN_CACHE = 'token_tourchannel_payment';

    /**
     * Path da URL de requisição
     */
    const _PATH = '/authentication';

    /**
     * Recupera o token de autenticação no Cache
     * Caso não tenha gera um novo token e coloca no cache
     * @return mixed
     */
    static public function getToken()
    {
        // Verifica os dados de acesso
        self::verifyCredentials();

        // Recupera o token no cache
        $token_cache = Cache::get(self::TOKEN_CACHE, null);

        // Caso não tenha o token gera um novo token
        return $token_cache ?? self::getNewToken();
    }

    /**
     * Verifica as credenciais colocadas no env
     * @throws \Exception
     */
    static public function verifyCredentials()
    {
        $user = env('TOURCHANNEL_PAYMENT_USER');
        $password = env('TOURCHANNEL_PAYMENT_PASSWORD');

        // Verifica se a configuração existe no ENV
        if($user == "" || $password == "") {
            throw new \Exception('Usário ou senha para acesso a API não está configurado no .ENV');
        } else {
            // Configura o usuário
            self::$user = $user;
            // Configura a senha do usuario
            self::$password = $password;
        }
    }

    /**
     * Gera um novo token e coloca no cache
     * @return mixed
     */
    static private function getNewToken()
    {
        // Token devolvido pela API
        $token_access = self::authenticate();

        // Tempo para expirar o token -1 hora do que retornado na API
        $expires_at = Carbon::parse($token_access->credentials->token_expiration)->subHours(1);

        // Coloca o token em cache
        Cache::put(self::TOKEN_CACHE, $token_access->credentials->token, $expires_at);

        return $token_access->credentials->token;
    }

    /**
     * Comunicação com a API para gerar novo Token
     * @return mixed|string
     */
    private static function authenticate() {

        // Connect da API de pagamentos
        $request_connect = new RequestConnect();

        // Realiza a comunicação
        return $request_connect->authenticate_api(self::_PATH, Request::METHOD_POST, [
            'user' => self::$user,
            'password' => self::$password,
        ]);
    }
}