<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221205113725 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE texte_after DROP titre, DROP texte, DROP logo');
        $this->addSql('ALTER TABLE texte_before DROP titre, DROP texte, DROP logo');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE texte_after ADD titre VARCHAR(75) NOT NULL, ADD texte LONGTEXT NOT NULL, ADD logo VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE texte_before ADD titre VARCHAR(75) NOT NULL, ADD texte LONGTEXT NOT NULL, ADD logo VARCHAR(255) NOT NULL');
    }
}
