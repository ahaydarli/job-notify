<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        $formattedUser = [
            'uid' => $user->uid,
            'name' => $user->name,
            'email' => $user->email,
            'is_activated' => $user->is_activated,
            'activated_at' => (string) $user->activated_at,
            'last_login' => $user->last_login,
            'created_at' => (string) $user->created_at,
            'updated_at' => (string) $user->updated_at,
            'username' => $user->username,
            'surname' => $user->surname,
            'last_seen' => $user->last_seen,
            'is_guest' => $user->is_guest,
            'is_superuser' => $user->is_superuser,
            'phone' => $user->phone,
            'is_company' => $user->is_company,
            'tax_id' => $user->tax_id,
            'role' => $user->role,
            'facebook' => $user->facebook,
            'linkedin' => $user->linkedin,
            'twitter' => $user->twitter,
            'instagram' => $user->instagram,
            'salary_min' => $user->salary_min,
            'profileImage' => $user->profileImage,
            'gender' => $user->gender,
            'date_of_birth' => $user->date_of_birth,
            'education' => $user->education,
            'experience' => $user->experience,
            'category' => $user->category,
            'subcategory' => $user->subCategory,
            'country' => $user->country,
            'city' => $user->city,
            'user_agreement' => $user->user_agreement,
        ];

        return $formattedUser;
    }
}
