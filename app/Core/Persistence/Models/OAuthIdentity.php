<?php

namespace Smile\Core\Persistence\Models;

use Illuminate\Database\Eloquent\Model;

class OAuthIdentity extends Model {

	/**
	 * Model table
	 *
	 * @var string
	 */
	protected $table = 'oauth_identities';

	/**
	 * Attributes that can be mass assigned
	 *
	 * @var array
	 */
	protected $fillable = ['user_id', 'provider_id', 'provider', 'token'];

	/**
	 * Deactivate timestamps for this model
	 *
	 * @var bool
	 */
	public $timestamps = false;
}
