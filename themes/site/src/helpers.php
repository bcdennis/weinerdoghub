<?php

/**
 * Helper function for button generation
 *
 * @param $model
 * @param $type
 * @param null $user
 * @return string
 */
function voteButton($model, $type, $user = null)
{
    if ($model instanceof \Smile\Core\Persistence\Models\Comment) {
        $url = route('comments.vote', $model->id);
    } else {
        $url = route('posts.vote', $model->id);
    }
    $active =  '';

    if ($model->votes->count() > 0 && $active !== null) {
        if ($type == 'like' && $model->votes[0]->value == 1) {
            $active = 'active';
        }
        if ($type == 'dislike' && $model->votes[0]->value == -1) {
            $active = 'active';
        }
    }

    $target = ! $user ? 'data-target=".modal-log-in"' : '';
    $active = ! $user ? $active.' modal-trigger' : $active;

    return sprintf('<button data-url="%s" %s class="%s %s"></button>', $url, $target ,$type, $active);
}

/**
 * Set active acording to the route
 *
 * @param $name
 * @return string
 */
function setActive($name)
{
    if (\Route::currentRouteName() == $name) {
        return 'class="active"';
    }
    return '';
}

/**
 * Profile active link
 *
 * @param $user
 * @param $route
 * @return string
 */
function setProfileActive($user, $route)
{
    $currentRoute = Route::current();
    $params = $currentRoute->parameters();

    $param = isset($params['user']) ? $params['user'] : null;

    if ($currentRoute->getName() === $route) {
        return $param->name == $user->name ? ' class="active" ' : '';
    }

    return '';
}

/**
 * Check if a category should be active acording to the route
 *
 * @param $category
 * @param $pos
 * @return bool
 */
function activeCategory($category, $pos = null)
{
    $route = Route::current();
    $params = $route->parameters();

    $param = isset($params['category']) ? $params['category'] : null;

    if ($route->getName() == 'home') {
        return $param == $category->slug || ($pos == 0 && $param == null);
    }

    return false;
}

/**
 * Display avatar
 *
 * @param $url
 * @return string
 */
function avatar($url)
{
    if (stripos($url, 'http') !== false) {
        return $url;
    }

    return $url ?  media($url) : assetTheme('assets/img/default.png');
}

/**
 * Computer user's rank
 *
 * @param $points
 * @return string
 */
function computeRank($points)
{
    if ($points < setting('bronze-lvl', 50000)) {
        return '';
    }

    if ($points < setting('silver-lvl', 100000)) {
        return 'bronze';
    }

    if ($points < setting('gold-lvl', 250000)) {
        return 'silver';
    }

    if ($points < setting('platinum-lvl', 500000)) {
        return 'gold';
    }

    if ($points >= setting('platinum-lvl', 500000)) {
        return 'platinum';
    }

    return '';
}


function canContact()
{
    if (setting('email.driver', 'mail') == 'smtp') {
        return setting('email.host') ? true : false;
    }

    return setting('email.sender-email') ? true : false;
}

/**
 * Parse post description
 *
 * @param $description
 * @return string
 */
function parseDescription($description)
{
    $html = '';
    $paragraphs = preg_split('/\n/i', $description);

    foreach ($paragraphs as $paragraph) {
        if (trim($paragraph)) {
            $html .= '<p>'.$paragraph.'</p>';
        }
    }

    return $html;
}


/**
 * Parse comment
 *
 * @param $comment
 * @return mixed
 */
function parseComment($comment)
{
    $regex = '#(?<=^|(?<=[^a-zA-Z0-9-_\.]))@([A-Za-z]+[A-Za-z0-9]+)#i';

    $callback = function ($value) {
        return sprintf('<a target="_blank" href="%s">@%s</a>', route('profile.overview', $value[1]), $value[1]);
    };

    return preg_replace_callback($regex, $callback, $comment);
}
