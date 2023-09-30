<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Address;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $user = $request->user();
        $address = $user->activeAddress();

        return view('profile.edit', compact('user', 'address'));
    }

    public function updateUser(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = Auth::user();

        foreach ($request->all() as $key => $value) {
            $data[strtoupper($key)] = $value;
        }

        $data['USUARIO_SENHA'] = Hash::make($data['USUARIO_SENHA']);

        $user->update($data);

        return redirect()->back()->with('success', 'Dados do usuário atualizados com sucesso.');
    }

    public function updateAddress(Request $request): RedirectResponse
    {
        $request->validate([
            'endereco_cep' => 'required|string|max:8',
            'endereco_nome' => 'required|string',
            'endereco_logradouro' => 'required|string',
            'endereco_numero' => 'required|string',
            'endereco_complemento' => 'nullable|string',
            'endereco_cidade' => 'required|string',
            'endereco_estado' => 'required|string',
        ]);

        $user = $request->user();
        $address = $user->activeAddress();

        foreach ($request->all() as $key => $value) {
            $data[strtoupper($key)] = $value;
        }

        $data['USUARIO_ID'] = $user->USUARIO_ID;

        if ($address) {
            $address->update($data);
        } else {
            Address::create($data);
        }

        return redirect()->back()->with('success', 'Dados do endereço atualizados com sucesso.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function destroyAddress(): RedirectResponse
    {
        if (!Auth::user()->activeAddress()) {
            return redirect()->back();
        }

        Auth::user()->activeAddress()->update([
            'ENDERECO_APAGADO' => 1
        ]);

        return redirect()->back()->with('success', 'Endereço excluído com sucesso.');
    }
}
