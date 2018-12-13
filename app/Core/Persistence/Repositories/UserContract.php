<?php

namespace Smile\Core\Persistence\Repositories;

use Smile\Core\Persistence\Models\User;

interface UserContract
{
	/**
	 * Find user by his email
	 *
	 * @param $email
	 * @return mixed
	 */
	public function findByEmail($email);

	/**
	 * Find user by its name
	 *
	 * @param $name
	 * @return mixed
	 */
	public function findByName($name);

    /**
     * @param $email
     * @param $token
     * @return mixed
     */
    public function findByEmailAndToken($email, $token);

    /**
     * Find user by id
     *
     * @param $id
     * @return mixed
     */
    public function findById($id);

	/**
	 * Creates a new user
	 *
	 * @param $data
	 * @return User
	 */
	public function create($data);

    /**
	 * Updates an user
	 *
	 * @param User $user
	 * @param array $data
	 * @return User
	 */
	public function update(User $user, array $data);

	/**
	 * Deletes a user by model
	 *
	 * @param User $user
	 * @return bool|null
	 * @throws \Exception
	 */
	public function delete(User $user);

    /**
     * Search for users
     *
     * @param $query
     * @param $perPage
     * @return mixed
     */
    public function search($query, $perPage = 10);

}
