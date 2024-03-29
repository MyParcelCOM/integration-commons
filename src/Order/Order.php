<?php

declare(strict_types=1);

namespace MyParcelCom\Integration\Order;

use DateTimeInterface;
use MyParcelCom\Integration\Address;
use MyParcelCom\Integration\Order\Items\ItemCollection;
use MyParcelCom\Integration\ProvidesJsonAPI;
use MyParcelCom\Integration\ShopId;

class Order implements ProvidesJsonAPI
{
    public function __construct(
        private readonly ShopId $shopId,
        private readonly string $id,
        private readonly DateTimeInterface $createdAt,
        private readonly Address $recipientAddress,
        private readonly ItemCollection $items,
        private readonly ?string $outboundShipmentIdentifier = null,
    ) {
    }

    public function transformToJsonApiArray(): array
    {
        return [
            'type'          => 'orders',
            'id'            => $this->id,
            'attributes'    => array_filter([
                'created_at'                   => $this->createdAt->format(DateTimeInterface::ATOM),
                'recipient_address'            => $this->recipientAddress->toArray(),
                'items'                        => $this->items->toArray(),
                'outbound_shipment_identifier' => $this->outboundShipmentIdentifier,
            ]),
            'relationships' => [
                'shop' => [
                    'data' => [
                        'type' => 'shops',
                        'id'   => $this->shopId->toString(),
                    ],
                ],
            ],
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->transformToJsonApiArray();
    }
}
