<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250204102603 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, galerie_id INT DEFAULT NULL, path VARCHAR(255) NOT NULL, legende VARCHAR(255) DEFAULT NULL, INDEX IDX_C53D045F825396CB (galerie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F825396CB FOREIGN KEY (galerie_id) REFERENCES galerie (id)');
        $this->addSql('ALTER TABLE page ADD galerie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB620825396CB FOREIGN KEY (galerie_id) REFERENCES galerie (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_140AB620825396CB ON page (galerie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F825396CB');
        $this->addSql('DROP TABLE image');
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB620825396CB');
        $this->addSql('DROP INDEX UNIQ_140AB620825396CB ON page');
        $this->addSql('ALTER TABLE page DROP galerie_id');
    }
}
