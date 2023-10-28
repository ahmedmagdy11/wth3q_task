<?php

namespace App\Http\Controllers;

use App\Repositories\Auth\AuthRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller {

    private $loginRules = [
        'username' => 'required|string|exists:users,username',
        'password' => 'required|string|min:8',
    ];

    private $registerRules = [
        'username' => 'required|string|unique:users,username',
        'password' => 'required|string|min:8',
        'avatar' => 'nullable|mime_types:image/jpeg,image/png,image/jpg',
        'name' => 'required|string',
    ];


    private $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository) {
        $this->authRepository = $authRepository;
        $this->middleware('auth:api', ['except' => ['login']]);
    }


    public function login(Request $request) {
        try {
            $validator = Validator::make($request->all(), $this->loginRules);
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();
                return _api_json('', ['errors' => $errors], 400);
            }
            $data = $this->authRepository->login($request);
            if (!$data) {
                $message = _lang('app.login_failed');
                return _api_json([], ['message' => $message], 400);
            }
            $message = _lang('app.login_success');
            return _api_json($data, ['message' => $message], 200);
        } catch (\Exception $e) {
            return $e;
            $message = _lang('app.something_went_wrong');
            return _api_json([], ['message' => $message], 400);
        }
    }

    public function register(Request $request) {
        try {
            $validator = Validator::make($request->all(), $this->registerRules);
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();
                return _api_json('', ['errors' => $errors], 400);
            }
            DB::beginTransaction();
            $this->authRepository->register($request);
            DB::commit();
            $message = _lang('app.register_success');
            return _api_json([], ['message' => $message], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            $message = _lang('app.something_went_wrong');
            return _api_json([], ['message' => $message], 400);
        }
    }
}
