<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240529130105 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande ADD le_relais_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D8259B9D7 FOREIGN KEY (le_relais_id) REFERENCES relais (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D8259B9D7 ON commande (le_relais_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D8259B9D7');
        $this->addSql('DROP INDEX IDX_6EEAA67D8259B9D7 ON commande');
        $this->addSql('ALTER TABLE commande DROP le_relais_id');
    }
}
