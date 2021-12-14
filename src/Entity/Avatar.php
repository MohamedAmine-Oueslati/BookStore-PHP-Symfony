<?php

namespace App\Entity;

use App\Repository\AvatarRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * @ORM\Entity(repositoryClass=AvatarRepository::class)
 * @Vich\Uploadable
 */
class Avatar implements \Serializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var File
     * @Vich\UploadableField(mapping="user_avatar", fileNameProperty="avatarName")
     */
    private $avatarFile;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $avatarName;

    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAvatarFile(): ?File
    {
        return $this->avatarFile;
    }

    public function setAvatarFile(?File $fileName = null)
    {
        $this->avatarFile = $fileName;

        if ($fileName) {
            $this->createdAt = new \DateTime('now');
        }

        // return $this;
    }

    public function getAvatarName(): ?string
    {
        return $this->avatarName;
    }

    public function setAvatarName(?string $avatarName): self
    {
        $this->avatarName = $avatarName;

        return $this;
    }

    public function serialize()
    {
        return serialize(array(
            $this->id
        ));
    }

    public function unserialize($serialized)
    {
        list(
            $this->id
        ) = unserialize($serialized);
    }
}
