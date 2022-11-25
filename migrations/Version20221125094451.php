<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221125094451 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE plante DROP FOREIGN KEY FK_517A6947177B16E8');
        $this->addSql('DROP INDEX IDX_517A6947177B16E8 ON plante');
        $this->addSql('ALTER TABLE plante DROP plante_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE plante ADD plante_id INT NOT NULL');
        $this->addSql('ALTER TABLE plante ADD CONSTRAINT FK_517A6947177B16E8 FOREIGN KEY (plante_id) REFERENCES plante (id)');
        $this->addSql('CREATE INDEX IDX_517A6947177B16E8 ON plante (plante_id)');
    }
}
