<?php 

namespace App\Http\Controllers\HelloWorld\V1;

use App\Http\Controllers\Controller;
use App\HelloWorld;

abstract class BaseController extends Controller {
    
    protected $api;
    private $paramsValidationForAction;
    
    public function __construct() {
        if ($this->api === null) {
            $this->api = new HelloWorld();
        }
    }
    abstract protected function APICall($params);
    
    protected function validateRequiredParams($params) {
        $response = ['status' => 0, 'data' => []];
        if (empty($params['name']) && !in_array(strtolower($params['route']->getActionMethod()), ['fetch', 'trashed', 'active', 'delete', 'restore'])) {
            $response['message'] = __('message.INVALID_PARAMS');
            return $response;
        }
        if (empty($params['id']) && in_array(strtolower($params['route']->getActionMethod()), ['delete', 'update', 'restore'])) {
            $response['message'] = __('message.INVALID_PARAMS');
            return $response;
        }
        $response = $this->APICall($params);
        $response = response()->json($response, !empty($response['exception']) ? $response['exception'] : 200);
        return $response;
    }
}
?>