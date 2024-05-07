<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240507102148 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE casier CHANGE le_relais_id le_relais_id INT NOT NULL, CHANGE utilise utilise TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE casier RENAME INDEX idx_3fdf285b73b9c0e TO IDX_3FDF285750CA3FD');
        $this->addSql('ALTER TABLE commande ADD nom_destinataire VARCHAR(255) DEFAULT NULL, ADD prenom_destinataire VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE casier CHANGE le_relais_id le_relais_id INT DEFAULT NULL, CHANGE utilise utilise TINYINT(1) DEFAULT 0');
        $this->addSql('ALTER TABLE casier RENAME INDEX idx_3fdf285750ca3fd TO IDX_3FDF285B73B9C0E');
        $this->addSql('ALTER TABLE commande DROP nom_destinataire, DROP prenom_destinataire');
    }
}
