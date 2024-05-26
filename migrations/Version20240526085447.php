<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240526085447 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande ADD relais_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D5B41AD20 FOREIGN KEY (relais_id) REFERENCES relais (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D5B41AD20 ON commande (relais_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D5B41AD20');
        $this->addSql('DROP INDEX IDX_6EEAA67D5B41AD20 ON commande');
        $this->addSql('ALTER TABLE commande DROP relais_id');
    }
}
