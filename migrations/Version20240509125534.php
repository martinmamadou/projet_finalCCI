<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240509125534 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE programme_exercices (programme_id INT NOT NULL, exercices_id INT NOT NULL, INDEX IDX_C39D4DEF62BB7AEE (programme_id), INDEX IDX_C39D4DEF192C7251 (exercices_id), PRIMARY KEY(programme_id, exercices_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE programme_exercices ADD CONSTRAINT FK_C39D4DEF62BB7AEE FOREIGN KEY (programme_id) REFERENCES programme (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE programme_exercices ADD CONSTRAINT FK_C39D4DEF192C7251 FOREIGN KEY (exercices_id) REFERENCES exercices (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE exercices DROP enable');
        $this->addSql('ALTER TABLE programme DROP enable');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE programme_exercices DROP FOREIGN KEY FK_C39D4DEF62BB7AEE');
        $this->addSql('ALTER TABLE programme_exercices DROP FOREIGN KEY FK_C39D4DEF192C7251');
        $this->addSql('DROP TABLE programme_exercices');
        $this->addSql('ALTER TABLE programme ADD enable TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE exercices ADD enable TINYINT(1) NOT NULL');
    }
}
