<?php
/**
 * Created by PhpStorm.
 * User: minhphuc429
 * Date: 6/28/18
 * Time: 16:15
 */

namespace App\Repositories\Eloquent;


class SocialAccountRepository extends BaseRepository
{
    /**
     * Specify Model class name
     */
    function model()
    {
        return 'App\Models\User';
    }
}