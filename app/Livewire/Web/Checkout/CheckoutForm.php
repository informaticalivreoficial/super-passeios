<?php

namespace App\Livewire\Web\Checkout;

use App\Enums\BookingStatusEnum;
use App\Enums\PaymentStatusEnum;
use App\Mail\BookingConfirmed;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\TourDate;
use App\Services\MercadoPagoService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;

class CheckoutForm extends Component
{
     // ─── Navegação ───────────────────────────
    public int $step = 1;
 
    // ─── Data do passeio ─────────────────────
    public TourDate $tourDate;
 
    // ─── Passo 1: quantidades ─────────────────
    public int $adults   = 1;
    public int $children = 0;
 
    // ─── Passo 2: dados do cliente ────────────
    public string $name  = '';
    public string $email = '';
    public string $phone = '';
    public string $cpf   = '';
 
    // ─── Passo 3: pagamento ───────────────────
    public string $paymentMethod = 'pix'; // 'pix' | 'card'
    public string $cardToken     = '';
    public string $paymentMethodId = '';
    public int    $installments  = 1;
 
    // ─── Resultado ───────────────────────────
    public ?array  $pixData   = null;
    public ?string $errorMsg  = null;
    public bool    $processing = false;
 
    // ─── Computed ────────────────────────────
    public float $subtotal        = 0;
    public float $commissionAmount = 0;
    public float $companyAmount   = 0;
    public float $total           = 0;
 
    public function mount(TourDate $tourDate): void
    {
        abort_if(
            !$tourDate->active ||
            $tourDate->status->value !== 'OPEN' ||
            $tourDate->date->isPast(),
            404
        );
 
        $this->tourDate = $tourDate;
        $this->recalculate();
    }
 
    // ─────────────────────────────────────────
    // CÁLCULO DE VALORES
    // ─────────────────────────────────────────
    public function recalculate(): void
    {
        $priceAdult    = (float) $this->tourDate->price;
        $priceChildren = (float) ($this->tourDate->half_price ?? $priceAdult / 2);
 
        $this->subtotal = ($this->adults * $priceAdult) + ($this->children * $priceChildren);
 
        //$commissionPct        = (float) env('SAAS_COMMISSION', 10);
        $commissionPct = $this->tourDate->tour->company->commission_rate;
        //$this->commissionAmount = round($this->subtotal * ($commissionPct / 100), 2);
        $this->commissionAmount = round($this->subtotal * ($commissionPct / 100), 2);
        $this->companyAmount = $this->subtotal - $this->commissionAmount;
        //$this->companyAmount  = round($this->subtotal - $this->commissionAmount, 2);
        $this->total          = $this->subtotal;

        if ($this->step === 3 && $this->paymentMethod === 'card') {
            //$this->dispatch('mercadopago:init', total: $this->total);
        }
    }
 
    public function updatedAdults(): void   { $this->recalculate(); }
    public function updatedChildren(): void { $this->recalculate(); }
 
    // ─────────────────────────────────────────
    // VALIDAÇÕES POR PASSO
    // ─────────────────────────────────────────
    protected function validateStep1(): void
    {
        $maxSlots = $this->tourDate->available_slots;
 
        $this->validate([
            'adults'   => ['required', 'integer', 'min:1'],
            'children' => ['required', 'integer', 'min:0'],
        ], [
            'adults.min'   => 'É necessário pelo menos 1 adulto.',
            'children.min' => 'Número de crianças inválido.',
        ]);
 
        if (($this->adults + $this->children) > $maxSlots) {
            $this->addError('adults', "Apenas {$maxSlots} vagas disponíveis para esta data.");
            return;
        }
    }
 
    protected function validateStep2(): void
    {
        $this->validate([
            'name'  => ['required', 'string', 'min:3', 'max:100'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'string', 'min:10', 'max:20'],
            'cpf'   => ['required', 'cpf',  'string', 'min:11', 'max:14'],
        ], [
            'name.required'  => 'Informe seu nome completo.',
            'email.required' => 'Informe seu e-mail.',
            'email.email'    => 'E-mail inválido.',
            'phone.required' => 'Informe seu telefone.',
            'cpf.required'   => 'Informe seu CPF.',
        ]);
    }
 
    // ─────────────────────────────────────────
    // NAVEGAÇÃO
    // ─────────────────────────────────────────
    public function nextStep(): void
    {
        if ($this->step === 1) {
            $this->validateStep1();
            if ($this->getErrorBag()->isNotEmpty()) return;
        }
 
        if ($this->step === 2) {
            $this->validateStep2();
            if ($this->getErrorBag()->isNotEmpty()) return;
        }
 
        $this->step++;

        if ($this->step === 3) {
            //$this->dispatch('mercadopago:init', total: $this->total);
        }
    }
 
    public function prevStep(): void
    {
        if ($this->step > 1) $this->step--;
    }
 
