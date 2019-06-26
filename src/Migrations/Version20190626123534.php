<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190626123534 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $schema->createSequence('speaker_event_interview_sent_id_seq');
    }

    public function down(Schema $schema) : void
    {
        $schema->dropSequence('speaker_event_interview_sent_id_seq');
    }
}
