<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240430131901 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE info_programme (id INT AUTO_INCREMENT NOT NULL, programme_id INT NOT NULL, repetition INT DEFAULT NULL, temps INT DEFAULT NULL, type VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_90AC04C262BB7AEE (programme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE info_programme ADD CONSTRAINT FK_90AC04C262BB7AEE FOREIGN KEY (programme_id) REFERENCES programme (id)');
        $this->addSql('ALTER TABLE programme ADD type VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE info_programme DROP FOREIGN KEY FK_90AC04C262BB7AEE');
        $this->addSql('DROP TABLE info_programme');
        $this->addSql('ALTER TABLE programme DROP type');
    }
}
