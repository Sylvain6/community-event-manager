<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Migrations\AbstractTableNameMigration;
use Doctrine\DBAL\Schema\Schema;

final class Version20190626090237 extends AbstractTableNameMigration
{
    public function up(Schema $schema): void
    {
        $table = $schema->getTable(self::SPEAKER);
        $table->dropColumn('interview_sent');
    }

    public function down(Schema $schema): void
    {
        $table = $schema->getTable(self::SPEAKER);
        $table->addColumn('interview_sent', 'boolean', ['default' => false]);
    }
}
