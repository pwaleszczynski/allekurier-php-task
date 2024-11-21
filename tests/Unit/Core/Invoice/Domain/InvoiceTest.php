<?php

declare(strict_types=1);

namespace App\Tests\Unit\Core\Invoice\Domain;

use App\Core\Invoice\Domain\Exception\CanNotCreateForInactiveUserException;
use App\Core\Invoice\Domain\Invoice;
use App\Core\User\Domain\User;
use PHPUnit\Framework\TestCase;

final class InvoiceTest extends TestCase
{
    public function test_can_not_create_invoice_for_inactive_user(): void
    {
        $user = $this->createMock(User::class);
        $user->method('isActive')->willReturn(false);

        $this->expectException(CanNotCreateForInactiveUserException::class);

        new Invoice($user, 1000);
    }

    public function test_should_create_invoice_correctly(): void
    {
        $user = $this->createMock(User::class);
        $user->method('isActive')->willReturn(true);

        $invoice = new Invoice($user, 1000);

        self::assertSame(1000, $invoice->getAmount());
        self::assertSame($user, $invoice->getUser());
    }
}
