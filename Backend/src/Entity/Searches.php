<?php
declare(strict_types=1);
namespace App\Entity;

use App\Repository\SearchesRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

#[ORM\Entity(repositoryClass: SearchesRepository::class)]
class Searches
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: "string")]
    private ?string $ip = null;

    #[ORM\Column(type: "string")]
    private ?string $query=null;

    #[ORM\Column(type: "datetime")]
    private ?Datetime $timeStamp=null;
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getIp(): ?int
    {
        return $this->ip;
    }

    /**
     * @param string|null $ip
     */
    public function setIp(?string $ip): void
    {
        $this->ip = $ip;
    }

    /**
     * @return string|null
     */
    public function getQuery(): ?string
    {
        return $this->query;
    }

    /**
     * @param string|null $query
     */
    public function setQuery(?string $query): void
    {
        $this->query = $query;
    }

    /**
     * @return DateTime|null
     */
    public function getTimeStamp(): ?DateTime
    {
        return $this->timeStamp;
    }

    /**
     * @param DateTime|null $timeStamp
     */
    public function setTimeStamp(?DateTime $timeStamp): void
    {
        $this->timeStamp = $timeStamp;
    }

}
