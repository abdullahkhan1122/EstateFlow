<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AgentRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AgentController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', User::class);

        return view('admin.agents.index', [
            'agents' => User::agents()->withCount('properties')->latest()->paginate(12),
        ]);
    }

    public function create(): View
    {
        $this->authorize('create', User::class);

        return view('admin.agents.create', ['agent' => new User(['is_active' => true])]);
    }

    public function store(AgentRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['role'] = User::ROLE_AGENT;
        $data['is_active'] = (bool) ($data['is_active'] ?? false);
        $data['email_verified_at'] = now();
        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()->route('admin.agents.index')->with('status', 'Agent created.');
    }

    public function edit(User $agent): View
    {
        $this->authorize('update', $agent);

        return view('admin.agents.edit', compact('agent'));
    }

    public function update(AgentRequest $request, User $agent): RedirectResponse
    {
        $this->authorize('update', $agent);

        $data = $request->validated();
        $data['is_active'] = (bool) ($data['is_active'] ?? false);

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $agent->update($data);

        return redirect()->route('admin.agents.index')->with('status', 'Agent updated.');
    }

    public function destroy(User $agent): RedirectResponse
    {
        $this->authorize('delete', $agent);
        $agent->delete();

        return redirect()->route('admin.agents.index')->with('status', 'Agent deleted.');
    }
}
