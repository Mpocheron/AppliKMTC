<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240527090928 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adresse ADD designation VARCHAR(255) NOT NULL, DROP longitude, DROP latitude, CHANGE numero numero VARCHAR(10) NOT NULL, CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE code_postal code_postal VARCHAR(10) NOT NULL, CHANGE ville ville VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adresse ADD longitude VARCHAR(45) DEFAULT NULL, ADD latitude VARCHAR(45) DEFAULT NULL, DROP designation, CHANGE numero numero INT NOT NULL, CHANGE nom nom VARCHAR(45) NOT NULL, CHANGE code_postal code_postal VARCHAR(5) NOT NULL, CHANGE ville ville VARCHAR(45) NOT NULL');
    }
}
