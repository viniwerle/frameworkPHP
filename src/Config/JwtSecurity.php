<?php

namespace App\Config;

use App\Models\Users;
use Exception;

/**
 * Classe jwtSecurity: Gerencia a autenticação via token JWT.
 */

class jwtSecurity
{
    protected $_users;


    /**
     * Construtor da classe.
     */

    public function __construct()
    {
        $this->_users = new Users();
    }

    /**
     * Função de login.
     *
     * @param string $user Nome de usuário.
     * @param string $password Senha do usuário.
     *
     * @return bool
     */

    public function login($user, $password)
    {

        if ($this->passwordCheck($user, $password)) {
            $this->createJWT($user);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Função createJWT.
     *
     * @param string $userName Nome de usuário para o qual o token JWT está sendo criado.
     *
     * @return void
     */

    private function createJWT($userName)
    {
        if (session_status() != 2) {
            session_start();
        }

        $returnDB = $this->_users->getByEmail($userName);
        // Dados do usuário que serão incorporados no token       

        $dadosUsuario = [
            'id' => $returnDB['ID'],
            'nome' => $returnDB['Name'],
            'email' => $returnDB['Email'],
        ];

        // Configuração do token
        $tokenConfig = [
            'iss' => 'seu_site',
            'aud' => 'sua_aplicacao',
            'iat' => time(), // Timestamp de quando o token foi emitido
            'exp' => time() + 3600, // Timestamp de quando o token expirará (1 hora neste exemplo)
        ];
        // Cabeçalho e payload do token
        $header = ['alg' => 'HS256', 'typ' => 'JWT'];
        $payload = array_merge($dadosUsuario, $tokenConfig);

        // Gere o token JWT
        $token = $this->generateJWT($header, $payload, jwtSecurity::HashUser($dadosUsuario['id']));

        $_SESSION['jwt_token'] = $token;
    }
    private static function base64UrlEncode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
    private static function base64UrlDecode($data)
    {
        $padding = strlen($data) % 4;
        if ($padding) {
            $data .= str_repeat('=', 4 - $padding);
        }

        return base64_decode(strtr($data, '-_', '+/'));
    }

    /**
     * Função generateJWT.
     *
     * @param array  $header  Cabeçalho do token JWT.
     * @param array  $payload Payload do token JWT.
     * @param string $secret  Chave secreta para a assinatura do token.
     *
     * @return string Token JWT gerado.F
     */

    private function generateJWT($header, $payload, $secret)
    {
        $headerEncoded = self::base64UrlEncode(json_encode($header));
        $payloadEncoded = self::base64UrlEncode(json_encode($payload));

        $signature = hash_hmac('sha256', "$headerEncoded.$payloadEncoded", $secret, true);
        $signatureEncoded = self::base64UrlEncode($signature);

        return "$headerEncoded.$payloadEncoded.$signatureEncoded";
    }

    /**
     * Função passwordCheck.
     *
     * Verifica a senha associada a um nome de usuário.
     *
     * @param string $userName Nome de usuário.
     * @param string $password Senha a ser verificada.
     *
     * @return bool Retorna true se a senha for válida para o usuário especificado, false caso contrário.
     */

    private function passwordCheck($userName, $password)
    {
        $returnDB = $this->_users->getByEmail($userName);
        if ($returnDB == null) {
            return false;
        } else {
            return Password::verifyPassword($password, $returnDB['Hash'], $returnDB['Salt']);
        }
        return false;
    }

    /**
     * Função userData.
     *
     * Obtém dados de um usuário com base no ID.
     *
     * @param int $id ID do usuário.
     *
     * @return array Retorna um array contendo os dados do usuário com o ID especificado.
     */

    private static function userData($id)
    {
        $userFunction = new Users();
        return $userFunction->getById($id);
    }

    /**
     * Função HashUser.
     *
     * Obtem o hash do usuário no banco de dados, buscando pelo Id.
     *
     * @param int $id ID do usuário.
     *
     * @return string Retorna a chave de hash do usuário com o ID especificado.
     */

    private static function HashUser($id)
    {
        $db = self::userData($id);
        return $db['Hash'];
    }

    /**
     * Função verifyJWT.
     *
     * Verifica a autenticidade de um token JWT.
     *
     * @param string $token Token JWT a ser verificado.
     *
     * @return mixed Retorna um array com os dados do payload se a verificação for bem-sucedida, false caso contrário.
     */

    private static function verifyJWT($token)
    {
        list($headerEncoded, $payloadEncoded, $signatureEncoded) = explode('.', $token);
        //$header = json_decode(jwtSecurity::base64UrlDecode($headerEncoded), true);        
        $payload = json_decode(jwtSecurity::base64UrlDecode($payloadEncoded), true);
        $secret = jwtSecurity::HashUser($payload['id']);
        $signature = jwtSecurity::base64UrlDecode($signatureEncoded);
        $expectedSignature = hash_hmac('sha256', "$headerEncoded.$payloadEncoded", $secret, true);
        if (hash_equals($signature, $expectedSignature)) {
            return $payload;
        }
        return false;
    }

    /**
     * Função RedirectLoginPage.
     *
     * Redireciona para a página de login, opcionalmente com uma URL de redirecionamento.
     *
     * @param string $redirect (Opcional) URL para redirecionamento após o login.
     *
     * @return void
     */

    public static function RedirectLoginPage($redirect = '')
    {
        $loginPage = '/login';
        if ($redirect != '') {
            header("Location:" . $loginPage . '/?redirect=' . urlencode($redirect));
        } else {
            header("Location:" . $loginPage);
        }
    }

    /**
     * Função isLogin.
     *
     * @return bool Retorna true se o usuário estiver logado e o token JWT for válido, false caso contrário.
     */

    public static function isLogin()
    {
        if (session_status() != 2) {
            session_start();
        }
        if (isset($_SESSION['jwt_token'])) {

            $payload = jwtSecurity::verifyJWT($_SESSION['jwt_token']);
            if ($payload == false) {
                return false;
            }
            if ($payload['exp'] > time()) {
                return true;
            }
        }
        return false;
    }

    /**
     * Função idLogin.
     *
     * @return int Retorna o ID do usuário se estiver logado.
     * @throws Exception Lança uma exceção se o usuário não estiver logado.
     */

    public static function idLogin()
    {
        if (jwtSecurity::isLogin()) {
            list($headerEncoded, $payloadEncoded, $signatureEncoded) = explode('.', $_SESSION['jwt_token']);
            $payload = json_decode(jwtSecurity::base64UrlDecode($payloadEncoded), true);
            return $payload['id'];
        } else {
            throw new Exception('Usuario não logado');
        }
    }
}
