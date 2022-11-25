<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221125091817 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(75) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE compte (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, nom VARCHAR(75) NOT NULL, mot_de_passe VARCHAR(75) NOT NULL, photo VARCHAR(255) DEFAULT NULL, niveau INT NOT NULL, INDEX IDX_CFF65260BCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plante (id INT AUTO_INCREMENT NOT NULL, plante_id INT NOT NULL, nom VARCHAR(75) NOT NULL, niveau INT NOT NULL, active TINYINT(1) NOT NULL, INDEX IDX_517A6947177B16E8 (plante_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plante_compte (id INT AUTO_INCREMENT NOT NULL, plante_id INT NOT NULL, compte_id INT NOT NULL, photo VARCHAR(255) NOT NULL, coordonnees VARCHAR(255) NOT NULL, date_photo DATE NOT NULL, date_valide DATE NOT NULL, INDEX IDX_5841302F177B16E8 (plante_id), INDEX IDX_5841302FF2C56620 (compte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE texte_after (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(75) NOT NULL, texte LONGTEXT NOT NULL, logo VARCHAR(255) NOT NULL, plante VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE texte_before (id INT AUTO_INCREMENT NOT NULL, plante_id INT NOT NULL, titre VARCHAR(75) NOT NULL, texte LONGTEXT NOT NULL, logo VARCHAR(255) NOT NULL, INDEX IDX_11A4DAA7177B16E8 (plante_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE compte ADD CONSTRAINT FK_CFF65260BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE plante ADD CONSTRAINT FK_517A6947177B16E8 FOREIGN KEY (plante_id) REFERENCES plante (id)');
        $this->addSql('ALTER TABLE plante_compte ADD CONSTRAINT FK_5841302F177B16E8 FOREIGN KEY (plante_id) REFERENCES plante (id)');
        $this->addSql('ALTER TABLE plante_compte ADD CONSTRAINT FK_5841302FF2C56620 FOREIGN KEY (compte_id) REFERENCES compte (id)');
        $this->addSql('ALTER TABLE texte_before ADD CONSTRAINT FK_11A4DAA7177B16E8 FOREIGN KEY (plante_id) REFERENCES plante (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE compte DROP FOREIGN KEY FK_CFF65260BCF5E72D');
        $this->addSql('ALTER TABLE plante DROP FOREIGN KEY FK_517A6947177B16E8');
        $this->addSql('ALTER TABLE plante_compte DROP FOREIGN KEY FK_5841302F177B16E8');
        $this->addSql('ALTER TABLE plante_compte DROP FOREIGN KEY FK_5841302FF2C56620');
        $this->addSql('ALTER TABLE texte_before DROP FOREIGN KEY FK_11A4DAA7177B16E8');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE compte');
        $this->addSql('DROP TABLE plante');
        $this->addSql('DROP TABLE plante_compte');
        $this->addSql('DROP TABLE texte_after');
        $this->addSql('DROP TABLE texte_before');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
