<?php
    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\LoginRequest;
    use App\Http\Requests\RegisterRequest;
    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Validation\ValidationException;

    class AuthController extends Controller {
        
        //Registrar usuário
        public function register(RegisterRequest $request) {
            $validated = $request->validated();

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password'])
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Usuário criado com sucesso',
                'token' => $token,
                'user' => $user
            ], 201);
        }

        //Login usuário
        public function login(LoginRequest $request) {
            $validated = $request->validated();

            $user = User::where('email', $validated['email'])->first();

            if (! $user || ! Hash::check($validated['password'], $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['Credenciais inválidas.'],
                ]);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Login realizado com sucesso',
                'token' => $token,
                'user' => $user
            ]);
        }

        //Usuário autenticado
        public function me(Request $request) {
            return response()->json($request->user());
        }

        //Logout
        public function logout(Request $request) {
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'message' => 'Logout realizado com sucesso'
            ]);
        }
    }
?>