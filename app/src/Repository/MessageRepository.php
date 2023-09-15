<?php /** @noinspection PhpMultipleClassDeclarationsInspection */

namespace App\Repository;

use App\Sorter\Sorter;
use App\Entity\Message;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class MessageRepository extends ServiceEntityRepository
{
    const PAGINATOR_ITEMS_PER_PAGE = 20;

    const AVAILABLE_SORTER_LEXERS = [
        'id',
        'createdAt'
    ];

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    public function inTransaction(\Closure $callable): void
    {
        $this->_em->wrapInTransaction(fn(EntityManager $em) => $callable($em));
    }

    public function save(Message $message): Message
    {
        $this->_em->persist($message);
        $this->_em->flush();

        return $message;
    }

    public function queryAll(Sorter $sorter): QueryBuilder
    {
        return $this
            ->getOrCreateQueryBuilder()
            ->select('message.id', 'message.createdAt', 'message.relativeFilePath')
            ->orderBy(
                'message.'.$this->prepareSortingLexer($sorter->key),
                $sorter->order
            );
    }

    /** @noinspection PhpSameParameterValueInspection */
    private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
    {
        return $queryBuilder ?? $this->createQueryBuilder('message');
    }

    /** @noinspection PhpSameParameterValueInspection */
    private function prepareSortingLexer(?string $columnProvided = null): string
    {
        return in_array($columnProvided, self::AVAILABLE_SORTER_LEXERS)
            ? $columnProvided
            : 'createdAt';
    }
}
