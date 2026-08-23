<div class="container-fluid bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="bg-white p-4 rounded shadow-lg" style="width: 25rem;">
        <a href="https://www.youtube.com/@RonaldCodes23" target="_blank"><img
                src="{{ asset('assets/images/RonaldCodesLogo.png') }}" alt="Ronald Codes Logo"
                class="mx-auto d-block mb-4 rounded-circle cursor-pointer" style="width: 100px" />
        </a>

        <h3 class="font-weight-bold mb-4 text-dark text-center">Register</h3>

        <form>
            <div class="form-group mb-4">
                <label for="name" class="text-sm font-weight-bold text-gray-700 mb-1">Name</label>
                <input type="text" class="form-control" wire:model="name" required>
                @error('name')
                    <p class="text-sm text-danger mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="email" class="text-sm font-weight-bold text-gray-700 mb-1">Email</label>
                <input wire:model="email" type="email" class="form-control" wire:model="email" required>
                @error('email')
                    <p class="text-sm text-danger mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mb-4" x-data="{ show: false }">
                <label for="password" class="text-sm font-weight-bold text-gray-700 mb-1">Password</label>
                <div class="position-relative">
                    <input wire:model="password" :type="show ? 'text' : 'password'" class="form-control" wire:model="password" required>
                    <button type="button" @click="show = !show" class="btn btn-sm position-absolute" style="right: 4px; top: 50%; transform: translateY(-50%);">
                        <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        <svg x-show="show" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                    </button>
                </div>
                @error('password')
                    <p class="text-sm text-danger mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mb-4" x-data="{ show: false }">
                <label for="password_confirmation" class="text-sm font-weight-bold text-gray-700 mb-1">Confirm
                    Password</label>
                <div class="position-relative">
                    <input :type="show ? 'text' : 'password'" class="form-control" wire:model="password_confirmation" required>
                    <button type="button" @click="show = !show" class="btn btn-sm position-absolute" style="right: 4px; top: 50%; transform: translateY(-50%);">
                        <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        <svg x-show="show" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                    </button>
                </div>
                @error('password_confirmation')
                    <p class="text-sm text-danger mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="button" wire:click="register" class="btn btn-primary w-100">
                Register
            </button>

            <a href="{{ route('login') }}" wire:navigate>Already have an account? Login</a>

        </form>
    </div>
</div>
