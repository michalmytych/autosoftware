<?php

namespace App\Service;

use App\Sorter\Sorter;
use App\DTO\MessageDto;
use App\Entity\Message;
use App\Repository\MessageRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Uid\Factory\UuidFactory;
use App\Service\Interface\MessageServiceInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class MessageService implements MessageServiceInterface
{
    public function __construct(
        private readonly PaginatorInterface $paginator,
        private readonly UuidFactory        $uuidFactory,
        private readonly MessageRepository  $messageRepository,
        private readonly MessageFileService $messageFileService
    )
    {
    }

    public function getPaginatedList(Sorter $sorter, int $page = 1): PaginationInterface
    {
        $pagination = $this->paginator->paginate(
            $this->messageRepository->queryAll($sorter),
            $page,
            MessageRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        $items = [];
        foreach ($pagination->getItems() as $messageRecord) {
            $items[] = $this->getMessageDtoFromPaginationRecord($messageRecord);
        }

        $pagination->setItems($items);

        return $pagination;
    }

    public function find(string $uuid): ?MessageDto
    {
        $message = $this->messageRepository->find($uuid);

        if (!$message) {
            return null;
        }

        /** @var Message $message */
        $fileContents = $this->messageFileService->getTextFileContents(
            $message->getRelativeFilePath()
        );

        return new MessageDto(
            uuid: $message->getId(),
            content: json_decode($fileContents, true),
            createdAt: $message->getCreatedAt(),
        );
    }

    public function save(MessageDto $dto): MessageDto
    {
        $relativeFilePath = $this->uuidFactory->create() . '.json';
        $messageContent = json_encode($dto->content);

        if (!$messageContent) {
            throw new UnprocessableEntityHttpException(
                'Provided message content is invalid.'
            );
        }

        $message = (new Message())
            ->setRelativeFilePath($relativeFilePath);

        $this->messageRepository->inTransaction(function () use (
            &$message, $messageContent, $relativeFilePath
        ) {
            $message = $this->messageRepository->save($message);

            $this->messageFileService->storeTextFile(
                $messageContent,
                $relativeFilePath
            );
        });

        return new MessageDto(
            uuid: $message->getId(),
            content: $dto->content,
            createdAt: $message->getCreatedAt()
        );
    }

    private function getMessageDtoFromPaginationRecord(array $messageRecord): MessageDto
    {
        $fileContents = $this->messageFileService->getTextFileContents(
            $messageRecord['relativeFilePath']
        );

        /** @var array $messageRecord */
        return new MessageDto(
            uuid: $messageRecord['id'],
            content: json_decode($fileContents, true),
            createdAt: $messageRecord['createdAt']
        );
    }

}