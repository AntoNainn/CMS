<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250430084940 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire CHANGE statut statut TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE galerie DROP FOREIGN KEY FK_9E7D1590C4663E4');
        $this->addSql('DROP INDEX UNIQ_9E7D1590C4663E4 ON galerie');
        $this->addSql('ALTER TABLE galerie DROP page_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire CHANGE statut statut VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE galerie ADD page_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE galerie ADD CONSTRAINT FK_9E7D1590C4663E4 FOREIGN KEY (page_id) REFERENCES page (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9E7D1590C4663E4 ON galerie (page_id)');
    }
}
