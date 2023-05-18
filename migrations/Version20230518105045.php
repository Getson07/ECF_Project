<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230518105045 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE administrator (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', salary VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_formula (formula_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_A0E918FFA50A6386 (formula_id), INDEX IDX_A0E918FF12469DE2 (category_id), PRIMARY KEY(formula_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', guests INT NOT NULL, allergies LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dish (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', category_id INT NOT NULL, creator_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', title VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, price NUMERIC(3, 1) NOT NULL, rating INT DEFAULT NULL, INDEX IDX_957D8CB812469DE2 (category_id), INDEX IDX_957D8CB861220EA6 (creator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dish_category (id INT AUTO_INCREMENT NOT NULL, creator_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, INDEX IDX_1FB098AA61220EA6 (creator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formula (id INT AUTO_INCREMENT NOT NULL, creator_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, price NUMERIC(5, 2) NOT NULL, INDEX IDX_6731588161220EA6 (creator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', creator_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', title VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_7D053A9361220EA6 (creator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reserved_table (id INT AUTO_INCREMENT NOT NULL, client_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', guest_info_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', number_of_tables INT NOT NULL, reserved_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', reserved_for DATETIME NOT NULL, has_arrived TINYINT(1) NOT NULL, INDEX IDX_E015E5B619EB6921 (client_id), INDEX IDX_E015E5B61D4E05B4 (guest_info_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE schedule (id INT AUTO_INCREMENT NOT NULL, admin_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', day VARCHAR(255) NOT NULL, opening_time TIME NOT NULL, closing_time TIME NOT NULL, break_start_time TIME NOT NULL, break_end_time TIME NOT NULL, INDEX IDX_5A3811FB642B8210 (admin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, gender VARCHAR(255) DEFAULT NULL, firstname VARCHAR(255) NOT NULL, date_of_birth DATE DEFAULT NULL, type VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE administrator ADD CONSTRAINT FK_58DF0651BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_formula ADD CONSTRAINT FK_A0E918FFA50A6386 FOREIGN KEY (formula_id) REFERENCES formula (id)');
        $this->addSql('ALTER TABLE category_formula ADD CONSTRAINT FK_A0E918FF12469DE2 FOREIGN KEY (category_id) REFERENCES dish_category (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dish ADD CONSTRAINT FK_957D8CB812469DE2 FOREIGN KEY (category_id) REFERENCES dish_category (id)');
        $this->addSql('ALTER TABLE dish ADD CONSTRAINT FK_957D8CB861220EA6 FOREIGN KEY (creator_id) REFERENCES administrator (id)');
        $this->addSql('ALTER TABLE dish_category ADD CONSTRAINT FK_1FB098AA61220EA6 FOREIGN KEY (creator_id) REFERENCES administrator (id)');
        $this->addSql('ALTER TABLE formula ADD CONSTRAINT FK_6731588161220EA6 FOREIGN KEY (creator_id) REFERENCES administrator (id)');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A9361220EA6 FOREIGN KEY (creator_id) REFERENCES administrator (id)');
        $this->addSql('ALTER TABLE reserved_table ADD CONSTRAINT FK_E015E5B619EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE reserved_table ADD CONSTRAINT FK_E015E5B61D4E05B4 FOREIGN KEY (guest_info_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FB642B8210 FOREIGN KEY (admin_id) REFERENCES administrator (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE administrator DROP FOREIGN KEY FK_58DF0651BF396750');
        $this->addSql('ALTER TABLE category_formula DROP FOREIGN KEY FK_A0E918FFA50A6386');
        $this->addSql('ALTER TABLE category_formula DROP FOREIGN KEY FK_A0E918FF12469DE2');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455BF396750');
        $this->addSql('ALTER TABLE dish DROP FOREIGN KEY FK_957D8CB812469DE2');
        $this->addSql('ALTER TABLE dish DROP FOREIGN KEY FK_957D8CB861220EA6');
        $this->addSql('ALTER TABLE dish_category DROP FOREIGN KEY FK_1FB098AA61220EA6');
        $this->addSql('ALTER TABLE formula DROP FOREIGN KEY FK_6731588161220EA6');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A9361220EA6');
        $this->addSql('ALTER TABLE reserved_table DROP FOREIGN KEY FK_E015E5B619EB6921');
        $this->addSql('ALTER TABLE reserved_table DROP FOREIGN KEY FK_E015E5B61D4E05B4');
        $this->addSql('ALTER TABLE schedule DROP FOREIGN KEY FK_5A3811FB642B8210');
        $this->addSql('DROP TABLE administrator');
        $this->addSql('DROP TABLE category_formula');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE dish');
        $this->addSql('DROP TABLE dish_category');
        $this->addSql('DROP TABLE formula');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE reserved_table');
        $this->addSql('DROP TABLE schedule');
        $this->addSql('DROP TABLE user');
    }
}
