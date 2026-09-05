<?php

namespace Database\Seeders;

use App\Enums\DocumentTypeEnum;
use App\Models\OperatorDocument;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OperatorDocumentSeeder extends Seeder
{
    public function run(): void
    {
        $documents = [
            [
                'type'         => DocumentTypeEnum::CONTRATO_ADESAO,
                'title'        => 'Contrato de Adesão e Parceria do Operador',
                'description'  => 'Contrato que estabelece as condições de adesão e parceria entre o operador e a plataforma SuperPasseios.',
                'is_required'  => true,
                'sort_order'   => 1,
            ],
            [
                'type'         => DocumentTypeEnum::TERMO_RESPONSABILIDADE,
                'title'        => 'Termo de Responsabilidade do Operador',
                'description'  => 'Termo que define as responsabilidades do operador durante a prestação dos serviços de passeios náuticos.',
                'is_required'  => true,
                'sort_order'   => 2,
            ],
            [
                'type'         => DocumentTypeEnum::TERMOS_COMISSAO,
                'title'        => 'Termos de Comissão, Pagamento e Repasse',
                'description'  => 'Termos que detalham as comissões cobradas pela plataforma, formas de pagamento e repasses financeiros.',
                'is_required'  => true,
                'sort_order'   => 3,
            ],
            [
                'type'         => DocumentTypeEnum::POLITICA_PRIVACIDADE,
                'title'        => 'Política de Privacidade do Operador',
                'description'  => 'Política que descreve como os dados do operador são coletados, utilizados e protegidos.',
                'is_required'  => true,
                'sort_order'   => 4,
            ],
            [
                'type'         => DocumentTypeEnum::TERMO_SEGURANCA,
                'title'        => 'Termo de Segurança e Responsabilidade pela Operação',
                'description'  => 'Termo que estabelece as normas de segurança e responsabilidade operacional do prestador.',
                'is_required'  => true,
                'sort_order'   => 5,
            ],
            [
                'type'         => DocumentTypeEnum::TERMO_VERIFICACAO,
                'title'        => 'Termo de Verificação do Operador',
                'description'  => 'Termo que autoriza a realização de verificações e auditorias pela plataforma.',
                'is_required'  => false,
                'sort_order'   => 6,
            ],
            [
                'type'         => DocumentTypeEnum::POLITICA_CANCELAMENTO,
                'title'        => 'Política de Cancelamento e Reembolso',
                'description'  => 'Política que define as regras de cancelamento de reservas e condições de reembolso.',
                'is_required'  => true,
                'sort_order'   => 7,
            ],
            [
                'type'         => DocumentTypeEnum::TERMO_MARCA,
                'title'        => 'Termo de Uso da Marca Super Passeios',
                'description'  => 'Termo que regula o uso da marca e identidade visual da plataforma pelo operador.',
                'is_required'  => false,
                'sort_order'   => 8,
            ],
        ];

        foreach ($documents as $data) {
            /** @var DocumentTypeEnum $type */
            $type = $data['type'];
            $slug = Str::slug($type->value . '-1.0');

            OperatorDocument::updateOrCreate(
                ['type' => $type->value, 'version' => '1.0'],
                [
                    'title'        => $data['title'],
                    'slug'         => $slug,
                    'description'  => $data['description'],
                    'content'      => $this->getContentForType($type),
                    'is_required'  => $data['is_required'],
                    'is_active'    => false,
                    'sort_order'   => $data['sort_order'],
                ]
            );
        }
    }

    private function getContentForType(DocumentTypeEnum $type): string
    {
        return match ($type) {
            DocumentTypeEnum::CONTRATO_ADESAO => $this->placeholder(
                'Contrato de Adesão e Parceria do Operador',
                'Este contrato estabelece as condições gerais de adesão e parceria entre o operador de passeios náuticos e a plataforma SuperPasseios.

Ao assinar este contrato, o operador declara estar ciente e de acordo com todos os termos e condições aqui descritos.

> [CONTEÚDO DO CONTRATO DE ADESÃO - INSERIR TEXTO JURÍDICO DEFINITIVO]'
            ),
            DocumentTypeEnum::TERMO_RESPONSABILIDADE => $this->placeholder(
                'Termo de Responsabilidade do Operador',
                'O operador é responsável por todas as atividades realizadas durante os passeios náuticos oferecidos por meio da plataforma SuperPasseios.

O operador se compromete a manter equipamentos de segurança adequados e em bom estado de conservação.

> [CONTEÚDO DO TERMO DE RESPONSABILIDADE - INSERIR TEXTO JURÍDICO DEFINITIVO]'
            ),
            DocumentTypeEnum::TERMOS_COMISSAO => $this->placeholder(
                'Termos de Comissão, Pagamento e Repasse',
                'A plataforma SuperPasseios cobrará uma comissão sobre cada reserva confirmada, conforme percentual definido no momento da adesão.

Os repasses serão realizados conforme o prazo de liberação estabelecido nos termos.

> [CONTEÚDO DOS TERMOS DE COMISSÃO - INSERIR TEXTO JURÍDICO DEFINITIVO]'
            ),
            DocumentTypeEnum::POLITICA_PRIVACIDADE => $this->placeholder(
                'Política de Privacidade do Operador',
                'A SuperPasseios valoriza a privacidade dos seus operadores e se compromete a proteger os dados pessoais coletados.

Os dados serão utilizados exclusivamente para fins de prestação dos serviços da plataforma.

> [CONTEÚDO DA POLÍTICA DE PRIVACIDADE - INSERIR TEXTO JURÍDICO DEFINITIVO]'
            ),
            DocumentTypeEnum::TERMO_SEGURANCA => $this->placeholder(
                'Termo de Segurança e Responsabilidade pela Operação',
                'O operador deve cumprir todas as normas de segurança aplicáveis à operação de passeios náuticos.

É obrigatório o uso de coletes salva-vidas e equipamentos de segurança homologados.

> [CONTEÚDO DO TERMO DE SEGURANÇA - INSERIR TEXTO JURÍDICO DEFINITIVO]'
            ),
            DocumentTypeEnum::TERMO_VERIFICACAO => $this->placeholder(
                'Termo de Verificação do Operador',
                'O operador autoriza a SuperPasseios a realizar verificações e auditorias periodicamente, incluindo documentação, equipamentos e condições operacionais.

> [CONTEÚDO DO TERMO DE VERIFICAÇÃO - INSERIR TEXTO JURÍDICO DEFINITIVO]'
            ),
            DocumentTypeEnum::POLITICA_CANCELAMENTO => $this->placeholder(
                'Política de Cancelamento e Reembolso',
                'As regras de cancelamento e reembolso seguem as diretrizes estabelecidas pela plataforma em conformidade com o Código de Defesa do Consumidor.

> [CONTEÚDO DA POLÍTICA DE CANCELAMENTO - INSERIR TEXTO JURÍDICO DEFINITIVO]'
            ),
            DocumentTypeEnum::TERMO_MARCA => $this->placeholder(
                'Termo de Uso da Marca Super Passeios',
                'O operador autoriza a utilizar a marca Super Passeios exclusivamente para divulgação dos passeios listados na plataforma.

Qualquer uso inadequado da marca poderá resultado na rescisão do contrato.

> [CONTEÚDO DO TERMO DE USO DA MARCA - INSERIR TEXTO JURÍDICO DEFINITIVO]'
            ),
        };
    }

    private function placeholder(string $title, string $content): string
    {
        return <<<MD
        ## {$title}

        **Versão:** 1.0
        **Data de Vigência:** {$this->formatDate()}

        ---

        {$content}
        MD;
    }

    private function formatDate(): string
    {
        return now()->format('d/m/Y');
    }
}
