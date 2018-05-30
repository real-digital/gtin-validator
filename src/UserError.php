<?php
declare(strict_types=1);

namespace Real\Validator;

interface UserError
{
    /**
     * Message key to be used by translation component
     */
    public function messageKey(): string;

    /**
     * Message data to be used by translation component
     */
    public function messageData(): array;
}
