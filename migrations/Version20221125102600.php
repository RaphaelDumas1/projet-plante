<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221125102600 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE texte_after ADD plante_id INT NOT NULL');
        $this->addSql('ALTER TABLE texte_after ADD CONSTRAINT FK_1AE3C132177B16E8 FOREIGN KEY (plante_id) REFERENCES plante (id)');
        $this->addSql('CREATE INDEX IDX_1AE3C132177B16E8 ON texte_after (plante_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE texte_after DROP FOREIGN KEY FK_1AE3C132177B16E8');
        $this->addSql('DROP INDEX IDX_1AE3C132177B16E8 ON texte_after');
        $this->addSql('ALTER TABLE texte_after DROP plante_id');
    }
}
