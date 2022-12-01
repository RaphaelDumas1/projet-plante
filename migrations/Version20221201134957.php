<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221201134957 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE plante_compte ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE plante_compte ADD CONSTRAINT FK_5841302FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_5841302FA76ED395 ON plante_compte (user_id)');
        $this->addSql('ALTER TABLE user ADD niveau INT NOT NULL, ADD pseudo VARCHAR(100) NOT NULL, ADD photo VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE plante_compte DROP FOREIGN KEY FK_5841302FA76ED395');
        $this->addSql('DROP INDEX IDX_5841302FA76ED395 ON plante_compte');
        $this->addSql('ALTER TABLE plante_compte DROP user_id');
        $this->addSql('ALTER TABLE user DROP niveau, DROP pseudo, DROP photo');
    }
}
