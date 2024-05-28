<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240528143032 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE preferences DROP FOREIGN KEY FK_E931A6F58259B9D7');
        $this->addSql('DROP INDEX IDX_E931A6F58259B9D7 ON preferences');
        $this->addSql('ALTER TABLE preferences DROP le_relais_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE preferences ADD le_relais_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE preferences ADD CONSTRAINT FK_E931A6F58259B9D7 FOREIGN KEY (le_relais_id) REFERENCES relais (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_E931A6F58259B9D7 ON preferences (le_relais_id)');
    }
}
