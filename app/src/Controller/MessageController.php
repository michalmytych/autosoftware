<?php

namespace App\Controller;

use App\DTO\MessageDto;
use App\Sorter\SorterFactory;
use App\Requests\MessageCreateRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Interface\MessageServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/messages')]
class MessageController extends AbstractController
{
    public function __construct(
        private readonly SorterFactory           $sorterFactory,
        private readonly MessageServiceInterface $messageService
    )
    {
    }

    #[Route(
        '/',
        name: 'message_index',
        methods: 'GET'
    )]
    public function index(Request $request): JsonResponse
    {
        $sorter = $this->sorterFactory->makeFromRequest($request);
        $pagination = $this->messageService->getPaginatedList(
            $sorter,
            $request->get('page', 1)
        );

        return new JsonResponse([
            'data' => $pagination->getItems(),
            'meta' => [
                'page' => $pagination->getCurrentPageNumber(),
                'per_page' => $pagination->getItemNumberPerPage(),
                'total' => $pagination->getTotalItemCount(),
            ]
        ]);
    }

    #[Route(
        '/{uuid}',
        name: 'message_show',
        requirements: ['id' => Requirement::UUID_V6],
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
    public function create(MessageCreateRequest $request): JsonResponse
    {
        $request->validate();

        $messageDto = new MessageDto(
            uuid: null,
            content: $request->content,
            createdAt: null,
        );

        $messageDto = $this->messageService->save($messageDto);

        return new JsonResponse([
            'data' => [
                'id' => $messageDto->uuid
            ]
        ], 201);
    }
}