<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230518103420 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category_formula (formula_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_A0E918FFA50A6386 (formula_id), INDEX IDX_A0E918FF12469DE2 (category_id), PRIMARY KEY(formula_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category_formula ADD CONSTRAINT FK_A0E918FFA50A6386 FOREIGN KEY (formula_id) REFERENCES formula (id)');
        $this->addSql('ALTER TABLE category_formula ADD CONSTRAINT FK_A0E918FF12469DE2 FOREIGN KEY (category_id) REFERENCES dish_category (id)');
        $this->addSql('ALTER TABLE formula_dish_category DROP FOREIGN KEY FK_B76CBDCC057AE07');
        $this->addSql('ALTER TABLE formula_dish_category DROP FOREIGN KEY FK_B76CBDCA50A6386');
        $this->addSql('DROP TABLE formula_dish_category');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE formula_dish_category (formula_id INT NOT NULL, dish_category_id INT NOT NULL, INDEX IDX_B76CBDCA50A6386 (formula_id), INDEX IDX_B76CBDCC057AE07 (dish_category_id), PRIMARY KEY(formula_id, dish_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE formula_dish_category ADD CONSTRAINT FK_B76CBDCC057AE07 FOREIGN KEY (dish_category_id) REFERENCES dish_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formula_dish_category ADD CONSTRAINT FK_B76CBDCA50A6386 FOREIGN KEY (formula_id) REFERENCES formula (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_formula DROP FOREIGN KEY FK_A0E918FFA50A6386');
        $this->addSql('ALTER TABLE category_formula DROP FOREIGN KEY FK_A0E918FF12469DE2');
        $this->addSql('DROP TABLE category_formula');
    }
}
