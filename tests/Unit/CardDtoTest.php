<?php

declare(strict_types=1);

namespace Anisotton\Pagarme\Tests\Unit;

use Anisotton\Pagarme\DataTransferObjects\CardDto;
use PHPUnit\Framework\TestCase;

class CardDtoTest extends TestCase
{
    public function test_credit_card_dto_creation(): void
    {
        $cardDto = CardDto::creditCard(
            number: '4000000000000010',
            holderName: 'João Silva',
            expMonth: 12,
            expYear: 2025,
            cvv: '123',
            holderDocument: '12345678901',
            billingAddress: [
                'line_1' => 'Rua das Flores, 123',
                'zip_code' => '01310-100',
                'city' => 'São Paulo',
                'state' => 'SP',
                'country' => 'BR',
            ],
            metadata: ['test' => 'value']
        );

        $this->assertEquals('4000000000000010', $cardDto->number);
        $this->assertEquals('João Silva', $cardDto->holder_name);
        $this->assertEquals(12, $cardDto->exp_month);
        $this->assertEquals(2025, $cardDto->exp_year);
        $this->assertEquals('123', $cardDto->cvv);
        $this->assertEquals('12345678901', $cardDto->holder_document);
        $this->assertIsArray($cardDto->billing_address);
        $this->assertIsArray($cardDto->metadata);
        $this->assertFalse($cardDto->private_label);
    }

    public function test_voucher_dto_creation(): void
    {
        $cardDto = CardDto::voucher(
            number: '6030000000000000',
            holderName: 'Maria Santos',
            holderDocument: '12345678901',
            expMonth: 6,
            expYear: 2026,
            cvv: '456',
            brand: 'sodexo'
        );

        $this->assertEquals('6030000000000000', $cardDto->number);
        $this->assertEquals('Maria Santos', $cardDto->holder_name);
        $this->assertEquals('12345678901', $cardDto->holder_document);
        $this->assertEquals(6, $cardDto->exp_month);
        $this->assertEquals(2026, $cardDto->exp_year);
        $this->assertEquals('456', $cardDto->cvv);
        $this->assertEquals('sodexo', $cardDto->brand);
    }

    public function test_private_label_dto_creation(): void
    {
        $cardDto = CardDto::privateLabel(
            number: '1234567890123456',
            holderName: 'Carlos Oliveira',
            expMonth: 3,
            expYear: 2027,
            cvv: '789',
            brand: 'store_brand',
            holderDocument: '98765432100'
        );

        $this->assertEquals('1234567890123456', $cardDto->number);
        $this->assertEquals('Carlos Oliveira', $cardDto->holder_name);
        $this->assertEquals(3, $cardDto->exp_month);
        $this->assertEquals(2027, $cardDto->exp_year);
        $this->assertEquals('789', $cardDto->cvv);
        $this->assertEquals('store_brand', $cardDto->brand);
        $this->assertEquals('98765432100', $cardDto->holder_document);
        $this->assertTrue($cardDto->private_label);
    }

    public function test_from_token_dto_creation(): void
    {
        $cardDto = CardDto::fromToken(
            token: 'token_abcd1234',
            billingAddress: [
                'line_1' => 'Av. Paulista, 1000',
                'zip_code' => '01310-100',
                'city' => 'São Paulo',
                'state' => 'SP',
                'country' => 'BR',
            ]
        );

        $this->assertEquals('token_abcd1234', $cardDto->token);
        $this->assertIsArray($cardDto->billing_address);
        $this->assertEquals('', $cardDto->number);
        $this->assertEquals('', $cardDto->holder_name);
        $this->assertEquals('', $cardDto->cvv);
    }

    public function test_dto_to_array(): void
    {
        $cardDto = CardDto::creditCard(
            number: '4000000000000010',
            holderName: 'Test User',
            expMonth: 12,
            expYear: 2025,
            cvv: '123'
        );

        $array = $cardDto->toArray();

        $this->assertIsArray($array);
        $this->assertEquals('4000000000000010', $array['number']);
        $this->assertEquals('Test User', $array['holder_name']);
        $this->assertEquals(12, $array['exp_month']);
        $this->assertEquals(2025, $array['exp_year']);
        $this->assertEquals('123', $array['cvv']);
    }
}
