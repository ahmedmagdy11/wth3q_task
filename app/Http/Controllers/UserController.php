<?php

namespace App\Http\Controllers;

use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller {
    private $createRules = [
        'name' => 'required|string',
        'username' => 'required|string|unique:users,username',
        'avatar' => 'required|string',
        'is_active' => 'required|boolean',
        'password' => 'required|string',

    ];

    private $updateRules = [
        'name' => 'string',
        'username' => 'string|unique:users,username',
        'avatar' => 'string',
        'is_active' => 'boolean',
        'password' => 'string',
    ];

    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function index() {
        try {
            $users = $this->userRepository->getAll();
            return _api_json($users);
        } catch (\Exception $e) {
            $message = _lang('app.something_went_wrong');
            return _api_json([], ['message' => $message], 400);
        }
    }

    public function show($id) {
        try {
            $user = $this->userRepository->getById($id);
            return _api_json($user);
        } catch (\Exception $e) {
            $message = _lang('app.something_went_wrong');
            return _api_json([], ['message' => $message], 400);
        }
    }

    public function store(Request $request) {
        try {
            $validator = Validator::make($request->all(), $this->createRules);
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();
                return _api_json([], ['errors' => $errors], 400);
            }
            DB::beginTransaction();
            $user = $this->userRepository->create($request);
            DB::commit();
            return _api_json($user, ['message' => _lang('app.created_successfully')]);
        } catch (\Exception $e) {
            DB::rollBack();
            $message = _lang('app.something_went_wrong');
            return _api_json([], ['message' => $message], 400);
        }
    }

    public function update(Request $request, $id) {
        try {
            $validator = Validator::make($request->all(), $this->updateRules);
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();
                return _api_json([], ['errors' => $errors], 400);
            }
            DB::beginTransaction();
            $user = $this->userRepository->update($request, $id);
            DB::commit();
            return _api_json($user, ['message' => _lang('app.updated_successfully')]);
        } catch (\Exception $e) {
            DB::rollBack();
            $message = _lang('app.something_went_wrong');
            return _api_json([], ['message' => $message], 400);
        }
    }

    public function destroy($id) {
        try {
            $user = $this->userRepository->delete($id);
            return _api_json($user, ['message' => _lang('app.deleted_successfully')]);
        } catch (\Exception $e) {
            $message = _lang('app.something_went_wrong');
            return _api_json([], ['message' => $message], 400);
        }
    }
}
