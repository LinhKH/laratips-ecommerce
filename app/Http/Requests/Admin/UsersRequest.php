<?php

namespace App\Http\Requests\Admin;

use App\Models\Users;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

class UsersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $model = $this->route('user');
        $passwordRule = $model ? ['nullable'] : ['required'];
        // dd(Rule::unique(Users::class)->ignore($model->user_id ?? null));
        return [
            'name' => ['bail', 'required', 'string', 'max:255'],
            'email' => ['bail', 'required', 'email', 'max:255', Rule::unique(Users::class)->ignore($model->user_id ?? null,'user_id')],
            'password' => ['bail','sometimes', ...$passwordRule, Password::defaults()],
            'passwordConfirmation' => ['bail', 'sometimes', ...$passwordRule, 'same:password'],
            // 'roleId' => ['bail', 'required', Rule::exists(Role::class, 'id')],
        ];
    }
}
