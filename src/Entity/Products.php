<?php

namespace App\Entity;

use App\Repository\ProductsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * @ORM\Entity(repositoryClass=ProductsRepository::class)
 */
class Products
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="le nom du produit est  obligoire!")
     * @Assert\Length(min=3,max=255,minMessage="le nom du produit avoir au moin 3 caractere")
     */
    private $Nom;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="le nom du produit est  obligoire!")
     */
    private $Prix;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="products")
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Url(message="la photo principale doit etre une URl valide")
     * @Assert\NotBlank(message="l'url est obligatoire!")
     */
    private $mainpicture;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message =" la description courte et obligatoire")
     * @Assert\Length(min=20, minMessage="la desription" )
     */
    private $shortDescription;


    // public static function loadValidatorMetadata(ClassMetadata $classMetadata)
    // {
    //     $classMetadata->addPropertyConstraints('nom',[
    //         new Assert\NotBlank(['message'=>'le nom du produit est obligatoire']),
    //         new Assert\Length(['min'=>3,'max'=>255,'minMessage'=>'le nom du produit doit contenir au moin 3 caracteres'])
    //     ]);

    //     $classMetadata->addPropertyConstraint('prix', new Assert\NotBlank(['message'=>'le prix du produit est obligatoire']));

    // }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(?string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->Prix;
    }

    public function setPrix(?int $Prix): self
    {
        $this->Prix = $Prix;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getMainpicture(): ?string
    {
        return $this->mainpicture;
    }

    public function setMainpicture(?string $mainpicture): self
    {
        $this->mainpicture = $mainpicture;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(?string $shortDescription): self
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }
}
