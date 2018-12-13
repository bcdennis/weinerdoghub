<?php

namespace Smile\Core\Services;

use Illuminate\Auth\Guard;
use Illuminate\Contracts\Hashing\Hasher;
use Smile\Core\Contracts\Image\UploaderContract;
use Smile\Events\User\UserWasConfirmed;
use Smile\Events\User\UserWasDeleted;
use Smile\Events\User\UserWasCreated;
use Smile\Events\User\UserWasBlocked;
use Smile\Events\User\UserWasUnblocked;
use Smile\Core\Persistence\Repositories\ActivityContract;
use Smile\Core\Persistence\Repositories\UserContract;
use Smile\Core\Persistence\Models\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UserService
{
	/**
	 * @var UploaderContract
	 */
	private $imageUpload;
	/**
	 * @var UserContract
	 */
	private $userRepo;
    /**
     * @var Hasher
     */
    private $hasher;
    /**
     * @var ActivityContract
     */
    private $activityRepo;
	/**
	 * @var Guard
	 */
	private $auth;

	/**
	 * @param UserContract $userRepo
	 * @param Guard $auth
	 * @param UploaderContract $imageUpload
	 * @param Hasher $hasher
	 * @param ActivityContract $activityRepo
	 */
	public function __construct(UserContract $userRepo,
								Guard $auth,
                                UploaderContract $imageUpload,
                                Hasher $hasher,
								ActivityContract $activityRepo)
	{
		$this->imageUpload = $imageUpload;
		$this->userRepo = $userRepo;
        $this->hasher = $hasher;
        $this->activityRepo = $activityRepo;
		$this->auth = $auth;
	}

    /**
     * Create user
     *
     * @param array $data
     * @return null|User
     */
	public function create(array $data)
	{
		$data['password'] = bcrypt($data['password']);
        $data['status'] = 1;

        $user = $this->userRepo->create($data);

        if ($user) {
            event(new UserWasCreated($user));
            return $user;
        }

        return null;
	}

    /**
     * Confirm account
     *
     * @param $email
     * @param $token
     * @return bool|User
     */
	public function confirm($email, $token)
	{
		$user = $this->userRepo->findByEmailAndToken($email, $token);

        if ($user && $token) {
            $user = $this->userRepo->update($user, [
                'confirmation_code' => '',
                'status' => 1,
            ]);
            event(new UserWasConfirmed($user));
            $this->auth->login($user);

            return $user;
        }

        return false;
	}

    /**
     * Update user profile
     *
     * @param User $user
     * @param array $data
     * @return User
     */
	public function updateProfile(User $user, array $data)
	{
		if ( ! empty($data['avatar']) && $data['avatar'] instanceof UploadedFile) {
			$data['avatar'] = $this->imageUpload->avatar($user, $data['avatar']);
		} else {
			unset($data['avatar']);
		}

		if ( ! empty($data['password'])) {
			$data['password'] = bcrypt($data['password']);
		} else {
			unset($data['password']);
		}

		return $this->userRepo->update($user, $data);
	}

	/**
	 * Reset user avatar
	 *
	 * @param User $user
	 */
	public function resetAvatar(User $user)
	{
		if ($user->avatar) {
			if ( ! starts_with($user->avatar, 'http')) {
                $this->imageUpload->removeAvatar($user);
            }
			$this->userRepo->update($user, ['avatar' => '']);
		}
	}

    /**
     * Delete account
     *
     * @param User $user
     * @param array $data
     * @return bool
     */
	public function delete(User $user, array $data)
	{

        if ( ! $this->hasher->check($data['password'], $user->password)) {
            return false;
        }

		if ($this->userRepo->delete($user)) {
            event(new UserWasDeleted($user));
            return true;
        }

        return false;
	}

    /**
     * Delete user
     *
     * @param $id
     * @return bool
     */
    public function deleteById($id)
    {
        $user = $this->userRepo->findById($id);

        if ($user && $user->permission != 'admin') {
            $this->userRepo->delete($user);
            event(new UserWasDeleted($user));

            return true;
        }

        return false;
    }

	/**
	 * Find activities for user
	 *
	 * @param User $user
	 * @param null $eventName
	 * @param int $perPage
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
    public function findActivities(User $user, $eventName = null, $perPage = 10)
    {
        return $this->activityRepo->findByUser($user, $eventName, $perPage);
    }

	/**
	 * Find user by name
	 *
	 * @param $name
	 * @return mixed
	 */
	public function getByName($name)
	{
		return $this->userRepo->findByName($name);
	}

    /**
     * Generate confirmation token
     *
     * @param User $user
     * @return User
     */
    public function generateConfirmation(User $user)
	{
        $token = str_random(29);

        return $this->userRepo->update($user, [
            'confirmation_code' => $token,
            'status' => 0,
        ]);
	}

    /**
     * Search for users
     *
     * @param $query
     * @param int $perPage
     * @return mixed
     */
    public function search($query, $perPage = 10)
    {
        return $this->userRepo->search($query, $perPage);
    }


    /**
     * @param $id
     * @return User
     */
    public function toggleBlock($id)
    {
        $user = $this->userRepo->findById($id);

        if ( ! $user || $user->permission == 'admin') {
            return false;
        }

        $toggle = ! ((bool) ($user->blocked));

        $user = $this->userRepo->update($user, [
            'blocked' => $toggle,
        ]);

        $event = ! $toggle ? new UserWasBlocked($user) : new UserWasUnblocked($user);

        event($event);

        return true;
    }
}
