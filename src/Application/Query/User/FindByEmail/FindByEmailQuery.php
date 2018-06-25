<?php
declare(strict_types=1);

/**
 * Date: 10/06/2018
 */

namespace App\Application\Query\User\FindByEmail;


use App\Domain\User\ValueObject\Email;

final class FindByEmailQuery
{
    /** @var Email */
    private $email;

    /**
     * FindByEmailQuery constructor.
     * @param string $email
     */
    public function __construct(string $email)
    {
        $this->email = Email::fromString($email);
    }

    /**
     * @return Email
     */
    public function email(): Email
    {
        return $this->email;
    }

}