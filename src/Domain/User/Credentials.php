<?php
declare(strict_types=1);

namespace App\Domain\User;


class Credentials
{
    /** @var Email */
    private $email;

    /** @var HashedPassword */
    private $password;

    /**
     * Credentials constructor.
     * @param Email $email
     * @param HashedPassword $password
     */
    public function __construct(Email $email, HashedPassword $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * @return Email
     */
    public function email(): Email
    {
        return $this->email;
    }

    /**
     * @return HashedPassword
     */
    public function password(): HashedPassword
    {
        return $this->password;
    }

}