<div class="space-y-5">
    <div>
        <label for="name" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
            Nama Lengkap <span class="text-red-500">*</span>
        </label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                <i class="fas fa-user text-sm"></i>
            </div>
            <input type="text" id="name" name="name" value="{{ old('name', $user?->name) }}" required
                class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border @error('name') border-red-300 ring-2 ring-red-100 @else border-gray-200 @enderror rounded-xl text-sm focus:bg-white focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition">
        </div>
        @error('name')
            <p class="text-xs text-red-600 mt-1.5 font-medium flex items-center gap-1"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="email" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
            Alamat Email <span class="text-red-500">*</span>
        </label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                <i class="fas fa-envelope text-sm"></i>
            </div>
            <input type="email" id="email" name="email" value="{{ old('email', $user?->email) }}" placeholder="nama@email.com" required
                class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border @error('email') border-red-300 ring-2 ring-red-100 @else border-gray-200 @enderror rounded-xl text-sm focus:bg-white focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition">
        </div>
        @error('email')
            <p class="text-xs text-red-600 mt-1.5 font-medium flex items-center gap-1"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="role" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
            Role Hak Akses <span class="text-red-500">*</span>
        </label>
        <select id="role" name="role" required
            class="w-full px-4 py-2.5 bg-gray-50 border @error('role') border-red-300 ring-2 ring-red-100 @else border-gray-200 @enderror rounded-xl text-sm focus:bg-white focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition text-gray-700">
            @foreach ($roles as $role)
                <option value="{{ $role->value }}" @selected(old('role', $user?->role->value ?? 'user') === $role->value)>{{ $role->label() }}</option>
            @endforeach
        </select>
        <p class="text-xs text-gray-400 mt-1.5">
            <strong>Admin</strong>: Akses penuh CRUD seluruh modul. <strong>User</strong>: Mengakses modul titik lalu lintas dan membuat laporan insiden.
        </p>
        @error('role')
            <p class="text-xs text-red-600 mt-1.5 font-medium flex items-center gap-1"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p>
        @enderror
    </div>

    <div class="pt-4 border-t border-gray-100">
        <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Keamanan & Password</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="password" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                    Password @unless ($user)<span class="text-red-500">*</span>@endunless
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                        <i class="fas fa-lock text-sm"></i>
                    </div>
                    <input type="password" id="password" name="password" autocomplete="new-password" @required(! $user)
                        class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border @error('password') border-red-300 ring-2 ring-red-100 @else border-gray-200 @enderror rounded-xl text-sm focus:bg-white focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition">
                </div>
                <p class="text-xs text-gray-400 mt-1.5">
                    {{ $user ? 'Kosongkan jika tidak ingin mengubah password.' : 'Minimal 8 karakter.' }}
                </p>
                @error('password')
                    <p class="text-xs text-red-600 mt-1.5 font-medium flex items-center gap-1"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                    Konfirmasi Password @unless ($user)<span class="text-red-500">*</span>@endunless
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                        <i class="fas fa-lock text-sm"></i>
                    </div>
                    <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password" @required(! $user)
                        class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition">
                </div>
            </div>
        </div>
    </div>
</div>
