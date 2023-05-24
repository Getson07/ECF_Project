<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230523224805 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reserved_table ADD reserved_for_date DATE  COMMENT \'(DC2Type:date_immutable)\', ADD reserved_date DATE  COMMENT \'(DC2Type:date_immutable)\', CHANGE reserved_for reserved_for DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reserved_table DROP reserved_for_date, DROP reserved_date, CHANGE reserved_for reserved_for DATETIME NOT NULL');
    }
}
