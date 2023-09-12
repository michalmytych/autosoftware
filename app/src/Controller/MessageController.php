<?php

namespace App\Controller;

use App\DTO\MessageDto;
use App\Sorter\SorterFactory;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\Interface\MessageServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/messages')]
class MessageController extends AbstractController
{
    public function __construct(
        private readonly SorterFactory $sorterFactory,
        private readonly MessageServiceInterface $messageService
    ) {}

    #[Route(
        '/',
        name: 'message_index',
        methods: 'GET'
    )]
    public function index(Request $request): JsonResponse
    {
        $sorter = $this->sorterFactory->makeFromRequest($request);
        $messages = $this->messageService->findAll($sorter);

        return new JsonResponse([
            'data' => $messages
        ]);
    }

    #[Route(
        '/{id}',
        name: 'message_show',
        requirements: ['id' => '[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}'],
        methods: 'GET'
    )]
    public function show(string $uuid): JsonResponse
    {
        $messageDto = $this->messageService->find($uuid);

        return new JsonResponse([
            'data' => $messageDto
        ], $messageDto ? 200 : 404);
    }

    #[Route(
        name: 'message_create',
        methods: 'POST'
    )]
    public function create(Request $request): JsonResponse
    {
        $messageDto = new MessageDto(
            uuid: Uuid::v4(),
            email: $request->get('email'),
            content: $request->get('content'),
            createdAt: new \DateTimeImmutable(),
        );

        $messageDto = $this->messageService->save($messageDto);

        return new JsonResponse([
            'data' => [
                'uuid' => $messageDto->uuid
            ]
        ], 201);
    }
}