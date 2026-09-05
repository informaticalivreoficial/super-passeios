<?php

namespace App\Enums;

enum DocumentTypeEnum: string
{
    case CONTRATO_ADESAO = 'contrato_adesao';
    case TERMO_RESPONSABILIDADE = 'termo_responsabilidade';
    case TERMOS_COMISSAO = 'termos_comissao';
    case POLITICA_PRIVACIDADE = 'politica_privacidade';
    case TERMO_SEGURANCA = 'termo_seguranca';
    case TERMO_VERIFICACAO = 'termo_verificacao';
    case POLITICA_CANCELAMENTO = 'politica_cancelamento';
    case TERMO_MARCA = 'termo_marca';

    public function label(): string
    {
        return match ($this) {
            self::CONTRATO_ADESAO => 'Contrato de Adesão e Parceria do Operador',
            self::TERMO_RESPONSABILIDADE => 'Termo de Responsabilidade do Operador',
            self::TERMOS_COMISSAO => 'Termos de Comissão, Pagamento e Repasse',
            self::POLITICA_PRIVACIDADE => 'Política de Privacidade do Operador',
            self::TERMO_SEGURANCA => 'Termo de Segurança e Responsabilidade pela Operação',
            self::TERMO_VERIFICACAO => 'Termo de Verificação do Operador',
            self::POLITICA_CANCELAMENTO => 'Política de Cancelamento e Reembolso',
            self::TERMO_MARCA => 'Termo de Uso da Marca Super Passeios',
        };
    }

    public function slug(): string
    {
        return match ($this) {
            self::CONTRATO_ADESAO => 'contrato-de-adesao',
            self::TERMO_RESPONSABILIDADE => 'termo-de-responsabilidade',
            self::TERMOS_COMISSAO => 'termos-de-comissao',
            self::POLITICA_PRIVACIDADE => 'politica-de-privacidade',
            self::TERMO_SEGURANCA => 'termo-de-seguranca',
            self::TERMO_VERIFICACAO => 'termo-de-verificacao',
            self::POLITICA_CANCELAMENTO => 'politica-de-cancelamento',
            self::TERMO_MARCA => 'termo-de-uso-da-marca',
        };
    }

    public static function options(): array
    {
        return array_map(fn($case) => $case->label(), self::cases());
    }
}
