<?php

namespace App\Entity\Type;

use App\Entity\OrderItem;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class OrderItemType extends Type
{
    const NAME = 'order_item';

    /**
     * @inheritdoc
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getClobTypeDeclarationSQL($fieldDeclaration);
    }

    /**
     * @inheritdoc
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (!is_array($value)) {
            return json_encode([]);
        }
        $serialized = [];
        /** @var OrderItem $item */
        foreach ($value as $item) {
            $serialized[] = [
                'product' => $item->getProduct(),
                'quantity' => $item->getQuantity()
            ];
        }
        return json_encode($serialized);
    }

    /**
     * @inheritdoc
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null || $value === '') {
            return [];
        }
        $value = (is_resource($value)) ? stream_get_contents($value) : $value;
        $decoded = json_decode($value, true);
        if (!$decoded) {
            return [];
        }
        $labels = [];
        foreach ($decoded as $item) {
            $labels[] = new OrderItem($item['product'], $item['quantity']);
        }
        return $labels;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return self::NAME;
    }

    /**
     * @inheritdoc
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}
