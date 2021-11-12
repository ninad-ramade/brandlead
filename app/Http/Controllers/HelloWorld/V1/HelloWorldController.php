<?php 

namespace App\Http\Controllers\HelloWorld\V1;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use App\Http\Controllers\Controller;
use App\HelloWorld;

class HelloWorldController extends BaseController {
    
    private $model;
    
    public function __construct() {
        if($this->model === null) {
            $this->model = new HelloWorld();
        }
        parent::__construct();
    }
    
    protected function APICall($params) {
        $actionParams = array_filter(["id" => !empty($params['id']) ? $params['id'] : '', "name" => !empty($params['name']) ? $params['name'] : '', "action" => $params['route']->getActionMethod()]);
        $actionParams = array_merge($actionParams, $params['request']->all());
        $response = $this->model->process($actionParams);
        return $response;
    }
    
    public function create(Route $route, Request $request, $name) {
        return $this->validateRequiredParams(['name' => $name, 'request' => $request, 'route' => $route]);
    }
    public function fetch(Route $route, Request $request) {
        return $this->validateRequiredParams(['request' => $request, 'route' => $route]);
    }
    public function delete(Route $route, Request $request, $id) {
        return $this->validateRequiredParams(['id' => $id, 'request' => $request, 'route' => $route]);
    }
    public function update(Route $route, Request $request, $id, $name) {
        return $this->validateRequiredParams(['id' => $id, 'name' => $name, 'request' => $request, 'route' => $route]);
    }
}
?>