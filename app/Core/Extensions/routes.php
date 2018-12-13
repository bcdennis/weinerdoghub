<?php

get('extensions/{extension}/assets/{file}', [
    'uses' => 'Smile\Core\Extensions\Controllers\AssetsController@serve',
    'as' => 'extensions.assets.serve',
])->where('file', '.*');