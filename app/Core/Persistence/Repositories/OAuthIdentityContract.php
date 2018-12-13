<?php

namespace Smile\Core\Persistence\Repositories;

use Smile\Core\Persistence\Models\OAuthIdentity;

interface OAuthIdentityContract
{
	/**
	 * Find OAuth identity by provider name and id
	 *
	 * @param $id
	 * @param $name
	 * @return mixed
	 */
	public function findByProviderNameAndId($id, $name);

	/**
	 * Get first identity or create a new one
	 *
	 * @param array $data
	 * @return mixed
	 */
	public function create(array $data);

	/**
	 * Update identity with new data
	 *
	 * @param OAuthIdentity $identity
	 * @param array $data
	 * @return mixed
	 */
	public function update(OAuthIdentity $identity, array $data);
}