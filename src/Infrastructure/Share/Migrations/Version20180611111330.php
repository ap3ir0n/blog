<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Broadway\EventStore\Dbal\DBALEventStore;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180611111330 extends AbstractMigration implements ContainerAwareInterface
{
    /** @var EntityManager */
    private $em;

    /** @var DBALEventStore */
    private $eventStore;

    public function up(Schema $schema) : void
    {
        $this->eventStore->configureSchema($schema);

        $this->em->flush();
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('events');

        $this->em->flush();
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->eventStore = $container->get('broadway.event_store');
        $this->em = $container->get('doctrine.orm.entity_manager');
    }
}
