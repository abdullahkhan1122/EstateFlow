<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class AgentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->isAdmin();
    }

    public function rules(): array
    {
        $agent = $this->route('agent');

        return [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:190', Rule::unique(User::class)->ignore($agent?->id)],
            'phone' => ['nullable', 'string', 'max:40'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'password' => [$this->isMethod('post') ? 'required' : 'nullable', 'confirmed', Rules\Password::defaults()],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
