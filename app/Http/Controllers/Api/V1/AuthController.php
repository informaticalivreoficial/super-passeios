<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:customers,email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Dados inválidos.', 'errors' => $validator->errors()], 422);
        }

        $customer = Customer::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'status'   => true,
        ]);

        $customer->assignRole('client');

        $token = $customer->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'customer' => new CustomerResource($customer),
            'token'    => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $customer = Customer::where('email', $request->email)->first();

        if (!$customer || !Hash::check($request->password, $customer->password)) {
            return response()->json(['message' => 'Credenciais inválidas.'], 401);
        }

        $token = $customer->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'customer' => new CustomerResource($customer),
            'token'    => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Sessão encerrada.']);
    }

    public function me(Request $request)
    {
        return response()->json(new CustomerResource($request->user()));
    }

    public function updateProfile(Request $request)
    {
        $customer = $request->user();

        $validator = Validator::make($request->all(), [
            'name'       => ['sometimes', 'required', 'string', 'max:255'],
            'email'      => ['sometimes', 'required', 'email', 'unique:customers,email,' . $customer->id],
            'phone'      => ['sometimes', 'nullable', 'string', 'max:20'],
            'cell_phone' => ['sometimes', 'nullable', 'string', 'max:20'],
            'whatsapp'   => ['sometimes', 'nullable', 'string', 'max:20'],
            'cpf'        => ['sometimes', 'nullable', 'string', 'max:20'],
            'gender'     => ['sometimes', 'nullable', 'string', 'in:male,female,other'],
            'birthday'   => ['sometimes', 'nullable', 'date'],
            'zipcode'    => ['sometimes', 'nullable', 'string', 'max:10'],
            'street'     => ['sometimes', 'nullable', 'string', 'max:255'],
            'number'     => ['sometimes', 'nullable', 'string', 'max:20'],
            'complement' => ['sometimes', 'nullable', 'string', 'max:255'],
            'neighborhood' => ['sometimes', 'nullable', 'string', 'max:255'],
            'state'      => ['sometimes', 'nullable', 'string', 'max:2'],
            'city'       => ['sometimes', 'nullable', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Dados inválidos.', 'errors' => $validator->errors()], 422);
        }

        $customer->update($validator->validated());

        return response()->json([
            'message'  => 'Perfil atualizado com sucesso.',
            'customer' => new CustomerResource($customer->fresh()),
        ]);
    }
}
