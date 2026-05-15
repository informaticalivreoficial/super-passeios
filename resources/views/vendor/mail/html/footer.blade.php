<tr>
    <td
        align="center"
        style="
            padding: 32px 40px;
            background: linear-gradient(135deg, #051e34 0%, #0a3358 100%);
            border-top: 4px solid #16a3b7;
        "
    >

        {{-- Brand --}}
        <p style="
            margin: 0 0 4px;
            font-size: 16px;
            font-weight: 800;
            color: #fadd37;
            font-family: Arial, sans-serif;
            letter-spacing: -0.3px;
        ">
            {{ config('app.name') }}
        </p>

        <p style="
            margin: 0 0 20px;
            font-size: 11px;
            color: rgba(255,255,255,0.4);
            font-family: Arial, sans-serif;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        ">
            Marketplace náutico
        </p>

        {{-- Divider --}}
        <div style="
            width: 40px;
            height: 2px;
            background: linear-gradient(90deg, #16a3b7, #fadd37);
            margin: 0 auto 20px;
        "></div>

        {{-- Aviso --}}
        <p style="
            margin: 0 0 20px;
            font-size: 12px;
            line-height: 1.7;
            color: rgba(255,255,255,0.45);
            font-family: Arial, sans-serif;
            max-width: 400px;
        ">
            Você está recebendo este email pois possui uma conta em nossa plataforma.<br>
            Se não reconhece este email, pode ignorá-lo com segurança.
        </p>

        {{-- Copyright --}}
        <p style="
            margin: 0;
            font-size: 11px;
            color: rgba(255,255,255,0.25);
            font-family: Arial, sans-serif;
        ">
            © {{ date('Y') }} {{ config('app.name') }} — Todos os direitos reservados.
        </p>

    </td>
</tr>