<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250204101935 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE galerie (id INT AUTO_INCREMENT NOT NULL, page_id INT DEFAULT NULL, user_id INT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_9E7D1590C4663E4 (page_id), INDEX IDX_9E7D1590A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, titre VARCHAR(255) NOT NULL, contenu LONGTEXT DEFAULT NULL, meta LONGTEXT DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, INDEX IDX_140AB620A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE galerie ADD CONSTRAINT FK_9E7D1590C4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('ALTER TABLE galerie ADD CONSTRAINT FK_9E7D1590A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB620A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE galerie DROP FOREIGN KEY FK_9E7D1590C4663E4');
        $this->addSql('ALTER TABLE galerie DROP FOREIGN KEY FK_9E7D1590A76ED395');
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB620A76ED395');
        $this->addSql('DROP TABLE galerie');
        $this->addSql('DROP TABLE page');
    }
}
