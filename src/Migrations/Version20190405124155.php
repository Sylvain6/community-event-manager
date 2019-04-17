<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Migrations\AbstractTableNameMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;

final class Version20190405124155 extends AbstractTableNameMigration
{
    public function up(Schema $schema) : void
    {
        $table = $schema->createTable(self::SPEAKER_EVENT_INTERVIEW_SENT);
        $table->addColumn('id', Type::INTEGER);
        $table->addColumn('speaker_id', Type::GUID);
        $table->addColumn('event_id', Type::GUID);
        $table->addColumn('interview_sent', Type::BOOLEAN);
        $table->addUniqueIndex(['id']);
        $table->setPrimaryKey(['speaker_id', 'event_id']);
        $table->addForeignKeyConstraint(self::SPEAKER, ['speaker_id'], ['id'], ['onDelete' => 'CASCADE']);
        $table->addForeignKeyConstraint(self::EVENT, ['event_id'], ['id'], ['onDelete' => 'CASCADE']);
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable(self::SPEAKER_EVENT_INTERVIEW_SENT);

    }
}
