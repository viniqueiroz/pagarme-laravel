<?php

declare(strict_types=1);

namespace Anisotton\Pagarme\DataTransferObjects;

class CardDto extends BaseDto
{
    public function __construct(
        public string $number,
        public string $holder_name,
        public int $exp_month,
        public int $exp_year,
        public string $cvv,
        public ?string $holder_document = null,
        public ?string $brand = null,
        public ?string $label = null,
        public ?array $billing_address = null,
        public ?string $billing_address_id = null,
        public ?array $metadata = null,
        public ?string $token = null,
        public ?bool $private_label = false
    ) {}

    public static function creditCard(
        string $number,
        string $holderName,
        int $expMonth,
        int $expYear,
        string $cvv,
        ?string $holderDocument = null,
        ?array $billingAddress = null,
        ?array $metadata = null
    ): self {
        return new self(
            number: $number,
            holder_name: $holderName,
            exp_month: $expMonth,
            exp_year: $expYear,
            cvv: $cvv,
            holder_document: $holderDocument,
            billing_address: $billingAddress,
            metadata: $metadata
        );
    }

    public static function voucher(
        string $number,
        string $holderName,
        string $holderDocument,
        int $expMonth,
        int $expYear,
        string $cvv,
        string $brand,
        ?array $billingAddress = null,
        ?array $metadata = null
    ): self {
        return new self(
            number: $number,
            holder_name: $holderName,
            holder_document: $holderDocument,
            exp_month: $expMonth,
            exp_year: $expYear,
            cvv: $cvv,
            brand: $brand,
            billing_address: $billingAddress,
            metadata: $metadata
        );
    }

    public static function privateLabel(
        string $number,
        string $holderName,
        int $expMonth,
        int $expYear,
        string $cvv,
        string $brand,
        ?string $holderDocument = null,
        ?array $billingAddress = null,
        ?array $metadata = null
    ): self {
        return new self(
            number: $number,
            holder_name: $holderName,
            exp_month: $expMonth,
            exp_year: $expYear,
            cvv: $cvv,
            holder_document: $holderDocument,
            brand: $brand,
            billing_address: $billingAddress,
            metadata: $metadata,
            private_label: true
        );
    }

    public static function fromToken(
        string $token,
        ?array $billingAddress = null,
        ?array $metadata = null
    ): self {
        return new self(
            number: '',
            holder_name: '',
            exp_month: 1,
            exp_year: (int) date('Y'),
            cvv: '',
            token: $token,
            billing_address: $billingAddress,
            metadata: $metadata
        );
    }
}
