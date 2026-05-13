<div class="max-w-6xl mx-auto">

    <form wire:submit="save" class="space-y-6">

        {{-- AVATAR --}}
        <div class="bg-white rounded-2xl overflow-hidden" style="border: 1px solid #e8e4d8;">

            <div class="flex items-center gap-3 px-6 py-4" style="border-bottom: 1px solid #f0ece4;">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background-color: rgba(35,197,94,0.1);">
                    <svg class="w-5 h-5" style="color: #23c55e;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold" style="color: #051e34;">Foto de Perfil</h2>
                    <p class="text-xs" style="color: #87c2c0;">Visível para outros usuários.</p>
                </div>
            </div>

            <div class="p-6 flex items-center gap-6">

                <div class="w-20 h-20 rounded-2xl flex items-center justify-center font-extrabold text-2xl shrink-0" style="background-color: #23c55e; color: #051e34;">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>

                <div class="flex-1">
                    <input
                        type="file"
                        wire:model="avatar"
                        accept="image/*"
                        class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                        style="border-color: #e8e4d8; color: #051e34;"
                    >
                    <p class="text-xs mt-2" style="color: #87c2c0;">PNG, JPG até 2MB. Recomendado: 200x200px.</p>
                </div>

            </div>
        </div>

        {{-- DADOS PESSOAIS --}}
        <div class="bg-white rounded-2xl overflow-hidden" style="border: 1px solid #e8e4d8;">

            <div class="flex items-center gap-3 px-6 py-4" style="border-bottom: 1px solid #f0ece4;">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background-color: rgba(51,123,188,0.1);">
                    <svg class="w-5 h-5" style="color: #337bbc;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold" style="color: #051e34;">Dados Pessoais</h2>
                    <p class="text-xs" style="color: #87c2c0;">Informações de identificação.</p>
                </div>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- Nome --}}
                <div class="flex flex-col gap-1.5 md:col-span-2">
                    <label class="text-sm font-bold" style="color: #051e34;">Nome Completo <span style="color: #337bbc;">*</span></label>
                    <input type="text" wire:model="name" placeholder="Seu nome completo"
                        class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                        style="border-color: #e8e4d8; color: #051e34;"
                        onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                        onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'">
                    @error('name') <p class="text-xs" style="color:#e53e3e;">{{ $message }}</p> @enderror
                </div>

                {{-- Gênero --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">Gênero</label>
                    <select wire:model="gender"
                        class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                        style="border-color: #e8e4d8; color: #051e34;"
                        onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                        onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'">
                        <option value="">Selecione...</option>
                        <option value="M">Masculino</option>
                        <option value="F">Feminino</option>
                        <option value="O">Outro</option>
                        <option value="N">Prefiro não informar</option>
                    </select>
                </div>

                {{-- Estado Civil --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">Estado Civil</label>
                    <select wire:model="civil_status"
                        class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                        style="border-color: #e8e4d8; color: #051e34;"
                        onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                        onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'">
                        <option value="">Selecione...</option>
                        <option value="solteiro">Solteiro(a)</option>
                        <option value="casado">Casado(a)</option>
                        <option value="divorciado">Divorciado(a)</option>
                        <option value="viuvo">Viúvo(a)</option>
                        <option value="uniao_estavel">União Estável</option>
                    </select>
                </div>

                {{-- CPF --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">CPF</label>
                    <div class="relative">
                        <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" style="color: #87c2c0;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 3H8a2 2 0 00-2 2v2h12V5a2 2 0 00-2-2z"/></svg>
                        <input type="text" wire:model="cpf" placeholder="000.000.000-00"
                            class="w-full border rounded-xl text-sm pl-9 pr-3 py-2.5 outline-none transition"
                            style="border-color: #e8e4d8; color: #051e34;"
                            onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                            onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'">
                    </div>
                </div>

                {{-- RG --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">RG</label>
                    <input type="text" wire:model="rg" placeholder="00.000.000-0"
                        class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                        style="border-color: #e8e4d8; color: #051e34;"
                        onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                        onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'">
                </div>

                {{-- Nascimento --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">Data de Nascimento</label>
                    <input type="date" wire:model="birthday"
                        class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                        style="border-color: #e8e4d8; color: #051e34;"
                        onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                        onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'">
                </div>

                {{-- Naturalidade --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">Naturalidade</label>
                    <input type="text" wire:model="naturalness" placeholder="Cidade onde nasceu"
                        class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                        style="border-color: #e8e4d8; color: #051e34;"
                        onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                        onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'">
                </div>

            </div>
        </div>

        {{-- CONTATO --}}
        <div class="bg-white rounded-2xl overflow-hidden" style="border: 1px solid #e8e4d8;">

            <div class="flex items-center gap-3 px-6 py-4" style="border-bottom: 1px solid #f0ece4;">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background-color: rgba(22,163,183,0.1);">
                    <svg class="w-5 h-5" style="color: #16a3b7;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 10.8 19.79 19.79 0 01.22 2.18 2 2 0 012.18 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.91 7.91a16 16 0 006.29 6.29l1.28-1.28a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold" style="color: #051e34;">Contato</h2>
                    <p class="text-xs" style="color: #87c2c0;">E-mails, telefones e mensageiros.</p>
                </div>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- Email --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">E-mail Principal <span style="color: #337bbc;">*</span></label>
                    <div class="relative">
                        <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" style="color: #87c2c0;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        <input type="email" wire:model="email" placeholder="seu@email.com"
                            class="w-full border rounded-xl text-sm pl-9 pr-3 py-2.5 outline-none transition"
                            style="border-color: #e8e4d8; color: #051e34;"
                            onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                            onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'">
                    </div>
                    @error('email') <p class="text-xs" style="color:#e53e3e;">{{ $message }}</p> @enderror
                </div>

                {{-- Email adicional --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">E-mail Adicional</label>
                    <div class="relative">
                        <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" style="color: #87c2c0;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        <input type="email" wire:model="additional_email" placeholder="outro@email.com"
                            class="w-full border rounded-xl text-sm pl-9 pr-3 py-2.5 outline-none transition"
                            style="border-color: #e8e4d8; color: #051e34;"
                            onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                            onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'">
                    </div>
                </div>

                {{-- Telefone --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">Telefone</label>
                    <div class="relative">
                        <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" style="color: #87c2c0;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 10.8 19.79 19.79 0 01.22 2.18 2 2 0 012.18 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.91 7.91a16 16 0 006.29 6.29l1.28-1.28a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
                        <input type="text" wire:model="phone" placeholder="(00) 0000-0000"
                            class="w-full border rounded-xl text-sm pl-9 pr-3 py-2.5 outline-none transition"
                            style="border-color: #e8e4d8; color: #051e34;"
                            onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                            onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'">
                    </div>
                </div>

                {{-- Celular --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">Celular</label>
                    <div class="relative">
                        <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" style="color: #87c2c0;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
                        <input type="text" wire:model="cell_phone" placeholder="(00) 00000-0000"
                            class="w-full border rounded-xl text-sm pl-9 pr-3 py-2.5 outline-none transition"
                            style="border-color: #e8e4d8; color: #051e34;"
                            onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                            onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'">
                    </div>
                </div>

                {{-- WhatsApp --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">WhatsApp</label>
                    <div class="relative">
                        <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" style="color: #87c2c0;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/></svg>
                        <input type="text" wire:model="whatsapp" placeholder="(00) 00000-0000"
                            class="w-full border rounded-xl text-sm pl-9 pr-3 py-2.5 outline-none transition"
                            style="border-color: #e8e4d8; color: #051e34;"
                            onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                            onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'">
                    </div>
                </div>

                {{-- Telegram --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">Telegram</label>
                    <div class="relative">
                        <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" style="color: #87c2c0;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                        <input type="text" wire:model="telegram" placeholder="@usuario"
                            class="w-full border rounded-xl text-sm pl-9 pr-3 py-2.5 outline-none transition"
                            style="border-color: #e8e4d8; color: #051e34;"
                            onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                            onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'">
                    </div>
                </div>

            </div>
        </div>

        {{-- ENDEREÇO --}}
        <div class="bg-white rounded-2xl overflow-hidden" style="border: 1px solid #e8e4d8;">

            <div class="flex items-center gap-3 px-6 py-4" style="border-bottom: 1px solid #f0ece4;">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background-color: rgba(22,163,183,0.1);">
                    <svg class="w-5 h-5" style="color: #16a3b7;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold" style="color: #051e34;">Endereço</h2>
                    <p class="text-xs" style="color: #87c2c0;">Localização residencial.</p>
                </div>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-5">

                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">CEP</label>
                    <input type="text" wire:model="zipcode" placeholder="00000-000"
                        class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                        style="border-color: #e8e4d8; color: #051e34;"
                        onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                        onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'">
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">Cidade</label>
                    <input type="text" wire:model="city" placeholder="São Paulo"
                        class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                        style="border-color: #e8e4d8; color: #051e34;"
                        onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                        onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'">
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">Estado</label>
                    <input type="text" wire:model="state" placeholder="SP"
                        class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                        style="border-color: #e8e4d8; color: #051e34;"
                        onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                        onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'">
                </div>

                <div class="flex flex-col gap-1.5 md:col-span-2">
                    <label class="text-sm font-bold" style="color: #051e34;">Rua</label>
                    <input type="text" wire:model="street" placeholder="Av. Beira Mar"
                        class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                        style="border-color: #e8e4d8; color: #051e34;"
                        onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                        onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'">
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">Número</label>
                    <input type="text" wire:model="number" placeholder="123"
                        class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                        style="border-color: #e8e4d8; color: #051e34;"
                        onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                        onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'">
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">Bairro</label>
                    <input type="text" wire:model="neighborhood" placeholder="Centro"
                        class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                        style="border-color: #e8e4d8; color: #051e34;"
                        onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                        onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'">
                </div>

                <div class="flex flex-col gap-1.5 md:col-span-2">
                    <label class="text-sm font-bold" style="color: #051e34;">Complemento</label>
                    <input type="text" wire:model="complement" placeholder="Apto 42, Bloco B"
                        class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                        style="border-color: #e8e4d8; color: #051e34;"
                        onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                        onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'">
                </div>

            </div>
        </div>

        {{-- REDES SOCIAIS --}}
        <div class="bg-white rounded-2xl overflow-hidden" style="border: 1px solid #e8e4d8;">

            <div class="flex items-center gap-3 px-6 py-4" style="border-bottom: 1px solid #f0ece4;">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background-color: rgba(250,221,55,0.15);">
                    <svg class="w-5 h-5" style="color: #c4a800;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold" style="color: #051e34;">Redes Sociais</h2>
                    <p class="text-xs" style="color: #87c2c0;">Seus perfis nas redes.</p>
                </div>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- Instagram --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">Instagram</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm font-bold pointer-events-none" style="color: #87c2c0;">@</span>
                        <input type="text" wire:model="instagram" placeholder="seu_usuario"
                            class="w-full border rounded-xl text-sm pl-7 pr-3 py-2.5 outline-none transition"
                            style="border-color: #e8e4d8; color: #051e34;"
                            onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                            onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'">
                    </div>
                </div>

                {{-- Facebook --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">Facebook</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm font-bold pointer-events-none" style="color: #87c2c0;">f/</span>
                        <input type="text" wire:model="facebook" placeholder="seu.perfil"
                            class="w-full border rounded-xl text-sm pl-8 pr-3 py-2.5 outline-none transition"
                            style="border-color: #e8e4d8; color: #051e34;"
                            onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                            onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'">
                    </div>
                </div>

                {{-- Twitter / X --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">Twitter / X</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm font-bold pointer-events-none" style="color: #87c2c0;">@</span>
                        <input type="text" wire:model="twitter" placeholder="seu_usuario"
                            class="w-full border rounded-xl text-sm pl-7 pr-3 py-2.5 outline-none transition"
                            style="border-color: #e8e4d8; color: #051e34;"
                            onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                            onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'">
                    </div>
                </div>

                {{-- LinkedIn --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">LinkedIn</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm font-bold pointer-events-none" style="color: #87c2c0;">in/</span>
                        <input type="text" wire:model="linkedin" placeholder="seu-perfil"
                            class="w-full border rounded-xl text-sm pl-8 pr-3 py-2.5 outline-none transition"
                            style="border-color: #e8e4d8; color: #051e34;"
                            onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                            onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'">
                    </div>
                </div>

            </div>
        </div>

        {{-- SENHA --}}
        <div class="bg-white rounded-2xl overflow-hidden" style="border: 1px solid #e8e4d8;">

            <div class="flex items-center gap-3 px-6 py-4" style="border-bottom: 1px solid #f0ece4;">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background-color: rgba(51,123,188,0.1);">
                    <svg class="w-5 h-5" style="color: #337bbc;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold" style="color: #051e34;">Senha</h2>
                    <p class="text-xs" style="color: #87c2c0;">Deixe em branco para manter a atual.</p>
                </div>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">

                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">Nova Senha</label>
                    <div class="relative">
                        <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" style="color: #87c2c0;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                        <input type="password" wire:model="password" placeholder="••••••••"
                            class="w-full border rounded-xl text-sm pl-9 pr-3 py-2.5 outline-none transition"
                            style="border-color: #e8e4d8; color: #051e34;"
                            onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                            onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'">
                    </div>
                    @error('password') <p class="text-xs" style="color:#e53e3e;">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">Confirmar Senha</label>
                    <div class="relative">
                        <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" style="color: #87c2c0;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                        <input type="password" wire:model="password_confirmation" placeholder="••••••••"
                            class="w-full border rounded-xl text-sm pl-9 pr-3 py-2.5 outline-none transition"
                            style="border-color: #e8e4d8; color: #051e34;"
                            onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                            onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'">
                    </div>
                </div>

            </div>
        </div>

        {{-- SOBRE --}}
        <div class="bg-white rounded-2xl overflow-hidden" style="border: 1px solid #e8e4d8;">

            <div class="flex items-center gap-3 px-6 py-4" style="border-bottom: 1px solid #f0ece4;">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background-color: rgba(35,197,94,0.1);">
                    <svg class="w-5 h-5" style="color: #23c55e;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold" style="color: #051e34;">Sobre Você</h2>
                    <p class="text-xs" style="color: #87c2c0;">Uma breve apresentação.</p>
                </div>
            </div>

            <div class="p-6">
                <textarea wire:model="information" rows="4"
                    placeholder="Conte um pouco sobre você..."
                    class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                    style="border-color: #e8e4d8; color: #051e34;"
                    onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                    onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'"></textarea>
            </div>

        </div>

        {{-- ACTIONS --}}
        <div class="flex items-center justify-end gap-3 pt-2">

            <button type="button"
                class="px-5 py-2.5 rounded-xl text-sm font-bold transition"
                style="border: 1px solid #e8e4d8; background: white; color: #87c2c0;"
                onmouseover="this.style.color='#051e34'"
                onmouseout="this.style.color='#87c2c0'">
                Cancelar
            </button>

            <button type="submit"
                class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-sm font-extrabold transition"
                style="background-color: #23c55e; color: #051e34; box-shadow: 0 2px 0 #15803d;"
                onmouseover="this.style.backgroundColor='#1aad52'"
                onmouseout="this.style.backgroundColor='#23c55e'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                Salvar Alterações
            </button>

        </div>

    </form>

</div>