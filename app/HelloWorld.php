<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Exception;

class HelloWorld extends Model
{
    use SoftDeletes;
    
    protected $table = 'hello_worlds';
    protected $fillable = ['name'];
    public $response = ['status' => 0, 'data' => [], 'message' => ''];
    public function process($params) {
        switch (strtolower($params['action'])) {
            case "create":
                $this->name = $params['name'];
                if(!$this->save()) {
                    $this->response['message'] = __('HelloWorldConstants._NAME_SAVE_FAILED_');
                    return $this->response;
                }
                $this->response['status'] = 1;
                $this->response['data'] = ['id' => $this->id];
                $this->response['message'] = __('HelloWorldConstants._NAME_SAVE_SUCCESS_');
                return $this->response;
            case "fetch":
                $names = $this->all();
                if(empty($names)) {
                    $this->response['message'] = __('HelloWorldConstants._NAMES_FETCH_FAILED_');
                    return $this->response;
                }
                $this->response['status'] = 1;
                $this->response['data'] = $names;
                $this->response['message'] = __('HelloWorldConstants._NAMES_FETCH_SUCCESS_');
                return $this->response;
            case "update":
                $row = $this->find($params['id']);
                if(empty($row)) {
                    $this->response['message'] =  __('HelloWorldConstants._NAME_UPDATE_FAILED_');
                    return $this->response;
                }
                $row->name = $params['name'];
                if(!$row->save()) {
                    $this->response['message'] =  __('HelloWorldConstants._NAME_UPDATE_FAILED_');
                    return $this->response;
                }
                $this->response['status'] = 1;
                $this->response['message'] =  __('HelloWorldConstants._NAME_UPDATE_SUCCESS_');
                return $this->response;
            case "delete":
                $row = $this->find($params['id']);
                if(empty($row) || !$row->delete()) {
                    $this->response['message'] =  __('HelloWorldConstants._NAME_DELETE_FAILED_');
                    return $this->response;
                }
                $this->response['status'] = 1;
                $this->response['message'] =  __('HelloWorldConstants._NAME_DELETE_SUCCESS_');
                return $this->response;
        }
    }
}
