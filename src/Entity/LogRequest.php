<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LogRequestRepository")
 */
class LogRequest
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="integer")
     */
    private $response_code;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $response_time;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getResponseCode(): ?int
    {
        return $this->response_code;
    }

    public function setResponseCode(int $response_code): self
    {
        $this->response_code = $response_code;

        return $this;
    }

    public function getResponseTime(): ?float
    {
        return $this->response_time;
    }

    public function setResponseTime(?float $response_time): self
    {
        $this->response_time = $response_time;

        return $this;
    }
}
