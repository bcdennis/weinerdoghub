<?php

namespace Smile\Core\Persistence\Repositories\Eloquent;

use Smile\Core\Persistence\Repositories\UserContract;
use Smile\Core\Persistence\Models\User;

class UserRepository extends BaseRepository implements UserContract
{
    /**
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * Find user by id
     *
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        return $this->model->where('id', $id)->first();
    }

    /**
     * Find user by his email
     *
     * @param $email
     * @return mixed
     */
    public function findByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }

    /**
     * @param $email
     * @param $token
     * @return mixed
     */
    public function findByEmailAndToken($email, $token)
    {
        return $this->model->where('email', $email)
                    ->where('confirmation_code', $token)
                    ->first();
    }

    /**
     * Find user by its name
     *
     * @param $name
     * @return mixed
     */
    public function findByName($name)
    {
        return $this->model->with('activity')->where('name', $name)->first();
    }

    /**
     * Search for users
     *
     * @param $query
     * @param $perPage
     * @return mixed
     */
    public function search($query, $perPage = 10)
    {
        $query = $this->escape($query);

        return $this->model->where('name', 'like', '%'.$query.'%')
                           ->where('email', 'like', '%'.$query.'%')
                           ->paginate($perPage);
    }

    /**
     * Creates a new user
     *
     * @param $data
     * @return User
     */
    public function create($data)
    {
        $user = $this->getNew();
        $user->fill($data);
        $user->save();

        return $user;
    }

    /**
     * Updates an user
     *
     * @param User $user
     * @param array $data
     * @return User
     */
    public function update(User $user, array $data)
    {
        $user->fill($data);
        $user->save();

        return $user;
    }

    /**
     * Deletes a user by model
     *
     * @param User $user
     * @return bool|null
     * @throws \Exception
     */
    public function delete(User $user)
    {
        return $user->delete();
    }

}
