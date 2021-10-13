<?php

namespace App\Models;

class Action
{
    private string $id;
    private string $name;
    private string $status;

    public const STATUS_CREATED = 'created';
    public const STATUS_COMPLETED = 'completed';

    private const STATUSES = [
        self::STATUS_CREATED,
        self::STATUS_COMPLETED
    ];

    public function __construct(string $id, string $name, ?string $status = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->setStatus($status ?? Action::STATUS_CREATED);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        if (!in_array($status, self::STATUSES)) {

            return;
        }
        $this->status = $status;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getName(),
            'status' => $this->getStatus()
        ];
    }
}