<?php

namespace App\Config;
use App\Controller\PainelController;

class Router
{
    protected $uri;
    protected $method;
    protected $routes = [
        'GET' => [
            '/' => [PainelController::class, 'Index'],
            '/user/{id}' => [PainelController::class, 'Usuarios'],
            '/teste/a/{id}' => [PainelController::class, 'Index'],
        ],
    ];

    public function __construct()
    {
        // Inicializa o roteador e define o método HTTP e URI da requisição.
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri = self::explodeURI($_SERVER['REQUEST_URI']);
        $this->callMethod();
    }

    /**
     * Encontra a rota correspondente para a URI atual.
     *
     * @param array $params Um array para armazenar parâmetros de rota.
     * @return array|null Retorna um array contendo informações do controlador e método, ou null se a rota não for encontrada.
     */
    private function findMatchingRoute(&$params)
    {
        $varUri = $this->routes[$this->method];
        foreach ($varUri as $route => $handler) {
            if ($this->doesRouteMatch($route, $params)) {
                return $handler;
            }
        }

        return null;
    }

    /**
     * Verifica se a URI atual corresponde à rota especificada.
     *
     * @param string $route A rota a ser verificada.
     * @param array $params Um array para armazenar parâmetros de rota.
     * @return bool Retorna true se a rota corresponder, false caso contrário.
     */
    private function doesRouteMatch($route, &$params)
    {
        $routeSegments = self::explodeURI($route);

        if (count($routeSegments) !== count($this->uri)) {
            return false;
        }

        $match = true;

        foreach ($routeSegments as $i => $segment) {
            if (substr($segment, 0, 1) !== '{') {
                if ($this->uri[$i] !== $segment) {
                    $match = false;
                    break;
                }
            } else {
                $paramName = str_replace(['{', '}'], '', $segment);
                $params[] = [$paramName => $this->uri[$i]];
            }
        }

        return $match;
    }

    /**
     * Divide a URI em segmentos.
     *
     * @param string $uri A URI a ser dividida.
     * @return array Retorna um array contendo os segmentos da URI.
     */
    private static function explodeURI($uri)
    {
        return explode('/', $uri);
    }

    /**
     * Chama o método do controlador correspondente à rota encontrada.
     */
    private function callMethod()
    {
        $params = [];
        $routeInfo = $this->findMatchingRoute($params);
        if ($routeInfo !== null) {
            $controllerClass = $routeInfo[0];
            $method = $routeInfo[1];
            $controllerInstance = new $controllerClass();
            call_user_func_array([$controllerInstance, $method], $params);
        } else {
            // Tratar aqui a rota não encontrada
            echo "Rota não encontrada";
        }
    }
}
