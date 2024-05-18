<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240509130200 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE detail_exercice (id INT AUTO_INCREMENT NOT NULL, repetitions INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE detail_exercice_exercices (detail_exercice_id INT NOT NULL, exercices_id INT NOT NULL, INDEX IDX_94152934E6DF6FC9 (detail_exercice_id), INDEX IDX_94152934192C7251 (exercices_id), PRIMARY KEY(detail_exercice_id, exercices_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE detail_exercice_exercices ADD CONSTRAINT FK_94152934E6DF6FC9 FOREIGN KEY (detail_exercice_id) REFERENCES detail_exercice (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE detail_exercice_exercices ADD CONSTRAINT FK_94152934192C7251 FOREIGN KEY (exercices_id) REFERENCES exercices (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detail_exercice_exercices DROP FOREIGN KEY FK_94152934E6DF6FC9');
        $this->addSql('ALTER TABLE detail_exercice_exercices DROP FOREIGN KEY FK_94152934192C7251');
        $this->addSql('DROP TABLE detail_exercice');
        $this->addSql('DROP TABLE detail_exercice_exercices');
    }
}
