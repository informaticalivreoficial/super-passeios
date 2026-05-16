<style>
    body { background: #EEF4FB !important; }

    .checkout-wrap {
        min-height: 100vh;
        background: #EEF4FB;
        font-family: 'Plus Jakarta Sans', sans-serif;
        padding: 40px 16px 80px;
    }

    /* Stepper */
    .stepper { display: flex; align-items: flex-start; justify-content: center; gap: 0; margin-bottom: 36px; }
    .step-item { display: flex; flex-direction: column; align-items: center; position: relative; }
    .step-item:not(:last-child) { padding-right: 80px; }
    .step-item:not(:last-child)::after {
        content: '';
        position: absolute;
        top: 24px;
        left: calc(50% + 24px);
        width: 80px;
        height: 2px;
        background: #D8E6F5;
    }
    .step-icon {
        width: 48px; height: 48px; border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 8px; transition: all 0.2s;
    }
    .step-icon.active   { background: #2563EB; box-shadow: 0 8px 20px rgba(37,99,235,0.30); }
    .step-icon.inactive { background: #fff; border: 1.5px solid #D8E6F5; }
    .step-icon svg { width: 22px; height: 22px; }
    .step-icon.active svg   { color: #fff; }
    .step-icon.inactive svg { color: #94a3b8; }
    .step-label { font-size: 12px; font-weight: 600; }
    .step-label.active   { color: #2563EB; }
    .step-label.inactive { color: #94a3b8; }

    /* Tour summary */
    .tour-summary {
        display: flex; align-items: center; gap: 14px;
        padding: 18px 24px;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(30,64,175,0.06);
        max-width: 600px;
        margin: 0 auto 20px;
    }
    .tour-thumb {
        width: 56px; height: 56px; border-radius: 12px;
        object-fit: cover; flex-shrink: 0;
    }
    .tour-info { flex: 1; min-width: 0; }
    .tour-title { font-size: 15px; font-weight: 700; color: #0f172a; margin-bottom: 4px; }
    .tour-meta  { display: flex; gap: 12px; font-size: 13px; color: #64748b; flex-wrap: wrap; }
    .tour-meta span { display: flex; align-items: center; gap: 4px; }
    .tour-price .amount { font-size: 20px; font-weight: 800; color: #2563EB; white-space: nowrap; }
    .tour-price .label  { font-size: 12px; color: #94a3b8; text-align: right; }

    /* Card */
    .ck-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 4px 24px rgba(30,64,175,0.07);
        max-width: 600px;
        margin: 0 auto;
        padding: 28px 24px;
    }
    .section-title { font-size: 20px; font-weight: 800; color: #0f172a; margin-bottom: 20px; }

    /* Quantity row */
    .qty-row {
        display: flex; align-items: center; justify-content: space-between;
        padding: 18px 20px; border-radius: 14px;
        border: 1.5px solid #EEF4FB;
        margin-bottom: 12px;
        transition: border-color 0.15s;
    }
    .qty-row:hover { border-color: #BFDBFE; }
    .qty-row.children-row { border-color: #FED7AA; background: #FFFBF7; }
    .qty-row.children-row:hover { border-color: #FDBA74; }
    .qty-label { font-size: 15px; font-weight: 700; color: #0f172a; display: flex; align-items: center; }
    .qty-label svg { width: 18px; height: 18px; margin-right: 8px; flex-shrink: 0; }
    .qty-sub   { font-size: 13px; color: #64748b; margin-top: 3px; }
    .qty-badge { font-size: 11px; font-weight: 600; padding: 2px 8px; border-radius: 20px; margin-left: 8px; background: #FED7AA; color: #C2410C; }

    .qty-controls { display: flex; align-items: center; gap: 14px; flex-shrink: 0; }
    .qty-btn {
        width: 36px; height: 36px; border-radius: 10px;
        border: 1.5px solid #E2E8F0; background: #fff;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; font-size: 20px; color: #475569; line-height: 1;
        transition: all 0.15s;
    }
    .qty-btn:hover { border-color: #2563EB; color: #2563EB; }
    .qty-btn.plus        { background: #2563EB; border-color: #2563EB; color: #fff; }
    .qty-btn.plus:hover  { background: #1d4ed8; }
    .qty-btn.plus-orange { background: #F97316; border-color: #F97316; color: #fff; }
    .qty-btn.plus-orange:hover { background: #EA580C; }
    .qty-count { font-size: 18px; font-weight: 700; color: #0f172a; min-width: 24px; text-align: center; }

    /* Slots */
    .slots-info {
        display: flex; align-items: center; justify-content: center;
        padding: 12px; border-radius: 12px;
        background: #F0FDF4; border: 1px solid #BBF7D0;
        font-size: 13px; font-weight: 600; color: #16A34A;
        margin-bottom: 16px; gap: 6px;
    }

    /* Inputs */
    .ck-input-group { margin-bottom: 16px; }
    .ck-label { font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px; display: block; }
    .ck-input {
        width: 100%; padding: 13px 16px; border-radius: 12px;
        border: 1.5px solid #E5E7EB; font-size: 14px; color: #0f172a;
        outline: none; transition: border-color 0.15s, box-shadow 0.15s;
        font-family: 'Plus Jakarta Sans', sans-serif; background: #fff;
        box-sizing: border-box;
    }
    .ck-input:focus { border-color: #2563EB; box-shadow: 0 0 0 3px rgba(37,99,235,0.08); }
    .ck-input::placeholder { color: #9CA3AF; }
    .ck-error { font-size: 12px; color: #DC2626; margin-top: 4px; }

    /* Payment methods */
    .pay-methods { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 20px; }
    .pay-method {
        padding: 16px; border-radius: 14px; border: 2px solid #E5E7EB;
        cursor: pointer; transition: all 0.15s; text-align: center; background: #fff;
    }
    .pay-method.selected { border-color: #2563EB; background: #EFF6FF; }
    .pay-method-icon { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px; }
    .pay-method-icon.pix  { background: #ECFDF5; }
    .pay-method-icon.card { background: #EFF6FF; }
    .pay-method-label { font-size: 14px; font-weight: 700; color: #0f172a; }
    .pay-method-sub   { font-size: 12px; color: #64748b; margin-top: 2px; }

    /* Buttons */
    .ck-btn {
        width: 100%; padding: 16px; border-radius: 14px;
        background: linear-gradient(135deg, #2563EB, #1d4ed8);
        color: #fff; font-size: 16px; font-weight: 700;
        border: none; cursor: pointer;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        box-shadow: 0 4px 16px rgba(37,99,235,0.30);
        transition: all 0.15s;
    }
    .ck-btn:hover { background: linear-gradient(135deg, #1d4ed8, #1e40af); box-shadow: 0 6px 20px rgba(37,99,235,0.40); transform: translateY(-1px); }
    .ck-btn:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }
    .ck-btn-ghost {
        padding: 13px; border-radius: 12px; border: 1.5px solid #E5E7EB;
        background: #fff; color: #475569; font-size: 14px; font-weight: 600;
        cursor: pointer; font-family: 'Plus Jakarta Sans', sans-serif; transition: all 0.15s;
        width: 100%;
    }
    .ck-btn-ghost:hover { border-color: #2563EB; color: #2563EB; }

    /* PIX */
    .pix-screen { text-align: center; }
    .pix-copy {
        display: flex; gap: 8px; align-items: center;
        padding: 12px 16px; border-radius: 12px;
        background: #F8FAFC; border: 1.5px solid #E2E8F0; margin-bottom: 16px;
    }
    .pix-code { flex: 1; font-size: 11px; color: #475569; word-break: break-all; text-align: left; }
    .pix-copy-btn {
        flex-shrink: 0; padding: 8px 14px; border-radius: 8px;
        background: #2563EB; color: #fff; font-size: 12px; font-weight: 600;
        border: none; cursor: pointer; font-family: 'Plus Jakarta Sans', sans-serif; white-space: nowrap;
    }

    .error-box { padding: 12px 16px; border-radius: 12px; background: #FEF2F2; border: 1px solid #FECACA; color: #DC2626; font-size: 13px; margin-bottom: 16px; }

    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
</style>

<div class="checkout-wrap">

    {{-- STEPPER --}}
    <div class="stepper">
        <div class="step-item">
            <div class="step-icon {{ $step >= 1 ? 'active' : 'inactive' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
            </div>
            <span class="step-label {{ $step >= 1 ? 'active' : 'inactive' }}">Resumo</span>
        </div>
        <div class="step-item">
            <div class="step-icon {{ $step >= 2 ? 'active' : 'inactive' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
            <span class="step-label {{ $step >= 2 ? 'active' : 'inactive' }}">Seus dados</span>
        </div>
        <div class="step-item">
            <div class="step-icon {{ $step >= 3 ? 'active' : 'inactive' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2"/><path d="M1 10h22"/></svg>
            </div>
            <span class="step-label {{ $step >= 3 ? 'active' : 'inactive' }}">Pagamento</span>
        </div>
    </div>

    {{-- TOUR SUMMARY --}}
    <div class="tour-summary">
        @if($tourDate->tour->images->first())
            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($tourDate->tour->images->first()->path) }}" class="tour-thumb" alt="{{ $tourDate->tour->title }}">
        @else
            <div class="tour-thumb" style="background:#EEF4FB;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg style="width:24px;height:24px;color:#94a3b8;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            </div>
        @endif
        <div class="tour-info">
            <div class="tour-title">{{ $tourDate->tour->title }}</div>
            <div class="tour-meta">
                <span>
                    <svg style="width:13px;height:13px;color:#2563EB;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                    {{ $tourDate->date->translatedFormat('d \d\e F \d\e Y') }}
                </span>
                <span>
                    <svg style="width:13px;height:13px;color:#2563EB;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                    {{ $tourDate->start_time }}
                </span>
            </div>
        </div>
        <div class="tour-price">
            <div class="amount">R$ {{ number_format($total, 2, ',', '.') }}</div>
            <div class="label">total</div>
        </div>
    </div>

    {{-- PASSO 1: QUANTIDADES --}}
    @if($step === 1)
        <div class="ck-card">
            <div class="section-title">Quantas pessoas?</div>

            <div class="qty-row">
                <div>
                    <div class="qty-label">
                        <svg fill="none" stroke="currentColor" stroke-width="2" style="color:#2563EB;" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                        Adultos
                    </div>
                    <div class="qty-sub">R$ {{ number_format($tourDate->price, 2, ',', '.') }} por pessoa</div>
                </div>
                <div class="qty-controls">
                    <button class="qty-btn" wire:click="$set('adults', {{ max(1, $adults - 1) }})">−</button>
                    <span class="qty-count">{{ $adults }}</span>
                    <button class="qty-btn plus" wire:click="$set('adults', {{ $adults + 1 }})">+</button>
                </div>
            </div>

            @error('adults') <div class="ck-error" style="margin-top:-8px;margin-bottom:12px;">{{ $message }}</div> @enderror

            @if($tourDate->half_price)
                <div class="qty-row children-row">
                    <div>
                        <div class="qty-label">
                            <svg fill="none" stroke="currentColor" stroke-width="2" style="color:#F97316;" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                            Crianças
                            <span class="qty-badge">meia entrada</span>
                        </div>
                        <div class="qty-sub">R$ {{ number_format($tourDate->half_price, 2, ',', '.') }} por criança</div>
                    </div>
                    <div class="qty-controls">
                        <button class="qty-btn" wire:click="$set('children', {{ max(0, $children - 1) }})">−</button>
                        <span class="qty-count">{{ $children }}</span>
                        <button class="qty-btn plus-orange" wire:click="$set('children', {{ $children + 1 }})">+</button>
                    </div>
                </div>
            @endif

            <div class="slots-info">
                <svg style="width:15px;height:15px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
                {{ $tourDate->available_slots }} vagas disponíveis nesta data
            </div>

            <button class="ck-btn" wire:click="nextStep">
                Continuar
                <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </button>
        </div>
    @endif

    {{-- PASSO 2: DADOS DO CLIENTE --}}
    @if($step === 2)
        <div class="ck-card">
            <div class="section-title">Seus dados</div>

            <div class="ck-input-group">
                <label class="ck-label">Nome completo</label>
                <input wire:model="name" type="text" class="ck-input" placeholder="Como está no documento">
                @error('name') <div class="ck-error">{{ $message }}</div> @enderror
            </div>
            <div class="ck-input-group">
                <label class="ck-label">E-mail</label>
                <input wire:model="email" type="email" class="ck-input" placeholder="seu@email.com">
                @error('email') <div class="ck-error">{{ $message }}</div> @enderror
                <div style="font-size:12px;color:#94a3b8;margin-top:4px;">Você receberá a confirmação neste e-mail</div>
            </div>
            <div class="ck-input-group">
                <label class="ck-label">Telefone / WhatsApp</label>
                <input wire:model="phone" type="tel" class="ck-input" placeholder="(00) 00000-0000">
                @error('phone') <div class="ck-error">{{ $message }}</div> @enderror
            </div>
            <div class="ck-input-group">
                <label class="ck-label">CPF</label>
                <input wire:model="cpf" type="text" class="ck-input" placeholder="000.000.000-00">
                @error('cpf') <div class="ck-error">{{ $message }}</div> @enderror
            </div>

            <div style="display:flex;gap:12px;margin-top:8px;">
                <button class="ck-btn-ghost" wire:click="prevStep" style="flex:1;">← Voltar</button>
                <button class="ck-btn" wire:click="nextStep" style="flex:2;">
                    Continuar para pagamento
                    <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>
    @endif

    {{-- PASSO 3: PAGAMENTO --}}
    @if($step === 3)
        <div class="ck-card">
            <div class="section-title">Forma de pagamento</div>

            <div class="pay-methods">
                <button class="pay-method {{ $paymentMethod === 'pix' ? 'selected' : '' }}" wire:click="$set('paymentMethod','pix')">
                    <div class="pay-method-icon pix">
                        <svg style="width:20px;height:20px;color:#16A34A;" viewBox="0 0 512 512" fill="currentColor"><path d="M242.4 292.5C247.8 287.1 257.1 287.1 262.5 292.5L339.5 369.5C357.6 387.6 387.4 387.6 405.5 369.5L412.5 362.5L331.5 281.5C313.4 263.4 313.4 233.6 331.5 215.5L412.5 134.5L405.5 127.5C387.4 109.4 357.6 109.4 339.5 127.5L262.5 204.5C257.1 209.9 247.8 209.9 242.4 204.5L165.5 127.5C147.4 109.4 117.6 109.4 99.5 127.5L92.5 134.5L173.5 215.5C191.6 233.6 191.6 263.4 173.5 281.5L92.5 362.5L99.5 369.5C117.6 387.6 147.4 387.6 165.5 369.5L242.4 292.5zM51.5 315.5L21.1 285.1C-7.033 256.1-7.033 209.1 21.1 180.1L51.5 149.5L132.5 230.5C140.8 238.8 140.8 252.2 132.5 260.5L51.5 315.5zM460.5 149.5L490.9 179.9C519 208 519 255 490.9 283.1L460.5 313.5L379.5 232.5C371.2 224.2 371.2 210.8 379.5 202.5L460.5 149.5z"/></svg>
                    </div>
                    <div class="pay-method-label">PIX</div>
                    <div class="pay-method-sub">Aprovação imediata</div>
                </button>
                <button class="pay-method {{ $paymentMethod === 'card' ? 'selected' : '' }}" wire:click="$set('paymentMethod','card')">
                    <div class="pay-method-icon card">
                        <svg style="width:20px;height:20px;color:#2563EB;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2"/><path d="M1 10h22"/></svg>
                    </div>
                    <div class="pay-method-label">Cartão</div>
                    <div class="pay-method-sub">Crédito ou débito</div>
                </button>
            </div>

            @if($paymentMethod === 'pix')
                <div style="padding:14px 16px;border-radius:12px;background:#F0FDF4;border:1px solid #BBF7D0;font-size:13px;color:#166534;margin-bottom:20px;">
                    Após confirmar, você receberá o <strong>QR Code PIX</strong>. O código expira em <strong>30 minutos</strong>.
                </div>
            @endif

            @if($paymentMethod === 'card')
                <div id="mp-card-form" style="margin-bottom:20px;">
                    <div id="cardNumber" style="margin-bottom:12px;"></div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
                        <div id="expirationDate"></div>
                        <div id="securityCode"></div>
                    </div>
                    <div id="cardholderName" style="margin-bottom:12px;"></div>
                    <div id="issuer" style="margin-bottom:12px;"></div>
                    <div id="installments"></div>
                </div>
            @endif

            @if($errorMsg)
                <div class="error-box">{{ $errorMsg }}</div>
            @endif

            <div style="display:flex;justify-content:space-between;align-items:center;padding:16px;border-radius:12px;background:#F8FAFC;margin-bottom:20px;">
                <span style="font-size:14px;color:#64748b;">Total a pagar</span>
                <span style="font-size:22px;font-weight:800;color:#2563EB;">R$ {{ number_format($total, 2, ',', '.') }}</span>
            </div>

            <div style="display:flex;gap:12px;">
                <button class="ck-btn-ghost" wire:click="prevStep" style="flex:1;">← Voltar</button>
                <button class="ck-btn" wire:click="pay" wire:loading.attr="disabled" style="flex:2;">
                    <span wire:loading.remove wire:target="pay">
                        {{ $paymentMethod === 'pix' ? 'Gerar QR Code PIX' : 'Pagar agora' }}
                        <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </span>
                    <span wire:loading wire:target="pay">Processando...</span>
                </button>
            </div>
        </div>
    @endif

    {{-- PASSO 4: PIX QR CODE --}}
    @if($step === 4 && $pixData)
        <div class="ck-card">
            <div class="pix-screen">
                <div style="width:56px;height:56px;border-radius:16px;background:#F0FDF4;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                    <svg style="width:28px;height:28px;color:#16A34A;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                </div>
                <div style="font-size:22px;font-weight:800;color:#0f172a;margin-bottom:6px;">Quase lá!</div>
                <div style="font-size:14px;color:#64748b;margin-bottom:24px;">Escaneie o QR Code ou copie o código PIX abaixo</div>

                @if($pixData['qr_code_base64'])
                    <img src="data:image/png;base64,{{ $pixData['qr_code_base64'] }}" style="width:200px;height:200px;border-radius:16px;margin:0 auto 20px;display:block;" alt="QR Code PIX">
                @endif

                <div class="pix-copy">
                    <code class="pix-code">{{ $pixData['qr_code'] }}</code>
                    <button class="pix-copy-btn" onclick="navigator.clipboard.writeText('{{ $pixData['qr_code'] }}').then(() => { this.textContent = '✓ Copiado'; setTimeout(() => this.textContent = 'Copiar', 2000); })">Copiar</button>
                </div>

                <div style="font-size:12px;color:#94a3b8;line-height:1.8;">
                    ⏱ O código expira em <strong>30 minutos</strong>.<br>
                    Após o pagamento, você receberá a confirmação por e-mail.
                </div>
            </div>
        </div>
    @endif

</div>

@push('scripts')
@if($step === 3 && $paymentMethod === 'card')
<script src="https://sdk.mercadopago.com/js/v2"></script>
<script>
    const mp = new MercadoPago('{{ config("services.mercadopago.public_key") }}', { locale: 'pt-BR' });
    const cardForm = mp.cardForm({
        amount: "{{ $total }}",
        iframe: true,
        form: {
            id: "mp-card-form",
            cardNumber:     { id: "cardNumber",     placeholder: "Número do cartão" },
            expirationDate: { id: "expirationDate", placeholder: "MM/AA" },
            securityCode:   { id: "securityCode",   placeholder: "CVV" },
            cardholderName: { id: "cardholderName", placeholder: "Nome no cartão" },
            issuer:         { id: "issuer",         placeholder: "Banco emissor" },
            installments:   { id: "installments",   placeholder: "Parcelas" },
        },
        callbacks: {
            onFormMounted: error => { if (error) console.warn('Form error:', error); },
            onSubmit: async (event) => {
                event.preventDefault();
                const { paymentMethodId, token, installments } = cardForm.getCardFormData();
                @this.set('cardToken', token);
                @this.set('paymentMethodId', paymentMethodId);
                @this.set('installments', installments);
                @this.call('pay');
            },
        },
    });
</script>
@endif
@endpush