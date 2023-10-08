<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Odm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post as Store;
use App\Repository\PostRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert; // Validacion campos vacios.


#[ORM\Entity(repositoryClass: PostRepository::class)]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => ['post:read', 'post:read:item']]), // Serialización que permite consultar y consultar por item.
        new GetCollection(normalizationContext: ['groups' => ['post:read', 'post:read:collection']]), // Serialización que permite consultar y consultar por colección.
        new Patch(),
        new Store()
    ],
    denormalizationContext: ['groups' => ['post:write']], // POST, PUT, PATCH. Serialización que nos permite modificar.
    paginationItemsPerPage: 8, // Paginacion: numero de elementos impresos por pagina.
)]
#[ApiFilter(SearchFilter::class, properties: [
    'title' => 'partial',
    'body' => 'partial',
    'category.name' => 'partial'
])] //Filtrar por.
#[ApiFilter(OrderFilter::class, properties: ['id'])] //Ordenar por.

class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['post:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['post:read', 'post:write'])]
    #[Assert\NotBlank]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['post:read:item', 'post:write'])]
    #[Assert\NotBlank]
    private ?string $body = null;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['post:read', 'post:write'])]
    #[Assert\NotBlank]
    private ?Category $category = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    /*
     * Campo virtual
     */

    #[Groups(['post:read:collection'])]
    public function getSummary($leng = 70): ?string
    {
        if (mb_strlen($this->body) <= $leng) {
            return $this->body;
        }

        return mb_substr($this->body, 0, 70) . '[...]';
    }

    public function setBody(string $body): static
    {
        $this->body = $body;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }
}
