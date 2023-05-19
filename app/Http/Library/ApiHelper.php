<?php

namespace App\Http\Library;

use Illuminate\Http\JsonResponse;

trait ApiHelpers
{
    protected function isAdmin($user): bool
    {
        if (!empty($user)) {
            return $user->tokenCan('admin');
        }

        return false;
    }

    protected function isEditor($user): bool
    {

        if (!empty($user)) {
            return $user->tokenCan('editor');
        }

        return false;
    }

    protected function isViewer($user): bool
    {
        if (!empty($user)) {
            return $user->tokenCan('viewer');
        }

        return false;
    }

}
