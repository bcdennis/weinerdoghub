<?php

namespace Smile\Core\Persistence\Repositories\Eloquent;

use Smile\Core\Persistence\Models\OAuthIdentity;
use Smile\Core\Persistence\Repositories\OauthIdentityContract;

class OAuthIdentityRepository extends BaseRepository implements OAuthIdentityContract
{

	/**
	 * @param OAuthIdentity $model
	 */
	public function __construct(OAuthIdentity $model)
	{
		$this->model = $model;
	}

	/**
	 * Find OAuth identity by provider name and id
	 *
	 * @param $id
	 * @param $name
	 * @return mixed
	 */
	function findByProviderNameAndId($id, $name)
	{
		return $this->model->where('provider_id', $id)->where('provider', $name)->first();
	}

	/**
	 * Get first identity or create a new one
	 *
	 * @param array $data
	 * @return mixed
	 */
	public function create(array $data)
	{
		$identity = $this->getNew();
		$identity->fill($data);
		$identity->save();

		return $identity;
	}

	/**
	 * Update identity with new data
	 *
	 * @param OAuthIdentity $identity
	 * @param array $data
	 * @return mixed
	 */
	public function update(OAuthIdentity $identity, array $data)
	{
		$identity->fill($data);
		$identity->save();

		return $identity;
	}
}