    // ─────────────────────────────────────────
    // FINALIZAR COMPRA
    // ─────────────────────────────────────────
    public function pay(MercadoPagoService $mp, $data = null): void
    {
        // Se os dados vierem do JS, preenchemos as propriedades do componente
        if ($data) {
            $this->cardToken = $data['cardToken'] ?? $this->cardToken;
            $this->paymentMethodId = $data['paymentMethodId'] ?? $this->paymentMethodId;
            $this->installments = $data['installments'] ?? $this->installments;
        }

        $this->validateStep2();
        if ($this->getErrorBag()->isNotEmpty()) return;
 
        $this->processing = true;
        $this->errorMsg   = null;
 
        try {
            // 1. Cria ou recupera o customer
            $customer = Customer::firstOrCreate(
                ['email' => $this->email],
                [
                    'name'     => $this->name,
                    'phone'    => preg_replace('/\D/', '', $this->phone),
                    'cpf'      => preg_replace('/\D/', '', $this->cpf),
                    'password' => \Illuminate\Support\Facades\Hash::make(\Illuminate\Support\Str::random(16)),
                ]
            );

            if (!$customer->wasRecentlyCreated === false && !$customer->hasRole('client')) {
                $customer->assignRole('client');
            }

            if (blank($customer->cpf)) {
                $customer->update(['cpf' => preg_replace('/\D/', '', $this->cpf)]);
            }
 
            // 2. Cria o booking com status pendente
            $booking = Booking::create([
                'uuid'              => (string) Str::uuid(),
                'tour_id'           => $this->tourDate->tour_id,
                'company_id'        => $this->tourDate->tour->company_id,
                'customer_id'       => $customer->id,
                'tour_date_id'      => $this->tourDate->id,
                'customer_name'     => $this->name,
                'customer_email'    => $this->email,
                'customer_phone'    => preg_replace('/\D/', '', $this->phone),
                'adults'            => $this->adults,
                'children'          => $this->children,
                'payment_method'    => $this->paymentMethod,
                'subtotal'          => $this->subtotal,
                'commission_amount' => $this->commissionAmount,
                'company_amount'    => $this->companyAmount,
                'total'             => $this->total,
                'status'            => BookingStatusEnum::PENDING,
                'payment_status'    => PaymentStatusEnum::PENDING,
                'expires_at'        => now()->addMinutes(30),
            ]);
 
            // 3. Processa o pagamento
            $nameParts = explode(' ', trim($this->name), 2);
            $paymentData = [
                'amount'      => $this->total,
                'description' => "Passeio: {$this->tourDate->tour->title}",
                'email'       => $this->email,
                'first_name'  => $nameParts[0],
                'last_name'   => $nameParts[1] ?? '',
                'cpf'         => $this->cpf,
                'booking_uuid'=> $booking->uuid,
            ];
 
            if ($this->paymentMethod === 'pix') {
                $response = $mp->createPixPayment($paymentData);
            } else {
                $response = $mp->createCardPayment(array_merge($paymentData, [
                    'card_token'        => $this->cardToken,
                    'payment_method_id' => $this->paymentMethodId,
                    'installments'      => $this->installments,
                ]));
            }
 
            if (!isset($response['id'])) {
                throw new \Exception(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            }
 
            $booking->update([
                'payment_id' => $response['id'],                
            ]);
 
            // 5. PIX: exibe QR code
            if ($this->paymentMethod === 'pix') {
                $this->pixData = [
                    'payment_id'   => $response['id'],
                    'booking_uuid' => $booking->uuid,
                    'qr_code'        => $response['point_of_interaction']['transaction_data']['qr_code'] ?? null,
                    'qr_code_base64' => $response['point_of_interaction']['transaction_data']['qr_code_base64'] ?? null,
                ];
                $this->step = 4; // tela de aguardando pagamento
            }
 
            // 6. Cartão aprovado imediatamente
            if ($this->paymentMethod === 'card' && ($response['status'] ?? '') === 'approved') {
                app(\App\Services\Booking\BookingPaidService::class)
                    ->handle($booking->fresh());

                $this->dispatch('mercadopago:destroy');

                $this->step = 5;

                return;
            } 
        } catch (\Exception $e) {
             Log::error('Checkout Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            $this->errorMsg = $e->getMessage();
        } finally {
            $this->processing = false;
        }
    }
 
    // ─────────────────────────────────────────
    // CONFIRMAR BOOKING (chamado pelo webhook também)
    // ─────────────────────────────────────────
    // public static function confirmBooking(Booking $booking): void
    // {
    //     $booking->update([
    //         'status'         => BookingStatusEnum::CONFIRMED,
    //         'payment_status' => PaymentStatusEnum::PAID,
    //         'paid_at'        => now(),
    //     ]);
 
    //     // Decrementa vagas da data
    //     $booking->tourDate->decrement('available_slots', $booking->adults + $booking->children);
 
    //     // Verifica se lotou
    //     if ($booking->tourDate->available_slots <= 0) {
    //         $booking->tourDate->update(['status' => \App\Enums\TourDateStatusEnum::FULL]);
    //     }
    // }

    public function checkPixStatus(MercadoPagoService $mp): void
    {
        if (!$this->pixData || empty($this->pixData['booking_uuid'])) {
            return;
        }

        $booking = Booking::where('uuid', $this->pixData['booking_uuid'])->first();

        if (
            $booking &&
            $booking->payment_status === PaymentStatusEnum::PAID
        ) {
            $this->step = 5;
        }
    }

    public function updatedPaymentMethod()
    {
        if ($this->paymentMethod === 'card') {
            //$this->dispatch('mercadopago:init', total: $this->total);
        } else {
            $this->dispatch('mercadopago:destroy');
        }
    }

    #[Layout('web.client.create', ['title' => 'Checkout'])]
    public function render()
    {
        return view('livewire.web.checkout.checkout-form');
    }
}
