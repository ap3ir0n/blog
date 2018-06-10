<?php
declare(strict_types=1);

/**
 * Date: 10/06/2018
 */

namespace App\Application\Query\User;


use App\Domain\User\Email;

final class FindByEmailQuery
{
    /** @var Email */
    private $email;

    /**
     * FindByEmailQuery constructor.
     * @param Email $email
     */
    public function __construct(Email $email)
    {
        $this->email = $email;
    }

    /**
     * @return Email
     */
    public function email(): Email
    {
        return $this->email;
    }

}