<?php

namespace ZnUser\Identity\Domain\Entities;

use DateTime;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnCore\Collection\Interfaces\Enumerable;
use ZnCore\Contract\Common\Exceptions\NotImplementedMethodException;
use ZnCore\Contract\User\Interfaces\Entities\IdentityEntityInterface;
use ZnCore\Contract\User\Interfaces\Entities\PersonEntityInterface;
use ZnCore\Collection\Helpers\CollectionHelper;
use ZnDomain\Entity\Interfaces\EntityIdInterface;
use ZnDomain\Validator\Interfaces\ValidationByMetadataInterface;
use ZnLib\Components\Status\Enums\StatusEnum;

class IdentityEntity implements ValidationByMetadataInterface, EntityIdInterface, IdentityEntityInterface, UserInterface
{

    protected $id = null;
    protected $username = null;
    protected $statusId = StatusEnum::ENABLED;
    protected $createdAt = null;
    protected $updatedAt = null;
    protected $roles = [];
    protected $assignments = null;
    protected $person = null;

    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {

    }

    public function setId($value)
    {
        $this->id = $value;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setStatusId($value)
    {
        $this->statusId = $value;
    }

    public function getStatusId()
    {
        return $this->statusId;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    /*public function getUserIdentifier(): string
    {
        return $this->username;
    }*/

    public function getRoles()
    {
        return $this->roles;
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function getAssignments(): ?Enumerable
    {
        return $this->assignments;
    }

    public function setAssignments(?Enumerable $assignments): void
    {
        $this->assignments = $assignments;
        if ($assignments) {
            $this->roles = CollectionHelper::getColumn($assignments, 'itemName');
        }
    }

    public function getPerson(): ?PersonEntityInterface
    {
        return $this->person;
    }

    public function setPerson(?PersonEntityInterface $person): void
    {
        $this->person = $person;
    }

    public function getPassword()
    {
//        throw new NotImplementedMethodException('Not Implemented Method "' . static::class . '::' . __METHOD__ . '"!');
    }

    public function getSalt()
    {
//        throw new NotImplementedMethodException('Not Implemented Method "' . static::class . '::' . __METHOD__ . '"!');
    }

    public function eraseCredentials()
    {
//        throw new NotImplementedMethodException('Not Implemented Method "' . static::class . '::' . __METHOD__ . '"!');
    }
}
