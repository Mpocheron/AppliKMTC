<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240528161937 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Initial database schema with default status insertion';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adresse (id INT AUTO_INCREMENT NOT NULL, numero INT NOT NULL, nom VARCHAR(45) NOT NULL, code_postal VARCHAR(5) NOT NULL, ville VARCHAR(45) NOT NULL, longitude VARCHAR(45) DEFAULT NULL, latitude VARCHAR(45) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE adresse_user (id INT AUTO_INCREMENT NOT NULL, leuser_id INT NOT NULL, le_adresse_id INT NOT NULL, INDEX IDX_7D95019FFE57C42A (leuser_id), INDEX IDX_7D95019F6EE7A3F7 (le_adresse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE casier (id INT AUTO_INCREMENT NOT NULL, le_model_id INT DEFAULT NULL, le_relais_id INT NOT NULL, utilise TINYINT(1) NOT NULL, INDEX IDX_3FDF285B73B9C0E (le_model_id), INDEX IDX_3FDF2858259B9D7 (le_relais_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, status_id INT DEFAULT NULL, le_user_id INT DEFAULT NULL, adresse_expedition_id INT DEFAULT NULL, adresse_destination_id INT DEFAULT NULL, adresse_facturation_id INT DEFAULT NULL, le_casier_id INT DEFAULT NULL, relais_id INT DEFAULT NULL, hauteur INT NOT NULL, largeur INT NOT NULL, longueur INT NOT NULL, poids INT NOT NULL, nombre_colis INT NOT NULL, nom_destinataire VARCHAR(255) DEFAULT NULL, prenom_destinataire VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_6EEAA67D6BF700BD (status_id), INDEX IDX_6EEAA67D88A1A5E2 (le_user_id), INDEX IDX_6EEAA67D4AE9938B (adresse_expedition_id), INDEX IDX_6EEAA67D11481E0 (adresse_destination_id), INDEX IDX_6EEAA67D5BBD1224 (adresse_facturation_id), UNIQUE INDEX UNIQ_6EEAA67DBD210531 (le_casier_id), INDEX IDX_6EEAA67D5B41AD20 (relais_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etat (id INT AUTO_INCREMENT NOT NULL, type_etat VARCHAR(45) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE modele (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(45) NOT NULL, hauteur INT NOT NULL, largeur INT NOT NULL, longueur INT NOT NULL, poids_max INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE preferences (id INT AUTO_INCREMENT NOT NULL, le_user_id INT DEFAULT NULL, sms TINYINT(1) NOT NULL, mail TINYINT(1) NOT NULL, push TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_E931A6F588A1A5E2 (le_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE relais (id INT AUTO_INCREMENT NOT NULL, le_adresse_id INT DEFAULT NULL, nom VARCHAR(45) NOT NULL, UNIQUE INDEX UNIQ_E32CEC906EE7A3F7 (le_adresse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, le_etat_id INT DEFAULT NULL, date DATETIME DEFAULT NULL, INDEX IDX_7B00651C2291F088 (le_etat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, adresse_user_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(45) NOT NULL, prenom VARCHAR(45) NOT NULL, telephone VARCHAR(10) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D6499706C0A (adresse_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        
        // Insert default etat values
        $this->addSql('INSERT INTO etat (id, type_etat) VALUES (1, "en attente"), (2, "En cours de préparation"), (3, "expediee"), (4, "livree")');
        
        // Insert default status
        $this->addSql('INSERT INTO status (le_etat_id, date) VALUES (1, NOW())');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adresse_user DROP FOREIGN KEY FK_7D95019FFE57C42A');
        $this->addSql('ALTER TABLE adresse_user DROP FOREIGN KEY FK_7D95019F6EE7A3F7');
        $this->addSql('ALTER TABLE casier DROP FOREIGN KEY FK_3FDF285B73B9C0E');
        $this->addSql('ALTER TABLE casier DROP FOREIGN KEY FK_3FDF2858259B9D7');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D6BF700BD');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D88A1A5E2');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D4AE9938B');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D11481E0');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D5BBD1224');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DBD210531');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D5B41AD20');
        $this->addSql('ALTER TABLE preferences DROP FOREIGN KEY FK_E931A6F588A1A5E2');
        $this->addSql('ALTER TABLE relais DROP FOREIGN KEY FK_E32CEC906EE7A3F7');
        $this->addSql('ALTER TABLE status DROP FOREIGN KEY FK_7B00651C2291F088');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6499706C0A');
        $this->addSql('DROP TABLE adresse');
        $this->addSql('DROP TABLE adresse_user');
        $this->addSql('DROP TABLE casier');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE etat');
        $this->addSql('DROP TABLE modele');
        $this->addSql('DROP TABLE preferences');
        $this->addSql('DROP TABLE relais');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
