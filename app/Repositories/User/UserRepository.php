<?php

namespace App\Repositories\User;

use App\Models\User;

class UserRepository implements UserRepositoryInterface {
    private $user;
    public function __construct(User $user) {
        $this->user = $user;
    }

    public function getAll() {
        return $this->user
            ->paginate();
    }

    public function getById($id) {
        return $this->user->find($id);
    }

    public function create($request) {
        $data = $request->only([
            'name',
            'username',
            'avatar',
            'is_active',
            'password',
        ]);
        return $this->user->create($data);
    }

    public function update($request, $id) {
        $data = $request->only([
            'name',
            'username',
            'avatar',
            'is_active',
            'password',
        ]);
        $user = $this->user->find($id);
        return $user->update($data);
    }

    public function delete($id) {
        $user = $this->user->find($id);
        return $user->delete();
    }



}
