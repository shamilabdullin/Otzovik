<?php


namespace App\Repository;


use App\Entity\User;

interface UserRepositoryInterface
{
    /**
     * @return User[]
     */
    public function getAllUser(): array;

    /**
     * @param int $userId
     * @return User
     */
    public function getOneUser(int $userId): object;

    /**
     * @param User $user
     */
    public function setDeleteUser(User $user);

}